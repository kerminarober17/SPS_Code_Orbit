-- ============================================================
-- SPS CODE ORBIT - Sample Challenges Seed
-- Run AFTER migrations/005_challenges_system.sql
-- Creates published challenges visible to all students
-- ============================================================

-- Sample challenge 1: Hello World project
INSERT INTO challenges (
    id, title, description, instructions, difficulty,
    target_audience, allowed_types, max_zip_mb, max_image_mb,
    deadline, is_published, is_archived, xp_reward, created_by,
    created_at, updated_at
) VALUES (
    UUID(),
    'Hello World Project',
    'Build a simple Hello World program in any language you are learning.',
    'Create a small program that prints "Hello, SPS Code Orbit!" to the console or screen.

Requirements:
1. Use any language taught in your current course (Python, JavaScript, Scratch export, etc.).
2. Include a short comment or note with your name and class.
3. Upload either:
   - A ZIP containing your source files, OR
   - A clear screenshot (JPG/PNG/WEBP) of the running program.

Submit your work as a ZIP or image. Your teacher will review and give feedback.',
    'easy',
    'all',
    'zip,image',
    10,
    5,
    NULL,
    1,
    0,
    50,
    NULL,
    NOW(),
    NOW()
);

-- Sample challenge 2: Mini calculator / logic task
INSERT INTO challenges (
    id, title, description, instructions, difficulty,
    target_audience, allowed_types, max_zip_mb, max_image_mb,
    deadline, is_published, is_archived, xp_reward, created_by,
    created_at, updated_at
) VALUES (
    UUID(),
    'Mini Calculator',
    'Create a program that performs basic arithmetic operations.',
    'Build a mini calculator that can add, subtract, multiply, and divide two numbers.

Requirements:
1. Accept two numbers as input (or use fixed demo values if input is hard in your environment).
2. Show the results of +, -, *, / for those numbers.
3. Handle division by zero gracefully if possible.
4. Upload a ZIP of your code, or a screenshot of the running program.

Bonus: add a simple menu or buttons if you are using a GUI / web page.',
    'medium',
    'all',
    'zip,image',
    10,
    5,
    NULL,
    1,
    0,
    100,
    NULL,
    NOW(),
    NOW()
);

-- Sample challenge 3: Creative coding challenge
INSERT INTO challenges (
    id, title, description, instructions, difficulty,
    target_audience, allowed_types, max_zip_mb, max_image_mb,
    deadline, is_published, is_archived, xp_reward, created_by,
    created_at, updated_at
) VALUES (
    UUID(),
    'Creative Coding Showcase',
    'Show something creative you built with code — a game snippet, animation, or useful tool.',
    'This is an open creative challenge.

Pick ONE of the following (or invent your own with teacher approval):
• A short interactive game or animation
• A useful utility (to-do list, unit converter, password strength checker, etc.)
• A data visualization or simple chart
• A themed landing page related to space / coding

Upload:
- A ZIP with all source files and a README.txt explaining how to run it, OR
- Screenshots / images that clearly show the result

Your teacher will score creativity, clarity, and effort.',
    'hard',
    'all',
    'zip,image',
    10,
    5,
    NULL,
    1,
    0,
    150,
    NULL,
    NOW(),
    NOW()
);
