-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 24 2025 г., 11:48
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `reviews_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `rating`, `comments`, `submitted_at`) VALUES
(1, 'енкнекн', '', 3, 'кенекнгкен', '2025-05-12 08:26:56'),
(2, 'Борис', '', 5, 'оплуырпоао', '2025-05-12 08:27:16'),
(3, 'Борис', '', 5, 'оплуырпоао', '2025-05-12 08:29:17'),
(4, 'Валентина ', '', 4, 'аппкпввр', '2025-05-12 08:29:36'),
(5, 'Евгений', 'mnovicki2006@gmail.com', 4, 'рарврравр', '2025-05-15 06:04:20'),
(6, 'Дмитрий', 'dkfjkdj@mail.ru', 5, 'gdfgdfg', '2025-06-04 14:01:22'),
(7, 'Дмитрий', 'dkfjkdj@mail.ru', 5, 'gdfgdfg', '2025-06-04 14:10:14'),
(8, 'Дмитрий', 'dkfjkdj@mail.ru', 5, 'gdfgdfg', '2025-06-04 14:12:56'),
(9, 'Дмитрий', 'dkfjkdj@mail.ru', 5, 'gdfgdfg', '2025-06-04 14:13:09'),
(10, 'vikcha', '12345@mail.ru', 5, 'gfgdfgfdg', '2025-06-05 15:29:53');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `avatar`) VALUES
(1, 'vika', '123@mail.ru', '$2y$10$RYNizhF9S6VTUKpWMQuc7.XEWwMlOwR2OOxzB6S4MUJMG0dhYWQqq', '2025-06-04 15:11:17', NULL),
(2, 'vikcha', '1234@mail.ru', '$2y$10$vSz3K.XKnF941HfEgPWDQuvJFXwdcUhcVKyn7FdCYv/zHgID/MiAq', '2025-06-04 15:50:08', 'uploads/avatars/avatar_68406b30704e72.10778154.jpg'),
(3, 'vikchas', 'v@mail.ru', '$2y$10$N1wv5MjCrNZrYEdpRxKq2Ouk4lsAPEr6V0ud2bIt2ZjQBn7HEiZFW', '2025-06-04 15:54:50', 'uploads/avatars/avatar_68406c4a512b94.33953213.jpg'),
(4, 'qwerty', 'qwerty@mail.ru', '$2y$10$mYrk.tqbVtS4S4xUxuXYKu68/ZU.5MFXTvsu.wakdLyFjoNHWgNEq', '2025-06-04 16:18:21', 'uploads/avatars/avatar_684071cd1bbf48.22441825.jpg'),
(5, 'qwerty1', 'qwerty1@mail.ru', '$2y$10$IRDWmDRnBReTaK.Cu6r3F.EbHEgez.6RH1vWc8a0Mt2hLtNIM6sL2', '2025-06-04 16:33:17', 'uploads/avatars/avatar_6840754dd08409.23897100.jpg'),
(6, 'www', 'www@mail.ru', '$2y$10$tGWQ00qGPFmj8gyPFenGce8uoFbQ25ML0Nii4HT8CatCif/Q.QfN2', '2025-06-04 16:34:43', 'uploads/avatars/avatar_684075a3c4a6d6.00681014.jpg'),
(7, 'qwqw', 'qwqw@mail.ru', '$2y$10$P/.V/e8kx3l4GMqNyg/oVOzCgxZFVqQVEuisdZhP5qVjpsvtwE8iO', '2025-06-04 16:38:07', 'uploads/avatars/avatar_6840766f284425.15192983.jpg'),
(8, 'ewo', 'ewo@mail.ru', '$2y$10$cxAaWXd6JOWbjD5TnIRR1epSG9aeJkwePpLIWe76aK6FXfDoyys3G', '2025-06-04 16:41:25', 'uploads/avatars/avatar_684077350ee171.08775038.jpeg'),
(9, 'vikchasss', 'shizahahass@gmail.com', '$2y$10$9CYORIJj5lvUkTLkDMzjk.w9DdIbPTTGI/x0pMA3zLZXAhyZYadVe', '2025-06-13 06:34:00', 'uploads/avatars/avatar_684bc658b8eae9.30946409.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
