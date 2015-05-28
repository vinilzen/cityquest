<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */  ?>

<script type="text/javascript">
	var user_name = '<?=!Yii::app()->user->isGuest ? Yii::app()->getModule("user")->user()->username : ''?>',
		city_id = '<?=Yii::app()->getModule("user")->user()->city_id?>',
		user_phone = '<?=!Yii::app()->user->isGuest ? Yii::app()->getModule("user")->user()->phone : ''?>';
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
?>
<div class="block">
	<div class="block-title">
		<h2 data-toggle="tooltip" data-placement="left" title="<?=$today_holiday ? 'Выходной' : 'Рабочий'?> день">
			Квесты на <?=date('d', $selectedDate)?> <?=$month[date('n', $selectedDate)-1]?> <?=date('Y', $selectedDate)?>
			<span	class="hi hi-star<?=$today_holiday ? '' : '-empty'?> setHoliday"
					data-holiday="<?=$today_holiday?>" 
					style="cursor:pointer;" data-toggle="tooltip" 
					data-date="<?=date('Ymd', $selectedDate)?>"
					title="<?=$today_holiday ? 'Сделать рабочим' : 'Сделать выходным'?>"></span>
		</h2>
	</div>
	<h3 class="sub-header hide"><?=$month_f[date('n', $selectedDate)-1]?></h3>
	<div class="row">
		<div class="col-sm-12">
			<div class="widget">
				<div class="widget-extra">
					<div class="row">
						<div class="col-sm-12" id="bb_days" style="padding-top:15px; position:relative; "></div>
					</div>
					<div class="row">
						<div class="col-sm-12" id="bb_quests" style="padding-top:15px; position:relative; ">
							<div class="table-responsive table">
								<table class="table">
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>