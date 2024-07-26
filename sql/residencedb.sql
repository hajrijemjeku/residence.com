-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
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
-- Database: `residencedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `residence`
--

CREATE TABLE `residence` (
  `id` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `street` varchar(100) NOT NULL,
  `squaremeters` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `price` float NOT NULL,
  `tel` varchar(100) NOT NULL,
  `image` varchar(250) NOT NULL DEFAULT 'no-image.jpg',
  `userid` int(11) NOT NULL,
  `status` enum('Me Qira','Ne Shitje') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residence`
--

INSERT INTO `residence` (`id`, `typeid`, `title`, `description`, `neighborhood`, `city`, `street`, `squaremeters`, `rooms`, `price`, `tel`, `image`, `userid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Shtepi ne shitje', 'Shtepia eshte ne shitje me super cmim', 'Kalabri', 'Prishtine', 'Xhafer Gashi nr 120', 110, 7, 105000, '049123456', '1.jpg', 2, 'Ne Shitje', '2024-07-03 17:09:41', '2024-07-17 23:53:14'),
(2, 2, 'Banese me qira', 'Banesa me qira ne kat te dyte me pamje nga parku!', 'Mati 1', 'Prishtine', 'Jakov Xoxa', 70, 3, 300, '044556677', '12.jpg', 3, 'Me Qira', '2024-07-03 18:41:59', '2024-07-18 00:24:27'),
(3, 1, 'Shtepia me Qira!', 'Shtepia me Qira, afer shkolles \'Mihail Grameno\' ...', 'Dardania', 'Fushe Kosove', 'Dardania', 98, 4, 500, '048475578', '4.jpg', 4, 'Me Qira', '2024-07-03 19:07:59', '2024-07-17 23:53:14'),
(4, 1, 'Shtepia ne shitje!', 'Ne Velani, shtepia ne shitje, 3 kateshe!', 'Velani', 'Prishtine', 'Xhemail Berisha', 111, 8, 160000, '043258963', '2.jpg', 8, 'Ne Shitje', '2024-07-06 23:30:06', '2024-07-18 22:10:22'),
(10, 2, 'Banesa me qira!', 'Banese me qira, kati 4!', 'Bregu Diellit', 'Prishtine', 'Abdyl Frasheri', 92, 4, 400, '123456789', '7.jpg', 10, 'Me Qira', '2024-07-10 12:51:18', '2024-07-17 23:53:14'),
(14, 2, 'Banesa ne shitje!', 'Banese, kati i dyte, afer shkolles \'Hajdar Dushi\'.', 'Qarshia Vjeter', 'Gjakove', 'Sami Frasheri', 100, 4, 75000, '1234567', '8.jpg', 4, 'Ne Shitje', '2024-07-10 19:54:23', '2024-07-17 23:53:14'),
(21, 1, 'Shtepia ne Shitje', 'Shtepia ne Shitje, 2 kateshe!', 'Arberia', 'Gjilan', '28 Nentori', 96, 4, 80000, '22222222', '17215999803.jpg', 4, 'Ne Shitje', '2024-07-12 17:11:11', '2024-07-21 22:13:00'),
(24, 1, 'Shtepi me Qira', 'Shtepi me Qira afer stacionit te trenit', 'Peja Hill', 'Peja', 'Agim Ramadani', 99, 4, 600, '044526942', '11.jpg', 3, 'Me Qira', '2024-07-18 00:11:38', '2024-07-18 00:22:51'),
(30, 2, 'Banesa ne shitje!', 'Banesa ne Shitje ne katin e 6, Gjakove!', 'Qarshia', 'Gjakove', 'Hajdar Dushi', 78, 3, 77400, '043658462', '172167560519.jpg', 8, 'Ne Shitje', '2024-07-20 15:46:23', '2024-07-22 19:13:25'),
(32, 2, 'Banese me Qira!', 'Banese me qira ne qender te qytetit te Prizrenit! Kati 4.', 'Shadervani', 'Prizren', '17 Shkurti', 98, 4, 350, '043445782', '172159992120.jpg', 8, 'Me Qira', '2024-07-20 15:51:28', '2024-07-21 22:12:01'),
(38, 1, 'Shtepia ne Shitje', 'Shtepi ne Shitje, 3 kateshe, me podrum!', 'Lagjja e Re', 'Kamenice', 'Rexhep Mala', 120, 6, 78600, '049826419', '172159990216.jpg', 8, 'Ne Shitje', '2024-07-21 19:22:02', '2024-07-21 22:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `residence_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `residence_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 2, 4, 'lorem', '2024-07-05 16:03:20'),
(2, 2, 3, 5, 'test', '2024-07-05 16:03:20'),
(3, 3, 4, 5, '5 stars rating', '2024-07-12 22:14:53'),
(12, 21, 4, 5, 'test', '2024-07-13 12:44:51'),
(14, 1, 4, 4, 'testest', '2024-07-13 12:50:36'),
(15, 1, 4, 1, 'residenca me id 10, review i pare nga t@t.t (user me id 4)', '2024-07-13 12:51:56'),
(18, 1, 4, 4, 'prap', '2024-07-13 12:54:08'),
(27, 1, 4, 5, '21 id e residences', '2024-07-13 14:13:03'),
(31, 4, 4, 4, '4', '2024-07-13 15:38:58'),
(33, 3, 4, 3, 'per 3', '2024-07-13 15:41:38'),
(34, 1, 4, 1, 'pwe 1', '2024-07-13 15:42:05'),
(41, 1, 4, 1, 'per1', '2024-07-13 16:06:02'),
(42, 1, 4, 4, '4', '2024-07-13 16:08:59'),
(44, 1, 4, 5, '5', '2024-07-13 16:14:19'),
(46, 1, 4, 3, '3', '2024-07-13 16:17:17'),
(48, 1, 4, 4, '4 per 4', '2024-07-13 16:20:09'),
(49, 21, 4, 1, '1 per 21', '2024-07-13 16:24:36'),
(50, 21, 4, 5, 'fort mire', '2024-07-13 17:37:32'),
(51, 21, 4, 4, 'per 14', '2024-07-13 17:38:48'),
(53, 4, 4, 4, '4444444444', '2024-07-13 17:45:22'),
(54, 2, 4, 2, '2 per 2', '2024-07-13 17:45:47'),
(55, 14, 4, 4, 'qekjo 14', '2024-07-13 17:46:19'),
(58, 1, 4, 1, '1', '2024-07-13 17:56:40'),
(59, 14, 4, 4, 'prej index per 14', '2024-07-13 17:57:33'),
(66, 21, 10, 5, 'prej random user', '2024-07-13 18:17:08'),
(70, 24, 4, 4, '8/10', '2024-07-20 11:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`) VALUES
(1, 't@t.t', '2024-07-21 14:07:28'),
(3, 't@t.tt', '2024-07-21 14:07:28'),
(4, 'tt@t.t', '2024-07-21 14:07:28'),
(5, 'hm@hm.hm', '2024-07-21 14:07:28'),
(6, 'b@a.c', '2024-07-21 14:07:28'),
(8, 'b@a.cc', '2024-07-21 14:07:28'),
(10, 'hm@h.m', '2024-07-21 14:07:28'),
(12, 'a@b.c', '2024-07-21 14:07:28'),
(21, '1@a.a', '2024-07-21 14:07:28'),
(28, 'a@b.c', '2024-07-21 14:07:28'),
(44, 'e@e.f', '2024-07-21 18:10:41'),
(45, 'test@test.test', '2024-07-21 18:34:40'),
(46, 'b@b.b', '2024-07-21 18:35:14'),
(47, 'd@d.d', '2024-07-21 18:36:11'),
(48, 'b@a.cd', '2024-07-21 18:36:45'),
(49, 't@t.ted', '2024-07-21 18:37:40'),
(50, 't@t.te', '2024-07-21 18:39:00'),
(51, 'a@b.cwe', '2024-07-21 18:39:15'),
(52, 'b@a.ceds', '2024-07-21 18:39:36'),
(53, 'a@b.cweds', '2024-07-21 18:40:24'),
(54, 'a@b.cwer', '2024-07-21 18:41:02'),
(55, 't@t.tttttt', '2024-07-21 20:59:03'),
(56, 'b@a.css', '2024-07-21 21:00:01'),
(57, 't@t.ttdfgdfs', '2024-07-21 21:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Shtepi'),
(2, 'Banese');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `isadmin`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$hokgZC.zUt8NVcsnCvfaJeqPxRiAGZul.BDZ9Adt5XGLsukBC4ryK', 1, '2024-07-03 17:06:16', '2024-07-11 16:15:16'),
(2, 'filan', 'fisteku', 'filan@fisteku.ff', '$2y$10$G4Wzeu3ztkZ5TJfV7QSv8uxbVaBOmSrl9CekcvWpxzHOCboZLyOgu', 0, '2024-07-03 17:06:16', '2024-07-09 12:22:39'),
(3, 'hajrije', 'mjeku', 'hajrije@mjeku.h', '$2y$10$3jfs/wiUJBAOqVhu6DrhpuWDr4CQoAiV96xKlunoJ/k9IocgYY8Ty', 0, '2024-07-04 00:20:16', '2024-07-09 12:20:03'),
(4, 'test', 'test', 't@t.t', '$2y$10$.xj20eZcSTwL2GmW/jGZZudhNAikz7MJOFfyplVlBxlRZpivx076i', 0, '2024-07-07 21:51:15', '2024-07-20 12:03:22'),
(8, 'abc', 'abc', 'a@b.c', '$2y$10$cg4m8XdgU33gQ8nlJGApde8LVCQaeem0SmFbufHd4If53b9qBr/qS', 0, '2024-07-10 12:48:39', '2024-07-12 16:27:23'),
(10, 'random', 'random', 'r@r.r', '$2y$10$EezuM1qB1.nAoyXdyCiHD.aT/PddqdfMB51m1oSgPsms70oAJ/YQi', 0, '2024-07-13 18:16:04', '2024-07-13 18:16:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `residence`
--
ALTER TABLE `residence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_typeid` (`typeid`),
  ADD KEY `fk_userid` (`userid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_ibfk_1` (`residence_id`),
  ADD KEY `reviews_ibfk_2` (`user_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `residence`
--
ALTER TABLE `residence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `residence`
--
ALTER TABLE `residence`
  ADD CONSTRAINT `fk_typeid` FOREIGN KEY (`typeid`) REFERENCES `type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`residence_id`) REFERENCES `residence` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
