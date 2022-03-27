-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 27, 2022 at 08:04 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CAR_RENTAL`
--

-- --------------------------------------------------------

--
-- Table structure for table `AGENCY`
--

CREATE TABLE `AGENCY` (
  `agency_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL CHECK (octet_length(`password`) >= 8)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CARS`
--

CREATE TABLE `CARS` (
  `vehicle_number` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `rent` int(11) NOT NULL,
  `agency_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMERS`
--

CREATE TABLE `CUSTOMERS` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL CHECK (octet_length(`password`) >= 8)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `RENT`
--

CREATE TABLE `RENT` (
  `rent_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `start_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AGENCY`
--
ALTER TABLE `AGENCY`
  ADD PRIMARY KEY (`agency_id`);

--
-- Indexes for table `CARS`
--
ALTER TABLE `CARS`
  ADD PRIMARY KEY (`vehicle_number`);

--
-- Indexes for table `CUSTOMERS`
--
ALTER TABLE `CUSTOMERS`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `RENT`
--
ALTER TABLE `RENT`
  ADD PRIMARY KEY (`rent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AGENCY`
--
ALTER TABLE `AGENCY`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CUSTOMERS`
--
ALTER TABLE `CUSTOMERS`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `RENT`
--
ALTER TABLE `RENT`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
