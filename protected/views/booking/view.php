<?php
/* @var $this BookingController */
/* @var $model Booking */
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
				Дата проведения мероприятия<br>
				<i class="glyphicon glyphicon-calendar"></i> <strong><?=$day; ?> <?=$month_array[$month]?> <?=$year?> <!-- <?=$model->time?> --></strong>
			</span>
			<img class="img-responsive" src="/images/winner_photo/<?=$model->winner_photo?>" alt="">
		</p>
		<? $host = $_SERVER['HTTP_HOST']; ?>
		<p class="text-center">
			<small>Поделись с друзьями</small>
		</p>
		<p class="text-center">
			<span class="share_panel">
				<a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&t=" title="Поделиться на Vk" target="_blank" onclick="window.open('http://vkontakte.ru/share.php?url=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;">
					<img src="/img/color/Vk.png">
				</a> &nbsp;
				<a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&t=" title="Поделиться на Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;">
					<img src="/img/color/Facebook.png">
				</a> &nbsp;
				<a href="https://twitter.com/intent/tweet?source=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&text=:%20http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;">
					<img src="/img/color/Twitter.png">
				</a>
				<!-- OK
					<a id="ok_shareWidget"></a>
					<script>
					!function (d, id, did, st) {
					  var js = d.createElement("script");
					  js.src = "http://connect.ok.ru/connect.js";
					  js.onload = js.onreadystatechange = function () {
					  if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
					    if (!this.executed) {
					      this.executed = true;
					      setTimeout(function () {
					        OK.CONNECT.insertShareWidget(id,did,st);
					      }, 0);
					    }
					  }};
					  d.documentElement.appendChild(js);
					}(document,"ok_shareWidget",document.URL,"{width:30,height:35,st:'oval',sz:30,nt:1,nc:1}");
					</script>
				-->
				<!--  MAIL
					<a target="_blank" class="mrc__plugin_uber_like_button" href="http://connect.mail.ru/share" data-mrc-config="{'nc' : '1', 'nt' : '1', 'cm' : '1', 'sz' : '30', 'st' : '1', 'tp' : 'mm'}">Нравится</a>
					<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>
 				-->
			</span>
			<!-- &nbsp;
				<a href="https://plus.google.com/share?url=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>" target="_blank" title="Поделиться на Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;">
					<img src="/img/color/Google+.png">
				</a> &nbsp;
				<a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&description=" target="_blank" title="Pin it" onclick="window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(document.URL) + '&description=' +  encodeURIComponent(document.title)); return false;">
					<img src="/img/color/Pinterest.png">
				</a> &nbsp;
				<a href="mailto:?subject=&body=:%20http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>" target="_blank" title="Email" onclick="window.open('mailto:?subject=' + encodeURIComponent(document.title) + '&body=' +  encodeURIComponent(document.URL)); return false;">
					<img src="/img/color/Email.png">
				</a>
			-->
		</p>
		<p class="text-center">
			<a href="/quest/<?=$quest->link?>" class="return_link">Все победители <br>этого квеста</a>
		</p>
	</div>
</div>
