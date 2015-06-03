<? if (isset($other_quests) && count($other_quests) > 0) { ?>
<div class="container-fluid bottom_quest" id="quests">
  <div class="row">
  <? $counter = 1;
    shuffle($other_quests);
    foreach ($other_quests as $quest) {
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
            <span><i class="icon icon-point"></i><?=CHtml::encode($locations[$quest->location_id]->address)?></span>
        </p>
      </a>
    </div>  
    <? }
  } ?>
  </div>
</div>
<? } ?>