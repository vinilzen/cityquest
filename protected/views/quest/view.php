<?php
  /* @var $this QuestController */
  /* @var $model Quest */
  $this->pageTitle = $model->page_title;
  $this->description = $model->description?$model->description:'';
  $this->keywords = $model->keywords?$model->keywords:'';
  $this->pageImg = '/images/q/'.$model->id.'.jpg';
  $currency = '<em itemprop="priceCurrency" content="RUB" class="rur"><em>руб.</em></em>';
  if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){
    $currency = '<em itemprop="priceCurrency" content="〒" class=""><em style="font-style:normal;">〒</em></em>';
  }
?>

<script type="text/javascript">
    var user_name = '<?=(!Yii::app()->user->isGuest) ? Yii::app()->getModule('user')->user()->username : ''?>',
        user_phone = '<?=(!Yii::app()->user->isGuest) ? Yii::app()->getModule('user')->user()->phone : ''?>';
</script>

<div class="jumbotron quest">
  <div itemscope itemtype="http://schema.org/Product" class="container text-center">
    <div class="row">
    <? $photos = '';
       $zindex = 10;
       $num = 1;
    ?>
      <div id="carouselPhoto" class="carousel slide img-container" data-ride="carousel">
        <? if (count($model->photo)>0) { ?>
        <ol class="carousel-indicators">
          <li data-target="#carouselPhoto" data-slide-to="0" class="active"></li>
          <? foreach ($model->photo AS $photo) {
            $photos .= '<div class="item"><img src="/images/'.$photo->name.'"></div>';
            echo '<li data-target="#carouselPhoto" data-slide-to="'.$num++.'"></li>';
          } ?>
        </ol>
        <? } ?>
        <div class="carousel-inner" role="listbox">
          <div class="item active"><img src="/images/<?=$model->cover?>"></div>
          <?=$photos?>
        </div>
      </div>

      <div class="col-sm-12 col-black">
        <p class="text-center quest-type hidden">
          <i class="icon icon-spiral"></i><span class="hidden-xs">Обычные</span>
        </p>
        <h1 itemprop="name" id='quest_title'>
          <?=$model->title?>
          <? if (isset($prev)) {
                echo '<a class="arrow-quest arrow-left" title="'.$prev->title.'" href="/quest/'.$prev->link.'">'.
                      '<span class="glyphicon glyphicon-menu-left"></span></a>';
              }
              if (isset($next)) {
                echo '<a class="arrow-quest arrow-right" title="'.$next->title.'" href="/quest/'.$next->link.'">'.
                      '<span class="glyphicon glyphicon-menu-right"></span></a>';
              }
          ?>
        </h1>
        <p class="description h2" itemprop="description"><?=$model->content?></p>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row quest_description">
      <div id="quest_description_left" class="col-md-6 col-lg-5 col-xlg-4 col-xs-12">
        <div class="container-fluid quest_description_left">
          <div class="row">
            <div class="col-md-4 col-sm-3 col-xs-12 text-left">
              <i class="icon icon-alarm"></i>
              <p>
                <em class="gotham">60</em>минут
              </p>
            </div>  
            <div class="col-md-8 col-sm-3 col-xs-12 text-left">
              <i class="icon icon-user hidden-sm"></i><i class="icon icon-user hidden-sm"></i><i class="icon icon-user noactive hidden-sm"></i><i class="icon icon-user noactive last-man"></i>
              <p>
                <em class="gotham">2-4</em><?=Yii::t('app','players')?>
              </p> 
            </div>
            <div class="clearfix hidden-sm"></div>
            <div class="col-md-4 col-sm-3 col-xs-5 text-left">
              <? if ($model->difficult == 2) { ?>
                <i class="icon icon-hexahedron"></i>
                <p><?=Yii::t('app','High')?></p>
              <? } elseif ($model->difficult == 1) { ?>
                <i class="icon icon-square"></i>
                <p><?=Yii::t('app','Medium')?></p>
              <? } else { ?>
                <i class="icon icon-triangle"></i>
                <p><?=Yii::t('app','Base')?></p>
              <? } ?>
            </div>  
            <div class="col-md-8 col-sm-3 col-xs-6 text-left">
              <? if ($model->actor) { ?>
                <i class="icon icon-mask"></i>
                <p><?=Yii::t('app','With actor')?></p>
              <? } ?>
            </div>  
          </div>
        </div>
      </div>
      <div id="quest_description_right" class="col-md-5 col-lg-4 col-lg-offset-3 col-xlg-3 col-xlg-offset-5 col-xs-12">
        <div class="container-fluid quest_description_right">
          <div class="row">
            <? if ($location->metro!= '') { ?><div class="col-xs-12 col-md-12 col-sm-3 text-left">
              <i class="icon icon-metro"></i>
              <p><span class="metro-title"><?=$location->metro?></span></p>
            </div><? } ?>
            <div class="col-xs-12 col-md-12 col-sm-9 text-left">
              <i class="icon icon-point"></i>
              <p><?=$location->address?>
                <br>
                <?=$location->address_additional?>
                <br>
                <a href="https://www.google.com/maps/preview?q=<?=$cities[$location->city_id]->name?>,+<?=urlencode($location->address)?>" target="_blank"><?=Yii::t('app','How to get there')?>?</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container container-xlg">
  <div class="row">
    <div class="col-xs-12 text-center">
      <a href="#schedule" class="h2 twotab active" role="tab" data-toggle="tab">
        <?=($model->status == 2)?Yii::t('app','Schedule'):Yii::t('app','Inactive quest')?>
      </a>
      <a href="#winner" class="h2 twotab" role="tab" data-toggle="tab">Победители</a>
      <hr class="fadeOut">
    </div>
    <? if ($model->status == 2) { ?>
    <div class="clearfix"></div>
    <div class="col-xs-12 ovs tab-content">
      <div class="row quests_schedules fade in quest_schedule tab-pane active" role="tabpanel" id="schedule">
        <? if ($model->id == 19 || $model->id == 21) {
          include('quests_schedules_table.php');
        } else {
          include('quests_schedules.php');
        }?>
      </div>
      <div class="row tab-pane fade" role="tabpanel" id="winner">
        <? include('winner_photo.php'); ?>
      </div>
    </div>
    <? } ?>
  </div>
</div>

<? include('other_quests.php');  ?>