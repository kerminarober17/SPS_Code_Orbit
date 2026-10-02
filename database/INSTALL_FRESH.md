# Code Orbit — Fresh database install

Use this order on an **empty** MySQL/MariaDB database.

## Official path (only these files)

| Order | File | Purpose |
|------:|------|---------|
| 1 | `database/MASTER_DATABASE.sql` | Schema + core tables + achievements |
| 2 | `database/migrations/004_content_translations.sql` | Bilingual translation tables (en/ar) |
| 3 | `database/migrations/005_challenges_system.sql` | Challenges system tables |
| 4 | `database/migrations/008_four_academic_tiers.sql` | 4 teacher tiers (Primary 3&4 / 5&6 / Prep / Secondary) |
| 5 | `database/seed_school_structure.sql` | Academic groups, grades, class sections |
| 6 | `php database/seed_curriculum.php` | Courses, chapters, lessons |
| 7 | `php database/seed_exams.php` | Exams |
| 8 | (optional) `database/seed_challenges.sql` | Sample challenges |
| 9 | (optional) `php database/archive_legacy/seed_translations.php` | Fill DB translation rows if used |

Then: `config/secrets.local.php` (DB + admin credentials).

---

## Commands

```bash
mysql -u USER -p DB_NAME < database/MASTER_DATABASE.sql
mysql -u USER -p DB_NAME < database/migrations/004_content_translations.sql
mysql -u USER -p DB_NAME < database/migrations/005_challenges_system.sql
mysql -u USER -p DB_NAME < database/migrations/008_four_academic_tiers.sql
mysql -u USER -p DB_NAME < database/seed_school_structure.sql

php database/seed_curriculum.php
php database/seed_exams.php
```

## Bilingual content (EN / AR)

| Layer | English | Arabic | Toggle |
|-------|---------|--------|--------|
| UI strings | `locales/en.json` | `locales/ar.json` | `js/i18n.js` language switcher |
| Lessons body | DB / curriculum seed | `data/educational_ar_lessons.json` (155 lessons) overlay when `lang=ar` | API `?lang=` + user preferred_language |
| Exams | `data/production_exams.json` (37) | `data/production_exams_ar.json` (37) | Exam page switcher reloads with `lang` |
| Course titles | DB | optional `*_translations` tables | same |

## After install — teacher roster

1. Create teacher (Admin → Teachers).
2. Assign one of the **4 tiers**: Primary 3 & 4 | Primary 5 & 6 | Preparatory | Secondary.
3. Students register with stage + **grade_level** + class letter.
4. Teacher dashboard shows **grade • Class letter**.

## Folder rules

- **Use for install:** only files listed above.
- **Do not run:** `database/archive_legacy/` except optional `seed_translations.php` if you want DB-level translations.
