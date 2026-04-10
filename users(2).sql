-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 10 2026 г., 17:23
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
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
