<?
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle= Yii::app()->name.' - '.Yii::t('app','Quests');

foreach ($quests as $quest) { ?>
	<div class="col-xs-12 col-md-6 col-sm-12 col-lg-6 col-xlg-4 item">
		<img alt="<?=CHtml::encode($quest->title)?>" class="featurette-image img-responsive" src="/images/q/<?=$quest->id?>.jpg">
		<? if ($quest->status == 2) { ?>
			<a class="descr" href="/quest/view?id=<? echo $quest->id; ?>">
				<h2><?=CHtml::encode($quest->title)?></h2>
				<p>
					<span>
						<i class="ico-ppl"></i>
						<i class="ico-ppl"></i>
						<i class="ico-ppl noactive"></i>
						<i class="ico-ppl noactive"></i>2 - 4 <?=Yii::t('app','players')?>
					</span>
					<span><i class="ico-loc"></i><?=CHtml::encode($quest->addres)?></span>
				</p>
			</a>
		<? } else { ?>
			<a class="descr inactive" href="#lab">
				<h2><?=CHtml::encode($quest->title)?></h2>
				<p><span class="glyphicon glyphicon-time"></span></p>
				<p><?=Yii::t('app','The quest to develop')?></p>
				<p><?=CHtml::encode($quest->start_text)?></p>
			</a>
		<? } ?>
	</div>

<? } ?>