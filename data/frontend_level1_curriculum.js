/**
 * SPS CODE ORBIT — Frontend Level 1 Curriculum
 * Source: frontend_level_1_en.md (authoritative)
 */

var FRONTEND_LEVEL1_COURSE = {
  "id": "course-frontend-level-1",
  "slug": "frontend-level-1",
  "title": "Frontend — Level 1",
  "subtitle": "Build Your First Web Pages",
  "description": "Learn how to create the structure and appearance of web pages using HTML and CSS. Start from zero — build clean multi-section pages with headings, text, images, links, lists, tables, forms, colors, fonts, and the CSS box model.",
  "track": "Frontend Track",
  "track_id": "track-frontend",
  "level": "Level 1",
  "level_number": 1,
  "difficulty": "Beginner",
  "prerequisite": "Programming Foundations",
  "academic_group_name": "Preparatory",
  "academicGroupLabel": "Frontend Track",
  "image": "/assets/courses/design.png",
  "image_url": "/assets/courses/design.png",
  "accent_color": "#E34F26",
  "is_published": 1,
  "chapters": [
    {
      "id": "chap-fe1-01",
      "slug": "chap-fe1-01-understanding-the-web-and-html",
      "title": "Chapter 1: Understanding the Web and HTML",
      "english_title": "Chapter 1: Understanding the Web and HTML",
      "description": "Understand what websites and HTML are, and write your first valid HTML documents.",
      "chapter_number": 1,
      "lessons_count": 5,
      "icon_symbol": "🌐",
      "lessons": [
        {
          "id": "fe1-1-1",
          "slug": "fe1-1-1-what-is-a-website",
          "title": "1.1: What Is a Website?",
          "lesson_number": 1,
          "duration": 10,
          "xp_reward": 20,
          "youtube_query": "“what is a website for beginners”",
          "summary_image": "",
          "learning_objective": "Explain what a website is and the role of a web browser.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "I use websites every day, but I’ve never thought about what they actually are. What is a website really?",
                "cody": "Great starting question! A website is a collection of pages that live on the internet and are displayed by a browser. Let’s unpack that."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "A <strong>website</strong> is a set of related web pages that share a common domain name and are published on the internet (or a local network).<br><br>When you type a web address (URL) or click a link:  \n1. Your <strong>browser</strong> (Chrome, Firefox, Edge, Safari…) requests the page from a server.  \n2. The server sends back files — mainly HTML, CSS, and sometimes JavaScript.  \n3. The browser reads those files and <strong>renders</strong> (draws) the page on your screen.<br><br>Key ideas:  \n- A website can be one page or thousands of pages.  \n- The browser is the program that displays the website.  \n- HTML describes the content and structure.  \n- CSS describes how it looks.  \n- JavaScript (optional) adds behavior.  <br><br>Many modern websites use HTML, CSS, and JavaScript together, but not every page needs JavaScript."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "When you visit a school website you might see:  <br>- A title and logo  <br>- Navigation links  <br>- Text about the school  <br>- Images of the campus  <br>- A contact form  <br><br>All of that is described with HTML and styled with CSS."
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "What is the main job of a web browser?",
                "options": {
                  "A": "To create websites",
                  "B": "To request, receive, and display web pages",
                  "C": "To store all websites on your computer permanently"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Write one sentence that explains what a website is in your own words."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Explain to a friend (or write in your notes) the difference between a website and a web browser."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "A website is a collection of web pages.",
                  "The browser displays the pages.",
                  "HTML = structure, CSS = appearance, JavaScript = behavior.",
                  "Not every page needs JavaScript."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-1-2",
          "slug": "fe1-1-2-what-is-html",
          "title": "1.2: What Is HTML?",
          "lesson_number": 2,
          "duration": 10,
          "xp_reward": 20,
          "youtube_query": "“what is html for absolute beginners”",
          "summary_image": "",
          "learning_objective": "Define HTML and understand that it uses tags to mark up content.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "People keep saying “HTML is the skeleton of a webpage.” What does that mean?",
                "cody": "HTML stands for HyperText Markup Language. It is the language we use to describe the structure and content of a page."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<strong>HTML</strong> = HyperText Markup Language  <br><br>It is <strong>not</strong> a programming language like JavaScript or Python.  \nIt is a <strong>markup language</strong> — it uses special markers called <strong>tags</strong> to tell the browser what each piece of content is.<br><br>Examples of what HTML can mark:  \n- This is a main heading  \n- This is a paragraph  \n- This is a link  \n- This is an image  \n- This is a list  <br><br>A simple HTML tag looks like this:  \n<pre><code><p>This is a paragraph.</p>\n</code></pre><br><br>- `<p>` is the opening tag  \n- `</p>` is the closing tag  \n- The content goes between them  <br><br>Most HTML elements have an opening and a closing tag. A few elements are self-closing (we will see them later)."
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<h1>Welcome to Code Orbit</h1>\n<p>This is the first paragraph of our page.</p>",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "What is the main purpose of HTML?",
                "options": {
                  "A": "To make pages look colorful",
                  "B": "To describe the structure and content of a webpage",
                  "C": "To add animations and interactivity"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Write one correct HTML paragraph element that contains a short sentence about yourself."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Write a one-sentence definition of HTML in your own words and give one example of a tag."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "HTML stands for HyperText Markup Language.",
                  "It uses tags to mark up content.",
                  "It describes structure, not appearance or behavior.",
                  "Most elements have opening and closing tags."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-1-3",
          "slug": "fe1-1-3-basic-html-document-structure",
          "title": "1.3: Basic HTML Document Structure",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html document structure for beginners”",
          "summary_image": "",
          "learning_objective": "Write a complete minimal HTML5 document with the correct skeleton.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "Do I just start writing tags anywhere?",
                "cody": "Almost every HTML page follows the same basic skeleton. Let’s learn it once and use it forever."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "Every modern HTML page should start with this structure:<br><br><pre><code><!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Page Title</title>\n</head>\n<body>\n  <!-- Visible content goes here -->\n</body>\n</html>\n</code></pre><br><br><strong>What each part means:</strong>  \n- `<!DOCTYPE html>` — tells the browser this is an HTML5 document  \n- `<html>` — the root element that wraps everything  \n- `lang=\"en\"` — language of the page (helps accessibility and search engines)  \n- `<head>` — information about the page (not visible content)  \n- `<meta charset=\"UTF-8\">` — character encoding so all languages display correctly  \n- `<title>` — the text that appears in the browser tab  \n- `<body>` — everything the user actually sees on the page  <br><br>Comments in HTML look like this:  \n<pre><code><!-- This is a comment. The browser ignores it. -->\n</code></pre>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>My First Page</title>\n</head>\n<body>\n  <h1>Hello, Code Orbit!</h1>\n  <p>This is my first webpage.</p>\n</body>\n</html>",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>My First Page</title>\n</head>\n<body>\n  <h1>Hello, Code Orbit!</h1>\n  <p>This is my first webpage.</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Where does the visible content of a webpage belong?",
                "options": {
                  "A": "Inside the `<head>`",
                  "B": "Inside the `<body>`",
                  "C": "Inside the `<!DOCTYPE>`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Change the language attribute to another language code (for example `lang=\"ar\"`) and change the title to something personal."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Create a complete minimal HTML page about yourself with a title, one heading, and one paragraph."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Every page needs DOCTYPE, html, head, and body.",
                  "Visible content goes in the body.",
                  "The title appears in the browser tab.",
                  "Comments help humans understand the code."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-1-4",
          "slug": "fe1-1-4-headings-and-paragraphs",
          "title": "1.4: Headings and Paragraphs",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html headings and paragraphs”",
          "summary_image": "",
          "learning_objective": "Use the six heading levels and the paragraph element correctly.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do I make some text big and important and other text normal?",
                "cody": "HTML has special tags for headings and paragraphs. They create a clear hierarchy."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<strong>Headings</strong> (`<h1>` to `<h6>`):  \n- `<h1>` — main title of the page (usually only one per page)  \n- `<h2>` — major section headings  \n- `<h3>` — sub-sections  \n- … down to `<h6>` for the smallest headings  <br><br><strong>Paragraphs:</strong>  \n<pre><code><p>This is a paragraph of text. It can contain several sentences.</p>\n</code></pre><br><br>Good practice:  \n- Use headings to create a logical outline.  \n- Do not skip levels just for visual size (use CSS for appearance later).  \n- Keep paragraphs focused on one idea."
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<h1>My Learning Journey</h1>\n<p>I started with Programming Foundations.</p>\n\n<h2>Current Course</h2>\n<p>Now I am learning Frontend Level 1.</p>\n\n<h3>Today’s Goal</h3>\n<p>Understand headings and paragraphs.</p>",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Headings Practice</title>\n</head>\n<body>\n  <h1>Main Title</h1>\n  <p>Introduction paragraph.</p>\n  <h2>Section One</h2>\n  <p>Details about section one.</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which heading level should normally be used for the main title of a page?",
                "options": {
                  "A": "`<h3>`",
                  "B": "`<h1>`",
                  "C": "`<h6>`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Write a mini article structure with one h1, two h2s, and a paragraph under each h2."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Build a simple “About My Day” page using proper heading hierarchy and paragraphs."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Headings create structure and hierarchy.",
                  "`<h1>` is the most important heading.",
                  "Paragraphs hold normal text content.",
                  "Use headings for meaning, not just size."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-1-5",
          "slug": "fe1-1-5-html-comments-and-good-habits",
          "title": "1.5: HTML Comments and Good Habits",
          "lesson_number": 5,
          "duration": 10,
          "xp_reward": 20,
          "youtube_query": "“html comments and best practices beginners”",
          "summary_image": "",
          "learning_objective": "Write HTML comments and adopt basic clean-code habits.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "When my page gets longer, I forget what each part is for.",
                "cody": "Comments and clean structure solve that problem."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "HTML comments:\n<pre><code><!-- This is a comment. It is not displayed on the page. -->\n</code></pre><br><br>Useful places for comments:  \n- At the start of a major section  \n- To temporarily disable a piece of code  \n- To leave notes for yourself or teammates  <br><br><strong>Good habits for Level 1:</strong>  \n- Indent nested elements (2 or 4 spaces)  \n- Close every tag that needs closing  \n- Use lowercase for tag names  \n- Keep the structure tidy"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<body>\n  <!-- Main header -->\n  <h1>Welcome</h1>\n\n  <!-- Introduction -->\n  <p>This page is about learning HTML.</p>\n</body>",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Do HTML comments appear on the visible webpage?",
                "options": {
                  "A": "Yes",
                  "B": "No",
                  "C": "Only in some browsers"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Take a previous page and add at least two useful comments."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Review one of your earlier pages and improve it with comments and consistent indentation."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Comments help humans understand code.",
                  "The browser ignores comments.",
                  "Indentation and consistent structure make code easier to read.",
                  "Close your tags."
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-fe1-02",
      "slug": "chap-fe1-02-html-content-and-navigation",
      "title": "Chapter 2: HTML Content and Navigation",
      "english_title": "Chapter 2: HTML Content and Navigation",
      "description": "Add links, images, and lists so pages can navigate and present content clearly.",
      "chapter_number": 2,
      "lessons_count": 4,
      "icon_symbol": "🧭",
      "lessons": [
        {
          "id": "fe1-2-1",
          "slug": "fe1-2-1-links-with-the-anchor-element",
          "title": "2.1: Links with the Anchor Element",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html links href beginners”",
          "summary_image": "",
          "learning_objective": "Create hyperlinks using the `<a>` element and the `href` attribute.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do I make text that I can click to go to another page?",
                "cody": "That is what the anchor element is for — the heart of the web!"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "The <strong>anchor</strong> element creates a link:<br><br><pre><code><a href=\"https://www.example.com\">Visit Example</a>\n</code></pre><br><br>- `<a>` stands for anchor  \n- `href` (hypertext reference) holds the destination URL  \n- The text between the tags is what the user sees and clicks  <br><br><strong>Absolute vs relative links (beginner level):</strong>  \n- Absolute: full address starting with `https://` — goes to another website  \n- Relative: path to another page on the same site, for example `about.html`  <br><br><pre><code><a href=\"https://www.wikipedia.org\">Wikipedia (absolute)</a>\n<a href=\"contact.html\">Contact page (relative)</a>\n</code></pre>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<p>\n  Learn more at \n  <a href=\"https://developer.mozilla.org\">MDN Web Docs</a>.\n</p>",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Links Practice</title>\n</head>\n<body>\n  <h1>Useful Links</h1>\n  <p><a href=\"https://www.google.com\">Go to Google</a></p>\n  <!-- Add one more link below -->\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which attribute of the `<a>` tag specifies the destination of the link?",
                "options": {
                  "A": "`src`",
                  "B": "`href`",
                  "C": "`link`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Write two links: one absolute and one relative (you can invent the relative filename)."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Create a small “Resources” section with three useful links for learning frontend."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Use `<a href=\"...\">` to create links.",
                  "Absolute links start with `https://`.",
                  "Relative links point to pages on the same site.",
                  "The visible text is placed between the tags."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-2-2",
          "slug": "fe1-2-2-images",
          "title": "2.2: Images",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html img tag alt text”",
          "summary_image": "",
          "learning_objective": "Insert images with the `<img>` element and use `src`, `alt`, width, and height responsibly.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do I put a picture on my page?",
                "cody": "With the image element. And we always describe the image for accessibility."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code><img src=\"photo.jpg\" alt=\"A smiling robot named Cody\" width=\"300\">\n</code></pre><br><br>- `<img>` is a self-closing element (no closing tag needed)  \n- `src` — path or URL of the image file  \n- `alt` — alternative text that describes the image (very important for accessibility and when the image fails to load)  \n- `width` and `height` — optional size in pixels (for Level 1 we keep it simple)  <br><br>Good `alt` text:  \n- Describes the content or function of the image  \n- Is not just “image” or “photo”"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<img \n  src=\"https://via.placeholder.com/200\" \n  alt=\"Placeholder image 200 pixels wide\"\n  width=\"200\">",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Why is the `alt` attribute important?",
                "options": {
                  "A": "It makes the image load faster",
                  "B": "It describes the image for screen readers and when the image cannot be shown",
                  "C": "It is required for CSS to work"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create a short profile section that contains a heading, a paragraph, and an image with good alt text."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Build a simple “About Me” block that includes one image with proper alt text."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Use `<img src=\"...\" alt=\"...\">`.",
                  "Always provide meaningful alt text.",
                  "width/height can control display size at a basic level.",
                  "Images are self-closing."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-2-3",
          "slug": "fe1-2-3-unordered-and-ordered-lists",
          "title": "2.3: Unordered and Ordered Lists",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html lists ul ol li”",
          "summary_image": "",
          "learning_objective": "Create bulleted and numbered lists.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "I want to show a list of topics or steps. How do I do that cleanly?",
                "cody": "HTML has special list elements for exactly that purpose."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<strong>Unordered list</strong> (bullets):\n<pre><code><ul>\n  <li>HTML</li>\n  <li>CSS</li>\n  <li>JavaScript</li>\n</ul>\n</code></pre><br><br><strong>Ordered list</strong> (numbers):\n<pre><code><ol>\n  <li>Learn HTML structure</li>\n  <li>Add content</li>\n  <li>Style with CSS</li>\n</ol>\n</code></pre><br><br>- `<ul>` = unordered list  \n- `<ol>` = ordered list  \n- `<li>` = list item (used inside both)  <br><br>You can put paragraphs, links, or other elements inside a list item when needed."
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "language": "html",
                "code": "<h2>My Learning Plan</h2>\n<ol>\n  <li>Finish Frontend Level 1</li>\n  <li>Practice building small pages</li>\n  <li>Move to Level 2</li>\n</ol>",
                "explanation": ""
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which element creates a bulleted list?",
                "options": {
                  "A": "`<ol>`",
                  "B": "`<ul>`",
                  "C": "`<li>`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Make a nested structure idea (list of courses, each with a short description paragraph inside the `<li>`)."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Create a page section that contains both an ordered list and an unordered list related to your learning goals."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "`<ul>` for bullets, `<ol>` for numbers.",
                  "Every item is an `<li>`.",
                  "Lists help organize information clearly."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-2-4",
          "slug": "fe1-2-4-grouping-content-and-simple-navigat",
          "title": "2.4: Grouping Content and Simple Navigation",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html navigation menu beginners”",
          "summary_image": "",
          "learning_objective": "Use basic grouping and create a simple navigation list of links.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do real websites put a menu of links at the top?",
                "cody": "We combine lists and links — and later CSS will make it look like a real menu. For now we focus on correct structure."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "A common beginner navigation pattern:<br><br><pre><code><nav>\n  <ul>\n    <li><a href=\"index.html\">Home</a></li>\n    <li><a href=\"about.html\">About</a></li>\n    <li><a href=\"contact.html\">Contact</a></li>\n  </ul>\n</nav>\n</code></pre><br><br>- `<nav>` is a semantic element that indicates navigation (good practice)  \n- Inside it we often place an unordered list of links  \n- Each link points to a different page or section  <br><br>You can also group content with simple elements like `<div>` (generic container) or more semantic tags later. For Level 1, focus on clear structure."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A small page with navigation and two sections."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which element is specifically meant to wrap major navigation links?",
                "options": {
                  "A": "`<nav>`",
                  "B": "`<header>` only",
                  "C": "`<p>`"
                },
                "correct": "A",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Add a fourth navigation item and a footer paragraph with a copyright note."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Create a mini multi-page concept (Home, About, Contact) using a shared navigation list structure."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Combine `<nav>`, `<ul>`, and `<a>` for basic menus.",
                  "Structure comes before styling.",
                  "Semantic tags like `<nav>` improve clarity."
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-fe1-03",
      "slug": "chap-fe1-03-html-data-and-forms",
      "title": "Chapter 3: HTML Data and Forms",
      "english_title": "Chapter 3: HTML Data and Forms",
      "description": "Present data in tables and collect information with forms.",
      "chapter_number": 3,
      "lessons_count": 4,
      "icon_symbol": "📋",
      "lessons": [
        {
          "id": "fe1-3-1",
          "slug": "fe1-3-1-tables",
          "title": "3.1: Tables",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html tables for beginners”",
          "summary_image": "",
          "learning_objective": "Create simple data tables with rows, headers, and cells.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How can I show information in neat rows and columns, like a schedule?",
                "cody": "HTML tables are perfect for tabular data."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "Basic table structure:<br><br><pre><code><table>\n  <tr>\n    <th>Name</th>\n    <th>Score</th>\n  </tr>\n  <tr>\n    <td>Shady</td>\n    <td>95</td>\n  </tr>\n  <tr>\n    <td>Cody</td>\n    <td>100</td>\n  </tr>\n</table>\n</code></pre><br><br>- `<table>` — the whole table  \n- `<tr>` — table row  \n- `<th>` — header cell (bold and centered by default)  \n- `<td>` — normal data cell  <br><br>Use tables for <strong>data</strong>, not for page layout (layout belongs to CSS)."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A small scoreboard or class timetable."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which tag is used for a header cell in a table?",
                "options": {
                  "A": "`<td>`",
                  "B": "`<th>`",
                  "C": "`<tr>`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Make a 3×3 table that shows a simple weekly plan."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Create a useful table related to your learning progress or a hobby."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Tables organize data in rows and columns.",
                  "Use `<th>` for headers and `<td>` for data.",
                  "Do not use tables for visual layout."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-3-2",
          "slug": "fe1-3-2-introduction-to-forms",
          "title": "3.2: Introduction to Forms",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html forms for beginners”",
          "summary_image": "",
          "learning_objective": "Understand the purpose of forms and create a basic form structure.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do websites let me type my name or search for something?",
                "cody": "Through forms! Forms are the way users send information to a page or a server."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "A basic form:<br><br><pre><code><form>\n  <label for=\"name\">Name:</label>\n  <input type=\"text\" id=\"name\" name=\"name\">\n  <button type=\"submit\">Send</button>\n</form>\n</code></pre><br><br>- `<form>` wraps the whole form  \n- `<label>` describes the field (important for accessibility)  \n- `<input>` creates many kinds of fields  \n- `<button>` can submit the form  <br><br>In Level 1 we focus on the structure and the different input types. We do not yet connect forms to real servers or JavaScript validation."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A simple feedback form with a name field and a submit button."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which element is used to group form controls?",
                "options": {
                  "A": "`<form>`",
                  "B": "`<input>`",
                  "C": "`<label>`"
                },
                "correct": "A",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Add a second field for “Favorite color” to your form."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Design a small “Contact Me” form structure with at least two fields and a button."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Forms collect user input.",
                  "Always use labels.",
                  "The basic structure is form → label + input → button."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-3-3",
          "slug": "fe1-3-3-common-input-types",
          "title": "3.3: Common Input Types",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“html input types explained”",
          "summary_image": "",
          "learning_objective": "Use text, email, password, number, radio, checkbox, and select inputs.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "There seem to be many different kinds of boxes and buttons in forms. How do I choose the right one?",
                "cody": "Each `type` of input is designed for a specific kind of data. Let’s meet the most useful ones for beginners."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code><!-- Text -->\n<label for=\"username\">Username</label>\n<input type=\"text\" id=\"username\" name=\"username\"><br><br><!-- Email -->\n<label for=\"email\">Email</label>\n<input type=\"email\" id=\"email\" name=\"email\"><br><br><!-- Password -->\n<label for=\"password\">Password</label>\n<input type=\"password\" id=\"password\" name=\"password\"><br><br><!-- Number -->\n<label for=\"age\">Age</label>\n<input type=\"number\" id=\"age\" name=\"age\" min=\"1\" max=\"120\"><br><br><!-- Radio buttons (only one can be selected) -->\n<p>Choose a level:</p>\n<input type=\"radio\" id=\"beginner\" name=\"level\" value=\"beginner\">\n<label for=\"beginner\">Beginner</label>\n<input type=\"radio\" id=\"advanced\" name=\"level\" value=\"advanced\">\n<label for=\"advanced\">Advanced</label><br><br><!-- Checkboxes (multiple can be selected) -->\n<p>Interests:</p>\n<input type=\"checkbox\" id=\"html\" name=\"interest\" value=\"html\">\n<label for=\"html\">HTML</label>\n<input type=\"checkbox\" id=\"css\" name=\"interest\" value=\"css\">\n<label for=\"css\">CSS</label><br><br><!-- Dropdown -->\n<label for=\"country\">Country</label>\n<select id=\"country\" name=\"country\">\n  <option value=\"eg\">Egypt</option>\n  <option value=\"sa\">Saudi Arabia</option>\n  <option value=\"ae\">UAE</option>\n</select>\n</code></pre>"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A registration-style form that uses several of the above types."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which input type hides the characters as the user types?",
                "options": {
                  "A": "`text`",
                  "B": "`password`",
                  "C": "`email`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Add a number input for “Years of experience” with a sensible min value."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Build a “Student Profile Form” that uses at least five different input types."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Different input types serve different data.",
                  "Radio = one choice, checkbox = multiple choices.",
                  "Always pair inputs with labels.",
                  "`select` + `option` creates dropdowns."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-3-4",
          "slug": "fe1-3-4-buttons-and-form-purpose",
          "title": "3.4: Buttons and Form Purpose",
          "lesson_number": 4,
          "duration": 10,
          "xp_reward": 20,
          "youtube_query": "“html form button types”",
          "summary_image": "",
          "learning_objective": "Use buttons correctly and understand that forms have a purpose.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What exactly happens when I click the button?",
                "cody": "In real websites the data is usually sent to a server. In Level 1 we focus on correct structure and understanding the purpose."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code><button type=\"submit\">Send Message</button>\n<button type=\"reset\">Clear Form</button>\n<button type=\"button\">Just a Button</button>\n</code></pre><br><br>- `type=\"submit\"` — sends the form data  \n- `type=\"reset\"` — clears the form fields  \n- `type=\"button\"` — a generic button (no automatic action)  <br><br>Every form should have a clear purpose: search, login, contact, survey, registration, etc.  \nGood forms are easy to understand and easy to fill."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A contact form with a clear heading, a few fields, and a “Send” button."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "What does a button with `type=\"submit\"` do?",
                "options": {
                  "A": "Clears the form",
                  "B": "Sends the form data",
                  "C": "Only changes color"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Add a reset button next to the submit button and test both."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Finalize one complete form that has a clear purpose, good labels, appropriate input types, and a submit button."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Buttons can submit, reset, or perform custom actions.",
                  "Forms need a clear purpose.",
                  "Good labels and structure make forms usable."
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-fe1-04",
      "slug": "chap-fe1-04-css-fundamentals",
      "title": "Chapter 4: CSS Fundamentals",
      "english_title": "Chapter 4: CSS Fundamentals",
      "description": "Control the appearance of HTML elements with CSS.",
      "chapter_number": 4,
      "lessons_count": 5,
      "icon_symbol": "🎨",
      "lessons": [
        {
          "id": "fe1-4-1",
          "slug": "fe1-4-1-what-is-css",
          "title": "4.1: What Is CSS?",
          "lesson_number": 1,
          "duration": 10,
          "xp_reward": 20,
          "youtube_query": "“what is css for beginners”",
          "summary_image": "",
          "learning_objective": "Explain the role of CSS and the three ways to add it.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "My pages look very plain. How do I add colors and nicer fonts?",
                "cody": "That is the job of CSS — Cascading Style Sheets."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<strong>CSS</strong> = Cascading Style Sheets  <br><br>It describes <strong>how</strong> HTML elements should look: colors, fonts, sizes, spacing, etc.<br><br>There are three ways to add CSS:  <br><br>1. <strong>Inline</strong> — style attribute on an element (quick but not recommended for large projects)  \n<pre><code><p style=\"color: blue;\">Blue text</p>\n</code></pre><br><br>2. <strong>Internal</strong> — `<style>` tag inside the `<head>`  \n<pre><code><style>\n  p { color: blue; }\n</style>\n</code></pre><br><br>3. <strong>External</strong> — separate `.css` file linked with `<link>` (best practice)  \n<pre><code><link rel=\"stylesheet\" href=\"styles.css\">\n</code></pre><br><br>In this course we will mostly use internal and external CSS."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "Changing the color of all paragraphs with internal CSS."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "What is the main job of CSS?",
                "options": {
                  "A": "To describe the structure of the page",
                  "B": "To control the appearance and layout of the page",
                  "C": "To add interactivity"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Write one inline style and one internal style rule and observe the difference."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Take a previous HTML page and give it a simple internal style that changes the heading color."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "CSS controls appearance.",
                  "Three ways: inline, internal, external.",
                  "External stylesheets are the best long-term approach.",
                  "HTML stays focused on structure."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-4-2",
          "slug": "fe1-4-2-selectors-element-class-and-id",
          "title": "4.2: Selectors: Element, Class, and ID",
          "lesson_number": 2,
          "duration": 15,
          "xp_reward": 30,
          "youtube_query": "“css selectors element class id”",
          "summary_image": "",
          "learning_objective": "Target elements using element, class, and ID selectors.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How does CSS know which elements to style?",
                "cody": "Through selectors! Let’s learn the three most important ones."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<strong>1. Element selector</strong> — targets all elements of that type  \n<pre><code>p {\n  color: navy;\n}\n</code></pre><br><br><strong>2. Class selector</strong> — targets elements that have a specific class (reusable)  \n<pre><code><p class=\"highlight\">Important text</p>\n</code></pre>\n<pre><code>.highlight {\n  background-color: yellow;\n}\n</code></pre><br><br><strong>3. ID selector</strong> — targets one unique element  \n<pre><code><h1 id=\"main-title\">Welcome</h1>\n</code></pre>\n<pre><code>#main-title {\n  color: darkgreen;\n}\n</code></pre><br><br><strong>Basic specificity idea (Level 1):</strong>  \nID is more specific than class, class is more specific than element.  \nWhen rules conflict, the more specific one wins."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "Styling a page that uses all three kinds of selectors."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which character is used to start a class selector in CSS?",
                "options": {
                  "A": "`#`",
                  "B": "`.`",
                  "C": "`*`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create two paragraphs: one normal, one with class `special`. Make only the special one red."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Style a small page using at least one element selector, one class, and one ID."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Element selector → tag name",
                  "Class selector → `.classname`",
                  "ID selector → `#idname`",
                  "Classes are reusable; IDs should be unique."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-4-3",
          "slug": "fe1-4-3-colors-and-backgrounds",
          "title": "4.3: Colors and Backgrounds",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css colors hex named colors”",
          "summary_image": "",
          "learning_objective": "Apply text colors and background colors using named colors and hex values.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do I choose nice colors for text and backgrounds?",
                "cody": "CSS gives us several ways to write colors. Let’s start with the simplest."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code>h1 {\n  color: darkblue;           /* named color */\n  background-color: #f0f8ff; /* hex color */\n}<br><br>p {\n  color: #333333;\n  background-color: lightyellow;\n}\n</code></pre><br><br>- `color` controls text color  \n- `background-color` controls the background of the element  \n- Named colors: `red`, `blue`, `white`, `black`, `navy`, etc.  \n- Hex colors: `#RRGGBB` (for example `#ff0000` is pure red)  <br><br>You can also use more advanced formats later (RGB, HSL). For Level 1, named colors and basic hex are enough."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A simple color scheme for a learning page."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which property changes the text color?",
                "options": {
                  "A": "`background-color`",
                  "B": "`color`",
                  "C": "`font-color`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create a “highlight” class that uses a bright background color and dark text."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Design a simple two-color scheme for one of your pages and apply it with CSS."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "`color` = text, `background-color` = background.",
                  "Named colors are easy to start with.",
                  "Hex codes give precise control.",
                  "Good contrast improves readability."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-4-4",
          "slug": "fe1-4-4-typography-fonts-size-weight-and-al",
          "title": "4.4: Typography: Fonts, Size, Weight, and Alignment",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css font-family font-size text-align”",
          "summary_image": "",
          "learning_objective": "Control font family, size, weight, and text alignment.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "The default font looks a bit boring. Can I change it?",
                "cody": "Yes — typography is a big part of how professional pages feel."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code>body {\n  font-family: Arial, sans-serif;\n  font-size: 16px;\n}<br><br>h1 {\n  font-size: 2rem;\n  font-weight: bold;\n  text-align: center;\n}<br><br>p {\n  font-weight: normal;\n  text-align: left;\n  line-height: 1.5;\n}\n</code></pre><br><br>Important properties:  \n- `font-family` — which font to use (always provide a fallback)  \n- `font-size` — size of the text  \n- `font-weight` — normal, bold, or numeric values  \n- `text-align` — left, center, right, justify  \n- `line-height` — space between lines (improves readability)"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A clean reading style for articles."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which property controls whether text is bold?",
                "options": {
                  "A": "`font-size`",
                  "B": "`font-weight`",
                  "C": "`text-align`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create a class `.big-text` that increases font size and another class `.center` that centers text."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Improve the typography of one of your earlier pages so it feels more pleasant to read."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Choose readable fonts and always give a fallback.",
                  "Control size, weight, and alignment.",
                  "Good line-height makes text easier to read.",
                  "Consistency across the page looks professional."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-4-5",
          "slug": "fe1-4-5-linking-an-external-stylesheet",
          "title": "4.5: Linking an External Stylesheet",
          "lesson_number": 5,
          "duration": 10,
          "xp_reward": 25,
          "youtube_query": "“how to link css file to html”",
          "summary_image": "",
          "learning_objective": "Connect an HTML file to an external CSS file correctly.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "My style block is getting long. Can I move the CSS to its own file?",
                "cody": "Yes — and that is the professional way to work."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "In the `<head>` of your HTML:<br><br><pre><code><link rel=\"stylesheet\" href=\"styles.css\">\n</code></pre><br><br>- `rel=\"stylesheet\"` tells the browser this is a style sheet  \n- `href` points to the CSS file  <br><br>The CSS file itself contains only CSS rules — no HTML tags:<br><br><pre><code>/* styles.css */\nbody {\n  font-family: Arial, sans-serif;\n  background-color: #fafafa;\n}<br><br>h1 {\n  color: #223;\n}\n</code></pre><br><br>Benefits:  \n- One CSS file can style many HTML pages  \n- Easier to maintain  \n- Cleaner HTML"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A two-file mini project: `index.html` + `styles.css`."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Where should the `<link>` element for a stylesheet usually be placed?",
                "options": {
                  "A": "Inside the `<body>`",
                  "B": "Inside the `<head>`",
                  "C": "After the closing `</html>`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Describe one advantage of external CSS over internal CSS."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Convert one of your internal-style pages into an external-stylesheet version."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Use `<link rel=\"stylesheet\" href=\"...\">`.",
                  "Place it in the `<head>`.",
                  "External CSS keeps projects organized.",
                  "The CSS file contains pure CSS rules."
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-fe1-05",
      "slug": "chap-fe1-05-the-css-box-model-and-basic-page-flow",
      "title": "Chapter 5: The CSS Box Model and Basic Page Flow",
      "english_title": "Chapter 5: The CSS Box Model and Basic Page Flow",
      "description": "Understand how every element is a box and control spacing and sizing.",
      "chapter_number": 5,
      "lessons_count": 5,
      "icon_symbol": "📦",
      "lessons": [
        {
          "id": "fe1-5-1",
          "slug": "fe1-5-1-the-box-model-concept",
          "title": "5.1: The Box Model Concept",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css box model explained for beginners”",
          "summary_image": "",
          "learning_objective": "Explain the four parts of the CSS box model.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "Why is there space around my elements that I didn’t expect?",
                "cody": "Because every HTML element is a rectangular box with several layers. Welcome to the box model!"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "Every element generates a box that consists of:<br><br>1. <strong>Content</strong> — the text or image itself  \n2. <strong>Padding</strong> — space between the content and the border  \n3. <strong>Border</strong> — the line around the padding  \n4. <strong>Margin</strong> — space outside the border (separates elements from each other)<br><br><pre><code>.box {\n  width: 200px;\n  padding: 20px;\n  border: 3px solid black;\n  margin: 15px;\n}\n</code></pre><br><br>Understanding the box model is the key to controlling layout and spacing at Level 1."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A visible box with background, padding, border, and margin so the student can see each part."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which part of the box model is the space *outside* the border?",
                "options": {
                  "A": "Padding",
                  "B": "Margin",
                  "C": "Content"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Make a box that has different padding and margin values and observe the difference."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Draw (or describe) the box model and create one styled box that clearly shows all four parts."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Every element is a box.",
                  "Content + padding + border + margin.",
                  "Padding is inside, margin is outside.",
                  "Mastering the box model unlocks layout control."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-5-2",
          "slug": "fe1-5-2-padding-border-and-margin-in-practi",
          "title": "5.2: Padding, Border, and Margin in Practice",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css padding margin border shorthand”",
          "summary_image": "",
          "learning_objective": "Apply padding, border, and margin with individual and shorthand values.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "How do I write the values for padding and margin?",
                "cody": "You can set all sides at once or control each side individually."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code>.card {\n  padding: 20px;                  /* all four sides */\n  padding: 10px 20px;             /* top/bottom | left/right */\n  padding: 10px 15px 20px 25px;   /* top | right | bottom | left */<br><br>  margin: 15px;\n  margin-top: 30px;<br><br>  border: 2px solid #333;\n  border-radius: 8px;             /* rounded corners (bonus) */\n}\n</code></pre><br><br>You can also set individual sides:  \n`padding-top`, `margin-left`, `border-bottom`, etc."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A card-style box with comfortable padding and a subtle border."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "If you write `padding: 10px 20px;`, what does the 20px control?",
                "options": {
                  "A": "Top and bottom",
                  "B": "Left and right",
                  "C": "All four sides"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create two boxes that are separated by margin and each have internal padding."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Create a simple “card” component using padding, border, and margin."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Padding adds space inside the border.",
                  "Margin adds space outside the border.",
                  "Border draws the edge.",
                  "Shorthand values save time."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-5-3",
          "slug": "fe1-5-3-width-height-and-box-sizing",
          "title": "5.3: Width, Height, and box-sizing",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css box-sizing border-box”",
          "summary_image": "",
          "learning_objective": "Control element size and understand the basic idea of box-sizing.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "I set width to 200px but the box looks wider. Why?",
                "cody": "Because by default padding and border are added on top of the width. Let’s fix that understanding."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<pre><code>.box {\n  width: 200px;\n  height: 100px;\n  padding: 20px;\n  border: 5px solid black;\n}\n</code></pre><br><br>By default (`box-sizing: content-box`):  \nFinal size = width + padding + border  <br><br>Modern best practice:\n<pre><code>* {\n  box-sizing: border-box;\n}\n</code></pre><br><br>With `border-box`, the declared width includes padding and border, which makes sizing much more predictable.<br><br>For Level 1 it is enough to know:  \n- You can set `width` and `height`  \n- Padding and border affect the final size  \n- `box-sizing: border-box` is a helpful habit"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "Two side-by-side boxes demonstrating the difference (conceptually)."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which property helps make width calculations more intuitive by including padding and border?",
                "options": {
                  "A": "`box-sizing: content-box`",
                  "B": "`box-sizing: border-box`",
                  "C": "`display: block`"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create a box that is exactly 300px wide including its padding and border."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Apply consistent widths and comfortable padding to the main sections of one of your pages."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "You can set width and height.",
                  "Default box model adds padding and border outside the width.",
                  "`border-box` makes sizing easier.",
                  "Use it as a good habit."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-5-4",
          "slug": "fe1-5-4-block-vs-inline-elements",
          "title": "5.4: Block vs Inline Elements",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css block vs inline elements”",
          "summary_image": "",
          "learning_objective": "Distinguish block-level and inline elements and understand basic page flow.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "Why do some elements start on a new line while others sit next to each other?",
                "cody": "Because some elements are block-level and others are inline. This is the foundation of page flow."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<strong>Block-level elements</strong> (examples: `<h1>`, `<p>`, `<div>`, `<ul>`, `<li>`, `<section>`):  \n- Start on a new line  \n- Take up the full available width by default  \n- You can set width, height, margin, and padding freely  <br><br><strong>Inline elements</strong> (examples: `<a>`, `<span>`, `<strong>`, `<em>`, `<img>`):  \n- Sit within a line of text  \n- Only take up as much width as their content needs  \n- Top and bottom margins do not push other elements the same way  <br><br>You can change the behavior with the `display` property (for example `display: inline-block`), but for Level 1 it is enough to recognize the default behavior."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A paragraph that contains a link and a strong element — the link and strong stay on the same line as the text."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "Which type of element starts on a new line and takes full width by default?",
                "options": {
                  "A": "Inline",
                  "B": "Block",
                  "C": "Neither"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Wrap a few words inside a paragraph with `<span class=\"highlight\">` and style only those words."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Build a short page that intentionally mixes block and inline elements and explain the flow you observe."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Block elements stack vertically and take full width.",
                  "Inline elements sit within a line.",
                  "Understanding flow is essential before learning advanced layout.",
                  "Flexbox and Grid come in Level 2."
                ]
              }
            }
          ]
        },
        {
          "id": "fe1-5-5",
          "slug": "fe1-5-5-putting-spacing-and-flow-together",
          "title": "5.5: Putting Spacing and Flow Together",
          "lesson_number": 5,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "“css spacing best practices beginners”",
          "summary_image": "",
          "learning_objective": "Combine box model, typography, and basic flow to create a clean multi-section page.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "I know the individual pieces. How do I make a whole page that looks tidy?",
                "cody": "By combining structure, the box model, and consistent spacing. Let’s practice."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "Practical checklist for a clean Level 1 page:  \n1. Solid HTML structure and hierarchy  \n2. External (or internal) CSS with clear selectors  \n3. Readable typography  \n4. Consistent padding and margin  \n5. Visible but not excessive borders if needed  \n6. Good contrast between text and background  <br><br>Avoid:  \n- Random spacing values  \n- Overlapping elements  \n- Text that is too close to the edges"
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Example",
                "body": "A simple profile-style page with header, about section, skills list, and footer — all properly spaced."
              }
            },
            {
              "block_type": "html_css_playground",
              "content": {
                "html": "<!DOCTYPE html>\n<html>\n<head><title>Practice</title></head>\n<body>\n  <h1>Hello</h1>\n  <p>Edit me!</p>\n</body>\n</html>",
                "css": "body { font-family: sans-serif; }",
                "instructions": "Edit the HTML and CSS. The live preview updates with your code.",
                "external_resource_title": "Try More Code",
                "external_resource_description": "Experiment in a free online HTML/CSS editor",
                "external_resource_target": "https://codepen.io/pen/"
              }
            },
            {
              "block_type": "quick_check",
              "content": {
                "title": "Quick Check",
                "question": "What is a good general approach to spacing on a page?",
                "options": {
                  "A": "Use random large numbers",
                  "B": "Apply consistent padding and margin so content has room to breathe",
                  "C": "Remove all margin and padding"
                },
                "correct": "B",
                "explanation": ""
              }
            },
            {
              "block_type": "challenge",
              "content": {
                "title": "Tiny Challenge",
                "body": "Create a “card” that contains a heading, a short paragraph, and a list, all comfortably spaced."
              }
            },
            {
              "block_type": "mission",
              "content": {
                "title": "Lesson Mission",
                "body": "Polish one complete page so it feels organized and pleasant to read."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key Points",
                "points": [
                  "Combine structure + box model + typography.",
                  "Consistency looks professional.",
                  "Leave breathing room around content.",
                  "You now have the tools for solid Level 1 pages."
                ]
              }
            }
          ]
        }
      ]
    }
  ],
  "chaptersCount": 5,
  "lessonsCount": 23,
  "total_lessons": 23
};

if (typeof window !== 'undefined') { window.FRONTEND_LEVEL1_COURSE = FRONTEND_LEVEL1_COURSE; }
if (typeof module !== 'undefined' && module.exports) { module.exports = { FRONTEND_LEVEL1_COURSE }; }
