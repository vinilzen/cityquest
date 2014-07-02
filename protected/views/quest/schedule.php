<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Quests',
);



if (Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'Create Quest', 'url'=>array('create')),
		array('label'=>'Manage Quest', 'url'=>array('admin')),
	);
}
?>

<script type="text/javascript">
	var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>',
		user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>';
</script>

<br><br>
<div class="btn-group">
<?	$days = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
	$month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря' );
	$times = array('00:00', '01:15', '02:30', '04:00', '05:15', '06:30', '07:45', '09:00', '10:15', '11:30', '12:45', '14:00', '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45');
	$times2 = array('00:30', '01:45', '03:00', '04:15', '05:30', '06:45', '08:00', '09:15', '10:30', '11:30', '12:45', '14:00', '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45');

	$selectedDate = 0;

	for ($i=0; $i<30; $i++) {
		$currDate = strtotime( '+'.$i.' day' );

		// выбранная дата
		$disabled = '';
		if ($ymd == date('Ymd', $currDate)) {
			$disabled = ' disabled="disabled"';
			$selectedDate = $currDate;
		}

		// сегодня 
		$active = '';
		if (date('Ymd', $currDate) === date('Ymd', strtotime('now'))) $active = ' active';

		// weekend
		$weekend = '';
		if (date('w', $currDate) == 0 || date('w', $currDate) == 6) $weekend = ' btn-warning';

		echo '<a title="'.date('d M Y', $currDate).'" href="/quest/schedule/ymd/'.date('Ymd', $currDate).'" type="button" class="btn btn-default'.$active.$weekend.'" '.$disabled.' >'.date('d', $currDate).'</a>';
	}
?>
</div>
<hr>
<h1>Quests - <? echo date('Y m d', $selectedDate); ?></h1>
<style> .table>tbody>tr>td { padding:8px 0; } </style>
<div id="times-table">
	<? foreach ($quests as $quest) {
		
		echo '<table class="table"><tr><td style="width:150px;">';
		echo $quest['q']->title.'</td>';

		foreach ($times as $k=>$time) {

			$dis = '';
			if ( isset($quest['bookings'][$time]) )
	            $dis = 'disabled="disabled"';

	        $invisible = '';
	        if (date('w', $selectedDate) != 0 && date('w', $selectedDate) != 6 && $k > 2 && $k < 7) $invisible = ' invisible'; ?>

			<td>
				<span 
                    data-name="<?php echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>" 
                  	data-phone="<?php echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>" 
				    data-time="<? echo $time; ?>" 
	                data-ymd="<? echo $ymd; ?>" 
	                data-quest="<? echo $quest['q']->id; ?>" 
	                data-date="<? echo date('d',$currDate); ?> <? echo date('M', $currDate); ?>" 
	                data-day="<? echo $days[date('w',$currDate)]; ?>" 
	                data-price="<? echo Yii::app()->params['price_weekend_AM']; ?>" 
					class="time btn btn-default btn-sm <? echo $invisible;?>" <? echo $dis;?>>
					<? echo $time; ?>
				</span>
			</td>

			<?
		}

		echo '</tr></table>';
	} ?>
</div>

