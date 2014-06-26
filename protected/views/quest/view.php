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
		// 'id',
		// 'title',
		'content',
		'addres',
		'metro',
		// 'times',
		// array( 'label' => 'Status', 'value' => $status_value, ),
		// array( 'label' => 'create_time', 'value' => date('Y-m-d H:i:s', $model->create_time) ),
		// array( 'label' => 'update_time', 'value' => date('Y-m-d H:i:s', $model->update_time) ),
		// 'author_id',
		array( 'label' => 'img', 'type'=>'raw', 'value' => $img )
	),
)); ?>

<div id="times-table" class="collapse in" style="min-width:1265px;">
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
                if ($time < date('H:i', strtotime( '+0 hours' )) ) $near = 1;
              	// data-trigger="click" data-toggle="modal" data-title="<?php echo $value['day'];  echo $value['month_name'];  echo $time;   Вася Иванов" data-placement="top" data-container="body" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." 

              ?><button type="button" 
                  data-time="<?php echo $time; ?>" 
                  data-ymd="<?php echo $value['date']; ?>" 
                  data-date="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?>" 
                  data-day="<?php echo $value['day_name']; ?>" 
                  data-price="<?php
                    if ($workday === 1) echo ($k>3 && $k<14) ? $pricePm : $priceAm;
                    else echo $k < 9 ? $priceAm : $pricePm; ?>" 
                  class="time btn btn-default btn-sm <?php
          echo (($value['date'] === date('Ymd') && $near) || $dis) ? 'disabled' : '';
          if ($value['date'] != '20140612' && $value['date'] != '20140613' && $value['day_name'] != 'суббота' && $value['day_name'] != 'воскресенье' && $k > 2 && $k < 7 ) echo ' invisible'; 
        ?>">
              <?php echo $time; ?></button> <?php } ?>
          <div class="clearfix"></div>
          <?php echo $pricesStr; ?>
        </td>
      </tr>
      <?php } ?>
    </table>

	<div aria-hidden="true" aria-labelledby="myModalLabel" class="formaModal modal fade" role="dialog" tabindex="-1">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">6 июня (пятница)   10:15<br><strong>3 000 </strong>руб.</h4>
	      </div>
	      <div class="modal-body">
	         <form role="form">
	         	<input type="hidden" value="" name="date" id="selected_date" />
	         	<input type="hidden" value="<? echo $model->id; ?>" name="quest_id" id="quest_id" />
	         	<input type="hidden" value="" name="ymd" id="selected_ymd" />
	         	<input type="hidden" value="" name="time" id="selected_time" />
	         	<input type="hidden" value="" name="price" id="selected_price" />
	              <div class="form-group">
	                <label for="name">Имя</label><input class="form-control input-lg" id="name"
	                	value="<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>" type="text">
	              </div>
	              <div class="form-group">
	              		<label for="mail">Примечание</label><textarea id="comment"></textarea>
	              </div>
	              <div class="form-group">
	                <label for="phone">Телефон</label><input class="form-control input-lg" id="phone" 
	                	value="<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>" type="text">
	              </div>
	              <?php if (Yii::app()->user->isGuest) { ?>
		              <div class="form-group">
		                <label for="mail">Email</label><input class="form-control input-lg" value="" id="mail" type="text" value="" >
		              </div>
	              <? } ?>
	              <button class="btn btn-default btn-block btn-lg" id="book" type="submit">Забронировать</button>
	            </form>
	            <h4 class="text-center" style="display:none;">Ваша заяка успешно отправлена.</h4>
	      </div>
	    </div>
	  </div>
	</div>

</div>