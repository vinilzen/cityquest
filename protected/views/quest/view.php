<?php
  /* @var $this QuestController */
  /* @var $model Quest */
  $this->pageTitle= Yii::app()->name.' - '.$model->page_title;
  $this->description= $model->description?$model->description:'';
  $this->keywords= $model->keywords?$model->keywords:'';
  $this->pageImg= '/images/q/'.$model->id.'.jpg';
?>

<script type="text/javascript">
    var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>',
        user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>';
</script>

<div class="jumbotron quest">
  <div itemscope itemtype="http://schema.org/Product" class="container text-center">
    <div class="row">
      <div class="img-container" style="background-image: url(../images/q/<?=$model->id?>.jpg);"></div>
      <div style="display:none;" itemscope itemtype="http://schema.org/ImageObject">
        <h2 itemprop="name"> Квест в <?=$cities[$model->city_id]->name?> "<?=$model->title?>"</h2>
          <img src="/images/q/<?=$model->id?>.jpg" itemprop="contentUrl" />
          <span itemprop="description"><?=$this->description?></span>
      </div>
      <div style="display: none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <meta itemprop="bestRating" content="5" />
        <meta itemprop="ratingValue" content="5" />
        <meta itemprop="ratingCount" content="171" />
      </div>
      <div class="col-sm-12 col-black">

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
        <h2 itemprop="description"><?=$model->content?></h2>

        <div class="descr_quest">
          <i class="duration iconm-Time"></i>
          <p class="time-text">
            <span class="time-mt"><em>60</em>минут</span>
          </p>
          <p class="pull-right"><i class="ico-ppl iconm-Man"></i><i class="ico-ppl iconm-Man"></i><i class="ico-ppl iconm-Man noactive"></i><i class="ico-ppl iconm-Man noactive"></i>
            <span class="people"><em>2-4</em><?=Yii::t('app','players')?></span>
          </p>
        </div>
      </div>
      <div class="col-sm-12 col-br descr_quest">
          <div class="text-left tr text-metro">
            <i class="metro"></i>
            <p>
              <span class="metro-title"><?=$model->metro?></span>
            </p>
          </div>
          <div class="text-left text-pin">
            <i class="ico-loc iconm-Pin"></i>
            <p>
              <span class="addr-quest">
                <span><?=$model->addres?></span><br>
                <?=($model->id!=15)?Yii::t('app','Free on site parking is 1.5 hours').'.':'Проход и проезд со стороны <br>ул. Нижняя Красносельская д.15/17 в арку'?><br>
                <a href="https://www.google.com/maps/preview?q=<?=$cities[$model->city_id]->name?>,+<?=urlencode($model->addres)?>" target="_blank"><?=Yii::t('app','How to get there')?>?</a>
              </span>
            </p>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="container container-xlg">
  <div class="row">
    <div class="col-xs-12 text-center">
      <h2 class="twotab active">
        <?=($model->status == 2)?Yii::t('app','Schedule'):Yii::t('app','Inactive quest')?>
      </h2>
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
                if ($k != 0 && $k<8) {
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

<? if (isset($other_quests) && count($other_quests) > 0) { ?>
<div class="container-fluid bottom_quest" id="quests">
  <div class="row">
  <? $counter = 1;
    foreach ($other_quests as $quest) { ?>
    <div class="col-xs-12 col-md-6 col-sm-12 col-lg-4 col-xlg-4 item">
    <? $counter = 0; ?>
      <img class="featurette-image img-responsive"
        alt="<?=CHtml::encode($quest->title)?>" 
        src="/images/q/<?=$quest->id?>.jpg">
      <a class="descr" href="/quest/<?=$quest->link?>">
        <h2><?=CHtml::encode($quest->title)?></h2>
        <p>
            <span>
                <i class="ico-ppl iconm-Man"></i>
                <i class="ico-ppl iconm-Man"></i>
                <i class="ico-ppl iconm-Man noactive"></i>
                <i class="ico-ppl iconm-Man noactive"></i>2 - 4 <?=Yii::t('app','players')?>
            </span>
            <span><i class="ico-loc iconm-Pin"></i><?=CHtml::encode($quest->addres)?></span>
        </p>
      </a>
    </div>
  <? } ?>
  </div>
</div>
<? } ?>