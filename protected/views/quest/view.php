<?php
  /* @var $this QuestController */
  /* @var $model Quest */
  $this->pageTitle = $model->page_title;
  $this->description = $model->description?$model->description:'';
  $this->keywords = $model->keywords?$model->keywords:'';
  $this->pageImg = '/images/q/'.$model->id.'.jpg';
?>

<script type="text/javascript">
    var user_name = '<?=(!Yii::app()->user->isGuest) ? Yii::app()->getModule('user')->user()->username : ''?>',
        user_phone = '<?=(!Yii::app()->user->isGuest) ? Yii::app()->getModule('user')->user()->phone : ''?>';
</script>

<div class="jumbotron quest">
  <div itemscope itemtype="http://schema.org/Product" class="container text-center">
    <div class="row">
    <?
      $photos = '';
      $zindex = 10;
      foreach ($model->photo AS $photo) {
        $photos .= '<div class="img-container" style="z-index:'.$zindex--.';background-image: url(../images/'.$photo->name.');"></div>';
      }
      ?>
      <div class="img-container" style="z-index:11; background-image: url(../images/<?=$model->cover?>);"></div><?=$photos?>
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
              <i class="icon icon-Time"></i>
              <p>
                <em class="gotham">60</em>минут
              </p>
            </div>  
            <div class="col-md-8 col-sm-3 col-xs-12 text-left">
              <i class="icon icon-Man hidden-sm"></i><i class="icon icon-Man hidden-sm"></i><i class="icon icon-Man noactive hidden-sm"></i><i class="icon icon-Man noactive last-man"></i>
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
              <i class="icon icon-Pin"></i>
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
                if ( $timastamp_quest_start < (strtotime( 'now' )+(40*60)) ) $near = 1;

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
            <?if ($workday) { ?>
              <div class="price-line">
                <? // if ($model->id!=15) { ?>
                <div class="priceTbl workPrice1" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="price" itemprop="price" content="<?=$pricePm?>" style="padding:0;"><? echo $pricePm; ?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                  </div>
                </div>
                <? // } ?>
                <div class="priceTbl workPrice2 <? if ($model->id==15) echo 'workPrice23'; ?>" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<?=$priceAm?>"><?=$priceAm?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
                <div class="priceTbl workPrice3" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<?=$pricePm?>"><?=$pricePm?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
                    <span class="dashed">&nbsp;</span>
                  </div>
                </div>
              </div>
            <? } else { ?>
              <div class="price-line weekend">
                <div class="priceTbl weekendPrice2 <?// if ($model->id==15) echo 'weekendPrice23'; ?>" title="Цена за команду" data-toggle="tooltip">
                  <div class="priceRow">
                    <span class="dashed">&nbsp;</span>
                    <span class="price" itemprop="price" content="<?=$pricePm?>"><?=$pricePm?> <em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em></span>
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
    <div class="col-xs-12 col-md-4 col-sm-6 col-lg-4 col-xlg-4 item">
    <? $counter = 0; ?>
      <img class="featurette-image img-responsive"
        alt="<?=CHtml::encode($quest->title)?>" 
        src="/images/q/<?=$quest->id?>.jpg">
      <a class="descr" href="/quest/<?=$quest->link?>">
        <h3 class="h2"><?=CHtml::encode($quest->title)?></h3>
        <p class="quest_info">
            <span>
                <i class="icon icon-user"></i>
                <i class="icon icon-user"></i>
                <i class="icon icon-user noactive"></i>
                <i class="icon icon-user noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
            </span>
            <span><i class="icon icon-Pin"></i><?=CHtml::encode($quest->addres)?></span>
        </p>
      </a>
    </div>
  <? } ?>
  </div>
</div>
<? } ?>