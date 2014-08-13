-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: sportc00.mysql.ukraine.com.ua
-- Время создания: Авг 14 2014 г., 00:13
-- Версия сервера: 5.1.72-cll-lve
-- Версия PHP: 5.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sportc00_city`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_booking`
--

CREATE TABLE IF NOT EXISTS `tbl_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT '0',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `time` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `result` varchar(5) COLLATE utf8_unicode_ci DEFAULT '00:00',
  `quest_id` int(11) NOT NULL,
  `competitor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_booking_quest` (`quest_id`),
  KEY `FK_booking_user` (`competitor_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71 ;

--
-- Дамп данных таблицы `tbl_booking`
--

INSERT INTO `tbl_booking` (`id`, `date`, `price`, `name`, `comment`, `status`, `time`, `create_time`, `email`, `phone`, `result`, `quest_id`, `competitor_id`) VALUES
(28, 20140728, 2000, 'Administrator', ' ', 0, '12:00', 1406360561, NULL, '', NULL, 4, 1),
(29, 20140729, 2000, 'marchukil', ' ', 0, '14:30', 1406575201, NULL, ' ', NULL, 4, 6),
(30, 20140729, 2000, 'marchukil', ' ', 0, '14:30', 1406575244, NULL, ' ', NULL, 4, 6),
(32, 20140729, 2000, 'marchukil', ' ', 0, '14:30', 1406575299, NULL, ' ', NULL, 4, 6),
(34, 20140729, 2000, 'marchukil', ' ', 0, '12:00', 1406575300, NULL, ' ', NULL, 4, 6),
(35, 20140729, 2000, 'marchukil', ' ', 0, '14:30', 1406575432, NULL, ' ', NULL, 4, 6),
(37, 20140729, 2000, 'marchukil', ' ', 0, '12:00', 1406575432, NULL, ' ', NULL, 4, 6),
(41, 20140729, 2000, 'marchukil', ' ', 0, '14:30', 1406575620, NULL, ' ', NULL, 4, 6),
(42, 20140729, 2000, 'marchukil', ' ', 0, '12:00', 1406575620, NULL, ' ', NULL, 4, 6),
(44, 20140728, 3000, 'demo', ' ', 0, '09:00', 1406576143, NULL, ' ', NULL, 3, 2),
(46, 20140730, 3000, 'marchukil', ' ', 0, '14:00', 1406699094, NULL, ' ', NULL, 3, 6),
(48, 20140731, 3000, 'admin', ' ', 0, '02:30', 1406704588, NULL, ' ', NULL, 3, 1),
(49, 20140731, 3000, 'demo', ' ', 0, '14:00', 1406785610, NULL, ' 123-456', NULL, 3, 2),
(50, 20140807, 3000, 'demo', ' ', 0, '12:00', 1406785638, NULL, ' 123-456', NULL, 4, 2),
(54, 20140807, 3000, 'admin', ' ', 0, '01:15', 1407392121, NULL, ' ', NULL, 2, 1),
(55, 20140810, 3000, 'demo', ' ', 0, '11:30', 1407670672, NULL, '+7(123)-456-23-23', NULL, 2, 2),
(56, 20140811, 2000, 'demo', ' ', 0, '12:00', 1407670814, NULL, '+7(123)-456-00-11', NULL, 4, 2),
(58, 20140811, 2000, 'admin', ' ', 0, '09:00', 1407702136, NULL, '+7(123)-123-12-32', NULL, 3, 1),
(59, 20140811, 3000, 'admin', ' ', 0, '03:00', 1407702299, NULL, '+7(123)-123-12-32', NULL, 4, 1),
(60, 20140815, 3000, 'admin', ' ', 0, '02:30', 1407702332, NULL, '+7(123)-123-12-32', NULL, 2, 1),
(62, 20140811, 2000, 'demo', ' ', 0, '09:00', 1407703098, NULL, '+7(123)-456-11-11', NULL, 2, 2),
(64, 20140813, 2000, 'Коляцу', ' ', 0, '12:00', 1407751022, NULL, '+7(123)-123-12-33', '34:00', 4, 1),
(65, 20140812, 3000, 'admin', ' ', 0, '02:30', 1407752338, NULL, '+7(123)-123-12-32', '30:00', 3, 1),
(67, 20140812, 2000, 'admin', ' ', 0, '10:15', 1407752492, NULL, '+7(123)-123-12-33', '45:12', 3, 1),
(68, 20140811, 3000, 'marchukil', ' ', 0, '10:15', 1407783010, NULL, '+7(132)-000-00-00', NULL, 3, 6),
(69, 20140813, 2000, 'demo', ' ', 0, '09:00', 1407792569, NULL, '+7(123)-456-11-11', '45:40', 3, 1),
(70, 20140814, 2000, 'Коля', ' ', 0, '12:00', 1407943454, NULL, '+7(123)-123-12-33', NULL, 4, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_city`
--

CREATE TABLE IF NOT EXISTS `tbl_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `name`, `active`) VALUES
(1, 'Москва', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `role` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`, `birthday`, `role`, `phone`) VALUES
(1, 'Admin', 'Administrator', '0000-00-00', 1, ''),
(2, 'Demo', 'Demo', '0000-00-00', 1, '123-465-798');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'birthday', 'Birthday', 'DATE', 0, 0, 2, '', '', '', '', '0000-00-00', 'UWjuidate', '{"ui-theme":"redmond"}', 3, 2),
(4, 'role', 'Роль', 'INTEGER', 0, 1, 0, '', '', '', '', '1', '', '', 0, 2),
(5, 'phone', 'Номер телефона', 'VARCHAR', 128, 5, 1, '', '', '', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_quest`
--

CREATE TABLE IF NOT EXISTS `tbl_quest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `start_text` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `addres` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `metro` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `times` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `city_quest` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `tbl_quest`
--

INSERT INTO `tbl_quest` (`id`, `title`, `content`, `start_text`, `addres`, `metro`, `times`, `status`, `create_time`, `update_time`, `author_id`, `city_id`, `sort`) VALUES
(1, 'Чердак', '"Замуровали демоны!" - знакомая всем с детства фраза принимает в этом комнате буквальный характер. Вас ждут мистические темницы подземелья из смутного времени, чтобы выбраться из которых, вам прийдется познакомиться с различными орудиями пыток тех лет, а также вспомнить классику советского кинематографа.', ' ', 'Малая Тульская улица д.2/1 к5', 'Тульская ', 2, 3, 1403167567, 1407696091, 1, 1, 5),
(2, 'Театр', 'В этой квартире переплелись не только судьбы персонажей книги Булгакова, но еще пространство и время. Чтобы выбраться из очень атмосферного помещения игрокам предстоит распутать этот сложный клубок загадок, а возможно и познакомиться с самим Воландом!', ' ', 'ул. Летниковская, дом 6А', 'Павелецкая', 1, 2, 4, 1407703492, 1, 1, 2),
(3, 'Ограбление банка', 'Описание ограбления 1 23', 'запуск в августе', 'ул. Летниковская, дом 6А', 'Павелецкая', 1, 2, 1404222436, 1407784944, 1, 1, 0),
(4, 'Лаборатория', 'Атмосферная история про заброшенное лечебное заведение. Кафельный пол и обитые войлоком стены, один безумец и множество медицинских предметов.', ' ', 'ул. Летниковская, дом 6А', 'Павелецкая', 2, 2, 1404473434, 1407703484, 1, 1, 1),
(5, 'Космос', 'в разаботке', ' ', '1', '2', 1, 3, 1406298405, 1407696091, 1, 1, 3),
(6, 'Рудник', 'контент', ' Запуск на Новый Год', '123', '456', 1, 3, 1406298557, 1407784972, 1, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `tbl_tag`
--

INSERT INTO `tbl_tag` (`id`, `name`, `frequency`) VALUES
(1, 'yii', 1),
(2, 'blog', 1),
(3, 'test', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `phone` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `createtime`, `lastvisit`, `superuser`, `status`, `phone`) VALUES
(1, 'Админ', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', 1261146094, 1406183122, 1, 1, '+7(323)-232-32-33'),
(2, 'demo', 'c514c91e4ed341f263e458d44b3bb0a7', 'demo@example.com', 'd9ca76044e48a3716c6259038bd144c0', 1261146096, 1404488470, 0, 1, '+7(123)-222-11-22'),
(6, 'marchukil', 'e10adc3949ba59abbe56e057f20f883e', 'marchukil@mail.ru', '798470347a6dcaad6e94000b68b6c292', 1406566278, 0, 0, 1, '+7(132)-000-22-00'),
(7, 'Коля', 'e10adc3949ba59abbe56e057f20f883e', 'marchukilya@yandex.ru', 'b25b7859449874fcd58ac45d9dd0cad7', 1407478578, 0, 0, 1, '+7(123)-123-12-33');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD CONSTRAINT `FK_booking_quest` FOREIGN KEY (`quest_id`) REFERENCES `tbl_quest` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_booking_user` FOREIGN KEY (`competitor_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_quest`
--
ALTER TABLE `tbl_quest`
  ADD CONSTRAINT `tbl_quest_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_quest_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
