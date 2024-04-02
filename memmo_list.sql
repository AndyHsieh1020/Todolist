-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-03-05 10:08:54
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `memmo`
--

-- --------------------------------------------------------

--
-- 資料表結構 `memmo_list`
--

CREATE TABLE `memmo_list` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `send_mail` tinyint(1) NOT NULL,
  `finish` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5 COLLATE=big5_chinese_ci;

--
-- 傾印資料表的資料 `memmo_list`
--

INSERT INTO `memmo_list` (`id`, `user_name`, `date`, `title`, `content`, `send_mail`, `finish`) VALUES
(18, 'andy', '2024-03-09 17:07:00', '你好', '我很好', 0, 1),
(19, 'andy', '2024-03-06 18:10:00', '打掃', '打掃廁所\r\n打掃房間', 1, 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `memmo_list`
--
ALTER TABLE `memmo_list`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `memmo_list`
--
ALTER TABLE `memmo_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
