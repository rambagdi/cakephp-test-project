-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Feb 29, 2024 at 10:17 AM
-- Server version: 8.0.26
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `body`, `created`, `modified`) VALUES
(2, 1, 'CakePHP', 'This is a CakePHP Development', '2024-02-28 04:13:10', '2024-02-28 04:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `articles_likes`
--

CREATE TABLE `articles_likes` (
  `article_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `article_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`article_id`, `user_id`, `created`, `modified`) VALUES
(2, 2, '2024-02-28 05:18:30', '2024-02-28 05:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `token`, `created`, `modified`) VALUES
(1, 'ram@example.com', '$2y$10$DHEVrVzo42yZc5fM9sMKBODa1WzqEohSsvtKLt9pNuTY6quOOOnoC', 'n', '2024-02-27 21:14:45', '2024-02-27 21:14:45'),
(2, 'demo1@gmail.com', '$2y$10$DHEVrVzo42yZc5fM9sMKBODa1WzqEohSsvtKLt9pNuTY6quOOOnoC', '61967e5eaf47b9417e63bb6d6c196b8f', '2024-02-28 04:42:13', '2024-02-29 09:55:51'),
(3, 'test@gmail.com', '$2y$10$/qdfC1lvCACSzdBtrmKcQuU9UqDyV3BNt9HR85Urvse/ZCxUvLNWe', '2918978dc97412e3f78f519df1c004b0', '2024-02-28 18:40:40', '2024-02-29 10:13:23'),
(4, 'demo@gmail.com', '$2y$10$M4Ync.ldQHsvAIqhLrKGd.qik3SM81vQ2APQfvHboX94ShQ7tuBra', '27d7ccfa0d6f658885bf5c7bda13a0ab', '2024-02-29 09:36:35', '2024-02-29 09:36:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_key` (`user_id`);

--
-- Indexes for table `articles_likes`
--
ALTER TABLE `articles_likes`
  ADD PRIMARY KEY (`article_id`,`user_id`),
  ADD KEY `user_key` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`article_id`,`user_id`),
  ADD KEY `user_key` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `articles_likes`
--
ALTER TABLE `articles_likes`
  ADD CONSTRAINT `articles_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `articles_likes_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
