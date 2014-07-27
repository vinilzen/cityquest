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
            <h1>«Выберись из комнаты» в реальной жизни</h1>
            <p>Здесь все как в компьютерной игре, только по-настоящему:<br>можно трогать и брать в руки предметы обстановки,<br>открывать шкафы и двери.</p>
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