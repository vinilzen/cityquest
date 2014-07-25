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
		var user_name = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>',
			user_phone = '<? echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>';
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
				<div class="col-xs-2 col-sm-3 col-md-2 col-xlg-1">
					<a class="move move-left"><i class="glyphicon glyphicon-chevron-left"></i></a>
				</div>
				<div class="col-xs-8 col-sm-6 col-md-8 col-xlg-10 calendar_container">
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
				<div class="col-xs-2 col-sm-3 col-md-2 col-xlg-1 text-right">
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
        	<div class="quest_preview">
                <img src="/images/q/<? echo $quest['q']->id; ?>.jpg" />
            	<h5><? echo $quest['q']->title; ?></h5>
            </div>
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
			if ( isset($quest['bookings'][$time]) )
	            $dis = 'disabled="disabled"';

	        $invisible = '';
	        if (date('w', $selectedDate) != 0 && date('w', $selectedDate) != 6 && $k > 2 && $k < 7) $invisible = ' invisible'; ?>

				<div	data-name="<?php echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('firstname') : ''; ?>" 
						data-phone="<?php echo !Yii::app()->user->isGuest ? Yii::app()->getModule('user')->user()->profile->getAttribute('phone') : ''; ?>" 
						data-time="<? echo $time; ?>" 
						data-ymd="<? echo $ymd; ?>" 
						data-quest="<? echo $quest['q']->id; ?>" 
						data-date="<? echo date('d',$currDate); ?> <? echo date('M', $currDate); ?>" 
						data-day="<? echo $days[date('w',$currDate)]; ?>" 
						data-price="<? echo Yii::app()->params['price_weekend_AM']; ?>" 
						class="btn btn-q <? echo $invisible;?>" <? echo $dis;?> >
					<? echo $time; ?> <!-- <? echo $price; ?>р. -->
				</div>

		<? } ?> 

			</div>
			<div class="price-line">
				<div class="priceTbl" style="width: 166px;">
					<div class="priceRow">
						<span class="dashed"></span>
						<span class="price">3000 руб.</span>
						<span class="dashed"></span>
					</div>
				</div>
				<div class="priceTbl" style="margin-left: 219px; width: 660px;">
					<div class="priceRow">
						<span class="dashed"></span>
						<span class="price">3000 руб.</span>
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
