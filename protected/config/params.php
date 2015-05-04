<?php

// this contains the application parameters that can be maintained via GUI
return array(
	// this is displayed in the header section
	'title'=>'CityQuest - Квесты «выберись из комнаты» ',
	// this is used in error pages
	'adminEmail'=>'marchukilya@gmail.com',
	'helloEmail'=>'hello@cityquest.ru',
	// number of posts displayed per page
	'postsPerPage'=>10,

	// времена начала квестов
	'times' => array(
		1 => array('00:00', '01:15', '02:30', '04:00', '05:15', '06:30', '07:45', '09:00', '10:15', '11:30', '12:45', '14:00', '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45'),
      	2 => array('00:30', '01:45', '03:00', '04:30', '05:45', '07:00', '08:15', '09:30', '10:45', '12:00', '13:15', '14:30', '15:45', '17:00', '18:15', '19:30', '20:45', '22:00', '23:15'),
      	3 => array('00:15', '01:30', '02:45', '04:15', '05:30', '06:45', '08:00', '09:15', '10:30', '11:45', '13:00', '14:15', '15:30', '16:45', '18:00', '19:15', '20:30', '21:45', '23:00'),
		4 => array('10:15', '11:30', '12:45', '14:00', '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45'),

		5 => array('00:45', '11:00', '12:15', '13:30', '14:45', '16:00', '17:15', '18:30', '19:45', '21:00', '22:15', '23:30'),
    ),

    'days' => array('воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'),
    'days_short' => array('Пн', 'Вт', 'Ср', 'Чт', 'Птн', 'Сб', 'Вс'),

    'month' => array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' ),
    'month_f' => array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь' ),

    // сколько след дней доступно для записи
    'offset' => 10,
    'fb' => require(dirname(__FILE__).'/fb.php'),
    'vk' => require(dirname(__FILE__).'/vk.php'),

);
