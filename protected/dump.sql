-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 04 2014 г., 14:37
-- Версия сервера: 5.5.37-0ubuntu0.12.04.1
-- Версия PHP: 5.3.10-1ubuntu3.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `cityquest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_booking`
--

CREATE TABLE IF NOT EXISTS `tbl_booking` (
`id` int(11) NOT NULL,
  `date` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT '0',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `time` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `result` int(11) DEFAULT NULL,
  `quest_id` int(11) NOT NULL,
  `competitor_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `tbl_booking`
--

INSERT INTO `tbl_booking` (`id`, `date`, `price`, `name`, `comment`, `status`, `time`, `create_time`, `email`, `phone`, `result`, `quest_id`, `competitor_id`) VALUES
(2, 20140703, 3500, '', '29 июня - 14:00 - ', 0, '14:00', 1403793747, NULL, '123-465-798', NULL, 2, 2),
(3, 20140706, 3500, '', '29 июня - 15:15 - попробуемс\n', 0, '15:15', 1403811712, NULL, '123-465-798', NULL, 2, 2),
(5, 20140712, 3500, '', '28 июня - 19:00 - ', 0, '19:00', 1403811797, NULL, '123-465-798', NULL, 2, 2),
(6, 20140705, 2000, '', '3 июля - 11:30 - qwer', 0, '11:30', 1404228523, NULL, '123-465-798', NULL, 3, 2),
(7, 20140709, 3000, '', '9 июля - 01:15 - ', 0, '01:15', 1404284654, NULL, '', NULL, 1, 1),
(8, 20140706, 3000, '', '31 Jul - 07:45 - agrtafbzdfb', 0, '07:45', 1404286102, NULL, '123-465-798', NULL, 3, 2),
(9, 20140706, 3000, '', '31 Jul - 06:30 - привет', 0, '06:30', 1404286564, NULL, '123-000-000', NULL, 3, 1),
(10, 20140706, 3000, '', '31 Jul - 17:45 - ауауау', 0, '17:45', 1404286708, NULL, '00-0-678468', NULL, 3, 1),
(11, 20140706, 3000, '', '31 Jul - 22:45 - ауауау', 0, '22:45', 1404286725, NULL, '00-0-678468', NULL, 3, 1),
(12, 20140706, 3000, '', '31 Jul - 09:00 - rthnsr gfg', 1, '09:00', 1404286793, NULL, '123-321-321-312', NULL, 2, 1),
(13, 20140706, 3000, '', '31 Jul - 04:00 - 12321', 0, '04:00', 1404288438, NULL, '123-465-798', NULL, 3, 2),
(14, 20140706, 3000, '', '31 Jul - 10:15 - qwerty', 1, '10:15', 1404288538, NULL, '123-465-798', NULL, 3, 2),
(15, 20140706, 3000, '', '31 Jul - 21:30 - привет лопухи как делы ?\nбудут задачки из квантовой механики Евклида ?', 0, '21:30', 1404289218, NULL, '123-465-798', NULL, 3, 2),
(16, 20140706, 3000, '', '31 Jul - 19:00 - ', 0, '19:00', 1404289225, NULL, '', NULL, 3, 2),
(18, 20140706, 3500, '', '6 июля - 11:30 - zaq', 1, '11:30', 1404292952, NULL, '111222333', NULL, 3, 1),
(19, 20140706, 1500, '', '6 июля - 16:30 - все таки попробуем', 1, '16:30', 1404402838, NULL, '000-000-000', NULL, 2, 1),
(20, 20140706, 1200, 'Вася', '6 июля - 17:45 - тест за 1200', 0, '17:45', 1404402994, NULL, '000-111', NULL, 2, 1),
(21, 20140706, 1200, 'Вася', '6 июля - 17:45 - тест за 1200', 0, '17:45', 1404402997, NULL, '000-111', NULL, 2, 1),
(22, 20140708, 5000, 'Ольга', '8 июля - 15:15 - на все', 1, '15:15', 1404403058, NULL, '789-789-79', NULL, 2, 1),
(23, 20140706, 2500, 'Инга', '6 июля - 04:00 - 6 июля - 04:00 - 6 июля - 04:00 - яфцы', 1, '04:00', 1404462897, NULL, '789789789', NULL, 2, 1),
(24, 20140706, 4000, 'Петя', '6 июля - 14:00 - хочет кушать', 0, '14:00', 1404464789, NULL, 'marchuk@gmail.com', NULL, 2, 1),
(25, 20140707, 2000, 'Антон Петров', '7 июля - 12:00 - Играем', 0, '12:00', 1404473587, NULL, '123-465-798', NULL, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_city`
--

CREATE TABLE IF NOT EXISTS `tbl_city` (
`id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` smallint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `name`, `active`) VALUES
(1, 'Москва', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
`id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tbl_comment`
--

INSERT INTO `tbl_comment` (`id`, `content`, `status`, `create_time`, `author`, `email`, `url`, `post_id`) VALUES
(1, 'This is a test comment.', 2, 1230952187, 'Tester', 'tester@example.com', NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lookup`
--

CREATE TABLE IF NOT EXISTS `tbl_lookup` (
`id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_lookup`
--

INSERT INTO `tbl_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, 'Draft', 1, 'PostStatus', 1),
(2, 'Published', 2, 'PostStatus', 2),
(3, 'Archived', 3, 'PostStatus', 3),
(4, 'Pending Approval', 1, 'CommentStatus', 1),
(5, 'Approved', 2, 'CommentStatus', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_post`
--

CREATE TABLE IF NOT EXISTS `tbl_post` (
`id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `title`, `content`, `tags`, `status`, `create_time`, `update_time`, `author_id`) VALUES
(1, 'Welcome!', 'This blog system is developed using Yii. It is meant to demonstrate how to use Yii to build a complete real-world application. Complete source code may be found in the Yii releases.\n\nFeel free to try this system by writing new posts and posting comments.', 'yii, blog', 2, 1230952187, 1230952187, 1),
(2, 'A Test Post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'test', 2, 1230952187, 1230952187, 1);

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
  `phone` varchar(128) NOT NULL DEFAULT ''
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
`id` int(10) NOT NULL,
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
  `visible` int(1) NOT NULL DEFAULT '0'
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
`id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `addres` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `metro` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `times` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `tbl_quest`
--

INSERT INTO `tbl_quest` (`id`, `title`, `content`, `addres`, `metro`, `times`, `status`, `create_time`, `update_time`, `author_id`, `city_id`, `sort`) VALUES
(1, 'Темница Ивана Грозного', '"Замуровали демоны!" - знакомая всем с детства фраза принимает в этом комнате буквальный характер. Вас ждут мистические темницы подземелья из смутного времени, чтобы выбраться из которых, вам прийдется познакомиться с различными орудиями пыток тех лет, а также вспомнить классику советского кинематографа.', 'Малая Тульская улица д.2/1 к5', 'Тульская ', 2, 3, 1403167567, 1404473487, 1, 1, 3),
(2, 'Нехорошая квартира', 'В этой квартире переплелись не только судьбы персонажей книги Булгакова, но еще пространство и время. Чтобы выбраться из очень атмосферного помещения игрокам предстоит распутать этот сложный клубок загадок, а возможно и познакомиться с самим Воландом!', ' Малая Тульская улица д.2/1 к5', 'Тульская', 3, 2, 4, 1404473487, 1, 1, 2),
(3, 'Ограбление банка', 'Описание ограбления ', 'Ульяновская 45', 'Партизанская', 1, 2, 1404222436, 1404473487, 1, 1, 1),
(4, 'Психиатрическая больница', 'Атмосферная история про заброшенное лечебное заведение. Кафельный пол и обитые войлоком стены, один безумец и множество медицинских предметов.', 'ул. Нижняя Сыромятническая, д. 10, стр. 8', 'Курская, Чкаловская', 2, 2, 1404473434, 1404473487, 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_tag` (
`id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1'
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
`id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `createtime`, `lastvisit`, `superuser`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', 1261146094, 1403817732, 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', 1261146096, 1403811696, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_booking_quest` (`quest_id`), ADD KEY `FK_booking_user` (`competitor_id`), ADD KEY `date` (`date`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_comment_post` (`post_id`);

--
-- Indexes for table `tbl_lookup`
--
ALTER TABLE `tbl_lookup`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_post_author` (`author_id`);

--
-- Indexes for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_profiles_fields`
--
ALTER TABLE `tbl_profiles_fields`
 ADD PRIMARY KEY (`id`), ADD KEY `varname` (`varname`,`widget`,`visible`);

--
-- Indexes for table `tbl_quest`
--
ALTER TABLE `tbl_quest`
 ADD PRIMARY KEY (`id`), ADD KEY `author_id` (`author_id`), ADD KEY `city_quest` (`city_id`);

--
-- Indexes for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`), ADD KEY `status` (`status`), ADD KEY `superuser` (`superuser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_lookup`
--
ALTER TABLE `tbl_lookup`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_profiles_fields`
--
ALTER TABLE `tbl_profiles_fields`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_quest`
--
ALTER TABLE `tbl_quest`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
-- Ограничения внешнего ключа таблицы `tbl_comment`
--
ALTER TABLE `tbl_comment`
ADD CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_post`
--
ALTER TABLE `tbl_post`
ADD CONSTRAINT `FK_post_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_quest`
--
ALTER TABLE `tbl_quest`
ADD CONSTRAINT `tbl_quest_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `tbl_quest_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;