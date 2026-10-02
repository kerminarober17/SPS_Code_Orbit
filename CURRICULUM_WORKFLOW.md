# Curriculum workflow (production)

## Authorities

| Layer | File(s) | Role |
|-------|---------|------|
| Catalog metadata | `data/courses.js` | Titles, slugs, images, claimed counts |
| Lesson bodies | `data/*_curriculum.js` | Rendered content in lesson UI |
| Registry | `data/curriculum_index.js` | Maps course IDs → curriculum modules |
| DB seed structure | `data/curriculum_export.json` | Courses/chapters/lessons for MySQL |
| Exams | `data/production_exams.json` (+ `_ar.json`) | Chapter exams |
| Runtime enrollment/progress | MySQL | Via APIs after seed |

## Official install

```bash
mysql -u USER -p DBNAME < database/MASTER_DATABASE.sql
php database/seed_curriculum.php
php database/seed_exams.php
```

Expect **5** published courses, **37** chapters, **155** lessons, **37** exams.

## Add a new course

1. Add metadata object to `data/courses.js`.
2. Add `data/<name>_curriculum.js` with the same course `id` / chapter / lesson ids.
3. Register the module in `data/curriculum_index.js`.
4. Add the full course tree to `data/curriculum_export.json`.
5. Add one exam per chapter to `data/production_exams.json` (and AR if needed).
6. Add the course id to `SPS_EXPECTED_COURSE_COUNTS` in `database/seed_curriculum.php` and update totals.
7. Update `SPS_EXPECTED_EXAM_COUNT` in `database/seed_exams.php` if chapter count changes.
8. Run `php database/seed_curriculum.php` then `php database/seed_exams.php`.
9. Confirm `/api/courses/list.php` shows the course with correct chapter/lesson counts.

Keep **ids and slugs stable** once students have progress.

## Add a chapter to an existing course

1. Edit the course’s `*_curriculum.js` module.
2. Mirror the chapter + lessons in `data/curriculum_export.json`.
3. Add exam entry for the new `chapter_id` in `production_exams.json`.
4. Update expected counts in `seed_curriculum.php` / `seed_exams.php`.
5. Re-run both seed scripts.

## Add a lesson

1. Edit the parent chapter in `*_curriculum.js`.
2. Mirror in `curriculum_export.json`.
3. Update lesson count expectations in `seed_curriculum.php`.
4. Re-run `seed_curriculum.php` (exams unchanged if no new chapter).

## Do not

- Run `production_rebuild.sql` or `cleanup_legacy_courses.sql` on live data.
- Rely on `seed_js_frontend_*` for normal installs (legacy).
- Create catalog-only courses without export + DB seed (enrollment will fail).
