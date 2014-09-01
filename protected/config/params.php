<?php

// this contains the application parameters that can be maintained via GUI
return array(
	// this is displayed in the header section
	'title'=>'CityQuest - Квесты «выберись из команты» ',
	// this is used in error pages
	'adminEmail'=>'marchukilya@gmail.com',
	'helloEmail'=>'hello@cityquest.ru',
	// number of posts displayed per page
	'postsPerPage'=>10,
	// maximum number of comments that can be displayed in recent comments portlet
	'recentCommentCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; 2009 by Pandra ru.',

	// цена в будние до обеда
	'price_workday_AM' => 2000,
	
	// цена в будние после обеда
	'price_workday_PM' => 3000,

	// цена в выходные до обеда
	'price_weekend_AM' => 3000,

	// цена в выходные после обеда
	'price_weekend_PM' => 3500,

	// времена начала квестов
	'times' => array(
		1 => array('00:00', '01:15', '02:30', '04:00', '05:15', '06:30', '07:45', '09:00', '10:15', '11:30', '12:45', '14:00', '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45'),
      	2 => array('00:30', '01:45', '03:00', '04:30', '05:45', '07:00', '08:15', '09:30', '10:45', '12:00', '13:15', '14:30', '15:45', '17:00', '18:15', '19:30', '20:45', '22:00', '23:15'),
    ),

    'days' => array('воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'),
    'days_short' => array('Пн', 'Вт', 'Ср', 'Чт', 'Птн', 'Сб', 'Вс'),

    'month' => array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря' ),
    'month_f' => array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'ноябрь', 'октябрь', 'декабрь' ),

    // сколько след дней доступно для записи
    'offset' => 14

);
