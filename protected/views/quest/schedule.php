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
<div class="btn-group btn-group-justified">
<?	
	$days = Yii::app()->params['days'];
    $month = Yii::app()->params['month'];

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

		echo '<a title="'.date('d M Y', $currDate).'" href="/quest/schedule/ymd/'.date('Ymd', $currDate).'" type="button" class="btn btn-sm btn-default'.$active.$weekend.'" '.$disabled.' >'.date('d', $currDate).'</a>';
	}
?>
</div>
<hr>
<h1>Quests - <? echo date('Y m d', $selectedDate); ?></h1>
<style> .table>tbody>tr>td { padding:8px 0; } </style>
<div id="times-table">
	<? foreach ($quests as $quest) {
		
		if (isset($quest['q']->times) && is_numeric($quest['q']->times) && isset(Yii::app()->params['times'][(int)$quest['q']->times]))
			$times = Yii::app()->params['times'][(int)$quest['q']->times];
		else 
			$times = Yii::app()->params['times'][1];

		echo '<table class="table"><tr><td style="width:150px;">';
		echo $quest['q']->title.'</td>';

		if (date('w', $selectedDate) == 0 || date('w', $selectedDate) == 6) $workday = 0;
		else $workday = 1;

        if ( !$workday)
        {
          $priceAm = Yii::app()->params['price_weekend_AM'];
          $pricePm = Yii::app()->params['price_weekend_PM'];
        } else {         
          $priceAm = Yii::app()->params['price_workday_AM'];
          $pricePm = Yii::app()->params['price_workday_PM'];
        }

		foreach ($times as $k=>$time) {


            if ($workday){
              if ($k>6 && $k<14) $price = $priceAm;
              else $price = $pricePm;
            } else {
              if ($k<10) $price = $priceAm;
              else $price = $pricePm;
            }

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
					class="time btn btn-default btn-xs <? echo $invisible;?>" <? echo $dis;?>>
					<? echo $time; ?><br><small><? echo $price; ?>р.</small>
				</span>
			</td>

			<?
		}

		echo '</tr></table>';
	} ?>
</div>

