<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width"/>
</head>
<body>
  <h1>Здравствуйте, <?php echo $data['username']; ?>!</h1>
  <?php echo $content ?>
   
  <? if ($data['count_quests'] > 0) { ?>
  <p>Приглашаем Вас посетить <?
    if ($data['count_quests'] > 1) {
      echo 'другие наши квесты';
    } else { 
      echo 'другой наш квест';
    } ?>: <?php echo $data['list_quests']; ?>. <br>
  <? } ?>
  Следите за открытием новых квестов на нашем сайте и в наших соц. сетях:<br>
  <a target="_blank" href="https://www.facebook.com/cityquestru">https://www.facebook.com/cityquestru</a><br>
  <a target="_blank" href="http://vk.com/cityquestru">http://vk.com/cityquestru</a>
  <a target="_blank" href="https://instagram.com/cityquestru/">https://instagram.com/cityquestru/</a>
  </p>
   
  <p>Нам важно ваше мнение, поэтому если у вас есть замечания по работе квеста или просто предложения и идеи, мы будем очень признательны, если вы напишите нам на <a href="mailto:hello@cityquest.ru">hello@cityquest.ru</a>.</p>
   
  <p>До скорой встречи, <br>
  Команда CityQuest </p>
</body>
</html>