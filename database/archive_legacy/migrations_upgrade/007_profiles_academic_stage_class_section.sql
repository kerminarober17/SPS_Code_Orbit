-- Migration 007: Store student Academic Stage and Class (section letter) on profiles
-- NON-DESTRUCTIVE
--
-- Academic Stage: Primary | Preparatory | Secondary
-- Class (class_section): A | B | C | A2 | D | E | E2
--
-- profiles.class_id is preserved for any existing relational uses.
-- New registrations write academic_stage + class_section as the authoritative
-- human-readable school class data for Admin display and filters.

ALTER TABLE profiles
  ADD COLUMN academic_stage VARCHAR(32) NULL
    COMMENT 'School academic stage: Primary, Preparatory, Secondary'
    AFTER class_id,
  ADD COLUMN class_section VARCHAR(8) NULL
    COMMENT 'Student class letter/group: A, B, C, A2, D, E, E2'
    AFTER academic_stage;

-- Optional index for Admin filters
CREATE INDEX idx_profiles_academic_stage ON profiles (academic_stage);
CREATE INDEX idx_profiles_class_section ON profiles (class_section);
