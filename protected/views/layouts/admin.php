<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="language" content="ru" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/proui/bootstrap.min-3.1.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/proui/main-3.1.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/proui/plugins-3.1.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/proui/themes-3.1.css" />
	<link rel="stylesheet" type="text/css" href="/css/jquery.formstyler.css" />
	<title><?=CHtml::encode($this->pageTitle)?></title>
	<link href="/favico.png" rel="icon">
</head>
<body>
	<div id="page-wrapper">
		<div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations sidebar-visible-xs">
			<div id="sidebar">
				<div id="sidebar-scroll">
					<div class="sidebar-content">
						<a href="/" class="sidebar-brand">
							<span class="sidebar-nav-mini-hide">
								<strong>CityQuest</strong>
							</span>
						</a>
						<div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide hide">
							<div class="sidebar-user-avatar">
								<a href="page_ready_user_profile.php">
									<img src="/img/avatar2.jpg" alt="avatar">
								</a>
							</div>
							<div class="sidebar-user-name">Илья</div>
							<div class="sidebar-user-links">
								<a href="page_ready_user_profile.php" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Profile"><i class="gi gi-user"></i></a>
								<a href="page_ready_inbox.php" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Messages"><i class="gi gi-envelope"></i></a>
								<a href="javascript:void(0)" class="enable-tooltip" data-placement="bottom" title="" onclick="$('#modal-user-settings').modal('show');" data-original-title="Settings"><i class="gi gi-cogwheel"></i></a>
								<a href="login.php" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Logout"><i class="gi gi-exit"></i></a>
							</div>
						</div>
						<ul class="sidebar-nav">
							<li class="">
								<a href="/quest/adminschedule/ymd">
									<i class="hi hi-tasks sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Брони</span>
								</a>
							</li>
							<li class="">
								<a href="/quest/admin">
									<i class="hi hi-book sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Квесты</span>
								</a>
							</li>
							<li class="hide">
								<a href="/user/user/export">
									<span class="sidebar-nav-mini-hide">Экспорт пользователей</span>
								</a>
							</li>
							<li class=" hide">
								<a href="/user/user/exportlab" title="Экспорт кто не прошел Лабораторию">
									<span class="sidebar-nav-mini-hide">Экспорт пользователей которые не прошли Лабораторию</span>
								</a>
							</li>
							<li class="">
								<a href="/user/admin">
									<i class="hi hi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Пользователи</span>
								</a>
							</li>

							<li class="">
								<a href="/city/admin">
									<i class="hi hi-globe sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Города</span>
								</a>
							</li>
							<li class="hide">
								<a href="/site/editmailtpl/success/1">
									<span class="sidebar-nav-mini-hide">Шаблон письма "Прошел""</span>
								</a>
							</li>
							<li class="hide">
								<a href="/site/editmailtpl/success/0">
									<span class="sidebar-nav-mini-hide">Шаблон письма "Не прошел"</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div id="main-container">
				<header class="navbar navbar-default">
					<ul class="nav navbar-nav-custom">
						<li>
							<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
							<i class="fa fa-bars fa-fw"></i>
							</a>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
								<? 	
								$user_city_id = Yii::app()->getModule('user')->user()->city_id;
								
								foreach ($this->cities AS $city)
									if ($city->id == $user_city_id)
										echo $city->name;
								?>
								<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-custom dropdown-options">
								<li class="dropdown-header text-center">Выберите город</li>
								<? foreach ($this->cities AS $city) {
									echo '<li><a href="/city/set/?id='.$city->id.'">'.$city->name.'</a></li>';
								} ?>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav-custom pull-right">
						<li class="dropdown">
							<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								Профиль
								<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
								<li class="dropdown-header text-center"><?=Yii::app()->user->name?></li>
								<li class="hide">
									<a href="page_ready_timeline.php">
										<i class="fa fa-clock-o fa-fw pull-right"></i>
										<span class="badge pull-right">10</span>
										Updates
									</a>
									<a href="page_ready_inbox.php">
										<i class="fa fa-envelope-o fa-fw pull-right"></i>
										<span class="badge pull-right">5</span>
										Messages
									</a>
									<a href="page_ready_pricing_tables.php"><i class="fa fa-magnet fa-fw pull-right"></i>
										<span class="badge pull-right">3</span>
										Subscriptions
									</a>
									<a href="page_ready_faq.php"><i class="fa fa-question fa-fw pull-right"></i>
										<span class="badge pull-right">11</span>
										FAQ
									</a>
								</li>
								<li>
									<a href="/user/profile">
										<i class="fa fa-user fa-fw pull-right"></i>
										Profile
									</a>
									<a href="/user/logout" class="hide">
										<i class="fa fa-cog fa-fw pull-right"></i>
										Settings
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<!-- <a href="page_ready_lock_screen.php"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a> -->
									<a href="/user/logout"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
								</li>
							</ul>
						</li>
					</ul>

				</header>
				<div id="page-content"><?=$content?></div>
			</div>
		</div>
	</div>
	<div class="navbar navbar-inverse navbar-fixed-top hide">
		<div class="container-fluid">
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
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 main">
		<? 	} else { ?>
			<div class="col-xs-12 main">
		<? 	} ?>
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
<script src="/js/app-3.1.js"></script>  
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