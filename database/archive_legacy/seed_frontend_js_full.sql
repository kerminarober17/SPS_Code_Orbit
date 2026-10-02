-- LEGACY / OPTIONAL — NOT the official production seed path.
-- Frontend + JavaScript courses are seeded by: php database/seed_curriculum.php
-- Official install: INSTALL.txt

-- ============================================================================
-- FULL SEED: Frontend Level 1 (5 chapters) + JavaScript Level 1 (6 chapters)
-- Generated from data/*_curriculum.js — run after courses rows exist
-- ============================================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Ensure courses exist
INSERT INTO courses (id, academic_group_id, slug, title, description, image_url, accent_color, is_published, created_at, updated_at)
SELECT 'course-javascript-level-1', (SELECT id FROM academic_groups LIMIT 1), 'javascript-level-1',
 'JavaScript — Level 1',
 'Learn the fundamental building blocks of JavaScript.',
 '/assets/courses/web.png', '#F7DF1E', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM courses WHERE id='course-javascript-level-1' OR slug='javascript-level-1');

INSERT INTO courses (id, academic_group_id, slug, title, description, image_url, accent_color, is_published, created_at, updated_at)
SELECT 'course-frontend-level-1', (SELECT id FROM academic_groups LIMIT 1), 'frontend-level-1',
 'Frontend — Level 1',
 'Learn how to create web pages with HTML and CSS.',
 '/assets/courses/design.png', '#E34F26', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM courses WHERE id='course-frontend-level-1' OR slug='frontend-level-1');



-- ===== Frontend — Level 1 (5 chapters) =====
-- Clear existing chapters/lessons for course-frontend-level-1 (safe rebuild)
DELETE lb FROM lesson_blocks lb INNER JOIN lessons l ON lb.lesson_id=l.id INNER JOIN chapters ch ON l.chapter_id=ch.id WHERE ch.course_id='course-frontend-level-1';
DELETE lp FROM lesson_progress lp INNER JOIN lessons l ON lp.lesson_id=l.id INNER JOIN chapters ch ON l.chapter_id=ch.id WHERE ch.course_id='course-frontend-level-1';
DELETE FROM lessons WHERE chapter_id IN (SELECT id FROM chapters WHERE course_id='course-frontend-level-1');
DELETE FROM chapters WHERE course_id='course-frontend-level-1';
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-fe1-01', 'course-frontend-level-1', 'chap-fe1-01-understanding-the-web-and-html', 'Chapter 1: Understanding the Web and HTML', 'Understand what websites and HTML are, and write your first valid HTML documents.', 1, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-1-1', 'chap-fe1-01', 'fe1-1-1-what-is-a-website', 1, '1.1: What Is a Website?', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-1', 'fe1-1-1', 'dialogue', 1, '{"shady": "I use websites every day, but I’ve never thought about what they actually are. What is a website really?", "cody": "Great starting question! A website is a collection of pages that live on the internet and are displayed by a browser. Let’s unpack that."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-2', 'fe1-1-1', 'text', 2, '{"title": "Learn", "body": "A <strong>website</strong> is a set of related web pages that share a common domain name and are published on the internet (or a local network).<br><br>When you type a web address (URL) or click a link:  \\n1. Your <strong>browser</strong> (Chrome, Firefox, Edge, Safari…) requests the page from a server.  \\n2. The server sends back files — mainly HTML, CSS, and sometimes JavaScript.  \\n3. The browser reads those files and <strong>renders</strong> (draws) the page on your screen.<br><br>Key ideas:  \\n- A website can be one page or thousands of pages.  \\n- The browser is the program that displays the website.  \\n- HTML describes the content and structure.  \\n- CSS describes how it looks.  \\n- JavaScript (optional) adds behavior.  <br><br>Many modern websites use HTML, CSS, and JavaScript together, but not every page needs JavaScript."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-3', 'fe1-1-1', 'text', 3, '{"title": "Example", "body": "When you visit a school website you might see:  <br>- A title and logo  <br>- Navigation links  <br>- Text about the school  <br>- Images of the campus  <br>- A contact form  <br><br>All of that is described with HTML and styled with CSS."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-4', 'fe1-1-1', 'quick_check', 4, '{"title": "Quick Check", "question": "What is the main job of a web browser?", "options": {"A": "To create websites", "B": "To request, receive, and display web pages", "C": "To store all websites on your computer permanently"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-5', 'fe1-1-1', 'challenge', 5, '{"title": "Tiny Challenge", "body": "Write one sentence that explains what a website is in your own words."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-6', 'fe1-1-1', 'mission', 6, '{"title": "Lesson Mission", "body": "Explain to a friend (or write in your notes) the difference between a website and a web browser."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-1-7', 'fe1-1-1', 'key_points', 7, '{"title": "Key Points", "points": ["A website is a collection of web pages.", "The browser displays the pages.", "HTML = structure, CSS = appearance, JavaScript = behavior.", "Not every page needs JavaScript."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-1-2', 'chap-fe1-01', 'fe1-1-2-what-is-html', 2, '1.2: What Is HTML?', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-1', 'fe1-1-2', 'dialogue', 1, '{"shady": "People keep saying “HTML is the skeleton of a webpage.” What does that mean?", "cody": "HTML stands for HyperText Markup Language. It is the language we use to describe the structure and content of a page."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-2', 'fe1-1-2', 'text', 2, '{"title": "Learn", "body": "<strong>HTML</strong> = HyperText Markup Language  <br><br>It is <strong>not</strong> a programming language like JavaScript or Python.  \\nIt is a <strong>markup language</strong> — it uses special markers called <strong>tags</strong> to tell the browser what each piece of content is.<br><br>Examples of what HTML can mark:  \\n- This is a main heading  \\n- This is a paragraph  \\n- This is a link  \\n- This is an image  \\n- This is a list  <br><br>A simple HTML tag looks like this:  \\n<pre><code><p>This is a paragraph.</p>\\n</code></pre><br><br>- `<p>` is the opening tag  \\n- `</p>` is the closing tag  \\n- The content goes between them  <br><br>Most HTML elements have an opening and a closing tag. A few elements are self-closing (we will see them later)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-3', 'fe1-1-2', 'code_example', 3, '{"language": "html", "code": "<h1>Welcome to Code Orbit</h1>\\n<p>This is the first paragraph of our page.</p>", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-4', 'fe1-1-2', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-5', 'fe1-1-2', 'quick_check', 5, '{"title": "Quick Check", "question": "What is the main purpose of HTML?", "options": {"A": "To make pages look colorful", "B": "To describe the structure and content of a webpage", "C": "To add animations and interactivity"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-6', 'fe1-1-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write one correct HTML paragraph element that contains a short sentence about yourself."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-7', 'fe1-1-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Write a one-sentence definition of HTML in your own words and give one example of a tag."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-2-8', 'fe1-1-2', 'key_points', 8, '{"title": "Key Points", "points": ["HTML stands for HyperText Markup Language.", "It uses tags to mark up content.", "It describes structure, not appearance or behavior.", "Most elements have opening and closing tags."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-1-3', 'chap-fe1-01', 'fe1-1-3-basic-html-document-structure', 3, '1.3: Basic HTML Document Structure', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-1', 'fe1-1-3', 'dialogue', 1, '{"shady": "Do I just start writing tags anywhere?", "cody": "Almost every HTML page follows the same basic skeleton. Let’s learn it once and use it forever."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-2', 'fe1-1-3', 'text', 2, '{"title": "Learn", "body": "Every modern HTML page should start with this structure:<br><br><pre><code><!DOCTYPE html>\\n<html lang=\\"en\\">\\n<head>\\n  <meta charset=\\"UTF-8\\">\\n  <title>Page Title</title>\\n</head>\\n<body>\\n  <!-- Visible content goes here -->\\n</body>\\n</html>\\n</code></pre><br><br><strong>What each part means:</strong>  \\n- `<!DOCTYPE html>` — tells the browser this is an HTML5 document  \\n- `<html>` — the root element that wraps everything  \\n- `lang=\\"en\\"` — language of the page (helps accessibility and search engines)  \\n- `<head>` — information about the page (not visible content)  \\n- `<meta charset=\\"UTF-8\\">` — character encoding so all languages display correctly  \\n- `<title>` — the text that appears in the browser tab  \\n- `<body>` — everything the user actually sees on the page  <br><br>Comments in HTML look like this:  \\n<pre><code><!-- This is a comment. The browser ignores it. -->\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-3', 'fe1-1-3', 'code_example', 3, '{"language": "html", "code": "<!DOCTYPE html>\\n<html lang=\\"en\\">\\n<head>\\n  <meta charset=\\"UTF-8\\">\\n  <title>My First Page</title>\\n</head>\\n<body>\\n  <h1>Hello, Code Orbit!</h1>\\n  <p>This is my first webpage.</p>\\n</body>\\n</html>", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-4', 'fe1-1-3', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html lang=\\"en\\">\\n<head>\\n  <meta charset=\\"UTF-8\\">\\n  <title>My First Page</title>\\n</head>\\n<body>\\n  <h1>Hello, Code Orbit!</h1>\\n  <p>This is my first webpage.</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-5', 'fe1-1-3', 'quick_check', 5, '{"title": "Quick Check", "question": "Where does the visible content of a webpage belong?", "options": {"A": "Inside the `<head>`", "B": "Inside the `<body>`", "C": "Inside the `<!DOCTYPE>`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-6', 'fe1-1-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Change the language attribute to another language code (for example `lang=\\"ar\\"`) and change the title to something personal."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-7', 'fe1-1-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a complete minimal HTML page about yourself with a title, one heading, and one paragraph."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-3-8', 'fe1-1-3', 'key_points', 8, '{"title": "Key Points", "points": ["Every page needs DOCTYPE, html, head, and body.", "Visible content goes in the body.", "The title appears in the browser tab.", "Comments help humans understand the code."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-1-4', 'chap-fe1-01', 'fe1-1-4-headings-and-paragraphs', 4, '1.4: Headings and Paragraphs', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-1', 'fe1-1-4', 'dialogue', 1, '{"shady": "How do I make some text big and important and other text normal?", "cody": "HTML has special tags for headings and paragraphs. They create a clear hierarchy."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-2', 'fe1-1-4', 'text', 2, '{"title": "Learn", "body": "<strong>Headings</strong> (`<h1>` to `<h6>`):  \\n- `<h1>` — main title of the page (usually only one per page)  \\n- `<h2>` — major section headings  \\n- `<h3>` — sub-sections  \\n- … down to `<h6>` for the smallest headings  <br><br><strong>Paragraphs:</strong>  \\n<pre><code><p>This is a paragraph of text. It can contain several sentences.</p>\\n</code></pre><br><br>Good practice:  \\n- Use headings to create a logical outline.  \\n- Do not skip levels just for visual size (use CSS for appearance later).  \\n- Keep paragraphs focused on one idea."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-3', 'fe1-1-4', 'code_example', 3, '{"language": "html", "code": "<h1>My Learning Journey</h1>\\n<p>I started with Programming Foundations.</p>\\n\\n<h2>Current Course</h2>\\n<p>Now I am learning Frontend Level 1.</p>\\n\\n<h3>Today’s Goal</h3>\\n<p>Understand headings and paragraphs.</p>", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-4', 'fe1-1-4', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html lang=\\"en\\">\\n<head>\\n  <meta charset=\\"UTF-8\\">\\n  <title>Headings Practice</title>\\n</head>\\n<body>\\n  <h1>Main Title</h1>\\n  <p>Introduction paragraph.</p>\\n  <h2>Section One</h2>\\n  <p>Details about section one.</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-5', 'fe1-1-4', 'quick_check', 5, '{"title": "Quick Check", "question": "Which heading level should normally be used for the main title of a page?", "options": {"A": "`<h3>`", "B": "`<h1>`", "C": "`<h6>`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-6', 'fe1-1-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write a mini article structure with one h1, two h2s, and a paragraph under each h2."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-7', 'fe1-1-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Build a simple “About My Day” page using proper heading hierarchy and paragraphs."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-4-8', 'fe1-1-4', 'key_points', 8, '{"title": "Key Points", "points": ["Headings create structure and hierarchy.", "`<h1>` is the most important heading.", "Paragraphs hold normal text content.", "Use headings for meaning, not just size."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-1-5', 'chap-fe1-01', 'fe1-1-5-html-comments-and-good-habits', 5, '1.5: HTML Comments and Good Habits', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-1', 'fe1-1-5', 'dialogue', 1, '{"shady": "When my page gets longer, I forget what each part is for.", "cody": "Comments and clean structure solve that problem."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-2', 'fe1-1-5', 'text', 2, '{"title": "Learn", "body": "HTML comments:\\n<pre><code><!-- This is a comment. It is not displayed on the page. -->\\n</code></pre><br><br>Useful places for comments:  \\n- At the start of a major section  \\n- To temporarily disable a piece of code  \\n- To leave notes for yourself or teammates  <br><br><strong>Good habits for Level 1:</strong>  \\n- Indent nested elements (2 or 4 spaces)  \\n- Close every tag that needs closing  \\n- Use lowercase for tag names  \\n- Keep the structure tidy"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-3', 'fe1-1-5', 'code_example', 3, '{"language": "html", "code": "<body>\\n  <!-- Main header -->\\n  <h1>Welcome</h1>\\n\\n  <!-- Introduction -->\\n  <p>This page is about learning HTML.</p>\\n</body>", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-4', 'fe1-1-5', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-5', 'fe1-1-5', 'quick_check', 5, '{"title": "Quick Check", "question": "Do HTML comments appear on the visible webpage?", "options": {"A": "Yes", "B": "No", "C": "Only in some browsers"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-6', 'fe1-1-5', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Take a previous page and add at least two useful comments."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-7', 'fe1-1-5', 'mission', 7, '{"title": "Lesson Mission", "body": "Review one of your earlier pages and improve it with comments and consistent indentation."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-1-5-8', 'fe1-1-5', 'key_points', 8, '{"title": "Key Points", "points": ["Comments help humans understand code.", "The browser ignores comments.", "Indentation and consistent structure make code easier to read.", "Close your tags."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-fe1-02', 'course-frontend-level-1', 'chap-fe1-02-html-content-and-navigation', 'Chapter 2: HTML Content and Navigation', 'Add links, images, and lists so pages can navigate and present content clearly.', 2, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-2-1', 'chap-fe1-02', 'fe1-2-1-links-with-the-anchor-element', 1, '2.1: Links with the Anchor Element', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-1', 'fe1-2-1', 'dialogue', 1, '{"shady": "How do I make text that I can click to go to another page?", "cody": "That is what the anchor element is for — the heart of the web!"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-2', 'fe1-2-1', 'text', 2, '{"title": "Learn", "body": "The <strong>anchor</strong> element creates a link:<br><br><pre><code><a href=\\"https://www.example.com\\">Visit Example</a>\\n</code></pre><br><br>- `<a>` stands for anchor  \\n- `href` (hypertext reference) holds the destination URL  \\n- The text between the tags is what the user sees and clicks  <br><br><strong>Absolute vs relative links (beginner level):</strong>  \\n- Absolute: full address starting with `https://` — goes to another website  \\n- Relative: path to another page on the same site, for example `about.html`  <br><br><pre><code><a href=\\"https://www.wikipedia.org\\">Wikipedia (absolute)</a>\\n<a href=\\"contact.html\\">Contact page (relative)</a>\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-3', 'fe1-2-1', 'code_example', 3, '{"language": "html", "code": "<p>\\n  Learn more at \\n  <a href=\\"https://developer.mozilla.org\\">MDN Web Docs</a>.\\n</p>", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-4', 'fe1-2-1', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html lang=\\"en\\">\\n<head>\\n  <meta charset=\\"UTF-8\\">\\n  <title>Links Practice</title>\\n</head>\\n<body>\\n  <h1>Useful Links</h1>\\n  <p><a href=\\"https://www.google.com\\">Go to Google</a></p>\\n  <!-- Add one more link below -->\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-5', 'fe1-2-1', 'quick_check', 5, '{"title": "Quick Check", "question": "Which attribute of the `<a>` tag specifies the destination of the link?", "options": {"A": "`src`", "B": "`href`", "C": "`link`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-6', 'fe1-2-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write two links: one absolute and one relative (you can invent the relative filename)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-7', 'fe1-2-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a small “Resources” section with three useful links for learning frontend."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-1-8', 'fe1-2-1', 'key_points', 8, '{"title": "Key Points", "points": ["Use `<a href=\\"...\\">` to create links.", "Absolute links start with `https://`.", "Relative links point to pages on the same site.", "The visible text is placed between the tags."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-2-2', 'chap-fe1-02', 'fe1-2-2-images', 2, '2.2: Images', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-1', 'fe1-2-2', 'dialogue', 1, '{"shady": "How do I put a picture on my page?", "cody": "With the image element. And we always describe the image for accessibility."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-2', 'fe1-2-2', 'text', 2, '{"title": "Learn", "body": "<pre><code><img src=\\"photo.jpg\\" alt=\\"A smiling robot named Cody\\" width=\\"300\\">\\n</code></pre><br><br>- `<img>` is a self-closing element (no closing tag needed)  \\n- `src` — path or URL of the image file  \\n- `alt` — alternative text that describes the image (very important for accessibility and when the image fails to load)  \\n- `width` and `height` — optional size in pixels (for Level 1 we keep it simple)  <br><br>Good `alt` text:  \\n- Describes the content or function of the image  \\n- Is not just “image” or “photo”"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-3', 'fe1-2-2', 'code_example', 3, '{"language": "html", "code": "<img \\n  src=\\"https://via.placeholder.com/200\\" \\n  alt=\\"Placeholder image 200 pixels wide\\"\\n  width=\\"200\\">", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-4', 'fe1-2-2', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-5', 'fe1-2-2', 'quick_check', 5, '{"title": "Quick Check", "question": "Why is the `alt` attribute important?", "options": {"A": "It makes the image load faster", "B": "It describes the image for screen readers and when the image cannot be shown", "C": "It is required for CSS to work"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-6', 'fe1-2-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a short profile section that contains a heading, a paragraph, and an image with good alt text."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-7', 'fe1-2-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Build a simple “About Me” block that includes one image with proper alt text."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-2-8', 'fe1-2-2', 'key_points', 8, '{"title": "Key Points", "points": ["Use `<img src=\\"...\\" alt=\\"...\\">`.", "Always provide meaningful alt text.", "width/height can control display size at a basic level.", "Images are self-closing."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-2-3', 'chap-fe1-02', 'fe1-2-3-unordered-and-ordered-lists', 3, '2.3: Unordered and Ordered Lists', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-1', 'fe1-2-3', 'dialogue', 1, '{"shady": "I want to show a list of topics or steps. How do I do that cleanly?", "cody": "HTML has special list elements for exactly that purpose."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-2', 'fe1-2-3', 'text', 2, '{"title": "Learn", "body": "<strong>Unordered list</strong> (bullets):\\n<pre><code><ul>\\n  <li>HTML</li>\\n  <li>CSS</li>\\n  <li>JavaScript</li>\\n</ul>\\n</code></pre><br><br><strong>Ordered list</strong> (numbers):\\n<pre><code><ol>\\n  <li>Learn HTML structure</li>\\n  <li>Add content</li>\\n  <li>Style with CSS</li>\\n</ol>\\n</code></pre><br><br>- `<ul>` = unordered list  \\n- `<ol>` = ordered list  \\n- `<li>` = list item (used inside both)  <br><br>You can put paragraphs, links, or other elements inside a list item when needed."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-3', 'fe1-2-3', 'code_example', 3, '{"language": "html", "code": "<h2>My Learning Plan</h2>\\n<ol>\\n  <li>Finish Frontend Level 1</li>\\n  <li>Practice building small pages</li>\\n  <li>Move to Level 2</li>\\n</ol>", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-4', 'fe1-2-3', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-5', 'fe1-2-3', 'quick_check', 5, '{"title": "Quick Check", "question": "Which element creates a bulleted list?", "options": {"A": "`<ol>`", "B": "`<ul>`", "C": "`<li>`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-6', 'fe1-2-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Make a nested structure idea (list of courses, each with a short description paragraph inside the `<li>`)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-7', 'fe1-2-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a page section that contains both an ordered list and an unordered list related to your learning goals."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-3-8', 'fe1-2-3', 'key_points', 8, '{"title": "Key Points", "points": ["`<ul>` for bullets, `<ol>` for numbers.", "Every item is an `<li>`.", "Lists help organize information clearly."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-2-4', 'chap-fe1-02', 'fe1-2-4-grouping-content-and-simple-navigat', 4, '2.4: Grouping Content and Simple Navigation', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-1', 'fe1-2-4', 'dialogue', 1, '{"shady": "How do real websites put a menu of links at the top?", "cody": "We combine lists and links — and later CSS will make it look like a real menu. For now we focus on correct structure."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-2', 'fe1-2-4', 'text', 2, '{"title": "Learn", "body": "A common beginner navigation pattern:<br><br><pre><code><nav>\\n  <ul>\\n    <li><a href=\\"index.html\\">Home</a></li>\\n    <li><a href=\\"about.html\\">About</a></li>\\n    <li><a href=\\"contact.html\\">Contact</a></li>\\n  </ul>\\n</nav>\\n</code></pre><br><br>- `<nav>` is a semantic element that indicates navigation (good practice)  \\n- Inside it we often place an unordered list of links  \\n- Each link points to a different page or section  <br><br>You can also group content with simple elements like `<div>` (generic container) or more semantic tags later. For Level 1, focus on clear structure."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-3', 'fe1-2-4', 'text', 3, '{"title": "Example", "body": "A small page with navigation and two sections."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-4', 'fe1-2-4', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-5', 'fe1-2-4', 'quick_check', 5, '{"title": "Quick Check", "question": "Which element is specifically meant to wrap major navigation links?", "options": {"A": "`<nav>`", "B": "`<header>` only", "C": "`<p>`"}, "correct": "A", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-6', 'fe1-2-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Add a fourth navigation item and a footer paragraph with a copyright note."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-7', 'fe1-2-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a mini multi-page concept (Home, About, Contact) using a shared navigation list structure."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-2-4-8', 'fe1-2-4', 'key_points', 8, '{"title": "Key Points", "points": ["Combine `<nav>`, `<ul>`, and `<a>` for basic menus.", "Structure comes before styling.", "Semantic tags like `<nav>` improve clarity."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-fe1-03', 'course-frontend-level-1', 'chap-fe1-03-html-data-and-forms', 'Chapter 3: HTML Data and Forms', 'Present data in tables and collect information with forms.', 3, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-3-1', 'chap-fe1-03', 'fe1-3-1-tables', 1, '3.1: Tables', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-1', 'fe1-3-1', 'dialogue', 1, '{"shady": "How can I show information in neat rows and columns, like a schedule?", "cody": "HTML tables are perfect for tabular data."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-2', 'fe1-3-1', 'text', 2, '{"title": "Learn", "body": "Basic table structure:<br><br><pre><code><table>\\n  <tr>\\n    <th>Name</th>\\n    <th>Score</th>\\n  </tr>\\n  <tr>\\n    <td>Shady</td>\\n    <td>95</td>\\n  </tr>\\n  <tr>\\n    <td>Cody</td>\\n    <td>100</td>\\n  </tr>\\n</table>\\n</code></pre><br><br>- `<table>` — the whole table  \\n- `<tr>` — table row  \\n- `<th>` — header cell (bold and centered by default)  \\n- `<td>` — normal data cell  <br><br>Use tables for <strong>data</strong>, not for page layout (layout belongs to CSS)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-3', 'fe1-3-1', 'text', 3, '{"title": "Example", "body": "A small scoreboard or class timetable."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-4', 'fe1-3-1', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-5', 'fe1-3-1', 'quick_check', 5, '{"title": "Quick Check", "question": "Which tag is used for a header cell in a table?", "options": {"A": "`<td>`", "B": "`<th>`", "C": "`<tr>`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-6', 'fe1-3-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Make a 3×3 table that shows a simple weekly plan."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-7', 'fe1-3-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a useful table related to your learning progress or a hobby."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-1-8', 'fe1-3-1', 'key_points', 8, '{"title": "Key Points", "points": ["Tables organize data in rows and columns.", "Use `<th>` for headers and `<td>` for data.", "Do not use tables for visual layout."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-3-2', 'chap-fe1-03', 'fe1-3-2-introduction-to-forms', 2, '3.2: Introduction to Forms', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-1', 'fe1-3-2', 'dialogue', 1, '{"shady": "How do websites let me type my name or search for something?", "cody": "Through forms! Forms are the way users send information to a page or a server."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-2', 'fe1-3-2', 'text', 2, '{"title": "Learn", "body": "A basic form:<br><br><pre><code><form>\\n  <label for=\\"name\\">Name:</label>\\n  <input type=\\"text\\" id=\\"name\\" name=\\"name\\">\\n  <button type=\\"submit\\">Send</button>\\n</form>\\n</code></pre><br><br>- `<form>` wraps the whole form  \\n- `<label>` describes the field (important for accessibility)  \\n- `<input>` creates many kinds of fields  \\n- `<button>` can submit the form  <br><br>In Level 1 we focus on the structure and the different input types. We do not yet connect forms to real servers or JavaScript validation."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-3', 'fe1-3-2', 'text', 3, '{"title": "Example", "body": "A simple feedback form with a name field and a submit button."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-4', 'fe1-3-2', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-5', 'fe1-3-2', 'quick_check', 5, '{"title": "Quick Check", "question": "Which element is used to group form controls?", "options": {"A": "`<form>`", "B": "`<input>`", "C": "`<label>`"}, "correct": "A", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-6', 'fe1-3-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Add a second field for “Favorite color” to your form."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-7', 'fe1-3-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Design a small “Contact Me” form structure with at least two fields and a button."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-2-8', 'fe1-3-2', 'key_points', 8, '{"title": "Key Points", "points": ["Forms collect user input.", "Always use labels.", "The basic structure is form → label + input → button."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-3-3', 'chap-fe1-03', 'fe1-3-3-common-input-types', 3, '3.3: Common Input Types', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-1', 'fe1-3-3', 'dialogue', 1, '{"shady": "There seem to be many different kinds of boxes and buttons in forms. How do I choose the right one?", "cody": "Each `type` of input is designed for a specific kind of data. Let’s meet the most useful ones for beginners."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-2', 'fe1-3-3', 'text', 2, '{"title": "Learn", "body": "<pre><code><!-- Text -->\\n<label for=\\"username\\">Username</label>\\n<input type=\\"text\\" id=\\"username\\" name=\\"username\\"><br><br><!-- Email -->\\n<label for=\\"email\\">Email</label>\\n<input type=\\"email\\" id=\\"email\\" name=\\"email\\"><br><br><!-- Password -->\\n<label for=\\"password\\">Password</label>\\n<input type=\\"password\\" id=\\"password\\" name=\\"password\\"><br><br><!-- Number -->\\n<label for=\\"age\\">Age</label>\\n<input type=\\"number\\" id=\\"age\\" name=\\"age\\" min=\\"1\\" max=\\"120\\"><br><br><!-- Radio buttons (only one can be selected) -->\\n<p>Choose a level:</p>\\n<input type=\\"radio\\" id=\\"beginner\\" name=\\"level\\" value=\\"beginner\\">\\n<label for=\\"beginner\\">Beginner</label>\\n<input type=\\"radio\\" id=\\"advanced\\" name=\\"level\\" value=\\"advanced\\">\\n<label for=\\"advanced\\">Advanced</label><br><br><!-- Checkboxes (multiple can be selected) -->\\n<p>Interests:</p>\\n<input type=\\"checkbox\\" id=\\"html\\" name=\\"interest\\" value=\\"html\\">\\n<label for=\\"html\\">HTML</label>\\n<input type=\\"checkbox\\" id=\\"css\\" name=\\"interest\\" value=\\"css\\">\\n<label for=\\"css\\">CSS</label><br><br><!-- Dropdown -->\\n<label for=\\"country\\">Country</label>\\n<select id=\\"country\\" name=\\"country\\">\\n  <option value=\\"eg\\">Egypt</option>\\n  <option value=\\"sa\\">Saudi Arabia</option>\\n  <option value=\\"ae\\">UAE</option>\\n</select>\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-3', 'fe1-3-3', 'text', 3, '{"title": "Example", "body": "A registration-style form that uses several of the above types."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-4', 'fe1-3-3', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-5', 'fe1-3-3', 'quick_check', 5, '{"title": "Quick Check", "question": "Which input type hides the characters as the user types?", "options": {"A": "`text`", "B": "`password`", "C": "`email`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-6', 'fe1-3-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Add a number input for “Years of experience” with a sensible min value."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-7', 'fe1-3-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Build a “Student Profile Form” that uses at least five different input types."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-3-8', 'fe1-3-3', 'key_points', 8, '{"title": "Key Points", "points": ["Different input types serve different data.", "Radio = one choice, checkbox = multiple choices.", "Always pair inputs with labels.", "`select` + `option` creates dropdowns."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-3-4', 'chap-fe1-03', 'fe1-3-4-buttons-and-form-purpose', 4, '3.4: Buttons and Form Purpose', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-1', 'fe1-3-4', 'dialogue', 1, '{"shady": "What exactly happens when I click the button?", "cody": "In real websites the data is usually sent to a server. In Level 1 we focus on correct structure and understanding the purpose."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-2', 'fe1-3-4', 'text', 2, '{"title": "Learn", "body": "<pre><code><button type=\\"submit\\">Send Message</button>\\n<button type=\\"reset\\">Clear Form</button>\\n<button type=\\"button\\">Just a Button</button>\\n</code></pre><br><br>- `type=\\"submit\\"` — sends the form data  \\n- `type=\\"reset\\"` — clears the form fields  \\n- `type=\\"button\\"` — a generic button (no automatic action)  <br><br>Every form should have a clear purpose: search, login, contact, survey, registration, etc.  \\nGood forms are easy to understand and easy to fill."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-3', 'fe1-3-4', 'text', 3, '{"title": "Example", "body": "A contact form with a clear heading, a few fields, and a “Send” button."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-4', 'fe1-3-4', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-5', 'fe1-3-4', 'quick_check', 5, '{"title": "Quick Check", "question": "What does a button with `type=\\"submit\\"` do?", "options": {"A": "Clears the form", "B": "Sends the form data", "C": "Only changes color"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-6', 'fe1-3-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Add a reset button next to the submit button and test both."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-7', 'fe1-3-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Finalize one complete form that has a clear purpose, good labels, appropriate input types, and a submit button."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-3-4-8', 'fe1-3-4', 'key_points', 8, '{"title": "Key Points", "points": ["Buttons can submit, reset, or perform custom actions.", "Forms need a clear purpose.", "Good labels and structure make forms usable."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-fe1-04', 'course-frontend-level-1', 'chap-fe1-04-css-fundamentals', 'Chapter 4: CSS Fundamentals', 'Control the appearance of HTML elements with CSS.', 4, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-4-1', 'chap-fe1-04', 'fe1-4-1-what-is-css', 1, '4.1: What Is CSS?', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-1', 'fe1-4-1', 'dialogue', 1, '{"shady": "My pages look very plain. How do I add colors and nicer fonts?", "cody": "That is the job of CSS — Cascading Style Sheets."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-2', 'fe1-4-1', 'text', 2, '{"title": "Learn", "body": "<strong>CSS</strong> = Cascading Style Sheets  <br><br>It describes <strong>how</strong> HTML elements should look: colors, fonts, sizes, spacing, etc.<br><br>There are three ways to add CSS:  <br><br>1. <strong>Inline</strong> — style attribute on an element (quick but not recommended for large projects)  \\n<pre><code><p style=\\"color: blue;\\">Blue text</p>\\n</code></pre><br><br>2. <strong>Internal</strong> — `<style>` tag inside the `<head>`  \\n<pre><code><style>\\n  p { color: blue; }\\n</style>\\n</code></pre><br><br>3. <strong>External</strong> — separate `.css` file linked with `<link>` (best practice)  \\n<pre><code><link rel=\\"stylesheet\\" href=\\"styles.css\\">\\n</code></pre><br><br>In this course we will mostly use internal and external CSS."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-3', 'fe1-4-1', 'text', 3, '{"title": "Example", "body": "Changing the color of all paragraphs with internal CSS."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-4', 'fe1-4-1', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-5', 'fe1-4-1', 'quick_check', 5, '{"title": "Quick Check", "question": "What is the main job of CSS?", "options": {"A": "To describe the structure of the page", "B": "To control the appearance and layout of the page", "C": "To add interactivity"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-6', 'fe1-4-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write one inline style and one internal style rule and observe the difference."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-7', 'fe1-4-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Take a previous HTML page and give it a simple internal style that changes the heading color."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-1-8', 'fe1-4-1', 'key_points', 8, '{"title": "Key Points", "points": ["CSS controls appearance.", "Three ways: inline, internal, external.", "External stylesheets are the best long-term approach.", "HTML stays focused on structure."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-4-2', 'chap-fe1-04', 'fe1-4-2-selectors-element-class-and-id', 2, '4.2: Selectors: Element, Class, and ID', 15, 30, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-1', 'fe1-4-2', 'dialogue', 1, '{"shady": "How does CSS know which elements to style?", "cody": "Through selectors! Let’s learn the three most important ones."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-2', 'fe1-4-2', 'text', 2, '{"title": "Learn", "body": "<strong>1. Element selector</strong> — targets all elements of that type  \\n<pre><code>p {\\n  color: navy;\\n}\\n</code></pre><br><br><strong>2. Class selector</strong> — targets elements that have a specific class (reusable)  \\n<pre><code><p class=\\"highlight\\">Important text</p>\\n</code></pre>\\n<pre><code>.highlight {\\n  background-color: yellow;\\n}\\n</code></pre><br><br><strong>3. ID selector</strong> — targets one unique element  \\n<pre><code><h1 id=\\"main-title\\">Welcome</h1>\\n</code></pre>\\n<pre><code>#main-title {\\n  color: darkgreen;\\n}\\n</code></pre><br><br><strong>Basic specificity idea (Level 1):</strong>  \\nID is more specific than class, class is more specific than element.  \\nWhen rules conflict, the more specific one wins."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-3', 'fe1-4-2', 'text', 3, '{"title": "Example", "body": "Styling a page that uses all three kinds of selectors."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-4', 'fe1-4-2', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-5', 'fe1-4-2', 'quick_check', 5, '{"title": "Quick Check", "question": "Which character is used to start a class selector in CSS?", "options": {"A": "`#`", "B": "`.`", "C": "`*`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-6', 'fe1-4-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create two paragraphs: one normal, one with class `special`. Make only the special one red."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-7', 'fe1-4-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Style a small page using at least one element selector, one class, and one ID."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-2-8', 'fe1-4-2', 'key_points', 8, '{"title": "Key Points", "points": ["Element selector → tag name", "Class selector → `.classname`", "ID selector → `#idname`", "Classes are reusable; IDs should be unique."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-4-3', 'chap-fe1-04', 'fe1-4-3-colors-and-backgrounds', 3, '4.3: Colors and Backgrounds', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-1', 'fe1-4-3', 'dialogue', 1, '{"shady": "How do I choose nice colors for text and backgrounds?", "cody": "CSS gives us several ways to write colors. Let’s start with the simplest."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-2', 'fe1-4-3', 'text', 2, '{"title": "Learn", "body": "<pre><code>h1 {\\n  color: darkblue;           /* named color */\\n  background-color: #f0f8ff; /* hex color */\\n}<br><br>p {\\n  color: #333333;\\n  background-color: lightyellow;\\n}\\n</code></pre><br><br>- `color` controls text color  \\n- `background-color` controls the background of the element  \\n- Named colors: `red`, `blue`, `white`, `black`, `navy`, etc.  \\n- Hex colors: `#RRGGBB` (for example `#ff0000` is pure red)  <br><br>You can also use more advanced formats later (RGB, HSL). For Level 1, named colors and basic hex are enough."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-3', 'fe1-4-3', 'text', 3, '{"title": "Example", "body": "A simple color scheme for a learning page."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-4', 'fe1-4-3', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-5', 'fe1-4-3', 'quick_check', 5, '{"title": "Quick Check", "question": "Which property changes the text color?", "options": {"A": "`background-color`", "B": "`color`", "C": "`font-color`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-6', 'fe1-4-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a “highlight” class that uses a bright background color and dark text."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-7', 'fe1-4-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Design a simple two-color scheme for one of your pages and apply it with CSS."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-3-8', 'fe1-4-3', 'key_points', 8, '{"title": "Key Points", "points": ["`color` = text, `background-color` = background.", "Named colors are easy to start with.", "Hex codes give precise control.", "Good contrast improves readability."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-4-4', 'chap-fe1-04', 'fe1-4-4-typography-fonts-size-weight-and-al', 4, '4.4: Typography: Fonts, Size, Weight, and Alignment', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-1', 'fe1-4-4', 'dialogue', 1, '{"shady": "The default font looks a bit boring. Can I change it?", "cody": "Yes — typography is a big part of how professional pages feel."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-2', 'fe1-4-4', 'text', 2, '{"title": "Learn", "body": "<pre><code>body {\\n  font-family: Arial, sans-serif;\\n  font-size: 16px;\\n}<br><br>h1 {\\n  font-size: 2rem;\\n  font-weight: bold;\\n  text-align: center;\\n}<br><br>p {\\n  font-weight: normal;\\n  text-align: left;\\n  line-height: 1.5;\\n}\\n</code></pre><br><br>Important properties:  \\n- `font-family` — which font to use (always provide a fallback)  \\n- `font-size` — size of the text  \\n- `font-weight` — normal, bold, or numeric values  \\n- `text-align` — left, center, right, justify  \\n- `line-height` — space between lines (improves readability)"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-3', 'fe1-4-4', 'text', 3, '{"title": "Example", "body": "A clean reading style for articles."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-4', 'fe1-4-4', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-5', 'fe1-4-4', 'quick_check', 5, '{"title": "Quick Check", "question": "Which property controls whether text is bold?", "options": {"A": "`font-size`", "B": "`font-weight`", "C": "`text-align`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-6', 'fe1-4-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a class `.big-text` that increases font size and another class `.center` that centers text."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-7', 'fe1-4-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Improve the typography of one of your earlier pages so it feels more pleasant to read."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-4-8', 'fe1-4-4', 'key_points', 8, '{"title": "Key Points", "points": ["Choose readable fonts and always give a fallback.", "Control size, weight, and alignment.", "Good line-height makes text easier to read.", "Consistency across the page looks professional."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-4-5', 'chap-fe1-04', 'fe1-4-5-linking-an-external-stylesheet', 5, '4.5: Linking an External Stylesheet', 10, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-1', 'fe1-4-5', 'dialogue', 1, '{"shady": "My style block is getting long. Can I move the CSS to its own file?", "cody": "Yes — and that is the professional way to work."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-2', 'fe1-4-5', 'text', 2, '{"title": "Learn", "body": "In the `<head>` of your HTML:<br><br><pre><code><link rel=\\"stylesheet\\" href=\\"styles.css\\">\\n</code></pre><br><br>- `rel=\\"stylesheet\\"` tells the browser this is a style sheet  \\n- `href` points to the CSS file  <br><br>The CSS file itself contains only CSS rules — no HTML tags:<br><br><pre><code>/* styles.css */\\nbody {\\n  font-family: Arial, sans-serif;\\n  background-color: #fafafa;\\n}<br><br>h1 {\\n  color: #223;\\n}\\n</code></pre><br><br>Benefits:  \\n- One CSS file can style many HTML pages  \\n- Easier to maintain  \\n- Cleaner HTML"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-3', 'fe1-4-5', 'text', 3, '{"title": "Example", "body": "A two-file mini project: `index.html` + `styles.css`."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-4', 'fe1-4-5', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-5', 'fe1-4-5', 'quick_check', 5, '{"title": "Quick Check", "question": "Where should the `<link>` element for a stylesheet usually be placed?", "options": {"A": "Inside the `<body>`", "B": "Inside the `<head>`", "C": "After the closing `</html>`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-6', 'fe1-4-5', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Describe one advantage of external CSS over internal CSS."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-7', 'fe1-4-5', 'mission', 7, '{"title": "Lesson Mission", "body": "Convert one of your internal-style pages into an external-stylesheet version."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-4-5-8', 'fe1-4-5', 'key_points', 8, '{"title": "Key Points", "points": ["Use `<link rel=\\"stylesheet\\" href=\\"...\\">`.", "Place it in the `<head>`.", "External CSS keeps projects organized.", "The CSS file contains pure CSS rules."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-fe1-05', 'course-frontend-level-1', 'chap-fe1-05-the-css-box-model-and-basic-page-flow', 'Chapter 5: The CSS Box Model and Basic Page Flow', 'Understand how every element is a box and control spacing and sizing.', 5, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-5-1', 'chap-fe1-05', 'fe1-5-1-the-box-model-concept', 1, '5.1: The Box Model Concept', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-1', 'fe1-5-1', 'dialogue', 1, '{"shady": "Why is there space around my elements that I didn’t expect?", "cody": "Because every HTML element is a rectangular box with several layers. Welcome to the box model!"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-2', 'fe1-5-1', 'text', 2, '{"title": "Learn", "body": "Every element generates a box that consists of:<br><br>1. <strong>Content</strong> — the text or image itself  \\n2. <strong>Padding</strong> — space between the content and the border  \\n3. <strong>Border</strong> — the line around the padding  \\n4. <strong>Margin</strong> — space outside the border (separates elements from each other)<br><br><pre><code>.box {\\n  width: 200px;\\n  padding: 20px;\\n  border: 3px solid black;\\n  margin: 15px;\\n}\\n</code></pre><br><br>Understanding the box model is the key to controlling layout and spacing at Level 1."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-3', 'fe1-5-1', 'text', 3, '{"title": "Example", "body": "A visible box with background, padding, border, and margin so the student can see each part."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-4', 'fe1-5-1', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-5', 'fe1-5-1', 'quick_check', 5, '{"title": "Quick Check", "question": "Which part of the box model is the space *outside* the border?", "options": {"A": "Padding", "B": "Margin", "C": "Content"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-6', 'fe1-5-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Make a box that has different padding and margin values and observe the difference."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-7', 'fe1-5-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Draw (or describe) the box model and create one styled box that clearly shows all four parts."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-1-8', 'fe1-5-1', 'key_points', 8, '{"title": "Key Points", "points": ["Every element is a box.", "Content + padding + border + margin.", "Padding is inside, margin is outside.", "Mastering the box model unlocks layout control."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-5-2', 'chap-fe1-05', 'fe1-5-2-padding-border-and-margin-in-practi', 2, '5.2: Padding, Border, and Margin in Practice', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-1', 'fe1-5-2', 'dialogue', 1, '{"shady": "How do I write the values for padding and margin?", "cody": "You can set all sides at once or control each side individually."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-2', 'fe1-5-2', 'text', 2, '{"title": "Learn", "body": "<pre><code>.card {\\n  padding: 20px;                  /* all four sides */\\n  padding: 10px 20px;             /* top/bottom | left/right */\\n  padding: 10px 15px 20px 25px;   /* top | right | bottom | left */<br><br>  margin: 15px;\\n  margin-top: 30px;<br><br>  border: 2px solid #333;\\n  border-radius: 8px;             /* rounded corners (bonus) */\\n}\\n</code></pre><br><br>You can also set individual sides:  \\n`padding-top`, `margin-left`, `border-bottom`, etc."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-3', 'fe1-5-2', 'text', 3, '{"title": "Example", "body": "A card-style box with comfortable padding and a subtle border."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-4', 'fe1-5-2', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-5', 'fe1-5-2', 'quick_check', 5, '{"title": "Quick Check", "question": "If you write `padding: 10px 20px;`, what does the 20px control?", "options": {"A": "Top and bottom", "B": "Left and right", "C": "All four sides"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-6', 'fe1-5-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create two boxes that are separated by margin and each have internal padding."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-7', 'fe1-5-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a simple “card” component using padding, border, and margin."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-2-8', 'fe1-5-2', 'key_points', 8, '{"title": "Key Points", "points": ["Padding adds space inside the border.", "Margin adds space outside the border.", "Border draws the edge.", "Shorthand values save time."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-5-3', 'chap-fe1-05', 'fe1-5-3-width-height-and-box-sizing', 3, '5.3: Width, Height, and box-sizing', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-1', 'fe1-5-3', 'dialogue', 1, '{"shady": "I set width to 200px but the box looks wider. Why?", "cody": "Because by default padding and border are added on top of the width. Let’s fix that understanding."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-2', 'fe1-5-3', 'text', 2, '{"title": "Learn", "body": "<pre><code>.box {\\n  width: 200px;\\n  height: 100px;\\n  padding: 20px;\\n  border: 5px solid black;\\n}\\n</code></pre><br><br>By default (`box-sizing: content-box`):  \\nFinal size = width + padding + border  <br><br>Modern best practice:\\n<pre><code>* {\\n  box-sizing: border-box;\\n}\\n</code></pre><br><br>With `border-box`, the declared width includes padding and border, which makes sizing much more predictable.<br><br>For Level 1 it is enough to know:  \\n- You can set `width` and `height`  \\n- Padding and border affect the final size  \\n- `box-sizing: border-box` is a helpful habit"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-3', 'fe1-5-3', 'text', 3, '{"title": "Example", "body": "Two side-by-side boxes demonstrating the difference (conceptually)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-4', 'fe1-5-3', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-5', 'fe1-5-3', 'quick_check', 5, '{"title": "Quick Check", "question": "Which property helps make width calculations more intuitive by including padding and border?", "options": {"A": "`box-sizing: content-box`", "B": "`box-sizing: border-box`", "C": "`display: block`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-6', 'fe1-5-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a box that is exactly 300px wide including its padding and border."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-7', 'fe1-5-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Apply consistent widths and comfortable padding to the main sections of one of your pages."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-3-8', 'fe1-5-3', 'key_points', 8, '{"title": "Key Points", "points": ["You can set width and height.", "Default box model adds padding and border outside the width.", "`border-box` makes sizing easier.", "Use it as a good habit."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-5-4', 'chap-fe1-05', 'fe1-5-4-block-vs-inline-elements', 4, '5.4: Block vs Inline Elements', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-1', 'fe1-5-4', 'dialogue', 1, '{"shady": "Why do some elements start on a new line while others sit next to each other?", "cody": "Because some elements are block-level and others are inline. This is the foundation of page flow."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-2', 'fe1-5-4', 'text', 2, '{"title": "Learn", "body": "<strong>Block-level elements</strong> (examples: `<h1>`, `<p>`, `<div>`, `<ul>`, `<li>`, `<section>`):  \\n- Start on a new line  \\n- Take up the full available width by default  \\n- You can set width, height, margin, and padding freely  <br><br><strong>Inline elements</strong> (examples: `<a>`, `<span>`, `<strong>`, `<em>`, `<img>`):  \\n- Sit within a line of text  \\n- Only take up as much width as their content needs  \\n- Top and bottom margins do not push other elements the same way  <br><br>You can change the behavior with the `display` property (for example `display: inline-block`), but for Level 1 it is enough to recognize the default behavior."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-3', 'fe1-5-4', 'text', 3, '{"title": "Example", "body": "A paragraph that contains a link and a strong element — the link and strong stay on the same line as the text."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-4', 'fe1-5-4', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-5', 'fe1-5-4', 'quick_check', 5, '{"title": "Quick Check", "question": "Which type of element starts on a new line and takes full width by default?", "options": {"A": "Inline", "B": "Block", "C": "Neither"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-6', 'fe1-5-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Wrap a few words inside a paragraph with `<span class=\\"highlight\\">` and style only those words."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-7', 'fe1-5-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Build a short page that intentionally mixes block and inline elements and explain the flow you observe."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-4-8', 'fe1-5-4', 'key_points', 8, '{"title": "Key Points", "points": ["Block elements stack vertically and take full width.", "Inline elements sit within a line.", "Understanding flow is essential before learning advanced layout.", "Flexbox and Grid come in Level 2."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('fe1-5-5', 'chap-fe1-05', 'fe1-5-5-putting-spacing-and-flow-together', 5, '5.5: Putting Spacing and Flow Together', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-1', 'fe1-5-5', 'dialogue', 1, '{"shady": "I know the individual pieces. How do I make a whole page that looks tidy?", "cody": "By combining structure, the box model, and consistent spacing. Let’s practice."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-2', 'fe1-5-5', 'text', 2, '{"title": "Learn", "body": "Practical checklist for a clean Level 1 page:  \\n1. Solid HTML structure and hierarchy  \\n2. External (or internal) CSS with clear selectors  \\n3. Readable typography  \\n4. Consistent padding and margin  \\n5. Visible but not excessive borders if needed  \\n6. Good contrast between text and background  <br><br>Avoid:  \\n- Random spacing values  \\n- Overlapping elements  \\n- Text that is too close to the edges"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-3', 'fe1-5-5', 'text', 3, '{"title": "Example", "body": "A simple profile-style page with header, about section, skills list, and footer — all properly spaced."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-4', 'fe1-5-5', 'html_css_playground', 4, '{"html": "<!DOCTYPE html>\\n<html>\\n<head><title>Practice</title></head>\\n<body>\\n  <h1>Hello</h1>\\n  <p>Edit me!</p>\\n</body>\\n</html>", "css": "body { font-family: sans-serif; }", "instructions": "Edit the HTML and CSS. The live preview updates with your code.", "external_resource_title": "Try More Code", "external_resource_description": "Experiment in a free online HTML/CSS editor", "external_resource_target": "https://codepen.io/pen/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-5', 'fe1-5-5', 'quick_check', 5, '{"title": "Quick Check", "question": "What is a good general approach to spacing on a page?", "options": {"A": "Use random large numbers", "B": "Apply consistent padding and margin so content has room to breathe", "C": "Remove all margin and padding"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-6', 'fe1-5-5', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a “card” that contains a heading, a short paragraph, and a list, all comfortably spaced."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-7', 'fe1-5-5', 'mission', 7, '{"title": "Lesson Mission", "body": "Polish one complete page so it feels organized and pleasant to read."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-fe1-5-5-8', 'fe1-5-5', 'key_points', 8, '{"title": "Key Points", "points": ["Combine structure + box model + typography.", "Consistency looks professional.", "Leave breathing room around content.", "You now have the tools for solid Level 1 pages."]}');

-- ===== JavaScript — Level 1 (6 chapters) =====
-- Clear existing chapters/lessons for course-javascript-level-1 (safe rebuild)
DELETE lb FROM lesson_blocks lb INNER JOIN lessons l ON lb.lesson_id=l.id INNER JOIN chapters ch ON l.chapter_id=ch.id WHERE ch.course_id='course-javascript-level-1';
DELETE lp FROM lesson_progress lp INNER JOIN lessons l ON lp.lesson_id=l.id INNER JOIN chapters ch ON l.chapter_id=ch.id WHERE ch.course_id='course-javascript-level-1';
DELETE FROM lessons WHERE chapter_id IN (SELECT id FROM chapters WHERE course_id='course-javascript-level-1');
DELETE FROM chapters WHERE course_id='course-javascript-level-1';
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-js1-01', 'course-javascript-level-1', 'chap-js1-01-1-getting-started-with-javascript', 'Chapter 1: Getting Started with JavaScript', 'Understand what JavaScript is, where it runs, and write your first statements.', 1, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-1-1', 'chap-js1-01', 'js1-1-1-what-is-javascript', 1, '1.1: What Is JavaScript?', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-1', 'js1-1-1', 'dialogue', 1, '{"shady": "Cody, I keep hearing people say “JavaScript makes websites come alive.” Is it the same as Java?", "cody": "Great question! JavaScript and Java are completely different languages. JavaScript is the language that runs inside web browsers and adds behavior to web pages. Let’s explore what that really means."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-2', 'js1-1-1', 'text', 2, '{"title": "Learn", "body": "JavaScript is a <strong>programming language<strong> created to make web pages interactive.  <br><br>When you visit a website you usually see three layers:  \\n- <strong>HTML<strong> → structure and content (the skeleton)  \\n- <strong>CSS<strong> → appearance and layout (the look)  \\n- <strong>JavaScript<strong> → behavior and interactivity (the actions)<br><br>JavaScript can:  \\n- Respond when a user clicks a button  \\n- Show or hide content  \\n- Calculate values  \\n- Update text on the page  \\n- Validate forms  <br><br>Important facts for beginners:  \\n- JavaScript was invented in 1995 by Brendan Eich.  \\n- It runs directly in the browser — you do not need to install extra software to try it.  \\n- It is one of the most popular programming languages in the world.  \\n- Many modern websites use HTML, CSS, and JavaScript together, but not every webpage *requires* JavaScript.<br><br>JavaScript is <strong>not<strong> the same as Java. They share a similar name for historical reasons, but their syntax and purpose are different."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-3', 'js1-1-1', 'text', 3, '{"title": "Example", "body": "Imagine a simple webpage with a button that says “Say Hello”.  <br>When you click the button, a message appears: “Hello, Code Orbit!”.  <br>That click-and-respond behavior is powered by JavaScript."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-4', 'js1-1-1', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-5', 'js1-1-1', 'quick_check', 5, '{"title": "Quick Check", "question": "What is the main job of JavaScript on a webpage?", "options": {"A": "To describe the structure of the page", "B": "To style the colors and fonts", "C": "To add behavior and interactivity", "D": "To store files on a server"}, "correct": "C", "explanation": "JavaScript is the language that makes pages respond to users and perform actions."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-6', 'js1-1-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "In the console, type a message that includes your name using `console.log`."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-7', 'js1-1-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Explain to a friend (or write in your notes) what JavaScript does and how it is different from HTML and CSS."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-1-8', 'js1-1-1', 'key_points', 8, '{"title": "Key Points", "points": ["JavaScript is a programming language that adds behavior to web pages.", "It works together with HTML and CSS.", "It runs inside the browser.", "It is not the same as Java."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-1-2', 'chap-js1-01', 'js1-1-2-where-javascript-runs', 2, '1.2: Where JavaScript Runs', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-1', 'js1-1-2', 'dialogue', 1, '{"shady": "So if I write JavaScript, where does the computer actually run it?", "cody": "Excellent question! The most important place for beginners is the web browser. Let’s see how that works."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-2', 'js1-1-2', 'text', 2, '{"title": "Learn", "body": "JavaScript can run in several places, but for this Level 1 course we focus on the <strong>browser<strong>.<br><br><strong>1. Inside the Web Browser<strong>  \\nEvery modern browser (Chrome, Firefox, Edge, Safari) contains a JavaScript engine.  \\nWhen the browser loads a webpage that contains JavaScript, the engine reads and executes the code.<br><br><strong>2. Browser Developer Console<strong>  \\nYou can also type JavaScript directly into the Console and see results immediately. This is perfect for learning and testing small pieces of code.<br><br><strong>3. Other environments (just for awareness)<strong>  \\n- Node.js allows JavaScript to run on servers (outside the browser).  \\n- Some mobile apps and desktop apps also use JavaScript.  <br><br>In this course we stay inside the browser and the Code Orbit playground. You do not need Node.js yet."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-3', 'js1-1-2', 'text', 3, '{"title": "Example", "body": "When you open a webpage and the page shows a live clock or a button that changes color, that JavaScript is running inside your browser’s JavaScript engine."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-4', 'js1-1-2', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-5', 'js1-1-2', 'quick_check', 5, '{"title": "Quick Check", "question": "Which tool lets you type and run JavaScript immediately without creating a file?", "options": {"A": "The browser Developer Console", "B": "A text editor only", "C": "A printer"}, "correct": "A", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-6', 'js1-1-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "In the console, run:  <br>```javascript<br>console.log(2 + 3);<br>```  <br>Confirm you see the number 5."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-7', 'js1-1-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Write one sentence explaining where JavaScript runs when you visit a normal website."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-2-8', 'js1-1-2', 'key_points', 8, '{"title": "Key Points", "points": ["JavaScript primarily runs inside the browser.", "The Developer Console is a great place to experiment.", "Node.js and other environments exist but are not required for Level 1."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-1-3', 'chap-js1-01', 'js1-1-3-your-first-javascript-statements', 3, '1.3: Your First JavaScript Statements', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-1', 'js1-1-3', 'dialogue', 1, '{"shady": "I’m ready to write real code! What’s the simplest thing I can type?", "cody": "Let’s start with the classic first statement — telling the computer to print a message."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-2', 'js1-1-3', 'text', 2, '{"title": "Learn", "body": "A <strong>statement<strong> is a complete instruction that JavaScript can execute.  <br><br>The simplest useful statement is:<br><br><pre><code>console.log(\\"Hello, Code Orbit!\\");\\n</code></pre><br><br>- `console` is an object provided by the browser.  \\n- `.log()` is a method that prints a value to the console.  \\n- The text inside the quotes is a <strong>string<strong>.  \\n- The semicolon `;` marks the end of the statement (optional in many cases, but good practice).<br><br>You can also print numbers and results of calculations:<br><br><pre><code>console.log(42);\\nconsole.log(10 + 5);\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-3', 'js1-1-3', 'code_example', 3, '{"language": "javascript", "code": "console.log(\\"Welcome to SPS Code Orbit\\");\\nconsole.log(2026);\\nconsole.log(\\"2 + 2 =\\", 2 + 2);", "explanation": "**Expected output:**"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-4', 'js1-1-3', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "**", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-5', 'js1-1-3', 'quick_check', 5, '{"title": "Quick Check", "question": "What does `console.log(\\"Hi\\")` do?", "options": {"A": "Saves a file named Hi", "B": "Prints the text Hi to the console", "C": "Deletes the console"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-6', 'js1-1-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Print the message: `I am learning JavaScript!` and also print the number of letters in the word “JavaScript” (which is 10)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-7', 'js1-1-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a short “About Me” output using three `console.log` statements."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-3-8', 'js1-1-3', 'key_points', 8, '{"title": "Key Points", "points": ["A statement is a complete instruction.", "`console.log()` prints values to the console.", "Strings need quotes.", "You can print numbers and calculations too."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-1-4', 'chap-js1-01', 'js1-1-4-comments-and-basic-syntax', 4, '1.4: Comments and Basic Syntax', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-1', 'js1-1-4', 'dialogue', 1, '{"shady": "Sometimes I write a note to myself in code and the program breaks. Why?", "cody": "Because the computer tries to run everything unless you mark it as a comment. Let’s learn how to write notes safely."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-2', 'js1-1-4', 'text', 2, '{"title": "Learn", "body": "<strong>Comments<strong> are text that JavaScript ignores. They are for humans only.<br><br><strong>Single-line comment:<strong>\\n<pre><code>// This is a single-line comment\\nconsole.log(\\"This still runs\\");\\n</code></pre><br><br><strong>Multi-line comment:<strong>\\n<pre><code>/*\\n  This is a multi-line comment.\\n  It can span several lines.\\n*/\\nconsole.log(\\"Still running!\\");\\n</code></pre><br><br><strong>Basic syntax rules for Level 1:<strong>  \\n- Statements usually end with a semicolon `;`  \\n- JavaScript is <strong>case-sensitive<strong> (`Console` is different from `console`)  \\n- Strings can use double quotes `\\" \\"` or single quotes `'' ''`  \\n- Indentation (spaces) helps humans read the code but does not change how it runs  \\n- Extra spaces around operators are usually fine"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-3', 'js1-1-4', 'code_example', 3, '{"language": "javascript", "code": "// Print a greeting\\nconsole.log(\\"Hello!\\");\\n\\n/*\\n  Calculate a simple sum\\n  and show the result\\n*/\\nconsole.log(5 + 3);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-4', 'js1-1-4', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-5', 'js1-1-4', 'quick_check', 5, '{"title": "Quick Check", "question": "What happens to text written after `//` on the same line?", "options": {"A": "It is executed as code", "B": "It is ignored by JavaScript", "C": "It causes an error"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-6', 'js1-1-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write a short program that prints “Comments are helpful” and includes both a single-line and a multi-line comment."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-7', 'js1-1-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Take any previous `console.log` program and add clear comments explaining each line."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-4-8', 'js1-1-4', 'key_points', 8, '{"title": "Key Points", "points": ["`//` starts a single-line comment.", "`/* */` creates a multi-line comment.", "Comments are ignored by the computer.", "JavaScript is case-sensitive."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-1-5', 'chap-js1-01', 'js1-1-5-running-code-and-reading-output', 5, '1.5: Running Code and Reading Output', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-1', 'js1-1-5', 'dialogue', 1, '{"shady": "Sometimes my code works, sometimes I get a red message. How do I know what went wrong?", "cody": "Reading the output and the error messages is a superpower. Let’s practice."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-2', 'js1-1-5', 'text', 2, '{"title": "Learn", "body": "When you run JavaScript:  \\n1. The code is executed from top to bottom.  \\n2. Successful `console.log` statements appear in the output area.  \\n3. If there is a <strong>syntax error<strong>, the program stops and shows a red error message.<br><br>Common beginner errors:  \\n- Missing closing quote: `\\"Hello`  \\n- Misspelled keyword: `consol.log`  \\n- Using the wrong quotes or brackets  <br><br>Always read the error message carefully — it often tells you the line number and the problem."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-3', 'js1-1-5', 'code_example', 3, '{"language": "javascript", "code": "console.log(\\"All good\\");", "explanation": "Correct code:\\n\\nOutput: `All good`\\n\\nBroken code:\\n\\nError: something like `Uncaught SyntaxError: Invalid or unexpected token`"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-4', 'js1-1-5', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-5', 'js1-1-5', 'quick_check', 5, '{"title": "Quick Check", "question": "What should you do first when you see a red error message?", "options": {"A": "Delete all the code", "B": "Read the error message and check the line number", "C": "Restart the computer"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-6', 'js1-1-5', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write a program that prints two lines. Then deliberately break one line and fix it again."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-7', 'js1-1-5', 'mission', 7, '{"title": "Lesson Mission", "body": "Run three different statements and write down what each output looks like."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-1-5-8', 'js1-1-5', 'key_points', 8, '{"title": "Key Points", "points": ["Code runs from top to bottom.", "Successful output appears in the console.", "Error messages help you find mistakes.", "Always read the error carefully."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-js1-02', 'course-javascript-level-1', 'chap-js1-02-2-variables-and-data-types', 'Chapter 2: Variables and Data Types', 'Store and work with different kinds of data using variables.', 2, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-2-1', 'chap-js1-02', 'js1-2-1-introducing-variables-with-let-and', 1, '2.1: Introducing Variables with let and const', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-1', 'js1-2-1', 'dialogue', 1, '{"shady": "I want to remember a score or a name so I can use it later. Do I have to type the value every time?", "cody": "No! We use **variables** — named containers that hold values."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-2', 'js1-2-1', 'text', 2, '{"title": "Learn", "body": "A <strong>variable<strong> is a named place in memory that stores a value.<br><br><strong>Declaring with `let`<strong> (value can change later):\\n<pre><code>let score = 10;\\nconsole.log(score);   // 10\\nscore = 15;\\nconsole.log(score);   // 15\\n</code></pre><br><br><strong>Declaring with `const`<strong> (value cannot be reassigned):\\n<pre><code>const name = \\"Shady\\";\\nconsole.log(name);    // Shady\\n// name = \\"Cody\\";    // This would cause an error\\n</code></pre><br><br><strong>Rules:<strong>  \\n- Use `const` when the value should not change.  \\n- Use `let` when you need to update the value.  \\n- Always declare a variable before using it.  \\n- Variable names should be descriptive."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-3', 'js1-2-1', 'code_example', 3, '{"language": "javascript", "code": "let lives = 3;\\nconst playerName = \\"Shady\\";\\n\\nconsole.log(playerName);\\nconsole.log(lives);\\n\\nlives = lives - 1;\\nconsole.log(lives);", "explanation": "**Expected output:**"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-4', 'js1-2-1', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-5', 'js1-2-1', 'quick_check', 5, '{"title": "Quick Check", "question": "Which keyword should you use if the value must never change?", "options": {"A": "`let`", "B": "`const`", "C": "`var`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-6', 'js1-2-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Declare a `const` for your name and a `let` for your current level. Print a message that uses both."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-7', 'js1-2-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Write a short program that stores your name (`const`) and a changing score (`let`)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-1-8', 'js1-2-1', 'key_points', 8, '{"title": "Key Points", "points": ["`let` allows reassignment.", "`const` does not allow reassignment.", "Variables store values for later use.", "Choose meaningful names."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-2-2', 'chap-js1-02', 'js1-2-2-variable-naming-rules', 2, '2.2: Variable Naming Rules', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-1', 'js1-2-2', 'dialogue', 1, '{"shady": "Can I name a variable `2score` or `my-score`?", "cody": "Some names are allowed by the language, some are not, and some are allowed but not recommended. Let’s learn the rules."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-2', 'js1-2-2', 'text', 2, '{"title": "Learn", "body": "<strong>Valid variable names:<strong>  \\n- Can contain letters, digits, `$`, and `_`  \\n- Cannot start with a digit  \\n- Cannot contain spaces or hyphens  \\n- Are case-sensitive (`score` and `Score` are different)<br><br><strong>Good naming conventions (camelCase):<strong>  \\n<pre><code>let playerScore = 0;\\nconst maxLives = 3;\\nlet isGameOver = false;\\n</code></pre><br><br><strong>Avoid:<strong>  \\n- Single letters unless the meaning is obvious (e.g., `i` in a loop)  \\n- Reserved words such as `let`, `const`, `if`, `function`  \\n- Names that do not describe the data"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-3', 'js1-2-2', 'code_example', 3, '{"language": "javascript", "code": "// Good\\nlet userName = \\"Shady\\";\\nconst MAX_SCORE = 100;\\n\\n// Bad (will cause errors or confusion)\\n// let 2ndPlace = \\"silver\\";   // starts with digit\\n// let user-name = \\"Shady\\";   // hyphen not allowed", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-4', 'js1-2-2', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-5', 'js1-2-2', 'quick_check', 5, '{"title": "Quick Check", "question": "Which variable name is valid?", "options": {"A": "`2score`", "B": "`player-score`", "C": "`playerScore`"}, "correct": "C", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-6', 'js1-2-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create three well-named variables related to a game and print them."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-7', 'js1-2-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Review any previous code and improve the variable names if needed."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-2-8', 'js1-2-2', 'key_points', 8, '{"title": "Key Points", "points": ["Names cannot start with a number.", "No spaces or hyphens.", "Use camelCase for readability.", "Choose descriptive names."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-2-3', 'chap-js1-02', 'js1-2-3-strings-and-template-literals', 3, '2.3: Strings and Template Literals', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-1', 'js1-2-3', 'dialogue', 1, '{"shady": "I want to say “Hello, Shady!” but the name is stored in a variable. How do I combine them?", "cody": "Classic strings work, but template literals make it much cleaner. Let’s see both ways."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-2', 'js1-2-3', 'text', 2, '{"title": "Learn", "body": "A <strong>string<strong> is text data.<br><br><pre><code>let greeting = \\"Hello\\";\\nlet name = ''Shady'';\\n</code></pre><br><br><strong>Concatenation (older way):<strong>\\n<pre><code>console.log(greeting + \\", \\" + name + \\"!\\");\\n</code></pre><br><br><strong>Template literals (modern and preferred):<strong>  \\nUse backticks `` ` `` and `${ }` to insert variables:<br><br><pre><code>console.log(`${greeting}, ${name}!`);\\n</code></pre><br><br>Template literals can also span multiple lines and include expressions:<br><br><pre><code>let score = 42;\\nconsole.log(`Your score is ${score + 8}`);\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-3', 'js1-2-3', 'code_example', 3, '{"language": "javascript", "code": "const student = \\"Shady\\";\\nconst course = \\"JavaScript Level 1\\";\\nconst message = `Welcome ${student} to ${course}!`;\\nconsole.log(message);", "explanation": "**Expected output:**  \\n`Welcome Shady to JavaScript Level 1!`"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-4', 'js1-2-3', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-5', 'js1-2-3', 'quick_check', 5, '{"title": "Quick Check", "question": "Which character starts a template literal?", "options": {"A": "Double quote `\\"`", "B": "Single quote `''`", "C": "Backtick `` ` ``"}, "correct": "C", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-6', 'js1-2-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a multi-line template literal that introduces yourself (name + favorite language)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-7', 'js1-2-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Write a short introduction message about yourself using a template literal."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-3-8', 'js1-2-3', 'key_points', 8, '{"title": "Key Points", "points": ["Strings hold text.", "Template literals use backticks.", "`${}` inserts values or expressions.", "Template literals are cleaner than `+` concatenation."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-2-4', 'chap-js1-02', 'js1-2-4-numbers-booleans-null-and-undefined', 4, '2.4: Numbers, Booleans, null and undefined', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-1', 'js1-2-4', 'dialogue', 1, '{"shady": "So far I only used text and numbers. Are there other kinds of values?", "cody": "Yes! Let’s meet the most important data types you will use every day."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-2', 'js1-2-4', 'text', 2, '{"title": "Learn", "body": "<strong>Number<strong> — integers or decimals  \\n<pre><code>let score = 100;\\nlet temperature = 36.6;\\n</code></pre><br><br><strong>Boolean<strong> — only two values: `true` or `false`  \\n<pre><code>let isLoggedIn = true;\\nlet hasKey = false;\\n</code></pre><br><br><strong>null<strong> — intentional empty value  \\n<pre><code>let selectedItem = null;\\n</code></pre><br><br><strong>undefined<strong> — a variable has been declared but not given a value yet  \\n<pre><code>let futureScore;\\nconsole.log(futureScore);  // undefined\\n</code></pre><br><br><strong>typeof operator<strong> — tells you the type of a value  \\n<pre><code>console.log(typeof 42);          // \\"number\\"\\nconsole.log(typeof \\"hello\\");     // \\"string\\"\\nconsole.log(typeof true);        // \\"boolean\\"\\nconsole.log(typeof null);        // \\"object\\" (historical quirk)\\nconsole.log(typeof undefined);   // \\"undefined\\"\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-3', 'js1-2-4', 'code_example', 3, '{"language": "javascript", "code": "const name = \\"Shady\\";\\nlet lives = 3;\\nlet isAlive = true;\\nlet powerUp = null;\\n\\nconsole.log(typeof name);\\nconsole.log(typeof lives);\\nconsole.log(typeof isAlive);\\nconsole.log(powerUp);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-4', 'js1-2-4', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-5', 'js1-2-4', 'quick_check', 5, '{"title": "Quick Check", "question": "What is the value of a variable that has been declared but not assigned?", "options": {"A": "`null`", "B": "`undefined`", "C": "`0`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-6', 'js1-2-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a small “player status” using all four types and print them with labels."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-7', 'js1-2-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Write a program that stores and prints one example of each data type you learned."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-4-8', 'js1-2-4', 'key_points', 8, '{"title": "Key Points", "points": ["Numbers, strings, and booleans are the most common types.", "`null` means intentionally empty.", "`undefined` means not yet assigned.", "Use `typeof` to inspect a value’s type."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-2-5', 'chap-js1-02', 'js1-2-5-changing-variables-and-simple-debug', 5, '2.5: Changing Variables and Simple Debugging', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-1', 'js1-2-5', 'dialogue', 1, '{"shady": "I tried to change a `const` and everything broke! Also sometimes I misspell a variable name.", "cody": "Perfect time to practice safe updating and basic debugging."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-2', 'js1-2-5', 'text', 2, '{"title": "Learn", "body": "You can change a `let` variable as many times as you need:<br><br><pre><code>let counter = 0;\\ncounter = counter + 1;\\ncounter += 1;          // shorter way\\nconsole.log(counter);  // 2\\n</code></pre><br><br><strong>Common mistakes and how to fix them:<strong>  \\n1. Reassigning a `const` → use `let` instead if you need to change it.  \\n2. Using a variable before declaring it → declare first.  \\n3. Misspelling the variable name → JavaScript treats it as a new (undefined) variable.  \\n4. Forgetting quotes around strings → causes syntax errors."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-3', 'js1-2-5', 'code_playground', 3, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-4', 'js1-2-5', 'quick_check', 4, '{"title": "Quick Check", "question": "What happens if you try to reassign a variable declared with `const`?", "options": {"A": "It changes silently", "B": "You get an error", "C": "It becomes undefined"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-5', 'js1-2-5', 'challenge', 5, '{"title": "Tiny Challenge", "body": "Create a score that starts at 0, adds 10, then multiplies by 2. Print the final result. Include at least one comment."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-6', 'js1-2-5', 'mission', 6, '{"title": "Lesson Mission", "body": "Write a small “lives counter” that starts at 3 and loses one life, then prints the remaining lives. Add comments."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-2-5-7', 'js1-2-5', 'key_points', 7, '{"title": "Key Points", "points": ["Only `let` variables can be reassigned.", "Always declare before use.", "Spelling matters.", "Read error messages carefully."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-js1-03', 'course-javascript-level-1', 'chap-js1-03-3-operators-and-expressions', 'Chapter 3: Operators and Expressions', 'Combine values and make comparisons using operators.', 3, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-3-1', 'chap-js1-03', 'js1-3-1-arithmetic-operators', 1, '3.1: Arithmetic Operators', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-1', 'js1-3-1', 'dialogue', 1, '{"shady": "Can JavaScript do math for me?", "cody": "Absolutely! Let’s meet the arithmetic operators."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-2', 'js1-3-1', 'text', 2, '{"title": "Learn", "body": "<pre><code>console.log(10 + 3);   // 13  addition\\nconsole.log(10 - 3);   // 7   subtraction\\nconsole.log(10 * 3);   // 30  multiplication\\nconsole.log(10 / 3);   // 3.333... division\\nconsole.log(10 % 3);   // 1   remainder (modulo)\\n</code></pre><br><br>An <strong>expression<strong> is any valid combination of values and operators that produces a result.<br><br><pre><code>let total = 5 + 3 * 2;   // 11 (multiplication first)\\n</code></pre><br><br>You can store the result of an expression in a variable."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-3', 'js1-3-1', 'code_example', 3, '{"language": "javascript", "code": "let a = 8;\\nlet b = 3;\\nconsole.log(a + b);\\nconsole.log(a % b);\\nconsole.log((a + b) * 2);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-4', 'js1-3-1', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-5', 'js1-3-1', 'quick_check', 5, '{"title": "Quick Check", "question": "What does the `%` operator return?", "options": {"A": "Percentage", "B": "The remainder after division", "C": "The average"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-6', 'js1-3-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write an expression that calculates how many full weeks are in 30 days and how many days are left over."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-7', 'js1-3-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Create three useful calculations related to a game (score, lives, time) and print the results."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-1-8', 'js1-3-1', 'key_points', 8, '{"title": "Key Points", "points": ["`+ - * / %` are the basic arithmetic operators.", "Expressions produce values.", "Operator precedence: `*` and `/` before `+` and `-` (use parentheses to control order)."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-3-2', 'chap-js1-03', 'js1-3-2-assignment-operators', 2, '3.2: Assignment Operators', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-1', 'js1-3-2', 'dialogue', 1, '{"shady": "Writing `score = score + 10` every time feels long. Is there a shorter way?", "cody": "Yes — assignment operators!"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-2', 'js1-3-2', 'text', 2, '{"title": "Learn", "body": "<pre><code>let score = 10;<br><br>score += 5;   // same as score = score + 5\\nscore -= 2;   // score = score - 2\\nscore *= 2;   // score = score * 2\\nscore /= 3;   // score = score / 3\\n</code></pre><br><br>These operators update the variable in place."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-3', 'js1-3-2', 'code_example', 3, '{"language": "javascript", "code": "let points = 0;\\npoints += 10;\\npoints += 5;\\npoints *= 2;\\nconsole.log(points);  // 30", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-4', 'js1-3-2', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-5', 'js1-3-2', 'quick_check', 5, '{"title": "Quick Check", "question": "What does `x += 3` mean?", "options": {"A": "x is equal to 3", "B": "Add 3 to the current value of x", "C": "Multiply x by 3"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-6', 'js1-3-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Simulate a simple bank balance that starts at 100, adds 50, then subtracts 30 using only assignment operators."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-7', 'js1-3-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Write a short “score tracker” using at least three different assignment operators."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-2-8', 'js1-3-2', 'key_points', 8, '{"title": "Key Points", "points": ["Assignment operators update a variable.", "`+=`, `-=`, `*=`, `/=` are the most common.", "They make code shorter and clearer."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-3-3', 'chap-js1-03', 'js1-3-3-comparison-operators-and-strict-equ', 3, '3.3: Comparison Operators and Strict Equality', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-1', 'js1-3-3', 'dialogue', 1, '{"shady": "How does the computer know if two things are equal or if one number is bigger?", "cody": "With comparison operators! And in modern JavaScript we prefer strict equality."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-2', 'js1-3-3', 'text', 2, '{"title": "Learn", "body": "<pre><code>console.log(5 === 5);    // true   strict equality\\nconsole.log(5 === \\"5\\");  // false  different types\\nconsole.log(5 !== 3);    // true   not equal\\nconsole.log(10 > 5);     // true\\nconsole.log(10 < 5);     // false\\nconsole.log(10 >= 10);   // true\\nconsole.log(10 <= 9);    // false\\n</code></pre><br><br><strong>Why `===` instead of `==`?<strong>  \\n`==` tries to convert types (can cause surprises).  \\n`===` checks both value and type — safer for beginners and professionals.<br><br>Always prefer `===` and `!==` in this course."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-3', 'js1-3-3', 'code_example', 3, '{"language": "javascript", "code": "const age = 15;\\nconsole.log(age >= 13);     // true\\nconsole.log(age === \\"15\\");  // false", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-4', 'js1-3-3', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-5', 'js1-3-3', 'quick_check', 5, '{"title": "Quick Check", "question": "What is the safest way to check if two values are equal in modern JavaScript?", "options": {"A": "`==`", "B": "`===`", "C": "`=`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-6', 'js1-3-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Store a temperature and print whether it is above freezing (`> 0`)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-7', 'js1-3-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Write five different comparisons related to a game (score, lives, level) and print the boolean results."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-3-8', 'js1-3-3', 'key_points', 8, '{"title": "Key Points", "points": ["Comparison operators return `true` or `false`.", "Prefer `===` and `!==`.", "`>`, `<`, `>=`, `<=` compare numbers (and some other types)."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-3-4', 'chap-js1-03', 'js1-3-4-building-useful-expressions', 4, '3.4: Building Useful Expressions', 10, 20, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-1', 'js1-3-4', 'dialogue', 1, '{"shady": "Now I know the operators, but how do I put them together for real problems?", "cody": "Let’s build practical expressions step by step."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-2', 'js1-3-4', 'text', 2, '{"title": "Learn", "body": "Expressions can mix variables, numbers, and operators:<br><br><pre><code>let price = 50;\\nlet tax = 0.1;\\nlet total = price + (price * tax);\\nconsole.log(total);  // 55\\n</code></pre><br><br>You can also combine comparisons with arithmetic:<br><br><pre><code>let score = 85;\\nlet passed = score >= 60;\\nconsole.log(passed);  // true\\n</code></pre><br><br>Parentheses control the order of operations — use them freely for clarity."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-3', 'js1-3-4', 'code_example', 3, '{"language": "javascript", "code": "const width = 10;\\nconst height = 5;\\nconst area = width * height;\\nconst perimeter = 2 * (width + height);\\nconsole.log(`Area: ${area}, Perimeter: ${perimeter}`);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-4', 'js1-3-4', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-5', 'js1-3-4', 'quick_check', 5, '{"title": "Quick Check", "question": "Why are parentheses useful in expressions?", "options": {"A": "They are required for every calculation", "B": "They control the order of operations and improve readability", "C": "They convert numbers to strings"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-6', 'js1-3-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a simple “discount calculator”: original price 100, discount 20%. Print the final price."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-7', 'js1-3-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Invent a small real-world calculation (shopping, game score, time) using at least three operators and print a clear message with a template literal."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-3-4-8', 'js1-3-4', 'key_points', 8, '{"title": "Key Points", "points": ["Expressions combine values and operators.", "Store results in variables when useful.", "Use parentheses for clarity and correct order.", "Template literals help present results nicely."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-js1-04', 'course-javascript-level-1', 'chap-js1-04-4-decisions-and-functions', 'Chapter 4: Decisions and Functions', 'Make decisions with conditions and organize code with functions.', 4, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-4-1', 'chap-js1-04', 'js1-4-1-making-decisions-with-if-and-else', 1, '4.1: Making Decisions with if and else', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-1', 'js1-4-1', 'dialogue', 1, '{"shady": "I want the program to do different things depending on the score. How?", "cody": "That is what the `if` statement is for!"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-2', 'js1-4-1', 'text', 2, '{"title": "Learn", "body": "<pre><code>let score = 75;<br><br>if (score >= 60) {\\n  console.log(\\"You passed!\\");\\n} else {\\n  console.log(\\"Try again.\\");\\n}\\n</code></pre><br><br>- The condition inside `()` must evaluate to `true` or `false`.  \\n- Code inside the first `{ }` runs only when the condition is true.  \\n- The `else` block runs when the condition is false.  \\n- `else` is optional."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-3', 'js1-4-1', 'code_example', 3, '{"language": "javascript", "code": "const temperature = 30;\\n\\nif (temperature > 25) {\\n  console.log(\\"It’s hot!\\");\\n} else {\\n  console.log(\\"It’s comfortable or cool.\\");\\n}", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-4', 'js1-4-1', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-5', 'js1-4-1', 'quick_check', 5, '{"title": "Quick Check", "question": "When does the `else` block run?", "options": {"A": "Always", "B": "Only when the `if` condition is false", "C": "Only when the `if` condition is true"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-6', 'js1-4-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Check if a player’s score is at least 100 and print “Level up!” or “Keep going!”."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-7', 'js1-4-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a simple “pass/fail” checker for a test score."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-1-8', 'js1-4-1', 'key_points', 8, '{"title": "Key Points", "points": ["`if` runs code when a condition is true.", "`else` handles the opposite case.", "Conditions use comparison operators.", "Always use curly braces `{ }` for clarity."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-4-2', 'chap-js1-04', 'js1-4-2-else-if-and-logical-operators', 2, '4.2: else if and Logical Operators', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-1', 'js1-4-2', 'dialogue', 1, '{"shady": "What if I have more than two possibilities — like grades A, B, C?", "cody": "Then we use `else if`. And logical operators let us combine conditions."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-2', 'js1-4-2', 'text', 2, '{"title": "Learn", "body": "<pre><code>let score = 85;<br><br>if (score >= 90) {\\n  console.log(\\"A\\");\\n} else if (score >= 80) {\\n  console.log(\\"B\\");\\n} else if (score >= 70) {\\n  console.log(\\"C\\");\\n} else {\\n  console.log(\\"Needs improvement\\");\\n}\\n</code></pre><br><br><strong>Logical operators:<strong>  \\n- `&&` (AND) — both sides must be true  \\n- `||` (OR) — at least one side true  \\n- `!` (NOT) — reverses true/false  <br><br><pre><code>let age = 15;\\nlet hasPermission = true;<br><br>if (age >= 13 && hasPermission) {\\n  console.log(\\"You may enter\\");\\n}\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-3', 'js1-4-2', 'code_example', 3, '{"language": "javascript", "code": "const temperature = 22;\\nconst isRaining = false;\\n\\nif (temperature > 20 && !isRaining) {\\n  console.log(\\"Nice day for a walk!\\");\\n} else {\\n  console.log(\\"Maybe stay inside.\\");\\n}", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-4', 'js1-4-2', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-5', 'js1-4-2', 'quick_check', 5, '{"title": "Quick Check", "question": "What does `&&` require?", "options": {"A": "Only one condition true", "B": "Both conditions true", "C": "Both conditions false"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-6', 'js1-4-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a login check: username must be “Shady” **and** password length must be at least 4 (you can hard-code the values for now)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-7', 'js1-4-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Build a small weather advisor using `else if` and at least one logical operator."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-2-8', 'js1-4-2', 'key_points', 8, '{"title": "Key Points", "points": ["`else if` adds more conditions.", "`&&`, `||`, `!` combine or reverse conditions.", "Order of `if / else if / else` matters."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-4-3', 'chap-js1-04', 'js1-4-3-introducing-functions', 3, '4.3: Introducing Functions', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-1', 'js1-4-3', 'dialogue', 1, '{"shady": "I keep writing the same `console.log` greeting many times. Is there a better way?", "cody": "Yes — functions let you package code and reuse it."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-2', 'js1-4-3', 'text', 2, '{"title": "Learn", "body": "A <strong>function<strong> is a reusable block of code.<br><br><pre><code>function sayHello() {\\n  console.log(\\"Hello, Code Orbit!\\");\\n}<br><br>sayHello();  // call the function\\nsayHello();  // call it again\\n</code></pre><br><br>- `function` keyword starts the declaration.  \\n- `sayHello` is the function name.  \\n- `()` is where parameters will go (empty for now).  \\n- `{ }` contains the body.  \\n- You must <strong>call<strong> the function with `()` to run it."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-3', 'js1-4-3', 'code_example', 3, '{"language": "javascript", "code": "function showMission() {\\n  console.log(\\"Mission: Learn JavaScript\\");\\n  console.log(\\"Status: In progress\\");\\n}\\n\\nshowMission();", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-4', 'js1-4-3', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-5', 'js1-4-3', 'quick_check', 5, '{"title": "Quick Check", "question": "What do you need to do to actually run the code inside a function?", "options": {"A": "Only declare it", "B": "Call it with its name followed by `()`", "C": "Restart the browser"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-6', 'js1-4-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a function that prints three lines of a short poem or motto and call it."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-7', 'js1-4-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Create two different functions (e.g., one for greeting, one for showing score) and call both."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-3-8', 'js1-4-3', 'key_points', 8, '{"title": "Key Points", "points": ["Functions package reusable code.", "Declare with `function name() { }`.", "Call with `name()`.", "Functions help avoid repetition."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-4-4', 'chap-js1-04', 'js1-4-4-parameters-arguments-and-return-val', 4, '4.4: Parameters, Arguments, and Return Values', 15, 30, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-1', 'js1-4-4', 'dialogue', 1, '{"shady": "Can a function work with different names or numbers each time I call it?", "cody": "Yes! That’s what parameters and return values are for."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-2', 'js1-4-4', 'text', 2, '{"title": "Learn", "body": "<strong>Parameters<strong> are placeholders in the function definition.  \\n<strong>Arguments<strong> are the actual values you pass when calling.<br><br><pre><code>function greet(name) {\\n  console.log(`Hello, ${name}!`);\\n}<br><br>greet(\\"Shady\\");  // argument \\"Shady\\"\\ngreet(\\"Cody\\");\\n</code></pre><br><br><strong>Return values<strong> send a result back:<br><br><pre><code>function add(a, b) {\\n  return a + b;\\n}<br><br>let sum = add(3, 4);\\nconsole.log(sum);  // 7\\n</code></pre><br><br>- `return` immediately exits the function and sends the value.  \\n- You can store the returned value in a variable or use it directly."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-3', 'js1-4-4', 'code_example', 3, '{"language": "javascript", "code": "function calculateArea(width, height) {\\n  return width * height;\\n}\\n\\nconst area = calculateArea(10, 5);\\nconsole.log(`Area is ${area}`);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-4', 'js1-4-4', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-5', 'js1-4-4', 'quick_check', 5, '{"title": "Quick Check", "question": "What keyword sends a value back from a function?", "options": {"A": "`send`", "B": "`return`", "C": "`output`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-6', 'js1-4-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Write a function that takes a player’s name and score, then returns a message string using a template literal."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-7', 'js1-4-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a small calculator function (add or multiply) that takes two numbers and returns the result. Use the returned value in a `console.log`."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-4-8', 'js1-4-4', 'key_points', 8, '{"title": "Key Points", "points": ["Parameters receive values.", "Arguments are the values you pass.", "`return` gives a result back.", "Functions can both perform actions and produce values."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-4-5', 'chap-js1-04', 'js1-4-5-simple-function-design-and-scope-ba', 5, '4.5: Simple Function Design and Scope Basics', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-1', 'js1-4-5', 'dialogue', 1, '{"shady": "Sometimes I create a variable inside a function and then I can’t use it outside. Why?", "cody": "That’s scope! Let’s learn the beginner version."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-2', 'js1-4-5', 'text', 2, '{"title": "Learn", "body": "<strong>Good function design tips:<strong>  \\n- One clear job per function  \\n- Descriptive names  \\n- Keep them short  <br><br><strong>Local scope (beginner level):<strong>  \\nVariables declared inside a function with `let` or `const` only exist inside that function.<br><br><pre><code>function showScore() {\\n  let score = 100;          // local variable\\n  console.log(score);\\n}<br><br>showScore();\\n// console.log(score);     // Error — score is not visible here\\n</code></pre><br><br>Variables declared outside functions are in the outer (global) scope and can be read inside functions, but beginners should prefer passing values as parameters."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-3', 'js1-4-5', 'code_example', 3, '{"language": "javascript", "code": "function createGreeting(name) {\\n  const message = `Welcome, ${name}!`;\\n  return message;\\n}\\n\\nconst text = createGreeting(\\"Shady\\");\\nconsole.log(text);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-4', 'js1-4-5', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-5', 'js1-4-5', 'quick_check', 5, '{"title": "Quick Check", "question": "A variable declared with `let` inside a function is visible:", "options": {"A": "Everywhere in the program", "B": "Only inside that function", "C": "Only after the function is called"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-6', 'js1-4-5', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Design two small functions: one that returns a welcome message, another that returns a goodbye message. Call both."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-7', 'js1-4-5', 'mission', 7, '{"title": "Lesson Mission", "body": "Refactor a few repeated `console.log` statements from earlier lessons into well-named functions."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-4-5-8', 'js1-4-5', 'key_points', 8, '{"title": "Key Points", "points": ["Keep functions focused and well-named.", "Variables declared inside a function are local.", "Prefer parameters over relying on outer variables when possible."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-js1-05', 'course-javascript-level-1', 'chap-js1-05-5-arrays-objects-and-repetition', 'Chapter 5: Arrays, Objects, and Repetition', 'Store collections of data and repeat actions with loops.', 5, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-5-1', 'chap-js1-05', 'js1-5-1-introducing-arrays', 1, '5.1: Introducing Arrays', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-1', 'js1-5-1', 'dialogue', 1, '{"shady": "I want to store a list of scores or names. Do I need a new variable for each one?", "cody": "No — we use an **array**, an ordered list of values."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-2', 'js1-5-1', 'text', 2, '{"title": "Learn", "body": "<pre><code>let scores = [90, 85, 78, 92];\\nlet names = [\\"Shady\\", \\"Cody\\", \\"Alex\\"];<br><br>console.log(scores[0]);   // 90  (first element)\\nconsole.log(names[1]);    // \\"Cody\\"\\nconsole.log(scores.length); // 4\\n</code></pre><br><br>- Arrays are written with square brackets `[ ]`.  \\n- Indexes start at <strong>0<strong>.  \\n- `.length` tells you how many items are in the array.<br><br>You can change an element:\\n<pre><code>scores[2] = 80;\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-3', 'js1-5-1', 'code_example', 3, '{"language": "javascript", "code": "const fruits = [\\"apple\\", \\"banana\\", \\"cherry\\"];\\nconsole.log(fruits[0]);\\nconsole.log(fruits.length);\\nfruits[1] = \\"blueberry\\";\\nconsole.log(fruits);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-4', 'js1-5-1', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-5', 'js1-5-1', 'quick_check', 5, '{"title": "Quick Check", "question": "What is the index of the first element in an array?", "options": {"A": "1", "B": "0", "C": "-1"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-6', 'js1-5-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create an array of numbers, change the second element, and print the whole array."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-7', 'js1-5-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Store a list of three mission names in an array and print each one using its index."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-1-8', 'js1-5-1', 'key_points', 8, '{"title": "Key Points", "points": ["Arrays store ordered lists.", "Indexes start at 0.", "Use `.length` to get the size.", "You can read and change elements by index."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-5-2', 'chap-js1-05', 'js1-5-2-array-methods-push-pop-shift-unshif', 2, '5.2: Array Methods: push, pop, shift, unshift', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-1', 'js1-5-2', 'dialogue', 1, '{"shady": "How do I add a new score to the end of my list without knowing the next index?", "cody": "Arrays give us helpful methods for that."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-2', 'js1-5-2', 'text', 2, '{"title": "Learn", "body": "<pre><code>let lives = [3, 2, 1];<br><br>lives.push(5);      // add to the end\\nconsole.log(lives); // [3, 2, 1, 5]<br><br>lives.pop();        // remove from the end\\nconsole.log(lives); // [3, 2, 1]<br><br>lives.unshift(4);   // add to the beginning\\nconsole.log(lives); // [4, 3, 2, 1]<br><br>lives.shift();      // remove from the beginning\\nconsole.log(lives); // [3, 2, 1]\\n</code></pre><br><br>- `push` / `pop` work at the <strong>end<strong>.  \\n- `unshift` / `shift` work at the <strong>beginning<strong>."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-3', 'js1-5-2', 'code_example', 3, '{"language": "javascript", "code": "const queue = [\\"Shady\\"];\\nqueue.push(\\"Cody\\");\\nqueue.push(\\"Alex\\");\\nconsole.log(queue);\\nqueue.shift();\\nconsole.log(queue);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-4', 'js1-5-2', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-5', 'js1-5-2', 'quick_check', 5, '{"title": "Quick Check", "question": "Which method removes the last element of an array?", "options": {"A": "`shift`", "B": "`pop`", "C": "`push`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-6', 'js1-5-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Simulate a simple stack of books: add three books with `push`, remove the top one with `pop`, and print the remaining list."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-7', 'js1-5-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a to-do list array and practice adding and removing items with the four methods."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-2-8', 'js1-5-2', 'key_points', 8, '{"title": "Key Points", "points": ["`push` / `pop` → end of array.", "`unshift` / `shift` → beginning of array.", "These methods change the original array."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-5-3', 'chap-js1-05', 'js1-5-3-introducing-objects', 3, '5.3: Introducing Objects', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-1', 'js1-5-3', 'dialogue', 1, '{"shady": "An array is great for a list, but what if I want to store a player’s name, score, and level together?", "cody": "That’s a perfect job for an **object**."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-2', 'js1-5-3', 'text', 2, '{"title": "Learn", "body": "An <strong>object<strong> stores related data as key-value pairs.<br><br><pre><code>const player = {\\n  name: \\"Shady\\",\\n  score: 120,\\n  level: 3,\\n  isActive: true\\n};<br><br>console.log(player.name);    // \\"Shady\\"\\nconsole.log(player.score);   // 120\\nplayer.score = 150;          // update a property\\nconsole.log(player.score);   // 150\\n</code></pre><br><br>- Keys are also called properties.  \\n- Use <strong>dot notation<strong> `object.property` to read or change values.  \\n- Objects are written with curly braces `{ }`."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-3', 'js1-5-3', 'code_example', 3, '{"language": "javascript", "code": "const course = {\\n  title: \\"JavaScript Level 1\\",\\n  lessons: 30,\\n  level: 1\\n};\\n\\nconsole.log(`${course.title} has ${course.lessons} lessons.`);", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-4', 'js1-5-3', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-5', 'js1-5-3', 'quick_check', 5, '{"title": "Quick Check", "question": "How do you usually read a property named `score` from an object `player`?", "options": {"A": "`player[score]`", "B": "`player.score`", "C": "`player->score`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-6', 'js1-5-3', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create a “mission” object with title, difficulty, and completed (boolean). Print a status message using a template literal."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-7', 'js1-5-3', 'mission', 7, '{"title": "Lesson Mission", "body": "Model a simple game character or a book using an object and print its information."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-3-8', 'js1-5-3', 'key_points', 8, '{"title": "Key Points", "points": ["Objects group related data.", "Properties are key-value pairs.", "Use dot notation to access properties.", "You can update property values."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-5-4', 'chap-js1-05', 'js1-5-4-for-loops', 4, '5.4: for Loops', 15, 30, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-1', 'js1-5-4', 'dialogue', 1, '{"shady": "I need to print every item in an array. Writing `console.log` five times is boring.", "cody": "Loops to the rescue! Let’s start with the classic `for` loop."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-2', 'js1-5-4', 'text', 2, '{"title": "Learn", "body": "<pre><code>for (let i = 0; i < 5; i++) {\\n  console.log(i);\\n}\\n</code></pre><br><br><strong>Parts of a for loop:<strong>  \\n1. Initialization: `let i = 0`  \\n2. Condition: `i < 5` (keep going while true)  \\n3. Update: `i++` (add 1 each time)  <br><br>Looping over an array:\\n<pre><code>const names = [\\"Shady\\", \\"Cody\\", \\"Alex\\"];<br><br>for (let i = 0; i < names.length; i++) {\\n  console.log(names[i]);\\n}\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-3', 'js1-5-4', 'code_example', 3, '{"language": "javascript", "code": "const scores = [90, 85, 78];\\n\\nfor (let i = 0; i < scores.length; i++) {\\n  console.log(`Score ${i + 1}: ${scores[i]}`);\\n}", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-4', 'js1-5-4', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-5', 'js1-5-4', 'quick_check', 5, '{"title": "Quick Check", "question": "In `for (let i = 0; i < 3; i++)`, how many times does the loop body run?", "options": {"A": "2", "B": "3", "C": "4"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-6', 'js1-5-4', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Calculate the sum of all numbers in an array using a `for` loop and print the total."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-7', 'js1-5-4', 'mission', 7, '{"title": "Lesson Mission", "body": "Create an array of mission names and print each one with its number using a `for` loop."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-4-8', 'js1-5-4', 'key_points', 8, '{"title": "Key Points", "points": ["`for` loops repeat a specific number of times.", "Classic pattern: start at 0, go while `< length`, increase by 1.", "Perfect for going through arrays by index."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-5-5', 'chap-js1-05', 'js1-5-5-while-loops-and-for-of', 5, '5.5: while Loops and for...of', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-1', 'js1-5-5', 'dialogue', 1, '{"shady": "Sometimes I don’t know how many times I need to repeat something in advance.", "cody": "Then a `while` loop is useful. And for arrays, `for...of` is often cleaner."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-2', 'js1-5-5', 'text', 2, '{"title": "Learn", "body": "<strong>while loop:<strong>\\n<pre><code>let count = 0;\\nwhile (count < 3) {\\n  console.log(count);\\n  count++;\\n}\\n</code></pre><br><br>Be careful: if the condition never becomes false, you create an <strong>infinite loop<strong>.<br><br><strong>for...of loop<strong> (great for arrays):\\n<pre><code>const fruits = [\\"apple\\", \\"banana\\", \\"cherry\\"];<br><br>for (const fruit of fruits) {\\n  console.log(fruit);\\n}\\n</code></pre><br><br>`for...of` gives you each item directly — no need to manage an index."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-3', 'js1-5-5', 'code_example', 3, '{"language": "javascript", "code": "let lives = 3;\\nwhile (lives > 0) {\\n  console.log(`Lives left: ${lives}`);\\n  lives--;\\n}\\nconsole.log(\\"Game over\\");", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-4', 'js1-5-5', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-5', 'js1-5-5', 'quick_check', 5, '{"title": "Quick Check", "question": "Which loop is especially convenient when you only need each item of an array and not its index?", "options": {"A": "`for` with index", "B": "`for...of`", "C": "`while` only"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-6', 'js1-5-5', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Combine an array and a `for...of` loop to print a numbered list of tasks."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-7', 'js1-5-5', 'mission', 7, '{"title": "Lesson Mission", "body": "Choose the most suitable loop (`for`, `while`, or `for...of`) for three different small problems and implement them."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-5-8', 'js1-5-5', 'key_points', 8, '{"title": "Key Points", "points": ["`while` continues as long as the condition is true.", "Avoid infinite loops by updating the condition variable.", "`for...of` is clean for iterating over array items."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-5-6', 'chap-js1-05', 'js1-5-6-simple-iteration-problems', 6, '5.6: Simple Iteration Problems', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-1', 'js1-5-6', 'dialogue', 1, '{"shady": "I know the pieces — arrays, objects, loops. How do I combine them for real tasks?", "cody": "Let’s practice a few classic beginner problems."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-2', 'js1-5-6', 'text', 2, '{"title": "Learn", "body": "Common patterns:  \\n1. Sum all numbers in an array.  \\n2. Find the highest value.  \\n3. Count how many items meet a condition.  \\n4. Build a new array or message from existing data.<br><br>Example — sum:\\n<pre><code>const numbers = [10, 20, 30];\\nlet total = 0;<br><br>for (const n of numbers) {\\n  total += n;\\n}\\nconsole.log(total);  // 60\\n</code></pre><br><br>Example — working with objects in an array:\\n<pre><code>const players = [\\n  { name: \\"Shady\\", score: 100 },\\n  { name: \\"Cody\\", score: 150 }\\n];<br><br>for (const player of players) {\\n  console.log(`${player.name}: ${player.score}`);\\n}\\n</code></pre>"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-3', 'js1-5-6', 'code_example', 3, '{"language": "javascript", "code": "const scores = [70, 95, 80, 60];\\nlet max = scores[0];\\n\\nfor (let i = 1; i < scores.length; i++) {\\n  if (scores[i] > max) {\\n    max = scores[i];\\n  }\\n}\\nconsole.log(max);", "explanation": "Find the maximum score:"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-4', 'js1-5-6', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-5', 'js1-5-6', 'quick_check', 5, '{"title": "Quick Check", "question": "What is a good way to sum all numbers in an array?", "options": {"A": "Use a loop and keep adding to a total variable", "B": "Use only `console.log`", "C": "Use `const` for the total and try to reassign it"}, "correct": "A", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-6', 'js1-5-6', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Create an array of objects (missions) and print only the titles of the completed ones."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-7', 'js1-5-6', 'mission', 7, '{"title": "Lesson Mission", "body": "Invent and solve one small problem that uses an array (or array of objects) plus a loop and a condition."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-5-6-8', 'js1-5-6', 'key_points', 8, '{"title": "Key Points", "points": ["Combine loops with conditions and accumulators.", "Arrays of objects are very common.", "Practice is the best way to become comfortable."]}');
INSERT INTO chapters (id, course_id, slug, title, description, chapter_number, created_at, updated_at) VALUES
('chap-js1-06', 'course-javascript-level-1', 'chap-js1-06-6-connecting-javascript-to-html', 'Chapter 6: Connecting JavaScript to HTML', 'Understand how to include JavaScript in a webpage (introduction only — no DOM manipulation).', 6, NOW(), NOW());
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-6-1', 'chap-js1-06', 'js1-6-1-the-script-tag-and-how-the-browser', 1, '6.1: The script Tag and How the Browser Loads JavaScript', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-1', 'js1-6-1', 'dialogue', 1, '{"shady": "So far I only used the console and the playground. How does JavaScript get into a real webpage?", "cody": "Through the `<script>` tag. Let’s see the beginner way."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-2', 'js1-6-1', 'text', 2, '{"title": "Learn", "body": "You can include JavaScript directly in an HTML file:<br><br><pre><code><!DOCTYPE html>\\n<html>\\n<head>\\n  <title>My Page</title>\\n</head>\\n<body>\\n  <h1>Hello</h1><br><br>  <script>\\n    console.log(\\"JavaScript is running inside the page!\\");\\n  </script>\\n</body>\\n</html>\\n</code></pre><br><br>- The browser reads the HTML from top to bottom.  \\n- When it reaches a `<script>` tag, it executes the JavaScript inside it.  \\n- Placing the script near the end of the `<body>` is a common beginner-friendly practice so the HTML content loads first.<br><br><strong>Important for Level 1:<strong>  \\nWe are only learning *how to include* JavaScript.  \\nWe are <strong>not<strong> yet learning how to change the page content with JavaScript (that belongs to Level 2)."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-3', 'js1-6-1', 'text', 3, '{"title": "Example", "body": "A minimal page that runs a greeting in the console when opened."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-4', 'js1-6-1', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-5', 'js1-6-1', 'quick_check', 5, '{"title": "Quick Check", "question": "Which HTML tag is used to include JavaScript in a page?", "options": {"A": "`<js>`", "B": "`<script>`", "C": "`<code>`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-6', 'js1-6-1', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Add a second `console.log` that prints the current year inside the same script block."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-7', 'js1-6-1', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a complete (but simple) HTML file that includes a short JavaScript message in the console."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-1-8', 'js1-6-1', 'key_points', 8, '{"title": "Key Points", "points": ["Use the `<script>` tag to include JavaScript.", "The browser executes the script when it reaches it.", "Level 1 focuses on including code, not manipulating the page."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-6-2', 'chap-js1-06', 'js1-6-2-inline-vs-external-javascript-begin', 2, '6.2: Inline vs External JavaScript (Beginner View)', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-1', 'js1-6-2', 'dialogue', 1, '{"shady": "Can I keep my JavaScript in a different file so the HTML stays clean?", "cody": "Yes! That is called external JavaScript. Both ways are useful."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-2', 'js1-6-2', 'text', 2, '{"title": "Learn", "body": "<strong>1. Inline / internal JavaScript<strong> (code written directly between `<script>` and `</script>`):<br><br><pre><code><script>\\n  console.log(\\"I am inside the HTML file\\");\\n</script>\\n</code></pre><br><br><strong>2. External JavaScript<strong> (code in a separate `.js` file):<br><br><pre><code><script src=\\"script.js\\"></script>\\n</code></pre><br><br>And in `script.js`:\\n<pre><code>console.log(\\"I am in an external file\\");\\n</code></pre><br><br><strong>Beginner guidelines:<strong>  \\n- Small experiments → internal script is fine.  \\n- Larger programs → external file keeps HTML cleaner and code reusable.  \\n- The `src` attribute tells the browser where to find the external file.  \\n- Paths can be relative (same folder) or more complex later.<br><br>We still do <strong>not<strong> teach DOM methods such as `document.querySelector` in this lesson."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-3', 'js1-6-2', 'text', 3, '{"title": "Example", "body": "A page that loads an external greeting file."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-4', 'js1-6-2', 'code_playground', 4, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-5', 'js1-6-2', 'quick_check', 5, '{"title": "Quick Check", "question": "What attribute of the `<script>` tag points to an external JavaScript file?", "options": {"A": "`href`", "B": "`src`", "C": "`link`"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-6', 'js1-6-2', 'challenge', 6, '{"title": "Tiny Challenge", "body": "Describe one advantage of keeping JavaScript in an external file."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-7', 'js1-6-2', 'mission', 7, '{"title": "Lesson Mission", "body": "Create a tiny project structure description: one HTML file + one external JS file and show how they connect."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-2-8', 'js1-6-2', 'key_points', 8, '{"title": "Key Points", "points": ["JavaScript can live inside the HTML or in a separate file.", "External files use `<script src=\\"...\\">`.", "External files help keep code organized.", "No DOM manipulation yet."]}');
INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at) VALUES
('js1-6-3', 'chap-js1-06', 'js1-6-3-putting-it-together-a-simple-page-w', 3, '6.3: Putting It Together: A Simple Page with JavaScript', 12, 25, NOW(), NOW());
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-1', 'js1-6-3', 'dialogue', 1, '{"shady": "Can we make a tiny complete example that uses everything we learned?", "cody": "Yes — a simple HTML page that runs a small JavaScript program in the console."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-2', 'js1-6-3', 'text', 2, '{"title": "Learn", "body": "We will create:  \\n1. Basic HTML structure  \\n2. A heading and a short paragraph  \\n3. A `<script>` block (or external file) that:  \\n   - Declares a few variables  \\n   - Uses a condition  \\n   - Calls a small function  \\n   - Works with a simple array  <br><br>Remember: the visible page stays static; the interesting work happens in the console. This is intentional for Level 1."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-3', 'js1-6-3', 'code_playground', 3, '{"language": "javascript", "initial_code": "console.log(\\"Hello, Code Orbit!\\");", "expected_output": "", "instructions": "Edit and run the JavaScript code. Observe the console output.", "success_condition": "Code runs without syntax errors", "external_resource_title": "Try More Code", "external_resource_description": "Practice more in a free online editor", "external_resource_target": "https://jsfiddle.net/"}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-4', 'js1-6-3', 'quick_check', 4, '{"title": "Quick Check", "question": "In Level 1, when we put JavaScript in an HTML page, where do we mainly see the results of `console.log`?", "options": {"A": "As visible text on the page", "B": "In the browser console", "C": "In a popup only"}, "correct": "B", "explanation": ""}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-5', 'js1-6-3', 'challenge', 5, '{"title": "Tiny Challenge", "body": "Add a simple object representing the course and print one of its properties from the script."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-6', 'js1-6-3', 'mission', 6, '{"title": "Lesson Mission", "body": "Build your own mini “console report” page that uses variables, a function, a condition, and a loop."}');
INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES
('blk-js1-6-3-7', 'js1-6-3', 'key_points', 7, '{"title": "Key Points", "points": ["You now know how to include JavaScript in a page.", "Console programs can live inside HTML.", "Real interactive page changes come in later levels.", "You have the foundations ready for Level 2."]}');

SET FOREIGN_KEY_CHECKS = 1;
-- Done. Frontend L1 = 5 chapters, JS L1 = 6 chapters.