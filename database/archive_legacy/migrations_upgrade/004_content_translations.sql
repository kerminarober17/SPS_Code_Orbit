-- Migration: Content translation tables for bilingual (en/ar) support
-- Content entities remain language-independent; translations are separate.
-- Same course_id / chapter_id / lesson_id / exam_id / question_id across languages.

SET FOREIGN_KEY_CHECKS = 0;

-- Course translations
CREATE TABLE IF NOT EXISTS course_translations (
    id CHAR(36) PRIMARY KEY,
    course_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_course_lang (course_id, language),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chapter translations
CREATE TABLE IF NOT EXISTS chapter_translations (
    id CHAR(36) PRIMARY KEY,
    chapter_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_chapter_lang (chapter_id, language),
    FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lesson translations (title, subtitle, description, etc.)
CREATE TABLE IF NOT EXISTS lesson_translations (
    id CHAR(36) PRIMARY KEY,
    lesson_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(512) NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_lesson_lang (lesson_id, language),
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lesson block translations (full educational content per block)
-- content_json holds the language-specific version of the block content
CREATE TABLE IF NOT EXISTS lesson_block_translations (
    id CHAR(36) PRIMARY KEY,
    lesson_block_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    content_json JSON NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_block_lang (lesson_block_id, language),
    FOREIGN KEY (lesson_block_id) REFERENCES lesson_blocks(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exam translations
CREATE TABLE IF NOT EXISTS exam_translations (
    id CHAR(36) PRIMARY KEY,
    exam_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructions TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_exam_lang (exam_id, language),
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Question translations
CREATE TABLE IF NOT EXISTS question_translations (
    id CHAR(36) PRIMARY KEY,
    question_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    question_text TEXT NOT NULL,
    options_json JSON,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_question_lang (question_id, language),
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Question explanation / feedback translations (from answer keys)
CREATE TABLE IF NOT EXISTS question_answer_key_translations (
    id CHAR(36) PRIMARY KEY,
    question_answer_key_id CHAR(36) NOT NULL,
    language VARCHAR(5) NOT NULL,
    explanation TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_answer_key_lang (question_answer_key_id, language),
    FOREIGN KEY (question_answer_key_id) REFERENCES question_answer_keys(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
