-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2022 at 05:17 PM
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
-- Database: `xmlbaza`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `wic` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `vpf_name` varchar(255) DEFAULT NULL,
  `currency_code` varchar(255) NOT NULL,
  `avail` int(11) NOT NULL,
  `retail_price` double NOT NULL,
  `my_price` double NOT NULL,
  `warrantyterm` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `small_image` text NOT NULL,
  `product_card` text NOT NULL,
  `ean` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
