-- Cyber Fraud Awareness DB
CREATE DATABASE IF NOT EXISTS cyber_fraud;
USE cyber_fraud;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    is_admin TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    category VARCHAR(100),
    content TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_email VARCHAR(150),
    type VARCHAR(100),
    details TEXT,
    status VARCHAR(50) DEFAULT 'Received',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample tips
INSERT INTO tips (title,category,content) VALUES
('Recognize Phishing Emails','Phishing','Check sender address, avoid clicking unknown links, never enter credentials on unfamiliar pages.'),
('Safe Online Shopping','Online Shopping','Use secure payment methods, check seller reviews, prefer official websites and apps.'),
('Protect Your Banking Info','Banking','Enable two-factor authentication, never share OTPs, verify bank messages via official channels.');

-- Insert admin user (email: admin@example.com, password: Admin@123)
INSERT INTO users (name,email,password,is_admin) VALUES ('Administrator','admin@example.com','$2b$12$yl1RHkdM92JOw6R4cT7jnuutXCCJ5Ju2xi9wsXLrZZqsa0Kh9L.QO',1);
