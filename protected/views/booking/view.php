<?php
/* @var $this BookingController */
/* @var $model Booking */
?>

<div class="row rules">
	<div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
		<h1 class="h3 text-center">
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
			<?=$quest->title?>, <?=$day; ?> <?=$month_array[$month]?> <?=$model->time?> <br>
			Результат: <?=$model->result?>
		</h1>
		<!-- <h2 class="h3 text-center"></h2> -->
		<p class="text-center">
			<img class="img-responsive" src="/images/winner_photo/<?=$model->winner_photo?>" alt="">
		</p>
		<? $host = $_SERVER['HTTP_HOST']; ?>
		<p class="text-center">
			Поделиться &nbsp;
			<a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&t=" title="Поделиться на Vk" target="_blank" onclick="window.open('http://vkontakte.ru/share.php?url=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;">
				<img src="/img/color/Vk.png">
			</a> &nbsp;
			<a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&t=" title="Поделиться на Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;">
				<img src="/img/color/Facebook.png">
			</a> &nbsp;
			<a href="https://twitter.com/intent/tweet?source=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&text=:%20http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;">
				<img src="/img/color/Twitter.png">
			</a> &nbsp;
			<a href="https://plus.google.com/share?url=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>" target="_blank" title="Поделиться на Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;">
				<img src="/img/color/Google+.png">
			</a> &nbsp;
			<a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>&description=" target="_blank" title="Pin it" onclick="window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(document.URL) + '&description=' +  encodeURIComponent(document.title)); return false;">
				<img src="/img/color/Pinterest.png">
			</a> &nbsp;
			<a href="mailto:?subject=&body=:%20http%3A%2F%2F<?=$host?>%2Fresult%2F<?=$model->id?>" target="_blank" title="Email" onclick="window.open('mailto:?subject=' + encodeURIComponent(document.title) + '&body=' +  encodeURIComponent(document.URL)); return false;">
				<img src="/img/color/Email.png">
			</a>
		</p>
	</div>
</div>
