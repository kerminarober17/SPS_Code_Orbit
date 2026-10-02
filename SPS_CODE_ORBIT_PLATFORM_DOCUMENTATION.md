# SPS Code Orbit — Platform Documentation

**Audience:** developers and maintainers  
**Scope:** the **current** production-oriented codebase (Browser → PHP → MySQL)  
**Not marketing copy.** Describes what the repository actually implements.

---

## 1. Purpose

**SPS Code Orbit** is a school-oriented coding learning platform. It teaches programming concepts through structured courses, sequential lessons, and chapter exams.

**Problem it solves:** young students need a guided path (foundations → Python) with progress tracking, bilingual (English/Arabic) content, and role separation so teachers and admins can manage classes without students accessing each other’s data.

**Main goals:**
- Deliver five production courses with lessons and chapter exams
- Track enrollment and progress in MySQL
- Support English and Arabic UI/content (with RTL for Arabic prose)
- Separate **student**, **teacher**, and **admin** permissions server-side

**Users:** students, teachers (admin-created), administrators.

---

## 2. User roles

### Student
**Can:** sign up/login; enroll in published courses; open enrolled courses; complete lessons in sequence; take chapter exams (up to 3 attempts); view own dashboard/progress/profile; switch EN/AR on localized pages.

**Cannot:** self-register as teacher/admin; access other students’ progress; call admin/teacher APIs; bypass lesson/exam locks via client tricks (server enforces).

**Enforcement:** `middleware/student.php` / `require_student()`; session `user_id` and `role`; enrollment and progress rows scoped to session user.

### Teacher
**Can:** login (account created by admin); see **assigned** students only (by academic group, class, or explicit assignment); view progress/activity within that scope.

**Cannot:** access unassigned students; admin APIs; create teachers.

**Enforcement:** `require_teacher()`; queries filter by `teacher_id` on assignment tables.

### Admin
**Can:** metrics (counts from DB); create teachers; activate/deactivate accounts; manage assignments (groups/classes/individuals).

**Cannot:** be created via public signup (signup forces `role = student`).

**Enforcement:** `require_admin()`.

---

## 3. Production courses

| Course | ID / slug | Chapters | Lessons | Exams |
|--------|-----------|----------|---------|-------|
| Programming Foundations | `course-programming-foundations` / `programming-foundations` | 6 | 24 | 6 |
| Python Level 1 | `course-python-foundations` / `python-foundations` | 10 | 40 | 10 |
| Python Level 2 | `course-python-level-2` / `python-level-2` | 10 | 40 | 10 |
| JavaScript Level 1 | `course-javascript-level-1` / `javascript-level-1` | 6 | 28 | 6 |
| Frontend Level 1 | `course-frontend-level-1` / `frontend-level-1` | 5 | 23 | 5 |
| **Total** | | **37** | **155** | **37** |

**Python Level 3** is **not** part of the production set.

Official seed allowlist (`database/seed_curriculum.php`) publishes **all five** IDs above (`is_published = 1`).

### Official install path

1. Import `database/MASTER_DATABASE.sql`
2. `php database/seed_curriculum.php`
3. `php database/seed_exams.php`

See `INSTALL.txt`. Do **not** use `production_rebuild.sql` or `cleanup_legacy_courses.sql` for normal production installs.

### Content architecture

| Concern | Authority |
|---------|-----------|
| Course catalog metadata | `data/courses.js` |
| Rich lesson bodies | `data/*_curriculum.js` + `data/curriculum_index.js` |
| MySQL structure seed | `data/curriculum_export.json` via `seed_curriculum.php` |
| Exam bank | `data/production_exams.json` (+ `_ar.json`) via `seed_exams.php` / submit fallback |
| Enrollment, progress, attempts | MySQL |

---

## 4. Student journey

1. **Signup** → profile with `role = student`  
2. **Login** → PHP session (`session_regenerate_id`)  
3. **Dashboard** → enrolled courses + XP/stats from MySQL  
4. **Explore Courses** → published courses  
5. **Enroll** → `POST /api/courses/enroll.php` → `course_enrollments`  
6. **My Courses** → enrollments from API  
7. **Course → chapter → lesson** → sequential unlock  
8. **Complete lesson** → `lesson_progress`  
9. **Chapter exam** after lessons → pass (≥60%) unlocks next chapter path  
10. Progress visible on dashboard / course pages from DB  

New accounts start with **zero** enrollments (no auto-enroll).

---

## 5. Enrollment

- Manual only via enroll API (CSRF + student auth).  
- Duplicate enroll returns success with `already_enrolled`.  
- Access checks use session user, not client-supplied alternate user ids.  
- Client may cache enrollment ids in `localStorage` for UI; **authoritative store is MySQL**.

---

## 6. Lesson system

Lessons include educational blocks such as:
- Dialogue (Cody/Shady style)
- Explanation / concept
- Examples and syntax-highlighted code
- Playground / run sandbox
- Tiny challenge
- Quick check
- Mission
- Visual summary / key points
- **YouTube enrichment** (search link)

**Progression:** first lesson of an enrolled course is open; later lessons require previous completion; chapter boundaries may require prior chapter exam pass (server-side in `api/lessons/complete.php`).

**Lesson page layout:** the student **lesson page intentionally has no app sidebar/aside**. Navigation uses the top header (and mobile link to courses). Dashboard/course/admin/teacher pages may still use sidebars.

**Bilingual content:**  
- Titles/metadata via translation tables / AR packs  
- PF rich Arabic blocks in `data/educational_ar_lessons.json`  
- Python L1/L2 AR **block bodies** may still fall back to English/DB if AR blocks empty (known limitation)

---

## 7. Progress system

| Entity | Storage |
|--------|---------|
| Lesson complete | `lesson_progress` |
| Chapter status | `chapter_progress` |
| Course progress | `course_progress` |
| Exam attempts | `exam_attempts` (+ archive table on reset) |

Authoritative progress is **server-side MySQL**. Dashboard and course UIs should read APIs, not treat localStorage as source of truth.

---

## 8. Exam system

- **26** chapter exams, **6** questions each, **156** total  
- Mostly MCQ (A–D); same structure EN/AR  
- **Pass threshold:** 60%  
- **Attempts:** 3 per cycle; history stored; archive on reset paths  
- **Grading:** server-side (`api/exams/submit.php`)  
- **Active exam:** API does **not** send correct answers until review mode  
- **Unlock:** chapter progression gated on pass where configured  

**Localization:** Arabic is the **same** exam (same ids, choice keys, correct letters)—only display language changes. Data: `data/production_exams.json` + `data/production_exams_ar.json`, seeded into DB + translation tables.

**Exam page:** language toggle in header; switching language reloads presentation without intentionally creating a new attempt.

---

## 9. Language / localization

- **System:** `js/i18n.js`, `locales/en.json`, `locales/ar.json`, PHP `includes/i18n_helpers.php`, translation tables (migration 004)  
- **Persistence:** `localStorage` key `sps_orbit_language`; authenticated `profiles.preferred_language`  
- **RTL:** Arabic sets `dir=rtl` on document; code/editor/terminal stay LTR  

### Exception: `index.html`
- **English only** by design  
- **No language toggle**  
- Does **not** switch to Arabic or RTL based on stored preference  
- Flag: `window.__SPS_LANDING_ENGLISH_ONLY__` — i18n skips switcher/RTL/static AR apply on landing only  
- Other pages keep full EN/AR behavior  

---

## 10. YouTube enrichment

`student/lesson.html` builds a YouTube search URL from:

1. Explicit `lesson.youtube_query` when it matches the **current language** (Arabic script for AR, Latin for EN)  
2. Otherwise derives a query from lesson title / course tech  

- **English:** e.g. `Python variables for beginners`  
- **Arabic:** e.g. `شرح المتغيرات بايثون للمبتدئين` (built from Arabic title when available)

Language follows the active lesson/UI language (`i18n.getLanguage()`).

---

## 11. Admin system

- Dashboard metrics from real `COUNT(*)` queries (`api/admin/metrics.php`)  
- Teacher create; activate/deactivate (`is_active`)  
- Assign groups / classes / individual students  
- Failures should return errors, not silent fake zeros  

---

## 12. Teacher system

- Accounts created by admin  
- Roster = union of group, class, and direct assignments for **that teacher only**  
- Progress shown is DB-backed for assigned students  

---

## 13. Security model (implemented in code)

| Control | Implementation |
|---------|----------------|
| Passwords | `password_hash` / `password_verify` |
| Sessions | PHP session; regenerate on login |
| Roles | Middleware; signup forces student |
| Inactive users | Login blocked if `is_active != 1` |
| SQL | Prepared statements widely used |
| CSRF | `middleware/csrf.php` on key POSTs (enroll, exam submit, etc.) |
| Exam keys | Withheld until review mode |
| IDOR (teacher) | SQL scoped to `teacher_id` |
| Lesson/exam locks | Server checks in complete/get/submit |

**Not claimed as fully verified in every environment:** live InfinityFree penetration tests, every endpoint CSRF matrix, session cookie flags on host.

**Legacy risk:** `server.js` is a **Node mock API** with fake data—**not** production. Production is PHP + MySQL only.

---

## 14. Technical architecture

```
Browser (HTML/JS student|teacher|admin pages)
    → PHP endpoints under /api/...
    → MySQL (profiles, courses, progress, exams, translations, …)
```

**Frontend:** static HTML under `student/`, `teacher/`, `admin/`, plus shared `js/`, `css/`, `locales/`.

**Backend:** `api/**/*.php`, `middleware/`, `includes/`, `config/database.php`.

**Content files (seed / overlay):**
- Curriculum JS/JSON under `data/`
- `data/production_exams.json` / `production_exams_ar.json`
- `data/educational_ar_lessons.json`
- Seeds: `database/seed_curriculum.php`, `seed_exams.php`, `seed_translations.php`

**Legacy / non-production:** `server.js`, Next/React `app/` scaffolding, `package.json` Node scripts—do not use for school production deploy.

---

## 15. Source of truth

| Data | Authority |
|------|-----------|
| Auth identity | PHP session + `profiles` |
| Enrollment | `course_enrollments` |
| Progress / attempts | MySQL progress & exam tables |
| Permissions | role + assignment tables |
| Course/lesson/exam **structure** | DB after seed; JSON/JS are seed sources |
| UI strings | locales + i18n |
| Lesson AR body | DB translations and/or `educational_ar_lessons.json` |
| Exam AR text | translation tables / AR JSON |

localStorage: preferences and UI cache only.

---

## 16. Known limitations / verification status

- Live InfinityFree runtime may not have been verified from every maintainer environment  
- Python Level 1/2 Arabic **lesson blocks** in JSON may be empty → English body fallback until filled or DB translations complete  
- Dual `server.js` in repo can confuse local runs if Node is started instead of PHP  
- Config must not ship live DB passwords in public copies (rotate if exposed)

---

## 17. Key paths (quick map)

| Path | Role |
|------|------|
| `student/lesson.html` | Lesson player (no sidebar) |
| `student/exam.html` | Exam + language toggle |
| `student/courses.html` | Explore / enroll |
| `api/lessons/get.php` | Lesson payload + lang |
| `api/exams/get.php` / `submit.php` | Exam load / grade |
| `api/courses/enroll.php` | Enrollment |
| `js/i18n.js` | Language system |
| `index.html` | Public landing, **English only** |

---

*End of platform documentation.*
