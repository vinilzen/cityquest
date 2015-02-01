<?php
/* @var $this QuestController */
/* @var $model Quest */
$this->pageTitle= Yii::app()->name.' - '.$model->title;
$this->pageImg= '/images/q/'.$model->id.'.jpg';
?>

<script type="text/javascript">
    var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>',
        user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>';
</script>

<div class="jumbotron quest" style="background-image: url(../images/q/<? echo $model->id; ?>.jpg); 
  <? if ($model->id == 2) { echo 'background-position: center 45%;'; } ?> " >
  <div itemscope itemtype="http://schema.org/Product" class="container text-center">
    <div class="row">
      <div class="col-md-10 col-md-offset-1 col-sm-12">
        <h1 itemprop="name" id='quest_title'><? echo $model->title; ?></h1>
        <h2 itemprop="description"><? echo $model->content; ?></h2>
      </div>
    </div>
    <div class="row descr_quest">
      <div class="col-xs-12 col-sm-4 col-md-3 tl">
        <p><i class="duration"></i><span><em>60</em>минут</span></p>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <p><i class="ico-ppl"></i><i class="ico-ppl"></i><i class="ico-ppl noactive"></i><i class="ico-ppl noactive"></i>
          <span class="people"><em>2 - 4</em>игрока</span>
        </p>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3 tr">
        <p><i class="metro"></i><span class="metro-title"><? echo $model->metro; ?></span></p>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-3">
        <p><i class="ico-loc"></i><span class="addr-quest"><? echo $model->addres; ?></span></p>
      </div>
    </div>
  </div>
</div>



<div class="container container-xlg">
  <div class="row">
    <div class="col-xs-12 text-center">
      <? if ($model->status == 2) { ?>
        <h2 class="twotab active">Расписание</h2><!-- <h2 class="twotab">Победители</h2> -->
      <? } else { ?>
        <h2 class="twotab active">Неактивный квест</h2><!-- <h2 class="twotab">Победители</h2> -->
      <? } ?>
      <hr class="fadeOut">
    </div>
    <? if ($model->status == 2) { ?>
    <div class="clearfix"></div>
    <div class="col-xs-12 ovs">
      <div class="row quests_schedules quest_schedule">

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
              $priceAm = Yii::app()->params['price_weekend_AM'];
              $pricePm = Yii::app()->params['price_weekend_PM'];
            } else {
              $workday = 1;
              $priceAm = Yii::app()->params['price_workday_AM'];
              $pricePm = Yii::app()->params['price_workday_PM'];
            }

          ?>
              
          <div class="col-xs-1 col-sm-1">
            <div class="curent_date <? echo !$workday ? 'weekend' : ''; ?>">
              <span><em><? echo $value['day']; ?>.</em><? echo $value['month']; ?></span>
              <small><? echo $value['day_name']; ?></small>
            </div>
          </div>
          <div class="col-xs-12 times">
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="times-line">

              <? foreach ($times as $k=>$time) {

                if ($workday){
                  if ($k>6 && $k<14) $price = $priceAm;
                  else $price = $pricePm;
                } else {
                  if ($k<10) $price = $priceAm;
                  else $price = $pricePm;
                }

                $dis = 0;
                $near = 0;
                $time_str = $value['year'].'-'.$value['month'].'-'.$value['day'].' '.$time;
                $timastamp_quest_start = strtotime( $value['year'].'-'.$value['month'].'-'.$value['day'].' '.$time);
                if ( $timastamp_quest_start < (strtotime( 'now' )+(40*60)) ) $near = 1;

               // echo '<!--('.$time_str.') '.$timastamp_quest_start.' = '.(strtotime( 'now' )+(40*60)).' -->';

                $disabled = '';
                $my_quest = '';
                if ( isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {
                  $disabled = ' disabled="disabled"';
                  if ( $booking[$value['date']][$time]['competitor_id'] == Yii::app()->user->id ) {
                    $my_quest = ' myDate ';
                  }
                }

                $empty = '';
                if (($model->id == 3 || $model->id == 2 || $model->id == 4) && ($k != 0 && $k<8)) {
                  $empty = ' empty_btn ';
                  $disabled = ' disabled="disabled"';
                }


              ?>
                <div  type="button" 
                  data-name="<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>" 
                  data-phone="<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>" 
                  data-time="<? echo $time; ?>" 
                  data-quest="<? echo $model->id; ?>" 
                  data-ymd="<? echo $value['date']; ?>" 
                  data-date="<? echo $value['day']; ?> <? echo $value['month_name']; ?>" 
                  data-day="<? echo $value['day_name']; ?>" 
                  data-d="<? echo $value['day']; ?>" 
                  data-m="<? echo $value['month']; ?>" 
                  data-price="<? echo $price; ?>" 
                  class="btn btn-q <? echo $my_quest.$empty; ?>
                      <? echo ($near || $dis) ? 'disabled' : '';
                      if ($workday && $k > 2 && $k < 7 ) echo ' invisible';?>" 
                      <? if (($workday && $k > 2 && $k < 7) || ($empty != '')) echo ' style="display:none;" '; ?>
                      <? echo $disabled; ?>><? echo $time; ?>
                </div>
              <? } ?>

            </div>
            <?if ($workday) { ?>
              <div class="price-line">
                <div class="priceTbl workPrice1" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="price" itemprop="price" content="<? echo $pricePm?>" style="padding:0;"><? echo $pricePm; ?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                  </div>
                </div>
                <div class="priceTbl workPrice2" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<? echo $priceAm?>"><? echo $priceAm; ?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
                <div class="priceTbl workPrice3" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<? echo $pricePm?>"><? echo $pricePm; ?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
              </div>
            <? } else { ?>
              <div class="price-line weekend">
                <div class="priceTbl weekendPrice2" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<? echo $pricePm?>"><? echo $pricePm; ?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
              </div>
            <? } ?>
            </div>
          </div>
          <div class="clearfix"></div>
      <?  } ?>
      </div>
    </div>
    <? } ?>
  </div>
</div>