-- ============================================================
-- SPS CODE ORBIT - CHALLENGES SYSTEM
-- Migration 005 - Fixed Version
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. CHALLENGES
-- ============================================================

CREATE TABLE IF NOT EXISTS challenges (
    id CHAR(36) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    instructions TEXT NOT NULL,

    difficulty VARCHAR(50) DEFAULT 'medium',

    course_id CHAR(36) NULL,
    class_id CHAR(36) NULL,
    academic_group_id CHAR(36) NULL,

    target_audience VARCHAR(50) DEFAULT 'all',
    allowed_types VARCHAR(100) DEFAULT 'zip,image',

    max_zip_mb INT DEFAULT 10,
    max_image_mb INT DEFAULT 5,

    deadline DATETIME NULL,

    is_published TINYINT(1) DEFAULT 0,
    is_archived TINYINT(1) DEFAULT 0,

    xp_reward INT DEFAULT 0,

    created_by CHAR(36) NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    INDEX idx_challenges_published (is_published, is_archived),
    INDEX idx_challenges_course (course_id),
    INDEX idx_challenges_class (class_id),
    INDEX idx_challenges_ag (academic_group_id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 2. CHALLENGE SUBMISSIONS
-- ============================================================

CREATE TABLE IF NOT EXISTS challenge_submissions (
    id CHAR(36) NOT NULL,

    challenge_id CHAR(36) NOT NULL,
    student_id CHAR(36) NOT NULL,

    attempt_number INT NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    status VARCHAR(50) NOT NULL DEFAULT 'pending',

    file_stored_name VARCHAR(255) NOT NULL,
    file_original_name VARCHAR(255) NOT NULL,
    file_mime VARCHAR(120) NOT NULL,
    file_type VARCHAR(20) NOT NULL,
    file_size INT NOT NULL,

    feedback TEXT NULL,

    score INT NULL,

    reviewed_by CHAR(36) NULL,

    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    reviewed_at DATETIME NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    INDEX idx_cs_challenge (challenge_id),
    INDEX idx_cs_student (student_id),
    INDEX idx_cs_status (status),
    INDEX idx_cs_active (
        challenge_id,
        student_id,
        is_active
    ),

    -- Only reference challenges.
    -- student_id intentionally has NO FK to profiles
    -- because existing installations may have a
    -- structurally incompatible profiles table.

    CONSTRAINT fk_cs_challenge
        FOREIGN KEY (challenge_id)
        REFERENCES challenges(id)
        ON DELETE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- DONE
-- ============================================================

SET FOREIGN_KEY_CHECKS = 1;