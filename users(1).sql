-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 10 2026 г., 17:21
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `route_name` varchar(200) DEFAULT NULL,
  `travel_date` date NOT NULL,
  `passengers` int(11) DEFAULT 1,
  `comment` text DEFAULT NULL,
  `status` enum('new','confirmed','cancelled') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `full_name`, `phone`, `email`, `route_name`, `travel_date`, `passengers`, `comment`, `status`, `created_at`) VALUES
(1, 5, 'орпорпо', '987987', 'gjhgjjg@gmail.com', 'В Ижевск на выходные', '2008-09-22', 19, '', 'new', '2026-04-10 07:51:12'),
(2, 5, 'jhgjhg', '78987997', 'sratmir14@gmail.com', 'Ожерелье Камы', '2008-09-22', 1, '', 'new', '2026-04-10 07:53:01'),
(3, 6, 'ыморыолв', '6576567765', 'jhgjhgjhgjhg@kgflg.fjkflj', 'Влюбиться в Удмуртию', '2000-09-22', 10, 'лорлорол', 'cancelled', '2026-04-10 08:50:40');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(1) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `travel_date` date NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `author`, `route_name`, `rating`, `travel_date`, `text`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'лорлорлорло', 'Влюбиться в Удмуртию!', 4, '2002-02-22', 'некенкллолорне', 'pending', '2026-04-10 15:13:32', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `created_at`, `is_admin`) VALUES
(1, '123', 'kjhgjhghjg@gmail.com', '76567567', '321321321', '2026-04-10 07:03:32', 0),
(2, 'grizz12yt', 'grizlibro78@gmail.com', '79999182460', 'eDbXMnvA228!@', '2026-04-10 07:05:46', 0),
(3, 'grizz12y', 'grizlibro@gmail.com', '79999182460', 'eDbXMnvA228!@', '2026-04-10 07:06:51', 0),
(4, '321321', 'hgjhg@gmail.com', '98798789987', '321321321', '2026-04-10 07:11:15', 0),
(5, '654654', 'jhkgkj@gmail.com', '799999999999', '654654654', '2026-04-10 07:47:20', 0),
(6, 'admin', 'admin@udmurtia.ru', '+70000000000', '$2y$10$VDmhAOTwULVNQRcQ1EtLyuJAZUsgtzzb9BGG6dS/PqA5jxdbOch82', '2026-04-10 07:59:31', 1),
(9, '3213211', 'griurgi@gmail.com', '8768768767', '321321321', '2026-04-10 08:48:57', 0),
(10, 'groz11', 'fhgfhg@dfgdfg.jkhg', '7654765675', '$2y$10$YFVxQ9iCmGwGXcgoXlnE6O9AOKOsvL.AynJ6iuv4RqMZKtxTA7tyy', '2026-04-10 11:55:31', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_rating` (`rating`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
