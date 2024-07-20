-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 03:26 AM
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
  `original_amount` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_advances`
--

INSERT INTO `cash_advances` (`id`, `name`, `amount`, `date`, `status`, `user_id`, `original_amount`) VALUES
(9, 'John Lloyd Bawi-in', 10, '2024-07-19', 'Approved', 19, 0),
(10, 'Micha Lopez', 2, '2024-07-20', 'Approved', 20, 4),
(11, 'Micha Lopez', 10, '2024-07-20', 'Approved', 20, 20);

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

--
-- Dumping data for table `cottage/hall`
--

INSERT INTO `cottage/hall` (`id`, `name`, `type`, `category`, `team`) VALUES
(54, 'John Lloyd Bawi-in', '424', 'Pamo', 'asd'),
(55, 'Micha Lopez', '36', 'Pamo', 'Isda');

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
(2, 19, '2024-07-19', 1.00, 0.00, 14.00, 'Paid', 'Payment Processed'),
(3, 19, '2024-07-19', 2.00, 0.00, 12.00, 'Paid', 'Payment Processed'),
(4, 19, '2024-07-19', 1.00, 12.00, 11.00, 'Paid', 'Payment Processed'),
(5, 19, '2024-07-19', 1.00, 11.00, 10.00, 'Paid', 'Payment Processed'),
(6, 20, '2024-07-20', 1.00, 12.00, 11.00, 'Paid', 'Payment Processed'),
(7, 20, '2024-07-20', 1.00, 11.00, 10.00, 'Paid', 'Payment Processed'),
(8, 20, '2024-07-20', 1.00, 0.00, 9.00, 'Paid', 'Payment Processed'),
(9, 20, '2024-07-20', 1.00, 0.00, 8.00, 'Paid', 'Payment Processed'),
(10, 20, '2024-07-20', 3.00, 8.00, 5.00, 'Paid', 'Payment Processed'),
(11, 20, '2024-07-20', 1.00, 0.00, 4.00, 'Paid', 'Payment Processed'),
(12, 20, '2024-07-20', 1.00, 4.00, 3.00, 'Paid', 'Payment Processed'),
(13, 20, '2024-07-20', 1.00, 4.00, 2.00, 'Paid', 'Payment Processed'),
(14, 20, '2024-07-20', 10.00, 20.00, 10.00, 'Paid', 'Payment Processed');

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

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`id`, `item_name`, `description`, `request_date`, `status`, `admin_comment`, `admin_approval`, `user_id`) VALUES
(13, 'Nylon', 'Nylon', '2024-07-15', '', '', 'Approved', 19),
(14, 'Pisi', 'Boning', '2024-07-17', 'Pending', '', 'Approved', 19);

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
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pumpboats`
--

INSERT INTO `pumpboats` (`id`, `license_no`, `pumpboat_no`, `type`, `status`) VALUES
(14, '844', 36, 'Pamo', '');

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
(4, '1231922180', '2024-06-14', 1, 1, '2024-06-14 09:50:40', '0000-00-00 00:00:00', 'Reserved', 3, 19, '2024-06-14', 0, 0),
(5, '779811827', '2024-07-02', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Processing', 2, 19, '2024-07-02', 0, 0);

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
  `team` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `contact_no`, `address`, `uname`, `pass`, `user_type_id`, `team`) VALUES
(1, 'admin', 'admin', '0', 'poblacion', 'admin', 'admin', 1, ''),
(19, 'John Lloyd', 'Bawi-in', '09665581572', 'Poblacion, Madridejos, Cebu', 'lloydy', 'lloydy', 3, 'Boning'),
(20, 'Micha', 'Lopez', '', '', 'Micha', '12345', 3, '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cottage/hall`
--
ALTER TABLE `cottage/hall`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `feature`
--
ALTER TABLE `feature`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pumpboats`
--
ALTER TABLE `pumpboats`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
