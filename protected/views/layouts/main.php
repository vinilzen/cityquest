<!DOCTYPE html>
<html lang="ru">
  
  <? include('head.php'); ?>

<body itemscope itemtype="http://schema.org/WebPage" class="<?    
    /*if (Yii::app()->request->url == '/contact')  {
      echo ' contact ';
      if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0) {
        echo ' contact_kz ';
      }
    }*/
    if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index') echo ' video ';
    else echo ' inner ';
    ?>">
<? if ( 0 && $_SERVER['HTTP_HOST'] != 'cq.il' && $_SERVER['HTTP_HOST'] != 'cq.kzil') { ?>
  <script type="text/javascript">
  (function (d, w) {
    w._admitadPixel = { response_type: 'img' };
    w._admitadPositions = w._admitadPositions || [];
    w._admitadPositions.push({
      uid: '',
      client_id: '',
      tariff_code: '1',
    });
    
    var id = '_admitad-pixel';

    if (d.getElementById(id)) { return; }

    var s = d.createElement('script');
    s.id = id;
    var r = (new Date).getTime();
    var protocol = (d.location.protocol === 'https:' ? 'https:' : 'http:');
    s.src = protocol + '//cdn.asbmit.com/static/js/pixel.min.js?r=' + r;
    d.head.appendChild(s);
   })(document, window)</script>

  <noscript>
    action_code: '1',
    campaign_code: 'e8be9dc3d4'
    order_id: '',
    payment_type: 'lead'
    <img src="//ad.admitad.com/r?uid=&campaign_code=e8be9dc3d4&action_code=1&response_type=img&order_id=&tariff_code=1&payment_type=lead" width="1" height="1" alt="">
  </noscript>
<? } ?>
    
    <? include('nav.php'); ?>

    <div class="jumbotron">
      <? if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index') { ?>
      <div class="container text-center">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12">
            <h1><?=Yii::t('app', 'slogan')?></h1>
            <p class="lead-p"><?=Yii::t('app', 'introdaction')?></p>
            <small><?=Yii::t('app', 'To participate you need a team')?></small>
            <p class="btns-filter">
              <span class="btn btn-filter">
                <i class="icon icon-logo_cityquest"></i> <span class="hidden-xs">Все квесты</span>
              </span>
              <span class="btn btn-filter active">
                <i class="icon icon-spiral"></i> <span class="hidden-xs">Обычные</span>
              </span>
              <span class="btn btn-filter">
                <i class="icon icon-alarm"></i> <span class="hidden-xs">Спортивные</span>
              </span>
              <span class="btn btn-filter">
                <i class="icon icon-star"></i> <span class="hidden-xs">Перфоманс</span>
              </span>
            </p>
          </div>
        </div>
      </div>
      <? } ?>
    </div>

		<?php echo $content; ?>
    
    <? if (Yii::app()->controller->id == 'quest' && Yii::app()->controller->action->id == 'index') { ?> 
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1 col-xs-12">
            <p class="text-center bottom-lead">CityQuest — это квесты "выберись из комнаты" в реальной жизни. Здесь все как в компьютерной игре, только по-настоящему: можно брать в руки предметы обстановки, открывать шкафы и двери, включать различные приборы. Цель игры – выбраться из запертого тематического помещения  за 60 минут, решая загадки, взламывая замки, находя ключи и открывая двери.</p>
          </div>
        </div>
      </div>
    <? } ?>

    <? include('footer.php'); ?>
</body>
</html>