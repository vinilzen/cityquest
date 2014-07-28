<? $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile"); ?>

<div class="jumbotron">
  <div class="row">
    
    <div class="col-xs-12 text-center cabinet visible-xs moveUp">
      <img class="img-circle" height="135" src="/img/ava.jpg" width="135">
    </div>

    <div class="col-xs-12 text-center cabinet">
      <span class="name"><? echo Yii::app()->getModule('user')->user()->username; ?></span>
      <span class="phone"><? echo Yii::app()->getModule('user')->user()->phone; ?></span>
      <img class="img-circle hidden-xs" height="135" src="/img/ava.jpg" width="135">
      <span><a href="#"><i class="edit-ico"></i>Редактировать</a></span>
      <span><a href="/user/logout"><i class="logout-ico"></i>Выйти</a></span>
    </div>

  </div>
</div>

<div class="container-fluid myQuests">
  <div class="row">
    <div class="col-xs-12 text-center">
      <h2 class="twotab active">Активные квесты</h2>
      <h2 class="twotab">предыдущие игры</h2>
      <hr class="fadeOut">
    </div>
  </div>

  <? if (isset($bookings)) foreach($bookings AS $book) { ?> 

  <div class="row ModalBook">
    <div class="col-sm-6 col-xs-12">
      <img alt="Generic placeholder image" class="featurette-image img-responsive" src="/images/q/<? echo $book->quest->id; ?>.jpg"><a class="descr" href="#lab">
          <h2><? echo $book->quest->title; ?></h2>
          <p>
            <span><i class="ico-ppl"></i><i class="ico-ppl"></i><i class="ico-ppl noactive"></i><i class="ico-ppl noactive"></i>2 - 4 игрока</span>
            <span><i class="ico-loc"></i><? echo $book->quest->addres; ?></span>
          </p>
        </a>
    </div>
    <div class="col-sm-6 col-xs-12 shad">
      <div class="text-center">
        <h3>Мы ждем вас</h3>
        <p>
          <?
            $week=array(0=>"Воскресенье", "Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
            $st = substr($book->date, -4, 2).'/'.substr($book->date, -2, 2).'/'.substr($book->date, 0, 4);
            $time = strtotime($st);
          ?>
          <small><? echo $week[date('w',$time)];?></small>
          <span><? echo substr($book->date, -4, 2); ?>.<? echo substr($book->date, -2, 2); ?></span><em>в</em><span><? echo $book->time; ?></span>
        </p>
        <div class="priceTbl">
          <div class="priceRow">
            <span class="dashed"></span><span class="price"><? echo $book->price; ?><em>руб.</em></span><span class="dashed"></span>
          </div>
        </div>
        <p class="you_phone">Ваш номер телефона:<a><? echo Yii::app()->getModule('user')->user()->phone; ?></a></p>
        <div class="btn btn-default btn-success">ПОдтвержден<div class="glyphicon glyphicon-ok"></div>
        </div>
        <div class="btn btn-default btn-blank">снять бронь</div>
      </div>
    </div>
  </div>
  <div class="row"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>

  <? } ?>
</div>