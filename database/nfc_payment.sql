-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 08:07 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nfc_payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `card_number` varchar(15) NOT NULL,
  `transaction_type` int(2) NOT NULL,
  `amount` int(11) NOT NULL,
  `previous_balance` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `reads_card` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `transaction_id`, `amount`, `reads_card`, `timestamp`, `transaction_type`) VALUES
(1, 1672155155, 3000, 1, '2022-12-27 15:32:55', ''),
(2, 1672156442, 2000, 1, '2022-12-27 15:54:16', ''),
(3, 1672157061, 5000, 1, '2022-12-27 16:04:45', ''),
(4, 1672341723, 2500, 1, '2022-12-29 19:22:32', ''),
(5, 1672432360, 5000, 1, '2022-12-30 20:32:50', ''),
(6, 1673006318, 2000, 1, '2023-01-06 11:58:49', ''),
(7, 1736926152, 100, 1, '2025-01-16 05:36:46', ''),
(8, 1736926423, 100, 1, '2025-01-16 05:36:38', ''),
(9, 1736926888, 100, 1, '2025-01-16 05:36:22', ''),
(10, 1737006210, 100, 1, '2025-01-16 06:02:37', ''),
(11, 1737006293, 100, 1, '2025-01-16 06:01:33', ''),
(12, 1737006383, 100, 1, '2025-01-16 05:50:07', ''),
(13, 1737006685, 100, 1, '2025-01-16 05:51:28', ''),
(14, 1737006713, 500, 1, '2025-01-16 05:51:55', ''),
(15, 1737006733, 500, 1, '2025-01-16 05:52:16', ''),
(16, 1737007305, 100, 1, '2025-01-16 06:01:48', ''),
(17, 1737007380, 100, 1, '2025-01-16 06:03:03', ''),
(18, 1737007419, 100, 1, '2025-01-16 06:03:41', ''),
(19, 1737007468, 100, 1, '2025-01-16 06:04:31', ''),
(20, 1737007562, 100, 1, '2025-01-16 06:06:04', ''),
(21, 1737007781, 100, 1, '2025-01-16 06:09:44', ''),
(22, 1737007940, 100, 0, '2025-01-16 06:12:20', ''),
(23, 1737008000, 100, 0, '2025-01-16 06:13:20', ''),
(24, 1737008070, 100, 1, '2025-01-16 06:59:52', ''),
(25, 1737008107, 100, 1, '2025-01-16 06:54:29', ''),
(26, 1737008806, 100, 1, '2025-01-16 06:54:21', ''),
(27, 1737009976, 100, 1, '2025-01-16 06:46:19', ''),
(28, 1737010224, 100, 1, '2025-01-16 06:54:13', ''),
(29, 1737010366, 100, 1, '2025-01-16 06:53:08', ''),
(30, 1737010838, 100, 1, '2025-01-16 07:00:41', '1'),
(31, 1737010948, 100, 0, '2025-01-16 07:02:28', 'debit'),
(32, 1737011075, 100, 0, '2025-01-16 07:04:35', 'debit'),
(33, 1737011084, 1001, 1, '2025-01-16 07:07:28', 'debit'),
(34, 1737011149, 3, 1, '2025-01-16 07:07:23', 'debit'),
(35, 1737011188, 3, 1, '2025-01-16 07:06:30', 'debit'),
(36, 1737011203, 100, 1, '2025-01-16 07:06:45', 'debit'),
(37, 1737011228, 100, 1, '2025-01-16 07:07:11', 'credit'),
(38, 1737011257, 100, 1, '2025-01-16 07:07:40', 'credit'),
(39, 1737011321, 100, 1, '2025-01-16 07:08:44', 'debit'),
(40, 1737011587, 100, 0, '2025-01-16 07:13:07', 'debit'),
(41, 1737011604, 12000, 0, '2025-01-16 07:13:24', 'debit'),
(42, 1737011618, 12000, 1, '2025-01-16 07:13:41', 'credit'),
(43, 1737011717, 12000, 1, '2025-01-16 07:15:25', 'debit'),
(44, 1737011820, 100, 1, '2025-01-16 07:17:03', 'debit'),
(45, 1737011882, 100, 1, '2025-01-16 07:18:05', 'debit'),
(46, 1737012024, 100, 1, '2025-01-16 07:20:26', 'debit'),
(47, 1737013929, 100, 1, '2025-01-16 07:57:04', 'debit'),
(48, 1737014424, 100, 1, '2025-01-16 08:00:30', 'debit'),
(49, 1737016304, 100, 1, '2025-01-16 08:31:47', 'debit'),
(50, 1737016427, 100, 1, '2025-01-16 08:33:50', 'debit'),
(51, 1737036285, 100, 1, '2025-01-16 14:06:14', 'credit'),
(52, 1737036384, 100, 1, '2025-01-16 14:06:27', 'debit'),
(53, 1737036546, 100, 1, '2025-01-16 14:09:29', 'debit'),
(54, 1737036780, 100, 1, '2025-01-16 14:13:03', 'debit'),
(55, 1737036925, 100, 1, '2025-01-16 14:15:27', 'debit'),
(56, 1737037108, 100, 1, '2025-01-16 14:18:30', 'debit'),
(57, 1737175636, 100, 1, '2025-01-18 04:59:23', 'credit'),
(58, 1737175946, 100, 1, '2025-01-18 04:59:07', 'credit'),
(59, 1737176373, 100, 1, '2025-01-18 04:59:36', 'credit'),
(60, 1737176418, 100, 1, '2025-01-18 05:00:20', 'credit'),
(61, 1737176476, 10000, 0, '2025-01-18 05:01:16', 'debit'),
(62, 1737176530, 100, 1, '2025-01-18 05:02:13', 'debit'),
(63, 1737177890, 100, 1, '2025-01-18 05:24:53', 'credit'),
(64, 1737178060, 100, 1, '2025-01-18 05:27:52', 'credit'),
(65, 1737178507, 100, 1, '2025-01-18 05:35:10', 'credit'),
(66, 1737268840, 100, 1, '2025-01-19 06:40:43', 'credit'),
(67, 1737269447, 100, 1, '2025-01-19 06:50:51', 'credit'),
(68, 1737269459, 100, 1, '2025-01-19 06:51:02', 'debit'),
(69, 1737269861, 100, 1, '2025-01-19 07:04:32', 'debit'),
(70, 1737269865, 100, 1, '2025-01-19 06:59:18', 'debit'),
(71, 1737269965, 100, 1, '2025-01-19 06:59:29', 'debit'),
(72, 1737270138, 100, 1, '2025-01-19 07:02:21', 'credit'),
(73, 1737270166, 100, 1, '2025-01-19 07:02:48', 'credit'),
(74, 1737270264, 100, 1, '2025-01-19 07:04:26', 'credit'),
(75, 1737270331, 100, 1, '2025-01-19 07:05:33', 'credit'),
(76, 1737271059, 100, 1, '2025-01-19 09:53:20', 'credit'),
(77, 1737271257, 100, 1, '2025-01-19 09:53:11', 'credit'),
(78, 1737277077, 100, 1, '2025-01-19 09:53:05', 'credit'),
(79, 1737279183, 100, 1, '2025-01-19 09:51:30', 'credit'),
(80, 1737279579, 100, 1, '2025-01-19 09:49:02', 'credit'),
(81, 1737280148, 3, 1, '2025-01-19 09:49:10', 'credit'),
(82, 1737280297, 3, 1, '2025-01-19 09:51:40', 'credit'),
(83, 1737280409, 3, 1, '2025-01-19 09:53:32', 'credit'),
(84, 1737280465, 100000, 1, '2025-01-19 09:54:28', 'credit'),
(85, 1737280474, 100000, 1, '2025-01-19 09:54:37', 'debit'),
(86, 1737281031, 100, 1, '2025-01-19 10:03:55', 'credit'),
(87, 1737281051, 3, 1, '2025-01-19 10:04:15', 'credit'),
(88, 1737281063, 3, 1, '2025-01-19 10:04:25', 'debit'),
(89, 1737281679, 3, 0, '2025-01-19 10:14:39', 'debit'),
(90, 1737281700, 3, 1, '2025-01-19 10:23:33', 'credit'),
(91, 1737281779, 3, 1, '2025-01-19 10:21:24', 'credit'),
(92, 1737281820, 3, 1, '2025-01-19 10:17:03', 'credit'),
(93, 1737281934, 3, 1, '2025-01-19 10:18:56', 'credit'),
(94, 1737282019, 3, 1, '2025-01-19 10:20:21', 'credit'),
(95, 1737282317, 100, 1, '2025-01-19 10:25:21', 'credit');

-- --------------------------------------------------------

--
-- Table structure for table `students_data`
--

CREATE TABLE `students_data` (
  `student_id` int(11) NOT NULL,
  `dept_no` varchar(20) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `balance` int(5) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students_data`
--

INSERT INTO `students_data` (`student_id`, `dept_no`, `name`, `card_number`, `balance`, `password`, `date_created`) VALUES
(2, 'admin', 'admin', '', 23, 'admin', '2022-12-31 01:42:39'),
(6, '', 'Leander Bertie J', 'D32A0935', 3417, 'leander@2005', '2025-01-19 10:25:21'),
(7, '22-UCS-101', 'Leander Bertie J', 'C4319922', 1000, '02042005', '2025-03-13 18:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `temp_cards`
--

CREATE TABLE `temp_cards` (
  `id` int(11) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temp_cards`
--

INSERT INTO `temp_cards` (`id`, `card_number`, `created_at`) VALUES
(1, '15AF2C62', '2025-02-28 03:57:41'),
(2, '13424EFA', '2025-02-28 03:58:20'),
(3, '15AF2C62', '2025-02-28 04:00:29'),
(4, '15AF2C62', '2025-02-28 04:00:43'),
(5, '13424EFA', '2025-02-28 04:04:05'),
(6, '15AF2C62', '2025-02-28 04:06:49'),
(7, 'C4319922', '2025-03-13 18:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('payment','topup') NOT NULL,
  `description` text,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `student_id`, `amount`, `transaction_type`, `description`, `stripe_session_id`, `status`, `created_at`) VALUES
(1, '21/93734', '100.00', 'topup', 'Wallet top-up payment', 'cs_test_a1jBV5D43RDKLeACfNPsmRnCdhFpMKPVIx6Kkt5uc31KMkkMhSkAMI9Mca', 'completed', '2024-12-23 07:36:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `students_data`
--
ALTER TABLE `students_data`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `card_number` (`card_number`);

--
-- Indexes for table `temp_cards`
--
ALTER TABLE `temp_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `students_data`
--
ALTER TABLE `students_data`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `temp_cards`
--
ALTER TABLE `temp_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
