# SPS Code Orbit

School coding platform (PHP + MySQL + static HTML/JS).

## Official production install

See **INSTALL.txt** for the full checklist.

```bash
mysql -u USER -p DBNAME < database/MASTER_DATABASE.sql
# configure config/secrets.local.php
php database/seed_curriculum.php   # 5 courses, 37 chapters, 155 lessons
php database/seed_exams.php         # 37 chapter exams
```

## Official courses

1. Programming Foundations
2. Python Foundations (Level 1)
3. Python Level 2
4. JavaScript Level 1
5. Frontend Level 1

## Content sources

| Layer | Path |
|-------|------|
| Catalog metadata | `data/courses.js` |
| Lesson bodies | `data/*_curriculum.js` |
| DB structure seed | `data/curriculum_export.json` |
| Exams | `data/production_exams.json` |

Do **not** run `database/production_rebuild.sql` or `database/cleanup_legacy_courses.sql` for normal installs.
