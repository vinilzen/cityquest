<!DOCTYPE html>
<html lang="ru">
  
  <? include('head.php'); ?>

<body itemscope itemtype="http://schema.org/WebPage" class="<?
    // if (!(Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index'))
    
    if (Yii::app()->request->url == '/contact') 
      echo ' contact ';

    if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index')
      echo ' video ';
    else 
      echo ' inner ';
    ?>">

    <? //echo '<video autoplay="autoplay" id="bgr_video" loop="loop"></video>'; ?>
    
    <? include('nav.php'); ?>

    <div class="jumbotron">
      <? if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index') { ?>
      <div class="container text-center">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12">
            <h1><?=Yii::t('app', 'slogan')?></h1>
            <p class="lead-p"><?=Yii::t('app', 'introdaction')?></p>
            <small><?=Yii::t('app', 'To participate you need a team')?></small>
            <p class="btns-filter">
              <span class="btn btn-filter">
                <i class="glyphicon glyphicon-time"></i> Все квесты
              </span>
              <span class="btn btn-filter active">
                <i class="glyphicon glyphicon-time"></i> Обычные
              </span>
              <span class="btn btn-filter">
                <i class="glyphicon glyphicon-time"></i> Спортивные
              </span>
              <span class="btn btn-filter">
                <i class="glyphicon glyphicon-time"></i> Перфоманс
              </span>
            </p>
          </div>
        </div>
      </div>
      <? } ?>
    </div>

    <div style="display: none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
      <meta itemprop="bestRating" content="5" />
      <meta itemprop="ratingValue" content="5" />
      <meta itemprop="ratingCount" content="436" />
    </div>

		<?php echo $content; ?>

    <div class="row">
      <div class="col-md-10 col-md-offset-1 col-sm-12">
        <p class="text-center bottom-lead">CityQuest - это уникальные приключения для команды от 2 до 4 человек. Игроки заходят в помещение и за ними запирается дверь. 
Мы детально продумали каждую мелочь и обстановку внутри, что позволит вам полностью погрузиться в атмосферу игры. Для того чтобы пройти квест, нужно найти выход, проявляя смекалку и решая загадки. Записаться на игру вы можете на нашем сайте или позвонив по телефону. Правила просты, но если вы хотите узнать подробные инструкции - они описаны ниже.
</p>
      </div>
    </div>

    <? include('footer.php'); ?>
</body>
</html>