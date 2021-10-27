-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2021 at 06:10 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mail_sending_service`
--
create database mail_sending_service;
use mail_sending_service;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `Id` int(11) NOT NULL,
  `Card_number` varchar(255) DEFAULT NULL,
  `Credit` double DEFAULT 50,
  `Cvc_number` varchar(255) DEFAULT NULL,
  `Valid_from` date DEFAULT NULL,
  `Valid_till` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`Id`, `Card_number`, `Credit`, `Cvc_number`, `Valid_from`, `Valid_till`) VALUES
(4, '01234567345', 50, '1234', '4444-12-10', '2222-11-10'),
(8, '012345673234545', 40, '1234', '4444-12-10', '2222-11-10'),
(9, '000345673234545', 50, '1234', '4444-12-10', '2222-11-10'),
(10, '123456789098765', 50, '1234', '2021-10-23', '2021-11-07'),
(14, '098765432134567', 539.8533, '3456', '2021-10-25', '2021-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Merchant_Password` varchar(255) NOT NULL,
  `Status` tinyint(1) DEFAULT 0,
  `Image` blob DEFAULT NULL,
  `Create_at` time NOT NULL,
  `Current_at` time NOT NULL,
  `Token` varchar(300) DEFAULT NULL,
  `Card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`Id`, `Name`, `Email`, `Merchant_Password`, `Status`, `Image`, `Create_at`, `Current_at`, `Token`, `Card_id`) VALUES
(4, 'Ali', 'malikhusnain@gamil.com', '12345678', 0, 0x496d6167652e6a706567, '10:12:13', '11:12:13', NULL, 4),
(5, 'Ali', 'malikhusnain713@gamil.com', '12345678', 1, 0x496d6167652e6a706567, '10:12:13', '11:12:13', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibWFsaWsifQ.ldVQOl80tne8EaDcVDtJ4GRWyBnnFpzmQN2pbupVi18', 8),
(6, 'Ali', 'malikhusnain714@gamil.com', '12345678', 0, 0x496d6167652e6a706567, '10:12:13', '11:12:13', NULL, 9),
(7, 'Ali Hussain', 'malik123@gmail.com', '626Malik', 1, 0x496d6167652e6a706567, '16:10:06', '16:10:06', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibWFsaWsxMjNAZ21haWwuY29tIn0.lgpBqt4hRAQl9-wqHKxO4195XQuEcYTBBIOQSgTV0TE', 10),
(8, 'Uzair', 'uzair@gmail.com', '034Uzair', 1, 0x496d6167652e6a706567, '12:59:33', '12:59:33', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidXphaXJAZ21haWwuY29tIn0.Voe-rf8ILQM3J_w-S28VZEWylOHFU4BcopFKI2EsCN4', 14);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `Id` int(11) NOT NULL,
  `Mail_from` varchar(255) NOT NULL,
  `Mail_to` varchar(255) NOT NULL,
  `Mail_cc` varchar(255) DEFAULT NULL,
  `Mail_bcc` varchar(255) DEFAULT NULL,
  `Subject` varchar(255) DEFAULT NULL,
  `Body` varchar(255) DEFAULT NULL,
  `Merchant_id` int(11) DEFAULT NULL,
  `Response_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`Id`, `Mail_from`, `Mail_to`, `Mail_cc`, `Mail_bcc`, `Subject`, `Body`, `Merchant_id`, `Response_id`) VALUES
(2, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 2),
(3, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 3),
(4, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 4),
(5, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 5),
(6, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 6),
(7, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 7),
(8, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 8),
(9, 'pt.alihussain@gmail.com', 'm.usamayounas669@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 9),
(10, 'pt.alihussain@gmail.com', 'm.usamayounas669@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 10);

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `Id` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `error` varchar(300) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`Id`, `Status`, `error`, `Description`) VALUES
(1, 'received', '', 'this mail is mail'),
(2, 'received', '', 'this mail is mail'),
(3, 'error', 'this is error', 'this mail is mail'),
(4, 'received', '', 'this mail is mail'),
(5, 'received', '', 'this mail is mail'),
(6, 'processed', '', 'this mail is mail'),
(7, 'processed', '', 'this mail is mail'),
(8, 'invalid', '', 'this mail is mail'),
(9, 'processed', '', 'this mail is mail'),
(10, 'processed', '', 'this mail is mail');

-- --------------------------------------------------------

--
-- Table structure for table `secondary_user`
--

CREATE TABLE `secondary_user` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `User_password` varchar(255) NOT NULL,
  `Email_permission` tinyint(1) DEFAULT 0,
  `List_view_permission` tinyint(1) DEFAULT 0,
  `Payment_permission` tinyint(1) DEFAULT 0,
  `Forget_password_permission` tinyint(1) DEFAULT 0,
  `Login_permission` tinyint(1) DEFAULT 0,
  `Token` varchar(300) DEFAULT NULL,
  `Merchant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secondary_user`
--

INSERT INTO `secondary_user` (`Id`, `Name`, `Email`, `User_password`, `Email_permission`, `List_view_permission`, `Payment_permission`, `Forget_password_permission`, `Login_permission`, `Token`, `Merchant_id`) VALUES
(2, 'Malik', 'MalikAli@gmail.com', '', 1, 1, 0, 0, 0, NULL, 7),
(3, 'mini Uzair', 'miniuzair@gmail.com', '', 1, 1, 0, 0, 0, NULL, 8),
(4, 'mini Uzair mini', 'miniuzini@gmail.com', '', 1, 1, 0, 0, 0, NULL, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Card_number` (`Card_number`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Card_id` (`Card_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Response_id` (`Response_id`),
  ADD KEY `Merchant_id` (`Merchant_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `secondary_user`
--
ALTER TABLE `secondary_user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Merchant_id` (`Merchant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `secondary_user`
--
ALTER TABLE `secondary_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `merchant`
--
ALTER TABLE `merchant`
  ADD CONSTRAINT `merchant_ibfk_1` FOREIGN KEY (`Card_id`) REFERENCES `card` (`Id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`Merchant_id`) REFERENCES `merchant` (`Id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`Response_id`) REFERENCES `response` (`Id`);

--
-- Constraints for table `secondary_user`
--
ALTER TABLE `secondary_user`
  ADD CONSTRAINT `secondary_user_ibfk_1` FOREIGN KEY (`Merchant_id`) REFERENCES `merchant` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
