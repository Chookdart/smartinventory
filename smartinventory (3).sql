-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 04:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(50) NOT NULL,
  `ProductType` varchar(100) NOT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `Brand` varchar(100) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  `qr_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductType`, `Category`, `quantity`, `UnitPrice`, `Brand`, `UserID`, `SupplierID`, `DateAdded`, `qr_code`) VALUES
(1, 'Paper', 'School Supplies', 16, 62.00, 'Papel', 1, 6, '2025-11-05 13:36:20', 'PAPER01'),
(2, 'Color', 'School Supplies', 24, 49.00, 'Crayola', 2, 7, '2025-11-05 13:36:20', 'COLOR01'),
(3, 'Eraser', 'School Supplies', 2, 25.00, 'Bhert O', 1, 2, '2025-11-05 13:36:20', 'ERASER01'),
(4, 'Pencil', 'School Supplies', 11, 13.00, 'Monggi', 4, 3, '2025-11-05 13:36:20', 'PENCIL01'),
(5, 'Ballpen', 'School Supplies', 2, 15.00, '8 Ball Point', 3, 4, '2025-11-05 13:36:20', 'BALLPEN01'),
(6, 'Tuxedo', 'Foot & Wear', 50, 1190.00, 'Young S Towne', 5, 1, '2025-11-05 13:36:20', 'TUX01'),
(7, 'Gown', 'Foot & Wear', 24496, 1000.00, 'Acousta', 1, 6, '2025-11-05 13:36:20', 'GOWN01'),
(8, 'Neck Tie', 'Foot & Wear', 24440, 190.00, 'Hed', 1, 3, '2025-11-05 13:36:20', 'NT01'),
(9, 'Polo', 'Foot & Wear', 31, 1300.00, 'Bock', 1, 2, '2025-11-05 13:36:20', 'POLO01'),
(10, 'Shirt', 'Foot & Wear', 17, 860.00, 'Damit Pantanga', 1, 2, '2025-11-05 13:36:20', 'SHIRT01'),
(11, 'Basket Ball', 'Sports', 614, 700.00, 'Suboding', 2, 5, '2025-11-05 13:36:20', 'BB01'),
(12, 'Boxing Gloves', 'Sports', 616, 1200.00, 'Son Goku', 3, 6, '2025-11-05 13:36:20', 'BG01'),
(13, 'Volley Ball', 'Sports', 21, 520.00, 'Ultimate', 5, 1, '2025-11-05 13:36:20', 'VB01'),
(14, 'Jersey', 'Sports', 5, 50.00, 'Kalye Irving', 5, 1, '2025-11-05 13:36:20', 'JERSEY01'),
(15, 'Shorts', 'Sports', 0, 200.00, 'Shorts Pantanga', 2, 7, '2025-11-05 13:36:20', 'SHORTS01'),
(16, 'Potato Crisp', 'Snacks', 11, 50.00, 'Piattos', 3, 1, '2025-11-05 13:36:20', 'PC01'),
(17, 'Multigrain', 'Snacks', 11, 50.00, 'Nova', 4, 3, '2025-11-05 13:36:20', 'M01'),
(18, 'Corn Chips', 'Snacks', 0, 7.00, 'Tattoos', 1, 1, '2025-11-05 13:36:20', 'CC01'),
(19, 'Potato Crisp', 'Snacks', 1299, 60.00, 'VCut', 3, 2, '2025-11-05 13:36:20', 'PC02'),
(20, 'Potato Crisp', 'Snacks', 42, 12.00, 'Roller Coaster', 2, 4, '2025-11-05 13:36:20', 'PC03'),
(26, 'Example', 'Foot & Wear', 20, 49.00, 'sample', 1, 2, '2025-11-25 15:14:01', 'EXAMPLE');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `SaleID` int(11) NOT NULL,
  `CashierID` int(11) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `Date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`SaleID`, `CashierID`, `TotalAmount`, `Date`) VALUES
(13, 1, 62.00, '2025-11-25 15:57:10'),
(14, 1, 62.00, '2025-11-25 17:45:03'),
(15, 1, 62.00, '2025-11-25 21:13:52'),
(16, 1, 62.00, '2025-11-25 21:14:32'),
(17, 1, 62.00, '2025-11-25 21:14:33'),
(18, 1, 62.00, '2025-11-25 21:14:34'),
(19, 1, 62.00, '2025-11-25 21:14:34'),
(20, 1, 62.00, '2025-11-25 21:29:08'),
(21, 1, 198.00, '2025-11-25 21:32:38'),
(22, 1, 25.00, '2025-11-25 21:33:45'),
(23, 1, 87.00, '2025-11-25 21:35:47'),
(24, 1, 87.00, '2025-11-25 21:35:56'),
(25, 1, 87.00, '2025-11-25 21:36:01'),
(26, 1, 62.00, '2025-11-25 21:43:00'),
(27, 1, 62.00, '2025-11-25 21:45:52'),
(28, 1, 112.00, '2025-11-25 21:49:36'),
(29, 1, 1091.00, '2025-11-25 23:18:23'),
(30, 1, 1385.00, '2025-11-26 02:04:37'),
(31, 1, 481.00, '2025-12-02 00:11:53'),
(32, 1, 15766.00, '2025-12-02 11:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `ItemID` int(11) NOT NULL,
  `SaleID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`ItemID`, `SaleID`, `ProductID`, `Quantity`, `Price`) VALUES
(1, 13, 1, 1, 62.00),
(2, 14, 1, 1, 62.00),
(3, 15, 1, 1, 62.00),
(4, 16, 1, 1, 62.00),
(5, 17, 1, 1, 62.00),
(6, 18, 1, 1, 62.00),
(7, 19, 1, 1, 62.00),
(8, 20, 1, 1, 62.00),
(9, 21, 1, 2, 62.00),
(10, 21, 2, 1, 49.00),
(11, 21, 3, 1, 25.00),
(12, 22, 3, 1, 25.00),
(13, 23, 1, 1, 62.00),
(14, 23, 3, 1, 25.00),
(15, 24, 1, 1, 62.00),
(16, 24, 3, 1, 25.00),
(17, 25, 1, 1, 62.00),
(18, 25, 3, 1, 25.00),
(19, 26, 1, 1, 62.00),
(20, 27, 1, 1, 62.00),
(21, 28, 1, 1, 62.00),
(22, 28, 3, 2, 25.00),
(23, 29, 2, 4, 49.00),
(24, 29, 3, 11, 25.00),
(25, 29, 1, 10, 62.00),
(26, 30, 2, 27, 49.00),
(27, 30, 1, 1, 62.00),
(28, 31, 2, 6, 49.00),
(29, 31, 3, 5, 25.00),
(30, 31, 1, 1, 62.00),
(31, 32, 5, 2, 15.00),
(32, 32, 11, 4, 700.00),
(33, 32, 18, 1, 7.00),
(34, 32, 2, 3, 49.00),
(35, 32, 3, 3, 25.00),
(36, 32, 7, 4, 1000.00),
(37, 32, 14, 3, 50.00),
(38, 32, 17, 3, 50.00),
(39, 32, 8, 2, 190.00),
(40, 32, 1, 2, 62.00),
(41, 32, 16, 1, 50.00),
(42, 32, 19, 1, 60.00),
(43, 32, 20, 2, 12.00),
(44, 32, 4, 3, 13.00),
(45, 32, 9, 3, 1300.00),
(46, 32, 10, 2, 860.00),
(47, 32, 15, 2, 200.00),
(48, 32, 6, 1, 1190.00),
(49, 32, 13, 1, 520.00);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `SupplierID` int(50) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `ContactInfo` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierID`, `SupplierName`, `Address`, `ContactInfo`) VALUES
(1, 'Sony', 'Paco, Manila', 988787600),
(2, 'Y2K', 'Tagaytay, Cavite', 975726391),
(3, 'Patrick Ice', 'Michigan, USA', 921464217),
(4, 'J&B School Supplies', 'San Mateo, Rizal', 946421741),
(5, 'Rockets', 'San Mateo, Rizal', 931405268),
(6, 'Jack & Jill', 'Mandaluyong, Metro Manila', 988787600),
(7, 'Louise', 'San Mateo, Rizal', 91100365),
(8, 'Supafly', 'Pasig, Metro Manila', 975726391);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(50) NOT NULL,
  `Roles` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(6) DEFAULT NULL COMMENT 'Stores the temporary 6-digit OTP for password resets.',
  `otp_expiry` datetime DEFAULT NULL COMMENT 'Timestamp when the OTP code expires and becomes invalid.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Roles`, `email`, `password`, `otp_code`, `otp_expiry`) VALUES
(1, 'Admin', 'lwisdompunzalan@gmail.com', '$2y$10$Jbpc7AI3o7tA4hJkAdIuLe3wdYbvVkuUVHOCKVxcnxF2v3wCn2/gW', NULL, NULL),
(2, 'Cashier', 'christian@gmail.com', '$2y$10$xy9N7oSsHzaqLDzDVelmcemAoNGWVxaAD6QJemRSlj5DIfJT.ygQK', NULL, NULL),
(3, 'Cashier', 'lumang@gmail.com', '$2y$10$1AYNkxr/BK3kbK2hEg7WKuFNc/Rc27ZEAmauROCN5sEDy/ywXU/xO', NULL, NULL),
(4, 'Cashier', 'jiar@gmail.com', '$2y$10$VD.CLp8x.Pg/qNe8QJWnUuWinScs5H8nY6ZQ54Mdez4xYFnMj/v3e', NULL, NULL),
(5, 'Staff', 'jolas@gmail.com', '$2y$10$BXxHv8yjz0a/.pMjITZlReD8gNbSk/M/tuWB/w1Um5MFkht1m7qYu', NULL, NULL),
(6, 'Staff', 'ChrisBrown@gmail.com', '$2y$10$4sKFt8XMAsenuEaDoIZZg.3qa9sTw0jDILIp22bMsEIlC68Y0kkR.', NULL, NULL),
(8, 'Admin', '2023-103325@rtu.edu.ph', '$2y$10$6HfSZsjteCWX9lWWNwBKku1LQwvr4v4jKvd.Nf9zfmudbhYAqoj2a', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD UNIQUE KEY `qr_code` (`qr_code`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`SaleID`),
  ADD KEY `sales_ibfk_1` (`CashierID`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `SaleID` (`SaleID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `SaleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `SupplierID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_supplier` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_product_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`CashierID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD CONSTRAINT `sales_items_ibfk_1` FOREIGN KEY (`SaleID`) REFERENCES `sales` (`SaleID`),
  ADD CONSTRAINT `sales_items_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
