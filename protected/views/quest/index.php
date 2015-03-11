<?
$this->pageTitle= Yii::app()->name.' - '.Yii::t('app','Quests');

$i=0;

foreach ($quests as $quest) {
	$i++;
	?> <div class="col-xs-12 col-md-6 col-sm-12 col-lg-4 col-xlg-4 item">
		<img	alt="<?=CHtml::encode($quest->title)?>"
					class="featurette-image img-responsive"
					src="/images/q/<?=$quest->id?>.jpg"	/>
		<? if ($quest->status == 2) { ?>
			<a class="descr" href="/quest/view?id=<? echo $quest->id; ?>">
				<h2><?=CHtml::encode($quest->title)?></h2>
				<p>
					<span>
						<i class="ico-ppl iconm-Man"></i>
						<i class="ico-ppl iconm-Man"></i>
						<i class="ico-ppl iconm-Man noactive"></i>
						<i class="ico-ppl iconm-Man noactive"></i>2 - 4 <?=Yii::t('app','players')?>
					</span>
					<span><i class="ico-loc iconm-Pin"></i><?=CHtml::encode($quest->addres)?></span>
				</p>
			</a>
		<? } else { ?>
			<a class="descr inactive">
				<h2><?=CHtml::encode($quest->title)?></h2>
				<p><i class="iconm iconm-Time"></i></p>
				<p><?=Yii::t('app','The quest to develop')?></p>
				<p class="add_descr"><?=CHtml::encode($quest->start_text)?></p>
			</a>
		<? } ?>
	</div>
	<? if ($i%3==0) { ?>
		<div class="clearfix visible-lg-block hidden-md"></div>
	<? } ?>
<? } ?>