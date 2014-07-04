<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	// 'htmlOptions' => array( 'class' => 'breadcrumb'),
	'Quests'=>array('index'),
	$model->title,
);


if (Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'List Quest', 'url'=>array('index')),
		array('label'=>'Create Quest', 'url'=>array('create')),
		array('label'=>'Update Quest', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete Quest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage Quest', 'url'=>array('admin')),
	);
}
?>

<h1>#<?php echo $model->id; ?> <?php echo $model->title; ?> </h1>

<?php

switch ($model->status) {
	case 3:
		$status_value = 'Вскоре';
		break;
	case 2:
		$status_value = 'Активен';
		break;
	default:
		$status_value = 'Черновик';
		break;
}

if ( file_exists('./images/q/'.$model->id.'.jpg') ){
	$img = CHtml::image('/images/q/'.$model->id.'.jpg', $model->title, array('style'=>'width:200px;') );
} else {
	$img = 'Нет изображения!';
}

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content',
		'addres',
		'metro',
		array( 'label' => 'img', 'type'=>'raw', 'value' => $img )
	),
)); ?>

<div id="times-table" class="collapse in">
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
	          'date' => date('Ymd', $currDate)
	        );
	        $currDate = strtotime( '+1 day' , $currDate );
	      } while( $currDate<=$endDate );

	      return $dayArray;
	    }

	    $next_2week = makeDayArray(); ?>

        <table class="table">
          <?php foreach ($next_2week as $value) {
            if ( $value['day_name'] == 'суббота' ||  $value['day_name'] == 'воскресенье')
            {
              $workday = 0;
              $priceAm = Yii::app()->params['price_weekend_AM'];
              $pricePm = Yii::app()->params['price_weekend_PM']; // $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.' <span class="price"><span>'.$pricePm.' руб.</span></span>';

            } else {
              $workday = 1;
              $priceAm = Yii::app()->params['price_workday_AM'];
              $pricePm = Yii::app()->params['price_workday_PM']; // $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.' <span class="price"><span>'.$pricePm.' руб.</span></span>'.' <span class="price"><span>'.$priceAm.' руб.</span></span>';
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

              ?><button type="button" 
                  data-name="<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>" 
                  data-phone="<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>" 
                  data-time="<? echo $time; ?>" 
                  data-quest="<? echo $model->id; ?>" 
                  data-ymd="<? echo $value['date']; ?>" 
                  data-date="<? echo $value['day']; ?> <? echo $value['month_name']; ?>" 
                  data-day="<? echo $value['day_name']; ?>" 
                  data-price="<? echo $price; ?>" 
                  class="time btn btn-default btn-xs <?php
          echo (($value['date'] === date('Ymd') && $near) || $dis) ? 'disabled' : '';
          if ($workday && $k > 2 && $k < 7 )
          	echo ' invisible';?>"
		<?
			if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) )
        echo ' disabled="disabled"'; ?>> <? echo $time; ?><br><small><? echo $price; ?>р.</small></button> <?php } ?>
          <div class="clearfix"></div>
        </td>
      </tr>
      <?php } ?>
    </table>
</div>