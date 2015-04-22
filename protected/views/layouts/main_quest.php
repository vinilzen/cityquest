<!DOCTYPE html>
<html lang="ru">
  
  <? include('head.php'); ?>

<body class="inner<?    
    if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'view')
      echo ' body-quest ';
?>">
    
  <? include('nav.php'); ?>
  
	<?php echo $content; ?>

  <? include('footer.php'); ?>
  
</body>
</html>