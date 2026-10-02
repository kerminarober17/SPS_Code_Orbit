-- Quick publish of JS Level 1 + Frontend Level 1 course shells
-- Full chapters/lessons: run php database/seed_curriculum.php after curriculum_export.json is updated

SET NAMES utf8mb4;

-- Ensure Preparatory academic group exists (adjust if your group id differs)
SET @ag := (SELECT id FROM academic_groups WHERE name IN ('Preparatory','Foundation Track') LIMIT 1);

INSERT INTO courses (id, academic_group_id, slug, title, description, image_url, accent_color, is_published, created_at, updated_at)
VALUES
('course-javascript-level-1', @ag, 'javascript-level-1',
 'JavaScript — Level 1',
 'Learn the fundamental building blocks of JavaScript — variables, data types, operators, decisions, functions, arrays, objects, and loops.',
 '/assets/courses/web.png', '#F7DF1E', 1, NOW(), NOW()),
('course-frontend-level-1', @ag, 'frontend-level-1',
 'Frontend — Level 1',
 'Learn how to create the structure and appearance of web pages using HTML and CSS from zero.',
 '/assets/courses/design.png', '#E34F26', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  description = VALUES(description),
  image_url = VALUES(image_url),
  accent_color = VALUES(accent_color),
  is_published = 1,
  academic_group_id = COALESCE(VALUES(academic_group_id), academic_group_id),
  updated_at = NOW();

-- EN / AR course translations
INSERT INTO course_translations (id, course_id, language, title, description)
SELECT UUID(), 'course-javascript-level-1', 'en',
 'JavaScript — Level 1',
 'Learn the fundamental building blocks of JavaScript — variables, data types, operators, decisions, functions, arrays, objects, and loops.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM course_translations WHERE course_id='course-javascript-level-1' AND language='en');

INSERT INTO course_translations (id, course_id, language, title, description)
SELECT UUID(), 'course-javascript-level-1', 'ar',
 'JavaScript — المستوى الأول',
 'تعلّم اللبنات الأساسية للغة JavaScript — المتغيرات، وأنواع البيانات، والعوامل، والقرارات، والدوال، والمصفوفات، والكائنات، والحلقات.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM course_translations WHERE course_id='course-javascript-level-1' AND language='ar');

INSERT INTO course_translations (id, course_id, language, title, description)
SELECT UUID(), 'course-frontend-level-1', 'en',
 'Frontend — Level 1',
 'Learn how to create the structure and appearance of web pages using HTML and CSS from zero.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM course_translations WHERE course_id='course-frontend-level-1' AND language='en');

INSERT INTO course_translations (id, course_id, language, title, description)
SELECT UUID(), 'course-frontend-level-1', 'ar',
 'Frontend — المستوى الأول',
 'تعلّم إنشاء هيكل ومظهر صفحات الويب باستخدام HTML وCSS من الصفر.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM course_translations WHERE course_id='course-frontend-level-1' AND language='ar');
