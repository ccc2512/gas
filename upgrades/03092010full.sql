-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 03 2010 г., 18:36
-- Версия сервера: 5.1.44
-- Версия PHP: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `gas_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `gas`
--

CREATE TABLE IF NOT EXISTS `gas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `summ` decimal(18,2) NOT NULL DEFAULT '0.00',
  `litr` decimal(18,2) NOT NULL DEFAULT '0.00',
  `odo` decimal(18,2) NOT NULL DEFAULT '0.00',
  `rubl2litr` decimal(18,2) NOT NULL DEFAULT '0.00',
  `km` decimal(18,2) NOT NULL DEFAULT '0.00',
  `litr2100km` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `rubl2km` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `comment` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)  AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `gas`
--

INSERT INTO `gas` (`id`, `status`, `date`, `summ`, `litr`, `odo`, `rubl2litr`, `km`, `litr2100km`, `rubl2km`, `comment`) VALUES
(1, 1, 1283461200, 690.00, 10.00, 236430.00, 23.00, 240.00, 12.5100, 2.8700, ''),
(2, 1, 1280523600, 300.00, 12.00, 236190.00, 0.00, 0.00, 0.0000, 0.0000, '');

-- --------------------------------------------------------

--
-- Структура таблицы `strings`
--

CREATE TABLE IF NOT EXISTS `strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
)  AUTO_INCREMENT=41 ;

--
-- Дамп данных таблицы `strings`
--

INSERT INTO `strings` (`id`, `name`, `value`, `type`, `comment`) VALUES
(1, 'vers', '0.01 alpha', 'system', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT '0' COMMENT '-2-blocked, -1-deleted, 0-not activated, 1-normal >1 not specified by available',
  `u_key` int(11) NOT NULL DEFAULT '0',
  `u_login` varchar(50) NOT NULL DEFAULT '',
  `u_pass` varchar(50) NOT NULL DEFAULT '',
  `last_visit_dt` int(11) NOT NULL DEFAULT '0',
  `reg_date` varchar(10) NOT NULL DEFAULT '',
  `activity` int(11) NOT NULL DEFAULT '0',
  `nick_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `second_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cel_phone` varchar(25) DEFAULT NULL,
  `home_phone` varchar(25) DEFAULT NULL,
  `fax` varchar(25) DEFAULT NULL,
  `city_id` int(11) NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `ind_login_pass` (`u_login`,`u_pass`)
)  AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `status`, `u_key`, `u_login`, `u_pass`, `last_visit_dt`, `reg_date`, `activity`, `nick_name`, `first_name`, `second_name`, `last_name`, `email`, `cel_phone`, `home_phone`, `fax`, `city_id`, `address`) VALUES
(1, 1, 7195445, 'ccc', 'ccc', 1283527967, '', 11010, '1', 'Сергей', '', 'Страхов', NULL, NULL, NULL, NULL, 0, NULL);
