<?
  $this->pageTitle= Yii::app()->name.' - Квесты в Москве. Контакты';
  $this->description= 'Лучшие квесты в Москве. ул. Летниковская, дом 4, строение 2 hello@cityquest.ru 8 (495) 749-96-09';
  $this->keywords= 'лучшие квесты в Москве, ул. Летниковская, дом 4, строение 2 hello@cityquest.ru 8 495 749-96-09, контакты, CityQuest';
?>
<div class="row" itemscope itemtype="http://schema.org/LocalBusiness">
  <meta itemprop="name" content="CityQuest" />
  <meta itemprop="telephone" content="+7 (495) 749-96-09" />
  <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
  <meta itemprop="url" content="http://cityquest.ru/" />
  <meta itemprop="address" content="Россия, Москва, ул. Летниковская, дом 4, строение 2" />
  <meta itemprop="openinghours" content="Mo-Su" />

  <div class="col-xs-12 col-md-5 col-lg-6 col-md-offset-7 col-lg-offset-6 contacts" itemscope itemtype="http://schema.org/Organization">
    <meta itemprop="url" content="http://cityquest.ru/" />
    <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
    <meta itemprop="name" content="CityQuest. Москва" />

    <h1 class="h3"><?=Yii::t('app','Contacts')?></h1>
    <h5><?=Yii::t('app','For all the questions and reservations quests write!')?></h5>

  <? if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){ ?>
    <p><i class="ico1"></i><a itemprop="telephone" class="ya-phone" href="tel:+7 776 1004447">
      <span class="ya-phone">+7 (776) 100-4447</span></a></p>
  <? } else { ?>
    
    <?  if (strpos($_SERVER['HTTP_HOST'], 'irk') === 0) { ?>

      <p><i class="ico1"></i><a itemprop="telephone" class="ya-phone" href="tel:60-05-21">
        <span class="ya-phone">60-05-21</span></a></p>

    <? } elseif (strpos($_SERVER['HTTP_HOST'], 'vlg') === 0) { ?>

      <p><i class="ico1"></i><a itemprop="telephone" class="ya-phone" href="tel:8 961 686 99 96">
        <span class="ya-phone">8 961 686 99 96</span></a></p>

    <? } else { ?>

      <p><i class="ico1"></i><a itemprop="telephone" class="ya-phone" href="tel:8 495 749-96-09">
        <span class="ya-phone">+7 (495) 749-96-09</span></a></p>

    <? } ?>

  <? } ?>

    <p><i class="ico2"></i>
    	<span><?=Yii::t('app','General questions')?>:&nbsp;<a itemprop="email" href="mailto:hello@cityquest.ru" target="_blank">hello@cityquest.ru</a><br></span>
    	<span><?=Yii::t('app','Franchise')?>:&nbsp;<a itemprop="email" href="mailto:franchise@cityquest.ru" target="_blank">franchise@cityquest.ru</a><br></span>
    	<span><?=Yii::t('app','For journalists')?>:&nbsp;<a itemprop="email" href="mailto:pr@cityquest.ru" target="_blank">pr@cityquest.ru</a></span></p>
    <div itemscope itemprop="itemType" content="http://schema.org/PostalAddress" />
      <meta itemprop="addresslocality" content="Москва" />
      <meta itemprop="streetaddress" content="ул. Летниковская, дом 4, строение 2" />
      <meta itemprop="telephone" content="+7 (495) 749-96-09" />
      <meta itemprop="faxnumber" content="+7 (495) 749-96-09" />
      <meta itemprop="email" content="hello@cityquest.ru" />
    </div>
    <? if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){ ?>
    <? } else { ?>
      <p><span>Адрес офиса:</span><br>
      <?  if (strpos($_SERVER['HTTP_HOST'], 'irk') === 0) { ?>
        г. Иркутск, переулок Мопра д. 5
      <? } elseif (strpos($_SERVER['HTTP_HOST'], 'vlg') === 0) { ?>
        г. Волгоград, ул. им.Хользунова, 18 А
      <? } else { ?>
        г. Москва, ул. Летниковская, д. 4, стр. 2
      <? } ?>
  
      </p>
      <p>ООО «Сити Квест»   ОГРН  5147746030900</p>
    <? } ?>
  </div>
</div>