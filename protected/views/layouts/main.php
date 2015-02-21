<!DOCTYPE html>
<html lang="ru">
  
  <? include('head.php'); ?>

<body class="<? if (!(Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index'))
echo ' inner ';  if (Yii::app()->request->url == '/contact') echo ' contact ';?>">

    <? if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index')
        echo '<video autoplay="1" id="bgr_video" loop="1" src=""></video>'; ?>
    
    <? include('nav.php'); ?>

    <div class="jumbotron">
      <? if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index') { ?>
      <div class="container text-center">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12">
            <h1><?=Yii::t('app', 'slogan')?></h1>
            <p><?=Yii::t('app', 'introdaction')?></p>
            <small><?=Yii::t('app', 'To participate you need a team')?></small>
          </div>
        </div>
      </div>
      <? } ?>
    </div>

		<?php echo $content; ?>

    <? include('footer.php'); ?>
</body>
</html>