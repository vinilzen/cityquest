<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<!--[if lt IE 8]>
	 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dashboard.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
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
						array('label'=>'О проекте', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Контакты', 'url'=>array('/site/contact')),
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
			<div class="col-sm-3 col-md-2 sidebar">

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
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<?php echo $content; ?>
			</div>
		</div>
	</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/underscore-min.js"></script>
<script src="/js/backbone-min.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/admin_main.js"></script>
</body>
</html>