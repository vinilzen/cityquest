<div class="navbar-wrapper">
  <div class="container-fluid">
    <div class="navbar navbar-static-top" role="navigation">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-4 col-xs-7">
            <div class="navbar-header" itemscope itemtype="http://schema.org/Brand">
              <h2 style="display:none;" itemprop="name">CityQuest - квесты в Москве</h2>
              <a class="navbar-brand" itemprop="url" href="http://cityquest.ru/">
                <img itemprop="logo" alt="CityQuest Реальные игровые квесты выход из комнаты в Москве" src="/img/logo1.png">
              </a>
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
                  <?
                    $domen2 = explode('.', $_SERVER['HTTP_HOST'])[1];
                    if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){
                      $default_city = 'Астана';
                    } else {
                      $default_city = 'Москва';
                    }
                  ?>
                  <? $domen_loc = explode('.', $_SERVER['HTTP_HOST'])[1]; ?>
                  <button class="btn btn-link ico-msq" data-toggle="dropdown" type="button">
                    <span><?=$default_city?></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  <? 
                    foreach($this->cities AS $city){
                      $domen1 = explode('.', $_SERVER['HTTP_HOST'])[0];
                      $domen2 = $city->country;

                      // only for local
                      if ($domen1 == 'cq'){
                        if ($city->country == 'ru') {
                          $domen2 = 'il';
                        } else {
                          $domen2 = 'kzil';
                        }
                      }

                      if (strtolower($city->name) != strtolower($default_city)){
                        echo '<li><a href="http://'.$domen1.'.'.$domen2.'/">'.$city->name.'</a></li>';
                      }
                    }
                   ?>
                  </ul>
                </div>
              </div><div id="for-local" <? if ($domen_loc=='ru' || $domen_loc=='il') echo 'style="display:none;"'; ?>>
                <div class="btn-group local-select">
                  <button class="btn btn-link ico-earth" data-toggle="dropdown" type="button">
                    <span><?=($this->language == 'kz')?'Kz':'Ru'?></span></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="/<?=($this->language == 'kz')?'ru':'kz'?>"><?=($this->language == 'kz')?'Russian':'Kazakh'?></a></li>
                  </ul>
                </div>
              </div><div id="for-login-pl">
                <?=(Yii::app()->user->isGuest)?
                  '<a class="btn btn-topline btn-default ico-lock" data-target="#myModalAuth" data-toggle="modal" href="#login">'.Yii::t('app','LOGIN').'</a>'
                  :
                  '<a class="btn btn-topline btn-default ico-lock" data-toggle="modal" href="/user/profile">'.Yii::t('app','CABINET').'</a>'?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>