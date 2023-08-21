-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2023 at 01:13 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`UID`, `Name`, `Passwd`) VALUES
('admin1', 'Dipti Gupta', '$2y$10$lBMwO7FRzF.5rozdKellfuYksf2qFpawt6ctxrNsVdBsK4wD3sgza'),
('admin2', 'Kashi Choudhary', '$2y$10$ySzr3.Y9N5KBNF0Fku4xre2CXCoXTu/NgJgQKzRN1lrrYXvtiynCi'),
('admin3', 'Aryan Gupta', '$2y$10$r/7aJnapi/RQKbHmv8d9Z.6k6BcSMWEtGcVyLUvu.oXucG335AWj2'),
('admin4', 'AA', '$2y$10$RKPKyYGDRXbyM5b6qFgbkuajRY7GVPbNl4yBQUpcvltY4MfeYYlum');

-- --------------------------------------------------------

--
-- Table structure for table `staff_login`
--

CREATE TABLE `staff_login` (
  `UID` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_login`
--

INSERT INTO `staff_login` (`UID`, `Name`, `Passwd`) VALUES
('staff1', 'Pratik Das', '$2y$10$oVeaN2Ek6WugGp4oyOKcmOALQl0U57Xe/b4A5LNhIZxYiwEHPZP3u'),
('staff2', 'Manjusha Choudhary', '$2y$10$Ca28Vet489B8a6SOXn5fuel/SHynVQ4fiAjiSHlz1GFHsIkpHBV56'),
('staff3', 'Samir Das', '$2y$10$O.f1qxneUeoOrglsyDb96ulAaShyKTexupaO8eiaImhHzb3zr/HQS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `staff_login`
--
ALTER TABLE `staff_login`
  ADD PRIMARY KEY (`UID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
