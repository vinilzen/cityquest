<?
  $this->pageTitle= Yii::app()->name.' - Квесты <?=$this->city_model->name?>. Контакты';
  $this->description= 'Лучшие квесты <?=$this->city_model->name?>. <?=$this->city_model->addres?> hello@cityquest.ru <?=$this->city_model->tel?>';
  $this->keywords= 'лучшие квесты <?=$this->city_model->name?>, <?=$this->city_model->addres?> hello@cityquest.ru <?=$this->city_model->tel?>, контакты, CityQuest';
?>
<div class="row" itemscope itemtype="http://schema.org/LocalBusiness">
  <meta itemprop="name" content="CityQuest" />
  <meta itemprop="telephone" content="<?=$this->city_model->tel?>" />
  <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
  <meta itemprop="url" content="http://cityquest.ru/" />
  <meta itemprop="address" content="<?=$this->city_model->name?>, <?=$this->city_model->addres?>" />
  <meta itemprop="openinghours" content="Mo-Su" />

  <div class="col-xs-12 col-md-5 col-lg-6 col-md-offset-7 col-lg-offset-6 contacts" itemscope itemtype="http://schema.org/Organization">
    <meta itemprop="url" content="http://cityquest.ru/" />
    <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
    <meta itemprop="name" content="CityQuest. <?=$this->city_model->name?>" />

    <h1 class="h3"><?=Yii::t('app','Contacts')?></h1>
    <h5><?=Yii::t('app','For all the questions and reservations quests write!')?></h5>

    <p><i class="ico1"></i><a itemprop="telephone" class="ya-phone" href="tel:<?=$this->city_model->tel?>">
    <span class="ya-phone"><?=$this->city_model->tel?></span></a></p>

    <p><i class="ico2"></i>
    	<span><?=Yii::t('app','General questions')?>:&nbsp;<a itemprop="email" href="mailto:hello@cityquest.ru" target="_blank">hello@cityquest.ru</a><br></span>
    	<span><?=Yii::t('app','Franchise')?>:&nbsp;<a itemprop="email" href="mailto:franchise@cityquest.ru" target="_blank">franchise@cityquest.ru</a><br></span>
    	<span><?=Yii::t('app','For journalists')?>:&nbsp;<a itemprop="email" href="mailto:pr@cityquest.ru" target="_blank">pr@cityquest.ru</a></span></p>
    <div itemscope itemprop="itemType" content="http://schema.org/PostalAddress" />
      <meta itemprop="addresslocality" content="<?=$this->city_model->name?>" />
      <meta itemprop="streetaddress" content="<?=$this->city_model->addres?>" />
      <meta itemprop="telephone" content="<?=$this->city_model->tel?>" />
      <meta itemprop="faxnumber" content="<?=$this->city_model->tel?>" />
      <meta itemprop="email" content="hello@cityquest.ru" />
    </div>
      <p>
        <span>Адрес офиса:</span><br><?=$this->city_model->addres?>
      </p>
      <? if (!strpos($_SERVER['HTTP_HOST'], '.kz') > 0){ ?>
        <p>ООО «Сити Квест»   ОГРН  5147746030900</p>
      <? } ?>
  </div>
</div>