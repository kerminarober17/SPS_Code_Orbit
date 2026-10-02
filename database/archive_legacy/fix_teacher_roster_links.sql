-- ============================================================================
-- OPTIONAL maintenance: link teachers & students so the Teacher Portal roster works.
-- Run AFTER seed_school_structure.sql
-- Edit the teacher username below before running.
-- ============================================================================

SET NAMES utf8mb4;

-- 1) Assign THIS teacher to Preparatory academic group + all classes under it
--    Change 'teacher1' to the real teacher username.
SET @teacher_username = 'teacher1';

SET @tid = (SELECT id FROM profiles WHERE username = @teacher_username AND role = 'teacher' LIMIT 1);

-- Academic group: Preparatory
INSERT IGNORE INTO teacher_academic_groups (id, teacher_id, academic_group_id)
SELECT UUID(), @tid, id FROM academic_groups
WHERE @tid IS NOT NULL
  AND (LOWER(name) LIKE '%prepar%' OR LOWER(name) LIKE '%prep%');

-- All classes under Preparatory grades
INSERT IGNORE INTO teacher_classes (id, teacher_id, class_id)
SELECT UUID(), @tid, c.id
FROM classes c
JOIN grades g ON g.id = c.grade_id
JOIN academic_groups ag ON ag.id = g.academic_group_id
WHERE @tid IS NOT NULL
  AND (LOWER(ag.name) LIKE '%prepar%' OR LOWER(ag.name) LIKE '%prep%');

-- 2) Best-effort: set student class_id from academic_stage + class_section when class_id is NULL
UPDATE profiles p
JOIN academic_groups ag ON (
    (LOWER(p.academic_stage) LIKE '%primary%' AND LOWER(ag.name) LIKE '%primary%')
 OR ( (LOWER(p.academic_stage) LIKE '%prep%' OR LOWER(p.academic_stage) LIKE '%prepar%')
      AND (LOWER(ag.name) LIKE '%prep%' OR LOWER(ag.name) LIKE '%prepar%') )
 OR (LOWER(p.academic_stage) LIKE '%second%' AND LOWER(ag.name) LIKE '%second%')
)
JOIN grades g ON g.academic_group_id = ag.id
JOIN classes c ON c.grade_id = g.id
  AND (
    UPPER(TRIM(c.name)) = UPPER(TRIM(p.class_section))
    OR UPPER(c.name) LIKE CONCAT('%', UPPER(TRIM(p.class_section)), '%')
  )
SET p.class_id = c.id
WHERE p.role = 'student'
  AND p.class_id IS NULL
  AND p.academic_stage IS NOT NULL
  AND p.class_section IS NOT NULL
LIMIT 5000;
