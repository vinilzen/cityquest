<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<!--[if lt IE 8]>
	 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="inner">
    <? if (Yii::app()->request->url == '/') echo '<video autoplay="1" id="bgr_video" loop="1" src=""></video>'; ?>
    <div class="navbar-wrapper">
      <div class="container-fluid">
        <div class="navbar navbar-static-top" role="navigation">
          <div class="container">
            <div class="row">
              <div class="col-md-3 col-sm-4 col-xs-7">
                <div class="navbar-header">
                  <a class="navbar-brand" href="/"><img src="/img/logo1.png"></a>
                </div>
              </div>
              <div class="col-md-6 col-sm-1 hidden-xs navbar-inner" id="top_menu_container">
                <div class="navbar-collapse collapse" id="top_menu">
                  <ul class="nav navbar-nav">
                    <li class="hidden hidden-lg"><a id="close_top_menu" type="button"><span aria-hidden="true"> ×</span><span class="sr-only">Close</span></a></li>
                    <li class="<? if (Yii::app()->request->url == '/') echo ' active '; ?>"><a href="/"> Квесты</a></li>
                    <li class="<? if (strpos(Yii::app()->request->url, '/quest/schedule/ymd/') === 0 ) echo ' active '; ?>"><a href="/quest/schedule/ymd/"> Расписание</a></li>
                    <li class="<? if (Yii::app()->request->url == '/rules') echo ' active '; ?>"><a href="/rules"> Правила</a></li>
                    <li class="<? if (Yii::app()->request->url == '/franchise') echo ' active '; ?>"><a href="/franchise"> Франшиза </a></li>
                    <li class="<? if (Yii::app()->request->url == '/contact') echo ' active '; ?>"><a href="/contact"> Контакты</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3 col-sm-7 col-xs-5">
                <div class="pull-right right-nav-btn">
                  <button class="btn navbar-toggle btn-topline" id="show-menu" type="button"><span class="icos"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></span><span>Меню</span></button>
                  <div id="for-city">
                    <div class="btn-group city-select">
                      <button class="btn btn-topline ico-msq" disabled="disabled" data-toggle="dropdown" type="button"> Москва</button>
                      <button class="btn btn-topline dropdown-toggle" disabled="disabled" data-toggle="dropdown" type="button"><span class="caret"></span><span class="sr-only">Выбрать город</span></button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Питер</a></li>
                        <li><a href="#">Уфа</a></li>
                        <li><a href="#">Владивосток</a></li>
                      </ul>
                    </div>
                  </div>
                  <div id="for-login-pl">
                    <a class="btn btn-topline btn-default ico-lock" data-target="#myModalAuth" data-toggle="modal" href="#login">ВОЙТИ</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   
	<?php echo $content; ?>

    <div class="footer">
      <div class="row">
        <div class="col-sm-5 hidden-xs">
          <p class="pull-left condition">
            <i class="ico-pay ico-visa" data-toggle="tooltip" title="Принимаем к оплате карты Visa"></i><i class="ico-pay ico-mc" data-toggle="tooltip" title="Принимаем к оплате карты MasterCard"></i><i class="ico-pay ico-cash" data-toggle="tooltip" title="Принимаем к оплате наличные"></i><span class="weinsoc hidden-sm"><em>&mdash;</em>Принимаем к оплате</span>
          </p>
        </div>
        <div class="col-xs-12 visible-xs">
          <p class="text-center">
            <a class="btn-soc" href="#"><i class="ico-soc ico-fb"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-tw"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-vk"></i></a>
          </p>
        </div>
        <div class="col-sm-2 col-xs-12">
          <p class="text-center">
            <span class="brand"><strong>CITY</strong>QUEST 2014</span>
          </p>
        </div>
        <div class="col-sm-5 col-xs-12 hidden-xs">
          <p class="pull-right right-soc">
            <span class="weinsoc hidden-sm">мы в социальных сетях<em>&mdash;</em></span><a class="btn-soc" href="#"><i class="ico-soc ico-fb"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-tw"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-vk"></i></a>
          </p>
        </div>
      </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalMenuLabel" class="modal fade" id="myModalMenu" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span><span class="sr-only">Close</span></button>
          </div>
          <div class="modal-body">
            <div class="row right-nav-btn">
              <div class="col-xs-6" id="for-select-city"></div>
              <div class="col-xs-6" id="for-login"></div>
            </div>
            <div class="row">
              <div class="col-xs-12" id="for-menu"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalLabelAuth" class="modal fade" id="myModalAuth" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="visible-xs close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><a class="h4 modal-title" data-toggle="tab" href="#auth" role="tab">Вход на сайт</a><a class="h4 modal-title active" data-toggle="tab" href="#reg" role="tab">Регистрация</a>
            <hr class="fadeOut">
          </div>
          <div class="modal-body">
            <div class="row social_auth">
              <div class="col-xs-6 text-right">
                <a class="vk" href="#vk"></a>
              </div>
              <div class="col-xs-6 text-left">
                <a class="fb" href="#fb"></a>
              </div>
              <div class="col-xs-12">
                <div class="orTbl">
                  <div class="orRow">
                    <div class="orCell orL"></div>
                    <div class="orCell orC">
                      <span>или</span>
                    </div>
                    <div class="orCell orR"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-content">
              <div class="tab-pane" id="auth">
                <form role="form">
                  <div class="form-group">
                    <input class="form-control" placeholder="Email" type="email">
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Пароль" type="password">
                  </div>
                  <div class="checkbox invisible">
                    <label></label>
                  </div>
                  <button class="btn btn-default btn-block btn-lg" type="submit"> Авторизоваться</button>
                </form>
              </div>
              <div class="tab-pane active" id="reg">
                <form role="form">
                  <div class="form-group">
                    <input class="form-control" placeholder="Имя" type="text">
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Email" type="email">
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Пароль" type="password">
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox">Я принимаю <a href="rules.html">Условия использования</a></label>
                  </div>
                  <button class="btn btn-default btn-block btn-lg" type="submit"> Зарегистрироваться</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalLabelBook" class="ModalBook modal fade" id="myModalBook" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6 col-xs-12">
                <img alt="Generic placeholder image" class="featurette-image img-responsive" src="">
                <a class="descr" href="#lab">
                  <h2>Лаборатория</h2>
                  <p>
                    <span>
                      <i class="ico-ppl"></i>
                      <i class="ico-ppl"></i>
                      <i class="ico-ppl noactive"></i>
                      <i class="ico-ppl noactive"></i>2 - 4 игрока
                    </span>
                    <span><i class="ico-loc"></i>ул. Стасовой, д. 10, корп. 3</span>
                  </p>
                </a>
              </div>
              <div class="col-sm-6 col-xs-12 shad shadow">
                <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="text-center">
                  <h3>Подтверждение</h3>
                  <p>
                    <small>Понедельник</small><span>30.07</span><em>в</em><span>10:45</span>
                  </p>
                  <div class="priceTbl">
                    <div class="priceRow">
                      <span class="dashed"></span><span class="price">3000<em>руб.</em></span><span class="dashed"></span>
                    </div>
                  </div>
                  <p class="you_phone">Ваш номер телефона:<a>+7 952 377-97-97</a></p>
                  <div class="btn btn-default">Подтвердить бронь</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/main.js"></script>
</body>
</html>