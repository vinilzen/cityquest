<?
  $this->pageTitle= Yii::app()->name.' - Квесты '.$this->city_model->name.' Контакты';
  $this->description= 'Лучшие квесты '.$this->city_model->name. '.$this->city_model->addres hello@cityquest.ru '.$this->city_model->tel;
  $this->keywords= 'лучшие квесты '.$this->city_model->name.', '.$this->city_model->addres.' hello@cityquest.ru '.$this->city_model->tel.', контакты, CityQuest';
?>
<div class="row rules contact-rules" itemscope itemtype="http://schema.org/LocalBusiness">
  <meta itemprop="name" content="CityQuest" />
  <meta itemprop="telephone" content="<?=$this->city_model->tel?>" />
  <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
  <meta itemprop="url" content="http://cityquest.ru/" />
  <meta itemprop="address" id="meta_address" content="<?=$this->city_model->name?>, <?=$this->city_model->addres?>" />
  <meta itemprop="openinghours" content="Mo-Su" />

  <div class="col-xs-10 col-xs-offset-1 col-md-12 col-lg-10 col-lg-offset-1" itemscope itemtype="http://schema.org/Organization">
    <h1 class="h3 text-center contactH1"><?=Yii::t('app','Contact details of office in')?> <?=Yii::t('app', $this->city_model->name, 2)?></h1>
    <meta itemprop="url" content="http://cityquest.ru/" />
    <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
    <meta itemprop="name" content="CityQuest. <?=$this->city_model->name?>" />
  </div>
  <div class="col-md-4 col-md-offset-2 contactV2">
    <p>
      <i class="icon icon-Call"></i><a itemprop="telephone" class="ya-phone" href="tel:<?=$this->city_model->tel?>">
      <span class="ya-phone"><?=$this->city_model->tel?></span></a>
    </p>
    <p>
      <i class="icon icon-Man"></i>
      <span><?=Yii::t('app','General questions')?>:&nbsp;<a itemprop="email" href="mailto:hello@cityquest.ru" target="_blank">hello@cityquest.ru</a><br></span>
      <span><?=Yii::t('app','Franchise')?>:&nbsp;<a itemprop="email" href="mailto:franchise@cityquest.ru" target="_blank">franchise@cityquest.ru</a><br></span>
      <span><?=Yii::t('app','For journalists')?>:&nbsp;<a itemprop="email" href="mailto:pr@cityquest.ru" target="_blank">pr@cityquest.ru</a></span>
    </p>
  </div>
  <div class="col-md-4 contactV2">
    <p>
      <i class="icon icon-Pin"></i>
      <span>Адрес офиса:</span><br><?=$this->city_model->addres?>
    </p>
    <?=(!strpos($_SERVER['HTTP_HOST'], '.kz') > 0)?'<p>ООО «Сити Квест»   ОГРН  5147746030900</p>':''?>
  </div>
  <div class="clearfix"></div>
  <div class="col-xs-12 text-center">
    <h2 class="contactH2"><?=Yii::t('app','Address of quests')?></h2>
  </div>
</div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="map_container">
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false&"></script>
        <div class="g_map">
            <div id="gmap_canvas"></div>
        </div>
        <div class="map_info">
          <div class="map_info_head">
            <div class="controls">
              <a href="">
                <img src="/img/arrow_left.png" alt="">
              </a>
              <a href="">
                <img src="/img/arrow_right.png" alt="">
              </a>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <img src="/img/close_btn.png" alt="">
            </button>
          </div>
          <div class="map_info_container">
            <? $active = 1; foreach ($locations as $location) { ?>
              <div class="map_info_body <?=$active?'active':''?>" id="location_<?=$location->id?>">
                <? $active = 0;?>
                <p class="info_ico info_addr" data-id="<?=$location->id?>">
                  <i class="icon icon-Pin"></i>
                  г. <?=$cities[$location->city_id]?>, <?=$location->address?>
                </p>
                <p class="info_ico">
                  <i class="icon icon icon-metro"></i>
                  <?=$location->metro?>
                </p>
                <p class="info_ico">
                  <i class="icon icon icon-Call"></i>
                  <?=$location->tel?>
                </p>
                <p class="info_ico">
                  <i class="icon icon icon-Man"></i>
                  <?=$location->contact_email?>
                </p>
                <h3>Квесты на этой локации</h3>
                <p class="text-center local_quests">
                <? foreach ($quests[$location->id] as $q)
                  echo '<a href="/quest/'.$q->link.'" target="_blank">'.$q->title.'</a>';
                ?>
                </p>
              </div>
            <? }?>
          </div>
        </div>
    </div>
  </div>
</div>
<div class="container">

    <!-- <h5><?=Yii::t('app','For all the questions and reservations quests write!')?></h5> -->


    <div itemscope itemprop="itemType" content="http://schema.org/PostalAddress" />
      <meta itemprop="addresslocality" content="<?=$this->city_model->name?>" />
      <meta itemprop="streetaddress" content="<?=$this->city_model->addres?>" />
      <meta itemprop="telephone" content="<?=$this->city_model->tel?>" />
      <meta itemprop="faxnumber" content="<?=$this->city_model->tel?>" />
      <meta itemprop="email" content="hello@cityquest.ru" />
    </div>
  </div>
</div>
        <script type="text/javascript">
            function init_map() {
                var address = $('#meta_address').attr('content');
                var styles = [
                  {
                    "featureType": "water",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "visibility": "on" },
                      { "color": "#475a8b" }
                    ]
                  },{
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      { "color": "#6782ba" }
                    ]
                  },{
                    "featureType": "water",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                      { "visibility": "off" }
                    ]
                  },{
                    "featureType": "landscape",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#3b4360" }
                    ]
                  },{
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "visibility": "off" }
                    ]
                  },{
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "visibility": "on" },
                      { "color": "#3b4360" }
                    ]
                  },{
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "color": "#475a8b" }
                    ]
                  },{
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "visibility": "off" }
                    ]
                  },{
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#6e89c0" }
                    ]
                  },{
                    "featureType": "road",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                      { "visibility": "on" },
                      { "color": "#3b4360" }
                    ]
                  },{
                    "featureType": "poi",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                      { "color": "#3b4360" }
                    ]
                  },{
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      { "color": "#ccddfb" }
                    ]
                  },{
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      { "color": "#ccddfb" }
                    ]
                  },{
                    "elementType": "labels.text.stroke",
                    "stylers": [
                      { "color": "#3b4360" }
                    ]
                  },{
                    "elementType": "labels.text.fill",
                    "stylers": [
                      { "color": "#b0c5eb" }
                    ]
                  },{
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                      { "color": "#2f3756" }
                    ]
                  },{
                    "featureType": "transit",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#2f3756" }
                    ]
                  },{
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "visibility": "off" }
                    ]
                  },{
                  }
                ];
                var icon_marker = '../img/marker.png';
                var icon_marker_hover = '../img/marker_hover.png';
                var geocoder = new google.maps.Geocoder();
                var latlngbounds = new google.maps.LatLngBounds();
                var map;

                geocoder.geocode( { 'address': 'Москва'}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    var myOptions = {
                        zoom: 12,
                        scrollwheel: true,
                        disableDefaultUI: true,
                        zoomControl: false,
                        center: results[0].geometry.location,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        styles:styles
                    };
                    map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
                  } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                  }
                });

                var i = 1,
                    last = false;
                $('.info_addr').each(function() {
                  var addr = $( this ).text().trim(),
                      location_id = $( this ).attr('data-id');

                  i++;

                  if ( $('.info_addr').length < i ) {
                    last = true;
                    console.log('last', location_id);
                  }

                  geocoder.geocode( { 'address': addr}, function(results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                      var marker = new google.maps.Marker({
                          id:location_id,
                          map: map,
                          icon: icon_marker,
                          position: results[0].geometry.location
                      });
                      google.maps.event.addListener(marker, 'mouseover', function() {
                          marker.setIcon(icon_marker_hover);
                      });
                      google.maps.event.addListener(marker, 'mouseout', function() {
                          marker.setIcon(icon_marker);
                      });
                      google.maps.event.addListener(marker, 'click', function() {
                        $('.map_info_body').removeClass('active');
                        $('#location_'+marker.id).addClass('active');
                      });

                      latlngbounds.extend(results[0].geometry.location);
                      if (last) {
                        map.setCenter(latlngbounds.getCenter());
                        map.fitBounds(latlngbounds);
                      }

                    } else {
                      console.log('Geocode was not successful for the following reason: ' + status);
                    }
                  });
                });
                
                // map.setOptions({styles: styles});
                // ico = new google.maps.Icon({
                //   url:'/img/marker.png'
                // });
                /*image = '../static/img/marker.png';
                marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    position: new google.maps.LatLng(55.7857383, 37.57939429999999)
                });
                infowindow = new google.maps.InfoWindow({
                    content: "<span style='height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;'><strong style='font-weight:400;'></strong><br>&#1091;&#1083; &#1055;&#1088;&#1072;&#1074;&#1076;&#1099; &#1076;. 8<br> &#1052;&#1086;&#1089;&#1082;&#1074;&#1072;</span>"
                });
                google.maps.event.addListener(marker, "click", function() {
                    infowindow.open(map, marker);
                });*/
            }
            google.maps.event.addDomListener(window, "load", init_map);
        </script>