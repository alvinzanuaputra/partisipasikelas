-- Database: partisipasi_kelas
-- Buat database terlebih dahulu: CREATE DATABASE partisipasi_kelas;

CREATE DATABASE IF NOT EXISTS partisipasi_kelas;
USE partisipasi_kelas;

-- Tabel untuk menyimpan data siswa
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan data kelas
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_code VARCHAR(20) UNIQUE NOT NULL,
    class_name VARCHAR(100) NOT NULL,
    description TEXT,
    instructor VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan data penilai
CREATE TABLE assessors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assessor_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('teacher', 'peer') DEFAULT 'teacher',
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan penilaian partisipasi
CREATE TABLE participations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    class_code VARCHAR(20) NOT NULL,
    assessor_id VARCHAR(20) NOT NULL,
    participation_score INT CHECK (participation_score >= 0 AND participation_score <= 100),
    speaking_quality INT CHECK (speaking_quality >= 1 AND speaking_quality <= 5),
    engagement_level INT CHECK (engagement_level >= 1 AND engagement_level <= 5),
    feedback TEXT,
    assessment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (class_code) REFERENCES classes(class_code) ON DELETE CASCADE,
    FOREIGN KEY (assessor_id) REFERENCES assessors(assessor_id) ON DELETE CASCADE
);

-- Tabel untuk enrollment siswa ke kelas
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    class_code VARCHAR(20) NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (class_code) REFERENCES classes(class_code) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, class_code)
);

-- Insert sample data
INSERT INTO students (student_id, name, email) VALUES
('23A1', 'Ade Sastro', 'ade@email.com'),
('23A2', 'Sania Leoran', 'sania@email.com'),
('23A3', 'Budi Herman', 'budi@email.com'),
('23A4', 'Maya Sari', 'maya@email.com'),
('23A5', 'Dina Kartika', 'dina@email.com');

INSERT INTO classes (class_code, class_name, description, instructor) VALUES
('ENG23A', 'Academic Speaking', 'Academic Speaking for English Language Learners', 'Ms. Rachel'),
('ENG23B', 'Academic Speaking', 'Academic Speaking for English Language Learners', 'Ms. Rachel');

INSERT INTO assessors (assessor_id, name, role, email) VALUES
('ENG0102', 'Ms. Rachel', 'teacher', 'rachel@university.edu');

INSERT INTO enrollments (student_id, class_code) VALUES
('23A1', 'ENG23A'),
('23A2', 'ENG23A'),
('23A3', 'ENG23A'),
('23A1', 'ENG23B'),
('23A2', 'ENG23B'),
('23A3', 'ENG23B'),
('23A4', 'ENG23B');

INSERT INTO participations (student_id, class_code, assessor_id, participation_score, speaking_quality, engagement_level, feedback, assessment_date) VALUES
('23A1', 'ENG23A', 'ENG0102', 100, 4, 4, 'Good participation in discussions. Shows improvement in fluency.', '2024-11-15'),
('23A1', 'ENG23B', 'ENG0102', 92, 5, 5, 'Excellent participation. Very engaged and asks thoughtful questions.', '2024-11-15');