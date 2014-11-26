<div class="navbar-wrapper">
  <div class="container-fluid">
    <div class="navbar navbar-static-top" role="navigation">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-4 col-xs-7">
            <div class="navbar-header" itemscope itemtype="http://schema.org/Brand">
              <a class="navbar-brand" itemprop="url" href="http://cityquest.ru/">
                <img itemprop="logo" alt="CityQuest - ВЫБЕРИСЬ ИЗ КОМНАТЫ КВЕСТЫ В РЕАЛЬНОЙ ЖИЗНИ" src="/img/logo1.png">
              </a>
              <span style="display:none;" itemprop="name">cityquest</span>
            </div>
          </div>
          <div class="col-md-6 col-sm-1 hidden-xs navbar-inner" id="top_menu_container">
            <div class="navbar-collapse collapse" id="top_menu">
              <ul class="nav navbar-nav">
                <? include('menu.php'); ?>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-7 col-xs-5">
            <div class="pull-right right-nav-btn">
              <button class="btn navbar-toggle btn-topline" id="show-menu" type="button"><span class="icos"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></span><span>Меню</span></button>
              <div id="for-city">
                <div class="btn-group city-select">
                  <button class="btn btn-topline ico-msq" disabled="disabled" data-toggle="dropdown" type="button">Москва</button>
                  <button class="btn btn-topline dropdown-toggle" disabled="disabled" data-toggle="dropdown" type="button">
                    <span class="caret"></span><span class="sr-only">Выбрать город</span>
                  </button>
                  <?/*<ul class="dropdown-menu" role="menu">
                    <li><a href="#">Питер</a></li>
                    <li><a href="#">Уфа</a></li>
                    <li><a href="#">Владивосток</a></li>
                  </ul> */
                ?></div>
              </div>
              <div id="for-login-pl">
                <? if (Yii::app()->user->isGuest) {
                  echo '<a class="btn btn-topline btn-default ico-lock" data-target="#myModalAuth" data-toggle="modal" href="#login">ВОЙТИ</a>';
                } else {
                  echo '<a class="btn btn-topline btn-default ico-lock" data-toggle="modal" href="/user/profile">КАБИНЕТ</a>';
                } ?>                    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>