-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2023 at 03:53 PM
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
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_cart`
--

CREATE TABLE `add_cart` (
  `user_id` varchar(30) NOT NULL,
  `p_id` char(30) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_cart`
--

INSERT INTO `add_cart` (`user_id`, `p_id`, `quantity`) VALUES
('c-202309172246530600', 'Gigabyte-10001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(35) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `pic`, `status`) VALUES
('admin-202308282307020600', 'Ruhul Amin Sharif', 'sharif@gmail.com', '123456', '2461d0a8e0d3675413c334e8be058215.jpg', 1),
('admin-202308311036520600', 'k', 'k@gmail.com', '123456', 'a7d81d37767430b38b129ee84d7d60be.jpg', 0),
('admin-202308311800420600', 'Afifa', 'afifa@gmail.com', '123456', 'ccf50b042cc5b05481647aec5fe1f915.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ptype` varchar(50) NOT NULL,
  `brand_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ptype`, `brand_name`) VALUES
('Graphics Card', 'Gigabyte'),
('Graphics Card', 'NVIDIA'),
('Graphics Card', 'Radeon'),
('Laptop', 'Acer'),
('Laptop', 'Apple'),
('Laptop', 'Asus'),
('Laptop', 'Dell'),
('Laptop', 'Hp'),
('Laptop', 'MSI'),
('Laptop', 'Toshiba'),
('Laptop', 'Walton'),
('Mobile', 'Huawei'),
('Mobile', 'iphone'),
('Mobile', 'Oppo'),
('Mobile', 'Redmi'),
('Mobile', 'Samsung'),
('Mobile', 'Vivo'),
('Processor', 'Intel'),
('Processor', 'Ryzen');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_id` varchar(30) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `status` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_id`, `first_name`, `last_name`, `email`, `password`, `address`, `mobile`, `dob`, `gender`, `pic`, `status`) VALUES
('c-202309130022540600', 'Ruhul Amin', 'Sharif', 'sharif@gmail.com', '123456', 'chittagong', '01946149577', '2001-07-28', 'male', '6ea8ee505f35d81ecb9f8026aecf8419.jpg', 1),
('c-202309162059390600', 'Shadadath Hossain', 'Sajib', 'sajib@gmail.com', '123456', 'chittagong', '01405663070', '2004-07-27', 'Male', '7f6f8a99a5c01ae71fdff16af15c3e1e.jpg', 1),
('c-202309172246530600', 'Adiba', 'Hoque', 'adiba@gmail.com', '123456', 'chittagong', '01234567', '2009-02-13', 'Female', 'cb4552dcea196c916bc35d8fd4de1fcb.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_id` varchar(30) NOT NULL,
  `cus_id` varchar(30) NOT NULL,
  `order_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`order_id`, `cus_id`, `order_date`, `status`) VALUES
('o-202309161748030200', 'c-202309162059390600', '2023-09-16', 1),
('o-202309161751320200', 'c-202309162059390600', '2023-09-16', 1),
('o-202309161752340200', 'c-202309130022540600', '2023-09-16', 1),
('o-202309171600150600', 'c-202309130022540600', '2023-09-17', 1),
('o-202309171604430600', 'c-202309130022540600', '2023-09-17', 1),
('o-202309181921400600', 'c-202309172246530600', '2023-09-18', 1),
('o-202309182259290600', 'c-202309130022540600', '2023-09-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_line`
--

CREATE TABLE `order_line` (
  `order_id` varchar(30) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `sold_quantity` int(30) NOT NULL,
  `sold_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_line`
--

INSERT INTO `order_line` (`order_id`, `product_id`, `sold_quantity`, `sold_price`) VALUES
('o-202309161748030200', 'nvidia-001', 1, 4500),
('o-202309161751320200', 'huawei-10001', 1, 10000),
('o-202309161752340200', 'radeon-002', 2, 240000),
('o-202309171600150600', 'Dell-0002', 1, 25000),
('o-202309171600150600', 'nvidia-001', 1, 4500),
('o-202309171600150600', 'Redmi-10001', 1, 18000),
('o-202309171604430600', 'nvidia-001', 1, 4500),
('o-202309181921400600', 'nvidia-001', 1, 4500),
('o-202309181921400600', 'nvidia-002', 1, 8000),
('o-202309182259290600', 'Radeon', 2, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` char(30) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `ptype` varchar(50) DEFAULT NULL,
  `brand_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `description`, `pic`, `ptype`, `brand_name`) VALUES
(' huawei-1002', 'mate-40', 'ram-16gb\r\ncolor-mate blue', '5b037b50d67f93a884877ee1598fa1a6.png', 'Mobile', 'Huawei'),
('Dell-0001', 'Dell Latitude 5290', 'Dell latitude 5290 2-in-1\r\ncore i5 8th gen laptop\r\nDell Latitude 5290 2-in-1 equipped with Intel UHD 620 graphics and a 2-megapixel HD camera. It contains 8GB of 1866 MH', 'd4a8c8a79897a7320269be41ca0aa835.jpg', 'Laptop', 'Dell'),
('Dell-0002', 'Dell xps 15', 'Key Features \r\nMPN: BERLR20011679A \r\nModel: Dell XPS 15 7590 \r\nIntel Core i7-9750H Processor (12M Cache, 2.60 GHz up to 4.50 GHz) \r\n16GB Ram + 512GB SSD \r\n15.6\' 4K UHD(3840 x 2160) IPS Display \r\nGeForce GTX', 'a0cd6d2d6eae82b6b6bf3438d2b2a4bf.jpg', 'Laptop', 'Dell'),
('Gigabyte-10001', 'Gigabyte AORUS ', 'Quick Overview\r\nGigabyte AORUS Radeon RX 6900 \r\nChipset - AMD Radeon\r\nVGA Port - No\r\nHDMI Port - 2\r\nCapacity (GB/TB) - 16GB\r\nGraphics Resolution Max. - 7680 x 4320\r\nMulti Display Capability - Quad Display', 'fc631245ab7778a7e416f5cf705c850a.webp', 'Graphics Card', 'Gigabyte'),
('Hp-1001', 'Hp 15s', 'Processor Type. - Ryzen 5\r\nGeneration - Not Applicable\r\nDisplay Size (Inch) - 15.6\r\nRAM - 8GB\r\nStorage - 512GB SSD\r\nGraphics Memory - Shared', 'c23626196bbaf8b93fb620c3f23c5fc2.jpg', 'Laptop', 'Hp'),
('huawei-10001', 'huawei y7', 'ram-8gb\r\ncolor-pastal', '8da5b94b75b09beb4f58de66902b0a62.jpg', 'Mobile', 'Huawei'),
('huawei-1102', 'huawei prime', 'ram-8gb\r\ncolor-black', 'c063cf6689580b53ff3b735591b7c1bd.png', 'Mobile', 'Huawei'),
('intel-1001', 'intel core i7', 'Intel® Core™ i3 processors, for entry-level gaming performance.', 'e1d5b81ff5350c80aa2b2b0c7ef796fc.jpg', 'Processor', 'Intel'),
('intel-1002', 'intel core i7 ', 'for mid range perfomance', 'b418c607b37ec645272275e4c1f17652.webp', 'Processor', 'Intel'),
('iphone-001', 'iphone 14 pro max', 'A15 Bionic chip\r\n6‑core CPU with 2 performance and 4 efficiency cores\r\n5‑core GPU\r\n16‑core Neural Engine', 'a2fb23e1caf9e1daef471fb9040054e8.jpg', 'Mobile', 'iphone'),
('iphone-002', 'iphone 13', 'rosegold model', 'cf9a1ca87900180d97619252aaea0892.jpg', 'Mobile', 'iphone'),
('iphone-003', 'iphone 14', 'color-pastal blue', '8be1b219648c6190dd89180897cdc44f.jpg', 'Mobile', 'iphone'),
('mac 1002', 'macbook m2', 'macbook pro 13 2.0 i5 10 gen 1tb/16gb ram', 'c8e435283427f756f90695a93cb2f7fd.jpg', 'Laptop', 'Apple'),
('mac-1001', 'mac 9765', 'macbook pro 13 2.0 i5 10 gen 1tb/16gb ram', '6bac6582762b76dc700ebac8baa2c466.jpg', 'Laptop', 'Apple'),
('nvidia-001', 'gigabyte GT 1030', 'with adjustable thermo fan', '6269c82e62046104e369c39c79c55413.jpg', 'Graphics Card', 'NVIDIA'),
('nvidia-002', 'pixels', 'more faster and robust with multi threads', 'd7612efb6d7bd34809c6b982c5a66b9b.jpg', 'Graphics Card', 'NVIDIA'),
('nvidia-003', 'getforce v3', 'new gaming and anti thermal graphics card', 'cc6fcc59f0a816129422047a38942cf0.jpg', 'Graphics Card', 'NVIDIA'),
('Radeon', 'phantom 4300', 'Clock: GPU / Memory\r\nBoost Clock: Up to 2310 MHz / 16 Gbps\r\nGame Clock: Up to 2065 MHz / 16 Gbps\r\nBase Clock: 1875 MHz / 16 Gbps', '79f24c8d7dbae6d63b94b9b42537d4da.png', 'Graphics Card', 'Radeon'),
('radeon-002', 'radeon rx 5700', ' Built on the 7 nm process, and based on the Navi 10 graphics processor, in its Navi 10 XL variant, the card supports DirectX 12. This ensures that all modern games will run on Radeon RX 5700. The Nav', 'a8f7580a6ee926be6e757a14226e26d7.jpg', 'Graphics Card', 'Radeon'),
('Redmi-10001', 'Redmi Note 8', '48MP Quad Camera All Star\r\n48MP AI quad camera\r\nQualcomm® Snapdragon™ 665', '9ab3976b9a0b53a21c2c3963e8f69745.jpg', 'Mobile', 'Redmi'),
('Toshiba-10001', 'Toshiba Dynabook Satellite', 'Toshiba Dynabook Satellite Pro \r\nC40-G-11I Core i3 10th Gen 14\" HD Laptop \r\nKey Features\r\nMPN: A1PYS27E112H\r\nModel: Dynabook Satellite Pro C40-G-11I\r\nProcessor: Intel Core i3 10110U (4MB Cache, 2.10Ghz', '8aae51da605fa74bea01751aa07bf6a2.webp', 'Laptop', 'Toshiba');

-- --------------------------------------------------------

--
-- Table structure for table `product_line`
--

CREATE TABLE `product_line` (
  `product_id` char(30) NOT NULL,
  `selling_price` double DEFAULT NULL,
  `quantity` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_line`
--

INSERT INTO `product_line` (`product_id`, `selling_price`, `quantity`) VALUES
(' huawei-1002', 18220, 2215),
('Dell-0001', 45999, 19),
('Dell-0002', 25000, 10),
('Gigabyte-10001', 168000, 111),
('Hp-1001', 73000, 71),
('huawei-10001', 10000, 9),
('huawei-1102', 15000, 15),
('intel-1001', 50000, 30),
('intel-1002', 30000, 47),
('iphone-001', 100000, 25),
('iphone-002', 100000, 10),
('iphone-003', 80000, 40),
('mac 1002', 150000, 20),
('mac-1001', 1250000, 45),
('nvidia-001', 4500, 21),
('nvidia-002', 8000, 24),
('nvidia-003', 120005, 5),
('Radeon', 50000, 23),
('radeon-002', 120000, 53),
('Redmi-10001', 18000, 19),
('Toshiba-10001', 45000, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_cart`
--
ALTER TABLE `add_cart`
  ADD PRIMARY KEY (`user_id`,`p_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ptype`,`brand_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `ptype` (`ptype`,`brand_name`);

--
-- Indexes for table `product_line`
--
ALTER TABLE `product_line`
  ADD PRIMARY KEY (`product_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_cart`
--
ALTER TABLE `add_cart`
  ADD CONSTRAINT `add_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `add_cart_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`ptype`,`brand_name`) REFERENCES `category` (`ptype`, `brand_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_line`
--
ALTER TABLE `product_line`
  ADD CONSTRAINT `product_line_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
