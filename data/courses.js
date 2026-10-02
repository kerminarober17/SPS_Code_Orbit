/**
 * SPS CODE ORBIT — Course catalog metadata (ACTIVE PRODUCTION)
 *
 * Authority for course list metadata (id, slug, title, counts, images).
 * Rich lesson content lives in data/*_curriculum.js (see curriculum_index.js).
 * MySQL course rows are seeded from data/curriculum_export.json via:
 *   php database/seed_curriculum.php
 *
 * Official production set (5):
 *   course-programming-foundations (6/24)
 *   course-python-foundations (10/40)
 *   course-python-level-2 (10/40)
 *   course-javascript-level-1 (6/28)
 *   course-frontend-level-1 (5/23)
 *
 * Catalog UI should prefer /api/courses/list.php (published DB rows).
 * Do not add a course here without also updating curriculum_export.json,
 * a *_curriculum.js module, curriculum_index.js, and production_exams.json.
 */

const COURSES_DATA = [
  // FOUNDATION TRACK
  {
    id: "course-programming-foundations",
    slug: "programming-foundations",
    title: "Programming Foundations — Start Here",
    subtitle: "Understand Programming Before You Code",
    description: "The complete foundational course: discover what programming truly is, how computers and the internet work, and master algorithmic thinking before writing code in any language.",
    track: "Foundation Track",
    track_id: "track-foundation",
    level: "Foundation",
    level_number: 0,
    difficulty: "Absolute Beginner",
    prerequisite: "None",
    academic_group_name: "Prep",
    academicGroupLabel: "Foundation",
    image: "/assets/courses/foundation.jpeg",
    image_url: "/assets/courses/foundation.jpeg",
    accent_color: "#70D6FF",
    chaptersCount: 6,
    lessonsCount: 24,
    total_lessons: 24,
    is_published: 1
  },

  // PYTHON TRACK
  {
    id: "course-python-foundations",
    slug: "python-foundations",
    title: "Python Level 1: Foundations",
    subtitle: "Build Robust Fundamentals",
    description: "Build robust programming fundamentals from scratch using Python. Master variables, data types, operators, branching logic, loops, collections, and structured problem-solving.",
    track: "Python Track",
    track_id: "track-python",
    level: "Level 1: Foundations",
    level_number: 1,
    difficulty: "Beginner",
    prerequisite: "Programming Foundations",
    academic_group_name: "Prep",
    academicGroupLabel: "Python Track",
    image: "/assets/courses/Py_L1.jpeg",
    image_url: "/assets/courses/Py_L1.jpeg",
    accent_color: "#0EA5E9",
    chaptersCount: 10,
    lessonsCount: 40,
    total_lessons: 40,
    is_published: 1
  },
  {
    id: "course-python-level-2",
    slug: "python-level-2",
    title: "Python Level 2: Code Orbit",
    subtitle: "Organize, Reuse, Protect, Scale",
    description: "Continue from Python Level 1. Master text power-ups, smarter collections, list comprehensions, dictionaries, scope & functions, files, modules, errors, and first steps into OOP — then build a real application.",
    track: "Python Track",
    track_id: "track-python",
    level: "Level 2: Foundations+",
    level_number: 2,
    difficulty: "Intermediate",
    prerequisite: "Python Level 1: Foundations",
    academic_group_name: "Prep",
    academicGroupLabel: "Python Track",
    image: "/assets/courses/Py_L2.jpeg",
    image_url: "/assets/courses/Py_L2.jpeg",
    accent_color: "#8B5CF6",
    chaptersCount: 10,
    lessonsCount: 40,
    total_lessons: 40,
    is_published: 1
  },
  // JAVASCRIPT TRACK
  {
    id: "course-javascript-level-1",
    slug: "javascript-level-1",
    title: "JavaScript — Level 1",
    subtitle: "Speak the Language of the Web",
    description: "Learn JavaScript as a programming language: output, variables, operators, decisions, loops, and functions — before HTML or the DOM.",
    track: "JavaScript Track",
    track_id: "track-javascript",
    level: "Level 1",
    level_number: 1,
    difficulty: "Beginner",
    prerequisite: "Programming Foundations",
    academic_group_name: "Prep",
    academicGroupLabel: "JavaScript Track",
    image: "/assets/courses/js_L1.jpeg",
    image_url: "/assets/courses/js_L1.jpeg",
    accent_color: "#F7DF1E",
    chaptersCount: 6,
    lessonsCount: 28,
    total_lessons: 28,
    is_published: 1
  },

  // FRONTEND TRACK
  {
    id: "course-frontend-level-1",
    slug: "frontend-level-1",
    title: "Frontend — Level 1",
    subtitle: "Build Your First Web Pages",
    description: "Learn how to create the structure and appearance of web pages using HTML and CSS. Start from zero — build clean multi-section pages with headings, text, images, links, lists, tables, forms, colors, fonts, and the CSS box model.",
    track: "Frontend Track",
    track_id: "track-frontend",
    level: "Level 1",
    level_number: 1,
    difficulty: "Beginner",
    prerequisite: "Programming Foundations",
    academic_group_name: "Prep",
    academicGroupLabel: "Frontend Track",
    image: "/assets/courses/frontend_L1.jpeg",
    image_url: "/assets/courses/frontend_L1.jpeg",
    accent_color: "#E34F26",
    chaptersCount: 5,
    lessonsCount: 23,
    total_lessons: 23,
    is_published: 1
  }

];

if (typeof window !== 'undefined') {
  window.COURSES_DATA = COURSES_DATA;
}

if (typeof module !== 'undefined' && module.exports) {
  module.exports = { COURSES_DATA };
}
