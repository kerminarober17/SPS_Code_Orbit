# database/

## Official install only

See **INSTALL_FRESH.md** for the ordered steps.

Keep in this folder (and `migrations/`):

| File | Role |
|------|------|
| MASTER_DATABASE.sql | Schema |
| migrations/005_challenges_system.sql | Challenges |
| migrations/008_four_academic_tiers.sql | 4 teacher tiers |
| seed_school_structure.sql | Groups / grades / classes |
| seed_curriculum.php | Curriculum |
| seed_exams.php | Exams |
| seed_challenges.sql | Optional samples |

Everything else lives under **archive_legacy/** — do not run on a fresh school DB.
