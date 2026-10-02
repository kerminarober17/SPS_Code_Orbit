# SPS Code Orbit — JavaScript Level 1
**Course Title:** JavaScript Level 1 — Speak the Language of the Web  
**Level:** 1  
**Track:** JavaScript Track  
**Prerequisite:** Programming Foundations (recommended)  
**Difficulty:** Beginner  
**Language:** English  

**Course Description:**  
Welcome to JavaScript Level 1! In this course you will learn the fundamental building blocks of JavaScript — the language that makes websites interactive. You will start from zero syntax knowledge and finish with solid skills in variables, data types, operators, decisions, functions, arrays, objects, and loops. You will also learn how to include JavaScript in an HTML page.  

No previous JavaScript experience is required. We build everything step by step with Cody (your patient mentor) and Shady (a curious beginner like you).

**Learning Outcomes:**  
By the end of this course you will be able to:  
- Explain what JavaScript is and where it runs  
- Write and run simple JavaScript statements in the browser console and in a code playground  
- Declare and use variables with `let` and `const`  
- Work with strings, numbers, booleans, null, and undefined  
- Use arithmetic, assignment, and comparison operators  
- Make decisions with `if`, `else`, and `else if`  
- Create and call simple functions with parameters and return values  
- Create and manipulate arrays and objects  
- Repeat actions with `for`, `while`, and `for...of` loops  
- Include JavaScript in an HTML page using the `<script>` tag  

**Course Structure:** 6 Chapters + Final Project  

---

# CHAPTER 1 — Getting Started with JavaScript

**Chapter Goal:** Understand what JavaScript is, where it runs, and write your first statements.

---

## Lesson 1.1 — What Is JavaScript?

**Lesson ID:** js1-1-1  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Explain what JavaScript is and its role on the web.

### AI Visual Banner Specification
A friendly space scene: Cody (robot mentor) pointing at a glowing “JS” logo floating between a browser window and a planet labeled “Web”. Shady looking curious with a speech bubble “What’s JavaScript?”. Soft blue and yellow tones.

### Story / Hook
**Shady:** Cody, I keep hearing people say “JavaScript makes websites come alive.” Is it the same as Java?  
**Cody:** Great question! JavaScript and Java are completely different languages. JavaScript is the language that runs inside web browsers and adds behavior to web pages. Let’s explore what that really means.

### Learn Section
JavaScript is a **programming language** created to make web pages interactive.  

When you visit a website you usually see three layers:  
- **HTML** → structure and content (the skeleton)  
- **CSS** → appearance and layout (the look)  
- **JavaScript** → behavior and interactivity (the actions)

JavaScript can:  
- Respond when a user clicks a button  
- Show or hide content  
- Calculate values  
- Update text on the page  
- Validate forms  

Important facts for beginners:  
- JavaScript was invented in 1995 by Brendan Eich.  
- It runs directly in the browser — you do not need to install extra software to try it.  
- It is one of the most popular programming languages in the world.  
- Many modern websites use HTML, CSS, and JavaScript together, but not every webpage *requires* JavaScript.

JavaScript is **not** the same as Java. They share a similar name for historical reasons, but their syntax and purpose are different.

### Example
Imagine a simple webpage with a button that says “Say Hello”.  
When you click the button, a message appears: “Hello, Code Orbit!”.  
That click-and-respond behavior is powered by JavaScript.

### Interactive Activity
Open the browser’s Developer Tools (usually by pressing F12 or right-click → Inspect).  
Find the **Console** tab.  
Type the following and press Enter:

```javascript
console.log("Hello from JavaScript!");
```

You should see the message appear in the console.

### Practice
1. What are the three main technologies used to build modern websites?  
2. Which one is responsible for behavior and interactivity?  
3. Is JavaScript the same language as Java?

### Feedback
- Correct answers: HTML (structure), CSS (appearance), JavaScript (behavior).  
- JavaScript is different from Java.

### Tiny Challenge
In the console, type a message that includes your name using `console.log`.

### Quick Check
**Question:** What is the main job of JavaScript on a webpage?  
A) To describe the structure of the page  
B) To style the colors and fonts  
C) To add behavior and interactivity  
D) To store files on a server  

**Correct Answer:** C  
**Explanation:** JavaScript is the language that makes pages respond to users and perform actions.

### Lesson Mission
Explain to a friend (or write in your notes) what JavaScript does and how it is different from HTML and CSS.

### Summary Image Concept
Cody holding three labeled cards: HTML (structure), CSS (style), JavaScript (behavior). Shady pointing at the JavaScript card with a big smile.

### Want to Learn More?
**YouTube search query:** “what is javascript for beginners”

### Check the Key Points
- JavaScript is a programming language that adds behavior to web pages.  
- It works together with HTML and CSS.  
- It runs inside the browser.  
- It is not the same as Java.

---

## Lesson 1.2 — Where JavaScript Runs

**Lesson ID:** js1-1-2  
**Duration:** 10 min  
**XP Reward:** 20  
**Primary Objective:** Identify the main environments where JavaScript can run, focusing on the browser.

### AI Visual Banner Specification
Cody standing next to a large browser window showing a console, with smaller icons of a server and a phone in the background. Shady asking “Where does the code actually run?”

### Story / Hook
**Shady:** So if I write JavaScript, where does the computer actually run it?  
**Cody:** Excellent question! The most important place for beginners is the web browser. Let’s see how that works.

### Learn Section
JavaScript can run in several places, but for this Level 1 course we focus on the **browser**.

**1. Inside the Web Browser**  
Every modern browser (Chrome, Firefox, Edge, Safari) contains a JavaScript engine.  
When the browser loads a webpage that contains JavaScript, the engine reads and executes the code.

**2. Browser Developer Console**  
You can also type JavaScript directly into the Console and see results immediately. This is perfect for learning and testing small pieces of code.

**3. Other environments (just for awareness)**  
- Node.js allows JavaScript to run on servers (outside the browser).  
- Some mobile apps and desktop apps also use JavaScript.  

In this course we stay inside the browser and the Code Orbit playground. You do not need Node.js yet.

### Example
When you open a webpage and the page shows a live clock or a button that changes color, that JavaScript is running inside your browser’s JavaScript engine.

### Interactive Activity
1. Open any website.  
2. Open Developer Tools → Console.  
3. Type:  
```javascript
typeof "Hello"
```  
4. Press Enter and observe the result.

### Practice
Where does the JavaScript of a normal website usually run?  
A) On the user’s computer inside the browser  
B) Only on a distant server  
C) Inside the HTML file itself as text  

### Feedback
Correct answer is A. The browser downloads the JavaScript and runs it locally on the user’s device.

### Tiny Challenge
In the console, run:  
```javascript
console.log(2 + 3);
```  
Confirm you see the number 5.

### Quick Check
**Question:** Which tool lets you type and run JavaScript immediately without creating a file?  
A) The browser Developer Console  
B) A text editor only  
C) A printer  

**Correct Answer:** A

### Lesson Mission
Write one sentence explaining where JavaScript runs when you visit a normal website.

### Summary Image Concept
A browser window with a glowing JavaScript engine inside it, and Cody pointing to the console tab.

### Want to Learn More?
**YouTube search query:** “javascript engine browser explained for beginners”

### Check the Key Points
- JavaScript primarily runs inside the browser.  
- The Developer Console is a great place to experiment.  
- Node.js and other environments exist but are not required for Level 1.

---

## Lesson 1.3 — Your First JavaScript Statements

**Lesson ID:** js1-1-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Write and run basic `console.log` statements and understand statements.

### AI Visual Banner Specification
Cody and Shady in front of a large code editor showing `console.log("Hello, Code Orbit!");` with a green “Run” button and output panel.

### Story / Hook
**Shady:** I’m ready to write real code! What’s the simplest thing I can type?  
**Cody:** Let’s start with the classic first statement — telling the computer to print a message.

### Learn Section
A **statement** is a complete instruction that JavaScript can execute.  

The simplest useful statement is:

```javascript
console.log("Hello, Code Orbit!");
```

- `console` is an object provided by the browser.  
- `.log()` is a method that prints a value to the console.  
- The text inside the quotes is a **string**.  
- The semicolon `;` marks the end of the statement (optional in many cases, but good practice).

You can also print numbers and results of calculations:

```javascript
console.log(42);
console.log(10 + 5);
```

### Example
```javascript
console.log("Welcome to SPS Code Orbit");
console.log(2026);
console.log("2 + 2 =", 2 + 2);
```

**Expected output:**
```
Welcome to SPS Code Orbit
2026
2 + 2 = 4
```

### Interactive Activity — Code Playground
**Language:** JavaScript  
**Initial code:**
```javascript
console.log("Hello, Code Orbit!");
```
**Editable area:** Yes  
**Expected output:** `Hello, Code Orbit!`  
**Evaluation rules:** Student code must contain at least one `console.log` that prints a non-empty string.  
**Success condition:** Output appears and contains the word “Hello” or any personal greeting.  
**Common mistakes:**  
- Forgetting the quotes around text  
- Misspelling `console` or `log`  
- Using single quotes inconsistently (both work, but be consistent)  
**Feedback:** If successful → “Great job! You just ran your first JavaScript statement.”  

**External Resource:**  
- external_resource_title: Try More Code  
- external_resource_description: Practice more console statements in a free online editor  
- external_resource_target: https://jsfiddle.net/ or https://codepen.io/pen/

### Practice
Write three `console.log` statements that print:  
1. Your first name  
2. Your favorite number  
3. The result of 15 – 7

### Feedback
Expected pattern:
```javascript
console.log("Shady");
console.log(7);
console.log(15 - 7);
```

### Tiny Challenge
Print the message: `I am learning JavaScript!` and also print the number of letters in the word “JavaScript” (which is 10).

### Quick Check
**Question:** What does `console.log("Hi")` do?  
A) Saves a file named Hi  
B) Prints the text Hi to the console  
C) Deletes the console  

**Correct Answer:** B

### Lesson Mission
Create a short “About Me” output using three `console.log` statements.

### Summary Image Concept
A console window showing the output of a first program with Cody giving a thumbs-up.

### Want to Learn More?
**YouTube search query:** “console.log javascript beginners”

### Check the Key Points
- A statement is a complete instruction.  
- `console.log()` prints values to the console.  
- Strings need quotes.  
- You can print numbers and calculations too.

---

## Lesson 1.4 — Comments and Basic Syntax

**Lesson ID:** js1-1-4  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Use single-line and multi-line comments and understand basic syntax rules.

### AI Visual Banner Specification
Code snippet with green comment text and Cody explaining “Comments are notes for humans”.

### Story / Hook
**Shady:** Sometimes I write a note to myself in code and the program breaks. Why?  
**Cody:** Because the computer tries to run everything unless you mark it as a comment. Let’s learn how to write notes safely.

### Learn Section
**Comments** are text that JavaScript ignores. They are for humans only.

**Single-line comment:**
```javascript
// This is a single-line comment
console.log("This still runs");
```

**Multi-line comment:**
```javascript
/*
  This is a multi-line comment.
  It can span several lines.
*/
console.log("Still running!");
```

**Basic syntax rules for Level 1:**  
- Statements usually end with a semicolon `;`  
- JavaScript is **case-sensitive** (`Console` is different from `console`)  
- Strings can use double quotes `" "` or single quotes `' '`  
- Indentation (spaces) helps humans read the code but does not change how it runs  
- Extra spaces around operators are usually fine

### Example
```javascript
// Print a greeting
console.log("Hello!");

/*
  Calculate a simple sum
  and show the result
*/
console.log(5 + 3);
```

### Interactive Activity — Code Playground
**Initial code:**
```javascript
// Write your name below this comment
console.log("Your Name Here");
```
**Task:** Replace the placeholder and add one multi-line comment describing what the program does.  
**Success condition:** Code runs without errors and contains both `//` and `/* */` comments.

### Practice
Add useful comments to this code:
```javascript
console.log(10 * 2);
console.log("Done");
```

### Feedback
Good practice looks like:
```javascript
// Multiply 10 by 2
console.log(10 * 2);

// Finished message
console.log("Done");
```

### Tiny Challenge
Write a short program that prints “Comments are helpful” and includes both a single-line and a multi-line comment.

### Quick Check
**Question:** What happens to text written after `//` on the same line?  
A) It is executed as code  
B) It is ignored by JavaScript  
C) It causes an error  

**Correct Answer:** B

### Lesson Mission
Take any previous `console.log` program and add clear comments explaining each line.

### Summary Image Concept
Side-by-side: code with comments (green) and the same code without comments, highlighting readability.

### Want to Learn More?
**YouTube search query:** “javascript comments explained”

### Check the Key Points
- `//` starts a single-line comment.  
- `/* */` creates a multi-line comment.  
- Comments are ignored by the computer.  
- JavaScript is case-sensitive.

---

## Lesson 1.5 — Running Code and Reading Output

**Lesson ID:** js1-1-5  
**Duration:** 10 min  
**XP Reward:** 20  
**Primary Objective:** Confidently run code in the playground and interpret console output and error messages.

### AI Visual Banner Specification
Code editor with green “Success” output and a red error message next to it. Cody pointing at the difference.

### Story / Hook
**Shady:** Sometimes my code works, sometimes I get a red message. How do I know what went wrong?  
**Cody:** Reading the output and the error messages is a superpower. Let’s practice.

### Learn Section
When you run JavaScript:  
1. The code is executed from top to bottom.  
2. Successful `console.log` statements appear in the output area.  
3. If there is a **syntax error**, the program stops and shows a red error message.

Common beginner errors:  
- Missing closing quote: `"Hello`  
- Misspelled keyword: `consol.log`  
- Using the wrong quotes or brackets  

Always read the error message carefully — it often tells you the line number and the problem.

### Example
Correct code:
```javascript
console.log("All good");
```
Output: `All good`

Broken code:
```javascript
console.log("Missing quote);
```
Error: something like `Uncaught SyntaxError: Invalid or unexpected token`

### Interactive Activity — Code Playground
**Initial code (intentionally broken):**
```javascript
console.log("Hello Code Orbit)
```
**Task:** Fix the missing quote so the program runs.  
**Success condition:** Output shows `Hello Code Orbit` without errors.

### Practice
Predict the output or error for each:
1. `console.log(5 + 5);`  
2. `console.log("5 + 5);`  
3. `Console.log("Hi");`

### Feedback
1. Prints 10  
2. Syntax error (missing quote)  
3. Error because `Console` is capitalized (case-sensitive)

### Tiny Challenge
Write a program that prints two lines. Then deliberately break one line and fix it again.

### Quick Check
**Question:** What should you do first when you see a red error message?  
A) Delete all the code  
B) Read the error message and check the line number  
C) Restart the computer  

**Correct Answer:** B

### Lesson Mission
Run three different statements and write down what each output looks like.

### Summary Image Concept
Split screen: happy green output vs red error message with Cody explaining “Read the message!”

### Want to Learn More?
**YouTube search query:** “how to read javascript errors beginners”

### Check the Key Points
- Code runs from top to bottom.  
- Successful output appears in the console.  
- Error messages help you find mistakes.  
- Always read the error carefully.

---

# CHAPTER 2 — Variables and Data Types

**Chapter Goal:** Store and work with different kinds of data using variables.

---

## Lesson 2.1 — Introducing Variables with let and const

**Lesson ID:** js1-2-1  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Declare variables using `let` and `const` and understand the difference.

### AI Visual Banner Specification
Cody holding two boxes labeled `let` (changeable) and `const` (constant). Shady putting values into the boxes.

### Story / Hook
**Shady:** I want to remember a score or a name so I can use it later. Do I have to type the value every time?  
**Cody:** No! We use **variables** — named containers that hold values.

### Learn Section
A **variable** is a named place in memory that stores a value.

**Declaring with `let`** (value can change later):
```javascript
let score = 10;
console.log(score);   // 10
score = 15;
console.log(score);   // 15
```

**Declaring with `const`** (value cannot be reassigned):
```javascript
const name = "Shady";
console.log(name);    // Shady
// name = "Cody";    // This would cause an error
```

**Rules:**  
- Use `const` when the value should not change.  
- Use `let` when you need to update the value.  
- Always declare a variable before using it.  
- Variable names should be descriptive.

### Example
```javascript
let lives = 3;
const playerName = "Shady";

console.log(playerName);
console.log(lives);

lives = lives - 1;
console.log(lives);
```

**Expected output:**
```
Shady
3
2
```

### Interactive Activity — Code Playground
**Initial code:**
```javascript
let score = 0;
const course = "JavaScript Level 1";

console.log(course);
console.log(score);
```
**Task:** Change the score to 100 and print it again.  
**Success condition:** Output shows the course name and the updated score 100.  
**Common mistakes:** Trying to reassign a `const`, forgetting to declare the variable.

**External Resource:** Try More Code → https://jsfiddle.net/

### Practice
Create two variables:  
- `const favoriteColor = "blue";`  
- `let age = 15;`  
Print both, then change `age` to 16 and print again.

### Feedback
```javascript
const favoriteColor = "blue";
let age = 15;
console.log(favoriteColor);
console.log(age);
age = 16;
console.log(age);
```

### Tiny Challenge
Declare a `const` for your name and a `let` for your current level. Print a message that uses both.

### Quick Check
**Question:** Which keyword should you use if the value must never change?  
A) `let`  
B) `const`  
C) `var`  

**Correct Answer:** B  
*(Note: We focus on `let` and `const` in Level 1. `var` is older and not recommended for new code.)*

### Lesson Mission
Write a short program that stores your name (`const`) and a changing score (`let`).

### Summary Image Concept
Two boxes: one locked (`const`) and one unlocked (`let`) with values inside.

### Want to Learn More?
**YouTube search query:** “let vs const javascript beginners”

### Check the Key Points
- `let` allows reassignment.  
- `const` does not allow reassignment.  
- Variables store values for later use.  
- Choose meaningful names.

---

## Lesson 2.2 — Variable Naming Rules

**Lesson ID:** js1-2-2  
**Duration:** 10 min  
**XP Reward:** 20  
**Primary Objective:** Follow correct JavaScript variable naming conventions.

### AI Visual Banner Specification
List of good and bad variable names with green checkmarks and red crosses. Cody nodding.

### Story / Hook
**Shady:** Can I name a variable `2score` or `my-score`?  
**Cody:** Some names are allowed by the language, some are not, and some are allowed but not recommended. Let’s learn the rules.

### Learn Section
**Valid variable names:**  
- Can contain letters, digits, `$`, and `_`  
- Cannot start with a digit  
- Cannot contain spaces or hyphens  
- Are case-sensitive (`score` and `Score` are different)

**Good naming conventions (camelCase):**  
```javascript
let playerScore = 0;
const maxLives = 3;
let isGameOver = false;
```

**Avoid:**  
- Single letters unless the meaning is obvious (e.g., `i` in a loop)  
- Reserved words such as `let`, `const`, `if`, `function`  
- Names that do not describe the data

### Example
```javascript
// Good
let userName = "Shady";
const MAX_SCORE = 100;

// Bad (will cause errors or confusion)
// let 2ndPlace = "silver";   // starts with digit
// let user-name = "Shady";   // hyphen not allowed
```

### Interactive Activity
Fix the invalid names in this code so it runs:
```javascript
let 1stName = "Shady";
let user-name = "Cody";
console.log(1stName);
```

### Practice
Rewrite these poor names into good camelCase names:  
- `player score`  
- `MaxLives`  
- `x`

### Feedback
Suggested: `playerScore`, `maxLives`, `score` or a more descriptive name.

### Tiny Challenge
Create three well-named variables related to a game and print them.

### Quick Check
**Question:** Which variable name is valid?  
A) `2score`  
B) `player-score`  
C) `playerScore`  

**Correct Answer:** C

### Lesson Mission
Review any previous code and improve the variable names if needed.

### Summary Image Concept
A “Name Checklist” poster with Cody’s tips.

### Want to Learn More?
**YouTube search query:** “javascript variable naming conventions”

### Check the Key Points
- Names cannot start with a number.  
- No spaces or hyphens.  
- Use camelCase for readability.  
- Choose descriptive names.

---

## Lesson 2.3 — Strings and Template Literals

**Lesson ID:** js1-2-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Create strings and use template literals for clean string building.

### AI Visual Banner Specification
Cody weaving text and variables together into a glowing string with backticks.

### Story / Hook
**Shady:** I want to say “Hello, Shady!” but the name is stored in a variable. How do I combine them?  
**Cody:** Classic strings work, but template literals make it much cleaner. Let’s see both ways.

### Learn Section
A **string** is text data.

```javascript
let greeting = "Hello";
let name = 'Shady';
```

**Concatenation (older way):**
```javascript
console.log(greeting + ", " + name + "!");
```

**Template literals (modern and preferred):**  
Use backticks `` ` `` and `${ }` to insert variables:

```javascript
console.log(`${greeting}, ${name}!`);
```

Template literals can also span multiple lines and include expressions:

```javascript
let score = 42;
console.log(`Your score is ${score + 8}`);
```

### Example
```javascript
const student = "Shady";
const course = "JavaScript Level 1";
const message = `Welcome ${student} to ${course}!`;
console.log(message);
```

**Expected output:**  
`Welcome Shady to JavaScript Level 1!`

### Interactive Activity — Code Playground
**Initial code:**
```javascript
const name = "Shady";
const language = "JavaScript";
// Create a template literal message below
```
**Task:** Create a message `I am learning JavaScript with Cody!` using the variables and template literals.  
**Success condition:** Output contains both the name and the language using `${}`.

### Practice
Using template literals, print:  
`Player Shady has 3 lives left.`

### Feedback
```javascript
const player = "Shady";
const lives = 3;
console.log(`Player ${player} has ${lives} lives left.`);
```

### Tiny Challenge
Create a multi-line template literal that introduces yourself (name + favorite language).

### Quick Check
**Question:** Which character starts a template literal?  
A) Double quote `"`  
B) Single quote `'`  
C) Backtick `` ` ``  

**Correct Answer:** C

### Lesson Mission
Write a short introduction message about yourself using a template literal.

### Summary Image Concept
Before/after: messy `+` concatenation vs clean template literal.

### Want to Learn More?
**YouTube search query:** “javascript template literals beginners”

### Check the Key Points
- Strings hold text.  
- Template literals use backticks.  
- `${}` inserts values or expressions.  
- Template literals are cleaner than `+` concatenation.

---

## Lesson 2.4 — Numbers, Booleans, null and undefined

**Lesson ID:** js1-2-4  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Recognize and use the main primitive data types.

### AI Visual Banner Specification
Five floating icons: Number, String, Boolean (true/false switch), null (empty box), undefined (question mark).

### Story / Hook
**Shady:** So far I only used text and numbers. Are there other kinds of values?  
**Cody:** Yes! Let’s meet the most important data types you will use every day.

### Learn Section
**Number** — integers or decimals  
```javascript
let score = 100;
let temperature = 36.6;
```

**Boolean** — only two values: `true` or `false`  
```javascript
let isLoggedIn = true;
let hasKey = false;
```

**null** — intentional empty value  
```javascript
let selectedItem = null;
```

**undefined** — a variable has been declared but not given a value yet  
```javascript
let futureScore;
console.log(futureScore);  // undefined
```

**typeof operator** — tells you the type of a value  
```javascript
console.log(typeof 42);          // "number"
console.log(typeof "hello");     // "string"
console.log(typeof true);        // "boolean"
console.log(typeof null);        // "object" (historical quirk)
console.log(typeof undefined);   // "undefined"
```

### Example
```javascript
const name = "Shady";
let lives = 3;
let isAlive = true;
let powerUp = null;

console.log(typeof name);
console.log(typeof lives);
console.log(typeof isAlive);
console.log(powerUp);
```

### Interactive Activity — Code Playground
**Task:** Declare one variable of each type (string, number, boolean, null) and print their `typeof` results.

### Practice
Predict the output of:
```javascript
console.log(typeof 0);
console.log(typeof "0");
console.log(typeof false);
```

### Feedback
`"number"`, `"string"`, `"boolean"`

### Tiny Challenge
Create a small “player status” using all four types and print them with labels.

### Quick Check
**Question:** What is the value of a variable that has been declared but not assigned?  
A) `null`  
B) `undefined`  
C) `0`  

**Correct Answer:** B

### Lesson Mission
Write a program that stores and prints one example of each data type you learned.

### Summary Image Concept
Data-type cards with examples next to each type.

### Want to Learn More?
**YouTube search query:** “javascript data types typeof beginners”

### Check the Key Points
- Numbers, strings, and booleans are the most common types.  
- `null` means intentionally empty.  
- `undefined` means not yet assigned.  
- Use `typeof` to inspect a value’s type.

---

## Lesson 2.5 — Changing Variables and Simple Debugging

**Lesson ID:** js1-2-5  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Update `let` variables safely and fix common beginner mistakes.

### AI Visual Banner Specification
Cody debugging a broken line of code with a magnifying glass while Shady watches.

### Story / Hook
**Shady:** I tried to change a `const` and everything broke! Also sometimes I misspell a variable name.  
**Cody:** Perfect time to practice safe updating and basic debugging.

### Learn Section
You can change a `let` variable as many times as you need:

```javascript
let counter = 0;
counter = counter + 1;
counter += 1;          // shorter way
console.log(counter);  // 2
```

**Common mistakes and how to fix them:**  
1. Reassigning a `const` → use `let` instead if you need to change it.  
2. Using a variable before declaring it → declare first.  
3. Misspelling the variable name → JavaScript treats it as a new (undefined) variable.  
4. Forgetting quotes around strings → causes syntax errors.

### Example — Debugging Practice
Broken code:
```javascript
const score = 10;
score = 20;          // Error!
console.log(scor);   // misspelled
```

Fixed version:
```javascript
let score = 10;
score = 20;
console.log(score);
```

### Interactive Activity — Code Playground
**Initial (broken) code:**
```javascript
const points = 5;
points = points + 10;
console.log(point);
```
**Task:** Fix both errors so the program prints 15.  
**Success condition:** Output is `15` with no errors.

### Practice
Write code that starts with `let health = 100`, reduces it by 25, then prints the new value.

### Feedback
```javascript
let health = 100;
health = health - 25;
console.log(health);  // 75
```

### Tiny Challenge
Create a score that starts at 0, adds 10, then multiplies by 2. Print the final result. Include at least one comment.

### Quick Check
**Question:** What happens if you try to reassign a variable declared with `const`?  
A) It changes silently  
B) You get an error  
C) It becomes undefined  

**Correct Answer:** B

### Lesson Mission
Write a small “lives counter” that starts at 3 and loses one life, then prints the remaining lives. Add comments.

### Summary Image Concept
Before/after debugging: red error → green success with Cody celebrating.

### Want to Learn More?
**YouTube search query:** “common javascript errors beginners”

### Check the Key Points
- Only `let` variables can be reassigned.  
- Always declare before use.  
- Spelling matters.  
- Read error messages carefully.

---

# CHAPTER 3 — Operators and Expressions

**Chapter Goal:** Combine values and make comparisons using operators.

---

## Lesson 3.1 — Arithmetic Operators

**Lesson ID:** js1-3-1  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Use +, -, *, /, % and understand basic expressions.

### AI Visual Banner Specification
Cody at a calculator board showing the five arithmetic operators with simple examples.

### Story / Hook
**Shady:** Can JavaScript do math for me?  
**Cody:** Absolutely! Let’s meet the arithmetic operators.

### Learn Section
```javascript
console.log(10 + 3);   // 13  addition
console.log(10 - 3);   // 7   subtraction
console.log(10 * 3);   // 30  multiplication
console.log(10 / 3);   // 3.333... division
console.log(10 % 3);   // 1   remainder (modulo)
```

An **expression** is any valid combination of values and operators that produces a result.

```javascript
let total = 5 + 3 * 2;   // 11 (multiplication first)
```

You can store the result of an expression in a variable.

### Example
```javascript
let a = 8;
let b = 3;
console.log(a + b);
console.log(a % b);
console.log((a + b) * 2);
```

### Interactive Activity — Code Playground
**Task:** Calculate the area of a rectangle (width 12, height 5) and print it.  
**Success condition:** Output shows 60.

### Practice
Predict:  
`console.log(15 % 4);`  
`console.log(2 + 3 * 4);`

### Feedback
3 and 14

### Tiny Challenge
Write an expression that calculates how many full weeks are in 30 days and how many days are left over.

### Quick Check
**Question:** What does the `%` operator return?  
A) Percentage  
B) The remainder after division  
C) The average  

**Correct Answer:** B

### Lesson Mission
Create three useful calculations related to a game (score, lives, time) and print the results.

### Summary Image Concept
Arithmetic operator cards with examples.

### Want to Learn More?
**YouTube search query:** “javascript arithmetic operators”

### Check the Key Points
- `+ - * / %` are the basic arithmetic operators.  
- Expressions produce values.  
- Operator precedence: `*` and `/` before `+` and `-` (use parentheses to control order).

---

## Lesson 3.2 — Assignment Operators

**Lesson ID:** js1-3-2  
**Duration:** 10 min  
**XP Reward:** 20  
**Primary Objective:** Use `=`, `+=`, `-=`, `*=`, `/=` to update variables cleanly.

### AI Visual Banner Specification
Variable box being updated with short assignment arrows (`+=` etc.).

### Story / Hook
**Shady:** Writing `score = score + 10` every time feels long. Is there a shorter way?  
**Cody:** Yes — assignment operators!

### Learn Section
```javascript
let score = 10;

score += 5;   // same as score = score + 5
score -= 2;   // score = score - 2
score *= 2;   // score = score * 2
score /= 3;   // score = score / 3
```

These operators update the variable in place.

### Example
```javascript
let points = 0;
points += 10;
points += 5;
points *= 2;
console.log(points);  // 30
```

### Interactive Activity
Start with `let health = 100`.  
Use assignment operators to:  
- lose 20 health  
- gain 10 health  
- double the remaining health  
Print the final value.

### Practice
Rewrite using assignment operators:  
`counter = counter + 1`  
`total = total * 1.1`

### Feedback
`counter += 1;` and `total *= 1.1;`

### Tiny Challenge
Simulate a simple bank balance that starts at 100, adds 50, then subtracts 30 using only assignment operators.

### Quick Check
**Question:** What does `x += 3` mean?  
A) x is equal to 3  
B) Add 3 to the current value of x  
C) Multiply x by 3  

**Correct Answer:** B

### Lesson Mission
Write a short “score tracker” using at least three different assignment operators.

### Summary Image Concept
Before → after value of a variable with `+=` arrow.

### Want to Learn More?
**YouTube search query:** “javascript assignment operators”

### Check the Key Points
- Assignment operators update a variable.  
- `+=`, `-=`, `*=`, `/=` are the most common.  
- They make code shorter and clearer.

---

## Lesson 3.3 — Comparison Operators and Strict Equality

**Lesson ID:** js1-3-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Compare values using `===`, `!==`, `>`, `<`, `>=`, `<=`.

### AI Visual Banner Specification
Two values being compared with a glowing `===` symbol and true/false results.

### Story / Hook
**Shady:** How does the computer know if two things are equal or if one number is bigger?  
**Cody:** With comparison operators! And in modern JavaScript we prefer strict equality.

### Learn Section
```javascript
console.log(5 === 5);    // true   strict equality
console.log(5 === "5");  // false  different types
console.log(5 !== 3);    // true   not equal
console.log(10 > 5);     // true
console.log(10 < 5);     // false
console.log(10 >= 10);   // true
console.log(10 <= 9);    // false
```

**Why `===` instead of `==`?**  
`==` tries to convert types (can cause surprises).  
`===` checks both value and type — safer for beginners and professionals.

Always prefer `===` and `!==` in this course.

### Example
```javascript
const age = 15;
console.log(age >= 13);     // true
console.log(age === "15");  // false
```

### Interactive Activity — Code Playground
**Task:** Write comparisons that check:  
- if a score of 80 is greater than or equal to 70  
- if the string `"pass"` is strictly equal to `"Pass"`  
Print both results.

### Practice
Predict true or false:  
`7 === 7`  
`7 === "7"`  
`10 !== 10`  
`4 < 4`

### Feedback
true, false, false, false

### Tiny Challenge
Store a temperature and print whether it is above freezing (`> 0`).

### Quick Check
**Question:** What is the safest way to check if two values are equal in modern JavaScript?  
A) `==`  
B) `===`  
C) `=`  

**Correct Answer:** B

### Lesson Mission
Write five different comparisons related to a game (score, lives, level) and print the boolean results.

### Summary Image Concept
`===` vs `==` comparison chart with Cody recommending `===`.

### Want to Learn More?
**YouTube search query:** “javascript strict equality ===”

### Check the Key Points
- Comparison operators return `true` or `false`.  
- Prefer `===` and `!==`.  
- `>`, `<`, `>=`, `<=` compare numbers (and some other types).

---

## Lesson 3.4 — Building Useful Expressions

**Lesson ID:** js1-3-4  
**Duration:** 10–12 min  
**XP Reward:** 20  
**Primary Objective:** Combine operators and variables into meaningful expressions.

### AI Visual Banner Specification
Cody combining number blocks and operator blocks into a final result.

### Story / Hook
**Shady:** Now I know the operators, but how do I put them together for real problems?  
**Cody:** Let’s build practical expressions step by step.

### Learn Section
Expressions can mix variables, numbers, and operators:

```javascript
let price = 50;
let tax = 0.1;
let total = price + (price * tax);
console.log(total);  // 55
```

You can also combine comparisons with arithmetic:

```javascript
let score = 85;
let passed = score >= 60;
console.log(passed);  // true
```

Parentheses control the order of operations — use them freely for clarity.

### Example
```javascript
const width = 10;
const height = 5;
const area = width * height;
const perimeter = 2 * (width + height);
console.log(`Area: ${area}, Perimeter: ${perimeter}`);
```

### Interactive Activity
Calculate the average of three scores (80, 90, 70) and print whether the average is at least 75.

### Practice
Write an expression that calculates remaining lives after taking damage.

### Feedback
```javascript
let lives = 5;
let damage = 2;
let remaining = lives - damage;
```

### Tiny Challenge
Create a simple “discount calculator”: original price 100, discount 20%. Print the final price.

### Quick Check
**Question:** Why are parentheses useful in expressions?  
A) They are required for every calculation  
B) They control the order of operations and improve readability  
C) They convert numbers to strings  

**Correct Answer:** B

### Lesson Mission
Invent a small real-world calculation (shopping, game score, time) using at least three operators and print a clear message with a template literal.

### Summary Image Concept
Expression tree showing how values flow into a final result.

### Want to Learn More?
**YouTube search query:** “javascript expressions and operators”

### Check the Key Points
- Expressions combine values and operators.  
- Store results in variables when useful.  
- Use parentheses for clarity and correct order.  
- Template literals help present results nicely.

---

# CHAPTER 4 — Decisions and Functions

**Chapter Goal:** Make decisions with conditions and organize code with functions.

---

## Lesson 4.1 — Making Decisions with if and else

**Lesson ID:** js1-4-1  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Use `if` and `else` to run different code based on a condition.

### AI Visual Banner Specification
A path that splits into two roads labeled `true` and `false`, with Cody guiding Shady.

### Story / Hook
**Shady:** I want the program to do different things depending on the score. How?  
**Cody:** That is what the `if` statement is for!

### Learn Section
```javascript
let score = 75;

if (score >= 60) {
  console.log("You passed!");
} else {
  console.log("Try again.");
}
```

- The condition inside `()` must evaluate to `true` or `false`.  
- Code inside the first `{ }` runs only when the condition is true.  
- The `else` block runs when the condition is false.  
- `else` is optional.

### Example
```javascript
const temperature = 30;

if (temperature > 25) {
  console.log("It’s hot!");
} else {
  console.log("It’s comfortable or cool.");
}
```

### Interactive Activity — Code Playground
**Initial code:**
```javascript
let lives = 0;
// Write an if-else that prints "Game Over" or "Keep playing"
```
**Success condition:** Correct message based on the value of `lives`.

### Practice
Write a program that checks if a number is positive or not.

### Feedback
```javascript
let number = 5;
if (number > 0) {
  console.log("Positive");
} else {
  console.log("Zero or negative");
}
```

### Tiny Challenge
Check if a player’s score is at least 100 and print “Level up!” or “Keep going!”.

### Quick Check
**Question:** When does the `else` block run?  
A) Always  
B) Only when the `if` condition is false  
C) Only when the `if` condition is true  

**Correct Answer:** B

### Lesson Mission
Create a simple “pass/fail” checker for a test score.

### Summary Image Concept
Decision diamond with true/false paths.

### Want to Learn More?
**YouTube search query:** “javascript if else beginners”

### Check the Key Points
- `if` runs code when a condition is true.  
- `else` handles the opposite case.  
- Conditions use comparison operators.  
- Always use curly braces `{ }` for clarity.

---

## Lesson 4.2 — else if and Logical Operators

**Lesson ID:** js1-4-2  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Chain conditions with `else if` and combine them with `&&`, `||`, `!`.

### AI Visual Banner Specification
Cody with three paths (if / else if / else) and logic gates for AND/OR/NOT.

### Story / Hook
**Shady:** What if I have more than two possibilities — like grades A, B, C?  
**Cody:** Then we use `else if`. And logical operators let us combine conditions.

### Learn Section
```javascript
let score = 85;

if (score >= 90) {
  console.log("A");
} else if (score >= 80) {
  console.log("B");
} else if (score >= 70) {
  console.log("C");
} else {
  console.log("Needs improvement");
}
```

**Logical operators:**  
- `&&` (AND) — both sides must be true  
- `||` (OR) — at least one side true  
- `!` (NOT) — reverses true/false  

```javascript
let age = 15;
let hasPermission = true;

if (age >= 13 && hasPermission) {
  console.log("You may enter");
}
```

### Example
```javascript
const temperature = 22;
const isRaining = false;

if (temperature > 20 && !isRaining) {
  console.log("Nice day for a walk!");
} else {
  console.log("Maybe stay inside.");
}
```

### Interactive Activity
Write a program that prints a message based on a player’s level:  
- level ≥ 10 → “Expert”  
- level ≥ 5 → “Intermediate”  
- otherwise → “Beginner”

### Practice
Check if a number is between 1 and 10 (inclusive) using `&&`.

### Feedback
```javascript
let n = 7;
if (n >= 1 && n <= 10) {
  console.log("In range");
}
```

### Tiny Challenge
Create a login check: username must be “Shady” **and** password length must be at least 4 (you can hard-code the values for now).

### Quick Check
**Question:** What does `&&` require?  
A) Only one condition true  
B) Both conditions true  
C) Both conditions false  

**Correct Answer:** B

### Lesson Mission
Build a small weather advisor using `else if` and at least one logical operator.

### Summary Image Concept
Flowchart with multiple branches and logic symbols.

### Want to Learn More?
**YouTube search query:** “javascript else if logical operators”

### Check the Key Points
- `else if` adds more conditions.  
- `&&`, `||`, `!` combine or reverse conditions.  
- Order of `if / else if / else` matters.

---

## Lesson 4.3 — Introducing Functions

**Lesson ID:** js1-4-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Create and call simple functions.

### AI Visual Banner Specification
Cody putting a set of instructions into a reusable box labeled “function”.

### Story / Hook
**Shady:** I keep writing the same `console.log` greeting many times. Is there a better way?  
**Cody:** Yes — functions let you package code and reuse it.

### Learn Section
A **function** is a reusable block of code.

```javascript
function sayHello() {
  console.log("Hello, Code Orbit!");
}

sayHello();  // call the function
sayHello();  // call it again
```

- `function` keyword starts the declaration.  
- `sayHello` is the function name.  
- `()` is where parameters will go (empty for now).  
- `{ }` contains the body.  
- You must **call** the function with `()` to run it.

### Example
```javascript
function showMission() {
  console.log("Mission: Learn JavaScript");
  console.log("Status: In progress");
}

showMission();
```

### Interactive Activity — Code Playground
**Task:** Create a function named `greet` that prints “Welcome, cadet!” and call it twice.

### Practice
Write a function `printDate` that prints today’s year (you can hard-code 2026 for now) and call it.

### Feedback
```javascript
function printDate() {
  console.log(2026);
}
printDate();
```

### Tiny Challenge
Create a function that prints three lines of a short poem or motto and call it.

### Quick Check
**Question:** What do you need to do to actually run the code inside a function?  
A) Only declare it  
B) Call it with its name followed by `()`  
C) Restart the browser  

**Correct Answer:** B

### Lesson Mission
Create two different functions (e.g., one for greeting, one for showing score) and call both.

### Summary Image Concept
Function box with “call me!” arrow.

### Want to Learn More?
**YouTube search query:** “javascript functions for beginners”

### Check the Key Points
- Functions package reusable code.  
- Declare with `function name() { }`.  
- Call with `name()`.  
- Functions help avoid repetition.

---

## Lesson 4.4 — Parameters, Arguments, and Return Values

**Lesson ID:** js1-4-4  
**Duration:** 15 min  
**XP Reward:** 30  
**Primary Objective:** Pass data into functions and get results back with `return`.

### AI Visual Banner Specification
Function machine with input slots (parameters) and an output tray (return value).

### Story / Hook
**Shady:** Can a function work with different names or numbers each time I call it?  
**Cody:** Yes! That’s what parameters and return values are for.

### Learn Section
**Parameters** are placeholders in the function definition.  
**Arguments** are the actual values you pass when calling.

```javascript
function greet(name) {
  console.log(`Hello, ${name}!`);
}

greet("Shady");  // argument "Shady"
greet("Cody");
```

**Return values** send a result back:

```javascript
function add(a, b) {
  return a + b;
}

let sum = add(3, 4);
console.log(sum);  // 7
```

- `return` immediately exits the function and sends the value.  
- You can store the returned value in a variable or use it directly.

### Example
```javascript
function calculateArea(width, height) {
  return width * height;
}

const area = calculateArea(10, 5);
console.log(`Area is ${area}`);
```

### Interactive Activity — Code Playground
**Task:** Write a function `double` that takes a number and returns the number multiplied by 2. Call it with 7 and print the result.

### Practice
Create a function `isEven` that returns `true` if a number is even, otherwise `false`.

### Feedback
```javascript
function isEven(n) {
  return n % 2 === 0;
}
console.log(isEven(4));  // true
```

### Tiny Challenge
Write a function that takes a player’s name and score, then returns a message string using a template literal.

### Quick Check
**Question:** What keyword sends a value back from a function?  
A) `send`  
B) `return`  
C) `output`  

**Correct Answer:** B

### Lesson Mission
Create a small calculator function (add or multiply) that takes two numbers and returns the result. Use the returned value in a `console.log`.

### Summary Image Concept
Function as a machine: inputs → process → output.

### Want to Learn More?
**YouTube search query:** “javascript function parameters return”

### Check the Key Points
- Parameters receive values.  
- Arguments are the values you pass.  
- `return` gives a result back.  
- Functions can both perform actions and produce values.

---

## Lesson 4.5 — Simple Function Design and Scope Basics

**Lesson ID:** js1-4-5  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Design small, clear functions and understand basic local scope.

### AI Visual Banner Specification
Cody organizing small function boxes, with a note “variables inside stay inside”.

### Story / Hook
**Shady:** Sometimes I create a variable inside a function and then I can’t use it outside. Why?  
**Cody:** That’s scope! Let’s learn the beginner version.

### Learn Section
**Good function design tips:**  
- One clear job per function  
- Descriptive names  
- Keep them short  

**Local scope (beginner level):**  
Variables declared inside a function with `let` or `const` only exist inside that function.

```javascript
function showScore() {
  let score = 100;          // local variable
  console.log(score);
}

showScore();
// console.log(score);     // Error — score is not visible here
```

Variables declared outside functions are in the outer (global) scope and can be read inside functions, but beginners should prefer passing values as parameters.

### Example
```javascript
function createGreeting(name) {
  const message = `Welcome, ${name}!`;
  return message;
}

const text = createGreeting("Shady");
console.log(text);
```

### Interactive Activity
Write a function that calculates remaining health and returns it. Call it and store the result.

### Practice
Explain why this code fails and fix it conceptually:
```javascript
function test() {
  let x = 5;
}
console.log(x);
```

### Feedback
`x` is local to the function, so it cannot be accessed outside. Return the value or declare `x` outside if needed.

### Tiny Challenge
Design two small functions: one that returns a welcome message, another that returns a goodbye message. Call both.

### Quick Check
**Question:** A variable declared with `let` inside a function is visible:  
A) Everywhere in the program  
B) Only inside that function  
C) Only after the function is called  

**Correct Answer:** B

### Lesson Mission
Refactor a few repeated `console.log` statements from earlier lessons into well-named functions.

### Summary Image Concept
Scope bubble around a function showing variables staying inside.

### Want to Learn More?
**YouTube search query:** “javascript function scope beginners”

### Check the Key Points
- Keep functions focused and well-named.  
- Variables declared inside a function are local.  
- Prefer parameters over relying on outer variables when possible.

---

# CHAPTER 5 — Arrays, Objects, and Repetition

**Chapter Goal:** Store collections of data and repeat actions with loops.

---

## Lesson 5.1 — Introducing Arrays

**Lesson ID:** js1-5-1  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Create arrays and access elements by index.

### AI Visual Banner Specification
A row of numbered boxes (0, 1, 2…) holding values, with Cody pointing at index 0.

### Story / Hook
**Shady:** I want to store a list of scores or names. Do I need a new variable for each one?  
**Cody:** No — we use an **array**, an ordered list of values.

### Learn Section
```javascript
let scores = [90, 85, 78, 92];
let names = ["Shady", "Cody", "Alex"];

console.log(scores[0]);   // 90  (first element)
console.log(names[1]);    // "Cody"
console.log(scores.length); // 4
```

- Arrays are written with square brackets `[ ]`.  
- Indexes start at **0**.  
- `.length` tells you how many items are in the array.

You can change an element:
```javascript
scores[2] = 80;
```

### Example
```javascript
const fruits = ["apple", "banana", "cherry"];
console.log(fruits[0]);
console.log(fruits.length);
fruits[1] = "blueberry";
console.log(fruits);
```

### Interactive Activity — Code Playground
**Task:** Create an array of three favorite games or courses and print the first and last items.

### Practice
What is the index of the last element in an array of length 5?

### Feedback
Index 4 (because indexing starts at 0).

### Tiny Challenge
Create an array of numbers, change the second element, and print the whole array.

### Quick Check
**Question:** What is the index of the first element in an array?  
A) 1  
B) 0  
C) -1  

**Correct Answer:** B

### Lesson Mission
Store a list of three mission names in an array and print each one using its index.

### Summary Image Concept
Numbered boxes representing array indexes.

### Want to Learn More?
**YouTube search query:** “javascript arrays for beginners”

### Check the Key Points
- Arrays store ordered lists.  
- Indexes start at 0.  
- Use `.length` to get the size.  
- You can read and change elements by index.

---

## Lesson 5.2 — Array Methods: push, pop, shift, unshift

**Lesson ID:** js1-5-2  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Add and remove items from the beginning or end of an array.

### AI Visual Banner Specification
Array shown as a line of items with arrows for push/pop (end) and unshift/shift (start).

### Story / Hook
**Shady:** How do I add a new score to the end of my list without knowing the next index?  
**Cody:** Arrays give us helpful methods for that.

### Learn Section
```javascript
let lives = [3, 2, 1];

lives.push(5);      // add to the end
console.log(lives); // [3, 2, 1, 5]

lives.pop();        // remove from the end
console.log(lives); // [3, 2, 1]

lives.unshift(4);   // add to the beginning
console.log(lives); // [4, 3, 2, 1]

lives.shift();      // remove from the beginning
console.log(lives); // [3, 2, 1]
```

- `push` / `pop` work at the **end**.  
- `unshift` / `shift` work at the **beginning**.

### Example
```javascript
const queue = ["Shady"];
queue.push("Cody");
queue.push("Alex");
console.log(queue);
queue.shift();
console.log(queue);
```

### Interactive Activity
Start with an empty array.  
Use `push` to add three items, then `pop` one item, then print the array.

### Practice
Explain the difference between `push` and `unshift`.

### Feedback
`push` adds at the end; `unshift` adds at the beginning.

### Tiny Challenge
Simulate a simple stack of books: add three books with `push`, remove the top one with `pop`, and print the remaining list.

### Quick Check
**Question:** Which method removes the last element of an array?  
A) `shift`  
B) `pop`  
C) `push`  

**Correct Answer:** B

### Lesson Mission
Create a to-do list array and practice adding and removing items with the four methods.

### Summary Image Concept
Visual of array with labeled push/pop/shift/unshift arrows.

### Want to Learn More?
**YouTube search query:** “javascript array push pop shift unshift”

### Check the Key Points
- `push` / `pop` → end of array.  
- `unshift` / `shift` → beginning of array.  
- These methods change the original array.

---

## Lesson 5.3 — Introducing Objects

**Lesson ID:** js1-5-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Create objects and access properties with dot notation.

### AI Visual Banner Specification
A labeled box (object) containing key-value pairs, with Cody opening it.

### Story / Hook
**Shady:** An array is great for a list, but what if I want to store a player’s name, score, and level together?  
**Cody:** That’s a perfect job for an **object**.

### Learn Section
An **object** stores related data as key-value pairs.

```javascript
const player = {
  name: "Shady",
  score: 120,
  level: 3,
  isActive: true
};

console.log(player.name);    // "Shady"
console.log(player.score);   // 120
player.score = 150;          // update a property
console.log(player.score);   // 150
```

- Keys are also called properties.  
- Use **dot notation** `object.property` to read or change values.  
- Objects are written with curly braces `{ }`.

### Example
```javascript
const course = {
  title: "JavaScript Level 1",
  lessons: 30,
  level: 1
};

console.log(`${course.title} has ${course.lessons} lessons.`);
```

### Interactive Activity — Code Playground
**Task:** Create an object representing yourself with at least three properties (name, age or level, favorite language) and print one of them.

### Practice
Access the `level` property of the `player` object above.

### Feedback
`player.level`

### Tiny Challenge
Create a “mission” object with title, difficulty, and completed (boolean). Print a status message using a template literal.

### Quick Check
**Question:** How do you usually read a property named `score` from an object `player`?  
A) `player[score]`  
B) `player.score`  
C) `player->score`  

**Correct Answer:** B

### Lesson Mission
Model a simple game character or a book using an object and print its information.

### Summary Image Concept
Object as a labeled container with named drawers.

### Want to Learn More?
**YouTube search query:** “javascript objects for beginners”

### Check the Key Points
- Objects group related data.  
- Properties are key-value pairs.  
- Use dot notation to access properties.  
- You can update property values.

---

## Lesson 5.4 — for Loops

**Lesson ID:** js1-5-4  
**Duration:** 15 min  
**XP Reward:** 30  
**Primary Objective:** Repeat actions a specific number of times with a `for` loop.

### AI Visual Banner Specification
Cody counting from 0 to 4 while repeating an action, with a loop arrow.

### Story / Hook
**Shady:** I need to print every item in an array. Writing `console.log` five times is boring.  
**Cody:** Loops to the rescue! Let’s start with the classic `for` loop.

### Learn Section
```javascript
for (let i = 0; i < 5; i++) {
  console.log(i);
}
```

**Parts of a for loop:**  
1. Initialization: `let i = 0`  
2. Condition: `i < 5` (keep going while true)  
3. Update: `i++` (add 1 each time)  

Looping over an array:
```javascript
const names = ["Shady", "Cody", "Alex"];

for (let i = 0; i < names.length; i++) {
  console.log(names[i]);
}
```

### Example
```javascript
const scores = [90, 85, 78];

for (let i = 0; i < scores.length; i++) {
  console.log(`Score ${i + 1}: ${scores[i]}`);
}
```

### Interactive Activity — Code Playground
**Task:** Use a `for` loop to print the numbers from 1 to 5.

### Practice
Print every element of an array of colors using a `for` loop.

### Feedback
Standard index-based loop over `.length`.

### Tiny Challenge
Calculate the sum of all numbers in an array using a `for` loop and print the total.

### Quick Check
**Question:** In `for (let i = 0; i < 3; i++)`, how many times does the loop body run?  
A) 2  
B) 3  
C) 4  

**Correct Answer:** B

### Lesson Mission
Create an array of mission names and print each one with its number using a `for` loop.

### Summary Image Concept
Loop cycle diagram with initialization → condition → body → update.

### Want to Learn More?
**YouTube search query:** “javascript for loop beginners”

### Check the Key Points
- `for` loops repeat a specific number of times.  
- Classic pattern: start at 0, go while `< length`, increase by 1.  
- Perfect for going through arrays by index.

---

## Lesson 5.5 — while Loops and for...of

**Lesson ID:** js1-5-5  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Use `while` when the number of repetitions is not known in advance, and `for...of` for clean array iteration.

### AI Visual Banner Specification
Two loop styles side by side: `while` (condition-focused) and `for...of` (item-focused).

### Story / Hook
**Shady:** Sometimes I don’t know how many times I need to repeat something in advance.  
**Cody:** Then a `while` loop is useful. And for arrays, `for...of` is often cleaner.

### Learn Section
**while loop:**
```javascript
let count = 0;
while (count < 3) {
  console.log(count);
  count++;
}
```

Be careful: if the condition never becomes false, you create an **infinite loop**.

**for...of loop** (great for arrays):
```javascript
const fruits = ["apple", "banana", "cherry"];

for (const fruit of fruits) {
  console.log(fruit);
}
```

`for...of` gives you each item directly — no need to manage an index.

### Example
```javascript
let lives = 3;
while (lives > 0) {
  console.log(`Lives left: ${lives}`);
  lives--;
}
console.log("Game over");
```

### Interactive Activity
Use `for...of` to print every name in an array of students.

### Practice
Write a `while` loop that doubles a number until it becomes greater than 100, starting from 1.

### Feedback
```javascript
let n = 1;
while (n <= 100) {
  console.log(n);
  n *= 2;
}
```

### Tiny Challenge
Combine an array and a `for...of` loop to print a numbered list of tasks.

### Quick Check
**Question:** Which loop is especially convenient when you only need each item of an array and not its index?  
A) `for` with index  
B) `for...of`  
C) `while` only  

**Correct Answer:** B

### Lesson Mission
Choose the most suitable loop (`for`, `while`, or `for...of`) for three different small problems and implement them.

### Summary Image Concept
Comparison card: when to use each loop type.

### Want to Learn More?
**YouTube search query:** “javascript while loop for of beginners”

### Check the Key Points
- `while` continues as long as the condition is true.  
- Avoid infinite loops by updating the condition variable.  
- `for...of` is clean for iterating over array items.

---

## Lesson 5.6 — Simple Iteration Problems

**Lesson ID:** js1-5-6  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Solve practical problems using arrays, objects, and loops together.

### AI Visual Banner Specification
Cody and Shady solving a checklist of small coding challenges on a holographic screen.

### Story / Hook
**Shady:** I know the pieces — arrays, objects, loops. How do I combine them for real tasks?  
**Cody:** Let’s practice a few classic beginner problems.

### Learn Section
Common patterns:  
1. Sum all numbers in an array.  
2. Find the highest value.  
3. Count how many items meet a condition.  
4. Build a new array or message from existing data.

Example — sum:
```javascript
const numbers = [10, 20, 30];
let total = 0;

for (const n of numbers) {
  total += n;
}
console.log(total);  // 60
```

Example — working with objects in an array:
```javascript
const players = [
  { name: "Shady", score: 100 },
  { name: "Cody", score: 150 }
];

for (const player of players) {
  console.log(`${player.name}: ${player.score}`);
}
```

### Example
Find the maximum score:
```javascript
const scores = [70, 95, 80, 60];
let max = scores[0];

for (let i = 1; i < scores.length; i++) {
  if (scores[i] > max) {
    max = scores[i];
  }
}
console.log(max);
```

### Interactive Activity — Code Playground
**Task:** Given an array of numbers, calculate and print the average.

### Practice
Count how many scores are greater than or equal to 60 in an array.

### Feedback
Use a counter variable and an `if` inside the loop.

### Tiny Challenge
Create an array of objects (missions) and print only the titles of the completed ones.

### Quick Check
**Question:** What is a good way to sum all numbers in an array?  
A) Use a loop and keep adding to a total variable  
B) Use only `console.log`  
C) Use `const` for the total and try to reassign it  

**Correct Answer:** A

### Lesson Mission
Invent and solve one small problem that uses an array (or array of objects) plus a loop and a condition.

### Summary Image Concept
Checklist of solved mini-problems with green ticks.

### Want to Learn More?
**YouTube search query:** “javascript loop array problems beginners”

### Check the Key Points
- Combine loops with conditions and accumulators.  
- Arrays of objects are very common.  
- Practice is the best way to become comfortable.

---

# CHAPTER 6 — Connecting JavaScript to HTML

**Chapter Goal:** Understand how to include JavaScript in a webpage (introduction only — no DOM manipulation).

---

## Lesson 6.1 — The script Tag and How the Browser Loads JavaScript

**Lesson ID:** js1-6-1  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Explain how to place JavaScript inside an HTML page using the `<script>` tag.

### AI Visual Banner Specification
HTML document with a highlighted `<script>` section and a browser loading the page.

### Story / Hook
**Shady:** So far I only used the console and the playground. How does JavaScript get into a real webpage?  
**Cody:** Through the `<script>` tag. Let’s see the beginner way.

### Learn Section
You can include JavaScript directly in an HTML file:

```html
<!DOCTYPE html>
<html>
<head>
  <title>My Page</title>
</head>
<body>
  <h1>Hello</h1>

  <script>
    console.log("JavaScript is running inside the page!");
  </script>
</body>
</html>
```

- The browser reads the HTML from top to bottom.  
- When it reaches a `<script>` tag, it executes the JavaScript inside it.  
- Placing the script near the end of the `<body>` is a common beginner-friendly practice so the HTML content loads first.

**Important for Level 1:**  
We are only learning *how to include* JavaScript.  
We are **not** yet learning how to change the page content with JavaScript (that belongs to Level 2).

### Example
A minimal page that runs a greeting in the console when opened.

### Interactive Activity
(Conceptual / observation)  
Look at a simple HTML file that contains a `<script>` block and identify where the JavaScript starts and ends.

### Practice
Write the basic skeleton of an HTML page that contains one `console.log` statement inside a `<script>` tag.

### Feedback
Standard HTML5 structure with a `<script>` before the closing `</body>` tag.

### Tiny Challenge
Add a second `console.log` that prints the current year inside the same script block.

### Quick Check
**Question:** Which HTML tag is used to include JavaScript in a page?  
A) `<js>`  
B) `<script>`  
C) `<code>`  

**Correct Answer:** B

### Lesson Mission
Create a complete (but simple) HTML file that includes a short JavaScript message in the console.

### Summary Image Concept
HTML page with a glowing `<script>` island.

### Want to Learn More?
**YouTube search query:** “html script tag javascript beginners”

### Check the Key Points
- Use the `<script>` tag to include JavaScript.  
- The browser executes the script when it reaches it.  
- Level 1 focuses on including code, not manipulating the page.

---

## Lesson 6.2 — Inline vs External JavaScript (Beginner View)

**Lesson ID:** js1-6-2  
**Duration:** 12 min  
**XP Reward:** 25  
**Primary Objective:** Distinguish between inline (inside the HTML) and external JavaScript files at a beginner level.

### AI Visual Banner Specification
Two options side by side: script written inside HTML vs a separate `.js` file linked with `src`.

### Story / Hook
**Shady:** Can I keep my JavaScript in a different file so the HTML stays clean?  
**Cody:** Yes! That is called external JavaScript. Both ways are useful.

### Learn Section
**1. Inline / internal JavaScript** (code written directly between `<script>` and `</script>`):

```html
<script>
  console.log("I am inside the HTML file");
</script>
```

**2. External JavaScript** (code in a separate `.js` file):

```html
<script src="script.js"></script>
```

And in `script.js`:
```javascript
console.log("I am in an external file");
```

**Beginner guidelines:**  
- Small experiments → internal script is fine.  
- Larger programs → external file keeps HTML cleaner and code reusable.  
- The `src` attribute tells the browser where to find the external file.  
- Paths can be relative (same folder) or more complex later.

We still do **not** teach DOM methods such as `document.querySelector` in this lesson.

### Example
A page that loads an external greeting file.

### Interactive Activity
(Conceptual) Decide for three different situations whether internal or external JavaScript is more appropriate.

### Practice
Write the HTML line that would load a file named `main.js` from the same folder.

### Feedback
`<script src="main.js"></script>`

### Tiny Challenge
Describe one advantage of keeping JavaScript in an external file.

### Quick Check
**Question:** What attribute of the `<script>` tag points to an external JavaScript file?  
A) `href`  
B) `src`  
C) `link`  

**Correct Answer:** B

### Lesson Mission
Create a tiny project structure description: one HTML file + one external JS file and show how they connect.

### Summary Image Concept
HTML file and JS file connected by a `src` arrow.

### Want to Learn More?
**YouTube search query:** “internal vs external javascript”

### Check the Key Points
- JavaScript can live inside the HTML or in a separate file.  
- External files use `<script src="...">`.  
- External files help keep code organized.  
- No DOM manipulation yet.

---

## Lesson 6.3 — Putting It Together: A Simple Page with JavaScript

**Lesson ID:** js1-6-3  
**Duration:** 12–15 min  
**XP Reward:** 25  
**Primary Objective:** Build a minimal complete example that combines HTML structure with a JavaScript console program.

### AI Visual Banner Specification
Finished simple webpage on a screen with the console open showing messages, Cody and Shady celebrating.

### Story / Hook
**Shady:** Can we make a tiny complete example that uses everything we learned?  
**Cody:** Yes — a simple HTML page that runs a small JavaScript program in the console.

### Learn Section
We will create:  
1. Basic HTML structure  
2. A heading and a short paragraph  
3. A `<script>` block (or external file) that:  
   - Declares a few variables  
   - Uses a condition  
   - Calls a small function  
   - Works with a simple array  

Remember: the visible page stays static; the interesting work happens in the console. This is intentional for Level 1.

### Example Structure
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JS Level 1 Demo</title>
</head>
<body>
  <h1>JavaScript Level 1</h1>
  <p>Open the console to see the program output.</p>

  <script>
    const student = "Shady";
    let score = 85;

    function checkPass(score) {
      if (score >= 60) {
        return "Passed!";
      } else {
        return "Try again";
      }
    }

    const missions = ["Variables", "Functions", "Loops"];
    console.log(`Student: ${student}`);
    console.log(checkPass(score));
    for (const m of missions) {
      console.log(`- ${m}`);
    }
  </script>
</body>
</html>
```

### Interactive Activity
Reproduce a simplified version of the example above in the playground or in a local file and observe the console output.

### Practice
Add one more property or one more mission to the example and re-run it.

### Feedback
Any valid extension that still runs cleanly.

### Tiny Challenge
Add a simple object representing the course and print one of its properties from the script.

### Quick Check
**Question:** In Level 1, when we put JavaScript in an HTML page, where do we mainly see the results of `console.log`?  
A) As visible text on the page  
B) In the browser console  
C) In a popup only  

**Correct Answer:** B

### Lesson Mission
Build your own mini “console report” page that uses variables, a function, a condition, and a loop.

### Summary Image Concept
Complete small project badge: HTML + JS working together at Level 1.

### Want to Learn More?
**YouTube search query:** “first javascript in html page beginners”

### Check the Key Points
- You now know how to include JavaScript in a page.  
- Console programs can live inside HTML.  
- Real interactive page changes come in later levels.  
- You have the foundations ready for Level 2.

---

# FINAL PROJECT — JavaScript Level 1

**Project Title:** Console Mission Control  
**Estimated Time:** 45–90 minutes  
**XP Reward:** 100  

### Project Goal
Create a **console-based interactive program** that brings together everything you learned in Level 1.

### Requirements
Your program must demonstrate:  
- Variables (`let` and `const`) and different data types  
- Operators and expressions  
- Decisions (`if` / `else` / `else if` and logical operators)  
- At least two functions (with parameters and return values)  
- Arrays **or** objects (ideally both)  
- At least one loop (`for`, `while`, or `for...of`)  
- Clear `console.log` output and helpful comments  
- **No DOM manipulation** (no `document.querySelector`, no events, etc.)

### Suggested Theme
“Mission Control” for a space cadet:  
- Store cadet information (object)  
- Keep a list of completed missions (array)  
- Calculate a final score  
- Decide rank based on score  
- Print a full status report  

### Example Skeleton (you should expand it significantly)
```javascript
const cadet = {
  name: "Shady",
  level: 1,
  lives: 3
};

const missions = ["Variables", "Functions", "Loops"];

function calculateScore(base, bonus) {
  return base + bonus;
}

function getRank(score) {
  if (score >= 90) return "Captain";
  if (score >= 70) return "Lieutenant";
  return "Cadet";
}

// ... add more logic, loops, and output
```

### Success Criteria
- Code runs without errors  
- All required concepts are used meaningfully  
- Output is readable and organized  
- Code contains useful comments  

### Submission Tips
- Test frequently in the playground or console  
- Start small and add features one by one  
- Use template literals for clean messages  

### After the Project
Congratulations! You now have solid JavaScript fundamentals.  
You are ready for **JavaScript Level 2**, where you will learn how to make web pages interactive with the DOM.

---

**End of JavaScript Level 1 — English Content Source**  
*SPS Code Orbit — Authoritative Curriculum File*  
