-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2021 at 11:15 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Name`, `Email`) VALUES
(1, 'Malik', 'Malik@gmail.com'),
(2, 'Husnain', 'Husnain@gmail.com');

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
(14, '098765432134567', 539.8533, '3456', '2021-10-25', '2021-11-09'),
(16, '098765432198765', 149.8044, '9876', '2021-10-27', '2021-11-11'),
(17, '123456789045678', 50, '1234', '2021-10-27', '2021-11-11'),
(19, '123456549045678', 50, '1234', '2021-10-27', '2021-11-11'),
(21, '098765432145678', 549.9022, '1289', '2021-10-28', '2021-11-12'),
(22, '123451234512345', 649.9022, '1234', '2021-10-29', '2021-11-13');

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
  `Create_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Current_at` time NOT NULL,
  `Token` varchar(300) DEFAULT NULL,
  `Card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`Id`, `Name`, `Email`, `Merchant_Password`, `Status`, `Image`, `Create_at`, `Current_at`, `Token`, `Card_id`) VALUES
(4, 'Ali', 'malikhusnain@gamil.com', '12345678', 0, 0x496d6167652e6a706567, '2021-10-27 05:12:13', '11:12:13', NULL, 4),
(5, 'Ali', 'malikhusnain713@gamil.com', '12345678', 1, 0x496d6167652e6a706567, '2021-10-27 05:12:13', '11:12:13', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibWFsaWsifQ.ldVQOl80tne8EaDcVDtJ4GRWyBnnFpzmQN2pbupVi18', 8),
(6, 'Ali', 'malikhusnain714@gamil.com', '12345678', 0, 0x496d6167652e6a706567, '2021-10-27 05:12:13', '11:12:13', NULL, 9),
(7, 'Ali Hussain', 'malik123@gmail.com', '626Malik', 1, 0x496d6167652e6a706567, '2021-10-27 11:10:06', '16:10:06', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibWFsaWsxMjNAZ21haWwuY29tIn0.lgpBqt4hRAQl9-wqHKxO4195XQuEcYTBBIOQSgTV0TE', 10),
(8, 'Uzair', 'uzair@gmail.com', '034Uzair', 1, 0x496d6167652e6a706567, '2021-10-27 07:59:33', '12:59:33', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidXphaXJAZ21haWwuY29tIn0.Voe-rf8ILQM3J_w-S28VZEWylOHFU4BcopFKI2EsCN4', 14),
(9, 'Mohsin', 'Mohsin@gmail.com', '0340Mohsin', 1, 0x496d6167652e6a706567, '2012-10-02 19:00:00', '12:10:03', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibW9oc2luQGdtYWlsLmNvbSJ9.sV6Woqm8yg1vMek8hizQnsQzF9xs1Ap5im_KRUoohrQ', 16),
(10, 'Zabil', 'zabil@gmail.com', '123Zabil', 1, 0x496d6167652e6a706567, '0000-00-00 00:00:00', '12:30:24', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiemFiaWxAZ21haWwuY29tIn0.Hijb5fi-vV2Edrj7PkXIJJkjm842Fi6iRJlE7LIR1sc', 17),
(12, 'Umar', 'Umar@gmail.com', '123Umar123', 1, 0x496d6167652e6a706567, '2021-10-27 11:02:07', '12:50:49', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiVW1hckBnbWFpbC5jb20ifQ.Kmyd8oVK4gI41rHCp1-GS_BW0Stpaulo1VuelCVGtBg', 19),
(13, 'Lala', 'lala@gmail.com', '123Lala123', 1, 0x496d6167652e6a706567, '2021-10-28 17:35:33', '06:00:39', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibGFsYUBnbWFpbC5jb20ifQ.8HISJKRbCfivk1rh43SXXpXOv01qSraXw2RsSbU3peo', 21),
(14, 'Husnain', 'husnain@gmail.com', '162Husnain', 1, 0x496d6167652e6a706567, '2021-10-29 06:30:04', '08:28:59', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiaHVzbmFpbkBnbWFpbC5jb20ifQ.SZWnc4W9FfRi3l8vAmcPqlMx2spMvPZ_wVMna6MI6ZM', 22);

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
(10, 'pt.alihussain@gmail.com', 'm.usamayounas669@gmail.com', '', '', 'this is from send mail api', 'this is the body of email that is from send mail', 8, 10),
(11, 'pt.alihussain@gmail.com', 'malikabdullah4300@gmail.com', '', '', 'Testing', 'this is the body of email that is send from php mail', 9, 11),
(12, 'pt.alihussain@gmail.com', 'uzair.am10@gmail.com', '', '', 'Testing Lala', 'this is the body of Lala email that is send from php mail', 9, 12),
(13, 'pt.alihussain@gmail.com', 'uzair.am10@gmail.com', '', '', 'Testing Lala', 'this is the body of Lala email that is send from php mail', 13, 13),
(14, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'Testing mail', 'this is the body of email that is send from php script', 14, 14),
(15, 'pt.alihussain@gmail.com', 'malikhusnain713@gmail.com', '', '', 'Testing', 'this is the body of email that is send from php mail', 14, 15);

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
(10, 'processed', '', 'this mail is mail'),
(11, 'processed', '', 'this mail is mail'),
(12, 'processed', '', 'this mail is mail'),
(13, 'processed', '', 'this mail is mail'),
(14, 'processed', '', 'this mail is mail'),
(15, 'invalid', '', 'this mail is mail');

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
(4, 'mini Uzair mini', 'miniuzini@gmail.com', '', 1, 1, 0, 0, 0, NULL, 8),
(5, 'mini Mohsin', 'minimohsin@gmail.com', '', 1, 1, 0, 0, 1, NULL, 9),
(6, 'mini Mohsin mini', 'minimohsinmini@gmail.com', '034MiniMohsinMini', 1, 1, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibWluaW1vaHNpbm1pbmlAZ21haWwuY29tIn0.gqY872uyuwyvgqhA85Jd6T5XOSi37r57ynBeFf_AE6U', 9),
(7, 'mini Lala', 'minilala@gmail.com', '034miniLala', 1, 1, 0, 0, 1, NULL, 13),
(8, 'mini Husnain', 'minihusnain@gmail.com', '162MiniHusnain', 1, 1, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoibWluaWh1c25haW5AZ21haWwuY29tIn0.TfVN8ylq9vxB8MYckepaW8i6LSGP2ONA58-I6eVEyEw', 14);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `secondary_user`
--
ALTER TABLE `secondary_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
