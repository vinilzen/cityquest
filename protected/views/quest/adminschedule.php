<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array('Quests');  ?>

<script type="text/javascript">
	var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>',
		user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>';
</script>

<?	
	$days = Yii::app()->params['days'];
    $month = Yii::app()->params['month'];
    $month_f = Yii::app()->params['month_f'];

	$selectedDate = 0;


	for ($i=0; $i<30; $i++) {
		$currDate = strtotime( '+'.$i.' day' );
		if ($ymd == date('Ymd', $currDate)) {
			$selectedDate = $currDate;
		}
	}
?>
<h1 class="page-header">Квесты на <? echo date('d M Y', $selectedDate); ?></h1>
<h2 class="sub-header" style="text-transform: capitalize; border-bottom: none; margin-bottom:0;"><? echo $month_f[date('n', $selectedDate)-1]; ?></h2>

<div class="btn-group btn-group-justified">
<?

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

		echo '<a title="'.date('d M Y', $currDate).'" href="/quest/adminschedule/ymd/'.date('Ymd', $currDate).'" type="button" class="btn btn-xs btn-default'.$active.$weekend.'" '.$disabled.' >'.date('d', $currDate).'</a>';
	}
?>
</div>
<hr>
<style> .table>tbody>tr>td { padding:8px 1px; } </style>
<div id="times-table" class="table-responsive">
	<? foreach ($quests as $quest) {
		
		if (isset($quest['q']->times) && is_numeric($quest['q']->times) && isset(Yii::app()->params['times'][(int)$quest['q']->times]))
			$times = Yii::app()->params['times'][(int)$quest['q']->times];
		else 
			$times = Yii::app()->params['times'][1];

		echo '<table class="table"><tr><td style="width:100px;"><small style="width:100px; overflow:hidden; display:block;">';
		echo $quest['q']->title.'</small></td>';

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
			$data = '';
      		$additionalClass = '';

			if ( isset($quest['bookings'][$time]) ) {

	        if ($quest['bookings'][$time]->status == 0)
	          $additionalClass = ' btn-info';

	        if ($quest['bookings'][$time]->status == 1)
	          $additionalClass = ' btn-success';

				$data = ' data-id="'.$quest['bookings'][$time]->id.'" '.
                'data-price="'.$quest['bookings'][$time]->price.'" '.
                'data-phone="'.$quest['bookings'][$time]->phone.'" '.
                'data-comment="'.$quest['bookings'][$time]->comment.'" '.
                'data-user-id="'. $quest['bookings'][$time]->competitor->id.'" '.
                'data-name="'.$quest['bookings'][$time]->name.'" ';
			} else {
        $data = ' data-price="'.Yii::app()->params['price_weekend_AM'].'" ';
      }

	        $invisible = '';
	        if (date('w', $selectedDate) != 0 && date('w', $selectedDate) != 6 && $k > 2 && $k < 7) $invisible = ' invisible'; ?>

			<td>
				<button data-toggle="popover"
            		data-title="<? echo date('d',$selectedDate); ?> <? echo date('M', $selectedDate); ?> <?php echo $time; ?>"
				    data-time="<? echo $time; ?>" 
		            data-ymd="<? echo $ymd; ?>" 
		            data-quest="<? echo $quest['q']->id; ?>" 
		            data-date="<? echo date('d',$selectedDate); ?> <? echo date('M', $selectedDate); ?>" 
		            data-day="<? echo $days[date('w',$selectedDate)]; ?>" 
					class="btn btn-default btn-xs <? echo $invisible.$additionalClass;?>" <? echo $dis.$data;?>>
					<? echo $time; ?><br><small><? echo $price; ?>р.</small>
				</button>
			</td>

			<?
		}

		echo '</tr></table>';
	} ?>
</div>

<? include('popover.php'); ?>