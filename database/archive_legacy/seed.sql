-- SPS Code Orbit Seed Data

-- UUIDs for fixed seed records
SET @ag_primary_3_4 = UUID();
SET @ag_primary_5_6 = UUID();
SET @ag_preparatory = UUID();
SET @ag_secondary = UUID();

-- Academic Groups
INSERT INTO academic_groups (id, name, description) VALUES
(@ag_primary_3_4, 'Primary 3-4', 'Basic programming and computational thinking for ages 8-10'),
(@ag_primary_5_6, 'Primary 5-6', 'Intermediate logic and visual programming for ages 10-12'),
(@ag_preparatory, 'Preparatory', 'Text-based programming and problem solving for ages 12-15'),
(@ag_secondary, 'Secondary', 'Advanced algorithms and real-world projects for ages 15-18');

-- Grades
SET @grade_3 = UUID();
SET @grade_4 = UUID();
SET @grade_5 = UUID();
SET @grade_6 = UUID();
SET @grade_prep_1 = UUID();
SET @grade_sec_1 = UUID();

INSERT INTO grades (id, academic_group_id, name, level) VALUES
(@grade_3, @ag_primary_3_4, 'Primary 3', 3),
(@grade_4, @ag_primary_3_4, 'Primary 4', 4),
(@grade_5, @ag_primary_5_6, 'Primary 5', 5),
(@grade_6, @ag_primary_5_6, 'Primary 6', 6),
(@grade_prep_1, @ag_preparatory, 'Prep 1', 7),
(@grade_sec_1, @ag_secondary, 'Secondary 1', 10);

-- Classes
SET @class_3A = UUID();
SET @class_4B = UUID();
SET @class_5C = UUID();
SET @class_6A = UUID();
SET @class_prep_1A = UUID();
SET @class_sec_1A = UUID();

INSERT INTO classes (id, grade_id, name) VALUES
(@class_3A, @grade_3, 'Class 3A - Alpha'),
(@class_4B, @grade_4, 'Class 4B - Beta'),
(@class_5C, @grade_5, 'Class 5C - Gamma'),
(@class_6A, @grade_6, 'Class Primary 6 - A'),
(@class_prep_1A, @grade_prep_1, 'Class Prep 1 - A'),
(@class_sec_1A, @grade_sec_1, 'Class Secondary 1 - A');

-- Achievements
INSERT INTO achievements (id, title, description, xp_reward, icon_url) VALUES
(UUID(), 'First Steps', 'Complete your very first lesson.', 50, '/assets/achievements/first-steps.png'),
(UUID(), 'Fast Learner', 'Complete 3 lessons in a single day.', 100, '/assets/achievements/fast-learner.png'),
(UUID(), 'Bug Squasher', 'Successfully pass a debugging quiz.', 75, '/assets/achievements/bug-squasher.png');

-- Initial Users (Password: admin123, teacher123, student123)
-- SECURITY: CHANGE BEFORE PRODUCTION / do not leave defaults on school servers
-- All hashed with password_hash(..., PASSWORD_DEFAULT)
INSERT INTO profiles (id, username, password_hash, full_name, role) VALUES
(UUID(), 'admin', '$2y$10$LkZ5ZQ5hQt1MgJqnANAo7ebq7ym2we4lkHrzZ3K87I5/ky7r7XvMe', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash);


-- ============================================================
-- Sample Challenges (visible to all students when published)
-- Requires: migrations/005_challenges_system.sql already applied
-- ============================================================

INSERT INTO challenges (
    id, title, description, instructions, difficulty,
    target_audience, allowed_types, max_zip_mb, max_image_mb,
    deadline, is_published, is_archived, xp_reward, created_by,
    created_at, updated_at
) VALUES
(UUID(),
 'Hello World Project',
 'Build a simple Hello World program in any language you are learning.',
 'Create a small program that prints \"Hello, SPS Code Orbit!\" to the console or screen.\n\nRequirements:\n1. Use any language taught in your current course.\n2. Include a short comment with your name and class.\n3. Upload a ZIP of source files or a clear screenshot (JPG/PNG/WEBP).\n\nYour teacher will review and give feedback.',
 'easy', 'all', 'zip,image', 10, 5, NULL, 1, 0, 50, NULL, NOW(), NOW()),
(UUID(),
 'Mini Calculator',
 'Create a program that performs basic arithmetic operations.',
 'Build a mini calculator that can add, subtract, multiply, and divide two numbers.\n\nRequirements:\n1. Accept two numbers (or use demo values).\n2. Show results of +, -, *, /.\n3. Handle division by zero if possible.\n4. Upload ZIP or screenshot.\n\nBonus: simple menu or GUI.',
 'medium', 'all', 'zip,image', 10, 5, NULL, 1, 0, 100, NULL, NOW(), NOW()),
(UUID(),
 'Creative Coding Showcase',
 'Show something creative you built with code — a game snippet, animation, or useful tool.',
 'Open creative challenge. Pick one:\n• Short interactive game or animation\n• Useful utility (to-do, converter, etc.)\n• Data visualization\n• Themed landing page (space / coding)\n\nUpload ZIP + README or clear screenshots. Scored on creativity, clarity, and effort.',
 'hard', 'all', 'zip,image', 10, 5, NULL, 1, 0, 150, NULL, NOW(), NOW());
