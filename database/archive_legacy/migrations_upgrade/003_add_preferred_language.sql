-- Migration: Add preferred_language to profiles
-- Allowed values: 'en', 'ar'
-- Default: 'en'

ALTER TABLE profiles
ADD COLUMN preferred_language VARCHAR(5) NOT NULL DEFAULT 'en'
COMMENT 'User preferred UI/content language: en or ar'
AFTER avatar_url;

-- Ensure existing rows have the default
UPDATE profiles SET preferred_language = 'en' WHERE preferred_language IS NULL OR preferred_language = '';

-- Optional index for future queries (low cardinality, optional)
-- CREATE INDEX idx_profiles_preferred_language ON profiles(preferred_language);
