
-- Database: msk_college

CREATE DATABASE IF NOT EXISTS msk_college;
USE msk_college;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'student') DEFAULT 'student'
);

-- Table: attendance
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    date DATE,
    subject VARCHAR(100),
    status ENUM('Present', 'Absent'),
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: marks
CREATE TABLE IF NOT EXISTS marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject VARCHAR(100),
    marks_obtained INT,
    max_marks INT,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: messages
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    subject VARCHAR(255),
    message TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

-- Sample admin
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@msk.edu', 'admin123', 'admin');

-- Sample students
INSERT INTO users (name, email, password, role) VALUES
('Student One', 'student1@msk.edu', 'student123', 'student'),
('Student Two', 'student2@msk.edu', 'student123', 'student'),
('Student Three', 'student3@msk.edu', 'student123', 'student'),
('Student Four', 'student4@msk.edu', 'student123', 'student'),
('Student Five', 'student5@msk.edu', 'student123', 'student'),
('Student Six', 'student6@msk.edu', 'student123', 'student'),
('Student Seven', 'student7@msk.edu', 'student123', 'student'),
('Student Eight', 'student8@msk.edu', 'student123', 'student'),
('Student Nine', 'student9@msk.edu', 'student123', 'student'),
('Student Ten', 'student10@msk.edu', 'student123', 'student');
