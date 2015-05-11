<?php
/* @var $this BookingController */
/* @var $model Booking */
  $this->pageTitle = 'CityQuest - квесты в реальности';
  $this->description = 'Квест '.$quest->title.' пройден за '.$model->result;
  $this->pageImg = '/images/winner_photo/'.$model->winner_photo;
?>

<div class="row rules">
	<div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
		<h1 class="h3 h3-winner text-center">
		<?
			$year = substr($model->date, 0, 4);
			$month = substr($model->date, 4,2);
			$day = (int)(substr($model->date, -2));

			$month_array = array(
				'01'=>'января',
				'02'=>'февраля',
				'03'=>'марта',
				'04'=>'апреля',
				'05'=>'мая',
				'06'=>'июня',
				'07'=>'июля',
				'08'=>'августа',
				'09'=>'сентября',
				'10'=>'октября',
				'11'=>'ноября',
				'12'=>'декабря',
			);

		?>
			Победители квеста &laquo;<a href="/quest/<?=$quest->link?>"><?=$quest->title?></a>&raquo;
		</h1>
		<!-- <h2 class="h3 text-center"></h2> -->
		<p class="text-center quest_result">
			<span class="pull-left text-left">
				Квест был пройден за <br>
				<i class="icon icon-alarm"></i> <strong><?=$model->result?></strong>
			</span>
			<span class="pull-right text-right">
				Дата игры<br>
				<i class="glyphicon glyphicon-calendar"></i> <strong><?=$day; ?> <?=$month_array[$month]?> <?=$year?> <!-- <?=$model->time?> --></strong>
			</span>
			<img class="img-responsive" src="/images/winner_photo/<?=$model->winner_photo?>" alt="">
		</p>
		<? $host = $_SERVER['HTTP_HOST']; ?>
		<p class="text-center">
			<small class="white">Поделись с друзьями</small>
		</p>
		<div id="fb-root"></div>
		<p class="text-center" style="margin-top:15px;">
			<span class="share_panel">
				<script type="text/javascript">
					var share_data = {
						url: 'http://<?=$host?>/result/<?=$model->id?>?<?=time()?>',
						title: 'CityQuest - квесты в реальности',
						description: 'Квест <?=$quest->title?> пройден за <?=$model->result?>',
						image: 'http://<?=$host?>/images/winner_photo/<?=$model->winner_photo?>',
						noparse: true						
					};
				</script>
				<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
				<span class="yashare-auto-init" 
					data-yashareL10n="ru" 
					data-yashareImage="http://<?=$host?>/images/winner_photo/<?=$model->winner_photo?>" 
					data-yashareType="button" 
					data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"
					data-yashareTitle="CityQuest - квесты в реальности"
					data-yashareDescription="Квест <?=$quest->title?> пройден за <?=$model->result?>"
					data-yashareLink="http://<?=$host?>/result/<?=$model->id?>?<?=time()?>" 
					data-yashareTheme="counter"></span>
			</span>
		</p>
		<p class="text-center">
			<a href="/quest/<?=$quest->link?>#winner" class="return_link">
			<img src="/img/orden.png" alt=""><br>
			Все победители <br>этого квеста</a>
		</p>
	</div>
</div>


<? if (isset($quests) && count($quests) > 0) { ?>
<div class="container-fluid bottom_quest" id="quests">
  <div class="row">
  <? $counter = 1;
    foreach ($quests as $quest) {
      $counter++;
      if ($counter<5) {
  ?>
    <div class="col-xs-12 col-md-4 col-sm-6 col-lg-4 col-xlg-4 item">
      <img class="featurette-image img-responsive"
        alt="<?=CHtml::encode($quest->title)?>" 
        src="/images/<?=$quest->cover?>">
      <a class="descr" href="/quest/<?=$quest->link?>">
        <h3 class="h2"><?=CHtml::encode($quest->title)?></h3>
        <p class="quest_info">
            <span>
                <i class="icon icon-user"></i>
                <i class="icon icon-user"></i>
                <i class="icon icon-user noactive"></i>
                <i class="icon icon-user noactive"></i><strong>2 - 4</strong> <?=Yii::t('app','players')?>
            </span>
            <span><i class="icon icon-point"></i><?=CHtml::encode($quest->addres)?></span>
        </p>
      </a>
    </div>  
    <? }
  } ?>
  </div>
</div>
<? } ?>