-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2020 at 04:07 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `update_at`) VALUES
(2, 'Fruits', 'shoe', '2020-11-09 00:00:00', '2020-11-16 23:18:51'),
(3, 'Shoes', 'shoes', '2020-11-16 00:00:00', '2020-11-17 04:16:33'),
(4, 'Shirt', 'shirt', '2020-11-23 00:00:00', '2020-11-23 01:30:26'),
(5, 'Women Coat', 'women', '2020-12-02 00:00:00', '2020-12-02 03:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `quantity`, `price`, `image`, `created_at`, `update_at`) VALUES
(1, 'Shoe', 'shoe', 3, 10, 10000, 'shoe.jpg', '2020-11-22 05:18:54', '2020-11-22 05:18:54'),
(2, 'Apple', 'apple', 2, 1, 1000, 'apple.jpg', '2020-11-22 09:02:50', '2020-11-22 09:02:50'),
(3, 'T-shirt', 'young boy', 4, 2, 10000, 'tshirt.jpg', '2020-11-23 01:32:28', '2020-11-23 01:32:28'),
(4, 'T-shirt', 'young boy', 4, 0, 9000, 'tshirt-1.jpeg', '2020-11-23 01:32:59', '2020-11-23 01:32:59'),
(6, 'Orange', 'Orange Fresh fruit', 2, 10, 1000, 'orange.jpeg', '2020-12-02 03:26:41', '2020-12-02 03:26:41'),
(7, 'Pineapple', 'fresh fruit', 2, 9, 2000, 'pineapple.jpeg', '2020-12-02 03:28:28', '2020-12-02 03:28:28'),
(8, 'Stawberry', 'fresh furit', 2, 19, 3000, 'stawberry.jpeg', '2020-12-02 03:29:02', '2020-12-02 03:29:02'),
(9, 'Mango', 'mango', 2, 45, 3000, 'mango.jpeg', '2020-12-02 03:29:47', '2020-12-02 03:29:47'),
(10, 'Coat', 'coat', 5, 9, 20000, 'women.jpeg', '2020-12-02 03:30:35', '2020-12-02 03:30:35'),
(11, 'Coat-2', 'coat', 5, 19, 15000, 'women1.jpeg', '2020-12-02 03:31:02', '2020-12-02 03:31:02'),
(12, 'Coat-3', 'coat', 5, 9, 30000, 'women2.jpeg', '2020-12-02 03:31:29', '2020-12-02 03:31:29'),
(13, 'Coat-4', 'coat', 5, 4, 40000, 'women4.jpeg', '2020-12-02 03:31:58', '2020-12-02 03:31:58'),
(14, 'Shoe-new', 'shoe', 3, 16, 20000, 'shoe.jpg', '2020-12-02 03:32:31', '2020-12-02 03:32:31'),
(15, 'Shoe-new-1', 'shoe', 3, 19, 12000, 'shoe1.jpeg', '2020-12-02 03:33:04', '2020-12-02 03:33:04'),
(16, 'Shoe-new-2', 'shoe', 3, 28, 15000, 'shoe2.jpeg', '2020-12-02 03:33:31', '2020-12-02 03:33:31'),
(17, 'Shoe-new-3', 'shoe', 3, 49, 6000, 'shoe3.jpeg', '2020-12-02 03:34:01', '2020-12-02 03:34:01'),
(18, 'Shoe-new-4', 'shoe', 3, 39, 40000, 'shoe4.jpeg', '2020-12-02 03:34:31', '2020-12-02 03:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `sale_orders`
--

CREATE TABLE `sale_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(10) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale_orders`
--

INSERT INTO `sale_orders` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(9, 1, 373000, '2020-12-02 09:04:50'),
(10, 7, 27000, '2020-12-02 09:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `sale_orders_detail`
--

CREATE TABLE `sale_orders_detail` (
  `id` int(11) NOT NULL,
  `sale_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale_orders_detail`
--

INSERT INTO `sale_orders_detail` (`id`, `sale_order_id`, `product_id`, `quantity`, `order_date`) VALUES
(15, 9, 18, 1, '2020-12-02 09:04:50'),
(16, 9, 14, 4, '2020-12-02 09:04:50'),
(17, 9, 13, 6, '2020-12-02 09:04:51'),
(18, 9, 9, 4, '2020-12-02 09:04:51'),
(19, 9, 2, 1, '2020-12-02 09:04:52'),
(20, 10, 15, 1, '2020-12-02 09:27:38'),
(21, 10, 16, 1, '2020-12-02 09:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `address`, `role`, `created_at`, `update_at`) VALUES
(1, 'admin', 'admin@gmail.com', '09401576089', '$2y$10$F.9j5FlsaC6nSz04vI2jCunM5.AAjFhpSyTkmD1xIZdWcIqeocI16', 'text', 1, '2020-11-16 10:50:09', '2020-11-16 10:51:04'),
(4, 'Trust', 'user@gmail.com', '0938484488', '$2y$10$bdPDGW5T8h1bpU8BW4FNiurTYMl2.l50QYtADtGY2KdlSaq3.i2rO', 'Hello Wrold', 0, '2020-11-17 00:00:00', '2020-11-17 03:59:54'),
(6, 'Khant', 'khantminthant2001@gmail.com', '3897958', '$2y$10$F08rRr.UjN8qi43GMAPeJuz3G5aDc5BVLND1STDn3gMfkjT8WXs.O', 'nay', 0, '2020-11-22 10:10:53', '2020-11-22 10:10:53'),
(7, 'Apple', 'apple@gmail.com', '98079879', '$2y$10$zm2INcguM.RheSn5DSyju.bTWwXrWkYWo.XadvvbsM4EVowAqaAXS', 'Nay Pyi Taw', 0, '2020-12-01 21:28:03', '2020-12-01 21:28:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_orders`
--
ALTER TABLE `sale_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_orders_detail`
--
ALTER TABLE `sale_orders_detail`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sale_orders`
--
ALTER TABLE `sale_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale_orders_detail`
--
ALTER TABLE `sale_orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
