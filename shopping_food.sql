-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2024 at 12:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL DEFAULT '#',
  `image` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL DEFAULT 'top-banner',
  `prioty` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `name`, `link`, `image`, `description`, `position`, `prioty`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Meat', '#', 'banner_bg.png', '', 'top-banner', 0, 1, NULL, NULL),
(2, 'gallery 1', '#', 'gallery_img01.png', '', 'gallery', 1, 1, NULL, NULL),
(3, 'gallery 2', '#', 'gallery_img02.png', '', 'gallery', 2, 1, NULL, NULL),
(4, 'gallery 3', '#', 'gallery_img03.png', '', 'gallery', 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL DEFAULT '#',
  `image` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL DEFAULT 'top-banner',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `price` float(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`customer_id`, `product_id`, `price`, `quantity`) VALUES
(6, 4, 255.00, 1),
(6, 7, 100.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Thịt gà', 1, '2024-03-03 07:59:37', '2024-03-03 09:52:18'),
(2, 'Thịt bò', 1, '2024-03-03 08:03:16', '2024-03-03 09:52:09'),
(3, 'Thịt lợn', 1, '2024-03-03 08:17:26', '2024-03-03 09:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT 0,
  `password` varchar(200) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `gender`, `password`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(6, 'Nguyen Van B', 'vanhle278@gmail.com', '123456', 'Ha Noi', 1, '$2y$12$f/iZ7eVSic2bHz6XBmvriOW/QILxbSiI5kfQ/YqV5hleFwp1npQ56', '2024-02-21 17:00:00', '2024-02-20 23:31:14', '2024-02-28 10:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer_reset_tokens`
--

CREATE TABLE `customer_reset_tokens` (
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_reset_tokens`
--

INSERT INTO `customer_reset_tokens` (`email`, `token`, `created_at`, `updated_at`) VALUES
('vanhle278@gmail.com', 'r5uGNGP6SyzpTGqWBjUYDaWEacXvY936BzzQTpSx', '2024-03-03 14:20:45', '2024-03-03 14:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 6, 7, '2024-03-03 12:28:03', '2024-03-03 12:28:03'),
(2, 6, 6, '2024-03-03 12:28:11', '2024-03-03 12:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2014_10_12_000000_create_users_table', 1),
(8, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(9, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(11, '2024_02_17_162850_create_categories_table', 1),
(12, '2024_02_17_165633_create_products_table', 1),
(13, '2024_02_17_183405_create_product_images_table', 1),
(14, '2024_02_18_154826_create_banners_table', 1),
(15, '2024_02_18_155536_create_blogs_table', 1),
(16, '2024_02_18_155649_create_customers_table', 1),
(17, '2024_02_18_160105_create_customer_reset_tokens_table', 1),
(18, '2024_02_18_160842_create_comments_table', 1),
(19, '2024_02_18_161313_create_favorites_table', 1),
(20, '2024_02_18_161424_create_orders_table', 1),
(21, '2024_02_18_161844_create_order_details_table', 1),
(22, '2024_02_29_153105_create_carts_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `address`, `token`, `customer_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Nguyen Van B', 'vanhle278@gmail.com', '123456', 'Ha Noi', NULL, 6, '2024-03-03 13:15:07', '2024-03-03 13:16:06', 1),
(2, 'Nguyen Van B', 'vanhle278@gmail.com', '123456', 'Ha Noi', NULL, 6, '2024-03-03 13:56:43', '2024-03-03 13:57:04', 1),
(3, 'Nguyen Van B', 'vanhle278@gmail.com', '123456', 'Ha Noi', 'yyIB8VgjIwgwA25gHYvKYtJAoaW5S85dxnSq3cFd', 6, '2024-03-03 14:18:56', '2024-03-03 14:18:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 4, 1, 255.00),
(1, 7, 1, 100.00),
(2, 4, 1, 255.00),
(2, 7, 1, 100.00),
(3, 4, 1, 255.00),
(3, 7, 1, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` float(10,2) NOT NULL,
  `sale_price` float(10,2) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `sale_price`, `category_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Đùi gà - 300 grams', 'JyIvBXkYlf5xEmMSEBpXnKWpSsAwLIR5x2ILS23I.png', 300.00, 200.00, 1, 'Là thịt được lấy ra từ cơ đùi của con gà. Phần thịt này có một đặc trưng khác những phần thịt khác trong cơ thể con gà là khi ăn có chút sần sật, có chút giai giòn vô cùng đặc trưng. Loại thịt này có vị ngọt rất đậm đà, hương thơm hấp dẫn lôi cuốn khiến chỉ cần ngửi thấy mùi thôi là đã muốn ăn ngay.', 1, '2024-03-03 10:05:11', '2024-03-03 10:41:56'),
(3, 'Ba chỉ lợn - 500 grams', 'VAdJ5PeH8d9yoUMV8WnCWAU07ZF3yclO2wG9naik.png', 455.00, 345.00, 3, 'Loại thịt ngon nhất của lợn. Có cả nạc và mỡ.', 1, '2024-03-03 10:11:11', '2024-03-03 10:42:12'),
(4, 'Bò miếng - 300 grams', 'GXtOWZWB9b74tUXv0nxDaEpZHud5FohdDTEiEIm2.jpg', 300.00, 255.00, 2, 'Là thịt được lấy ra từ cơ đùi của con bò. Phần thịt này có một đặc trưng khác những phần thịt khác trong cơ thể con bò là khi ăn có chút sần sật, có chút giai dòn vô cùng đặc trưng.', 1, '2024-03-03 10:25:20', '2024-03-03 10:42:24'),
(5, 'Bò nướng miếng - 300 grams', 'jiI7MIv9dntIdpew4TOrPRSnQEjjgpOkcljSZIKX.png', 230.00, 220.00, 2, 'Là thịt được lấy ra từ cơ đùi của con bò. Phần thịt này có một đặc trưng khác những phần thịt khác trong cơ thể con bò là khi ăn có chút sần sật, có chút giai giòn vô cùng đặc trưng.', 1, '2024-03-03 10:29:27', '2024-03-03 10:42:34'),
(6, 'Nội tạng gà - 200 grams', 'wk1SBPg8ZLZPoLds6SFXZqjuvdowW6C3prn76s3B.png', 250.00, 150.00, 1, 'Là thịt được lấy ra từ cơ đùi của con bò. Phần thịt này có một đặc trưng khác những phần thịt khác trong cơ thể con bò là khi ăn có chút sần sật, có chút giai dòn vô cùng đặc trưng.', 1, '2024-03-03 10:31:02', '2024-03-03 10:42:43'),
(7, 'Thịt lợn xay - 300 grams', 'JwE5C3GLIwdNuR9xElR4I9WtjS4ph18Mza6VD7ng.png', 300.00, 100.00, 3, 'Là thịt được lấy ra từ cơ đùi của con bò. Phần thịt này có một đặc trưng khác những phần thịt khác trong cơ thể con bò là khi ăn có chút sần sật, có chút giai dòn vô cùng đặc trưng.', 1, '2024-03-03 10:33:26', '2024-03-03 10:42:51'),
(8, 'Ức gà - 500 grams', 'I9yVsVbDXLlMxaQxMP5uKe1svNpdsBiWp6BwDYon.png', 100.00, 80.00, 1, 'Là thịt được lấy ra từ cơ đùi của con bò. Phần thịt này có một đặc trưng khác những phần thịt khác trong cơ thể con bò là khi ăn có chút sần sật, có chút giai dòn vô cùng đặc trưng.', 1, '2024-03-03 10:34:29', '2024-03-03 10:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(100) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tk41esmWCKQE6zKxdkQsAOlnNsxLgAjUc3lSkfg4.jpg', 2, 0, '2024-03-03 10:05:11', '2024-03-03 10:05:11'),
(2, 'MPKoQmC6DZnWByaRgZuk1DgccGRTby8e2DuNSARJ.jpg', 2, 0, '2024-03-03 10:05:11', '2024-03-03 10:05:11'),
(3, 'I78TKAhWxKvNo8qsMVgrfNIf9liO5PEKsDpNYsx8.jpg', 2, 0, '2024-03-03 10:05:11', '2024-03-03 10:05:11'),
(4, 'pQ3C97YpZttWN0fp9A0tWd3TgvevBsN3Dcabuxjv.png', 2, 0, '2024-03-03 10:05:11', '2024-03-03 10:05:11'),
(5, '7KXfg1pAgNb33OAsOKcUYLj7rbbLab6hAWuLkXYL.jpg', 3, 0, '2024-03-03 10:11:11', '2024-03-03 10:11:11'),
(6, 'BvAvf2Irwlr22ySdy5L79rQRy4uZKjcFdWqGyPVW.jpg', 3, 0, '2024-03-03 10:11:11', '2024-03-03 10:11:11'),
(7, 'T1FxIVEhOd1tvXINU51Xsz7vs5aSJPdxfkAwTG3f.png', 3, 0, '2024-03-03 10:11:11', '2024-03-03 10:11:11'),
(8, '1xwFatWgVIi27mc1Gbl05LQvP0h8yJGnx6O8szoO.png', 4, 0, '2024-03-03 10:25:20', '2024-03-03 10:25:20'),
(9, 'PBFnBqM8XoykdAhgl6frlF0GyF8mEloD20jbViTN.png', 4, 0, '2024-03-03 10:25:20', '2024-03-03 10:25:20'),
(10, '0cDH9AQI1ZbzTHTNGQyysAjZvyFgpQLQ2fwdyQMW.png', 5, 0, '2024-03-03 10:29:27', '2024-03-03 10:29:27'),
(11, 'A3ghhn5MIc5CmHK5OMj6utUHs6cMvgfGZEayRrMP.png', 5, 0, '2024-03-03 10:29:27', '2024-03-03 10:29:27'),
(12, '3doHgsFeoid0r7gV2yN3xl0XYGnUgFzjIfmVy9dg.png', 6, 0, '2024-03-03 10:31:02', '2024-03-03 10:31:02'),
(13, 'vc46oaiUIeF2NcNgnKDN9tVh0hktMIuh0OprvUiU.png', 6, 0, '2024-03-03 10:31:02', '2024-03-03 10:31:02'),
(14, 'ZQl1POhDQsGFkNfCmmAHVHzaiwukD879n4DkL5ve.png', 6, 0, '2024-03-03 10:31:02', '2024-03-03 10:31:02'),
(15, 'LSMYZIw04bE9ZmUPhO9p0cxX7wgLeTSNwRN6K1fY.png', 7, 0, '2024-03-03 10:33:26', '2024-03-03 10:33:26'),
(16, 'zQhvGKARttI0K11QheZruD7yy70QAzViXCddJXOD.png', 7, 0, '2024-03-03 10:33:26', '2024-03-03 10:33:26'),
(17, 'ak9m3kY2EIz2NJUVclauElcrPXQ57GnlzBLTPMK7.jpg', 8, 0, '2024-03-03 10:34:29', '2024-03-03 10:34:29'),
(18, 'kf8gr1t0Kwfl7CS3QQP7hmvuXKgjHn442vLlThu2.jpg', 8, 0, '2024-03-03 10:34:29', '2024-03-03 10:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Manager', 'admin@gmail.com', '$2y$12$pecP.tAjglMTOomVoLNY.eX6I6vtg7SIqBRCmVLTMfViY8UDjBfXq', NULL, NULL, '2024-02-23 11:40:16', '2024-02-23 11:40:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banners_name_unique` (`name`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_name_unique` (`name`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`customer_id`,`product_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_customer_id_foreign` (`customer_id`),
  ADD KEY `comments_product_id_foreign` (`product_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `customer_reset_tokens`
--
ALTER TABLE `customer_reset_tokens`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `customer_reset_tokens_token_unique` (`token`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_customer_id_foreign` (`customer_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_email_unique` (`email`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
