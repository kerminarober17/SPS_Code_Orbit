# SPS Code Orbit — Frontend Level 1
**Course Title:** Frontend Level 1 — Build Your First Web Pages  
**Level:** 1  
**Track:** Frontend Track  
**Prerequisite:** Programming Foundations (recommended)  
**Difficulty:** Beginner  
**Language:** English  

**Course Description:**  
Welcome to Frontend Level 1! In this course you will learn how to create the structure and appearance of web pages using HTML and CSS. You start from absolute zero — no previous HTML or CSS knowledge is required. By the end you will be able to build clean, well-structured multi-section pages with headings, text, images, links, lists, tables, forms, colors, fonts, and proper spacing using the CSS box model.

Cody (your patient mentor) and Shady (a curious beginner) will guide you every step of the way.

**Learning Outcomes:**  
By the end of this course you will be able to:  
- Explain what a website is and how a browser reads HTML  
- Write correct basic HTML structure (DOCTYPE, html, head, body)  
- Use headings, paragraphs, links, images, lists, tables, and forms  
- Understand the difference between HTML (structure), CSS (appearance), and JavaScript (behavior)  
- Apply CSS with element, class, and ID selectors  
- Control colors, fonts, text alignment, and backgrounds  
- Use the CSS box model (content, padding, border, margin)  
- Distinguish block and inline elements  
- Create a small multi-section personal profile page with external CSS  

**Course Structure:** 5 Chapters + Final Project  

---

# CHAPTER 1 — Understanding the Web and HTML

**Chapter Goal:** Understand what websites and HTML are, and write your first valid HTML documents.

---

## Lesson 1.1 — What Is a Website?

**Lesson ID:** fe1-1-1  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Explain what a website is and the role of a web browser.

### AI Visual Banner Specification
A friendly planet with a browser window open showing a simple webpage. Cody pointing at the screen, Shady looking curious. Soft blue and green tones.

### Story / Hook
**Shady:** I use websites every day, but I’ve never thought about what they actually are. What is a website really?  
**Cody:** Great starting question! A website is a collection of pages that live on the internet and are displayed by a browser. Let’s unpack that.

### Learn Section
A **website** is a set of related web pages that share a common domain name and are published on the internet (or a local network).

When you type a web address (URL) or click a link:  
1. Your **browser** (Chrome, Firefox, Edge, Safari…) requests the page from a server.  
2. The server sends back files — mainly HTML, CSS, and sometimes JavaScript.  
3. The browser reads those files and **renders** (draws) the page on your screen.

Key ideas:  
- A website can be one page or thousands of pages.  
- The browser is the program that displays the website.  
- HTML describes the content and structure.  
- CSS describes how it looks.  
- JavaScript (optional) adds behavior.  

Many modern websites use HTML, CSS, and JavaScript together, but not every page needs JavaScript.

### Example
When you visit a school website you might see:  
- A title and logo  
- Navigation links  
- Text about the school  
- Images of the campus  
- A contact form  

All of that is described with HTML and styled with CSS.

### Interactive Activity
Open any simple website in your browser. Right-click on the page and choose “View Page Source” or “Inspect”. Notice that you see HTML tags. You do not need to understand them yet — just observe that the page is made of code.

### Practice
1. What program do you use to view websites?  
2. What are the three main technologies often used to build modern websites?  
3. Does every website require JavaScript?

### Feedback
1. A web browser.  
2. HTML, CSS, and JavaScript.  
3. No — many pages work with only HTML and CSS.

### Tiny Challenge
Write one sentence that explains what a website is in your own words.

### Quick Check
**Question:** What is the main job of a web browser?  
A) To create websites  
B) To request, receive, and display web pages  
C) To store all websites on your computer permanently  

**Correct Answer:** B

### Lesson Mission
Explain to a friend (or write in your notes) the difference between a website and a web browser.

### Summary Image Concept
Browser window requesting a page from a server and then displaying the rendered result.

### Want to Learn More?
**YouTube search query:** “what is a website for beginners”

### Check the Key Points
- A website is a collection of web pages.  
- The browser displays the pages.  
- HTML = structure, CSS = appearance, JavaScript = behavior.  
- Not every page needs JavaScript.

---

## Lesson 1.2 — What Is HTML?

**Lesson ID:** fe1-1-2  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Define HTML and understand that it uses tags to mark up content.

### AI Visual Banner Specification
Cody holding a large “HTML” badge and a document with visible tags surrounding text. Shady examining a tag.

### Story / Hook
**Shady:** People keep saying “HTML is the skeleton of a webpage.” What does that mean?  
**Cody:** HTML stands for HyperText Markup Language. It is the language we use to describe the structure and content of a page.

### Learn Section
**HTML** = HyperText Markup Language  

It is **not** a programming language like JavaScript or Python.  
It is a **markup language** — it uses special markers called **tags** to tell the browser what each piece of content is.

Examples of what HTML can mark:  
- This is a main heading  
- This is a paragraph  
- This is a link  
- This is an image  
- This is a list  

A simple HTML tag looks like this:  
```html
<p>This is a paragraph.</p>
```

- `<p>` is the opening tag  
- `</p>` is the closing tag  
- The content goes between them  

Most HTML elements have an opening and a closing tag. A few elements are self-closing (we will see them later).

### Example
```html
<h1>Welcome to Code Orbit</h1>
<p>This is the first paragraph of our page.</p>
```

The browser knows that the first line is a top-level heading and the second line is a paragraph because of the tags.

### Interactive Activity
Look at a short piece of HTML and identify the opening tags, closing tags, and the content between them.

### Practice
What does the abbreviation HTML stand for?  
Is HTML a programming language or a markup language?

### Feedback
HyperText Markup Language. It is a markup language.

### Tiny Challenge
Write one correct HTML paragraph element that contains a short sentence about yourself.

### Quick Check
**Question:** What is the main purpose of HTML?  
A) To make pages look colorful  
B) To describe the structure and content of a webpage  
C) To add animations and interactivity  

**Correct Answer:** B

### Lesson Mission
Write a one-sentence definition of HTML in your own words and give one example of a tag.

### Summary Image Concept
Skeleton labeled “HTML” with CSS clothes and JavaScript tools nearby.

### Want to Learn More?
**YouTube search query:** “what is html for absolute beginners”

### Check the Key Points
- HTML stands for HyperText Markup Language.  
- It uses tags to mark up content.  
- It describes structure, not appearance or behavior.  
- Most elements have opening and closing tags.

---

## Lesson 1.3 — Basic HTML Document Structure

**Lesson ID:** fe1-1-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Write a complete minimal HTML5 document with the correct skeleton.

### AI Visual Banner Specification
An exploded view of an HTML document showing DOCTYPE, html, head, and body sections clearly labeled.

### Story / Hook
**Shady:** Do I just start writing tags anywhere?  
**Cody:** Almost every HTML page follows the same basic skeleton. Let’s learn it once and use it forever.

### Learn Section
Every modern HTML page should start with this structure:

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Page Title</title>
</head>
<body>
  <!-- Visible content goes here -->
</body>
</html>
```

**What each part means:**  
- `<!DOCTYPE html>` — tells the browser this is an HTML5 document  
- `<html>` — the root element that wraps everything  
- `lang="en"` — language of the page (helps accessibility and search engines)  
- `<head>` — information about the page (not visible content)  
- `<meta charset="UTF-8">` — character encoding so all languages display correctly  
- `<title>` — the text that appears in the browser tab  
- `<body>` — everything the user actually sees on the page  

Comments in HTML look like this:  
```html
<!-- This is a comment. The browser ignores it. -->
```

### Example
A complete minimal page:

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My First Page</title>
</head>
<body>
  <h1>Hello, Code Orbit!</h1>
  <p>This is my first webpage.</p>
</body>
</html>
```

### Interactive Activity — Live Preview Playground
**HTML editor content:**
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My First Page</title>
</head>
<body>
  <h1>Hello, Code Orbit!</h1>
  <p>This is my first webpage.</p>
</body>
</html>
```
**CSS editor content:** (empty for now)  
**Preview behavior:** The browser shows a heading and a paragraph.  
**Editable sections:** Student may change the title, heading, and paragraph text.  
**Expected visual result:** A page with a large heading and a normal paragraph.  
**Evaluation rules:** Document must contain DOCTYPE, html, head, title, and body.  
**Success condition:** Page renders without obvious structural errors.  
**Common mistakes:** Forgetting the DOCTYPE, missing closing tags, putting visible content inside `<head>`.  

**External Resource:**  
- external_resource_title: Try More Code  
- external_resource_description: Experiment with HTML structure in a free online editor  
- external_resource_target: https://codepen.io/pen/ or https://jsfiddle.net/

### Practice
Write the full skeleton from memory, then add one heading and one paragraph inside the body.

### Feedback
Compare with the example above. Make sure every opening tag has a matching closing tag (except self-closing ones).

### Tiny Challenge
Change the language attribute to another language code (for example `lang="ar"`) and change the title to something personal.

### Quick Check
**Question:** Where does the visible content of a webpage belong?  
A) Inside the `<head>`  
B) Inside the `<body>`  
C) Inside the `<!DOCTYPE>`  

**Correct Answer:** B

### Lesson Mission
Create a complete minimal HTML page about yourself with a title, one heading, and one paragraph.

### Summary Image Concept
Labeled HTML skeleton with arrows pointing to each major section.

### Want to Learn More?
**YouTube search query:** “html document structure for beginners”

### Check the Key Points
- Every page needs DOCTYPE, html, head, and body.  
- Visible content goes in the body.  
- The title appears in the browser tab.  
- Comments help humans understand the code.

---

## Lesson 1.4 — Headings and Paragraphs

**Lesson ID:** fe1-1-4  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Use the six heading levels and the paragraph element correctly.

### AI Visual Banner Specification
A text hierarchy pyramid from h1 (largest) to h6 (smallest) with a paragraph underneath. Cody explaining “structure first”.

### Story / Hook
**Shady:** How do I make some text big and important and other text normal?  
**Cody:** HTML has special tags for headings and paragraphs. They create a clear hierarchy.

### Learn Section
**Headings** (`<h1>` to `<h6>`):  
- `<h1>` — main title of the page (usually only one per page)  
- `<h2>` — major section headings  
- `<h3>` — sub-sections  
- … down to `<h6>` for the smallest headings  

**Paragraphs:**  
```html
<p>This is a paragraph of text. It can contain several sentences.</p>
```

Good practice:  
- Use headings to create a logical outline.  
- Do not skip levels just for visual size (use CSS for appearance later).  
- Keep paragraphs focused on one idea.

### Example
```html
<h1>My Learning Journey</h1>
<p>I started with Programming Foundations.</p>

<h2>Current Course</h2>
<p>Now I am learning Frontend Level 1.</p>

<h3>Today’s Goal</h3>
<p>Understand headings and paragraphs.</p>
```

### Interactive Activity — Live Preview
**HTML:**
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Headings Practice</title>
</head>
<body>
  <h1>Main Title</h1>
  <p>Introduction paragraph.</p>
  <h2>Section One</h2>
  <p>Details about section one.</p>
</body>
</html>
```
**Task:** Add an `<h3>` and another paragraph. Observe how the browser sizes the headings differently.

### Practice
Create a short page outline about a hobby using at least three heading levels and two paragraphs.

### Feedback
Check that headings follow a logical order and paragraphs contain normal text.

### Tiny Challenge
Write a mini article structure with one h1, two h2s, and a paragraph under each h2.

### Quick Check
**Question:** Which heading level should normally be used for the main title of a page?  
A) `<h3>`  
B) `<h1>`  
C) `<h6>`  

**Correct Answer:** B

### Lesson Mission
Build a simple “About My Day” page using proper heading hierarchy and paragraphs.

### Summary Image Concept
Visual outline of a page with heading levels clearly marked.

### Want to Learn More?
**YouTube search query:** “html headings and paragraphs”

### Check the Key Points
- Headings create structure and hierarchy.  
- `<h1>` is the most important heading.  
- Paragraphs hold normal text content.  
- Use headings for meaning, not just size.

---

## Lesson 1.5 — HTML Comments and Good Habits

**Lesson ID:** fe1-1-5  
**Duration:** 10 min  
**XP Reward:** 20  
**Primary Objective:** Write HTML comments and adopt basic clean-code habits.

### AI Visual Banner Specification
Code with green comment text and Cody saying “Future you will thank you”.

### Story / Hook
**Shady:** When my page gets longer, I forget what each part is for.  
**Cody:** Comments and clean structure solve that problem.

### Learn Section
HTML comments:
```html
<!-- This is a comment. It is not displayed on the page. -->
```

Useful places for comments:  
- At the start of a major section  
- To temporarily disable a piece of code  
- To leave notes for yourself or teammates  

**Good habits for Level 1:**  
- Indent nested elements (2 or 4 spaces)  
- Close every tag that needs closing  
- Use lowercase for tag names  
- Keep the structure tidy  

### Example
```html
<body>
  <!-- Main header -->
  <h1>Welcome</h1>

  <!-- Introduction -->
  <p>This page is about learning HTML.</p>
</body>
```

### Interactive Activity
Add meaningful comments to a short HTML page that already has a heading and two paragraphs.

### Practice
Write a comment that explains the purpose of a navigation section (even if the section is still empty).

### Feedback
Any clear, helpful comment is good.

### Tiny Challenge
Take a previous page and add at least two useful comments.

### Quick Check
**Question:** Do HTML comments appear on the visible webpage?  
A) Yes  
B) No  
C) Only in some browsers  

**Correct Answer:** B

### Lesson Mission
Review one of your earlier pages and improve it with comments and consistent indentation.

### Summary Image Concept
Clean vs messy HTML side by side, with comments highlighted.

### Want to Learn More?
**YouTube search query:** “html comments and best practices beginners”

### Check the Key Points
- Comments help humans understand code.  
- The browser ignores comments.  
- Indentation and consistent structure make code easier to read.  
- Close your tags.

---

# CHAPTER 2 — HTML Content and Navigation

**Chapter Goal:** Add links, images, and lists so pages can navigate and present content clearly.

---

## Lesson 2.1 — Links with the Anchor Element

**Lesson ID:** fe1-2-1  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Create hyperlinks using the `<a>` element and the `href` attribute.

### AI Visual Banner Specification
Cody clicking a glowing link that leads to another page. Shady watching the address appear.

### Story / Hook
**Shady:** How do I make text that I can click to go to another page?  
**Cody:** That is what the anchor element is for — the heart of the web!

### Learn Section
The **anchor** element creates a link:

```html
<a href="https://www.example.com">Visit Example</a>
```

- `<a>` stands for anchor  
- `href` (hypertext reference) holds the destination URL  
- The text between the tags is what the user sees and clicks  

**Absolute vs relative links (beginner level):**  
- Absolute: full address starting with `https://` — goes to another website  
- Relative: path to another page on the same site, for example `about.html`  

```html
<a href="https://www.wikipedia.org">Wikipedia (absolute)</a>
<a href="contact.html">Contact page (relative)</a>
```

### Example
```html
<p>
  Learn more at 
  <a href="https://developer.mozilla.org">MDN Web Docs</a>.
</p>
```

### Interactive Activity — Live Preview
**HTML:**
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Links Practice</title>
</head>
<body>
  <h1>Useful Links</h1>
  <p><a href="https://www.google.com">Go to Google</a></p>
  <!-- Add one more link below -->
</body>
</html>
```
**Task:** Add a second link to any educational site. Observe that the text becomes clickable.

### Practice
Create a link that says “My Favorite Site” and points to a real URL.

### Feedback
```html
<a href="https://...">My Favorite Site</a>
```

### Tiny Challenge
Write two links: one absolute and one relative (you can invent the relative filename).

### Quick Check
**Question:** Which attribute of the `<a>` tag specifies the destination of the link?  
A) `src`  
B) `href`  
C) `link`  

**Correct Answer:** B

### Lesson Mission
Create a small “Resources” section with three useful links for learning frontend.

### Summary Image Concept
Clickable text with an arrow pointing to a destination page.

### Want to Learn More?
**YouTube search query:** “html links href beginners”

### Check the Key Points
- Use `<a href="...">` to create links.  
- Absolute links start with `https://`.  
- Relative links point to pages on the same site.  
- The visible text is placed between the tags.

---

## Lesson 2.2 — Images

**Lesson ID:** fe1-2-2  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Insert images with the `<img>` element and use `src`, `alt`, width, and height responsibly.

### AI Visual Banner Specification
An image placeholder with `src` and `alt` labels, Cody emphasizing “always write alt text”.

### Story / Hook
**Shady:** How do I put a picture on my page?  
**Cody:** With the image element. And we always describe the image for accessibility.

### Learn Section
```html
<img src="photo.jpg" alt="A smiling robot named Cody" width="300">
```

- `<img>` is a self-closing element (no closing tag needed)  
- `src` — path or URL of the image file  
- `alt` — alternative text that describes the image (very important for accessibility and when the image fails to load)  
- `width` and `height` — optional size in pixels (for Level 1 we keep it simple)  

Good `alt` text:  
- Describes the content or function of the image  
- Is not just “image” or “photo”  

### Example
```html
<img 
  src="https://via.placeholder.com/200" 
  alt="Placeholder image 200 pixels wide"
  width="200">
```

### Interactive Activity — Live Preview
**Task:** Add an image to a page using a public placeholder URL or a local path. Always include meaningful `alt` text.

### Practice
Write an `<img>` tag for a logo with appropriate alt text.

### Feedback
Must include both `src` and `alt`.

### Tiny Challenge
Create a short profile section that contains a heading, a paragraph, and an image with good alt text.

### Quick Check
**Question:** Why is the `alt` attribute important?  
A) It makes the image load faster  
B) It describes the image for screen readers and when the image cannot be shown  
C) It is required for CSS to work  

**Correct Answer:** B

### Lesson Mission
Build a simple “About Me” block that includes one image with proper alt text.

### Summary Image Concept
Image tag anatomy with src and alt highlighted.

### Want to Learn More?
**YouTube search query:** “html img tag alt text”

### Check the Key Points
- Use `<img src="..." alt="...">`.  
- Always provide meaningful alt text.  
- width/height can control display size at a basic level.  
- Images are self-closing.

---

## Lesson 2.3 — Unordered and Ordered Lists

**Lesson ID:** fe1-2-3  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Create bulleted and numbered lists.

### AI Visual Banner Specification
Two lists side by side: one with bullets, one with numbers. Cody pointing at the `<li>` items.

### Story / Hook
**Shady:** I want to show a list of topics or steps. How do I do that cleanly?  
**Cody:** HTML has special list elements for exactly that purpose.

### Learn Section
**Unordered list** (bullets):
```html
<ul>
  <li>HTML</li>
  <li>CSS</li>
  <li>JavaScript</li>
</ul>
```

**Ordered list** (numbers):
```html
<ol>
  <li>Learn HTML structure</li>
  <li>Add content</li>
  <li>Style with CSS</li>
</ol>
```

- `<ul>` = unordered list  
- `<ol>` = ordered list  
- `<li>` = list item (used inside both)  

You can put paragraphs, links, or other elements inside a list item when needed.

### Example
```html
<h2>My Learning Plan</h2>
<ol>
  <li>Finish Frontend Level 1</li>
  <li>Practice building small pages</li>
  <li>Move to Level 2</li>
</ol>
```

### Interactive Activity — Live Preview
Create both an unordered list of favorite subjects and an ordered list of steps to make tea (or any process).

### Practice
Convert a short paragraph of steps into a proper ordered list.

### Feedback
Each step becomes its own `<li>`.

### Tiny Challenge
Make a nested structure idea (list of courses, each with a short description paragraph inside the `<li>`).

### Quick Check
**Question:** Which element creates a bulleted list?  
A) `<ol>`  
B) `<ul>`  
C) `<li>`  

**Correct Answer:** B

### Lesson Mission
Create a page section that contains both an ordered list and an unordered list related to your learning goals.

### Summary Image Concept
Visual of ul vs ol with matching tags.

### Want to Learn More?
**YouTube search query:** “html lists ul ol li”

### Check the Key Points
- `<ul>` for bullets, `<ol>` for numbers.  
- Every item is an `<li>`.  
- Lists help organize information clearly.

---

## Lesson 2.4 — Grouping Content and Simple Navigation

**Lesson ID:** fe1-2-4  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Use basic grouping and create a simple navigation list of links.

### AI Visual Banner Specification
A simple page layout with a horizontal navigation bar made of links, Cody approving the structure.

### Story / Hook
**Shady:** How do real websites put a menu of links at the top?  
**Cody:** We combine lists and links — and later CSS will make it look like a real menu. For now we focus on correct structure.

### Learn Section
A common beginner navigation pattern:

```html
<nav>
  <ul>
    <li><a href="index.html">Home</a></li>
    <li><a href="about.html">About</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>
```

- `<nav>` is a semantic element that indicates navigation (good practice)  
- Inside it we often place an unordered list of links  
- Each link points to a different page or section  

You can also group content with simple elements like `<div>` (generic container) or more semantic tags later. For Level 1, focus on clear structure.

### Example
A small page with navigation and two sections.

### Interactive Activity — Live Preview
Build a page that has:  
- A simple navigation list with three links (they can point to `#` for now)  
- A main heading  
- A short paragraph  

### Practice
Explain why putting links inside a list is useful for navigation.

### Feedback
It gives the links a clear structure and makes them easier to style later.

### Tiny Challenge
Add a fourth navigation item and a footer paragraph with a copyright note.

### Quick Check
**Question:** Which element is specifically meant to wrap major navigation links?  
A) `<nav>`  
B) `<header>` only  
C) `<p>`  

**Correct Answer:** A

### Lesson Mission
Create a mini multi-page concept (Home, About, Contact) using a shared navigation list structure.

### Summary Image Concept
Simple website wireframe with navigation highlighted.

### Want to Learn More?
**YouTube search query:** “html navigation menu beginners”

### Check the Key Points
- Combine `<nav>`, `<ul>`, and `<a>` for basic menus.  
- Structure comes before styling.  
- Semantic tags like `<nav>` improve clarity.

---

# CHAPTER 3 — HTML Data and Forms

**Chapter Goal:** Present data in tables and collect information with forms.

---

## Lesson 3.1 — Tables

**Lesson ID:** fe1-3-1  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Create simple data tables with rows, headers, and cells.

### AI Visual Banner Specification
A clean table with highlighted `<table>`, `<tr>`, `<th>`, and `<td>` labels.

### Story / Hook
**Shady:** How can I show information in neat rows and columns, like a schedule?  
**Cody:** HTML tables are perfect for tabular data.

### Learn Section
Basic table structure:

```html
<table>
  <tr>
    <th>Name</th>
    <th>Score</th>
  </tr>
  <tr>
    <td>Shady</td>
    <td>95</td>
  </tr>
  <tr>
    <td>Cody</td>
    <td>100</td>
  </tr>
</table>
```

- `<table>` — the whole table  
- `<tr>` — table row  
- `<th>` — header cell (bold and centered by default)  
- `<td>` — normal data cell  

Use tables for **data**, not for page layout (layout belongs to CSS).

### Example
A small scoreboard or class timetable.

### Interactive Activity — Live Preview
Create a table with three columns (Day, Topic, Status) and at least three rows of data.

### Practice
Add a header row and two data rows for a list of books (Title, Author).

### Feedback
Headers use `<th>`, data uses `<td>`, each row is a `<tr>`.

### Tiny Challenge
Make a 3×3 table that shows a simple weekly plan.

### Quick Check
**Question:** Which tag is used for a header cell in a table?  
A) `<td>`  
B) `<th>`  
C) `<tr>`  

**Correct Answer:** B

### Lesson Mission
Create a useful table related to your learning progress or a hobby.

### Summary Image Concept
Annotated table showing the four main tags.

### Want to Learn More?
**YouTube search query:** “html tables for beginners”

### Check the Key Points
- Tables organize data in rows and columns.  
- Use `<th>` for headers and `<td>` for data.  
- Do not use tables for visual layout.

---

## Lesson 3.2 — Introduction to Forms

**Lesson ID:** fe1-3-2  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Understand the purpose of forms and create a basic form structure.

### AI Visual Banner Specification
A simple form with input fields and a submit button. Cody explaining “forms collect information”.

### Story / Hook
**Shady:** How do websites let me type my name or search for something?  
**Cody:** Through forms! Forms are the way users send information to a page or a server.

### Learn Section
A basic form:

```html
<form>
  <label for="name">Name:</label>
  <input type="text" id="name" name="name">
  <button type="submit">Send</button>
</form>
```

- `<form>` wraps the whole form  
- `<label>` describes the field (important for accessibility)  
- `<input>` creates many kinds of fields  
- `<button>` can submit the form  

In Level 1 we focus on the structure and the different input types. We do not yet connect forms to real servers or JavaScript validation.

### Example
A simple feedback form with a name field and a submit button.

### Interactive Activity — Live Preview
Build a form that asks for a user’s first name and has a submit button. Observe that you can type into the field.

### Practice
Explain why labels are important.

### Feedback
Labels tell users (and screen readers) what each field is for. The `for` attribute should match the input’s `id`.

### Tiny Challenge
Add a second field for “Favorite color” to your form.

### Quick Check
**Question:** Which element is used to group form controls?  
A) `<form>`  
B) `<input>`  
C) `<label>`  

**Correct Answer:** A

### Lesson Mission
Design a small “Contact Me” form structure with at least two fields and a button.

### Summary Image Concept
Form anatomy with label, input, and button highlighted.

### Want to Learn More?
**YouTube search query:** “html forms for beginners”

### Check the Key Points
- Forms collect user input.  
- Always use labels.  
- The basic structure is form → label + input → button.

---

## Lesson 3.3 — Common Input Types

**Lesson ID:** fe1-3-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Use text, email, password, number, radio, checkbox, and select inputs.

### AI Visual Banner Specification
A gallery of different input types with clear labels and Cody pointing at each.

### Story / Hook
**Shady:** There seem to be many different kinds of boxes and buttons in forms. How do I choose the right one?  
**Cody:** Each `type` of input is designed for a specific kind of data. Let’s meet the most useful ones for beginners.

### Learn Section
```html
<!-- Text -->
<label for="username">Username</label>
<input type="text" id="username" name="username">

<!-- Email -->
<label for="email">Email</label>
<input type="email" id="email" name="email">

<!-- Password -->
<label for="password">Password</label>
<input type="password" id="password" name="password">

<!-- Number -->
<label for="age">Age</label>
<input type="number" id="age" name="age" min="1" max="120">

<!-- Radio buttons (only one can be selected) -->
<p>Choose a level:</p>
<input type="radio" id="beginner" name="level" value="beginner">
<label for="beginner">Beginner</label>
<input type="radio" id="advanced" name="level" value="advanced">
<label for="advanced">Advanced</label>

<!-- Checkboxes (multiple can be selected) -->
<p>Interests:</p>
<input type="checkbox" id="html" name="interest" value="html">
<label for="html">HTML</label>
<input type="checkbox" id="css" name="interest" value="css">
<label for="css">CSS</label>

<!-- Dropdown -->
<label for="country">Country</label>
<select id="country" name="country">
  <option value="eg">Egypt</option>
  <option value="sa">Saudi Arabia</option>
  <option value="ae">UAE</option>
</select>
```

### Example
A registration-style form that uses several of the above types.

### Interactive Activity — Live Preview
Create a form that includes:  
- One text input  
- One email input  
- One pair of radio buttons  
- One checkbox  
- A select dropdown  
- A submit button  

### Practice
What is the difference between radio buttons and checkboxes?

### Feedback
Radio buttons (same `name`) allow only one selection. Checkboxes allow multiple selections.

### Tiny Challenge
Add a number input for “Years of experience” with a sensible min value.

### Quick Check
**Question:** Which input type hides the characters as the user types?  
A) `text`  
B) `password`  
C) `email`  

**Correct Answer:** B

### Lesson Mission
Build a “Student Profile Form” that uses at least five different input types.

### Summary Image Concept
Input type cheatsheet poster.

### Want to Learn More?
**YouTube search query:** “html input types explained”

### Check the Key Points
- Different input types serve different data.  
- Radio = one choice, checkbox = multiple choices.  
- Always pair inputs with labels.  
- `select` + `option` creates dropdowns.

---

## Lesson 3.4 — Buttons and Form Purpose

**Lesson ID:** fe1-3-4  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Use buttons correctly and understand that forms have a purpose.

### AI Visual Banner Specification
A form with a clear “Submit” button and Cody explaining the purpose of the form.

### Story / Hook
**Shady:** What exactly happens when I click the button?  
**Cody:** In real websites the data is usually sent to a server. In Level 1 we focus on correct structure and understanding the purpose.

### Learn Section
```html
<button type="submit">Send Message</button>
<button type="reset">Clear Form</button>
<button type="button">Just a Button</button>
```

- `type="submit"` — sends the form data  
- `type="reset"` — clears the form fields  
- `type="button"` — a generic button (no automatic action)  

Every form should have a clear purpose: search, login, contact, survey, registration, etc.  
Good forms are easy to understand and easy to fill.

### Example
A contact form with a clear heading, a few fields, and a “Send” button.

### Interactive Activity
Improve a basic form by adding a clear title, proper labels, and a descriptive submit button.

### Practice
Write a short sentence describing the purpose of a form you created.

### Feedback
Any clear purpose statement is good.

### Tiny Challenge
Add a reset button next to the submit button and test both.

### Quick Check
**Question:** What does a button with `type="submit"` do?  
A) Clears the form  
B) Sends the form data  
C) Only changes color  

**Correct Answer:** B

### Lesson Mission
Finalize one complete form that has a clear purpose, good labels, appropriate input types, and a submit button.

### Summary Image Concept
Complete form with purpose label above it.

### Want to Learn More?
**YouTube search query:** “html form button types”

### Check the Key Points
- Buttons can submit, reset, or perform custom actions.  
- Forms need a clear purpose.  
- Good labels and structure make forms usable.

---

# CHAPTER 4 — CSS Fundamentals

**Chapter Goal:** Control the appearance of HTML elements with CSS.

---

## Lesson 4.1 — What Is CSS?

**Lesson ID:** fe1-4-1  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Explain the role of CSS and the three ways to add it.

### AI Visual Banner Specification
An unstyled page transforming into a colorful styled page, with Cody holding a “CSS” paintbrush.

### Story / Hook
**Shady:** My pages look very plain. How do I add colors and nicer fonts?  
**Cody:** That is the job of CSS — Cascading Style Sheets.

### Learn Section
**CSS** = Cascading Style Sheets  

It describes **how** HTML elements should look: colors, fonts, sizes, spacing, etc.

There are three ways to add CSS:  

1. **Inline** — style attribute on an element (quick but not recommended for large projects)  
```html
<p style="color: blue;">Blue text</p>
```

2. **Internal** — `<style>` tag inside the `<head>`  
```html
<style>
  p { color: blue; }
</style>
```

3. **External** — separate `.css` file linked with `<link>` (best practice)  
```html
<link rel="stylesheet" href="styles.css">
```

In this course we will mostly use internal and external CSS.

### Example
Changing the color of all paragraphs with internal CSS.

### Interactive Activity — Live Preview
Add an internal `<style>` block that makes all `<h1>` elements dark blue.

### Practice
Name the three ways to include CSS and say which one is preferred for real projects.

### Feedback
Inline, internal, external. External is preferred for maintainability.

### Tiny Challenge
Write one inline style and one internal style rule and observe the difference.

### Quick Check
**Question:** What is the main job of CSS?  
A) To describe the structure of the page  
B) To control the appearance and layout of the page  
C) To add interactivity  

**Correct Answer:** B

### Lesson Mission
Take a previous HTML page and give it a simple internal style that changes the heading color.

### Summary Image Concept
HTML skeleton receiving colorful CSS clothing.

### Want to Learn More?
**YouTube search query:** “what is css for beginners”

### Check the Key Points
- CSS controls appearance.  
- Three ways: inline, internal, external.  
- External stylesheets are the best long-term approach.  
- HTML stays focused on structure.

---

## Lesson 4.2 — Selectors: Element, Class, and ID

**Lesson ID:** fe1-4-2  
**Duration:** 15 min  
**XP Reward:** 30  
**Primary Objective:** Target elements using element, class, and ID selectors.

### AI Visual Banner Specification
Three targeting tools: a wide net (element), a labeled group (class), and a unique spotlight (ID).

### Story / Hook
**Shady:** How does CSS know which elements to style?  
**Cody:** Through selectors! Let’s learn the three most important ones.

### Learn Section
**1. Element selector** — targets all elements of that type  
```css
p {
  color: navy;
}
```

**2. Class selector** — targets elements that have a specific class (reusable)  
```html
<p class="highlight">Important text</p>
```
```css
.highlight {
  background-color: yellow;
}
```

**3. ID selector** — targets one unique element  
```html
<h1 id="main-title">Welcome</h1>
```
```css
#main-title {
  color: darkgreen;
}
```

**Basic specificity idea (Level 1):**  
ID is more specific than class, class is more specific than element.  
When rules conflict, the more specific one wins.

### Example
Styling a page that uses all three kinds of selectors.

### Interactive Activity — Live Preview
**HTML + CSS task:**  
Create a paragraph with a class and an h1 with an id. Write CSS rules for the element, the class, and the id. Observe which styles apply.

### Practice
Write the CSS selector for:  
- All `<li>` elements  
- Elements with class `card`  
- The element with id `header`

### Feedback
`li { }`, `.card { }`, `#header { }`

### Tiny Challenge
Create two paragraphs: one normal, one with class `special`. Make only the special one red.

### Quick Check
**Question:** Which character is used to start a class selector in CSS?  
A) `#`  
B) `.`  
C) `*`  

**Correct Answer:** B

### Lesson Mission
Style a small page using at least one element selector, one class, and one ID.

### Summary Image Concept
Selector targeting diagram with examples.

### Want to Learn More?
**YouTube search query:** “css selectors element class id”

### Check the Key Points
- Element selector → tag name  
- Class selector → `.classname`  
- ID selector → `#idname`  
- Classes are reusable; IDs should be unique.

---

## Lesson 4.3 — Colors and Backgrounds

**Lesson ID:** fe1-4-3  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Apply text colors and background colors using named colors and hex values.

### AI Visual Banner Specification
A color palette with named colors and hex codes, Cody painting a webpage.

### Story / Hook
**Shady:** How do I choose nice colors for text and backgrounds?  
**Cody:** CSS gives us several ways to write colors. Let’s start with the simplest.

### Learn Section
```css
h1 {
  color: darkblue;           /* named color */
  background-color: #f0f8ff; /* hex color */
}

p {
  color: #333333;
  background-color: lightyellow;
}
```

- `color` controls text color  
- `background-color` controls the background of the element  
- Named colors: `red`, `blue`, `white`, `black`, `navy`, etc.  
- Hex colors: `#RRGGBB` (for example `#ff0000` is pure red)  

You can also use more advanced formats later (RGB, HSL). For Level 1, named colors and basic hex are enough.

### Example
A simple color scheme for a learning page.

### Interactive Activity — Live Preview
Apply a background color to the body and a different text color to headings. Try both named and hex values.

### Practice
Write a rule that makes all paragraphs dark gray on a very light gray background.

### Feedback
```css
p {
  color: #444;
  background-color: #f5f5f5;
}
```

### Tiny Challenge
Create a “highlight” class that uses a bright background color and dark text.

### Quick Check
**Question:** Which property changes the text color?  
A) `background-color`  
B) `color`  
C) `font-color`  

**Correct Answer:** B

### Lesson Mission
Design a simple two-color scheme for one of your pages and apply it with CSS.

### Summary Image Concept
Before/after page with color applied.

### Want to Learn More?
**YouTube search query:** “css colors hex named colors”

### Check the Key Points
- `color` = text, `background-color` = background.  
- Named colors are easy to start with.  
- Hex codes give precise control.  
- Good contrast improves readability.

---

## Lesson 4.4 — Typography: Fonts, Size, Weight, and Alignment

**Lesson ID:** fe1-4-4  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Control font family, size, weight, and text alignment.

### AI Visual Banner Specification
Text samples showing different fonts, sizes, and bold/regular weights. Cody adjusting a type scale.

### Story / Hook
**Shady:** The default font looks a bit boring. Can I change it?  
**Cody:** Yes — typography is a big part of how professional pages feel.

### Learn Section
```css
body {
  font-family: Arial, sans-serif;
  font-size: 16px;
}

h1 {
  font-size: 2rem;
  font-weight: bold;
  text-align: center;
}

p {
  font-weight: normal;
  text-align: left;
  line-height: 1.5;
}
```

Important properties:  
- `font-family` — which font to use (always provide a fallback)  
- `font-size` — size of the text  
- `font-weight` — normal, bold, or numeric values  
- `text-align` — left, center, right, justify  
- `line-height` — space between lines (improves readability)  

### Example
A clean reading style for articles.

### Interactive Activity — Live Preview
Change the body font, make the main heading larger and centered, and increase the line-height of paragraphs.

### Practice
Write CSS that centers a heading and makes paragraphs slightly larger than the default.

### Feedback
Use `text-align: center` on the heading and `font-size` on the paragraphs.

### Tiny Challenge
Create a class `.big-text` that increases font size and another class `.center` that centers text.

### Quick Check
**Question:** Which property controls whether text is bold?  
A) `font-size`  
B) `font-weight`  
C) `text-align`  

**Correct Answer:** B

### Lesson Mission
Improve the typography of one of your earlier pages so it feels more pleasant to read.

### Summary Image Concept
Typography specimen sheet with labels.

### Want to Learn More?
**YouTube search query:** “css font-family font-size text-align”

### Check the Key Points
- Choose readable fonts and always give a fallback.  
- Control size, weight, and alignment.  
- Good line-height makes text easier to read.  
- Consistency across the page looks professional.

---

## Lesson 4.5 — Linking an External Stylesheet

**Lesson ID:** fe1-4-5  
**Duration:** 10–12 min  
**XP Reward:** 25  
**Primary Objective:** Connect an HTML file to an external CSS file correctly.

### AI Visual Banner Specification
An HTML file and a CSS file connected by a glowing `<link>` bridge.

### Story / Hook
**Shady:** My style block is getting long. Can I move the CSS to its own file?  
**Cody:** Yes — and that is the professional way to work.

### Learn Section
In the `<head>` of your HTML:

```html
<link rel="stylesheet" href="styles.css">
```

- `rel="stylesheet"` tells the browser this is a style sheet  
- `href` points to the CSS file  

The CSS file itself contains only CSS rules — no HTML tags:

```css
/* styles.css */
body {
  font-family: Arial, sans-serif;
  background-color: #fafafa;
}

h1 {
  color: #223;
}
```

Benefits:  
- One CSS file can style many HTML pages  
- Easier to maintain  
- Cleaner HTML  

### Example
A two-file mini project: `index.html` + `styles.css`.

### Interactive Activity
(Conceptual + practical) Create the link tag and a simple external rule that changes the body background.

### Practice
Write the exact `<link>` element needed to load a file named `main.css` from the same folder.

### Feedback
`<link rel="stylesheet" href="main.css">`

### Tiny Challenge
Describe one advantage of external CSS over internal CSS.

### Quick Check
**Question:** Where should the `<link>` element for a stylesheet usually be placed?  
A) Inside the `<body>`  
B) Inside the `<head>`  
C) After the closing `</html>`  

**Correct Answer:** B

### Lesson Mission
Convert one of your internal-style pages into an external-stylesheet version.

### Summary Image Concept
HTML and CSS files side by side with the link relationship shown.

### Want to Learn More?
**YouTube search query:** “how to link css file to html”

### Check the Key Points
- Use `<link rel="stylesheet" href="...">`.  
- Place it in the `<head>`.  
- External CSS keeps projects organized.  
- The CSS file contains pure CSS rules.

---

# CHAPTER 5 — The CSS Box Model and Basic Page Flow

**Chapter Goal:** Understand how every element is a box and control spacing and sizing.

---

## Lesson 5.1 — The Box Model Concept

**Lesson ID:** fe1-5-1  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Explain the four parts of the CSS box model.

### AI Visual Banner Specification
A clear diagram of the box model: content → padding → border → margin, with Cody pointing at each layer.

### Story / Hook
**Shady:** Why is there space around my elements that I didn’t expect?  
**Cody:** Because every HTML element is a rectangular box with several layers. Welcome to the box model!

### Learn Section
Every element generates a box that consists of:

1. **Content** — the text or image itself  
2. **Padding** — space between the content and the border  
3. **Border** — the line around the padding  
4. **Margin** — space outside the border (separates elements from each other)

```css
.box {
  width: 200px;
  padding: 20px;
  border: 3px solid black;
  margin: 15px;
}
```

Understanding the box model is the key to controlling layout and spacing at Level 1.

### Example
A visible box with background, padding, border, and margin so the student can see each part.

### Interactive Activity — Live Preview
Create a div with a background color, then add padding, border, and margin one by one while watching the preview.

### Practice
Name the four parts of the box model from the inside out.

### Feedback
Content → Padding → Border → Margin.

### Tiny Challenge
Make a box that has different padding and margin values and observe the difference.

### Quick Check
**Question:** Which part of the box model is the space *outside* the border?  
A) Padding  
B) Margin  
C) Content  

**Correct Answer:** B

### Lesson Mission
Draw (or describe) the box model and create one styled box that clearly shows all four parts.

### Summary Image Concept
Classic box-model diagram with labels and example values.

### Want to Learn More?
**YouTube search query:** “css box model explained for beginners”

### Check the Key Points
- Every element is a box.  
- Content + padding + border + margin.  
- Padding is inside, margin is outside.  
- Mastering the box model unlocks layout control.

---

## Lesson 5.2 — Padding, Border, and Margin in Practice

**Lesson ID:** fe1-5-2  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Apply padding, border, and margin with individual and shorthand values.

### AI Visual Banner Specification
Three control knobs labeled padding, border, margin with live preview of a box changing size.

### Story / Hook
**Shady:** How do I write the values for padding and margin?  
**Cody:** You can set all sides at once or control each side individually.

### Learn Section
```css
.card {
  padding: 20px;                  /* all four sides */
  padding: 10px 20px;             /* top/bottom | left/right */
  padding: 10px 15px 20px 25px;   /* top | right | bottom | left */

  margin: 15px;
  margin-top: 30px;

  border: 2px solid #333;
  border-radius: 8px;             /* rounded corners (bonus) */
}
```

You can also set individual sides:  
`padding-top`, `margin-left`, `border-bottom`, etc.

### Example
A card-style box with comfortable padding and a subtle border.

### Interactive Activity — Live Preview
Style a paragraph or div so it has:  
- 20px padding  
- a 2px solid border  
- 15px margin  

Observe how the space changes.

### Practice
Write a rule that adds more space above an element than below it.

### Feedback
Use `margin-top` larger than `margin-bottom`, or the four-value margin shorthand.

### Tiny Challenge
Create two boxes that are separated by margin and each have internal padding.

### Quick Check
**Question:** If you write `padding: 10px 20px;`, what does the 20px control?  
A) Top and bottom  
B) Left and right  
C) All four sides  

**Correct Answer:** B

### Lesson Mission
Create a simple “card” component using padding, border, and margin.

### Summary Image Concept
Box with arrows showing padding (inner) and margin (outer).

### Want to Learn More?
**YouTube search query:** “css padding margin border shorthand”

### Check the Key Points
- Padding adds space inside the border.  
- Margin adds space outside the border.  
- Border draws the edge.  
- Shorthand values save time.

---

## Lesson 5.3 — Width, Height, and box-sizing

**Lesson ID:** fe1-5-3  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Control element size and understand the basic idea of box-sizing.

### AI Visual Banner Specification
Two boxes of the same “width: 200px” — one growing larger because of padding (content-box) and one staying 200px (border-box).

### Story / Hook
**Shady:** I set width to 200px but the box looks wider. Why?  
**Cody:** Because by default padding and border are added on top of the width. Let’s fix that understanding.

### Learn Section
```css
.box {
  width: 200px;
  height: 100px;
  padding: 20px;
  border: 5px solid black;
}
```

By default (`box-sizing: content-box`):  
Final size = width + padding + border  

Modern best practice:
```css
* {
  box-sizing: border-box;
}
```

With `border-box`, the declared width includes padding and border, which makes sizing much more predictable.

For Level 1 it is enough to know:  
- You can set `width` and `height`  
- Padding and border affect the final size  
- `box-sizing: border-box` is a helpful habit  

### Example
Two side-by-side boxes demonstrating the difference (conceptually).

### Interactive Activity — Live Preview
Set a width on a box, then add padding and observe the change. Optionally add `box-sizing: border-box` and compare.

### Practice
What is the advantage of `box-sizing: border-box`?

### Feedback
The width you set is the final visible width, including padding and border.

### Tiny Challenge
Create a box that is exactly 300px wide including its padding and border.

### Quick Check
**Question:** Which property helps make width calculations more intuitive by including padding and border?  
A) `box-sizing: content-box`  
B) `box-sizing: border-box`  
C) `display: block`  

**Correct Answer:** B

### Lesson Mission
Apply consistent widths and comfortable padding to the main sections of one of your pages.

### Summary Image Concept
Content-box vs border-box comparison diagram.

### Want to Learn More?
**YouTube search query:** “css box-sizing border-box”

### Check the Key Points
- You can set width and height.  
- Default box model adds padding and border outside the width.  
- `border-box` makes sizing easier.  
- Use it as a good habit.

---

## Lesson 5.4 — Block vs Inline Elements

**Lesson ID:** fe1-5-4  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Distinguish block-level and inline elements and understand basic page flow.

### AI Visual Banner Specification
Block elements stacked vertically and inline elements sitting on the same line, with Cody explaining the difference.

### Story / Hook
**Shady:** Why do some elements start on a new line while others sit next to each other?  
**Cody:** Because some elements are block-level and others are inline. This is the foundation of page flow.

### Learn Section
**Block-level elements** (examples: `<h1>`, `<p>`, `<div>`, `<ul>`, `<li>`, `<section>`):  
- Start on a new line  
- Take up the full available width by default  
- You can set width, height, margin, and padding freely  

**Inline elements** (examples: `<a>`, `<span>`, `<strong>`, `<em>`, `<img>`):  
- Sit within a line of text  
- Only take up as much width as their content needs  
- Top and bottom margins do not push other elements the same way  

You can change the behavior with the `display` property (for example `display: inline-block`), but for Level 1 it is enough to recognize the default behavior.

### Example
A paragraph that contains a link and a strong element — the link and strong stay on the same line as the text.

### Interactive Activity — Live Preview
Place several block elements and several inline elements and observe how they flow.

### Practice
Name three block elements and three inline elements.

### Feedback
Block: headings, paragraphs, divs, lists…  
Inline: links, spans, strong, em, images…

### Tiny Challenge
Wrap a few words inside a paragraph with `<span class="highlight">` and style only those words.

### Quick Check
**Question:** Which type of element starts on a new line and takes full width by default?  
A) Inline  
B) Block  
C) Neither  

**Correct Answer:** B

### Lesson Mission
Build a short page that intentionally mixes block and inline elements and explain the flow you observe.

### Summary Image Concept
Visual comparison of block vs inline layout.

### Want to Learn More?
**YouTube search query:** “css block vs inline elements”

### Check the Key Points
- Block elements stack vertically and take full width.  
- Inline elements sit within a line.  
- Understanding flow is essential before learning advanced layout.  
- Flexbox and Grid come in Level 2.

---

## Lesson 5.5 — Putting Spacing and Flow Together

**Lesson ID:** fe1-5-5  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Combine box model, typography, and basic flow to create a clean multi-section page.

### AI Visual Banner Specification
A polished multi-section page with clear spacing, Cody and Shady giving a thumbs-up.

### Story / Hook
**Shady:** I know the individual pieces. How do I make a whole page that looks tidy?  
**Cody:** By combining structure, the box model, and consistent spacing. Let’s practice.

### Learn Section
Practical checklist for a clean Level 1 page:  
1. Solid HTML structure and hierarchy  
2. External (or internal) CSS with clear selectors  
3. Readable typography  
4. Consistent padding and margin  
5. Visible but not excessive borders if needed  
6. Good contrast between text and background  

Avoid:  
- Random spacing values  
- Overlapping elements  
- Text that is too close to the edges  

### Example
A simple profile-style page with header, about section, skills list, and footer — all properly spaced.

### Interactive Activity — Live Preview
Take any previous page and improve its spacing, typography, and overall cleanliness using only Level 1 techniques.

### Practice
List three improvements you can make to a plain HTML page using CSS.

### Feedback
Examples: better fonts, colors, padding, margins, alignment.

### Tiny Challenge
Create a “card” that contains a heading, a short paragraph, and a list, all comfortably spaced.

### Quick Check
**Question:** What is a good general approach to spacing on a page?  
A) Use random large numbers  
B) Apply consistent padding and margin so content has room to breathe  
C) Remove all margin and padding  

**Correct Answer:** B

### Lesson Mission
Polish one complete page so it feels organized and pleasant to read.

### Summary Image Concept
Before-and-after of a page with improved spacing and typography.

### Want to Learn More?
**YouTube search query:** “css spacing best practices beginners”

### Check the Key Points
- Combine structure + box model + typography.  
- Consistency looks professional.  
- Leave breathing room around content.  
- You now have the tools for solid Level 1 pages.

---

# FINAL PROJECT — Frontend Level 1

**Project Title:** Personal / Student Profile Page  
**Estimated Time:** 60–120 minutes  
**XP Reward:** 100  

### Project Goal
Create a small multi-section personal or student profile webpage that demonstrates everything you learned in Frontend Level 1.

### Requirements
Your page must include:  
- Correct HTML5 document structure  
- Multiple sections with proper headings and paragraphs  
- At least one image with meaningful alt text  
- Navigation links (can be internal anchors or placeholder pages)  
- At least one list (ordered or unordered)  
- A simple table **or** a simple form  
- External CSS file linked correctly  
- Element, class, and/or ID selectors  
- Colors, typography, and text alignment  
- Clear use of the box model (padding, margin, border where appropriate)  
- Good overall spacing and readability  

**Do NOT use:**  
- Flexbox or Grid (those belong to Level 2)  
- Advanced responsive techniques  
- JavaScript / DOM manipulation  

### Suggested Sections
1. Header with name and a short tagline  
2. About Me  
3. Skills or Courses (list)  
4. Progress or Schedule (table) **or** Contact form  
5. Footer with links or copyright  

### Success Criteria
- Valid, well-structured HTML  
- External CSS that clearly improves appearance  
- Consistent spacing and readable text  
- All required elements present  
- Code is commented where helpful  

### Submission Tips
- Build the HTML structure first, then add CSS  
- Test in the live preview frequently  
- Keep the design simple and clean  

### After the Project
Congratulations! You can now build solid, well-structured web pages with HTML and CSS.  
You are ready for **Frontend Level 2**, where you will learn modern layout techniques (Flexbox & Grid) and responsive design.

---

**End of Frontend Level 1 — English Content Source**  
*SPS Code Orbit — Authoritative Curriculum File*  
