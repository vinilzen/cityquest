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

	$selectedDate = strtotime('now');

	$offset = 20;
	$start = 0;
	$prev = -1*$offset;
	$next = $offset;

	if (isset($_GET['d'])) {
		$start = (int)$_GET['d'];
		$prev = ((int)$_GET['d']/$offset - 1)*$offset;
		$next = $prev + 2*$offset;
	}

	for ($i=$start-1; $i<$start+$offset; $i++) {
		$currDate = strtotime( '+'.$i.' day' );

		if ($ymd == date('Ymd', $currDate)) {
			$selectedDate = $currDate;
		}
	}
	$today_holiday = 0;
	if (date('w', $selectedDate) == 0 || date('w', $selectedDate) == 6 || in_array(date('Ymd', $selectedDate), $holidays)){
		$today_holiday = 1;
	}

echo '<!-- '.date('Y/m/d H:i', strtotime('now')).','.$ymd.','.$selectedDate.' -->';
?>

<h1 class="page-header" data-toggle="tooltip" data-placement="left" title="<? echo $today_holiday ? 'Выходной' : 'Рабочий'; ?> день">
	Квесты на <? echo date('d', $selectedDate); ?> <? echo $month[date('n', $selectedDate)-1]; ?> <? echo date('Y', $selectedDate); ?>
	<span	class="glyphicon glyphicon-star<? echo $today_holiday ? '' : '-empty'; ?> setHoliday"
			data-holiday="<? echo $today_holiday; ?>" 
			style="cursor:pointer;" data-toggle="tooltip" 
			data-date="<? echo date('Ymd', $selectedDate) ?>"
			title="<? echo $today_holiday ? 'Сделать рабочим' : 'Сделать выходным'; ?>"></span>

</h1>
<h2 class="sub-header hidden" style="text-transform: capitalize; border-bottom: none; margin-bottom:0;"><? echo $month_f[date('n', $selectedDate)-1]; ?></h2>
<?
	$start = 0;
	$prev = -1*$offset;
	$next = $offset;

	if (isset($_GET['d'])) {
		$start = (int)$_GET['d'];
		$prev = ((int)$_GET['d']/$offset - 1)*$offset;
		$next = $prev + 2*$offset;
	}
?>
<div class="btn-group btn-group-justified">
	<a href="/quest/adminschedule/ymd/?d=<? echo $prev; ?>" class="btn btn-default" title="<? echo $offset; ?> дней назад">
		<i class="glyphicon glyphicon-arrow-left"></i>
	</a>
<?
	for ($i=$start-1; $i<$start+$offset; $i++) {
		$currDate = strtotime( '+'.$i.' day' );

		// выбранная дата
		$disabled = '';
		$disabled_class = '';

		// weekend
		$weekend = '';
		$holiday = 0;
		if ($ymd == date('Ymd', $currDate)) {
			$disabled = ' disabled="disabled"';
			$selectedDate = $currDate;
			$disabled_class = ' btn-success ';
		} else {
			if (date('w', $currDate) == 0 || date('w', $currDate) == 6 || in_array(date('Ymd', $currDate), $holidays)){
				$holiday = 1;
				$weekend = ' btn-warning';
			}			
		}

		// сегодня 
		$active = '';
		if (date('Ymd', $currDate) === date('Ymd', strtotime('now')))
			$active = ' active';


		$style="";
		$title="";
		$badge = '<span class="badge" style=" margin-top:3px; font-size: 13px;font-family: \'Open Sans\';font-weight: normal;">0</span>';
		if (isset($twoweek_bookings_arr[date('Ymd', $currDate)])) {	
			// $style = 'style="box-shadow: inset 0px -10px 0px -7px #000; padding-bottom: 3px;';
			$title = '(Всего броней - '.count($twoweek_bookings_arr[date('Ymd', $currDate)]).')';
			$badge = '<span class="badge" style=" margin-top:3px; font-size: 13px;font-family: \'Open Sans\';font-weight: normal;">'.count($twoweek_bookings_arr[date('Ymd', $currDate)]).'</span>';
		}

		if (date('w', $currDate) == 0 || date('w', $currDate) == 6){
			echo '<a data-container="body" data-toggle="tooltip" title="'.date('d M Y', $currDate).' '.$title.'" '.
					'href="/quest/adminschedule/ymd/'.date('Ymd', $currDate).'?d='.$start.'" type="button" 
						class="text-center btn btn-default'.$active.$weekend.$disabled_class.'" '.$disabled.'>'.
						'<span style="display:block;line-height:1;">'.date('d', $currDate).'</span>'.
						'<small style="display:block;line-height:1;">'.$days_short[date('N', $currDate)-1].'</small>'.
						'<small style="display:block;line-height:1;">'.mb_substr($month[date('n', $currDate)-1],0,6).'</small>'.
						$badge.
				 '</a>';
		} else {
			echo '<a '.$style.' data-container="body" data-toggle="tooltip" title="'.date('d M Y', $currDate).' '.$title.'" '.
					'href="/quest/adminschedule/ymd/'.date('Ymd', $currDate).'?d='.$start.'" type="button" 
						class="text-center btn btn-default'.$active.$weekend.$disabled_class.'" '.$disabled.'>'.
						'<span style="display:block;line-height:1;">'.date('d', $currDate).'</span>'.
						'<small style="display:block;line-height:1;">'.$days_short[date('N', $currDate)-1].'</small>'.
						'<small style="display:block;line-height:1;">'.mb_substr($month[date('n', $currDate)-1],0,6).'</small>'.
						$badge.
				 '</a>';
		}
	}
?>
	<a href="/quest/adminschedule/ymd/?d=<? echo $next; ?>" class="btn btn-default" title="<? echo $offset; ?> дней вперед">
		<i class="glyphicon glyphicon-arrow-right"></i>
	</a>
</div>
<hr>
<style> .table>tbody>tr>td { padding:8px 1px; } </style>
<div id="times-table" class="table-responsive">
	<? foreach ($quests as $quest) {
		
		if (isset($quest['q']->times) && is_numeric($quest['q']->times) && isset(Yii::app()->params['times'][(int)$quest['q']->times]))
			$times = Yii::app()->params['times'][(int)$quest['q']->times];
		else 
			$times = Yii::app()->params['times'][1];

		echo '<table class="table"><tr><td style="width:100px;">'.$quest['q']->title.'</td>';

		if (date('w', $selectedDate) == 0 || date('w', $selectedDate) == 6 || in_array(date('Ymd', $selectedDate), $holidays))
			$workday = 0;
		else
			$workday = 1;

        if (!$workday)
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
						'data-fb-id="'. (int)$quest['bookings'][$time]->competitor->fb_id.'" '.
						'data-vk-id="'. (int)$quest['bookings'][$time]->competitor->vk_id.'" '.
						'data-name="'.$quest['bookings'][$time]->name.'" ';

				if ($quest['bookings'][$time]->result != 0 && 
					$quest['bookings'][$time]->result != '0' && 
					$quest['bookings'][$time]->result != '00' && 
					$quest['bookings'][$time]->result != ' ' && 
					$quest['bookings'][$time]->result != '')
				{
					$additionalClass = ' btn-success';
				} else {
					if (
						(	
							$time < date('H:i', strtotime( '+0 hours' )) && 
							$quest['bookings'][$time]->date == date('Ymd', strtotime( '+0 hours' ))
						)
						|| 
						$quest['bookings'][$time]->date < date('Ymd', strtotime( '+0 hours' ))

					) {
						$additionalClass = '  btn-info btn-danger ';
					}
				}

			} else {
				$data = ' data-price="'.$price.'" ';
			}

	        $invisible = '';
	        if ($workday && $k > 2 && $k < 7)
	        	$invisible = ' invisible';

	        ?>

			<td>
				<button data-toggle="popover"  
            		data-title="<? echo date('d',$selectedDate); ?> <? echo $month[date('n', $selectedDate)-1]; ?> <?php echo $time; ?>"
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