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
                  <button class="btn btn-topline dropdown-toggle" disabled="disabled" data-toggle="dropdown" type="button">
                    <span class="caret"></span><span class="sr-only">Выбрать город</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Питер</a></li>
                    <li><a href="#">Уфа</a></li>
                    <li><a href="#">Владивосток</a></li>
                  </ul>
                </div>
              </div>
              <div id="for-login-pl">
                <? if (Yii::app()->user->isGuest) {
                  echo '<a class="btn btn-topline btn-default ico-lock" data-target="#myModalAuth" data-toggle="modal" href="#login">ВОЙТИ</a>';
                } else {
                  echo '<a class="btn btn-topline btn-default ico-lock" data-toggle="modal" href="/user/profile">'.Yii::app()->getModule('user')->user()->username.'</a>';
                } ?>                    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>