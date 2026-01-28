-- Create the database
CREATE DATABASE IF NOT EXISTS nfc_payment;
USE nfc_payment;

-- Students data table
CREATE TABLE students_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dept_no VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    card_number VARCHAR(50) UNIQUE,
    balance DECIMAL(10,2) DEFAULT 0.00,
    password VARCHAR(255) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Payment transactions table
CREATE TABLE payment (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_id VARCHAR(50) NOT NULL UNIQUE,
    amount DECIMAL(10,2) NOT NULL,
    reads_card TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Transaction logs table
CREATE TABLE logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    card_number VARCHAR(50) NOT NULL,
    transaction_type CHAR(1) NOT NULL, -- '0' for credit, '1' for debit
    amount DECIMAL(10,2) NOT NULL,
    previous_balance DECIMAL(10,2) NOT NULL,
    balance DECIMAL(10,2) NOT NULL,
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (card_number) REFERENCES students_data(card_number)
);

CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_type ENUM('payment', 'topup') NOT NULL,
    description TEXT,
    stripe_session_id VARCHAR(255),
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Insert admin user
INSERT INTO students_data (dept_no, name, password) 
VALUES ('Admin', 'Administrator', 'admin_password');

-- Add indexes
CREATE INDEX idx_card_number ON students_data(card_number);
CREATE INDEX idx_transaction_id ON payment(transaction_id);
CREATE INDEX idx_logs_card ON logs(card_number);
CREATE INDEX idx_logs_time ON logs(time);
-- Transaction history table
-- First, ensure students_data table has proper primary key

-- If the table already exists, you can add the foreign key with:
-- Add indexes to students_data
    ALTER TABLE payment ADD COLUMN transaction_type VARCHAR(10) NOT NULL;