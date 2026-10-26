CREATE DATABASE IF NOT EXISTS mental_health CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mental_health;

CREATE TABLE IF NOT EXISTS admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(80) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS assessments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 q1 TINYINT NOT NULL, q2 TINYINT NOT NULL, q3 TINYINT NOT NULL,
 q4 TINYINT NOT NULL, q5 TINYINT NOT NULL, q6 TINYINT NOT NULL,
 total_score TINYINT NOT NULL,
 result_level ENUM('low','mild','moderate','high') NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS suggestions (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(160) NOT NULL,
 description TEXT NOT NULL,
 min_level ENUM('low','mild','moderate','high') NOT NULL DEFAULT 'low',
 priority INT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS doctors (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(160) NOT NULL,
 qualification VARCHAR(160) NOT NULL,
 specialization VARCHAR(160) NOT NULL,
 location VARCHAR(160) NOT NULL,
 phone VARCHAR(60) DEFAULT '',
 website VARCHAR(255) DEFAULT '',
 min_level ENUM('low','mild','moderate','high') NOT NULL DEFAULT 'moderate',
 active TINYINT(1) NOT NULL DEFAULT 1,
 featured TINYINT(1) NOT NULL DEFAULT 0
);

-- Demo admin: username admin / password Admin@12345
-- CHANGE THIS PASSWORD IMMEDIATELY after first login.
INSERT INTO admins(username,password_hash)
VALUES ('admin','$2y$12$kbH6vOQYEaxzLHG/6aafSOMGIZEy3ZGgsIIE.PBpxJTNJmvLLAJhW')
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO suggestions(title,description,min_level,priority) VALUES
('Try mindful breathing','Spend a few minutes breathing slowly and comfortably, focusing attention on the breath.','low',10),
('Keep a regular sleep routine','Try to keep a consistent bedtime and wake time and create a calm wind-down routine.','low',9),
('Write down your thoughts','A short journal entry can help you notice patterns in stress, emotions and daily habits.','mild',8),
('Take short activity breaks','A short walk or gentle physical activity can be a useful break during a demanding day.','mild',7),
('Talk to someone you trust','Consider sharing what you are experiencing with a trusted friend, family member or mentor.','moderate',10),
('Consider professional support','A qualified mental-health professional can help you understand persistent or difficult concerns.','moderate',10),
('Seek support promptly','Consider arranging a conversation with a qualified mental-health professional, especially if difficulties are interfering with daily life.','high',10)
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- Replace these demonstration records with verified professionals before public deployment.
INSERT INTO doctors(name,qualification,specialization,location,phone,website,min_level,active,featured) VALUES
('Demo Professional — Replace Me','Qualified Mental-Health Professional','Counselling / Mental Well-being','Your City','', 'https://example.com','moderate',1,1),
('Demo Professional — Replace Me','Qualified Mental-Health Professional','Psychological Support','Your City','', 'https://example.com','high',1,0);
