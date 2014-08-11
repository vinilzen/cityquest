<?
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

if (0 && Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
		array('label'=>'Управление квестами', 'url'=>array('admin')),
		array('label'=>'Создать новый квест', 'url'=>array('create')),
	);
}

foreach ($quests as $quest) { ?>
	<div class="col-xs-12 col-md-6 col-sm-12 col-lg-6 col-xlg-4 item">
		<img alt="Generic placeholder image" class="featurette-image img-responsive" src="/images/q/<? echo $quest->id; ?>.jpg">
		<? if ($quest->status == 2) { ?>
			<a class="descr" href="/quest/view?id=<? echo $quest->id; ?>">
				<h2><? echo CHtml::encode($quest->title); ?></h2>
				<p>
					<span>
						<i class="ico-ppl"></i>
						<i class="ico-ppl"></i>
						<i class="ico-ppl noactive"></i>
						<i class="ico-ppl noactive"></i>2 - 4 игрока
					</span>
					<span><i class="ico-loc"></i><? echo CHtml::encode($quest->addres); ?></span>
				</p>
			</a>
		<? } else { ?>
			<a class="descr inactive" href="#lab">
				<h2><? echo CHtml::encode($quest->title); ?></h2>
				<p><span class="glyphicon glyphicon-time"></span></p>
				<p>Квест в разработке</p>
				<p><? echo CHtml::encode($quest->start_text); ?></p>
			</a>
		<? } ?>
	</div>

<? } ?>