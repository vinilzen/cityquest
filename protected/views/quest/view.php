<?php
  /* @var $this QuestController */
  /* @var $model Quest */
  $this->pageTitle = $model->page_title;
  $this->description = $model->description?$model->description:'';
  $this->keywords = $model->keywords?$model->keywords:'';
  $this->pageImg = '/images/q/'.$model->id.'.jpg';
  $currency = '<em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em>';
  if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){
    $currency = '<em itemprop="priceCurrency" content="〒" class=""><em style="font-style:normal;">〒</em></em>';
  }
?>

<script type="text/javascript">
    var user_name = '<?=(!Yii::app()->user->isGuest) ? Yii::app()->getModule('user')->user()->username : ''?>',
        user_phone = '<?=(!Yii::app()->user->isGuest) ? Yii::app()->getModule('user')->user()->phone : ''?>';
</script>

<div class="jumbotron quest">
  <div itemscope itemtype="http://schema.org/Product" class="container text-center">
    <div class="row">
    <? $photos = '';
       $zindex = 10;
       $num = 1;
    ?>
      <div id="carouselPhoto" class="carousel slide img-container" data-ride="carousel">
        <? if (count($model->photo)>0) { ?>
        <ol class="carousel-indicators">
          <li data-target="#carouselPhoto" data-slide-to="0" class="active"></li>
          <? foreach ($model->photo AS $photo) {
            $photos .= '<div class="item"><img src="/images/'.$photo->name.'"></div>';
            echo '<li data-target="#carouselPhoto" data-slide-to="'.$num++.'"></li>';
          } ?>
        </ol>
        <? } ?>
        <div class="carousel-inner" role="listbox">
          <div class="item active"><img src="/images/<?=$model->cover?>"></div>
          <?=$photos?>
        </div>
      </div>

      <div class="col-sm-12 col-black">
        <p class="text-center quest-type hidden">
          <i class="icon icon-spiral"></i><span class="hidden-xs">Обычные</span>
        </p>
        <h1 itemprop="name" id='quest_title'>
          <?=$model->title?>
          <? if (isset($prev)) {
                echo '<a class="arrow-quest arrow-left" title="'.$prev->title.'" href="/quest/'.$prev->link.'">'.
                      '<span class="glyphicon glyphicon-menu-left"></span></a>';
              }
              if (isset($next)) {
                echo '<a class="arrow-quest arrow-right" title="'.$next->title.'" href="/quest/'.$next->link.'">'.
                      '<span class="glyphicon glyphicon-menu-right"></span></a>';
              }
          ?>
        </h1>
        <p class="description h2" itemprop="description"><?=$model->content?></p>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row quest_description">
      <div class="col-md-6 col-lg-5 col-xlg-4 col-xs-12">
        <div class="container-fluid quest_description_left">
          <div class="row">
            <div class="col-md-4 col-sm-3 col-xs-12 text-left">
              <i class="icon icon-alarm"></i>
              <p>
                <em class="gotham">60</em>минут
              </p>
            </div>  
            <div class="col-md-8 col-sm-3 col-xs-12 text-left">
              <i class="icon icon-user hidden-sm"></i><i class="icon icon-user hidden-sm"></i><i class="icon icon-user noactive hidden-sm"></i><i class="icon icon-user noactive last-man"></i>
              <p>
                <em class="gotham">2-4</em><?=Yii::t('app','players')?>
              </p> 
            </div>
            <div class="clearfix hidden-sm"></div>
            <div class="col-md-4 col-sm-3 col-xs-5 text-left">
              <? if ($model->difficult == 2) { ?>
                <i class="icon icon-hexahedron"></i>
                <p><?=Yii::t('app','High')?></p>
              <? } elseif ($model->difficult == 1) { ?>
                <i class="icon icon-square"></i>
                <p><?=Yii::t('app','Medium')?></p>
              <? } else { ?>
                <i class="icon icon-triangle"></i>
                <p><?=Yii::t('app','Base')?></p>
              <? } ?>
            </div>  
            <div class="col-md-8 col-sm-3 col-xs-6 text-left">
              <? if ($model->actor) { ?>
                <i class="icon icon-mask"></i>
                <p><?=Yii::t('app','With actor')?></p>
              <? } ?>
            </div>  
          </div>
        </div>
      </div>
      <div class="col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-3 col-xlg-3 col-xlg-offset-5 col-xs-12">
        <div class="container-fluid quest_description_right">
          <div class="row">
            <div class="col-xs-12 col-md-12 col-sm-3 text-left">
              <i class="icon icon-metro"></i>
              <p>
                <span class="metro-title"><?=$model->metro?></span>
              </p>
            </div>
            <div class="col-xs-12 col-md-12 col-sm-9 text-left">
              <i class="icon icon-point"></i>
              <p><?=$model->addres?>
                <br>
                <?=$model->addres_additional?>
                <br>
                <a href="https://www.google.com/maps/preview?q=<?=$cities[$model->city_id]->name?>,+<?=urlencode($model->addres)?>" target="_blank"><?=Yii::t('app','How to get there')?>?</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container container-xlg">
  <div class="row">
    <div class="col-xs-12 text-center">
      <a href="#schedule" class="h2 twotab active" role="tab" data-toggle="tab">
        <?=($model->status == 2)?Yii::t('app','Schedule'):Yii::t('app','Inactive quest')?>
      </a>
      <a href="#winner" class="h2 twotab" role="tab" data-toggle="tab">Победители</a>
      <hr class="fadeOut">
    </div>
    <? if ($model->status == 2) { ?>
    <div class="clearfix"></div>
    <div class="col-xs-12 ovs tab-content">
      <div class="row quests_schedules fade in quest_schedule tab-pane active" role="tabpanel" id="schedule">
      <?
      $days = Yii::app()->params['days'];
      $month = Yii::app()->params['month'];
      $endDate = strtotime( '+'.Yii::app()->params['offset'].' day' );
      $currDate = strtotime( 'now' );
      $dayArray = array();

      function makeDayArray( ){
        $days = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
        $month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря' );
        $endDate   = strtotime( '+'.Yii::app()->params['offset'].' day' );
        $currDate  = strtotime( 'now' );
        $dayArray  = array();

        do{
          $dayArray[] = array(
            'day_name' => $days[intval(date( 'N' , $currDate ))-1],
            'month_name' => $month[intval(date( 'n' , $currDate ))-1],
            'day' => date( 'j' , $currDate ),
            'date' => date('Ymd', $currDate),
            'month' => date('m', $currDate),
            'year' => date('Y', $currDate),
          );
          $currDate = strtotime( '+1 day' , $currDate );
        } while( $currDate<=$endDate );

        return $dayArray;
      }

      $next_2week = makeDayArray(); ?>

          <? foreach ($next_2week as $value) {

            if ( $value['day_name'] == 'суббота' ||  $value['day_name'] == 'воскресенье' || in_array($value['date'], $holidays)) {
              $workday = 0;
              $priceAm = $model->price_weekend_am;
              $pricePm = $model->price_weekend_pm;
            } else {
              $workday = 1;
              $priceAm = $model->price_am;
              $pricePm = $model->price_pm;
            }

            if (isset($promo_days[$value['date']])) {
              $priceAm = $promo_days[$value['date']]->price_am;
              $pricePm = $promo_days[$value['date']]->price_pm;
            }

          ?>
              
          <div class="col-xs-1 col-sm-1">
            <div class="curent_date <? echo !$workday ? 'weekend' : ''; ?>">
              <span class="quest_date"><em><?=$value['day']?>.</em><?=$value['month']?></span>
              <small><?=$value['day_name']?></small>
            </div>
            <? if (isset($promo_days[$value['date']])) { ?>
              <div class="curent_date">
                <span class="promo-flag">Акция</span>
              </div>
            <? } ?>
          </div>
          <div class="col-xs-12 times">
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="times-line">

              <? foreach ($times as $k=>$time) {

                if ($workday){
                  if ($k>6 && $k<14) $price = $priceAm;
                  else $price = $pricePm;

                  if ($model->id == 15 ){
                    if ($k<7) $price = $priceAm;
                    else $price = $pricePm;

                    if ($k<1) $price = $pricePm;
                  }

                } else {
                  if ($k<10) $price = $priceAm;
                  else $price = $pricePm;
                }

                $dis = 0;
                $near = 0;
                $time_str = $value['year'].'-'.$value['month'].'-'.$value['day'].' '.$time;
                $timastamp_quest_start = strtotime( $value['year'].'-'.$value['month'].'-'.$value['day'].' '.$time);
                if ( $timastamp_quest_start < (strtotime( 'now' )+ $model->time_preregistration ) ) $near = 1;

                $disabled = '';
                $my_quest = '';
                if ( isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {
                  $disabled = ' disabled="disabled"';
                  if ( $booking[$value['date']][$time]['competitor_id'] == Yii::app()->user->id ) {
                    $my_quest = ' myDate ';
                  }
                }

                $empty = '';
                if ($k != 0 && $k<8 && $model->id != 15) {
                  $empty = ' empty_btn ';
                  $disabled = ' disabled="disabled"';
                }


                ?>
                <div  type="button" 
                  data-name="<?=!Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''?>" 
                  data-phone="<?=!Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''?>" 
                  data-time="<?=$time?>" 
                  data-quest="<?=$model->id?>" 
                  data-quest-cover="<?=$model->cover?>" 
                  data-ymd="<?=$value['date']?>" 
                  data-date="<?=$value['day']?> <?=$value['month_name']?>" 
                  data-day="<?=$value['day_name']?>" 
                  data-d="<?=$value['day']?>" 
                  data-m="<?=$value['month']?>" 
                  data-price="<?=$price?>" 
                  class="btn btn-q <?=$my_quest.$empty?>
                      <? echo ($near || $dis) ? 'disabled' : '';
                      if ($workday && $k > 2 && $k < 7 && $model->id != 15) echo ' invisible';?>" 
                      <? if (($workday && $k > 2 && $k < 7 && $model->id != 15) || ($empty != '')) echo ' style="display:none;" '; ?>
                      <?=$disabled?>><?=$time?>
                </div>
              <? } ?>

            </div>
            <?
              $line_through = '';
              $promo_day = '';
              if (isset($promo_days[$value['date']]))
                $line_through = 'through';

              if ($workday) { ?>

              <div class="price-line">
                <div class="priceTbl workPrice1" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="price" itemprop="price" content="<?=$pricePm?>" style="padding:0;"><em class="<?=$line_through?>"><?=$pricePm?></em> <?=$currency?></span>
                  </div>
                </div>
                <div class="priceTbl workPrice2 <? if ($model->id==15) echo 'workPrice23'; ?>" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<?=$priceAm?>"><em class="<?=$line_through?>"><?=$priceAm?></em> <?=$currency?></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
                <div class="priceTbl workPrice3" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<?=$pricePm?>"><em class="<?=$line_through?>"><?=$pricePm?></em> <?=$currency?></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
              </div>


              <? if (isset($promo_days[$value['date']])) { ?>
              <div class="price-line promo-day">
                <div class="priceTbl workPrice1" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="price" itemprop="price" content="<?=$promo_days[$value['date']]->price_pm?>" style="padding:0;">
                      <strong><?=$promo_days[$value['date']]->price_pm?></strong> <?=$currency?>
                    </span>
                  </div>
                </div>
                <div class="priceTbl workPrice2 <? if ($model->id==15) echo 'workPrice23'; ?>" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price" itemprop="price" content="<?=$promo_days[$value['date']]->price_am?>">
                      <strong><?=$promo_days[$value['date']]->price_am?></strong> <?=$currency?>
                    </span>
                    <span class="dashed"></span>
                  </div>
                </div>
                <div class="priceTbl workPrice3" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price" itemprop="price" content="<?=$promo_days[$value['date']]->price_pm?>">
                      <strong><?=$promo_days[$value['date']]->price_pm?></strong> <?=$currency?>
                    </span>
                    <span class="dashed"></span>
                  </div>
                </div>
              </div>
              <? } ?>

            <? } else { ?>
              <div class="price-line weekend">
                <div class="priceTbl weekendPrice2 " title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<?=$pricePm?>">
                      <em class="<?=$line_through?>"><?=$pricePm?></em> <?=$currency?></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
              </div>
              <? if (isset($promo_days[$value['date']])) { ?>

                <div class="price-line weekend promo-day">
                  <div class="priceTbl weekendPrice2 " title="Цена за команду" data-toggle="tooltip">
                    <div class="priceRow">
                      <span class="dashed"></span>
                      <span class="price" itemprop="price" content="<?=$promo_days[$value['date']]->price_pm?>">
                        <?=$promo_days[$value['date']]->price_pm?> <?=$currency?>
                      </span>
                      <span class="dashed"></span>
                    </div>
                  </div>
                </div>

              <? } ?>
            <? } ?>
            </div>
          </div>
          <div class="clearfix"></div>
      <? } ?>
      </div>
      <div class="row tab-pane fade" role="tabpanel" id="winner">
        <div class="col-sm-10 col-sm-offset-1">
          
        <? $month_array = array(
            '01'=>'январь',
            '02'=>'февраль',
            '03'=>'март',
            '04'=>'апрель',
            '05'=>'май',
            '06'=>'июнь',
            '07'=>'июль',
            '08'=>'август',
            '09'=>'сентябрь',
            '10'=>'октябрь',
            '11'=>'ноябрь',
            '12'=>'декабрь',
          ); ?>
          <div class="text-center btn-group-month" role="group">
          <? foreach ($month_array as $key => $value){
              if ($key == date('m')) {
                echo '<div class="btn btn-xs btn-link active">'.$value.'</div>';
              } else {
                $disabled = '';
                if ($key > date('m')) $disabled = ' disabled';
                echo '<div class="btn btn-xs btn-link'.$disabled.'">'.$value.'</div>';
              }
          } ?>
          </div>
          <div class="clearfix"></div>
          <? foreach ($bookings_winner_array AS $date) { ?>
            <? foreach ($date AS $b) { ?>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <a href="/result/<?=$b->id?>" class="thumbnail thumbnail-transp">
                  <img class="img-responsive" src="/images/winner_photo/<?=$b->winner_photo?>" alt="">
                  <div class="caption">
                    <p>
                      <span class="pull-left">
                        <i class="icon icon-alarm"></i>
                        <?=$b->result?>
                      </span>
                      <?  
                        $year = substr($b->date, 0, 4);
                        $month = substr($b->date, 4,2);
                        $day = (int)(substr($b->date, -2));

                        $month_array = array(
                          '01'=>'января',
                          '02'=>'февраля',
                          '03'=>'марта',
                          '04'=>'апреля',
                          '05'=>'мая',
                          '06'=>'июня',
                          '07'=>'июля',
                          '08'=>'августа',
                          '09'=>'сентября',
                          '10'=>'октября',
                          '11'=>'ноября',
                          '12'=>'декабря',
                        );
                        
                      ?>
                      <span class="pull-right">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <?=$day; ?> <?=$month_array[$month]?> <?=$year?>
                      </span>
                    </p>
                  </div>
                </a>
              </div>
            <? } ?>
          <? } ?>
        </div>
      </div>
    </div>
    <? } ?>
  </div>
</div>

<? if (isset($other_quests) && count($other_quests) > 0) { ?>
<div class="container-fluid bottom_quest" id="quests">
  <div class="row">
  <? $counter = 1;
    foreach ($other_quests as $quest) {
      $counter++;
      if ($counter<5) {
  ?>
    <div class="col-xs-12 col-md-4 col-sm-6 col-lg-4 col-xlg-4 item">
      <img class="featurette-image img-responsive"
        alt="<?=CHtml::encode($quest->title)?>" 
        src="/images/<?=$quest->cover?>">
      <a class="descr" href="/quest/<?=$quest->link?>">
        <h3 class="h2"><?=CHtml::encode($quest->title)?></h3>
        <p class="quest_info">
            <span>
                <i class="icon icon-user"></i>
                <i class="icon icon-user"></i>
                <i class="icon icon-user noactive"></i>
                <i class="icon icon-user noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
            </span>
            <span><i class="icon icon-point"></i><?=CHtml::encode($quest->addres)?></span>
        </p>
      </a>
    </div>  
    <? }
  } ?>
  </div>
</div>
<? } ?>