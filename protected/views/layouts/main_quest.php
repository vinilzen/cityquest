<!DOCTYPE html>
<html lang="ru">
  
  <? include('head.php'); ?>

<body class="inner<?    
    if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'view')
      echo ' body-quest ';
?>">
 <? if ($this->city_model->id != 2 ) { ?>
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MLLHVP"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MLLHVP');</script>
    <!-- End Google Tag Manager -->
  <? } ?>
    
  <? include('nav.php'); ?>
  
	<?php echo $content; ?>

  <? include('footer.php'); ?>
</body>
</html>