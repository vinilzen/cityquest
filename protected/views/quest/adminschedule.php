<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array('Quests');  ?>

<script type="text/javascript">
	var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>',
		hash = '<? echo $arr_hash ?>',
		user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>';
</script>

<?	
	$days = Yii::app()->params['days'];
	$days_short = Yii::app()->params['days_short'];
    $month = Yii::app()->params['month'];
    $month_f = Yii::app()->params['month_f'];

	$selectedDate = 0;


	for ($i=-1; $i<30; $i++) {
		$currDate = strtotime( '+'.$i.' day' );
		if ($ymd == date('Ymd', $currDate)) {
			$selectedDate = $currDate;
		}
	}
?>
<h1 class="page-header">Квесты на <? echo date('d', $selectedDate); ?> <? echo $month[date('n', $selectedDate)-1]; ?> <? echo date('Y', $selectedDate); ?></h1>
<h2 class="sub-header hidden" style="text-transform: capitalize; border-bottom: none; margin-bottom:0;"><? echo $month_f[date('n', $selectedDate)-1]; ?></h2>

<div class="btn-group btn-group-justified">
<?
	for ($i=-1; $i<30; $i++) {
		$currDate = strtotime( '+'.$i.' day' );

		// выбранная дата
		$disabled = '';
		$disabled_class = '';
		if ($ymd == date('Ymd', $currDate)) {
			$disabled = ' disabled="disabled"';
			$selectedDate = $currDate;
			$disabled_class = ' btn-success ';
		}

		// сегодня 
		$active = '';
		if (date('Ymd', $currDate) === date('Ymd', strtotime('now')))
			$active = ' active';

		// weekend
		$weekend = '';
		if (date('w', $currDate) == 0 || date('w', $currDate) == 6)
			$weekend = ' btn-warning';

		$style="";
		$title="";
		$badge = '<span class="badge" style="font-size: 13px;font-family: \'Open Sans\';font-weight: normal;">0</span>';
		if (isset($twoweek_bookings_arr[date('Ymd', $currDate)])) {	
			$style = 'style="box-shadow: inset 0px -10px 0px -7px #000; padding-bottom: 3px;';
			$title = '(Всего броней - '.count($twoweek_bookings_arr[date('Ymd', $currDate)]).')';
			$badge = '<span class="badge" style="font-size: 13px;font-family: \'Open Sans\';font-weight: normal;">'.count($twoweek_bookings_arr[date('Ymd', $currDate)]).'</span>';
		}

		echo '<a '.$style.' data-container="body" data-toggle="tooltip" title="'.date('d M Y', $currDate).' '.$title.'" href="/quest/adminschedule/ymd/'.date('Ymd', $currDate).'" type="button" 
					class="text-center btn btn-xs btn-default'.$active.$weekend.$disabled_class.'" '.$disabled.'>'.
				'<span style="display:block;line-height:1;">'.date('d', $currDate).'</span>'.
				'<small style="display:block;line-height:1;">'.$days_short[date('N', $currDate)-1].'</small>'.
				'<small style="display:block;line-height:1;">'.mb_substr($month[date('n', $currDate)-1],0,6).'</small>'.$badge.
			 '</a>';
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
					$additionalClass = 'btn-info btn-gr';

				if ($quest['bookings'][$time]->status == 1){	
					$additionalClass = ' btn-info';
				}


				$data = ' data-id="'.$quest['bookings'][$time]->id.'" '.
						'data-price="'.$quest['bookings'][$time]->price.'" '.
						'data-phone="'.$quest['bookings'][$time]->phone.'" '.
						'data-result="'.$quest['bookings'][$time]->result.'" '.
						'data-comment="'.$quest['bookings'][$time]->comment.'" '.
						'data-user-id="'. $quest['bookings'][$time]->competitor->id.'" '.
						'data-name="'.$quest['bookings'][$time]->name.'" ';

				if ($quest['bookings'][$time]->result != 0 && 
					$quest['bookings'][$time]->result != '0' && 
					$quest['bookings'][$time]->result != '00' && 
					//$quest['bookings'][$time]->result != '60:00' && 
					//$quest['bookings'][$time]->result != '60' && 
					$quest['bookings'][$time]->result != ' ' && 
					$quest['bookings'][$time]->result != '')
				{
					$additionalClass = ' btn-success';
				} else {
					if ($time < date('H:i', strtotime( '+0 hours' )) && $quest['bookings'][$time]->date <= date('Ymd', strtotime( '+0 hours' ) ) ) {
						$additionalClass = '  btn-info btn-danger ';
					}
				}

			} else {
				$data = ' data-price="'.$price.'" ';
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


<!-- Modal -->
<div class="modal" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script  type="text/javascript">
	var adminschedule = 1;
</script>
<? include('popover.php'); ?>