-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2019 at 12:05 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `dateval` date NOT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `emp_id`, `dateval`, `in_time`, `out_time`) VALUES
(1, 1, '2019-05-02', '10:05:00', '13:17:00'),
(2, 1, '2019-05-02', '14:10:00', '15:30:00'),
(3, 1, '2019-05-02', '16:10:00', '19:20:00'),
(4, 1, '2019-05-03', '10:15:00', '11:11:18'),
(5, 1, '2019-05-03', '11:20:07', '12:10:24'),
(6, 1, '2019-05-03', '12:21:26', '13:45:18'),
(7, 1, '2019-05-03', '14:45:23', '16:18:36'),
(8, 1, '2019-05-03', '16:30:12', '18:45:14'),
(9, 1, '2019-05-06', '10:35:10', '11:15:36'),
(10, 1, '2019-05-06', '11:21:28', '12:40:18'),
(11, 1, '2019-05-06', '12:49:21', '14:05:34'),
(12, 1, '2019-05-06', '15:05:32', '16:10:45'),
(13, 1, '2019-05-06', '16:25:18', '17:30:17'),
(14, 1, '2019-05-06', '17:45:31', '19:05:40'),
(15, 2, '2019-05-04', '12:30:16', '18:30:11'),
(16, 2, '2019-05-03', '09:44:14', '19:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`) VALUES
(1, 'India'),
(2, 'Sri Lanka'),
(3, 'Bangladesh');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `emp_email` varchar(100) NOT NULL,
  `emp_phone` varchar(50) NOT NULL,
  `emp_salary` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_name`, `emp_email`, `emp_phone`, `emp_salary`) VALUES
(1, 'Manojit Nandi', 'manojit87@gmail.com', '9230459769', 7000),
(2, 'Doyeta Chakrovarty', 'doyeta.piyali@gmail.com', '9903772144', 5000),
(3, 'Anusua Putatunda', 'anu.csc@gmail.com', '9007175423', 10000),
(4, 'Rahul', 'rahul@gmail.com', '9123409786', 7000);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `img_name`, `created`) VALUES
(1, '1561208055.jpg', '2019-06-22 12:54:15'),
(2, '7190.jpg', '2019-06-22 13:03:53'),
(3, '3027.jpg', '2019-06-22 13:04:57'),
(4, '4933.jpg', '2019-06-22 13:04:57'),
(5, '4772.jpg', '2019-06-22 13:07:45'),
(6, '1823.jpg', '2019-06-22 13:07:46'),
(7, '7987.jpg', '2019-06-22 13:07:46'),
(8, '5572.jpg', '2019-06-22 13:07:46'),
(12, '7193.jpg', '2019-06-22 13:11:27'),
(13, '2570.jpg', '2019-06-22 13:11:27'),
(14, '490.jpg', '2019-06-23 07:23:06'),
(15, '7874.jpg', '2019-06-23 08:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_11_28_114148_create_posts_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created`, `modified`) VALUES
(1, 'First Post', 'lorem ipsum is the dummy text.\nlorem ipsum is the dummy text.\nlorem ipsum is the dummy text.\nlorem ipsum is the dummy text.', '2019-01-01 06:29:39', '2019-06-21 12:36:38'),
(2, 'My experiment with laravel', 'laravel is a nice framework.', '2019-01-01 06:32:29', '2019-01-01 06:50:51'),
(4, 'Fresh Post', 'lorem ipsum is the dummy text', '2019-01-01 12:32:46', '2019-01-01 12:32:46'),
(5, 'Laravel is most popular framework in web development', 'lorem ipsum is the dummy text', '2019-01-01 14:51:00', '2019-01-01 15:51:10'),
(6, 'Codeigniter is a very beautiful framework', 'We can achieve everything through codeigniter.', '2019-01-02 13:02:45', '2019-06-20 16:32:29'),
(12, 'Hi', 'Hello AngularJS.', '2019-06-19 14:08:02', '2019-06-20 16:34:48'),
(18, 'AngularJS', 'Angularjs is a nicely developed js library.', '2019-06-19 15:09:00', '2019-06-19 18:39:00'),
(19, 'AngularJS', 'My Experiment with angularjs.', '2019-06-19 15:47:32', '2019-06-19 19:17:32'),
(20, 'Jquery', 'Jquery is better than angularjs.', '2019-06-19 15:48:08', '2019-06-19 19:18:08'),
(21, 'ReactJS', 'No idea about reactjs.', '2019-06-19 15:48:37', '2019-06-19 19:18:37'),
(22, 'Node js vs PHP', 'PHP 7 is far better than nodejs.', '2019-06-19 15:49:53', '2019-06-19 19:19:53'),
(23, 'Modern web development', 'Javascript is the backbone of modern web development.', '2019-06-19 19:21:39', '2019-06-19 19:21:39'),
(24, 'Angularjs has few faults.', 'HTTP post request in angularjs nor working properly.', '2019-06-20 12:36:42', '2019-06-20 16:37:10'),
(25, 'Hello', 'Testing', '2019-06-20 12:46:02', '2019-06-20 12:46:02'),
(26, 'AngularJS is fun', 'Love you angular.', '2019-06-20 13:54:27', '2019-06-20 16:28:12'),
(27, 'PHP with AngularJS is fun.', 'WBlesson is a nice tutorial website. It teaches angularjs with PHP very nicely.', '2019-06-20 16:31:58', '2019-06-20 16:37:59'),
(28, 'Alert not working', 'Need to check.Try to fix it.', '2019-06-20 16:38:42', '2019-06-23 17:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `details` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1 for active 0 for inactive',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `product_image`, `status`, `created`, `modified`) VALUES
(1, 'Samsung Galaxy J5', 'This is an awesome smartphone', 130, '1546608455.jpg', '1', '2019-01-04 18:57:35', '2019-01-04 18:57:35'),
(2, 'Samsung Galaxy S5', 'This is another smartphone', 140, '1546609150.jpg', '1', '2019-01-04 19:09:10', '2019-01-04 19:09:10'),
(3, 'Samsung Galaxy S7', 'This is a great smartphone', 115, '1546609456.jpg', '1', '2019-01-04 19:14:16', '2019-01-04 19:14:16'),
(4, 'Micromax Canvas 6', 'lorem ipsum is the dummy text', 100, '1546609603.jpg', '1', '2019-01-04 19:16:43', '2019-01-04 19:16:43'),
(5, 'Micromax Nitro 3', 'A micromax smartphone', 100, '1546610346.jpg', '1', '2019-01-04 19:29:07', '2019-01-09 13:18:28'),
(6, 'Oppo smartphone', 'lorem ipsum is the dummy text', 170, '1546613797.jpg', '1', '2019-01-04 20:26:37', '2019-03-16 19:59:40'),
(7, 'Vivo V5 Smartphone', 'This is a vivo smartphone', 165, '1552747300.jpg', '1', '2019-01-04 20:29:22', '2019-03-16 20:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `country_id`, `state_name`) VALUES
(1, 1, 'West Bengal'),
(2, 1, 'Kerala'),
(3, 1, 'Gujrat'),
(4, 1, 'Assam'),
(5, 3, 'Dhaka'),
(6, 3, 'Khulna'),
(7, 3, 'Chitagang'),
(8, 2, 'Colombo'),
(9, 2, 'Candy');

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL COMMENT 'The unique session id for any customer',
  `item_id` int(11) NOT NULL COMMENT 'The id of product',
  `item_quantity` int(11) NOT NULL COMMENT 'Number of quantity added',
  `item_price` int(11) NOT NULL COMMENT 'instant price for item',
  `created` bigint(20) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcart`
--

INSERT INTO `tblcart` (`id`, `unique_id`, `item_id`, `item_quantity`, `item_price`, `created`, `modified`) VALUES
(5, 'eea2qpthfqje1abv5scmrrka6q', 2, 1, 140, 1561789420, '2019-06-29 06:23:40'),
(7, 'eea2qpthfqje1abv5scmrrka6q', 4, 1, 100, 1561791241, '2019-06-29 06:54:01'),
(8, 'eea2qpthfqje1abv5scmrrka6q', 5, 1, 100, 1561800378, '2019-06-29 09:26:18'),
(13, '1561801282_9437149', 1, 1, 130, 1561801282, '2019-06-29 09:41:22'),
(14, '1561801282_9437149', 7, 1, 165, 1561801301, '2019-06-29 09:41:41'),
(16, '1561801498_349220', 5, 1, 100, 1561801498, '2019-06-29 09:44:58'),
(17, '1561801498_349220', 2, 1, 140, 1561801507, '2019-06-29 09:45:07'),
(20, '1561801623_8054856', 6, 1, 170, 1561801959, '2019-06-29 09:52:39'),
(21, '1561801623_8054856', 1, 1, 130, 1561801963, '2019-06-29 09:52:43'),
(22, '1561801623_8054856', 3, 1, 115, 1561801967, '2019-06-29 09:52:47'),
(23, '1561803774_8793574', 1, 1, 130, 1561803774, '2019-06-29 10:22:54'),
(24, '1561803938_6258441', 4, 1, 100, 1561803938, '2019-06-29 10:25:38'),
(25, '1561804526_1064495', 7, 1, 165, 1561804526, '2019-06-29 10:35:26'),
(27, '1561804583_4674706', 1, 1, 130, 1561804638, '2019-06-29 10:37:18'),
(28, '1561804583_4674706', 7, 1, 165, 1561804644, '2019-06-29 10:37:24'),
(29, '1561804583_4674706', 3, 1, 115, 1561804650, '2019-06-29 10:37:30'),
(30, '1561804583_4674706', 2, 1, 140, 1561804655, '2019-06-29 10:37:35'),
(31, '1561806274_5525339', 2, 1, 140, 1561806274, '2019-06-29 11:04:34'),
(32, '1561806635_2724546', 5, 1, 100, 1561806635, '2019-06-29 11:10:35'),
(33, '1561966724_2539034', 1, 1, 130, 1561966724, '2019-07-01 07:38:44'),
(34, '1561966724_2539034', 6, 1, 170, 1561966734, '2019-07-01 07:38:54'),
(35, '1561967534_2276440', 5, 1, 100, 1561967534, '2019-07-01 07:52:14'),
(36, '1561976526_4160469', 1, 1, 130, 1561976526, '2019-07-01 10:22:06'),
(37, '1561976526_4160469', 6, 1, 170, 1561976536, '2019-07-01 10:22:16'),
(38, '1561977012_2684746', 4, 1, 100, 1561977012, '2019-07-01 10:30:12'),
(39, '1561982107_7550068', 1, 1, 130, 1561982107, '2019-07-01 11:55:07'),
(40, '1561982107_7550068', 6, 1, 170, 1561982124, '2019-07-01 11:55:24'),
(41, '1562046285_2532204', 1, 1, 130, 1562046285, '2019-07-02 05:44:45'),
(44, '1562135850_8540692', 2, 1, 140, 1562140514, '2019-07-03 07:55:14'),
(45, '1562135850_8540692', 7, 1, 165, 1562140527, '2019-07-03 07:55:27'),
(46, '1562140797_5267286', 1, 1, 130, 1562140797, '2019-07-03 07:59:57'),
(47, '1562141432_2648642', 4, 1, 100, 1562141432, '2019-07-03 08:10:32'),
(48, '1562141432_2648642', 6, 1, 170, 1562141637, '2019-07-03 08:13:57'),
(49, '1562141976_6065933', 4, 1, 100, 1562141976, '2019-07-03 08:19:36'),
(50, '1562141976_6065933', 1, 1, 130, 1562141982, '2019-07-03 08:19:42'),
(51, '1562141976_6065933', 6, 1, 170, 1562141988, '2019-07-03 08:19:48'),
(54, '1562143859_5895242', 1, 1, 130, 1562144112, '2019-07-03 08:55:12'),
(55, '1562143859_5895242', 5, 1, 100, 1562144119, '2019-07-03 08:55:19'),
(56, '1562147615_147789', 1, 1, 130, 1562147615, '2019-07-03 09:53:35'),
(57, '1562147615_147789', 3, 1, 115, 1562147734, '2019-07-03 09:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `order_id` int(11) NOT NULL,
  `order_unique_id` varchar(255) NOT NULL COMMENT 'The unique session id for any order',
  `order_amt` decimal(12,2) NOT NULL,
  `order_currency` varchar(50) NOT NULL,
  `order_cust_id` int(11) DEFAULT NULL,
  `order_time` datetime NOT NULL,
  `paid_status` enum('1','0') NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`order_id`, `order_unique_id`, `order_amt`, `order_currency`, `order_cust_id`, `order_time`, `paid_status`, `modified`) VALUES
(5, 'eea2qpthfqje1abv5scmrrka6q', '240.00', 'USD', 2147483647, '2019-06-29 14:51:25', '1', '2019-06-29 09:21:25'),
(7, '1561801282_9437149', '295.00', 'USD', 2147483647, '2019-06-29 15:12:58', '1', '2019-06-29 09:42:58'),
(8, '1561801498_349220', '240.00', 'USD', 2147483647, '2019-06-29 15:16:18', '1', '2019-06-29 09:46:18'),
(9, '1561801623_8054856', '415.00', 'USD', 2147483647, '2019-06-29 15:23:26', '1', '2019-06-29 09:53:26'),
(10, '1561803774_8793574', '130.00', 'USD', 2147483647, '2019-06-29 15:54:13', '1', '2019-06-29 10:24:13'),
(11, '1561803938_6258441', '100.00', 'USD', 2147483647, '2019-06-29 15:56:38', '1', '2019-06-29 10:26:38'),
(12, '1561804526_1064495', '165.00', 'USD', 2147483647, '2019-06-29 16:06:07', '1', '2019-06-29 10:36:07'),
(13, '1561804583_4674706', '550.00', 'USD', 2147483647, '2019-06-29 16:09:02', '1', '2019-06-29 10:39:02'),
(14, '1561806274_5525339', '140.00', 'USD', 2147483647, '2019-06-29 16:36:44', '1', '2019-06-29 11:06:44'),
(15, '1561806635_2724546', '100.00', 'USD', 2147483647, '2019-06-29 16:41:44', '1', '2019-06-29 11:11:44'),
(16, '1561966724_2539034', '300.00', 'USD', 2147483647, '2019-07-01 13:12:00', '1', '2019-07-01 07:42:00'),
(17, '1561967534_2276440', '100.00', 'USD', 2147483647, '2019-07-01 13:23:01', '1', '2019-07-01 07:53:01'),
(18, '1561976526_4160469', '300.00', 'USD', 2147483647, '2019-07-01 15:53:56', '1', '2019-07-01 10:23:56'),
(19, '1561977012_2684746', '100.00', 'USD', 2147483647, '2019-07-01 16:01:01', '1', '2019-07-01 10:31:01'),
(20, '1561982107_7550068', '300.00', 'USD', 0, '2019-07-01 17:27:36', '1', '2019-07-01 11:57:36'),
(21, '1562046285_2532204', '130.00', 'USD', 2147483647, '2019-07-02 15:02:05', '1', '2019-07-02 09:32:05'),
(22, '1562141432_2648642', '270.00', 'USD', NULL, '2019-07-03 13:46:17', '1', '2019-07-03 08:16:17'),
(23, '1562141976_6065933', '400.00', 'USD', NULL, '2019-07-03 14:11:07', '1', '2019-07-03 08:41:07'),
(24, '1562143859_5895242', '230.00', 'USD', NULL, '2019-07-03 14:26:48', '1', '2019-07-03 08:56:48'),
(25, '1562147615_147789', '245.00', 'USD', NULL, '2019-07-03 15:26:36', '1', '2019-07-03 09:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `tblpayments`
--

CREATE TABLE `tblpayments` (
  `id` int(11) NOT NULL,
  `txn_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_gross` decimal(12,2) NOT NULL,
  `currency_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `payer_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payer_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payer_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payer_country` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblpayments`
--

INSERT INTO `tblpayments` (`id`, `txn_id`, `order_id`, `payment_gross`, `currency_code`, `payer_id`, `payer_name`, `payer_email`, `payer_country`, `payment_status`, `created`) VALUES
(1, 'PAYID-LULSSDQ04N3131809503544A', 5, '240.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 09:21:25'),
(2, 'PAYID-LULTASY1MH4559724496550S', 6, '170.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 09:34:36'),
(3, 'PAYID-LULTEXI1SS54443EH853113D', 7, '295.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 09:42:58'),
(4, 'PAYID-LULTGKA7T243972WP218461U', 8, '240.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 09:46:19'),
(5, 'PAYID-LULTJ6I2S664552BH331893E', 9, '415.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 09:53:26'),
(6, 'PAYID-LULTYBQ19M38822MV300301U', 10, '130.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 10:24:13'),
(7, 'PAYID-LULTZKA16104602MN2540341', 11, '100.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 10:26:39'),
(8, 'PAYID-LULT55I3YT384375L556544U', 12, '165.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 10:36:07'),
(9, 'PAYID-LULT67Q0G987918UJ727781V', 13, '550.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 10:39:02'),
(10, 'PAYID-LULUL5A9WE00225XC4047713', 14, '140.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 11:06:44'),
(11, 'PAYID-LULUONQ3R453908PE869264H', 15, '100.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-06-29 11:11:45'),
(12, 'PAYID-LUM3SBA8K496263P7275870R', 16, '300.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-07-01 07:42:00'),
(13, 'PAYID-LUM3XNQ7MB43466UF898830P', 17, '100.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-07-01 07:53:02'),
(14, 'PAYID-LUM554Y7U081585SV898534E', 18, '300.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-07-01 10:23:56'),
(15, 'PAYID-LUM6BPI3F395151686452822', 19, '100.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-07-01 10:31:01'),
(16, 'PAYID-LUM7JQQ3HS463479L432420R', 20, '300.00', 'USD', 'PXHNE8UWU9JRE', 'Manojit Nandi', 'manojit.kgec.it@gmail.com', 'US', 'approved', '2019-07-01 11:57:36'),
(17, 'PAYID-LUNSITQ9EE99450SM9415020', 21, '130.00', 'USD', '7E9VPNWPB4JFU', 'Manojit Nandi', 'manojit87@gmail.com', 'US', 'approved', '2019-07-02 09:32:05'),
(18, '5M993119A34900016', 0, '305.00', 'USD', NULL, NULL, NULL, NULL, NULL, '2019-07-03 07:56:51'),
(19, '7D898516C0128072D', 0, '130.00', 'USD', NULL, NULL, NULL, NULL, 'Pending', '2019-07-03 08:00:38'),
(20, '72E52195M2929893X', 22, '270.00', 'USD', NULL, NULL, NULL, NULL, 'Pending', '2019-07-03 08:16:17'),
(21, '4KB00350JF874813H', 23, '400.00', 'USD', NULL, NULL, NULL, NULL, 'Pending', '2019-07-03 08:41:07'),
(22, '1T299433EK0816044', 24, '230.00', 'USD', NULL, NULL, NULL, NULL, 'Completed', '2019-07-03 08:56:48'),
(23, '28D2500553465243P', 25, '245.00', 'USD', NULL, NULL, NULL, NULL, 'Completed', '2019-07-03 09:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `u_status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 for active user 0 for inactive user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `u_status`) VALUES
(1, 'Manojit Nandi', 'manojit87@gmail.com', NULL, '$2y$10$Klwm3wZBv/.Ys3F82OSWR.hmHvR/x4hk9ml/GtoVS.1etEq1mjA86', 'IgUYkZnBShZ9MhD34Kr86KwwyytQEeQIAaosnthrJ0RIjld9FQHz4X0vmgMv', '2019-01-11 07:51:49', '2019-01-11 07:51:49', '1'),
(2, 'Manojit Nandi', 'mnbl87@gmail.com', NULL, '$2y$10$q0/SI580wBhPtKKJQopwae5Ql.dnk56FCWy0H7wDPMEAnI8IsfgOG', 'swbNrD4ydI1qa74KIdDSev2Y7s35IYMq7rKoKBqSumBhDzaSwhBjiIyLuzZx', '2019-01-11 11:07:09', '2019-01-11 11:07:09', '1'),
(3, 'Doyeta Chakrovarty', 'doyeta.piyali@gmail.com', NULL, '$2y$10$stg8ppOlT/QxrfOIaVuTWObNYSUTYjFvf1gWFEKhMF45q5YMa0HBe', 'QwQCQAQKZX8hkqYdMhsS37ru8RMChbXjVAr4rXE8m2K2iCWfMQq8QvRqAUUb', '2019-01-11 13:11:39', '2019-01-11 13:11:39', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tblpayments`
--
ALTER TABLE `tblpayments`
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
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblpayments`
--
ALTER TABLE `tblpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
