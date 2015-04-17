<?
	$this->pageTitle= Yii::app()->name.' - живые квесты в Москве. Найди выход из реальной комнаты';
	$this->description= 'Живые квесты поиска выходы из комнаты в Москве. Лучшие игровые квесты. Выберись из реальной квест-комнаты в Москве';
	$this->keywords= 'квест комната, квесты выход из комнаты, квесты выйти из комнаты, живой квест, квесты в москве, квесты в реальности в Москве';
$i=0;

foreach ($quests as $quest) {
	$i++;
	?> <div class="col-xs-12 col-md-6 col-sm-12 col-lg-4 col-xlg-4 item">
		<img	alt="<?=CHtml::encode($quest->title)?>"
					class="featurette-image img-responsive"
					src="/images/q/<?=$quest->id?>.jpg"	/>
		<? if ($quest->status == 2) { ?>
			<a class="descr" href="/quest/<?=$quest->link?>">
				<span class="difficult">
					<? if ($quest->difficult == 2) { ?>
						<i class="glyphicon glyphicon-record"></i>
						<?=Yii::t('app','High')?>
					<? } elseif ($quest->difficult == 1) { ?>
						<i class="glyphicon glyphicon-certificate"></i>
						<?=Yii::t('app','Medium')?>
					<? } else { ?>
						<i class="glyphicon glyphicon-dashboard"></i>
						<?=Yii::t('app','Base')?>
					<? } ?>
				</span>
				<h2><?=CHtml::encode($quest->title)?></h2>
				<p class="quest_info">
					<span>
						<i class="ico-ppl iconm-Man"></i>
						<i class="ico-ppl iconm-Man"></i>
						<i class="ico-ppl iconm-Man noactive"></i>
						<i class="ico-ppl iconm-Man noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
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