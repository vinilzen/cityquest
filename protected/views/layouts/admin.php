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
	<link rel="stylesheet" type="text/css" href="/css/jquery.formstyler.css" />
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
				<a class="navbar-brand" href="#">
					<span>CityQuest</span>
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<? 	
								$user_city_id = Yii::app()->getModule('user')->user()->city_id;
								
								foreach ($this->cities AS $city)
									if ($city->id == $user_city_id)
										echo $city->name;
							?><span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<? foreach ($this->cities AS $city) {
								echo '<li><a href="/city/set/?id='.$city->id.'">'.$city->name.'</a></li>';
							} ?>
		                </ul>
					</li>
					<? include('menu.php'); ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle profile_nav" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							<? echo Yii::app()->user->name; ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu profile_dropdown" role="menu">
							<li><a href="<? echo Yii::app()->getModule('user')->profileUrl[0]; ?>"><? echo Yii::app()->getModule('user')->t("Профиль"); ?></a></li>
							<li class="divider"></li>
							<li><a href="<? echo Yii::app()->getModule('user')->logoutUrl[0]; ?>"><? echo Yii::app()->getModule('user')->t("Выйти"); ?></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
		<? if (Yii::app()->getModule('user')->user()->superuser == 1) { ?>
			<div class="navbar-default">
				<button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#left-sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">

				<div class="navbar-collapse collapse" id="left-sidebar">
					<ul class="nav nav-sidebar menu-items" style="margin-bottom:0;">
						<li>
							<div class="menu-items-title menu-favorites">
								<span class="menu-items-title-text">Квесты</span>
							</div>
						</li>
					</ul>
					<ul class="nav nav-sidebar">
						<li class="menu-item-block menu-item-live-feed">
							<a href="/quest/adminschedule/ymd" class="menu-item-link">
								<span class="menu-item-link-text">Сводная таблица</span>
							</a>
						</li>
						<li class="menu-item-block menu-item-live-feed">
							<a href="/quest/admin" class="menu-item-link">
								<span class="menu-item-link-text">Управление квестами</span>
							</a>
						</li>
					</ul>
					<ul class="nav nav-sidebar menu-items" style="margin-bottom:0;">
						<li>
							<div class="menu-items-title menu-favorites">
								<span class="menu-items-title-text">Пользователи</span>
							</div>
						</li>
					</ul>
					<ul class="nav nav-sidebar">
						<li class="menu-item-block menu-item-live-feed">
							<a href="/user/user/export" class="menu-item-link">
								<span class="menu-item-link-text">Экспорт</span>
							</a>
						</li>
						<li class="menu-item-block menu-item-live-feed">
							<a href="/user/admin" class="menu-item-link">
								<span class="menu-item-link-text">Управление пользователями</span>
							</a>
						</li>
					</ul>

					<ul class="nav nav-sidebar menu-items" style="margin-bottom:0;">
						<li>
							<div class="menu-items-title menu-favorites">
								<span class="menu-items-title-text">Города</span>
							</div>
						</li>
					</ul>
					<?
						$this->beginWidget('zii.widgets.CMenu', array(
							'items'=>$this->city_menu,
							'itemTemplate' => '<span class="menu-item-link-text">{menu}</span>',
							'htmlOptions'=>array('class'=>'nav nav-sidebar menu-item-link'),
						));
						$this->endWidget();
					?>
					
					<ul class="nav nav-sidebar menu-items" style="margin-bottom:0;">
						<li>
							<div class="menu-items-title menu-favorites">
								<span class="menu-items-title-text">Шаблон письма</span>
							</div>
						</li>
					</ul>
					<ul class="nav nav-sidebar menu-items">
						<li>
							<a>Рус</a>
							<ul>
								<li><a href="/site/editmailtpl/success/1">Прошел</a></li>
								<li><a href="/site/editmailtpl/success/0">Не прошел</a></li>
							</ul>
						</li>
					</ul>
				</div>	
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 main">
		<? 	} else { ?>
			<div class="col-xs-12 main">
		<? 	} ?>
				<div style="min-height:300px;">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.ba-bbq.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/underscore-min.js"></script>
<script src="/js/backbone-min.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/admin_main.js"></script>
<script src="/js/jquery.mask.min.js"></script>
<script src="/js/jquery.formstyler.min.js"></script>  
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
  <div><img alt="" src="//mc.yandex.ru/watch/25221941" style="position:absolute; left:-9999px;"></div>
</noscript><!-- /Yandex.Metrika counter -->
</body>
</html>