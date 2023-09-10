-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 06:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `r35`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `UID` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`UID`, `Name`, `Passwd`) VALUES
('admin1', 'Dipti Gupta', '$2y$10$lBMwO7FRzF.5rozdKellfuYksf2qFpawt6ctxrNsVdBsK4wD3sgza'),
('admin2', 'Kashi Choudhary', '$2y$10$ySzr3.Y9N5KBNF0Fku4xre2CXCoXTu/NgJgQKzRN1lrrYXvtiynCi'),
('admin3', 'Aryan Gupta', '$2y$10$r/7aJnapi/RQKbHmv8d9Z.6k6BcSMWEtGcVyLUvu.oXucG335AWj2'),
('admin4', 'Jayashri Mishra', '$2y$10$AKusfp3NgSGSTq/Ha3EN0uV0AI5LnlPDCkT/CacwPdnlWENid783y');

-- --------------------------------------------------------

--
-- Table structure for table `leave_record`
--

CREATE TABLE `leave_record` (
  `SN` int(50) NOT NULL,
  `UID` varchar(10) NOT NULL,
  `Type` varchar(5) NOT NULL,
  `From` date NOT NULL,
  `To` date NOT NULL,
  `Days` int(3) NOT NULL,
  `Status` varchar(15) NOT NULL DEFAULT 'Pending',
  `Approved by` varchar(10) DEFAULT NULL
) ;

--
-- Dumping data for table `leave_record`
--

INSERT INTO `leave_record` (`SN`, `UID`, `Type`, `From`, `To`, `Days`, `Status`, `Approved by`) VALUES
(2, 'staff3', 'LWP', '2023-09-21', '2023-09-22', 2, 'Approved', NULL),
(4, 'staff2', 'OP', '2023-09-13', '2023-09-15', 3, 'Pending', NULL),
(6, 'staff1', 'SL', '2023-09-15', '2023-09-18', 3, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_leave`
--

CREATE TABLE `staff_leave` (
  `UID` varchar(10) NOT NULL,
  `EL` int(3) NOT NULL,
  `CL` int(2) NOT NULL,
  `SL` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_leave`
--

INSERT INTO `staff_leave` (`UID`, `EL`, `CL`, `SL`) VALUES
('staff1', 5, 12, 27),
('staff2', 5, 12, 30),
('staff3', 5, 12, 30),
('staff4', 5, 12, 30);

-- --------------------------------------------------------

--
-- Table structure for table `staff_login`
--

CREATE TABLE `staff_login` (
  `UID` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_login`
--

INSERT INTO `staff_login` (`UID`, `Name`, `Passwd`) VALUES
('staff1', 'Pratik Das', '$2y$10$oVeaN2Ek6WugGp4oyOKcmOALQl0U57Xe/b4A5LNhIZxYiwEHPZP3u'),
('staff2', 'Manjusha Choudhary', '$2y$10$Ca28Vet489B8a6SOXn5fuel/SHynVQ4fiAjiSHlz1GFHsIkpHBV56'),
('staff3', 'Samir Das', '$2y$10$O.f1qxneUeoOrglsyDb96ulAaShyKTexupaO8eiaImhHzb3zr/HQS'),
('staff4', 'Noyon Das', '$2y$10$KGEmNHwxdF.SxIZ9LMcDCe9NmzJsLIdxMcl0OM8xdrHd4LQC702rG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `leave_record`
--
ALTER TABLE `leave_record`
  ADD PRIMARY KEY (`SN`),
  ADD KEY `staff_rec_fk` (`UID`),
  ADD KEY `admin_app_fk` (`Approved by`);

--
-- Indexes for table `staff_leave`
--
ALTER TABLE `staff_leave`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `staff_login`
--
ALTER TABLE `staff_login`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_record`
--
ALTER TABLE `leave_record`
  MODIFY `SN` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leave_record`
--
ALTER TABLE `leave_record`
  ADD CONSTRAINT `admin_app_fk` FOREIGN KEY (`Approved by`) REFERENCES `admin_login` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_rec_fk` FOREIGN KEY (`UID`) REFERENCES `staff_login` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_ck` CHECK (`Status` IN ('Pending', 'Approved', 'Denied'));
--
-- Constraints for table `staff_leave`
--
ALTER TABLE `staff_leave`
  ADD CONSTRAINT `staff_id_fk` FOREIGN KEY (`UID`) REFERENCES `staff_login` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
