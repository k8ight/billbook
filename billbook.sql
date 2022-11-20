-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2022 at 05:19 PM
-- Server version: 10.9.3-MariaDB
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k8ight`
--
CREATE DATABASE IF NOT EXISTS `billbook` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `billbook`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Email` text NOT NULL,
  `pass` text NOT NULL,
  `Phone` text NOT NULL,
  `jdate` text NOT NULL,
  `jtitle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Email`, `pass`, `Phone`, `jdate`, `jtitle`) VALUES
(1, 'billbook@localhost.net', '917412f57e04ff749f37560c15b8d670', '0000000000', '-', 'OWNER');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invid` text NOT NULL,
  `dateissue` text NOT NULL,
  `lpdate` text NOT NULL,
  `status` text NOT NULL COMMENT 'Paid/Not Paid',
  `note` text NOT NULL,
  `items` text NOT NULL COMMENT 'Item in array formay\r\n{item=>"name",qty=>"1-999+",eachvalue=>"value",itv=>"qty * eachvalue"}',
  `type` text NOT NULL COMMENT 'PO/INV',
  `cname` text NOT NULL,
  `caddr` text NOT NULL,
  `cphone` text NOT NULL,
  `cemail` text NOT NULL,
  `ctax` text NOT NULL COMMENT 'Like PAN-ABCD\r\nor \r\nGST-HSADKJSAKJDHASKD',
  `cid` text NOT NULL COMMENT 'IF any',
  `tamt` text NOT NULL COMMENT 'Total Amount after Tax',
  `gsta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
