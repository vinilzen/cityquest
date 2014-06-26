<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Quest', 'url'=>array('index')),
	array('label'=>'Create Quest', 'url'=>array('create')),
	array('label'=>'View Quest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Quest', 'url'=>array('admin')),
);
?>

<h1>#<?php echo $model->id; ?> <?php echo $model->title; ?> </h1>

<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#times" data-toggle="tab">Времена для записи</a></li>
  <li><a href="#edit" data-toggle="tab">Реадктирование квеста</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="times">
    <div id="times-table" style="padding-top:10px;">
    <?
      $times = array('00:00', '01:15', '02:30', '04:00', '05:15', '06:30', 
                    '07:45', '09:00', '10:15', '11:30', '12:45', '14:00', 
                    '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45');

      $days = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
      $month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря' );
      $endDate = strtotime( '+14 day' );
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
              'date' => date('Ymd', $currDate)
            );
            $currDate = strtotime( '+1 day' , $currDate );
          } while( $currDate<=$endDate );

          return $dayArray;
        }

        $next_2week = makeDayArray(); ?>

          <table class="table">
            <?php foreach ($next_2week as $value) {
              $priceAm = 3000;
              $pricePm = 3500;
              $pricesStr = '';
              $workday = 1;
              if (
                $value['day_name'] == 'суббота' || 
                $value['day_name'] == 'воскресенье')
              {
                $workday = 0;
                $priceAm = 3000;
                $pricePm = 3500;
                $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.
                              ' <span class="price"><span>'.$pricePm.' руб.</span></span>';

              } else {

                $priceAm = 3000;
                $pricePm = 2000;
                $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.
                              ' <span class="price"><span>'.$pricePm.' руб.</span></span>'.
                              ' <span class="price"><span>'.$priceAm.' руб.</span></span>';
              }

              ?>
            <tr class="<?php echo $value['day_name'] == 'суббота' || $value['day_name'] == 'воскресенье' ? 'danger' : ''; ?>">
              <td>
                <p class="<?php echo $value['day_name'] == 'суббота' || $value['day_name'] == 'воскресенье' ? 'weekend' : ''; ?>">
                  <strong><?php echo $value['day']; ?> <?php echo $value['month_name']; ?></strong><br><span><?php echo $value['day_name']; ?></span>
                </p>
              </td>
              <td class="text-left">
                <?php foreach ($times as $k=>$time) {
                  $dis = 0;
                  
                  $near = 0;
                  if ($time < date('h:i', strtotime( '+3 hours' )) ) $near = 1;

                ?><button type="button" 
                    data-trigger="click" data-toggle="popover" data-title="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?> <?php echo $time; ?>  Вася Иванов" data-placement="top" data-container="body" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." 
                    data-time="<?php echo $time; ?>" 
                    data-date="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?>" 
                    data-day="<?php echo $value['day_name']; ?>" 
                    data-price="<?php
                      if ($workday === 1) echo ($k>3 && $k<14) ? $pricePm : $priceAm;
                      else echo $k < 9 ? $priceAm : $pricePm; ?>" 
                    class="time btn btn-default btn-sm <?php
            echo (($value['date'] === date('Ymd') && $near) || $dis) ? 'dis' : '';
            if ($value['date'] != '20140612' && $value['date'] != '20140613' && $value['day_name'] != 'суббота' && $value['day_name'] != 'воскресенье' && $k > 2 && $k < 7 ) echo ' turnoff'; 
          ?>">
                <?php echo $time; ?></button> <?php } ?>
            <div class="clearfix"></div>
            <?php echo $pricesStr; ?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
  <div class="tab-pane" id="edit">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
  </div>
</div>




<div class="clearfix"></div>

<hr>