<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="language" content="ru" />
	<!--[if lt IE 8]>
	 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dashboard.css" />
	<!--[if lt IE 9]
		<script src="/js/ie8-responsive-file-warning.js"></script>-->
	<script src="/js/ie-emulation-modes-warning.js"></script>
	<script src="/js/ie10-viewport-bug-workaround.js"></script>
	<!--[if lt IE 9]
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link href="/favico.png" rel="icon">
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<? include('menu.php'); ?>
				</ul>
				<?php $this->widget('zii.widgets.CMenu',array(
					'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right'),
					'items'=>array(
						array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Войти"), 'visible'=>Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Регистрация"), 'visible'=>Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Профиль"), 'visible'=>!Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Выйти").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
					),
				)); ?>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
		<? if (Yii::app()->getModule('user')->user()->superuser == 1) { ?>
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">

				<ul class="nav nav-sidebar" style="margin-bottom:0;"><li><a><strong>Квесты</strong></a></li></ul>
				<?
					$this->beginWidget('zii.widgets.CMenu', array(
						'items'=>$this->quest_menu,
						'htmlOptions'=>array('class'=>'nav nav-sidebar'),
					));
					$this->endWidget();
				?>

				<ul class="nav nav-sidebar" style="margin-bottom:0;"><li><a><strong>Пользователи</strong></a></li></ul>
				<?
					$this->beginWidget('zii.widgets.CMenu', array(
						'items'=>$this->user_menu,
						'htmlOptions'=>array('class'=>'nav nav-sidebar'),
					));
					$this->endWidget();
				?>

				<ul class="nav nav-sidebar" style="margin-bottom:0;"><li><a><strong>Города</strong></a></li></ul>
				<?
					$this->beginWidget('zii.widgets.CMenu', array(
						'items'=>$this->city_menu,
						'htmlOptions'=>array('class'=>'nav nav-sidebar'),
					));
					$this->endWidget();
				?>

			</div>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 main">
		<? 	} else { ?>
			<div class="col-xs-12 main">
		<? 	} ?>
				<div style="min-height:300px; min-width:1024px; overflow:auto;">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/underscore-min.js"></script>
<script src="/js/backbone-min.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/admin_main.js"></script>
<!-- Yandex.Metrika informer --><!-- /Yandex.Metrika informer --><!-- Yandex.Metrika counter -->
<script type="text/javascript">
  (function (d, w, c) {
  (w[c] = w[c] || []).push(function() {
      try {
          w.yaCounter25221941 = new Ya.Metrika({id:25221941,
                  webvisor:true,
                  clickmap:true,
                  trackLinks:true,
                  accurateTrackBounce:true});
      } catch(e) { }
  });
  
  var n = d.getElementsByTagName("script")[0],
      s = d.createElement("script"),
      f = function () { n.parentNode.insertBefore(s, n); };
  s.type = "text/javascript";
  s.async = true;
  s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
  
  if (w.opera == "[object Opera]") {
      d.addEventListener("DOMContentLoaded", f, false);
  } else { f(); }
  })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
  <div>
    <img alt="" src="//mc.yandex.ru/watch/25221941" style="position:absolute; left:-9999px;">
  </div>
</noscript><!-- /Yandex.Metrika counter -->
</body>
</html>