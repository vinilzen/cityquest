<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->quest_menu=array(
  array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
  array('label'=>'Управление квестами', 'url'=>array('admin')),
  array('label'=>'Создать новый квест', 'url'=>array('create')),
);
?>
<div class="block">
  <div class="block-title">
    <h2>#<?=$model->id?> <?=$model->title?></h2>
  </div>
  
  <input type="hidden" value="<?=$model->id?>" id="quest_id">

  <div class="row">
    <div class="col-sm-12">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <!-- <li><a href="#times" data-toggle="tab"><?=Yii::t('app','Time table')?></a></li> -->
      <li class="active"><a href="#edit" data-toggle="tab"><?=Yii::t('app','Editing quest')?></a></li>
      <li class=""><a href="#promo" data-toggle="tab"><?=Yii::t('app','Promo days')?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane" id="times">
        <div id="times-table" class="table-responsive" style="padding-top:10px;">
        <? /*
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
              ?>" ><?=$time?><br><small><?=$price?>р.</small></button></td> <?php } ?>        
            </tr>
            <?php } ?>
          </table>
        <? */ ?>
        </div>
      </div>
      <div class="tab-pane active" id="edit">
        <?php $this->renderPartial('_form', array(
            'model'=>$model, 
            'errors'=>$errors,
            'cities'=>$cities,
            'locations'=>$locations,
            'message_success'=>$message_success
          )); ?>
      </div>
      <div class="tab-pane " id="promo">
          <br>
        <div class="col-md-12 promo_days" data-quest="<?=$model->id?>"></div>
        <form action="#" method="post" class="form-horizontal col-md-8 col-lg-6 col-sm-12" onsubmit="return false;">
          <div class="form-group">
            <div class="col-md-12">
              <h3><?=Yii::t('app','Add')?></h3>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label"><?=Yii::t('app','Enter date')?></label>
            <div class="col-md-8">
              <input type="text" class="form-control input-datepicker" name="date" data-date-format="yyyy/mm/dd" placeholder="yyyy/mm/dd" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label"><?=Yii::t('app','Price Am')?></label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="price_am">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label"><?=Yii::t('app','Price Pm')?></label>
            <div class="col-md-8">
              <input type="text" class="form-control"  name="price_pm">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label"></label>
            <div class="col-md-8">
              <div class="btn btn-md btn-success" id="add_promoday"><?=Yii::t('app','Add')?></div>
            </div>
          </div>
        </form>
      </div>
    </div>

<? include('popover.php'); ?>