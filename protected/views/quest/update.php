<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->quest_menu=array(
  array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
  array('label'=>'Управление квестами', 'url'=>array('admin')),
  array('label'=>'Создать новый квест', 'url'=>array('create')),
);
?>

<h1 class="page-header">#<?php echo $model->id; ?> <?php echo $model->title; ?></h1>
<input type="hidden" value="<?php echo $model->id; ?>" id="quest_id">

<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#times" data-toggle="tab">Времена для записи</a></li>
  <li><a href="#edit" data-toggle="tab">Реадктирование квеста</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="times">
    <div id="times-table" class="table-responsive" style="padding-top:10px;">
    <?
      $days = Yii::app()->params['days'];
      $month = Yii::app()->params['month'];
      $endDate = strtotime( '+'.Yii::app()->params['offset'].' day' );
      $currDate = strtotime( 'now' );
      $dayArray = array();

      $pricesStr = '';
      $workday = 1;

      function makeDayArray( ){
        $days = Yii::app()->params['days'];
        $days_short = Yii::app()->params['days_short'];
        $month = Yii::app()->params['month'];
        $endDate = strtotime( '+13 day' );
        $currDate = strtotime( '-1 day' );
        $dayArray = array();

        do{
          $dayArray[] = array(
            'day_name' => $days_short[intval(date( 'N' , $currDate ))-1],
            'month_name' => $month[intval(date( 'n' , $currDate ))-1],
            'day' => date( 'j' , $currDate ),
            'date' => date('Ymd', $currDate)
          );
          $currDate = strtotime( '+1 day' , $currDate );
        } while( $currDate<=$endDate );

        return $dayArray;
      }

      $next_2week = makeDayArray(); ?>

        <style> .table>tbody>tr>td { padding:8px 1px; } </style>
        <table class="table">
          <? foreach ($next_2week as $value) {

            if ($value['date'] == date('Ymd',strtotime( 'now' )) ){
              $first = 1;
            } else {
              $first = 0;
            }

            if ( $value['day_name'] == 'Сб' || $value['day_name'] == 'Вс')
            {
              $workday = 0;
              $priceAm = Yii::app()->params['price_weekend_AM'];
              $pricePm = Yii::app()->params['price_weekend_PM'];

            } else {

              $workday = 1;
              $priceAm = Yii::app()->params['price_workday_AM'];
              $pricePm = Yii::app()->params['price_workday_PM'];

            } ?>
            <tr class="<? echo $value['day_name'] == 'Сб' || $value['day_name'] == 'Вс' ? 'danger' : ''; if ($first) echo 'active'; ?>">
              <td>
                <p class="<? echo $value['day_name'] == 'Сб' || $value['day_name'] == 'Вс' ? 'weekend' : ''; ?>">
                  <strong style="white-space:nowrap; padding-right:10px;"><? echo $value['day']; ?> <? echo $value['month_name']; ?></strong><br><small><? echo $value['day_name']; ?></small>
                </p>
              </td>
              
                <?

                foreach ($times as $k=>$time) {
                  $dis = 0;                  
                  $near = 0;
                  if ($time < date('h:i', strtotime( '+3 hours' )) ) $near = 1;
                ?><td><button type="button" <?

                  if ($workday){
                    if ($k>6 && $k<14) $price = $priceAm;
                    else $price = $pricePm;
                  } else {
                    if ($k<10) $price = $priceAm;
                    else $price = $pricePm;
                  }

                 if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {

                  echo  'data-name="'.$booking[$value['date']][$time]['name'].'" '.
                        'data-phone="'.$booking[$value['date']][$time]['phone'].'" '.
                        'data-price="'.$booking[$value['date']][$time]['price'].'" '.
                        'data-result="'.$booking[$value['date']][$time]['result'].'" '.
                        'data-id="'.$booking[$value['date']][$time]['id'].'" '. 
                        'data-user-id="'.$booking[$value['date']][$time]['user_id'].'" '. 
                        'data-comment="'.$booking[$value['date']][$time]['comment'].'"';
                 } else {
                    echo 'data-price="'.$price.'" ';
                 }
                ?>
                    data-toggle="popover"
                    data-quest="<? echo $model->id ?>" 
                    data-title="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?> <?php echo $time; ?>"
                    data-time="<?php echo $time; ?>" 
                    data-ymd="<?php echo $value['date']; ?>" 
                    data-date="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?>" 
                    data-day="<?php echo $value['day_name']; ?>" 
                    class="btn btn-default btn-xs <?php
              
                  if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {
                    if ($booking[$value['date']][$time]['status'] == 0)
                      echo ' btn-info';

                    if ($booking[$value['date']][$time]['status'] == 1)
                      echo ' btn-success';

                  }

            if ($workday && $k > 2 && $k < 7 )
                echo ' invisible'; 
          ?>" ><? echo $time; ?><br><small><? echo $price; ?>р.</small></button></td> <?php } ?>        
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
  <div class="tab-pane" id="edit">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
  </div>
</div>

<? include('popover.php'); ?>