<?
  $this->pageTitle= Yii::app()->name.' - Квесты '.$this->city_model->name.' Контакты';
  $this->description= 'Лучшие квесты '.$this->city_model->name. '.$this->city_model->addres hello@cityquest.ru '.$this->city_model->tel;
  $this->keywords= 'лучшие квесты '.$this->city_model->name.', '.$this->city_model->addres.' hello@cityquest.ru '.$this->city_model->tel.', контакты, CityQuest';
  
  // var_dump($this->city_model); die;

?>

<div class="row rules contact-rules" itemscope itemtype="http://schema.org/LocalBusiness">
  <meta itemprop="name" content="CityQuest" />
  <meta itemprop="telephone" content="<?=$this->city_model->tel?>" />
  <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
  <meta itemprop="url" content="http://cityquest.ru/" />
  <meta itemprop="address" id="meta_address" content="<?=$this->city_model->name?>, <?=$this->city_model->addres?>" />
  <meta itemprop="openinghours" content="Mo-Su" />

  <div class="col-xs-10 col-xs-offset-1 col-md-12 col-lg-10 col-lg-offset-1" itemscope itemtype="http://schema.org/Organization">
    <h1 class="h3 text-center contactH1"><?=Yii::t('app','Contacts')?></h1>
    <meta itemprop="url" content="http://cityquest.ru/" />
    <meta itemprop="logo" content="http://cityquest.ru/img/logo1.png" />
    <meta itemprop="name" content="CityQuest. <?=$this->city_model->name?>" />
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-2 col-md-5 col-lg-4 col-md-offset-1 col-lg-offset-2 contactV2">
    <p>
      <i class="icon icon-Mobile"></i><a itemprop="telephone" class="ya-phone" href="tel:<?=$this->city_model->tel?>">
      <span class="ya-phone"><?=$this->city_model->tel?></span></a>
    </p>
    <p>
      <i class="icon icon-Mail"></i>
      <span><span><?=Yii::t('app','General questions')?>:&nbsp;</span><a itemprop="email" href="mailto:hello@cityquest.ru" target="_blank">hello@cityquest.ru</a></span>
      <span><span><?=Yii::t('app','Franchise')?>:&nbsp;</span><a itemprop="email" href="mailto:franchise@cityquest.ru" target="_blank">franchise@cityquest.ru</a></span>
      <span><span><?=Yii::t('app','For journalists')?>:&nbsp;</span><a itemprop="email" href="mailto:pr@cityquest.ru" target="_blank">pr@cityquest.ru</a></span>
    </p>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-5 col-lg-4 contactV2">
    <p>
      <i class="icon icon-Pin"></i>
      <span>Адрес офиса:</span><?=$this->city_model->addres?>
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
        <div class="map_info_show">
          <a href="#" class="right" role="button">
            <img src="/img/arrow_right.png" alt="">
          </a>
        </div>
        <div class="map_info carousel slide" id="carousel-location" data-interval="false">
          <div class="map_info_head">
            <div class="controls">
            <? if (count($locations)>1) { ?>
              <a href="#carousel-location" class="left" role="button" data-slide="prev">
                <img src="/img/arrow_left.png" alt="">
              </a>
              <a href="#carousel-location" class="right" role="button" data-slide="next">
                <img src="/img/arrow_right.png" alt="">
              </a>
            <? } ?>
            </div>
            <button type="button" class="close" aria-label="Close">
              <img src="/img/close_btn.png" alt="">
            </button>
          </div>
          <div class="map_info_container carousel-inner" role="listbox">
            <?
              $active = 1;
              $i = 0;
              foreach ($locations as $location) { ?>
                <div class="map_info_body item <?=$active?'active':''?>" id="location_<?=$location->id?>">
                  <div class="row">
                    <div class="col-md-12 col-sm-6 col-xs-12">
                      <? $active = 0;?>
                      <p class="info_ico info_addr" data-id="<?=$location->id?>" data-num="<?=$i++?>" data-addr="г. <?=$cities[$location->city_id]?>, <?=$location->address?>">
                        <i class="icon icon-Pin"></i>
                        <?=$location->address?>
                      </p>
                      <? if ($location->metro != '') { ?>
                      <p class="info_ico">
                        <i class="icon icon icon-metro"></i>
                        <?=$location->metro?>
                      </p>
                      <? } ?>
                      <p class="info_ico">
                        <i class="icon icon icon-Mobile"></i>
                        <?=$location->tel?>
                      </p><!-- 
                      <p class="info_ico">
                        <i class="icon icon icon-Man"></i>
                        <?=$location->contact_email?>
                      </p> -->
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                      <h3>Квесты на этой локации</h3>
                      <p class="text-center local_quests">
                      <? foreach ($quests[$location->id] as $q)
                        echo '<a href="/quest/'.$q->link.'" target="_blank">'.$q->title.'</a>';
                      ?>
                      </p>
                    </div>
                  </div>
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
  Object.size = function(obj) {
      var size = 0, key;
      for (key in obj) {
          if (obj.hasOwnProperty(key)) size++;
      }
      return size;
  };

  function init_map() {
    var address = $('#meta_address').attr('content'),
        styles = [
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
        ],
        markersOptions = {},
        markers = {},
        icon_marker = '../img/marker.png',
        icon_marker_hover = '../img/marker_hover.png',
        geocoder = new google.maps.Geocoder(),
        latlngbounds = new google.maps.LatLngBounds(),
        length = $('.info_addr').length,
        map, i = 0, last = false,
        getGeocode = function(i) {
          var element = $('.info_addr[data-num="'+i+'"]');

          if (element) {

            var addr = element.attr('data-addr'),
                location_id = element.attr('data-id');
            // Get coordinats for marker
            geocoder.geocode( { 'address': addr}, function(results, status, c) {

              if (status == google.maps.GeocoderStatus.OK) {

                var ww = $(window).width(),
                    marker = {
                      id:location_id,
                      num:i,
                      icon: (i==0 && ww<769)?icon_marker_hover:icon_marker,
                      position: results[0].geometry.location
                    };

                markersOptions[i] = marker;
                latlngbounds.extend(results[0].geometry.location);

                if (i<length-1){
                  i++
                  getGeocode(i);
                } else {
                  var myMapOptions = {
                      zoom: 11,
                      scrollwheel: true,
                      disableDefaultUI: true,
                      zoomControl: true,
                      zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.SMALL,
                        position: google.maps.ControlPosition.RIGHT_TOP
                      },
                      center: latlngbounds.getCenter(), // get center of group items
                      mapTypeId: google.maps.MapTypeId.ROADMAP,
                      styles:styles
                  };
                  map = new google.maps.Map(document.getElementById("gmap_canvas"), myMapOptions);
                  
                  if (markersOptions.length>1)
                    map.fitBounds(latlngbounds);//auto zoom

                  /*google.maps.event.addListenerOnce(map, 'idle', function(){
                    console.log('map loaded');
                  });*/

                  // Create markers
                  $.each(markersOptions,function(k,v){
                    v.map = map;
                    var m = new google.maps.Marker(v);
                    markers[k] = m;
                    google.maps.event.addListener(m,'mouseover',function(){ m.setIcon(icon_marker_hover); });
                    google.maps.event.addListener(m,'mouseout',function(){ m.setIcon(icon_marker); });

                    if (Object.size(markersOptions)>1){
                      google.maps.event.addListener(m, 'click', function() {
                        if (m.num == 0) {
                          $('#carousel-location').trigger('slid.bs.carousel');
                        }
                        $('#carousel-location').carousel(m.num);
                      });
                    } else {
                      google.maps.event.addListener(m,'click',function(event){
                        map = m.getMap();
                        map.setCenter(m.getPosition()); // set map center to marker position
                        smoothZoom(map, 17, map.getZoom()); // call smoothZoom, parameters map, final zoomLevel, and starting zoom level
                      });
                    }
                  });

                  $('#carousel-location').on('slid.bs.carousel', function (e) {
                    var i = $(".active", e.target).index();
                    $.each(markers,function(k,v){
                      v.setIcon(icon_marker);
                      google.maps.event.addListener(v,'mouseover',function(){ v.setIcon(icon_marker_hover); });
                      google.maps.event.addListener(v,'mouseout',function(){ v.setIcon(icon_marker); });
                    });
                    markers[i].setIcon(icon_marker_hover);
                    google.maps.event.clearListeners(markers[i], 'mouseout');
                    google.maps.event.clearListeners(markers[i], 'mouseover');
                    map = markers[i].getMap();
                    map.setCenter(markers[i].getPosition()); // set map center to marker position
                    smoothZoom(map, 17, map.getZoom());
                    $('.map_info').animate({ left: '0' }, 500);
                  });

                  // the smooth zoom function
                  function smoothZoom (map, max, cnt) {
                    if (cnt >= max) {
                            return;
                    } else {
                        z = google.maps.event.addListener(map, 'zoom_changed', function(event){
                            google.maps.event.removeListener(z);
                            smoothZoom(map, max, cnt + 1);
                        });
                        setTimeout(function(){map.setZoom(cnt)}, 80); // 80ms is what I found to work well on my system -- it might not work well on all systems
                    }
                  }

                }

              } else {
                console.log('Geocode was not successful for the following reason: ' + status);
              }
            });
          }
        }

        getGeocode(i);
  }

  google.maps.event.addDomListener(window, "load", init_map);
</script>