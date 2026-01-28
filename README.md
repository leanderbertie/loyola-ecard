# 🎓 Loyola E-Card – Campus Payment Solution

## 📌 Project Overview

**Loyola E-Card** is an RFID-based campus payment system designed to address payment inefficiencies within Loyola College. The system replaces cash and network-dependent digital wallets with a **secure, fast, and reliable tap-to-pay solution** using RFID-enabled student ID cards.

The project aims to reduce transaction delays, eliminate cash handling issues, and provide a seamless payment experience for both students and vendors across the campus.

---

## 🎯 Problem Statement

Students at Loyola College face frequent issues with on-campus payments due to:

* Network failures during peak hours
* Dependence on digital wallets such as GPay
* Lack of physical cash
* Vendor difficulties in providing exact change
* Congestion in high-traffic areas like bike parking and stores

These challenges result in delays, frustration, and inefficient transaction handling.

---

## 💡 Proposed Solution

The **Loyola E-Card System** introduces an **RFID-based tap-to-pay mechanism** integrated into student ID cards.

### Key Concepts:

* Students preload money into their RFID card
* Payments are completed by tapping the card on an RFID reader
* Transactions are processed instantly without network dependency
* Vendors can track transactions digitally

---

## ✨ Features

* 🔖 RFID-based Tap-to-Pay system
* 💳 Prepaid balance management
* 🧾 Automatic transaction logging
* 📊 Vendor transaction tracking
* 🚫 Eliminates cash handling
* 📡 Network-independent payments
* 🔐 Secure and error-free transactions

---

## 🛠️ Technologies Used

### Hardware

* ESP32 Development Board
* RC522 RFID Module
* OLED Display
* Buzzer
* Breadboard & Jumper Wires
* USB Cable

### Software

* **Frontend:** HTML, CSS, JavaScript, PHP
* **Backend:** MySQL
* **IDE:** Visual Studio Code, Arduino IDE
* **Operating System:** Windows 10 or later

---

## 🏗️ System Architecture

The system consists of:

* RFID-enabled student ID cards
* ESP32 + RFID reader for card scanning
* Backend database for balance and transaction management
* Vendor interface for payment confirmation and logs

The architecture ensures **fast, offline-capable payment processing** and centralized transaction management.

---

## 🗂️ Database Design

### 1️⃣ STUDENTS_DATA

| Field        | Type          | Key     |
| ------------ | ------------- | ------- |
| id           | INT           | Primary |
| dept_no      | VARCHAR(50)   | Unique  |
| name         | VARCHAR(100)  | —       |
| card_number  | VARCHAR(50)   | Unique  |
| balance      | DECIMAL(10,2) | —       |
| password     | VARCHAR(255)  | —       |
| date_created | TIMESTAMP     | —       |

### 2️⃣ PAYMENT (NFC Payments)

| Field          | Type          | Key     |
| -------------- | ------------- | ------- |
| payment_id     | INT           | Primary |
| transaction_id | VARCHAR(50)   | Unique  |
| student_id     | VARCHAR(50)   | —       |
| amount         | DECIMAL(10,2) | —       |
| reads_card     | TINYINT(1)    | —       |
| status         | ENUM          | —       |
| created_at     | TIMESTAMP     | —       |

### 3️⃣ LOGS (Transaction History)

| Field            | Type          |
| ---------------- | ------------- |
| log_id           | INT           |
| card_number      | VARCHAR(50)   |
| transaction_type | CHAR(1)       |
| amount           | DECIMAL(10,2) |
| previous_balance | DECIMAL(10,2) |
| balance          | DECIMAL(10,2) |
| payment_id       | INT           |
| transaction_id   | INT           |
| time             | TIMESTAMP     |

### 4️⃣ TRANSACTIONS (Online Top-Ups)

| Field             | Type          |
| ----------------- | ------------- |
| id                | INT           |
| student_id        | VARCHAR(50)   |
| amount            | DECIMAL(10,2) |
| transaction_type  | ENUM          |
| description       | TEXT          |
| stripe_session_id | VARCHAR(255)  |
| status            | ENUM          |
| created_at        | TIMESTAMP     |

---

## 🚀 How to Run the Project

1. Clone the repository:

   ```bash
   git clone https://github.com/leanderbertie/loyola-ecard.git
   ```
2. Import the MySQL database using the provided SQL schema
3. Configure database credentials in backend files
4. Open the frontend using a local server (XAMPP / Live Server)
5. Upload Arduino code to ESP32 via Arduino IDE
6. Connect RFID hardware and test tap-to-pay functionality

---

## 📘 What I Learned

* RFID-based system integration
* Embedded systems using ESP32
* Secure transaction handling
* Database schema design
* Full-stack development
* Real-world problem-solving in campus environments

---

## ⚠️ Challenges Faced

* Handling peak-hour payment congestion
* Designing network-independent transactions
* Integrating hardware with backend systems

### Solutions

* RFID tap-to-pay implementation
* Local transaction validation
* Centralized database logging

---

