<?php
/* @var $this QuestController */
/* @var $model Quest */

if (0 && Yii::app()->user->name == 'admin' ){
	$this->menu=array(
    array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
		array('label'=>'List Quest', 'url'=>array('index')),
		array('label'=>'Create Quest', 'url'=>array('create')),
		array('label'=>'Update Quest', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete Quest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage Quest', 'url'=>array('admin')),
	);
}

?>

<script type="text/javascript">
    var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>',
      user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>';
</script>

<div class="jumbotron quest" style="background-image: url(../images/q/<? echo $model->id; ?>.jpg);">
  <div class="container text-center">
    <div class="row">
      <div class="col-md-10 col-md-offset-1 col-sm-12">
        <h1 id='quest_title'><? echo $model->title; ?></h1>
        <p><? echo $model->content; ?></p>
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
      <h2 class="twotab active">Расписание</h2>
      <h2 class="twotab">Победители</h2>
      <hr class="fadeOut">
    </div>
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
        $endDate   = strtotime( '+14 day' );
        $currDate  = strtotime( 'now' );
        $dayArray  = array();

        do{
          $dayArray[] = array(
            'day_name' => $days[intval(date( 'N' , $currDate ))-1],
            'month_name' => $month[intval(date( 'n' , $currDate ))-1],
            'day' => date( 'j' , $currDate ),
            'date' => date('Ymd', $currDate),
            'month' => date('m', $currDate),
          );
          $currDate = strtotime( '+1 day' , $currDate );
        } while( $currDate<=$endDate );

        return $dayArray;
      }

      $next_2week = makeDayArray(); ?>

          <? foreach ($next_2week as $value) {
            if ( $value['day_name'] == 'суббота' ||  $value['day_name'] == 'воскресенье')
            {
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
            <div class="curent_date <? echo $value['day_name'] == 'суббота' || $value['day_name'] == 'воскресенье' ? 'weekend' : ''; ?>">
              <span><em><? echo $value['day']; ?>.</em><? echo $value['month']; ?></span><small><? echo $value['day_name']; ?></small>
            </div>
          </div>
          <div class="col-xs-12 times">
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
                if ($time < date('H:i', strtotime( '+0 hours' )) ) $near = 1;

                $disabled = '';
                $my_quest = '';
                if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {
                  $disabled = ' disabled="disabled"';
                  if ( $booking[$value['date']][$time]['competitor_id'] == Yii::app()->user->id ) {
                    $my_quest = ' myDate ';
                  }
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
                      class="btn btn-q <? echo $my_quest; ?> <? echo (($value['date'] === date('Ymd') && $near) || $dis) ? 'disabled' : '';
                          if ($workday && $k > 2 && $k < 7 ) echo ' invisible';?>" <?
                          
                          echo $disabled; ?>><? echo $time; ?></div>
              <? } ?>

            </div>
            <?if ($workday) { ?>
              <div class="price-line">
                <div class="priceTbl workPrice1">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price"><? echo $pricePm; ?> <em class="rur"><em>руб.</em></em></span>
                    <span class="dashed"></span>
                  </div>
                </div>
                <div class="priceTbl workPrice2">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price"><? echo $priceAm; ?> <em class="rur"><em>руб.</em></em></span>
                    <span class="dashed"></span>
                  </div>
                </div>
                <div class="priceTbl workPrice3">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price"><? echo $pricePm; ?> <em class="rur"><em>руб.</em></em></span>
                    <span class="dashed"></span>
                  </div>
                </div>
              </div>
            <? } else { ?>
              <div class="price-line weekend">
                <div class="priceTbl weekendPrice1">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price"><? echo $priceAm; ?> <em class="rur"><em>руб.</em></em></span>
                    <span class="dashed"></span>
                  </div>
                </div>
                <div class="priceTbl weekendPrice2">
                  <div class="priceRow">
                    <span class="dashed"></span>
                    <span class="price"><? echo $pricePm; ?> <em class="rur"><em>руб.</em></em></span>
                    <span class="dashed"></span>
                  </div>
                </div>
              </div>
            <? } ?>
          </div>
          <div class="clearfix"></div>
      <? } ?>
      </div>
    </div>
  </div>
</div>