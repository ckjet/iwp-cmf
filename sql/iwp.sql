-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 09 2015 г., 19:22
-- Версия сервера: 5.5.41
-- Версия PHP: 5.4.39-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `iwp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `iwp_administrator`
--

CREATE TABLE IF NOT EXISTS `iwp_administrator` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `iwp_administrator`
--

INSERT INTO `iwp_administrator` (`id`, `login`, `password`, `email`, `level`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', '1248783@gmail.com', 10);
