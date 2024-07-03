-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 08:20 AM
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
-- Database: `farm`
--
CREATE DATABASE IF NOT EXISTS `farm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `farm`;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `createuser` varchar(255) DEFAULT NULL,
  `deleteuser` varchar(255) DEFAULT NULL,
  `createbid` varchar(255) DEFAULT NULL,
  `updatebid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `createuser`, `deleteuser`, `createbid`, `updatebid`) VALUES
(1, 'Superuser', '1', '1', '1', '1'),
(2, 'Admin', '1', '1', '1', '1'),
(3, 'User', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `store_out`
--

CREATE TABLE `store_out` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `itemsoutvalue` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_out`
--

INSERT INTO `store_out` (`id`, `date`, `item`, `quantity`, `itemsoutvalue`) VALUES
(1, '2024-05-13', 'SIKEN ZOY', '10', 10),
(2, '2024-05-13', 'SIKEN', '3', 3),
(3, '2024-05-14', 'SIKEN', '300', 300),
(4, '2024-05-14', 'SIKEN', '300', 300),
(5, '2024-05-14', 'SIKEN', '300', 300),
(6, '2024-05-14', 'ITLOG', '200', 200),
(7, '2024-05-14', 'SIKEN', '200', 200);

-- --------------------------------------------------------

--
-- Table structure for table `store_stock`
--

CREATE TABLE `store_stock` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item` varchar(500) NOT NULL,
  `product_id` varchar(500) NOT NULL DEFAULT '',
  `rate` varchar(500) NOT NULL,
  `total` varchar(500) NOT NULL,
  `quantity_remaining` varchar(500) NOT NULL,
  `itemvalue` int(15) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_stock`
--

INSERT INTO `store_stock` (`id`, `date`, `item`, `product_id`, `rate`, `total`, `quantity_remaining`, `itemvalue`, `status`) VALUES
(24, '2024-05-16', 'klkh', '', '89', '408421', '4566', 408421, '0'),
(25, '2024-05-21', 'itlog ni jericho', '', '100', '764272', '81', 764272, '1'),
(26, '2024-05-22', 'Chicken Small', '', '111', '7810', '76', 7810, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `Staffid` int(10) DEFAULT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `Photo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'avatar15.jpg',
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `Staffid`, `AdminName`, `UserName`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Status`, `Photo`, `Password`, `AdminRegdate`, `reset_token`) VALUES
(2, 1002, 'Admin', 'admin', 'Diwata', 'Oberkok', 9423979339, 'nexus@gmail.com', 1, 'diwata.jpg', 'c4ca4238a0b923820dcc509a6f75849b', '2022-03-15 10:18:39', '8bb4f2cc77a50cc0305fee84dfef48b994843cb570504f1d6fc7a6de0842774c89b626579e35fb828dfc7bf6a81ee9c61a2f'),
(9, 1003, 'Admin', 'staff', 'Raghav', 'Jain', 9090909090, 'symptomsvictems@yahoo.com', 2, 'pic_3.jpg', 'c4ca4238a0b923820dcc509a6f75849b', '2022-03-15 10:18:39', '8bb4f2cc77a50cc0305fee84dfef48b994843cb570504f1d6fc7a6de0842774c89b626579e35fb828dfc7bf6a81ee9c61a2f');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `CategoryCode` varchar(50) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `CategoryCode`, `PostingDate`) VALUES
(1, 'EGGS', 'RKF-001', '2022-03-13 18:28:24'),
(3, 'Manok', '3572', '2024-04-24 14:59:49'),
(4, 'bantres', '123', '2024-05-14 04:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `tblcompany`
--

CREATE TABLE `tblcompany` (
  `id` int(11) NOT NULL,
  `regno` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `companyname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `companyemail` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `companyphone` text NOT NULL,
  `companyaddress` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `companylogo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'avatar15.jpg',
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `developer` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcompany`
--

INSERT INTO `tblcompany` (`id`, `regno`, `companyname`, `companyemail`, `country`, `companyphone`, `companyaddress`, `companylogo`, `status`, `developer`, `creationdate`) VALUES
(4, '3422232443223', 'Wellington Poultry Farm', 'wllingtonpoultryfarm@gmail.com', 'Philippines', '09665581572', 'Tugas, Madridejos, Cebu', 'poultrylogo.png', '1', 'Nikhil_Bhalerao', '2021-02-02 12:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

CREATE TABLE `tblitems` (
  `id` int(11) NOT NULL,
  `item` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblitems`
--

INSERT INTO `tblitems` (`id`, `item`, `description`, `Creationdate`) VALUES
(35, 'itlog ni jericho', 'small', '2024-05-16 02:40:53'),
(36, 'Chicken Small', 'small', '2024-05-16 05:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `InvoiceNumber` int(11) DEFAULT NULL,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerContactNo` bigint(12) DEFAULT NULL,
  `PaymentMode` varchar(100) DEFAULT NULL,
  `InvoiceGenDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`id`, `ProductId`, `Quantity`, `InvoiceNumber`, `CustomerName`, `CustomerContactNo`, `PaymentMode`, `InvoiceGenDate`) VALUES
(1, 1, 10, 789218424, 'Suraj Jain', 9423979339, 'COD', '2022-03-13 18:38:29'),
(2, 2, 6, 789218424, 'Suraj Jain', 9423979339, 'COD', '2022-03-13 18:38:30'),
(3, 4, 10, 789218424, 'Suraj Jain', 9423979339, 'COD', '2022-03-13 18:38:30'),
(4, 3, 1, 115696254, 'sad', 0, 'COD', '2023-04-29 12:11:50'),
(5, 3, 1, 944179197, 'asdsa', 0, 'COD', '2023-04-29 12:15:32'),
(6, 4, 1, 208755782, 'asdas', 122, 'COD', '2023-04-29 12:16:36'),
(7, 1, 1, 396734329, 'k', 8798000000000000, 'COD', '2024-04-22 11:54:55'),
(8, 1, 1, 826683818, 'nexus ', 9665581572, 'COD', '2024-04-24 15:55:30'),
(9, 2, 1, 826683818, 'nexus ', 9665581572, 'COD', '2024-04-24 15:55:30'),
(10, 3, 1, 826683818, 'nexus ', 9665581572, 'COD', '2024-04-24 15:55:30'),
(11, 7, 1, 826683818, 'nexus ', 9665581572, 'COD', '2024-04-24 15:55:30'),
(12, 8, 1, 826683818, 'nexus ', 9665581572, 'COD', '2024-04-24 15:55:30'),
(13, 8, 5, 149630434, 'nexus ', 9665581572, 'COD', '2024-04-24 16:04:17'),
(14, 1, 7, 778843564, 'nexus ', 9665581572, 'COD', '2024-04-24 16:18:55'),
(15, 7, 13, 569135649, 'nexus ', 9665581572, 'COD', '2024-04-24 16:20:07'),
(16, 3, 1, 468169191, 'nexus ', 9665581572, 'CASH', '2024-05-06 16:48:46'),
(17, 1, 1, 468169191, 'nexus ', 9665581572, 'CASH', '2024-05-06 16:48:46'),
(18, 9, 1, 468169191, 'nexus ', 9665581572, 'CASH', '2024-05-06 16:48:46'),
(19, 9, 1, 632233186, 'nexus ', 9665581572, 'CASH', '2024-05-06 16:49:22'),
(20, 3, 1, 632233186, 'nexus ', 9665581572, 'CASH', '2024-05-06 16:49:22'),
(21, 9, 5, 126556447, 'nexus ', 9665581572, 'CASH', '2024-05-06 17:58:44'),
(22, 12, 500, 126556447, 'nexus ', 9665581572, 'CASH', '2024-05-06 17:58:44'),
(23, 13, 300, 126556447, 'nexus ', 9665581572, 'CASH', '2024-05-06 17:58:44'),
(24, 13, 1, 904551622, 'nexus ', 63665581572, 'CASH', '2024-05-13 16:21:22'),
(25, 13, 1, 292222705, 'nexus buang', 63665581572, 'CASH', '2024-05-13 16:24:08'),
(26, 9, 1, 693396724, 'nexus buang', 9665581572, 'CASH', '2024-05-13 16:27:50'),
(27, 9, 9, 715239214, 'nexus buang', 9665581572, 'CASH', '2024-05-13 16:28:17'),
(28, 13, 1, 973494876, 'nexus buang', 9665581572, 'CASH', '2024-05-13 16:34:15'),
(29, 15, 1, 342667540, 'nexus buang', 12313123213, 'CASH', '2024-05-14 04:59:07'),
(30, 16, 8, 589482059, 'permen gwapo', 9123456777, 'CASH', '2024-05-14 05:17:59'),
(31, 19, 11, 307565225, 'ikaw mamamo', 9747483838, 'CASH', '2024-05-14 05:36:41'),
(32, 19, 11, 396220761, 'ikaw mamamo', 9884848444, 'CASH', '2024-05-14 05:40:25'),
(33, 9, 50, 296737434, 'nexus buang', 9665581572, 'CASH', '2024-05-15 07:24:43'),
(34, 22, 50, 681947438, 'nexus buang', 9665581572, 'CASH', '2024-05-15 08:22:56'),
(35, 22, 50, 903235278, 'nexus buang', 9665581572, 'CASH', '2024-05-15 08:24:33'),
(36, 23, 10, 129011770, 'nexus buang', 9665581572, 'CASH', '2024-05-15 08:29:57'),
(37, 24, 20, 832986995, 'nexus buang', 9665581572, 'CASH', '2024-05-15 08:42:46'),
(38, 33, 1, 860811664, 'nexus buang', 9665581572, 'CASH', '2024-05-15 10:39:59'),
(39, 34, 23, 156832649, 'permen permen', 9665581572, 'CASH', '2024-05-16 02:37:44'),
(40, 35, 25, 612292757, 'jerson bwaon', 9665581572, 'CASH', '2024-05-16 02:42:20'),
(41, 36, 12, 692634226, 'nexus buang', 9665581572, 'CASH', '2024-05-16 05:49:25'),
(42, 35, 80, 230478035, 'nexus buang', 9665581572, 'CASH', '2024-05-16 06:06:09'),
(43, 36, 1, 583715027, 'nexus ', 9665581572, 'CASH', '2024-05-21 03:23:05'),
(44, 36, 1, 853169914, 'jade m velez', 9665581572, 'CASH', '2024-05-21 04:23:55'),
(45, 35, 1, 853169914, 'jade m velez', 9665581572, 'CASH', '2024-05-21 04:23:55'),
(46, 35, 5000, 885445344, 'ikaw mamamo', 9665581572, 'CASH', '2024-05-21 04:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `ProductName` varchar(150) DEFAULT NULL,
  `ProductImage` varchar(255) DEFAULT NULL,
  `ProductPrice` decimal(10,0) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `CategoryName`, `ProductName`, `ProductImage`, `ProductPrice`, `PostingDate`, `UpdationDate`) VALUES
(35, 'EGGS', 'itlog ni jericho', 'diwata.jpg', 100, '2024-05-16 02:40:15', NULL),
(36, 'Manok', 'Chicken Small', 'dog.jpg', 10, '2024-05-16 05:43:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_out`
--
ALTER TABLE `store_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_stock`
--
ALTER TABLE `store_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcompany`
--
ALTER TABLE `tblcompany`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_out`
--
ALTER TABLE `store_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `store_stock`
--
ALTER TABLE `store_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblcompany`
--
ALTER TABLE `tblcompany`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblitems`
--
ALTER TABLE `tblitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- Database: `farm1`
--
CREATE DATABASE IF NOT EXISTS `farm1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `farm1`;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `createuser` varchar(255) DEFAULT NULL,
  `deleteuser` varchar(255) DEFAULT NULL,
  `createbid` varchar(255) DEFAULT NULL,
  `updatebid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `createuser`, `deleteuser`, `createbid`, `updatebid`) VALUES
(1, 'Superuser', '1', '1', '1', '1'),
(2, 'Admin', '1', NULL, '1', '1'),
(3, 'User', NULL, NULL, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_out`
--

CREATE TABLE `store_out` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `itemsoutvalue` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_out`
--

INSERT INTO `store_out` (`id`, `date`, `item`, `quantity`, `itemsoutvalue`) VALUES
(1, '2023-05-03', 'PRECUT CHICKEN - 500 GM', '54', 36558);

-- --------------------------------------------------------

--
-- Table structure for table `store_stock`
--

CREATE TABLE `store_stock` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item` varchar(500) NOT NULL,
  `product_id` varchar(500) NOT NULL DEFAULT '',
  `rate` varchar(500) NOT NULL,
  `total` varchar(500) NOT NULL,
  `quantity_remaining` varchar(500) NOT NULL,
  `itemvalue` int(15) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_stock`
--

INSERT INTO `store_stock` (`id`, `date`, `item`, `product_id`, `rate`, `total`, `quantity_remaining`, `itemvalue`, `status`) VALUES
(1, '2022-03-14', 'PRECUT CHICKENs - 500 GM', '4', '677', '6770', '10', 6770, '1'),
(4, '2022-03-14', 'WHOLE EGG POWDER (50 gm)', '1', '499', '4990', '9', 4990, '1'),
(5, '2022-03-14', 'READY TO COOK - OMELET POWDER (50 gm)', '2', '299', '2990', '10', 2990, '1'),
(6, '2022-03-14', 'WHOLE CHICKEN - 900 GM', '3', '699', '6990', '10', 6990, '1'),
(7, '2023-05-03', 'PRECUT CHICKEN - 500 GM', '', '677', '43328', '9', 6770, '1'),
(8, '2024-04-25', 'SIKEN', '', '5', '100', '20', 100, '1'),
(9, '2024-05-07', 'SIKEN ZOY', '', '5', '50', '10', 50, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `Staffid` int(10) DEFAULT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `Photo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'avatar15.jpg',
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `Staffid`, `AdminName`, `UserName`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Status`, `Photo`, `Password`, `AdminRegdate`) VALUES
(2, 1002, 'Admin', 'admin', 'John Lloyd', 'Bawi-in', 9423979339, 'admin', 1, 'john.jpg', '21232f297a57a5a743894a0e4a801fc3', '2022-03-15 10:18:39'),
(9, 1003, 'Admin', 'staff', 'Raghav', 'Jain', 9090909090, 'symptomsvictems@gmail.com', 2, 'pic_3.jpg', '21232f297a57a5a743894a0e4a801fc3', '2022-03-15 10:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `CategoryCode` varchar(50) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `CategoryCode`, `PostingDate`) VALUES
(1, 'EGGS', 'RKF-001', '2022-03-13 18:28:24'),
(2, 'CHICKEN', 'RKF-002', '2022-03-13 18:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblcompany`
--

CREATE TABLE `tblcompany` (
  `id` int(11) NOT NULL,
  `regno` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `companyname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `companyemail` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `companyphone` text NOT NULL,
  `companyaddress` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `companylogo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'avatar15.jpg',
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `developer` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcompany`
--

INSERT INTO `tblcompany` (`id`, `regno`, `companyname`, `companyemail`, `country`, `companyphone`, `companyaddress`, `companylogo`, `status`, `developer`, `creationdate`) VALUES
(4, '3422232443223', 'Wellington Poultry Farm', 'wellingtonpoultryfarm@gmail.com', 'Philippines', '091234567891', 'Tugas, Madridejos, Cebu', 'poultrylogo.png', '1', 'Nikhil_Bhalerao', '2021-02-02 12:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

CREATE TABLE `tblitems` (
  `id` int(11) NOT NULL,
  `item` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblitems`
--

INSERT INTO `tblitems` (`id`, `item`, `description`, `Creationdate`) VALUES
(1, 'PRECUT CHICKEN - 500 GM', 'Serving Weight/Egg: 900/500 gm It comes in ‘food-grade foil bag packaging with 900gm (Approx.) free-range KADAKNATH pre-cut chicken. Cooking Guidelines: Kadaknath chicken has lean meat with very low-fat content. Hence, it is best served in a curry or masa', '2022-03-13 18:36:52'),
(2, '12 EGGS - ECONOMY PACK', 'Serving Weight/Egg: 40-50g (Approx.) It comes in ‘food-grade paper pulp packaging with 12 free-range KADAKNATH eggs. High Protein | Low Fat | Low Cholesterol | Rich Iron Source Higher Levels of - 18 essential Amino Acids & Hormones, Vitamins B1, B2, B6, B', '2022-03-13 18:37:33'),
(5, 'SIKEN', 'diwata', '2024-04-24 16:58:32'),
(6, 'SIKEN ZOY', '.', '2024-05-06 17:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `InvoiceNumber` int(11) DEFAULT NULL,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerContactNo` bigint(12) DEFAULT NULL,
  `PaymentMode` varchar(100) DEFAULT NULL,
  `InvoiceGenDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`id`, `ProductId`, `Quantity`, `InvoiceNumber`, `CustomerName`, `CustomerContactNo`, `PaymentMode`, `InvoiceGenDate`) VALUES
(7, 1, 1, 106702960, 'John ', 91234568791, 'COD', '2023-05-03 10:21:39'),
(8, 1, 1, 841948735, 'nexus ', 9665581572, 'COD', '2024-04-24 16:56:02'),
(9, 4, 1, 841948735, 'nexus ', 9665581572, 'COD', '2024-04-24 16:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `ProductName` varchar(150) DEFAULT NULL,
  `ProductImage` varchar(255) DEFAULT NULL,
  `ProductPrice` decimal(10,0) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `CategoryName`, `ProductName`, `ProductImage`, `ProductPrice`, `PostingDate`, `UpdationDate`) VALUES
(1, 'EGGS', 'WHOLE EGG POWDER (50 gm)', '714Ml7MS8wL._SL1500_.jpg', 499, '2022-03-13 18:29:45', NULL),
(2, 'EGGS', 'READY TO COOK - OMELET POWDER (50 gm)', 'fd.jpg', 299, '2022-03-13 18:34:00', NULL),
(3, 'CHICKEN', 'WHOLE CHICKEN - 900 GM', '71pfC4X8s1L._SX679_.jpg', 699, '2022-03-13 18:34:46', NULL),
(4, 'CHICKEN', 'PRECUT CHICKEN - 500 GM', 'WHOLE-CHICKEN---900-GM.jpg', 677, '2023-05-03 03:18:48', '2023-05-03 03:18:48'),
(7, 'EGGS', 'SIKEN ZOY', 'dove.jpg', 5, '2024-05-06 17:30:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_out`
--
ALTER TABLE `store_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_stock`
--
ALTER TABLE `store_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcompany`
--
ALTER TABLE `tblcompany`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_out`
--
ALTER TABLE `store_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_stock`
--
ALTER TABLE `store_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcompany`
--
ALTER TABLE `tblcompany`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblitems`
--
ALTER TABLE `tblitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Database: `mvogms_db`
--
CREATE DATABASE IF NOT EXISTS `mvogms_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mvogms_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cart_list`
--

CREATE TABLE `cart_list` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_list`
--

INSERT INTO `cart_list` (`id`, `client_id`, `product_id`, `quantity`) VALUES
(36, 5, 11, 1),
(38, 6, 10, 1),
(41, 4, 24, 1),
(42, 7, 34, 1),
(46, 3, 18, 1),
(47, 3, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `vendor_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `vendor_id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(10, 4, 'D and J - Wedding', 'Wedding-Package', 1, 0, '2023-02-25 03:48:44', '2023-04-24 19:01:47'),
(11, 4, 'D and J - Birthday', 'Birthday-Package', 1, 0, '2023-02-25 03:48:54', '2023-04-24 19:01:32'),
(12, 5, ' MSM Weeding', ' MSM Weeding', 1, 0, '2023-03-30 10:32:24', NULL),
(13, 13, 'MSM - Wedding', 'Wedding Package', 1, 0, '2023-04-24 18:58:14', '2023-04-24 18:58:42'),
(14, 13, 'MSM-Birthday', 'Birthday-Package', 1, 0, '2023-04-24 18:59:20', NULL),
(15, 13, 'MSM-Debut', 'Debut-Package', 1, 0, '2023-04-24 18:59:49', NULL),
(16, 13, 'MSM-Anniversary', 'Anniversary-Package', 1, 0, '2023-04-24 19:00:12', NULL),
(17, 4, 'D and J -Debut', 'Debut-Package', 1, 0, '2023-04-24 19:02:18', NULL),
(18, 4, 'D and J -Anniversary', 'Anniversary-Package', 1, 0, '2023-04-24 19:02:51', NULL),
(19, 6, 'Kristinemae ', 'Kristinemae-Wedding', 1, 1, '2023-04-24 20:15:25', '2023-04-24 20:18:21'),
(20, 6, 'Kristinemae -Wedding', 'Wedding Package', 1, 0, '2023-04-24 20:18:12', NULL),
(21, 6, 'Kristinemae -Debut', 'Debut-Package', 1, 0, '2023-04-24 20:19:03', NULL),
(22, 6, 'Kristinemae -Birthday', 'Birthday-Package', 1, 0, '2023-04-24 20:19:45', NULL),
(23, 6, 'Kristinemae -Anniversary', 'Anniversary-Package', 1, 0, '2023-04-24 20:24:10', NULL),
(24, 14, 'Johnmarie -Anniversary', 'Anniversary-Package', 1, 0, '2023-04-24 20:49:41', NULL),
(25, 14, 'Johnmarie -Birthday', 'Birthday-Package', 1, 0, '2023-04-24 20:50:08', NULL),
(26, 14, 'Johnmarie -Debut', 'Debut-Package', 1, 0, '2023-04-24 20:50:31', NULL),
(27, 14, 'Johnmarie -Wedding', 'Wedding-Package', 1, 0, '2023-04-24 20:51:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `code`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `address`, `email`, `password`, `avatar`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(3, '202302-00001', 'Alex', '', 'Tibay', 'Male', '09090909099', 'San Agustine, Madridejos, Cebu', 'alextibay.24.axebay@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'uploads/clients/3.png?v=1677268241', 1, 0, '2023-02-25 03:50:41', '2023-05-08 16:38:58'),
(4, '202303-00001', 'try', 'try', 'try', 'Male', '09090909099', 'asdasd', 'try@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/clients/4.png?v=1679816316', 1, 0, '2023-03-26 15:38:36', '2023-03-26 15:38:36'),
(5, '202304-00001', 'ASDAS', 'ASDAS', 'ASDAS', 'Male', '090909090999', 'ASDASDAD', 'user@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/clients/5.png?v=1681352456', 1, 1, '2023-04-13 10:20:56', '2023-04-24 17:25:59'),
(6, '202304-00002', 'Joseph', 'T.', 'Despi', 'Male', '09090909099', 'Maalat, Madridejos, Cebu', 'alextibay.24.axebay@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'uploads/clients/6.png?v=1682327752', 1, 1, '2023-04-24 17:15:52', '2023-05-08 16:38:25'),
(7, '202304-00003', 'rina', 'sevilleno', 'nepangue', 'Female', '09262253489', 'bantayan', 'rina@gmail.com', '4ebe7e6097e22e7421b6551944540780', 'uploads/clients/7.png?v=1682411165', 1, 0, '2023-04-25 01:26:05', '2023-04-25 01:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`, `date_created`) VALUES
(129, 10, 1, 700000, '2023-04-11 20:13:25'),
(130, 11, 1, 10000, '2023-04-11 20:13:42'),
(131, 11, 1, 10000, '2023-04-13 10:44:27'),
(132, 11, 1, 10000, '2023-04-24 16:52:42'),
(133, 11, 1, 10000, '2023-04-24 16:54:59'),
(135, 11, 1, 10000, '2023-04-24 17:02:04'),
(136, 11, 1, 10000, '2023-04-24 17:02:38'),
(137, 10, 1, 700000, '2023-04-24 17:17:56'),
(138, 10, 1, 700000, '2023-04-24 17:19:03'),
(139, 10, 1, 700000, '2023-04-24 17:22:53'),
(140, 19, 1, 145000, '2023-04-25 01:01:26'),
(141, 24, 1, 85000, '2023-04-25 01:06:42'),
(142, 34, 1, 65000, '2023-04-25 01:28:01'),
(143, 34, 1, 65000, '2023-04-25 03:15:04'),
(144, 34, 1, 65000, '2023-04-25 03:25:28'),
(145, 35, 1, 155000, '2023-05-09 00:09:52'),
(146, 14, 1, 55000, '2023-05-09 00:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `vendor_id` int(30) NOT NULL,
  `total_amount` double NOT NULL DEFAULT 0,
  `delivery_address` text NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `code`, `client_id`, `vendor_id`, `total_amount`, `delivery_address`, `name`, `contact`, `email`, `schedule`, `status`, `date_created`, `date_updated`, `proof`) VALUES
(129, '202304-00001', 4, 4, 700000, 'asdasd', 'asdas', '09090909099', 'asdas@asdas', '2023/04/13 22:00', 3, '2023-04-11 20:13:25', '2023-04-24 16:31:34', 'uploads/proof/proofclass-schedule (2).png'),
(130, '202304-00002', 4, 5, 10000, 'asdasd', 'asdas', '09090909099', 'asdad@asdasd', '2023/04/13 21:00', 1, '2023-04-11 20:13:42', '2023-04-11 20:27:01', NULL),
(131, '202304-00003', 5, 5, 10000, 'ASDASDAD', 'ASDASD', '2323232322', 'ASDASD@SDAD', '2023/04/15 13:00', 2, '2023-04-13 10:44:27', '2023-04-13 11:10:21', NULL),
(132, '202304-00004', 4, 5, 10000, 'asdasd', 'asd', '09090909099', 'adasd@asdas', '2023/04/26 17:00', 5, '2023-04-24 16:52:42', '2023-04-25 01:05:03', NULL),
(133, '202304-00005', 4, 5, 10000, 'asdasd', 'asdsad', '09090909099', 'asdas@asdasd', '2023/04/26 20:00', 0, '2023-04-24 16:54:59', '2023-04-24 16:54:59', NULL),
(135, '202304-00006', 4, 5, 10000, 'asdasd', 'asdas', '09090909009', 'asdas@asd', '2023/04/26 21:00', 0, '2023-04-24 17:02:04', '2023-04-24 17:02:04', NULL),
(136, '202304-00007', 4, 5, 10000, 'asdasd', 'ads', '09090909099', 'meds@asdas', '2023/04/28 17:00', 5, '2023-04-24 17:02:38', '2023-04-25 01:04:24', NULL),
(137, '202304-00008', 6, 4, 700000, 'Maalat, Madridejos, Cebu', 'Joseph Despi', '09090909099', 'joseph@gmail.com', '2023/04/29 20:00', 5, '2023-04-24 17:17:56', '2023-04-24 17:18:38', NULL),
(138, '202304-00009', 6, 4, 700000, 'Maalat, Madridejos, Cebu', 'asdsad', '09090909099', 'asd@adasd', '2023/04/27 20:00', 7, '2023-04-24 17:19:03', '2023-04-24 17:20:34', NULL),
(139, '202304-00010', 6, 4, 700000, 'Maalat, Madridejos, Cebu', 'assad', '09090909099', 'sdas@sadas', '2023/04/26 22:00', 4, '2023-04-24 17:22:53', '2023-04-24 17:24:53', 'uploads/proof/proofA.png'),
(140, '202304-00011', 4, 4, 145000, 'anika beach resort', 'rina nepangue', '09261156789', 'rina@gmail.com', '2023/04/27 02:00', 2, '2023-04-25 01:01:26', '2023-04-25 01:02:28', NULL),
(141, '202304-00012', 4, 13, 85000, 'anika', 'rina ', '09234567891', 'rinanepangue81@gmail.com', '2023/04/28 02:00', 6, '2023-04-25 01:06:42', '2023-04-25 01:12:37', 'uploads/proof/proofpayment.jpg'),
(142, '202304-00013', 7, 14, 65000, 'anika', 'rina', '09233222212', 'rina@gmail.com', '2023/04/27 03:00', 3, '2023-04-25 01:28:01', '2023-04-25 01:33:03', 'uploads/proof/proofpayment.jpg'),
(143, '202304-00014', 7, 14, 65000, 'anika', 'rina nepangue', '09565757867', 'rina@gmail.com', '2023/04/27 04:00', 6, '2023-04-25 03:15:04', '2023-04-25 03:18:33', 'uploads/proof/proofpayment.jpg'),
(144, '202304-00015', 7, 14, 65000, 'bantayan', 'alex', '09465004434', 'alextibay.24axebay@gmail.com', '2023/04/28 05:00', 0, '2023-04-25 03:25:28', '2023-04-25 03:25:28', NULL),
(145, '202305-00001', 3, 14, 155000, 'San Agustine, Madridejos, Cebu', 'ascad', '09090909999', 'asdasd@asda', '2023/05/11 03:00', 0, '2023-05-09 00:09:52', '2023-05-09 00:09:52', NULL),
(146, '202305-00002', 3, 4, 55000, 'San Agustine, Madridejos, Cebu', 'sas@asdas', '09090909999', 'asda@ads', '2023/05/26 03:00', 3, '2023-05-09 00:11:57', '2023-05-09 00:12:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `vendor_id` int(30) DEFAULT NULL,
  `category_id` int(30) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `vendor_id`, `category_id`, `name`, `description`, `price`, `image_path`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(9, 4, 10, 'Package 1', '&lt;p&gt;HAHAHAHAHasdasd&lt;/p&gt;', 100000, 'uploads/products/9.png?v=1677268158', 1, 1, '2023-02-25 03:49:18', '2023-04-24 17:34:03'),
(10, 4, 10, 'Package 2', '&lt;p&gt;asdads&lt;/p&gt;&lt;p&gt;sdasd&lt;/p&gt;&lt;p&gt;adasds&lt;/p&gt;&lt;p&gt;asdasd&lt;/p&gt;&lt;p&gt;dsad&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asda&lt;/p&gt;&lt;p&gt;sds&lt;/p&gt;&lt;p&gt;dadasdasdjadhgaudhuiasdhahdiahdioahdiaduyagdasd&lt;/p&gt;', 700000, 'uploads/products/10.png?v=1677269499', 1, 1, '2023-02-25 04:11:38', '2023-04-24 17:34:11'),
(11, 5, 12, 'MSM Weeding', '&lt;p&gt;asdd&lt;/p&gt;', 10000, 'uploads/products/11.png?v=1680143627', 1, 0, '2023-03-30 10:33:34', '2023-03-30 10:33:47'),
(12, 4, 10, 'Package A-Wedding', '&lt;p&gt;&lt;span style=&quot;white-space: pre; font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;FOOD AND VENUE SET-UP&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 150 persons only&lt;/p&gt;&lt;p&gt;-8 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-dressed banquet tables with cloth table napkins&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-tiffany chairs set-up for the presidential table&lt;/p&gt;&lt;p&gt;-color motif decoration&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-75 pieces of invitation&lt;/p&gt;&lt;p&gt;-75 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-bride robe&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-8 bridesmaids&lt;/p&gt;&lt;p&gt;-8 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;-elegant bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-20 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-2 days prenuptias&lt;/p&gt;&lt;p&gt;-2 hours use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 185000, 'uploads/products/12.png?v=1682383146', 1, 0, '2023-04-24 17:39:05', '2023-04-24 19:58:34'),
(13, 4, 10, 'Package B-Wedding', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-3 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;- basic complete table setting&lt;/p&gt;&lt;p&gt;-basic color motif decoration&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-40 pieces of invitation&lt;/p&gt;&lt;p&gt;-40 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 day prenuptias&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;W/ WEDDING HOST&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 87000, 'uploads/products/13.png?v=1682383293', 1, 0, '2023-04-24 17:41:32', '2023-04-24 20:00:23'),
(14, 4, 11, 'Package A-Birthday', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 100 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Backdrop structure design&lt;/p&gt;&lt;p&gt;-banner 9ft x 6ft with mini parcan light&lt;/p&gt;&lt;p&gt;-arc/pillar design balloon entrance&lt;/p&gt;&lt;p&gt;-50 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-50 pieces helium balloons&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;POTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 55000, 'uploads/products/14.png?v=1682383475', 1, 0, '2023-04-24 17:44:33', '2023-04-24 19:57:55'),
(15, 4, 11, 'Package B-Birthday', '&lt;p&gt;PACKAGE A&lt;span style=&quot;white-space:pre&quot;&gt;					&lt;/span&gt;&lt;/p&gt;&lt;p&gt;P35, 000.00&lt;span style=&quot;white-space:pre&quot;&gt;	&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 100 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Backdrop structure design&lt;/p&gt;&lt;p&gt;-banner 9ft x 6ft with mini parcan light&lt;/p&gt;&lt;p&gt;-arc/pillar design balloon entrance&lt;/p&gt;&lt;p&gt;-50 pieces non- flying balloons&nbsp;&lt;/p&gt;&lt;p&gt;-50 pieces helium balloons&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 55000, 'uploads/products/15.png?v=1682383718', 1, 1, '2023-04-24 17:48:36', '2023-04-24 18:12:39'),
(16, 4, 11, 'Package B-Birthday', '&lt;p&gt;PACKAGE B&lt;span style=&quot;white-space:pre&quot;&gt;					&lt;/span&gt;&lt;/p&gt;&lt;p&gt;P38, 000.00&lt;span style=&quot;white-space:pre&quot;&gt;	&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:pre&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 50 persons only&lt;/span&gt;&lt;/p&gt;&lt;p&gt;- 3 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Tarpaulin backdrop design&lt;/p&gt;&lt;p&gt;-banner 8ft x 4ft&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces helium balloons&lt;/p&gt;&lt;p&gt;-20 pieces invitation card&lt;/p&gt;&lt;p&gt;-30 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 38000, 'uploads/products/16.png?v=1682385368', 1, 0, '2023-04-24 18:16:06', '2023-04-24 19:11:35'),
(17, 4, 17, 'Package A-Debut', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Venue amenities&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 120 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-thematic backdrop design&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-75 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 2 locations&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 75000, 'uploads/products/17.png?v=1682385500', 1, 0, '2023-04-24 18:18:18', '2023-04-24 19:58:16'),
(18, 4, 17, 'Package B-Debut', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Venue amenities&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;/p&gt;&lt;p&gt;- 4 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic thematic backdrop design&lt;/p&gt;&lt;p&gt;-basic complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-40 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 1 location&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-1 hour photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:pre&quot;&gt;																		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 50000, 'uploads/products/18.png?v=1682385921', 1, 0, '2023-04-24 18:25:20', '2023-04-24 20:00:01'),
(19, 4, 18, 'Package A-Anniversary', '&lt;p&gt;&lt;span style=&quot;white-space: pre; font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;FOOD AND VENUE SET-UP&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;			&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;-6 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-50 pieces of invitation&lt;/p&gt;&lt;p&gt;-50 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-6 bridesmaids&lt;/p&gt;&lt;p&gt;-6 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-15 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 145000, 'uploads/products/19.png?v=1682386267', 1, 0, '2023-04-24 18:31:05', '2023-04-24 19:54:34'),
(20, 4, 18, 'Package B-Anniversary ', '&lt;p&gt;&lt;span style=&quot;white-space: pre; font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;FOOD AND VENUE SET-UP&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;			&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-4 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;/p&gt;&lt;p&gt;-5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-30 pieces of invitation&lt;/p&gt;&lt;p&gt;-30 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4 bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 75000, 'uploads/products/20.png?v=1682386431', 1, 0, '2023-04-24 18:33:50', '2023-04-24 19:55:02'),
(21, 13, 13, 'Package A-Wedding', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 150 persons only&lt;/p&gt;&lt;p&gt;-8 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-dressed banquet tables with cloth table napkins&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-tiffany chairs set-up for the presidential table&lt;/p&gt;&lt;p&gt;-color motif decoration&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-75 pieces of invitation&lt;/p&gt;&lt;p&gt;-75 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-bride robe&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-8 bridesmaids&lt;/p&gt;&lt;p&gt;-8 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;-elegant bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-20 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-2 days prenuptias&lt;/p&gt;&lt;p&gt;-2 hours use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 215000, 'uploads/products/21.png?v=1682389019', 1, 0, '2023-04-24 19:16:52', '2023-04-24 20:02:32'),
(22, 13, 13, 'Package B-Wedding', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-3 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;- basic complete table setting&lt;/p&gt;&lt;p&gt;-basic color motif decoration&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-40 pieces of invitation&lt;/p&gt;&lt;p&gt;-40 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 day prenuptias&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;W/ WEDDING HOST&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 87000, 'uploads/products/22.png?v=1682389204', 1, 0, '2023-04-24 19:20:02', '2023-04-24 20:04:01'),
(23, 13, 16, 'Package A-Anniversary', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 100 persons only&lt;/span&gt;&lt;span style=&quot;white-space:pre&quot;&gt;		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-6 main dishes+ inclusive 1 round of soft drinks&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-50 pieces of invitation&lt;/p&gt;&lt;p&gt;-50 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-6 bridesmaids&lt;/p&gt;&lt;p&gt;-6 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-15 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 165000, 'uploads/products/23.png?v=1682390040', 1, 0, '2023-04-24 19:33:52', '2023-04-24 20:01:51'),
(24, 13, 16, 'Package B-Anniversary', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;FOOD AND VENUE SET-UP&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;			&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-4 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;/p&gt;&lt;p&gt;-5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-30 pieces of invitation&lt;/p&gt;&lt;p&gt;-30 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4 bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 85000, 'uploads/products/24.png?v=1682390281', 1, 0, '2023-04-24 19:38:00', '2023-04-24 20:02:52'),
(25, 13, 14, 'Package  A-Birthday', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 100 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Backdrop structure design&lt;/p&gt;&lt;p&gt;-banner 9ft x 6ft with mini parcan light&lt;/p&gt;&lt;p&gt;-arc/pillar design balloon entrance&lt;/p&gt;&lt;p&gt;-50 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-50 pieces helium balloons&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 75000, 'uploads/products/25.png?v=1682390473', 1, 0, '2023-04-24 19:41:12', '2023-04-24 20:01:32'),
(26, 13, 14, 'Package B-Birthday', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 80 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 3 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Tarpaulin backdrop design&lt;/p&gt;&lt;p&gt;-banner 8ft x 4ft&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces helium balloons&lt;/p&gt;&lt;p&gt;-20 pieces invitation card&lt;/p&gt;&lt;p&gt;-30 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 45000, 'uploads/products/26.png?v=1682390609', 1, 0, '2023-04-24 19:43:27', '2023-04-24 20:03:15'),
(27, 13, 15, 'Package A-Debut', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;	&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Good for 120 persons only&lt;span style=&quot;white-space:pre&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-Venue Amenities&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-thematic backdrop design&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-75 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 2 locations&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 95000, 'uploads/products/27.png?v=1682390827', 1, 0, '2023-04-24 19:47:06', '2023-04-24 20:02:11'),
(28, 13, 15, 'Package B-Debut', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 80 persons only&lt;/span&gt;&lt;span style=&quot;white-space:pre&quot;&gt;		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-venue amenities&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;- 4 main dishes+ inclusive 1 round of soft drinks&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic thematic backdrop design&lt;/p&gt;&lt;p&gt;-basic complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-40 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;POTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 1 location&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-1 hour photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:pre&quot;&gt;																		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 75000, 'uploads/products/28.png?v=1682391059', 1, 0, '2023-04-24 19:50:58', '2023-04-24 20:03:38'),
(29, 14, 27, 'Package A-Wedding', '&lt;p&gt;INCLUSIONS&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 150 persons only&lt;/p&gt;&lt;p&gt;-8 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-dressed banquet tables with cloth table napkins&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-tiffany chairs set-up for the presidential table&lt;/p&gt;&lt;p&gt;-color motif decoration&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-75 pieces of invitation&lt;/p&gt;&lt;p&gt;-75 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-bride robe&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-8 bridesmaids&lt;/p&gt;&lt;p&gt;-8 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;-elegant bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-20 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-2 days prenuptias&lt;/p&gt;&lt;p&gt;-2 hours use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 190000, 'uploads/products/29.png?v=1682394845', 1, 0, '2023-04-24 20:54:03', '2023-04-24 20:54:05'),
(30, 14, 27, 'Package B - Wedding', '&lt;p&gt;INCLUSIONS&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-3 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;- basic complete table setting&lt;/p&gt;&lt;p&gt;-basic color motif decoration&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-40 pieces of invitation&lt;/p&gt;&lt;p&gt;-40 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 day prenuptias&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;W/ WEDDING HOST&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 90000, 'uploads/products/30.png?v=1682395226', 1, 0, '2023-04-24 21:00:24', '2023-04-24 21:00:26'),
(31, 14, 25, 'Package A - Birthday', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:pre&quot;&gt;		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Backdrop structure design&lt;/p&gt;&lt;p&gt;-banner 9ft x 6ft with mini parcan light&lt;/p&gt;&lt;p&gt;-arc/pillar design balloon entrance&lt;/p&gt;&lt;p&gt;-50 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-50 pieces helium balloons&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 65000, 'uploads/products/31.png?v=1682395635', 1, 0, '2023-04-24 21:07:14', '2023-04-24 21:07:15'),
(32, 14, 25, 'Package B-Birthday', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 50 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 3 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Tarpaulin backdrop design&lt;/p&gt;&lt;p&gt;-banner 8ft x 4ft&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces helium balloons&lt;/p&gt;&lt;p&gt;-20 pieces invitation card&lt;/p&gt;&lt;p&gt;-30 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 40000, 'uploads/products/32.png?v=1682395803', 1, 0, '2023-04-24 21:09:58', '2023-04-24 21:10:03'),
(33, 14, 26, 'Package A - Debut', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;	&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 120 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Avenue amenities&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-thematic backdrop design&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp; candles&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-75 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 2 locations&lt;/p&gt;&lt;p&gt;-photo &amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 85000, 'uploads/products/33.png?v=1682396612', 1, 1, '2023-04-24 21:14:08', '2023-04-24 21:24:05'),
(34, 14, 26, 'Package B- Debut', '&lt;p&gt;INCLUSIONS:&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Venue amenities&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;/p&gt;&lt;p&gt;- 4 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic thematic backdrop design&lt;/p&gt;&lt;p&gt;-basic complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-40 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 1 location&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-1 hour photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:pre&quot;&gt;																		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 65000, 'uploads/products/34.png?v=1682396472', 1, 0, '2023-04-24 21:21:11', '2023-04-24 21:21:12'),
(35, 14, 24, 'Packgae A - Anniversary', '&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;-6 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-50 pieces of invitation&lt;/p&gt;&lt;p&gt;-50 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-6 bridesmaids&lt;/p&gt;&lt;p&gt;-6 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-15 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp; video&nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 155000, 'uploads/products/35.png?v=1682396745', 1, 0, '2023-04-24 21:22:53', '2023-04-24 21:25:45'),
(36, 14, 26, 'Package B - Debut', '&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;INCLUSIONS:&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;	&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 120 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Avenue amenities&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-thematic backdrop design&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-75 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 2 locations&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 85000, 'uploads/products/36.png?v=1682396702', 1, 0, '2023-04-24 21:24:57', '2023-04-24 21:25:02'),
(37, 14, 24, 'Package - Anniversary', '&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-4 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;/p&gt;&lt;p&gt;-5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-30 pieces of invitation&lt;/p&gt;&lt;p&gt;-30 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4 bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 95000, 'uploads/products/37.png?v=1682396882', 1, 0, '2023-04-24 21:27:59', '2023-04-24 21:28:02'),
(38, 6, 20, 'Package A- Wedding', '&lt;p&gt;INCLUSION&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;FOOD AND VENUE SET-UP&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; white-space: pre;&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 150 persons only&lt;/p&gt;&lt;p&gt;-8 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-dressed banquet tables with cloth table napkins&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-tiffany chairs set-up for the presidential table&lt;/p&gt;&lt;p&gt;-color motif decoration&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-75 pieces of invitation&lt;/p&gt;&lt;p&gt;-75 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-bride robe&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-8 bridesmaids&lt;/p&gt;&lt;p&gt;-8 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;-elegant bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-20 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-2 days prenuptias&lt;/p&gt;&lt;p&gt;-2 hours use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 190000, 'uploads/products/38.png?v=1682397127', 1, 0, '2023-04-24 21:32:06', '2023-04-24 21:32:07');
INSERT INTO `product_list` (`id`, `vendor_id`, `category_id`, `name`, `description`, `price`, `image_path`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(39, 6, 20, 'Package  B- Wedding', '&lt;p&gt;INCLUSION&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-3 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;- basic complete table setting&lt;/p&gt;&lt;p&gt;-basic color motif decoration&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-fresh flowers for the presidential &amp;amp; guest tables&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-40 pieces of invitation&lt;/p&gt;&lt;p&gt;-40 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;-groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 day prenuptias&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;W/ WEDDING HOST&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 90000, 'uploads/products/39.png?v=1682397287', 1, 0, '2023-04-24 21:34:42', '2023-04-24 21:34:47'),
(40, 6, 22, 'Package  A- Birthday', '&lt;p&gt;INCLUSIONS:&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 100 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Backdrop structure design&lt;/p&gt;&lt;p&gt;-banner 9ft x 6ft with mini parcan light&lt;/p&gt;&lt;p&gt;-arc/pillar design balloon entrance&lt;/p&gt;&lt;p&gt;-50 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-50 pieces helium balloons&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 75000, 'uploads/products/40.png?v=1682397397', 1, 0, '2023-04-24 21:36:36', '2023-04-24 21:36:37'),
(41, 6, 22, 'Package B- Birthday', '&lt;p&gt;INCLUSIONS:&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Good for 85 persons only&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;- 3 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-Tarpaulin backdrop design&lt;/p&gt;&lt;p&gt;-banner 8ft x 4ft&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces non- flying balloons&amp;nbsp;&lt;/p&gt;&lt;p&gt;-30 pieces helium balloons&lt;/p&gt;&lt;p&gt;-20 pieces invitation card&lt;/p&gt;&lt;p&gt;-30 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Unlimited shots&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;w/ host program party&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 45000, 'uploads/products/41.png?v=1682397577', 1, 0, '2023-04-24 21:39:36', '2023-04-24 21:39:37'),
(42, 6, 21, 'Package A - Debut', '&lt;p&gt;INCLUSIONS:&lt;span style=&quot;white-space:pre&quot;&gt;	&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-venue amenities&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 120 persons only&lt;/p&gt;&lt;p&gt;- 5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-2 main desserts&lt;/p&gt;&lt;p&gt;-thematic backdrop design&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-50 pieces invitation card&lt;/p&gt;&lt;p&gt;-75 pieces giveaways&lt;/p&gt;&lt;p&gt;-3 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 2 locations&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-2 hours photo booth&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 90, 'uploads/products/42.png?v=1682397688', 1, 0, '2023-04-24 21:41:27', '2023-04-24 21:41:28'),
(43, 6, 21, 'Package B - Debut', '&lt;p&gt;INCLUSIONS:&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;-Venue amenities&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Tables and chairs included&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;- 4 main dishes+ inclusive 1 round of soft drinks&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic thematic backdrop design&lt;/p&gt;&lt;p&gt;-basic complete table setting&lt;/p&gt;&lt;p&gt;-presidential &amp;amp; guest table&lt;/p&gt;&lt;p&gt;-18 roses &amp;amp; candles&lt;/p&gt;&lt;p&gt;-40 pieces invitation card&lt;/p&gt;&lt;p&gt;-50 pieces giveaways&lt;/p&gt;&lt;p&gt;-2 layered fondant cake&lt;/p&gt;&lt;p&gt;-basic lights and sounds&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-Pre-debut photo-shoots 1 location&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-1 hour photo booth&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;white-space:pre&quot;&gt;																		&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 65000, 'uploads/products/43.png?v=1682397851', 1, 0, '2023-04-24 21:44:10', '2023-04-24 21:44:11'),
(44, 6, 23, 'Package A- Anniversary', '&lt;p&gt;INCLUSIONS&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-6 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 100 persons only&lt;/p&gt;&lt;p&gt;-6 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-3 main desserts&lt;/p&gt;&lt;p&gt;-specialized buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-specialized church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-5 layered wedding cake&lt;/p&gt;&lt;p&gt;-50 pieces of invitation&lt;/p&gt;&lt;p&gt;-50 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-6 bridesmaids&lt;/p&gt;&lt;p&gt;-6 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-15 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video&amp;nbsp; coverage&lt;/p&gt;&lt;p&gt;-1 hour use of photobooth with props&lt;/p&gt;&lt;p&gt;W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-ideal program arrangement&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 165000, 'uploads/products/44.png?v=1682398134', 1, 0, '2023-04-24 21:48:53', '2023-04-24 21:48:54'),
(45, 6, 23, 'Package B - Anniversary', '&lt;p&gt;INCLUSIONS&lt;/p&gt;&lt;p&gt;FOOD AND VENUE SET-UP&lt;span style=&quot;white-space:pre&quot;&gt;			&lt;/span&gt;&lt;/p&gt;&lt;p&gt;-4 hours use of venue&lt;/p&gt;&lt;p&gt;-tables and chairs included&lt;/p&gt;&lt;p&gt;-Good for 80 persons only&lt;/p&gt;&lt;p&gt;-5 main dishes+ inclusive 1 round of soft drinks&lt;/p&gt;&lt;p&gt;-1 main dessert&lt;/p&gt;&lt;p&gt;-basic buffet arrangement for lunch or dinner&lt;/p&gt;&lt;p&gt;-complete table setting&lt;/p&gt;&lt;p&gt;-basic church decoration with flowers and red carpet&lt;/p&gt;&lt;p&gt;-bottle of wine for wedding toast&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;WEDDING CAKE, INVITATION &amp;amp; GIVEAWAYS&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-3 layered wedding cake&lt;/p&gt;&lt;p&gt;-30 pieces of invitation&lt;/p&gt;&lt;p&gt;-30 pieces of giveaways&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;ENTOURAGE WEDDING GOWNS AND BOUQUET&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;-bride wedding gown&lt;/p&gt;&lt;p&gt;- -groom suit&lt;/p&gt;&lt;p&gt;-maid of honor gown&lt;/p&gt;&lt;p&gt;-best man suit&lt;/p&gt;&lt;p&gt;-4 bridesmaids&lt;/p&gt;&lt;p&gt;-4 groom&rsquo;s men&lt;/p&gt;&lt;p&gt;-3 flowers girls&lt;/p&gt;&lt;p&gt;-3 bearers&lt;/p&gt;&lt;p&gt;-2 mother&rsquo;s gowns&lt;/p&gt;&lt;p&gt;-2 father&rsquo;s suit&lt;/p&gt;&lt;p&gt;- bouquet for the bride&lt;/p&gt;&lt;p&gt;-maid of honor bouquet&lt;/p&gt;&lt;p&gt;-bridesmaid bouquet&lt;/p&gt;&lt;p&gt;-3 flower basket&lt;/p&gt;&lt;p&gt;-10 pieces corsage&lt;/p&gt;&lt;p&gt;PHOTO &amp;amp; VIDEO COVERAGE&lt;/p&gt;&lt;p&gt;-photo &amp;amp; video coverage&lt;/p&gt;&lt;p&gt;-W/ WEDDING HOST&lt;/p&gt;&lt;p&gt;-basic program arrangement&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 85000, 'uploads/products/45.png?v=1682398442', 1, 0, '2023-04-24 21:54:01', '2023-04-24 21:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `shop_type_list`
--

CREATE TABLE `shop_type_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop_type_list`
--

INSERT INTO `shop_type_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Weekend', 1, 0, '2022-02-09 08:49:34', '2023-02-25 03:44:56'),
(2, 'Weekdays', 1, 0, '2022-02-09 08:49:46', '2023-02-25 03:44:47'),
(3, 'Produce', 1, 1, '2022-02-09 08:50:31', '2023-02-25 03:45:20'),
(4, 'Fulltime', 1, 0, '2022-02-09 08:50:36', '2023-02-25 03:44:36'),
(5, 'Others', 1, 1, '2022-02-09 08:50:41', '2022-02-09 08:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Event Booking Management System'),
(6, 'short_name', 'EBMS - MCC'),
(11, 'logo', 'uploads/logo-1682382320.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1677263910.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'alextibay.24.axebay@gmail.com', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1644472635', NULL, 1, '2021-01-20 14:02:37', '2023-05-08 16:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_list`
--

CREATE TABLE `vendor_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `shop_type_id` int(30) NOT NULL,
  `shop_name` text NOT NULL,
  `shop_owner` text NOT NULL,
  `contact` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 2,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `gcash` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_list`
--

INSERT INTO `vendor_list` (`id`, `code`, `shop_type_id`, `shop_name`, `shop_owner`, `contact`, `username`, `password`, `avatar`, `status`, `delete_flag`, `date_created`, `date_updated`, `gcash`) VALUES
(4, '202302-00001', 4, 'D and J ', 'D and J Catering Services', '1111111111', 'alextibay.24.axebay@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'uploads/vendors/4.png?v=1680437769', 1, 0, '2023-02-25 03:47:17', '2023-05-08 16:38:15', 'uploads/gcash/4.png?v=1682403123'),
(5, '202303-00001', 4, 'msm', 'msm', '09090909099', 'msm', '6abc4fb79023c7f31153f8504dc39f65', 'uploads/vendors/5.png?v=1680143408', 1, 1, '2023-03-30 10:30:07', '2023-04-24 17:26:06', 'uploads/vendors/5.png?v=1680143408'),
(6, '202304-00001', 4, 'Kristine Mae', 'Kristine Mae', '09090909099', 'kristinemae', '3a4b09354548cfbc3cd61dc6a1981114', 'uploads/vendors/6.png?v=1680437935', 1, 0, '2023-04-02 20:18:55', '2023-04-24 22:01:58', 'uploads/gcash/6.png?v=1680437984'),
(8, '202304-00002', 4, 'sadsa', 'asdas', '09090909099', '1234', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/vendors/8.png?v=1682327081', 1, 1, '2023-04-24 17:04:41', '2023-04-24 17:12:52', '0'),
(9, '202304-00003', 4, 'MSM Catering', 'MSM', '09234567891', 'msm', '6abc4fb79023c7f31153f8504dc39f65', 'uploads/vendors/9.png?v=1682387112', 2, 1, '2023-04-24 18:45:12', '2023-04-24 18:48:42', '0'),
(10, '202304-00004', 4, 'MSM Catering', 'MSM', '09234567891', 'msm123', '6abc4fb79023c7f31153f8504dc39f65', 'uploads/vendors/10.png?v=1682387158', 2, 1, '2023-04-24 18:45:57', '2023-04-24 18:48:12', '0'),
(11, '202304-00005', 4, 'MSM Catering', 'MSM', '09234567891', 'msm1', '6abc4fb79023c7f31153f8504dc39f65', 'uploads/vendors/11.png?v=1682387197', 2, 1, '2023-04-24 18:46:36', '2023-04-24 18:48:34', '0'),
(12, '202304-00006', 4, 'MSM Catering', 'MSM', '09234567891', 'msm@gmail.com', '6abc4fb79023c7f31153f8504dc39f65', 'uploads/vendors/12.png?v=1682387232', 2, 1, '2023-04-24 18:47:12', '2023-04-24 18:48:23', '0'),
(13, '202304-00007', 4, 'msm catering', 'Mae Ann', '09267890324', 'mae', '6abc4fb79023c7f31153f8504dc39f65', 'uploads/vendors/13.png?v=1682387488', 1, 0, '2023-04-24 18:51:27', '2023-04-25 00:34:43', 'uploads/gcash/13.png?v=1682408083'),
(14, '202304-00008', 4, 'Johnmarie Catering', 'Johnmarie', '09234567891', 'johnmarie', 'e46a4e3203802624345aa1f18672873b', 'uploads/vendors/14.png?v=1682393952', 1, 0, '2023-04-24 20:39:12', '2023-04-24 23:25:41', 'uploads/gcash/14.png?v=1682403941'),
(15, '202304-00009', 4, 'msm', 'rina', '09666666666', 'rina', 'd52dd8068f21d7424345ea25e369a8ae', 'uploads/vendors/15.png?v=1682417378', 1, 0, '2023-04-25 03:09:38', '2023-04-25 03:10:25', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_list`
--
ALTER TABLE `cart_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `category_id` (`category_id`) USING BTREE;

--
-- Indexes for table `shop_type_list`
--
ALTER TABLE `shop_type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_list`
--
ALTER TABLE `vendor_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_type_id` (`shop_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `shop_type_list`
--
ALTER TABLE `shop_type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendor_list`
--
ALTER TABLE `vendor_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_list`
--
ALTER TABLE `cart_list`
  ADD CONSTRAINT `cart_list_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_list`
--
ALTER TABLE `category_list`
  ADD CONSTRAINT `category_list_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_list_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `product_list_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_list` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_list_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_list`
--
ALTER TABLE `vendor_list`
  ADD CONSTRAINT `vendor_list_ibfk_1` FOREIGN KEY (`shop_type_id`) REFERENCES `shop_type_list` (`id`) ON DELETE CASCADE;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

--
-- Dumping data for table `pma__export_templates`
--

INSERT INTO `pma__export_templates` (`id`, `username`, `export_type`, `template_name`, `template_data`) VALUES
(1, 'root', 'server', 'farm', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"db_select[]\":[\"farm\",\"mvogms_db\",\"phpmyadmin\",\"sbtbsphp\",\"ship_ticketing_db\",\"test\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@SERVER@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"yaml_structure_or_data\":\"data\",\"\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_drop_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_procedure_function\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}'),
(2, 'root', 'server', 'reservation', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"db_select[]\":[\"farm\",\"farm1\",\"mvogms_db\",\"phpmyadmin\",\"resevation\",\"sbtbsphp\",\"ship_ticketing_db\",\"test\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@SERVER@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"yaml_structure_or_data\":\"data\",\"\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_drop_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_procedure_function\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"resevation\",\"table\":\"pumpboats\"},{\"db\":\"resevation\",\"table\":\"cottage\\/hall\"},{\"db\":\"resevation\",\"table\":\"reservation\"},{\"db\":\"resevation\",\"table\":\"feature\"},{\"db\":\"farm\",\"table\":\"tbladmin\"},{\"db\":\"resevation\",\"table\":\"user\"},{\"db\":\"resevation\",\"table\":\"user_type\"},{\"db\":\"resevation\",\"table\":\"payment\"},{\"db\":\"resevation\",\"table\":\"picture\"},{\"db\":\"farm\",\"table\":\"tblproducts\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'farm', 'store_stock', '[]', '2024-04-24 15:46:06'),
('root', 'farm', 'tblproducts', '{\"sorted_col\":\"`ProductName` ASC\"}', '2024-05-06 17:15:22'),
('root', 'resevation', 'payment', '{\"sorted_col\":\"`payment`.`ammount_payment` ASC\"}', '2024-06-14 10:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-07-02 02:53:34', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `resevation`
--
CREATE DATABASE IF NOT EXISTS `resevation` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `resevation`;

-- --------------------------------------------------------

--
-- Table structure for table `cottage/hall`
--

CREATE TABLE `cottage/hall` (
  `id` int(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `actual_no` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `max_person` int(250) NOT NULL,
  `price` int(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cottage/hall`
--

INSERT INTO `cottage/hall` (`id`, `img`, `actual_no`, `name`, `type`, `category`, `max_person`, `price`) VALUES
(2, 'uploads/small-cottage-18.jpg', '01', 'this is cottage name', 'Cottage', '1st Class', 12, 300),
(3, 'uploads/grammarly.png', '357', 'Baruto', 'Hall', '3rd Class', 5, 100);

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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(250) NOT NULL,
  `cust_id` int(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `cust_id`, `name`, `description`) VALUES
(1, 0, 'sample name', 'good experience nice place'),
(2, 0, 'Anonymous', 'buang');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(250) NOT NULL,
  `transaction_id` int(250) NOT NULL,
  `ammount_payment` int(250) NOT NULL,
  `payment_status` varchar(250) NOT NULL,
  `ref_no` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `transaction_id`, `ammount_payment`, `payment_status`, `ref_no`) VALUES
(1, 1197077060, 476, 'Fullypaid', 'sample12345'),
(2, 1231922180, 88, 'Paid', '1');

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
  `category` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pumpboats`
--

INSERT INTO `pumpboats` (`id`, `license_no`, `pumpboat_no`, `type`, `category`, `image`, `date_created`) VALUES
(6, '13', 13, 'Type1', 'Category1', 'uploads/permaDANROSE1.jpg', '0000-00-00'),
(9, '844', 12, 'Type1', 'Category1', 'uploads/ohaha.jpg', '2024-07-02');

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
  `user_type_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `contact_no`, `address`, `uname`, `pass`, `user_type_id`) VALUES
(1, 'admin', 'admin', '0', 'poblacion', 'admin', 'admin', 1),
(18, 'Cardo', 'Dalisay', '09783648265', 'this is sample address', 'cardo', 'cardo1234', 3),
(19, 'John Lloyd', 'Bawi-in', '09665581572', 'Poblacion, Madridejos, Cebu', 'lloydy', 'lloydy', 3);

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
(3, 'customer'),
(4, 'staff');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

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
-- AUTO_INCREMENT for table `cottage/hall`
--
ALTER TABLE `cottage/hall`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feature`
--
ALTER TABLE `feature`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pumpboats`
--
ALTER TABLE `pumpboats`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Database: `sbtbsphp`
--
CREATE DATABASE IF NOT EXISTS `sbtbsphp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sbtbsphp`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(100) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `customer_route` varchar(200) NOT NULL,
  `booked_amount` int(100) NOT NULL,
  `booked_seat` varchar(100) NOT NULL,
  `booking_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `customer_id`, `route_id`, `customer_route`, `booked_amount`, `booked_seat`, `booking_created`) VALUES
(60, 'TBZJ360', 'CUST-2114034', 'RT-1908653', 'CITY1 &rarr; CITY2', 100, '3', '2021-10-16 22:15:13'),
(61, 'QK0MT61', 'CUST-2017936', 'RT-9941455', 'EDROISCHESTER &rarr; BRUGOW', 110, '15', '2021-10-17 22:36:10'),
(62, 'A8L5662', 'CUST-5585037', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '2', '2021-10-18 00:08:51'),
(63, 'QDNGC63', 'CUST-8996235', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '15', '2021-10-18 09:31:30'),
(64, 'X34RW64', 'CUST-9474738', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '6', '2021-10-18 09:32:21'),
(65, 'JKZVT65', 'CUST-4031139', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '18', '2021-10-18 09:33:36'),
(66, 'HIIAN66', 'CUST-9997540', 'RT-5887160', 'FLORIA &rarr; ARKBY', 118, '16', '2021-10-18 09:40:16'),
(67, 'QLOE167', 'CUST-9997540', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '12', '2021-10-18 09:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(100) NOT NULL,
  `bus_no` varchar(255) NOT NULL,
  `bus_assigned` tinyint(1) NOT NULL DEFAULT 0,
  `bus_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_no`, `bus_assigned`, `bus_created`) VALUES
(44, 'MVL1000', 0, '2021-10-16 22:05:16'),
(45, 'ABC0010', 1, '2021-10-17 22:32:46'),
(46, 'XYZ7890', 0, '2021-10-17 22:33:15'),
(47, 'BCC9999', 0, '2021-10-17 22:33:22'),
(48, 'RDH4255', 1, '2021-10-17 22:33:36'),
(49, 'TTH8888', 1, '2021-10-18 00:05:32'),
(50, 'MMM9969', 1, '2021-10-18 00:06:02'),
(51, 'LLL7699', 1, '2021-10-18 00:06:42'),
(52, 'SSX6633', 0, '2021-10-18 00:06:52'),
(53, 'NBS4455', 0, '2021-10-18 09:27:49'),
(54, 'CAS3300', 1, '2021-10-18 09:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(100) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `customer_phone` varchar(10) NOT NULL,
  `customer_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `customer_name`, `customer_phone`, `customer_created`) VALUES
(34, 'CUST-2114034', 'Dfirst Dlast', '7002001200', '2021-10-16 22:09:12'),
(35, 'CUST-8996235', 'Willian Hobbs', '4012222222', '2021-10-17 22:30:23'),
(36, 'CUST-2017936', 'George Watts', '7011111111', '2021-10-17 22:30:53'),
(37, 'CUST-5585037', 'Bobb Horn', '1111111110', '2021-10-17 22:31:20'),
(38, 'CUST-9474738', 'Alan Moore', '7900000000', '2021-10-18 09:32:02'),
(39, 'CUST-4031139', 'Jamie Rhoades', '1003000010', '2021-10-18 09:33:08'),
(40, 'CUST-9997540', 'Demo Customer', '7777777700', '2021-10-18 09:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(100) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `bus_no` varchar(155) NOT NULL,
  `route_cities` varchar(255) NOT NULL,
  `route_dep_date` date NOT NULL,
  `route_dep_time` time NOT NULL,
  `route_step_cost` int(100) NOT NULL,
  `route_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_id`, `bus_no`, `route_cities`, `route_dep_date`, `route_dep_time`, `route_step_cost`, `route_created`) VALUES
(53, 'RT-1908653', 'MVL1000', 'CITY1,CITY2', '2021-10-17', '22:05:00', 100, '2021-10-16 22:05:42'),
(54, 'RT-3835554', 'MMM9969', 'ZEKA,ZREGOW', '2021-10-19', '23:13:00', 70, '2021-10-16 22:12:32'),
(55, 'RT-9941455', 'RDH4255', 'EDROISCHESTER,BRUGOW', '2021-10-18', '10:00:00', 110, '2021-10-17 22:34:47'),
(56, 'RT-9069556', 'XYZ7890', 'ANTALAND,ZREGOW', '2021-10-19', '11:40:00', 85, '2021-10-17 23:39:57'),
(57, 'RT-775557', 'ABC0010', 'ENCEFORD,VLIRGINIA', '2021-10-19', '13:30:00', 131, '2021-10-17 23:42:12'),
(58, 'RT-753558', 'TTH8888', 'ARKBY,VEIM', '2021-10-20', '12:04:00', 55, '2021-10-18 00:04:42'),
(59, 'RT-6028759', 'LLL7699', 'BELRITH,ARKBY', '2021-10-20', '13:50:00', 166, '2021-10-18 00:07:50'),
(60, 'RT-5887160', 'CAS3300', 'FLORIA,ARKBY', '2021-10-19', '10:30:00', 118, '2021-10-18 09:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `bus_no` varchar(155) NOT NULL,
  `seat_booked` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`bus_no`, `seat_booked`) VALUES
('ABC0010', NULL),
('BCC9999', NULL),
('CAS3300', '16'),
('LLL7699', NULL),
('MMM9969', '2,15,6,18,12'),
('MVL1000', '3'),
('NBS4455', NULL),
('RDH4255', '15'),
('SSX6633', NULL),
('TTH8888', NULL),
('XYZ7890', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_name`, `user_password`, `user_created`) VALUES
(1, 'Liam Moore', 'admin', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', '2021-06-02 13:55:21'),
(2, 'Test Admin', 'testadmin', '$2y$10$A2eGOu1K1TSBqMwjrEJZg.lgy.FmCUPl/l5ugcYOXv4qKWkFEwcqS', '2021-10-17 21:10:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`bus_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Database: `ship_ticketing_db`
--
CREATE DATABASE IF NOT EXISTS `ship_ticketing_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ship_ticketing_db`;

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int(30) NOT NULL,
  `accommodation` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`id`, `accommodation`, `description`, `date_created`) VALUES
(1, 'CABIN FOR 6', 'Accom 101', '2021-08-28 10:43:12'),
(2, 'TOURIST CLASS', 'Accom 102', '2021-08-28 10:43:45'),
(3, 'CABIN FOR 4', 'Accom 103', '2021-08-28 10:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `port_list`
--

CREATE TABLE `port_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `port_list`
--

INSERT INTO `port_list` (`id`, `name`, `location`, `date_created`) VALUES
(1, 'Sample Port 101', 'Location 1', '2021-08-28 10:34:53'),
(2, 'Sample Port 102', 'Location 2', '2021-08-28 10:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(30) NOT NULL,
  `ticket_number` varchar(30) NOT NULL,
  `schedule_id` int(30) NOT NULL,
  `accommodation_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `ticket_price` float NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = Confirmed, 2 = Cancel',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `ticket_number`, `schedule_id`, `accommodation_id`, `name`, `gender`, `contact`, `address`, `dob`, `ticket_price`, `status`, `date_created`, `date_updated`) VALUES
(1, '2147483647', 2, 3, 'John D Smith', 'Male', '09123456789', 'Sample Address', '1997-06-23', 2000, 1, '2021-08-28 16:03:48', '2021-08-28 16:31:16'),
(2, '2147483647', 2, 2, 'Mike Williams', 'Male', '09456789321', 'Sample Address', '1997-10-14', 1300, 1, '2021-08-28 16:33:39', NULL),
(5, '2147483647', 3, 2, 'Claire Blake', 'Female', '09123989456', 'Sample address ', '1997-12-07', 900, 1, '2021-08-29 23:39:58', '2021-08-29 23:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(30) NOT NULL,
  `port_from_id` int(30) NOT NULL,
  `port_to_id` int(30) NOT NULL,
  `ship_id` int(30) NOT NULL,
  `departure_datetime` datetime DEFAULT NULL,
  `arrival_datetime` datetime DEFAULT NULL,
  `total_passengers` int(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `port_from_id`, `port_to_id`, `ship_id`, `departure_datetime`, `arrival_datetime`, `total_passengers`, `date_created`, `date_updated`) VALUES
(2, 2, 1, 1, '2021-08-30 13:00:00', '2021-08-31 13:00:00', 0, '2021-08-28 13:41:48', '2021-08-28 14:07:48'),
(3, 2, 1, 2, '2021-09-02 23:00:00', '2021-09-03 02:00:00', 0, '2021-08-29 23:41:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sched_accom`
--

CREATE TABLE `sched_accom` (
  `id` int(30) NOT NULL,
  `schedule_id` int(30) NOT NULL,
  `accommodation_id` int(30) NOT NULL,
  `net_fare` float NOT NULL,
  `max_passenger` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sched_accom`
--

INSERT INTO `sched_accom` (`id`, `schedule_id`, `accommodation_id`, `net_fare`, `max_passenger`) VALUES
(4, 2, 3, 2000, 80),
(5, 2, 1, 1600, 60),
(6, 2, 2, 1300, 200),
(7, 3, 3, 1500, 40),
(8, 3, 1, 1300, 0),
(9, 3, 2, 900, 150);

-- --------------------------------------------------------

--
-- Table structure for table `ship_list`
--

CREATE TABLE `ship_list` (
  `id` int(30) NOT NULL,
  `id_code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ship_list`
--

INSERT INTO `ship_list` (`id`, `id_code`, `name`, `description`, `status`, `date_created`) VALUES
(1, '78954', 'Vessel 101', 'Sample Vessel 101', 1, '2021-08-28 10:22:54'),
(2, '65499', 'Vessel 102', 'Sample Vessel 2', 1, '2021-08-28 10:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'SANTA FE PORT ISLAND SHIP TICKET RESERVATION SYSTEM '),
(6, 'short_name', 'STFPISTRS'),
(11, 'logo', 'uploads/1630115400_ship_logo.jpg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1712156100_ISLAND SHIPPING.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-21 09:55:07'),
(2, 'John', 'Smith', 'jsmith@sample.com', '39ce7e2a8573b41ce73b5ba41617f8f7', 'uploads/1630246860_male.png', NULL, 2, '2021-08-29 22:21:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `port_list`
--
ALTER TABLE `port_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sched_accom`
--
ALTER TABLE `sched_accom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `ship_list`
--
ALTER TABLE `ship_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `port_list`
--
ALTER TABLE `port_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sched_accom`
--
ALTER TABLE `sched_accom`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ship_list`
--
ALTER TABLE `ship_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sched_accom`
--
ALTER TABLE `sched_accom`
  ADD CONSTRAINT `sched_accom_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
