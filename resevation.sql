-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 08:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resevation`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash_advances`
--

CREATE TABLE `cash_advances` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `user_id` int(11) NOT NULL,
  `original_amount` float NOT NULL DEFAULT 0,
  `archived` tinyint(1) DEFAULT 0,
  `total_paid` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_advances`
--

INSERT INTO `cash_advances` (`id`, `name`, `amount`, `date`, `status`, `user_id`, `original_amount`, `archived`, `total_paid`) VALUES
(13, 'Lloydy', 450, '2024-10-10', 'Approved', 34, 500, 0, 50);

-- --------------------------------------------------------

--
-- Table structure for table `cottage/hall`
--

CREATE TABLE `cottage/hall` (
  `id` int(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `team` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feature`
--

CREATE TABLE `feature` (
  `id` int(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `desc` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feature`
--

INSERT INTO `feature` (`id`, `img`, `name`, `desc`) VALUES
(16, 'uploads/danrose_house.jpg', 'DanRose House', 'DanRose House');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_issued` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `original_amount` decimal(10,2) NOT NULL,
  `remaining_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `user_id`, `date_issued`, `amount`, `original_amount`, `remaining_amount`, `status`, `description`) VALUES
(67, 34, '2024-10-10', 3.00, 1334.00, 847.00, 'Paid', 'Payment Processed'),
(68, 34, '2024-10-10', 7.00, 1334.00, 840.00, 'Partially Paid', 'Payment Processed'),
(69, 34, '2024-10-10', 40.00, 1334.00, 800.00, 'Partially Paid', 'Payment Processed'),
(70, 34, '2024-10-10', 20.00, 1334.00, 780.00, 'Partially Paid', 'Payment Processed'),
(71, 34, '2024-10-10', 80.00, 1334.00, 700.00, 'Partially Paid', 'Payment Processed'),
(72, 34, '2024-10-10', 80.00, 1334.00, 620.00, 'Partially Paid', 'Payment Processed'),
(73, 34, '2024-10-10', 80.00, 1334.00, 540.00, 'Partially Paid', 'Payment Processed'),
(74, 34, '2024-10-10', 50.00, 1334.00, 490.00, 'Paid', 'Payment Processed'),
(75, 34, '2024-10-10', 90.00, 1334.00, 400.00, 'Paid', 'Payment Processed'),
(76, 34, '2024-10-10', 1.00, 1334.00, 399.00, 'Paid', 'Payment Processed'),
(77, 34, '2024-10-10', 1.00, 1334.00, 398.00, 'Paid', 'Payment Processed'),
(78, 34, '2024-10-10', 1.00, 1334.00, 397.00, 'Paid', 'Payment Processed'),
(79, 34, '2024-10-10', 7.00, 1334.00, 390.00, 'Paid', 'Payment Processed'),
(80, 34, '2024-10-10', 1.00, 1334.00, 389.00, 'Paid', 'Payment Processed'),
(81, 34, '2024-10-10', 1.00, 1334.00, 388.00, 'Paid', 'Payment Processed'),
(82, 34, '2024-10-10', 1.00, 1334.00, 387.00, 'Paid', 'Payment Processed'),
(83, 34, '2024-10-10', 42.00, 1334.00, 345.00, 'Paid', 'Payment Processed'),
(84, 34, '2024-10-10', 14.00, 1334.00, 331.00, 'Paid', 'Payment Processed'),
(85, 34, '2024-10-10', 4.00, 1334.00, 327.00, 'Paid', 'Payment Processed'),
(86, 34, '2024-10-10', 12.00, 1334.00, 315.00, 'Paid', 'Payment Processed'),
(87, 34, '2024-10-10', 315.00, 1334.00, 0.00, 'Paid', 'Payment Processed'),
(88, 34, '2024-10-10', 50.00, 500.00, 450.00, 'Paid', 'Payment Processed');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `admin_comment` text NOT NULL,
  `admin_approval` enum('Pending','Approved','Disapproved') NOT NULL DEFAULT 'Pending',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintinance`
--

CREATE TABLE `maintinance` (
  `id` int(150) NOT NULL,
  `item` varchar(150) NOT NULL,
  `price` double NOT NULL,
  `date` date NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` int(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `des` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `img`, `name`, `des`) VALUES
(11, 'uploads/permaDANROSE1.jpg', 'Perma', 'DanRose'),
(10, 'uploads/danrose_house.jpg', 'DanRose House', 'Hauz'),
(12, 'uploads/permaDANROSE.jpg', 'Perma', 'DanRose');

-- --------------------------------------------------------

--
-- Table structure for table `pumpboats`
--

CREATE TABLE `pumpboats` (
  `id` int(250) NOT NULL,
  `license_no` varchar(50) NOT NULL,
  `pumpboat_no` int(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `team` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pumpboats`
--

INSERT INTO `pumpboats` (`id`, `license_no`, `pumpboat_no`, `type`, `team`) VALUES
(14, '844', 36, 'Pamo', 'boang'),
(15, 'ad', 0, 'Pamo', 'ad'),
(17, 'asd', 0, 'Pamo', 'adas'),
(19, 'AS', 0, 'Pamo', 'ASD');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(250) NOT NULL,
  `trans_no` varchar(250) NOT NULL,
  `date_reserve` date NOT NULL,
  `child` int(250) NOT NULL,
  `adult` int(250) NOT NULL,
  `check_in` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `check_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(250) NOT NULL,
  `cottage/hall_id` int(250) NOT NULL,
  `customer_id` int(250) NOT NULL,
  `date_created` date NOT NULL,
  `downpayment` int(250) NOT NULL,
  `balance` int(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `trans_no`, `date_reserve`, `child`, `adult`, `check_in`, `check_out`, `status`, `cottage/hall_id`, `customer_id`, `date_created`, `downpayment`, `balance`) VALUES
(3, '1197077060', '2022-11-11', 3, 2, '2022-11-08 11:44:34', '0000-00-00 00:00:00', 'Fullypaid', 2, 18, '2022-11-08', 0, 0),
(4, '1231922180', '2024-06-14', 1, 1, '2024-06-14 09:50:40', '0000-00-00 00:00:00', 'Reserved', 3, 19, '2024-06-14', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(250) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `contact_no` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `uname` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `user_type_id` int(250) NOT NULL,
  `team` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `mname` varchar(150) NOT NULL,
  `person_to_contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `contact_no`, `address`, `uname`, `pass`, `user_type_id`, `team`, `email`, `reset_token`, `token_expiry`, `mname`, `person_to_contact`) VALUES
(1, 'admin', 'admin', '0', 'poblacion', 'admin', '$2a$12$wjuBwKj0IYk0NsL2zcrISOEgtCWkb4wadO9Jm/FYTquVrptAW3NYS', 1, '', 'symptomsvictems@gmail.com', '$2y$10$1vnAiJP4LzJnYFFprd1l6uqFDOQHMBivCVAy3MewFm5q64U3DodgC', '2024-09-30 06:08:29', '', ''),
(34, 'lloydy', 'Mikhamot', '09665581572', 'buang, buang, buang', 'lloydy', '$2a$12$wjuBwKj0IYk0NsL2zcrISOEgtCWkb4wadO9Jm/FYTquVrptAW3NYS', 3, '', 'jeanskyut@gmail.com', NULL, NULL, 'R', '09665581572');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(250) NOT NULL,
  `user_type_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'admin'),
(2, 'superadmin'),
(3, 'agent'),
(4, 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_advances`
--
ALTER TABLE `cash_advances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cottage/hall`
--
ALTER TABLE `cottage/hall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature`
--
ALTER TABLE `feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintinance`
--
ALTER TABLE `maintinance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pumpboats`
--
ALTER TABLE `pumpboats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_advances`
--
ALTER TABLE `cash_advances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cottage/hall`
--
ALTER TABLE `cottage/hall`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `feature`
--
ALTER TABLE `feature`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `maintinance`
--
ALTER TABLE `maintinance`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pumpboats`
--
ALTER TABLE `pumpboats`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
