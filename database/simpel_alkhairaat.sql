-- SIMPEL-Alkhairaat Database Schema

-- Create database
CREATE DATABASE IF NOT EXISTS simpel_alkhairaat;
USE simpel_alkhairaat;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin_pusat', 'admin_kabupaten', 'admin_kecamatan', 'admin_sekolah') NOT NULL,
    school_id INT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_active (is_active)
);

-- Provinces table
CREATE TABLE provinces (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Regencies/Kabupaten table
CREATE TABLE regencies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    province_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (province_id) REFERENCES provinces(id) ON DELETE CASCADE
);

-- Districts/Kecamatan table
CREATE TABLE districts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    regency_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (regency_id) REFERENCES regencies(id) ON DELETE CASCADE
);

-- Schools/Sekolah table
CREATE TABLE schools (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    npsn VARCHAR(20),
    district_id INT NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    principal_name VARCHAR(100),
    total_students INT DEFAULT 0,
    total_teachers INT DEFAULT 0,
    founded_year INT,
    status ENUM('aktif', 'non-aktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (district_id) REFERENCES districts(id) ON DELETE CASCADE,
    INDEX idx_status (status)
);

-- Financial Reports table
CREATE TABLE financial_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    school_id INT NOT NULL,
    report_date DATE NOT NULL,
    month INT NOT NULL,
    year INT NOT NULL,
    opening_balance DECIMAL(15,2) DEFAULT 0,
    closing_balance DECIMAL(15,2) DEFAULT 0,
    status ENUM('draft', 'submitted', 'approved') DEFAULT 'draft',
    notes TEXT,
    created_by INT NOT NULL,
    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    INDEX idx_school (school_id),
    INDEX idx_date (report_date),
    INDEX idx_status (status)
);

-- Financial Transactions table
CREATE TABLE financial_transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    report_id INT NOT NULL,
    transaction_type ENUM('income', 'expense') NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    transaction_date DATE NOT NULL,
    reference_number VARCHAR(50),
    receipt_file VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES financial_reports(id) ON DELETE CASCADE,
    INDEX idx_type (transaction_type),
    INDEX idx_date (transaction_date)
);

-- Assets table
CREATE TABLE assets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    school_id INT NOT NULL,
    asset_code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    quantity INT NOT NULL DEFAULT 1,
    unit VARCHAR(50),
    purchase_date DATE,
    purchase_price DECIMAL(15,2),
    current_condition ENUM('baik', 'rusak ringan', 'rusak berat') DEFAULT 'baik',
    status ENUM('aktif', 'tidak-aktif', 'hilang') DEFAULT 'aktif',
    location VARCHAR(150),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_school (school_id),
    INDEX idx_status (status),
    INDEX idx_code (asset_code)
);

-- Visitor Book table
CREATE TABLE visitor_books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    school_id INT NOT NULL,
    visitor_name VARCHAR(100) NOT NULL,
    visitor_phone VARCHAR(20),
    visitor_email VARCHAR(100),
    visitor_organization VARCHAR(150),
    purpose TEXT NOT NULL,
    visit_date DATETIME NOT NULL,
    visit_duration INT,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_school (school_id),
    INDEX idx_date (visit_date)
);

-- Letters table
CREATE TABLE letters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    school_id INT NOT NULL,
    letter_type ENUM('keluar', 'masuk') NOT NULL,
    letter_number VARCHAR(50),
    subject VARCHAR(255) NOT NULL,
    sender_recipient VARCHAR(150),
    letter_date DATE NOT NULL,
    content TEXT,
    letter_file VARCHAR(255),
    status ENUM('draft', 'terkirim', 'diterima') DEFAULT 'draft',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_school (school_id),
    INDEX idx_type (letter_type),
    INDEX idx_status (status),
    INDEX idx_date (letter_date)
);

-- Activity Logs table
CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    module VARCHAR(50) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_date (created_at)
);

-- Insert default users
INSERT INTO users (username, email, password, name, role) VALUES
('admin_pusat', 'admin@pusat.com', '$2y$10$YourHashedPasswordHere', 'Administrator Pusat', 'admin_pusat'),
('admin_kab', 'admin@kabupaten.com', '$2y$10$YourHashedPasswordHere', 'Admin Kabupaten', 'admin_kabupaten'),
('admin_kec', 'admin@kecamatan.com', '$2y$10$YourHashedPasswordHere', 'Admin Kecamatan', 'admin_kecamatan'),
('admin_sekolah', 'admin@sekolah.com', '$2y$10$YourHashedPasswordHere', 'Admin Sekolah', 'admin_sekolah');
