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
		<div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">
			<div id="sidebar">
				<div id="sidebar-scroll">
					<div class="sidebar-content">
						<a href="/quest/adminschedule/ymd" class="sidebar-brand">
							<span class="sidebar-nav-mini-hide">
								<strong>CityQuest</strong>
							</span>
						</a>
						<? if (Yii::app()->getModule('user')->user()->superuser == 1) { ?>
						<ul class="sidebar-nav">
							<li class="">
								<a href="/quest/adminschedule/ymd">
									<i class="hi hi-tasks sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Bookings')?></span>
								</a>
							</li>
							<li class="">
								<a href="/quest/admin">
									<i class="hi hi-book sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Quests')?></span>
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
									<i class="hi hi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Users')?></span>
								</a>
							</li>
							<li class="">
								<a href="/city/admin">
									<i class="hi hi-globe sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Cities')?></span>
								</a>
							</li>
							<li class="">
								<a href="/location/admin">
									<i class="hi hi-globe sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Locations')?></span>
								</a>
							</li>
							<li class="">
								<a href="/booking/reports">
									<i class="gi gi-charts sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Reports')?></span>
								</a>
							</li>
							<li class="">
								<a href="/photo/admin">
									<i class="fa fa-camera-retro sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Photos')?></span>
								</a>
							</li>
							<li class="">
								<a href="#" class="sidebar-nav-menu">
									<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
									<i class="fa fa-wrench sidebar-nav-icon"></i>
									<span class="sidebar-nav-mini-hide"><?=Yii::t('app','Settings')?></span>
								</a>
								<ul>
									<li>
										<a href="/discounts/admin">
											<i class="hi sidebar-nav-icon" style="margin-top:-3px;">%</i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Discounts')?></span>
										</a>
									</li>
									<li>
										<a href="/payments/admin">
											<i class="sidebar-nav-icon fa fa-money"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Payment method')?></span>
										</a>
									</li>
									<li>
										<a href="/sources/admin">
											<i class="fa fa-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Source of traffic')?></span>
										</a>
									</li>
								</ul>
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
						<? } elseif (Yii::app()->getModule('user')->user()->superuser > 1) { ?>
							<ul class="sidebar-nav">
								<li class="">
									<a href="/quest/adminschedule/ymd">
										<i class="hi hi-tasks sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Bookings')?></span>
									</a>
								</li>
								<li class="">
									<a href="/booking/reports">
										<i class="gi gi-charts sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?=Yii::t('app','Reports')?></span>
									</a>
								</li>
								<li class="">
									<a href="/discounts/admin">
										<i class="hi sidebar-nav-icon" style="margin-top:-3px;">%</i>
										<span class="sidebar-nav-mini-hide"><?=Yii::t('app','Discounts')?></span>
									</a>
								</li>
							</ul>
						<? } ?>

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
								<?=Yii::t('app','Profile')?>
								<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
								<li class="dropdown-header text-center"><?=Yii::app()->user->name?></li>
								<li>
									<a href="/user/profile">
										<i class="fa fa-user fa-fw pull-right"></i>
										<?=Yii::t('app','Profile')?>
									</a>
									<a href="/user/logout" class="hide">
										<i class="fa fa-cog fa-fw pull-right"></i>
										<?=Yii::t('app','Settings')?>						
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<!-- <a href="page_ready_lock_screen.php"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a> -->
									<a href="/user/logout"><i class="fa fa-ban fa-fw pull-right"></i><?=Yii::t('app','Logout')?></a>
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
									if ($city->id == $user_city_id) echo $city->name;
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
	
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.ba-bbq.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/underscore-min.js"></script>
<script src="/js/backbone-min.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/SimpleAjaxUploader.min.js"></script>

<!-- Jquery File Upload -->
	<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<script src="/js/jq_file_upload/jquery.ui.widget.js"></script>
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

	<script src="/js/jq_file_upload/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script src="/js/jq_file_upload/jquery.fileupload.js"></script>
	<!-- The File Upload processing plugin -->
	<script src="/js/jq_file_upload/jquery.fileupload-process.js"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script src="/js/jq_file_upload/jquery.fileupload-image.js"></script>
	<script src="/js/jq_file_upload/jquery.fileupload-validate.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="/js/jq_file_upload/jquery.fileupload-ui.js"></script>
<!-- Jquery File Upload -->

<script src="/js/admin_main.js"></script>
<script src="/js/jquery.mask.min.js"></script>
<script src="/js/jquery.formstyler.min.js"></script>  
<script src="/js/app-3.1.js"></script>
<script src="/js/proui/plugins-3.1.js"></script>

<? if ($_SERVER['HTTP_HOST'] != 'cq.il' && $_SERVER['HTTP_HOST'] != 'cq.kzil') { ?>
<!-- Yandex.Metrika counter -->
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
</noscript>
<!-- /Yandex.Metrika counter -->
<? } ?>

<?	if (Yii::app()->controller->action->id == 'ajaxschedule') {
		echo '<script src="/js/bb_popover.js"></script>';
		echo '<script src="/js/bb_seance.js"></script>';
		echo '<script src="/js/bb_quest.js"></script>';
		echo '<script src="/js/bb_day.js"></script>';
		echo '<script src="/js/bb_booking.js"></script>';
		echo '<script src="/js/bb.js"></script>';
	} ?>
</body>
</html>