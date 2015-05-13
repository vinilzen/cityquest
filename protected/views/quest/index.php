<?
	$this->pageTitle= 'Лучшие квесты в реальности в Москве, живой квест-игра выход из комнаты для подростков - CityQuest';
	$this->description= 'Живые квесты поиска выходы из комнаты в Москве. Лучшие игровые квесты. Выберись из реальной квест-комнаты в Москве';
	$this->keywords= 'квест комната, квесты выход из комнаты, квесты выйти из комнаты, живой квест, квесты в москве, квесты в реальности в Москве';
$i=0;
$count_quests = count($quests);

foreach ($quests as $quest) {
	$i++;
	?> 
	<? if ($count_quests == 2) {?>
		<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 col-xlg-6 item">
	<? } else { ?>
		<div class="col-xs-12 col-md-6 col-sm-6 col-lg-4 col-xlg-4 item">
	<? } ?>
		<img	alt="<?=CHtml::encode($quest->title)?>"
					class="featurette-image img-responsive"
					src="/images/<?=$quest->cover?>"	/>
		<? if ($quest->status == 2) { ?>
			<a class="descr" href="/quest/<?=$quest->link?>">
				<span class="difficult">
					<? if ($quest->difficult == 2) { ?>
						<i class="icon icon-hexahedron"></i>
						<?=Yii::t('app','High')?>
					<? } elseif ($quest->difficult == 1) { ?>
						<i class="icon icon-square"></i>
						<?=Yii::t('app','Medium')?>
					<? } else { ?>
						<i class="icon icon-triangle"></i>
						<?=Yii::t('app','Base')?>
					<? } 
					if ($quest->actor) { ?>
						<i class="icon icon-mask"></i>
						<?=Yii::t('app','With actor')?>
					<? } ?>
				</span>
				<h2><?=CHtml::encode($quest->title)?></h2>
				<p class="quest_info">
					<span>
						<i class="icon icon-user"></i>
						<i class="icon icon-user"></i>
						<i class="icon icon-user noactive"></i>
						<i class="icon icon-user noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
					</span>
					<span><i class="icon icon-Pin"></i><?=CHtml::encode($quest->addres)?></span>
				</p>
				<? if (in_array($quest->id, $quests_with_promo)) {
					echo '<span class="promo-flag promo-flag-right">Акция</span>';
				} ?>
			</a>
		<? } else { ?>
			<a class="descr inactive<?=($quest->actor)?' withactor':''?>">
				<p class="text-center">
					<?=($quest->actor)?'<i class="icon icon-mask"></i>'.Yii::t('app','With actor').'<br>' : '' ?>
				</p>
				<h2>
					<?=CHtml::encode($quest->title)?>
				</h2>
				<p><i class="icon icon-Time"></i></p>
				<p><?=Yii::t('app','The quest to develop')?></p>
				<p class="add_descr"><?=CHtml::encode($quest->start_text)?></p>
			</a>
		<? } ?>
	</div>
	<? if ($i%3==0) { ?>
		<div class="clearfix visible-lg-block hidden-md hidden-sm"></div>
	<? } ?>
<? } ?>