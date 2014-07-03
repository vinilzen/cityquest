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
              $priceAm = Yii::app()->params['price_weekend_AM'];
              $pricePm = Yii::app()->params['price_weekend_PM'];
              $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.
                            ' <span class="price"><span>'.$pricePm.' руб.</span></span>';

            } else {

              $priceAm = Yii::app()->params['price_workday_AM'];
              $pricePm = Yii::app()->params['price_workday_PM'];
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
                if ($time < date('H:i', strtotime( '+0 hours' )) ) $near = 1;

              ?><button type="button" 
                  data-name="<?php echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>" 
                  data-phone="<?php echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>" 
                  data-time="<?php echo $time; ?>" 
                  data-quest="<? echo $model->id; ?>" 
                  data-ymd="<?php echo $value['date']; ?>" 
                  data-date="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?>" 
                  data-day="<?php echo $value['day_name']; ?>" 
                  data-price="<?php
                    if ($workday === 1) echo ($k>3 && $k<14) ? $pricePm : $priceAm;
                    else echo $k < 9 ? $priceAm : $pricePm; ?>" 
                  class="time btn btn-default btn-xs <?php
          echo (($value['date'] === date('Ymd') && $near) || $dis) ? 'disabled' : '';
          if ($value['date'] != '20140612' && $value['date'] != '20140613' && $value['day_name'] != 'суббота' && $value['day_name'] != 'воскресенье' && $k > 2 && $k < 7 )
          	echo ' invisible';?>"
		<?
			if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) echo ' disabled="disabled"'; ?>>
              <?php echo $time; ?></button> <?php } ?>
          <div class="clearfix"></div>
          <?php echo $pricesStr; ?>
        </td>
      </tr>
      <?php } ?>
    </table>
</div>