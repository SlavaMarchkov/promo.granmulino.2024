-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.46
-- Время создания: Июл 28 2024 г., 15:38
-- Версия сервера: 5.7.37-40
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `a0126478_promo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `product_groups`
--

CREATE TABLE `product_groups`
(
    `id`        tinyint(2) UNSIGNED NOT NULL,
    `name`      varchar(50)         NOT NULL,
    `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8 COMMENT ='Группы макаронной и мучной продукции';

--
-- Дамп данных таблицы `product_groups`
--

INSERT INTO `product_groups` (`id`, `name`, `is_active`)
VALUES (1, 'Granmulino Премиум', 1),
       (2, 'Granmulino Стандарт', 1),
       (3, 'Granmulino Плюс', 1),
       (4, 'Granmulino Kids', 1),
       (5, 'VELNES', 0),
       (6, 'Мука Granmulino', 1),
       (7, 'Семейный Гарнир', 1),
       (8, 'Крупы и Хлопья', 0),
       (9, 'Весь ассортимент', 0),
       (10, 'Granmulino Йод', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `product_groups`
--
ALTER TABLE `product_groups`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `product_groups`
--
ALTER TABLE `product_groups`
    MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
