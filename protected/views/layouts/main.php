<!DOCTYPE html>
<html lang="ru">
  
  <? include('head.php'); ?>

<body class="<? if (Yii::app()->request->url != '/') echo ' inner ';  if (Yii::app()->request->url == '/contact') echo ' contact ';?>">

    <? if (Yii::app()->request->url == '/') echo '<video autoplay="1" id="bgr_video" loop="1" src=""></video>'; ?>
    
    <? include('nav.php'); ?>

    <div class="jumbotron">
      <? if (Yii::app()->request->url == '/') { ?>
      <div class="container text-center">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12">
            
            <h1>«Выберись из комнаты» квесты в реальной жизни</h1>
            
            <p>CityQuest заставит вас погрузится на час в атмосферу Игры, из которой есть только один выход. И найти его нужно вам – команде, запертой в помещении, наполненном загадками и хитроумными приспособлениями, которые отделяют вас от заветной цели.</p>           
            <small>Для участия нужно собрать команду от 2 до 4 человек и записаться на игру</small>

          </div>
        </div>
      </div>
      <? } ?>
    </div>

		<?php echo $content; ?>

    <? include('footer.php'); ?>
</body>
</html>