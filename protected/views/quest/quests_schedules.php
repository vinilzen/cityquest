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

  $next_2week = makeDayArray();

foreach ($next_2week as $value) {

  if ( $value['day_name'] == 'суббота' ||  $value['day_name'] == 'воскресенье' || in_array($value['date'], $holidays)) {
    $workday = 0;
    $priceAm = $model->price_weekend_am;
    $pricePm = $model->price_weekend_pm;
  } else {
    $workday = 1;
    $priceAm = $model->price_am;
    $pricePm = $model->price_pm;
  }

  $price_original_Am = $priceAm;
  $price_original_Pm = $pricePm;

  if (isset($promo_days[$value['date']])) {
    $priceAm = $promo_days[$value['date']]->price_am;
    $pricePm = $promo_days[$value['date']]->price_pm;
  } ?>
              
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
        if ($k != 0 && $k<8 && $model->id != 15 && $model->id != 19 && $model->id != 21) {
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
              if ($workday && $k > 2 && $k < 7 && $model->id != 15 && $model->id != 19 && $model->id != 21) echo ' invisible';?>" 
              <? if (($workday && $k > 2 && $k < 7 && $model->id != 15 && $model->id != 19 && $model->id != 21) || ($empty != '')) echo ' style="display:none;" '; ?>
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
            <span class="price" itemprop="price" content="<?=$price_original_Pm?>" style="padding:0;"><em class="<?=$line_through?>"><?=$price_original_Pm?></em> <?=$currency?></span>
          </div>
        </div>
        <div class="priceTbl workPrice2 <? if ($model->id==15) echo 'workPrice23'; ?>" title="Цена за команду" data-toggle="tooltip">
          <div class="priceRow">
            <span class="dashed">&nbsp;</span>
            <span class="price" itemprop="price" content="<?=$price_original_Am?>"><em class="<?=$line_through?>"><?=$price_original_Am?></em> <?=$currency?></span>
            <span class="dashed">&nbsp;</span>
          </div>
        </div>
        <div class="priceTbl workPrice3" title="Цена за команду" data-toggle="tooltip">
          <div class="priceRow">
            <span class="dashed">&nbsp;</span>
            <span class="price" itemprop="price" content="<?=$price_original_Pm?>"><em class="<?=$line_through?>"><?=$price_original_Pm?></em> <?=$currency?></span>
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
            <span class="price" itemprop="price" content="<?=$price_original_Pm?>">
              <em class="<?=$line_through?>"><?=$price_original_Pm?></em> <?=$currency?></span>
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