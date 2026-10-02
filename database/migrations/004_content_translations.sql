-- Migration: Content translation tables for bilingual (en/ar) support
-- Content entities remain language-independent; translations are separate.
--
-- NOTE: Foreign keys intentionally OMITTED for shared hosting (InfinityFree /
-- MariaDB) where parent tables may use a different charset/collation than
-- utf8mb4_unicode_ci, which causes errno 150 on FK create.
-- Application code still joins by id; orphan rows are harmless.
--
-- Prerequisites: MASTER_DATABASE.sql already applied (courses, chapters, … exist).

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Course translations
CREATE TABLE IF NOT EXISTS course_translations (
    id CHAR(36) NOT NULL,
    course_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_course_lang (course_id, language),
    KEY idx_course_translations_course (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Chapter translations
CREATE TABLE IF NOT EXISTS chapter_translations (
    id CHAR(36) NOT NULL,
    chapter_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_chapter_lang (chapter_id, language),
    KEY idx_chapter_translations_chapter (chapter_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Lesson translations
CREATE TABLE IF NOT EXISTS lesson_translations (
    id CHAR(36) NOT NULL,
    lesson_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(512) NULL,
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_lesson_lang (lesson_id, language),
    KEY idx_lesson_translations_lesson (lesson_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Lesson block translations
CREATE TABLE IF NOT EXISTS lesson_block_translations (
    id CHAR(36) NOT NULL,
    lesson_block_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    content_json JSON NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_block_lang (lesson_block_id, language),
    KEY idx_block_translations_block (lesson_block_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exam translations
CREATE TABLE IF NOT EXISTS exam_translations (
    id CHAR(36) NOT NULL,
    exam_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    instructions TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_exam_lang (exam_id, language),
    KEY idx_exam_translations_exam (exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Question translations
CREATE TABLE IF NOT EXISTS question_translations (
    id CHAR(36) NOT NULL,
    question_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    question_text TEXT NOT NULL,
    options_json JSON NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_question_lang (question_id, language),
    KEY idx_question_translations_question (question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Question answer-key explanation translations
CREATE TABLE IF NOT EXISTS question_answer_key_translations (
    id CHAR(36) NOT NULL,
    question_answer_key_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    explanation TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_answer_key_lang (question_answer_key_id, language),
    KEY idx_answer_key_translations_key (question_answer_key_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
