<? $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");


  $currency = '<em class="rur"><em>руб.</em></em>';
  if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){
    $currency = '<em content="〒" class=""><em style="font-style:normal;">〒</em></em>';
  }
?>
<div class="jumbotron">
  <div class="row">
    <div class="col-xs-12 text-center cabinet">
      <span class="name"><?=Yii::app()->getModule('user')->user()->username?></span>
      <span class="phone"><?
        if (Yii::app()->getModule('user')->user()->phone == '00000') // after vk auth
          echo '';
        else
          echo Yii::app()->getModule('user')->user()->phone;
      ?></span>
      <span>
        <a href="#" id="edit_profile" data-toggle="modal" data-target="#myModalEditProfile">
          <i class="edit-ico"></i>Редактировать
        </a>
      </span>
      <span>
        <a href="/user/logout">
          <i class="logout-ico"></i>Выйти
        </a>
      </span>
    </div>
  </div>
</div>
<div class="container-fluid myQuests">
  <div class="row">
    <div class="col-xs-12 text-center">
      <div class="clearfix"></div>
      <a href="#next_books" role="tab" data-toggle="tab" class="h2 twotab active">Активные квесты</a>
      <a href="#prev_books" role="tab" data-toggle="tab" class="h2 twotab">прошедшие квесты</a>
      <hr class="fadeOut">
    </div>
  </div>
  <div class="tab-content">
    <div class="tab-pane" id="prev_books">

      <? if (isset($bookings_old)) foreach($bookings_old AS $book) { ?> 

      <div class="row ModalBook" id="row_book_<?=$book['id']?>">
        <div class="col-sm-6 col-xs-12">
          <img alt="Generic placeholder image" class="featurette-image img-responsive" src="/images/<?=$book['quest']['cover']?>">
            <a class="descr" href="#lab">
              <h2><?=$book['quest']['title']?></h2>
              <p class="quest_info">
                <span>
                  <i class="icon icon-user"></i>
                  <i class="icon icon-user"></i>
                  <i class="icon icon-user noactive"></i>
                  <i class="icon icon-user noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
                </span>
                <span>
                  <i class="icon icon-point"></i><?=$book['location']['address']?>
                </span>
              </p>
            </a>
        </div>
        <div class="col-sm-6 col-xs-12 shad">
          <div class="text-center">
            <h3>Вы играли</h3>
            <p>
              <?
                $week=array(0=>"Воскресенье", "Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
                $st = substr($book['date'], -4, 2).'/'.substr($book['date'], -2, 2).'/'.substr($book['date'], 0, 4);
                $time = strtotime($st);
              ?>
              <small><?=$week[date('w',$time)]?></small>
              <span><?=substr($book['date'], -2, 2)?>.<?=substr($book['date'], -4, 2)?></span><em>в</em><span><?=$book['time']?></span>
            </p>
            <div class="priceTbl">
              <div class="priceRow">
                <span class="dashed"></span>
                <span class="price"><?=$book['price']?><?=$currency?></span>
                <span class="dashed"></span>
              </div>
            </div>
            <p class="you_phone">Ваш номер телефона: <input type="text" disabled value="<? echo Yii::app()->getModule('user')->user()->phone; ?>" ></p>
            <!-- <div class="btn btn-default btn-success">ПОдтвержден<i class="glyphicon glyphicon-ok"></i></div> -->
            <? if ($book['result'] == '00:00' || $book['result'] == '60' || $book['result'] == '0' || $book['result'] == '00' || $book['result'] == '') { ?>
              <div class="btn btn-default btn-blank">Квест не пройден</div>
            <? } else { ?>
              <div class="btn btn-default btn-success">Ваш результат <?=$book['result']?></div>
            <? } ?>
          </div>
        </div>
      </div>
      <div class="row" id="row_fade_<?=$book['id']?>"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>

      <? } ?>      
    </div>
    <div class="tab-pane active" id="next_books">

      <? if (isset($bookings)) foreach($bookings AS $book) { ?> 

      <div class="row ModalBook" id="row_book_<?=$book['id']?>">
        <div class="col-sm-6 col-xs-12">
          <img alt="Profile" class="featurette-image img-responsive" src="/images/<?=$book['quest']['cover']?>">
            <a class="descr" href="#lab">
              <h2><?=$book['quest']['title']?></h2>
              <p class="quest_info">
                <span>
                  <i class="icon icon-user"></i>
                  <i class="icon icon-user"></i>
                  <i class="icon icon-user noactive"></i>
                  <i class="icon icon-user noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
                </span>
                <span>
                  <i class="icon icon-point"></i><?=$book['location']['address']?>
                </span>
              </p>
            </a>
        </div>
        <div class="col-sm-6 col-xs-12 shad">
          <div class="text-center">
            <h3>Мы ждем вас</h3>
            <p>
              <?
                $week=array(0=>"Воскресенье", "Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
                $st = substr($book['date'], -4, 2).'/'.substr($book['date'], -2, 2).'/'.substr($book['date'], 0, 4);
                $time = strtotime($st);
              ?>
              <small><?=$week[date('w',$time)]?></small>
              <span><?=substr($book['date'], -2, 2)?>.<?=substr($book['date'], -4, 2)?></span><em>в</em><span><?=$book['time']?></span>
            </p>
            <div class="priceTbl">
              <div class="priceRow">
                <span class="dashed"></span><span class="price"><?=$book['price']?><?=$currency?></span><span class="dashed"></span>
              </div>
            </div>
            <p class="you_phone">Ваш номер телефона: <input type="text" disabled value="<?=Yii::app()->getModule('user')->user()->phone?>" ></p>
            <div class="btn btn-default btn-success">Подтвержден<i class="glyphicon glyphicon-ok"></i></div>
            <div class="btn btn-default btn-blank decline-book" data-book-id="<?=$book['id']?>">снять бронь</div>
          </div>
        </div>
      </div>
      <div class="row" id="row_fade_<?=$book['id']?>"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>
      <? } ?>
    </div>
  </div>
</div>