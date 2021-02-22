-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2021 at 10:41 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id15580275_borndayakboutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(10) NOT NULL,
  `adminUserName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adminPassword` varchar(6) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `adminUserName`, `adminPassword`) VALUES
(10, 'carmen', 'Car12*'),
(11, 'miza', 'Miz12*'),
(12, 'zulaikha', 'Zul12*'),
(13, 'syasya', 'Sya12*');

-- --------------------------------------------------------

--
-- Table structure for table `archivedmember`
--

CREATE TABLE `archivedmember` (
  `ArchivedUserID` int(10) UNSIGNED NOT NULL,
  `FullName` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `PhoneNumber` int(12) DEFAULT 0,
  `Email` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Password` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Gender` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `archivedmember`
--

INSERT INTO `archivedmember` (`ArchivedUserID`, `FullName`, `Username`, `PhoneNumber`, `Email`, `Password`, `Gender`, `Address`) VALUES
(4, 'Ika Aziyen', 'ikayen', 19875362, 'ikayen@gmail.com', 'Ika12*', 'Female', 'kl');

-- --------------------------------------------------------

--
-- Table structure for table `archivedproduct`
--

CREATE TABLE `archivedproduct` (
  `ArchivedProductID` int(11) NOT NULL,
  `ProductName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductDesc` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quantity_In_Stock` int(11) DEFAULT NULL,
  `Price` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ItemId` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `SizeID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `Price` float NOT NULL DEFAULT 999.99,
  `UserID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `UserID` int(10) UNSIGNED NOT NULL,
  `FullName` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `PhoneNumber` int(12) DEFAULT 0,
  `Email` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Password` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Gender` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`UserID`, `FullName`, `Username`, `PhoneNumber`, `Email`, `Password`, `Gender`, `Address`) VALUES
(1, 'ika', 'ka', 111, 'ika@gmail.com', 'Zu1!uu', 'Female', 'kl'),
(2, 'carmen', 'men', 999, 'carmen@gmail.com', 'Car12*', 'Female', 'kl'),
(3, 'Sabrina Said', 'sabrina', 196782345, 'sabrinna01@gmail.com', 'Sab#01', 'Female', 'ampang,selangor');

-- --------------------------------------------------------

--
-- Table structure for table `ordercontent`
--

CREATE TABLE `ordercontent` (
  `OrderContentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(10) NOT NULL,
  `SizeID` int(5) NOT NULL,
  `Quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ordercontent`
--

INSERT INTO `ordercontent` (`OrderContentID`, `OrderID`, `ProductID`, `SizeID`, `Quantity`) VALUES
(31, 24, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TotalPrice` int(10) NOT NULL,
  `DeliveryOption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PaymentOption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PaymentStatusID` int(11) DEFAULT NULL,
  `OrderStatusID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `TotalPrice`, `DeliveryOption`, `PaymentOption`, `PaymentStatusID`, `OrderStatusID`) VALUES
(24, 3, 49, '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `OrderStatusID` int(5) NOT NULL,
  `OrderStatusDetails` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`OrderStatusID`, `OrderStatusDetails`) VALUES
(1, 'Processing'),
(3, 'Out for delivery'),
(6, 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `paymentstatus`
--

CREATE TABLE `paymentstatus` (
  `PaymentStatusID` int(5) NOT NULL,
  `PaymentStatusDetails` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paymentstatus`
--

INSERT INTO `paymentstatus` (`PaymentStatusID`, `PaymentStatusDetails`) VALUES
(1, 'Successful'),
(2, 'Unsuccessful');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `ProductDesc` varchar(1000) DEFAULT NULL,
  `Quantity_In_Stock` int(11) DEFAULT NULL,
  `Price` decimal(5,2) NOT NULL DEFAULT 0.00,
  `images` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductDesc`, `Quantity_In_Stock`, `Price`, `images`) VALUES
(1, 'Bungai Terung White Cardigan ', 'White kimono', 6, '49.00', 'Bungai Terung White Cardigan 1 491.jpg\r\nBungai Terung White Cardigan 2 491.jpg\r\nBungai Terung White Cardigan 3 491.jpg'),
(2, 'Crimson Maiden Cardigan 1 492', 'Red kimono', 6, '49.00', 'Bungai Terung White Cardigan 1 492.jpg\r\nBungai Terung White Cardigan 2 492.jpg\r\nBungai Terung White Cardigan 3 492.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `SizeID` int(11) NOT NULL,
  `SizeName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SizeInformation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`SizeID`, `SizeName`, `SizeInformation`) VALUES
(1, 'FREESIZE', 'can fit up to XL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `archivedmember`
--
ALTER TABLE `archivedmember`
  ADD PRIMARY KEY (`ArchivedUserID`);

--
-- Indexes for table `archivedproduct`
--
ALTER TABLE `archivedproduct`
  ADD PRIMARY KEY (`ArchivedProductID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ItemId`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `ordercontent`
--
ALTER TABLE `ordercontent`
  ADD PRIMARY KEY (`OrderContentID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`OrderStatusID`);

--
-- Indexes for table `paymentstatus`
--
ALTER TABLE `paymentstatus`
  ADD PRIMARY KEY (`PaymentStatusID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`SizeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `archivedmember`
--
ALTER TABLE `archivedmember`
  MODIFY `ArchivedUserID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `archivedproduct`
--
ALTER TABLE `archivedproduct`
  MODIFY `ArchivedProductID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `UserID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ordercontent`
--
ALTER TABLE `ordercontent`
  MODIFY `OrderContentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `OrderStatusID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `paymentstatus`
--
ALTER TABLE `paymentstatus`
  MODIFY `PaymentStatusID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `SizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
