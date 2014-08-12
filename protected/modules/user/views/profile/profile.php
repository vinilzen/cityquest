<? $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile"); ?>

<div class="jumbotron">
  <div class="row">
    <!-- 
    <div class="col-xs-12 text-center cabinet visible-xs moveUp">
      <img class="img-circle" height="135" src="/img/ava.jpg" width="135">
    </div>
 -->
    <div class="col-xs-12 text-center cabinet">
      <span class="name"><? echo Yii::app()->getModule('user')->user()->username; ?></span>
      <span class="phone"><? echo Yii::app()->getModule('user')->user()->phone; ?></span>
      <!-- <img class="img-circle hidden-xs" height="135" src="/img/ava.jpg" width="135"> -->
      <span><a href="#" id="edit_profile" data-toggle="modal" data-target="#myModalEditProfile"><i class="edit-ico"></i>Редактировать</a></span>
      <span><a href="/user/logout"><i class="logout-ico"></i>Выйти</a></span>
    </div>

  </div>
</div>

<div class="container-fluid myQuests">
  <div class="row">
    <div class="col-xs-12 text-center">
      <a href="#next_books" role="tab" data-toggle="tab" class="h2 twotab active">Активные квесты</a>
      <a href="#prev_books" role="tab" data-toggle="tab" class="h2 twotab">прошедшие квесты</a>
      <hr class="fadeOut">
    </div>
  </div>
  <div class="tab-content">
    <div class="tab-pane" id="prev_books">

      <? if (isset($bookings_old)) foreach($bookings_old AS $book) { ?> 

      <div class="row ModalBook" id="row_book_<? echo $book->id; ?>">
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
              <small><? echo $week[date('w',$time)]; ?></small>
              <span><? echo substr($book->date, -2, 2); ?>.<? echo substr($book->date, -4, 2); ?></span><em>в</em><span><? echo $book->time; ?></span>
            </p>
            <div class="priceTbl">
              <div class="priceRow">
                <span class="dashed"></span><span class="price"><? echo $book->price; ?><em class="rur"><em>руб.</em></em></span><span class="dashed"></span>
              </div>
            </div>
            <p class="you_phone">Ваш номер телефона: <input type="text" disabled value="<? echo Yii::app()->getModule('user')->user()->phone; ?>" ></p>
            <!-- <div class="btn btn-default btn-success">ПОдтвержден<i class="glyphicon glyphicon-ok"></i></div> -->
            <div class="btn btn-default btn-blank" data-book-id="<? echo $book->id; ?>">Результат?</div>
          </div>
        </div>
      </div>
      <div class="row" id="row_fade_<? echo $book->id; ?>"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>

      <? } ?>      
    </div>
    <div class="tab-pane active" id="next_books">

      <? if (isset($bookings)) foreach($bookings AS $book) { ?> 

      <div class="row ModalBook" id="row_book_<? echo $book->id; ?>">
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
              <small><? echo $week[date('w',$time)]; ?></small>
              <span><? echo substr($book->date, -2, 2); ?>.<? echo substr($book->date, -4, 2); ?></span><em>в</em><span><? echo $book->time; ?></span>
            </p>
            <div class="priceTbl">
              <div class="priceRow">
                <span class="dashed"></span><span class="price"><? echo $book->price; ?><em class="rur"><em>руб.</em></em></span><span class="dashed"></span>
              </div>
            </div>
            <p class="you_phone">Ваш номер телефона: <input type="text" disabled value="<? echo Yii::app()->getModule('user')->user()->phone; ?>" ></p>
            <div class="btn btn-default btn-success">ПОдтвержден<i class="glyphicon glyphicon-ok"></i></div>
            <div class="btn btn-default btn-blank decline-book" data-book-id="<? echo $book->id; ?>">снять бронь</div>
          </div>
        </div>
      </div>
      <div class="row" id="row_fade_<? echo $book->id; ?>"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>

      <? } ?>

    </div>
  </div>
</div>