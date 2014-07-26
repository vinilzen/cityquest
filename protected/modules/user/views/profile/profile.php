<?
	$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
?>

<div class="jumbotron">
  <div class="row">
    <div class="col-xs-12 text-center cabinet visible-xs moveUp">
      <img class="img-circle" height="135" src="img/ava.jpg" width="135">
    </div>
    <div class="col-xs-12 text-center cabinet">
      <span class="name"><? echo Yii::app()->getModule('user')->user()->profile->getAttribute('firstname'); ?></span>
      <span class="phone"><? echo Yii::app()->getModule('user')->user()->profile->getAttribute('phone'); ?></span>
      <img class="img-circle hidden-xs" height="135" src="/img/ava.jpg" width="135">
      <span><a href="/user/profile/edit"><i class="edit-ico"></i>Редактировать</a></span>
      <span><a href="/user/logout"><i class="logout-ico"></i>Выйти</a></span>
    </div>
  </div>
</div>

<div class="container-fluid myQuests">
  <div class="row">
    <div class="col-xs-12 text-center">
      <h2 class="twotab active">
        Активные квесты
      </h2>
      <h2 class="twotab">
        предыдущие игры
      </h2>
      <hr class="fadeOut">
    </div>
  </div>
  <div class="row ModalBook">
    <div class="col-sm-6 col-xs-12">
      <img alt="Generic placeholder image" class="featurette-image img-responsive" src="img/Photos/Lab.jpg"><a class="descr" href="#lab">
          <h2>
            Лаборатория
          </h2>
          <p>
            <span><i class="ico-ppl"></i><i class="ico-ppl"></i><i class="ico-ppl noactive"></i><i class="ico-ppl noactive"></i>2 - 4 игрока</span><span><i class="ico-loc"></i>ул. Стасовой, д. 10, корп. 3</span>
          </p>
        </a></img>
    </div>
    <div class="col-sm-6 col-xs-12 shad">
      <div class="text-center">
        <h3>
          Мы ждем вас
        </h3>
        <p>
          <small>Понедельник</small><span>30.07</span><em>в</em><span>10:45</span>
        </p>
        <div class="priceTbl">
          <div class="priceRow">
            <span class="dashed"></span><span class="price">3000<em>руб.</em></span><span class="dashed"></span>
          </div>
        </div>
        <p class="you_phone">
          Ваш номер телефона:<a>+7 952 377-97-97</a>
        </p>
        <div class="btn btn-default btn-success">
          ПОдтвержден
          <div class="glyphicon glyphicon-ok"></div>
        </div>
        <div class="btn btn-default btn-blank">
          снять бронь
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <hr class="fadeOut p10">
    </div>
  </div>
  <div class="row ModalBook">
    <div class="col-sm-6 col-xs-12">
      <img alt="Generic placeholder image" class="featurette-image img-responsive" src="img/Photos/Lab.jpg"><a class="descr" href="#lab">
          <h2>
            Лаборатория
          </h2>
          <p>
            <span><i class="ico-ppl"></i><i class="ico-ppl"></i><i class="ico-ppl noactive"></i><i class="ico-ppl noactive"></i>2 - 4 игрока</span><span><i class="ico-loc"></i>ул. Стасовой, д. 10, корп. 3</span>
          </p>
        </a></img>
    </div>
    <div class="col-sm-6 col-xs-12 shad">
      <div class="text-center">
        <h3>
          Мы ждем вас
        </h3>
        <p>
          <small>Понедельник</small><span>30.07</span><em>в</em><span>10:45</span>
        </p>
        <div class="priceTbl">
          <div class="priceRow">
            <span class="dashed"></span><span class="price">3000<em>руб.</em></span><span class="dashed"></span>
          </div>
        </div>
        <p class="you_phone">
          Ваш номер телефона:<a>+7 952 377-97-97</a>
        </p>
        <div class="btn btn-default btn-success">
          ПОдтвержден
          <div class="glyphicon glyphicon-ok"></div>
        </div>
        <div class="btn btn-default btn-blank">
          снять бронь
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <hr class="fadeOut p10">
    </div>
  </div>
</div>

<? if(Yii::app()->user->hasFlash('profileMessage')): ?>
	<div class="success"><? echo Yii::app()->user->getFlash('profileMessage'); ?></div>
<? endif; ?>