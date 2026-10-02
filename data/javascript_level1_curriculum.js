/**
 * SPS CODE ORBIT — JavaScript Level 1 (ACTIVE)
 * Pure JavaScript language course — NO HTML/DOM playgrounds.
 * Each lesson: Learn → Example (JS) → Coding Challenge (JS console) → Key points
 */
var JAVASCRIPT_LEVEL1_COURSE = {
  "id": "course-javascript-level-1",
  "slug": "javascript-level-1",
  "title": "JavaScript — Level 1",
  "subtitle": "Learn JavaScript as a programming language",
  "description": "Language fundamentals only: output, variables, operators, decisions, loops, functions. No HTML or DOM.",
  "language": "JavaScript",
  "track": "JavaScript Track",
  "level": "Level 1",
  "is_published": 1,
  "chapters": [
    {
      "id": "chap-js1-01",
      "slug": "chap-js1-01",
      "chapter_number": 1,
      "title": "Chapter 1: Getting Started with JavaScript",
      "description": "console.log, numbers, strings, comments, output order",
      "icon_symbol": "⚡",
      "xp_reward": 100,
      "lessons": [
        {
          "id": "js1-1-1",
          "slug": "js1-1-1",
          "title": "1.1: What Is JavaScript?",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Understand JavaScript as a programming language and print a message.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 1.1: What Is JavaScript??",
                "cody": "Understand JavaScript as a programming language and print a message."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><strong>JavaScript</strong> is a programming language. Programs are lists of instructions run in order.</p><p>In Level 1 you write <em>JavaScript only</em> — not HTML pages. Use <code>console.log</code> to show output in the Console panel.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(\"Hello, JavaScript!\");",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "What Is JavaScript? — Challenge",
                "language": "JavaScript",
                "instruction": "Write JavaScript that prints this exact message to the console:\nHello, JavaScript!\n\nUse console.log().",
                "initialCode": "console.log(\"Hello, JavaScript!\");",
                "expectedOutput": "Hello, JavaScript!",
                "solutionCode": "console.log(\"Hello, JavaScript!\");",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "JavaScript is a programming language",
                  "console.log shows output",
                  "No HTML is required in Level 1"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-1-2",
          "slug": "js1-1-2",
          "title": "1.2: Numbers and Arithmetic",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Evaluate and print arithmetic expressions.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 1.2: Numbers and Arithmetic?",
                "cody": "Evaluate and print arithmetic expressions."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Use <code>+</code> <code>-</code> <code>*</code> <code>/</code> with numbers. <code>console.log(2 + 3)</code> prints <code>5</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(2 + 3);\nconsole.log(10 - 4);\nconsole.log(3 * 5);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Numbers and Arithmetic — Challenge",
                "language": "JavaScript",
                "instruction": "Print the result of 100 divided by 4. The console should show 25.",
                "initialCode": "console.log(\"Hello, JavaScript!\");\n\n// Print 100 / 4 below:\n",
                "expectedOutput": "25",
                "solutionCode": "console.log(100 / 4);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Numbers can be calculated",
                  "Expressions are evaluated before printing"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-1-3",
          "slug": "js1-1-3",
          "title": "1.3: Strings vs Numbers",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Distinguish strings from numbers when printing.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 1.3: Strings vs Numbers?",
                "cody": "Distinguish strings from numbers when printing."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Strings are text in quotes: <code>\"15\"</code>. Numbers have no quotes: <code>15</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(\"My age is\");\nconsole.log(15);\nconsole.log(\"15\");",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Strings vs Numbers — Challenge",
                "language": "JavaScript",
                "instruction": "Print the number 7 on the first line, then the string digits 7 on the second line (use quotes for the string).\nBoth lines should show 7 — you are practicing number vs string values.",
                "initialCode": "console.log(\"Hello, JavaScript!\");\n\n// number then string:\n",
                "expectedOutput": "7\n7",
                "solutionCode": "console.log(7);\nconsole.log(\"7\");",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Strings use quotes",
                  "Numbers do not use quotes"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-1-4",
          "slug": "js1-1-4",
          "title": "1.4: Comments",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Write comments that the computer ignores.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 1.4: Comments?",
                "cody": "Write comments that the computer ignores."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Lines starting with <code>//</code> are comments. They do not appear in output.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "// This is a comment\nconsole.log(\"Comments help humans read code\");",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Comments — Challenge",
                "language": "JavaScript",
                "instruction": "Add a comment on the first line, then print exactly:\nComments help humans read code",
                "initialCode": "// write your comment here\n",
                "expectedOutput": "Comments help humans read code",
                "solutionCode": "// This comment explains the next line\nconsole.log(\"Comments help humans read code\");",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "// starts a comment",
                  "Comments are for humans"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-1-5",
          "slug": "js1-1-5",
          "title": "1.5: Reading Output Order",
          "lesson_number": 5,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Predict output order of multiple console.log calls.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 1.5: Reading Output Order?",
                "cody": "Predict output order of multiple console.log calls."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Statements run top to bottom. Output lines follow the same order.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(\"Step 1\");\nconsole.log(\"Step 2\");\nconsole.log(\"Step 3\");",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Reading Output Order — Challenge",
                "language": "JavaScript",
                "instruction": "Print Step 1, then Step 2, then Step 3 — each on its own line, in that order.",
                "initialCode": "// Print three steps in order\n",
                "expectedOutput": "Step 1\nStep 2\nStep 3",
                "solutionCode": "console.log(\"Step 1\");\nconsole.log(\"Step 2\");\nconsole.log(\"Step 3\");",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Code runs top to bottom",
                  "Each console.log is a line of output"
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-js1-02",
      "slug": "chap-js1-02",
      "chapter_number": 2,
      "title": "Chapter 2: Variables and Data",
      "description": "let, const, types, typeof, joining strings",
      "icon_symbol": "⚡",
      "xp_reward": 100,
      "lessons": [
        {
          "id": "js1-2-1",
          "slug": "js1-2-1",
          "title": "2.1: Creating Variables with let",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Store a value with let and print it.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 2.1: Creating Variables with let?",
                "cody": "Store a value with let and print it."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>let studentName = \"Alex\";</code> creates a variable. Print it with <code>console.log(studentName)</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let studentName = \"Alex\";\nconsole.log(studentName);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Creating Variables with let — Challenge",
                "language": "JavaScript",
                "instruction": "Create a variable studentName with the string \"Alex\" and print it with console.log.",
                "initialCode": "let studentName = \"Alex\";\n// print studentName\n",
                "expectedOutput": "Alex",
                "solutionCode": "let studentName = \"Alex\";\nconsole.log(studentName);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "let creates a variable",
                  "Use the name to read the value"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-2-2",
          "slug": "js1-2-2",
          "title": "2.2: const for Fixed Values",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Use const for values that should not be reassigned.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 2.2: const for Fixed Values?",
                "cody": "Use const for values that should not be reassigned."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>const school = \"SPS\";</code> creates a fixed binding. Prefer const when the value will not change.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "const school = \"SPS\";\nconsole.log(school);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "const for Fixed Values — Challenge",
                "language": "JavaScript",
                "instruction": "Create const school = \"SPS\" and print school.",
                "initialCode": "const school = \"SPS\";\n",
                "expectedOutput": "SPS",
                "solutionCode": "const school = \"SPS\";\nconsole.log(school);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "const should not be reassigned",
                  "Use let when the value will change"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-2-3",
          "slug": "js1-2-3",
          "title": "2.3: Changing let Variables",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Reassign a let variable.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 2.3: Changing let Variables?",
                "cody": "Reassign a let variable."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>After <code>let age = 15;</code> write <code>age = 16;</code> (no second let).</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let age = 15;\nage = 16;\nconsole.log(age);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Changing let Variables — Challenge",
                "language": "JavaScript",
                "instruction": "Create let age = 15, change it to 16, then print age.",
                "initialCode": "let age = 15;\n// change age to 16, then print\n",
                "expectedOutput": "16",
                "solutionCode": "let age = 15;\nage = 16;\nconsole.log(age);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Reassign without repeating let",
                  "New value replaces the old one"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-2-4",
          "slug": "js1-2-4",
          "title": "2.4: Booleans and typeof",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Use true/false and typeof.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 2.4: Booleans and typeof?",
                "cody": "Use true/false and typeof."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>typeof value</code> returns <code>\"string\"</code>, <code>\"number\"</code>, or <code>\"boolean\"</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let isReady = true;\nconsole.log(typeof \"Alex\");\nconsole.log(typeof 15);\nconsole.log(typeof isReady);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Booleans and typeof — Challenge",
                "language": "JavaScript",
                "instruction": "Print typeof results for a string, a number, and a boolean — each on its own line.",
                "initialCode": "// Print three typeof results\n",
                "expectedOutput": "string\nnumber\nboolean",
                "solutionCode": "console.log(typeof \"hello\");\nconsole.log(typeof 42);\nconsole.log(typeof true);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Booleans are true or false",
                  "typeof reports the type name"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-2-5",
          "slug": "js1-2-5",
          "title": "2.5: Combining Strings",
          "lesson_number": 5,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Join strings and variables with +.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 2.5: Combining Strings?",
                "cody": "Join strings and variables with +."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>\"Hi, \" + studentName</code> builds one message.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let studentName = \"Alex\";\nlet age = 16;\nconsole.log(studentName + \" is \" + age + \" years old\");",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Combining Strings — Challenge",
                "language": "JavaScript",
                "instruction": "Using studentName and age, print a sentence that includes both values (for example: Alex is 16).",
                "initialCode": "let studentName = \"Alex\";\nlet age = 16;\n// print a sentence using both\n",
                "expectedOutput": "Alex is 16",
                "solutionCode": "let studentName = \"Alex\";\nlet age = 16;\nconsole.log(studentName + \" is \" + age);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "+ joins strings",
                  "Variables can be part of a message"
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-js1-03",
      "slug": "chap-js1-03",
      "chapter_number": 3,
      "title": "Chapter 3: Operators and Expressions",
      "description": "arithmetic, assignment, comparison, logic",
      "icon_symbol": "⚡",
      "xp_reward": 100,
      "lessons": [
        {
          "id": "js1-3-1",
          "slug": "js1-3-1",
          "title": "3.1: Arithmetic Operators",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Use +, -, *, /, and % on numbers.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 3.1: Arithmetic Operators?",
                "cody": "Use +, -, *, /, and % on numbers."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>%</code> is remainder: <code>10 % 3</code> is <code>1</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(10 + 3);\nconsole.log(10 % 3);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Arithmetic Operators — Challenge",
                "language": "JavaScript",
                "instruction": "Print the remainder of 17 divided by 5 (use %).",
                "initialCode": "// Print 17 % 5\n",
                "expectedOutput": "2",
                "solutionCode": "console.log(17 % 5);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "% is remainder",
                  "Arithmetic operators work on numbers"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-3-2",
          "slug": "js1-3-2",
          "title": "3.2: Assignment Operators",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Update variables with +=.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 3.2: Assignment Operators?",
                "cody": "Update variables with +=."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>score += 5</code> means <code>score = score + 5</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let score = 10;\nscore += 5;\nconsole.log(score);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Assignment Operators — Challenge",
                "language": "JavaScript",
                "instruction": "Start with score = 10, add 5 using +=, then print score.",
                "initialCode": "let score = 10;\n// use += then print\n",
                "expectedOutput": "15",
                "solutionCode": "let score = 10;\nscore += 5;\nconsole.log(score);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "+= adds and stores",
                  "Start from a known value"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-3-3",
          "slug": "js1-3-3",
          "title": "3.3: Comparisons and Strict Equality",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Compare values with === and >.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 3.3: Comparisons and Strict Equality?",
                "cody": "Compare values with === and >."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Prefer <code>===</code> for equality. Comparisons produce true or false.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(5 === 5);\nconsole.log(5 === \"5\");\nconsole.log(5 > 3);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Comparisons and Strict Equality — Challenge",
                "language": "JavaScript",
                "instruction": "Print whether 10 is greater than 7 (use >). The result should be true.",
                "initialCode": "// Print a comparison result\n",
                "expectedOutput": "true",
                "solutionCode": "console.log(10 > 7);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "=== is strict equality",
                  "Comparisons are booleans"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-3-4",
          "slug": "js1-3-4",
          "title": "3.4: Logical Operators",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Combine conditions with &&, ||, and !.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 3.4: Logical Operators?",
                "cody": "Combine conditions with &&, ||, and !."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>&&</code> AND, <code>||</code> OR, <code>!</code> NOT.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "console.log(true && false);\nconsole.log(true || false);\nconsole.log(!false);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Logical Operators — Challenge",
                "language": "JavaScript",
                "instruction": "Print the result of true && true.",
                "initialCode": "// Print true && true\n",
                "expectedOutput": "true",
                "solutionCode": "console.log(true && true);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "&& needs both true",
                  "|| needs one true",
                  "! flips a boolean"
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-js1-04",
      "slug": "chap-js1-04",
      "chapter_number": 4,
      "title": "Chapter 4: Decisions",
      "description": "if, else, else if, logical conditions",
      "icon_symbol": "⚡",
      "xp_reward": 100,
      "lessons": [
        {
          "id": "js1-4-1",
          "slug": "js1-4-1",
          "title": "4.1: if Statements",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Run a block only when a condition is true.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 4.1: if Statements?",
                "cody": "Run a block only when a condition is true."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>if (age >= 13) { console.log(\"...\"); }</code></p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let age = 15;\nif (age >= 13) {\n  console.log(\"You can learn JavaScript!\");\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "if Statements — Challenge",
                "language": "JavaScript",
                "instruction": "With age = 15, use if (age >= 13) to print: You can learn JavaScript!",
                "initialCode": "let age = 15;\n// write your if below\n",
                "expectedOutput": "You can learn JavaScript!",
                "solutionCode": "let age = 15;\nif (age >= 13) {\n  console.log(\"You can learn JavaScript!\");\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "if checks a condition",
                  "The block runs only when true"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-4-2",
          "slug": "js1-4-2",
          "title": "4.2: else",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Handle the false path with else.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 4.2: else?",
                "cody": "Handle the false path with else."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Either the if block or the else block runs — not both.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let age = 10;\nif (age >= 18) {\n  console.log(\"Adult track\");\n} else {\n  console.log(\"Student track\");\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "else — Challenge",
                "language": "JavaScript",
                "instruction": "With age = 10, use if/else so younger students print: Student track",
                "initialCode": "let age = 10;\n// if / else\n",
                "expectedOutput": "Student track",
                "solutionCode": "let age = 10;\nif (age >= 18) {\n  console.log(\"Adult track\");\n} else {\n  console.log(\"Student track\");\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "else runs when the condition is false",
                  "Exactly one branch runs"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-4-3",
          "slug": "js1-4-3",
          "title": "4.3: else if Chains",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Choose among more than two options.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 4.3: else if Chains?",
                "cody": "Choose among more than two options."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Check conditions in order; the first true branch runs.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let score = 75;\nif (score >= 90) {\n  console.log(\"Excellent\");\n} else if (score >= 60) {\n  console.log(\"Pass\");\n} else {\n  console.log(\"Keep practicing\");\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "else if Chains — Challenge",
                "language": "JavaScript",
                "instruction": "With score = 75, use if / else if / else to print: Pass",
                "initialCode": "let score = 75;\n// if / else if / else\n",
                "expectedOutput": "Pass",
                "solutionCode": "let score = 75;\nif (score >= 90) {\n  console.log(\"Excellent\");\n} else if (score >= 60) {\n  console.log(\"Pass\");\n} else {\n  console.log(\"Try again\");\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "else if adds more branches",
                  "Order matters"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-4-4",
          "slug": "js1-4-4",
          "title": "4.4: Decisions with Logic",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Use && inside an if condition.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 4.4: Decisions with Logic?",
                "cody": "Use && inside an if condition."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>if (age >= 13 && isReady)</code> requires both conditions.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let age = 15;\nlet isReady = true;\nif (age >= 13 && isReady) {\n  console.log(\"Ready to code\");\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Decisions with Logic — Challenge",
                "language": "JavaScript",
                "instruction": "With age = 15 and isReady = true, print Ready to code when both conditions are true.",
                "initialCode": "let age = 15;\nlet isReady = true;\n// if with &&\n",
                "expectedOutput": "Ready to code",
                "solutionCode": "let age = 15;\nlet isReady = true;\nif (age >= 13 && isReady) {\n  console.log(\"Ready to code\");\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Combine comparisons with &&",
                  "Both sides must be true for &&"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-4-5",
          "slug": "js1-4-5",
          "title": "4.5: Decision Practice",
          "lesson_number": 5,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Compare strings in an if statement.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 4.5: Decision Practice?",
                "cody": "Compare strings in an if statement."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>String compares with === are exact (capital letters matter).</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let weather = \"sunny\";\nif (weather === \"sunny\") {\n  console.log(\"Great day to practice coding\");\n} else {\n  console.log(\"Still a great day to practice coding\");\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Decision Practice — Challenge",
                "language": "JavaScript",
                "instruction": "With weather = \"sunny\", print: Great day to practice coding",
                "initialCode": "let weather = \"sunny\";\n// if / else\n",
                "expectedOutput": "Great day to practice coding",
                "solutionCode": "let weather = \"sunny\";\nif (weather === \"sunny\") {\n  console.log(\"Great day to practice coding\");\n} else {\n  console.log(\"Practice indoors\");\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "String matches are exact",
                  "Practice reading if/else"
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-js1-05",
      "slug": "chap-js1-05",
      "chapter_number": 5,
      "title": "Chapter 5: Loops",
      "description": "for, while, accumulation, infinite-loop safety",
      "icon_symbol": "⚡",
      "xp_reward": 100,
      "lessons": [
        {
          "id": "js1-5-1",
          "slug": "js1-5-1",
          "title": "5.1: for Loops",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Repeat with a for loop counter.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 5.1: for Loops?",
                "cody": "Repeat with a for loop counter."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>for (let i = 1; i <= 5; i = i + 1) { console.log(i); }</code></p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "for (let i = 1; i <= 3; i = i + 1) {\n  console.log(i);\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "for Loops — Challenge",
                "language": "JavaScript",
                "instruction": "Use a for loop to print 1, then 2, then 3 (each on its own line).",
                "initialCode": "// for loop from 1 to 3\n",
                "expectedOutput": "1\n2\n3",
                "solutionCode": "for (let i = 1; i <= 3; i++) {\n  console.log(i);\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "for repeats a fixed number of times",
                  "The counter tracks progress"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-5-2",
          "slug": "js1-5-2",
          "title": "5.2: Accumulating Values",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Build a running total in a loop.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 5.2: Accumulating Values?",
                "cody": "Build a running total in a loop."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Start <code>total = 0</code>, add inside the loop, print after.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let total = 0;\nfor (let n = 1; n <= 5; n = n + 1) {\n  total = total + n;\n}\nconsole.log(total);",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Accumulating Values — Challenge",
                "language": "JavaScript",
                "instruction": "Sum numbers from 1 to 5 in a loop and print the total (15).",
                "initialCode": "let total = 0;\n// loop and print total\n",
                "expectedOutput": "15",
                "solutionCode": "let total = 0;\nfor (let i = 1; i <= 5; i++) {\n  total += i;\n}\nconsole.log(total);",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Initialize before the loop",
                  "Update each iteration"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-5-3",
          "slug": "js1-5-3",
          "title": "5.3: while Loops",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Repeat while a condition stays true.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 5.3: while Loops?",
                "cody": "Repeat while a condition stays true."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Change the variable inside the loop so it can eventually stop.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let t = 3;\nwhile (t > 0) {\n  console.log(t);\n  t = t - 1;\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "while Loops — Challenge",
                "language": "JavaScript",
                "instruction": "Use while to print 3, then 2, then 1 (each on its own line).",
                "initialCode": "let t = 3;\n// while loop\n",
                "expectedOutput": "3\n2\n1",
                "solutionCode": "let t = 3;\nwhile (t >= 1) {\n  console.log(t);\n  t--;\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "while checks before each repeat",
                  "Update state inside the loop"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-5-4",
          "slug": "js1-5-4",
          "title": "5.4: Avoiding Infinite Loops",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Ensure the loop condition can become false.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 5.4: Avoiding Infinite Loops?",
                "cody": "Ensure the loop condition can become false."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>If the condition never becomes false, the loop never ends.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let safe = 0;\nwhile (safe < 3) {\n  console.log(safe);\n  safe = safe + 1;\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Avoiding Infinite Loops — Challenge",
                "language": "JavaScript",
                "instruction": "Print 0, 1, and 2 with a while loop that safely stops.",
                "initialCode": "let safe = 0;\n// safe while loop\n",
                "expectedOutput": "0\n1\n2",
                "solutionCode": "let safe = 0;\nwhile (safe < 3) {\n  console.log(safe);\n  safe++;\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Always update the loop variable",
                  "Start with small counts"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-5-5",
          "slug": "js1-5-5",
          "title": "5.5: Loop Patterns Practice",
          "lesson_number": 5,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Build a string across loop iterations.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 5.5: Loop Patterns Practice?",
                "cody": "Build a string across loop iterations."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Each pass can add characters to a string accumulator.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "let stars = \"\";\nfor (let s = 1; s <= 3; s = s + 1) {\n  stars = stars + \"*\";\n  console.log(stars);\n}",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Loop Patterns Practice — Challenge",
                "language": "JavaScript",
                "instruction": "Use a loop to print *, then **, then *** (three lines).",
                "initialCode": "let stars = \"\";\n// loop\n",
                "expectedOutput": "*\n**\n***",
                "solutionCode": "let stars = \"\";\nfor (let i = 1; i <= 3; i++) {\n  stars += \"*\";\n  console.log(stars);\n}",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Loops can build strings",
                  "Patterns transfer to many problems"
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "id": "chap-js1-06",
      "slug": "chap-js1-06",
      "chapter_number": 6,
      "title": "Chapter 6: Functions",
      "description": "declare, call, parameters, return",
      "icon_symbol": "⚡",
      "xp_reward": 100,
      "lessons": [
        {
          "id": "js1-6-1",
          "slug": "js1-6-1",
          "title": "6.1: Declaring and Calling Functions",
          "lesson_number": 1,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Declare a function and call it.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 6.1: Declaring and Calling Functions?",
                "cody": "Declare a function and call it."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Declaring does not run the body until you call <code>sayHello()</code>.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "function sayHello() {\n  console.log(\"Hello from a function!\");\n}\nsayHello();",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Declaring and Calling Functions — Challenge",
                "language": "JavaScript",
                "instruction": "Write function sayHello that prints Hello from a function! and call it.",
                "initialCode": "// declare and call sayHello\n",
                "expectedOutput": "Hello from a function!",
                "solutionCode": "function sayHello() {\n  console.log(\"Hello from a function!\");\n}\nsayHello();",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "function name() { } declares",
                  "name() calls"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-6-2",
          "slug": "js1-6-2",
          "title": "6.2: Parameters and Arguments",
          "lesson_number": 2,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Pass values into a function.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 6.2: Parameters and Arguments?",
                "cody": "Pass values into a function."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Parameters are placeholders; arguments are values you pass when calling.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "function greet(person) {\n  console.log(\"Hello, \" + person + \"!\");\n}\ngreet(\"Maya\");",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Parameters and Arguments — Challenge",
                "language": "JavaScript",
                "instruction": "Write greet(person) that prints Hello, Maya! when called with \"Maya\".",
                "initialCode": "// function greet(person)\n",
                "expectedOutput": "Hello, Maya!",
                "solutionCode": "function greet(person) {\n  console.log(\"Hello, \" + person + \"!\");\n}\ngreet(\"Maya\");",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Parameters receive input",
                  "Arguments are passed at the call"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-6-3",
          "slug": "js1-6-3",
          "title": "6.3: return Values",
          "lesson_number": 3,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Return a result to the caller.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 6.3: return Values?",
                "cody": "Return a result to the caller."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p><code>return</code> sends a value back. Store it or print it.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "function add(x, y) {\n  return x + y;\n}\nconsole.log(add(7, 8));",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "return Values — Challenge",
                "language": "JavaScript",
                "instruction": "Write add(x, y) that returns the sum. Print add(7, 8).",
                "initialCode": "// function add(x, y)\n",
                "expectedOutput": "15",
                "solutionCode": "function add(x, y) {\n  return x + y;\n}\nconsole.log(add(7, 8));",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "return gives a value to the caller",
                  "Returned values can be stored"
                ]
              }
            }
          ]
        },
        {
          "id": "js1-6-4",
          "slug": "js1-6-4",
          "title": "6.4: Putting Functions Together",
          "lesson_number": 4,
          "duration": 12,
          "xp_reward": 25,
          "youtube_query": "",
          "summary_image": "",
          "learning_objective": "Combine parameters and return in a helper.",
          "blocks": [
            {
              "block_type": "dialogue",
              "content": {
                "shady": "What should I practice in 6.4: Putting Functions Together?",
                "cody": "Combine parameters and return in a helper."
              }
            },
            {
              "block_type": "text",
              "content": {
                "title": "Learn",
                "body": "<p>Name functions after what they do. Level 1 stays language-only — no HTML/DOM.</p>"
              }
            },
            {
              "block_type": "code_example",
              "content": {
                "title": "main.js — example",
                "language": "JavaScript",
                "code": "function describeStudent(name, years) {\n  return name + \" is \" + years + \" years old\";\n}\nconsole.log(describeStudent(\"Maya\", 15));",
                "explanation": "Read this example, then solve the challenge below in pure JavaScript."
              }
            },
            {
              "block_type": "exercise",
              "content": {
                "title": "Putting Functions Together — Challenge",
                "language": "JavaScript",
                "instruction": "Write describeStudent(name, years) that returns a sentence. Print describeStudent(\"Maya\", 15).",
                "initialCode": "// function describeStudent\n",
                "expectedOutput": "Maya is 15 years old",
                "solutionCode": "function describeStudent(name, years) {\n  return name + \" is \" + years + \" years old\";\n}\nconsole.log(describeStudent(\"Maya\", 15));",
                "hint": "Use only JavaScript. Click Run / Test to see Console Output — not an HTML page.",
                "successMessage": "Great job! Your solution matches the expected result."
              }
            },
            {
              "block_type": "key_points",
              "content": {
                "title": "Key points",
                "points": [
                  "Name functions clearly",
                  "Return useful values"
                ]
              }
            }
          ]
        }
      ]
    }
  ]
};
if (typeof window !== 'undefined') { window.JAVASCRIPT_LEVEL1_COURSE = JAVASCRIPT_LEVEL1_COURSE; }
if (typeof module !== 'undefined' && module.exports) { module.exports = { JAVASCRIPT_LEVEL1_COURSE }; }
