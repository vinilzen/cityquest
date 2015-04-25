<div class="navbar-wrapper">
  <div class="container-fluid">
    <div class="navbar navbar-static-top" role="navigation">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-4 col-xs-7">
            <div class="navbar-header" itemscope itemtype="http://schema.org/Brand">
              <a class="navbar-brand" itemprop="url" href="http://cityquest.ru/">
                <img itemprop="logo" alt="CityQuest Реальные игровые квесты выход из комнаты в Москве" src="/img/logo3.svg">
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
          <div class="col-md-3 col-sm-7 col-xs-5" style="max-width: 280px; float: right;">
            <div class="pull-right right-nav-btn">
              <button class="btn navbar-toggle btn-topline" id="show-menu" type="button"><span class="icos"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></span><span>Меню</span></button>
              <div id="for-city">
                <div class="btn-group city-select">
                  <?
                    $domen2 = explode('.', $_SERVER['HTTP_HOST']);
                    $domen2 = $domen2[count($domen2)-1];
                    $domen_loc = explode('.', $_SERVER['HTTP_HOST']);//[1];
                    $domen_loc = $domen_loc[count($domen_loc)-1];
                  ?>
                  <button class="btn btn-link ico-msq" data-toggle="dropdown" type="button">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    <span><?=$this->city_name?></span>
                    <i class="glyphicon glyphicon-menu-down"></i>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  <? 
                    foreach($this->cities AS $city){
                      $domen1 = explode('.', $_SERVER['HTTP_HOST']);//[0];
                      $domen1 = $domen1[count($domen1)-2];
                      $domen2 = $city->country;

                      $subdomain = '';

                      // only for local
                      if ($domen1 == 'cq'){
                        if ($city->country == 'ru') {
                          $domen2 = 'il';
                        } else {
                          $domen2 = 'kzil';
                        }
                      }

                      if ($city->subdomain != '' && $city->subdomain != '/'){
                        $subdomain = $city->subdomain.'.';
                      }

                      if (strtolower($city->name) != strtolower($this->city_name) && $city->active == 1){
                        echo '<li><a href="http://'.$subdomain.''.$domen1.'.'.$domen2.'/">'.$city->name.'</a></li>';
                      }
                    }
                   ?>
                  </ul>
                </div>
              </div><div id="for-local" <? if ($domen_loc=='ru' || $domen_loc=='il') echo 'style="display:none;"'; ?>>
                <div class="btn-group local-select hidden-xs">
                  <button class="btn btn-link ico-earth" data-toggle="dropdown" type="button">
                    <span><?=($this->language == 'kz')?'Kz':'Ru'?></span></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="/<?=($this->language == 'kz')?'ru':'kz'?>"><?=($this->language == 'kz')?'Russian':'Kazakh'?></a></li>
                  </ul>
                </div>
              </div><div id="for-login-pl">
                <? if (Yii::app()->user->isGuest) { ?>
                  <a class="btn btn-topline btn-default" data-target="#myModalAuth" data-toggle="modal" href="#login">
                    <i class="icon icon-lock"></i><?=Yii::t('app','LOGIN')?></a>
                <? } else { ?>
                  <a class="btn btn-topline btn-default" data-toggle="modal" href="/user/profile">
                    <i class="icon icon-lock"></i><?=Yii::t('app','CABINET')?></a>
                <? } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>