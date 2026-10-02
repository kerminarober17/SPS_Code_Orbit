<?php
/**
 * Challenge upload helpers — server-side validation only.
 * Never trust client extension/MIME alone.
 */

function challenge_upload_root() {
    $root = realpath(__DIR__ . '/../uploads/challenges');
    if ($root === false) {
        $path = __DIR__ . '/../uploads/challenges';
        if (!is_dir($path)) {
            @mkdir($path, 0750, true);
        }
        $root = realpath($path);
    }
    return $root ?: (__DIR__ . '/../uploads/challenges');
}

function challenge_allowed_image_mimes() {
    return ['image/jpeg', 'image/png', 'image/webp'];
}

function challenge_allowed_zip_mimes() {
    return [
        'application/zip',
        'application/x-zip-compressed',
        'multipart/x-zip',
        'application/octet-stream', // validated further by magic bytes
    ];
}

function challenge_detect_type_from_bytes($tmpPath, $clientMime, $clientName) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $detected = $finfo->file($tmpPath) ?: '';
    $ext = strtolower(pathinfo($clientName, PATHINFO_EXTENSION));

    // Magic-byte check for ZIP (PK\x03\x04 or empty archive variants)
    $fh = @fopen($tmpPath, 'rb');
    $magic = $fh ? fread($fh, 4) : '';
    if ($fh) fclose($fh);
    $isZipMagic = ($magic === "PK\x03\x04" || $magic === "PK\x05\x06" || $magic === "PK\x07\x08");

    if ($isZipMagic || $ext === 'zip') {
        if ($isZipMagic || in_array($detected, challenge_allowed_zip_mimes(), true)) {
            return ['ok' => true, 'type' => 'zip', 'mime' => $detected ?: 'application/zip', 'ext' => 'zip'];
        }
    }

    if (in_array($detected, challenge_allowed_image_mimes(), true)) {
        $map = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        return ['ok' => true, 'type' => 'image', 'mime' => $detected, 'ext' => $map[$detected] ?? 'img'];
    }

    // Block dangerous types explicitly
    $dangerous = ['php', 'phtml', 'php5', 'php7', 'phar', 'htaccess', 'exe', 'sh', 'bat', 'cmd', 'js', 'html', 'htm', 'svg'];
    if (in_array($ext, $dangerous, true)) {
        return ['ok' => false, 'error' => 'This file type is not allowed.'];
    }

    return ['ok' => false, 'error' => 'Only ZIP archives and images (JPG, PNG, WEBP) are allowed.'];
}

function challenge_store_upload(array $file, $maxZipMb = 10, $maxImageMb = 5) {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $map = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds server upload limit.',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds form size limit.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        ];
        $code = $file['error'] ?? UPLOAD_ERR_NO_FILE;
        return ['ok' => false, 'error' => $map[$code] ?? 'Upload failed.'];
    }

    $tmp = $file['tmp_name'] ?? '';
    $size = (int)($file['size'] ?? 0);
    $orig = basename($file['name'] ?? 'upload');

    if (!is_uploaded_file($tmp)) {
        return ['ok' => false, 'error' => 'Invalid upload.'];
    }

    $detected = challenge_detect_type_from_bytes($tmp, $file['type'] ?? '', $orig);
    if (!$detected['ok']) {
        return $detected;
    }

    if ($detected['type'] === 'zip' && $size > $maxZipMb * 1024 * 1024) {
        return ['ok' => false, 'error' => "ZIP files must be {$maxZipMb} MB or smaller."];
    }
    if ($detected['type'] === 'image' && $size > $maxImageMb * 1024 * 1024) {
        return ['ok' => false, 'error' => "Images must be {$maxImageMb} MB or smaller."];
    }

    $stored = bin2hex(random_bytes(16)) . '.' . $detected['ext'];
    $destDir = challenge_upload_root();
    if (!is_dir($destDir)) {
        @mkdir($destDir, 0750, true);
    }
    $dest = rtrim($destDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $stored;

    if (!move_uploaded_file($tmp, $dest)) {
        return ['ok' => false, 'error' => 'Could not store uploaded file.'];
    }
    @chmod($dest, 0640);

    return [
        'ok' => true,
        'stored_name' => $stored,
        'original_name' => mb_substr($orig, 0, 240),
        'mime' => $detected['mime'],
        'type' => $detected['type'],
        'size' => $size,
        'path' => $dest,
    ];
}

/**
 * Can this student see this challenge based on target audience?
 */
function student_can_see_challenge(PDO $db, array $challenge, array $student) {
    if (!(int)$challenge['is_published'] || (int)$challenge['is_archived']) {
        return false;
    }
    $audience = $challenge['target_audience'] ?? 'all';
    if ($audience === 'all' || empty($audience)) {
        return true;
    }
    if ($audience === 'course' && !empty($challenge['course_id'])) {
        $stmt = $db->prepare("SELECT 1 FROM course_enrollments WHERE user_id = ? AND course_id = ? LIMIT 1");
        $stmt->execute([$student['id'], $challenge['course_id']]);
        return (bool)$stmt->fetchColumn();
    }
    if ($audience === 'class' && !empty($challenge['class_id'])) {
        return !empty($student['class_id']) && $student['class_id'] === $challenge['class_id'];
    }
    if ($audience === 'academic_group' && !empty($challenge['academic_group_id'])) {
        // Resolve via class → grade → academic_group
        if (empty($student['class_id'])) return false;
        $stmt = $db->prepare("
            SELECT 1 FROM classes c
            JOIN grades g ON c.grade_id = g.id
            WHERE c.id = ? AND g.academic_group_id = ?
            LIMIT 1
        ");
        $stmt->execute([$student['class_id'], $challenge['academic_group_id']]);
        return (bool)$stmt->fetchColumn();
    }
    return true;
}

/**
 * Teacher authorized to review this student's submission?
 */
function teacher_can_review_student(PDO $db, $teacherId, $studentId) {
    $stmt = $db->prepare("
        SELECT 1 FROM profiles stu
        LEFT JOIN classes c ON stu.class_id = c.id
        LEFT JOIN grades g ON c.grade_id = g.id
        WHERE stu.id = ? AND (
            g.academic_group_id IN (SELECT academic_group_id FROM teacher_academic_groups WHERE teacher_id = ?)
            OR c.id IN (SELECT class_id FROM teacher_classes WHERE teacher_id = ?)
            OR stu.id IN (SELECT student_id FROM teacher_student_assignments WHERE teacher_id = ?)
        )
        LIMIT 1
    ");
    $stmt->execute([$studentId, $teacherId, $teacherId, $teacherId]);
    return (bool)$stmt->fetchColumn();
}

function challenge_deadline_passed(array $challenge) {
    if (empty($challenge['deadline'])) return false;
    return strtotime($challenge['deadline']) < time();
}
