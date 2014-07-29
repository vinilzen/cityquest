<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$days = Yii::app()->params['days'];
$month = Yii::app()->params['month'];
$month_f = Yii::app()->params['month_f'];

if (0 && Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'Create Quest', 'url'=>array('create')),
		array('label'=>'Manage Quest', 'url'=>array('admin')),
	);
}
?>
	<script type="text/javascript">
		var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->username : ''; ?>',
			user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->phone : ''; ?>';
	</script>

	<div class="row rules schedules">
		<div class="col-xs-10 col-xs-offset-1 col-xlg-offset-3 col-md-10 col-md-offset-1 col-lg-8 col-xlg-6 col-lg-offset-2 text-center">
		  <h3>Здесь вы можете наблюдать полное расписание по всем квестам на ближайшие две недели</h3>
		</div>
	</div>

</div>
<div class="container container-xlg">
	<div class="row">
		<div class="col-xs-12">
			<div class="row date_schedules">
				<div class="col-xs-2 col-sm-3 col-md-2 hidden-lg">
					<a class="move move-left"><i class="glyphicon glyphicon-chevron-left"></i></a>
				</div>
				<div class="col-xs-8 col-sm-6 col-md-8 col-lg-12 calendar_container">
				<div class="calendar">
<?	
	$days = Yii::app()->params['days'];
	$month = Yii::app()->params['month'];

	$selectedDate = 0;

	for ($i=0; $i<14; $i++) {
		$currDate = strtotime( '+'.$i.' day' );
		$active = '';
		$disabled = '';

		if ($ymd == date('Ymd', $currDate)) {
			$selectedDate = $currDate;
			$active = ' active';
		}

		if (date('Ymd', $currDate) === date('Ymd', strtotime('now'))) $disabled = ' disabled="disabled"';

		// weekend
		$weekend = '';
		if (date('w', $currDate) == 0 || date('w', $currDate) == 6) $weekend = ' weekend';

		echo	'<a title="'.date('d M Y', $currDate).'" href="/quest/schedule/ymd/'.date('Ymd', $currDate).'" type="button" class="curent_date'.$active.$weekend.'" '.$disabled.' >'.
					'<span><em>'.date('d', $currDate).'.</em>'.date('m', $currDate).'</span>'.
					'<small>'.$days[date('w', $currDate)].'</small>'.
				'</a>';
	}
?>
				</div>
				</div>
				<div class="col-xs-2 col-sm-3 col-md-2 hidden-lg text-right">
					<a class="move move-right"><i class="glyphicon glyphicon-chevron-right"></i></a>
				</div>
			</div>
			<hr class="gradient">
		</div>
		<div class="col-xs-12 ovs">
		    <div class="row quests_schedules">

	<? foreach ($quests as $quest) {
		
		if (isset($quest['q']->times) && is_numeric($quest['q']->times) && isset(Yii::app()->params['times'][(int)$quest['q']->times]))
			$times = Yii::app()->params['times'][(int)$quest['q']->times];
		else 
			$times = Yii::app()->params['times'][1];
	?>
        <div class="col-xs-2 col-sm-2">
        	<a href="/quest/view?id=<? echo $quest['q']->id; ?>" class="quest_preview">
                <img src="/images/q/<? echo $quest['q']->id; ?>.jpg" />
            	<h5 id="quest_title_<? echo $quest['q']->id; ?>"><? echo $quest['q']->title; ?></h5>
            	<input id="quest_addr_<? echo $quest['q']->id; ?>" type="hidden" value="<? echo $quest['q']->addres; ?>">
            </a>
        </div>
        <div class="col-xs-10 col-sm-10 times">
        	<div class="times-line">
    <?
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
			$my_quest = '';
			if ( isset($quest['bookings'][$time]) ){
	            $dis = 'disabled="disabled"';

				if ( $quest['bookings'][$time]['competitor_id'] == Yii::app()->user->id ) {
					$my_quest = ' myDate ';
				}
			}

	        $invisible = '';
	        if (date('w', $selectedDate) != 0 && date('w', $selectedDate) != 6 && $k > 2 && $k < 7) $invisible = ' invisible'; ?>

				<div	data-time="<? echo $time; ?>" 
						data-ymd="<? echo $ymd; ?>" 
						data-d="<? echo date('d',$selectedDate); ?>" 
						data-m="<? echo date('m', $selectedDate); ?>" 
						data-quest="<? echo $quest['q']->id; ?>" 
						data-date="<? echo date('d',$selectedDate); ?> <? echo date('M', $selectedDate); ?>" 
						data-day="<? echo $days[date('w',$selectedDate)]; ?>" 
						data-price="<? echo Yii::app()->params['price_weekend_AM']; ?>" 
						class="btn btn-q <? echo $invisible;?> <? echo $my_quest; ?>" <? echo $dis;?> ><? echo $time; ?></div>

		<? } ?> 

			</div>
			<div class="price-line">
				<div class="priceTbl" style="width: 166px;">
					<div class="priceRow">
						<span class="dashed"></span>
						<span class="price"><? echo $priceAm; ?> <em class="rur"><em>руб.</em></em></span>
						<span class="dashed"></span>
					</div>
				</div>
				<div class="priceTbl" style="margin-left: 219px; width: 660px;">
					<div class="priceRow">
						<span class="dashed"></span>
						<span class="price"><? echo $pricePm; ?> <em class="rur"><em>руб.</em></em></span>
						<span class="dashed"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	<? } ?>


		    </div>
		</div>
	</div>
