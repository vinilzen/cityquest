<p>Поздравляем, Вы прошли квест "<?=$title?>"!</p>
<? if ($winner_photo != '') { ?>
	<p>Фотография вашей команды: <a href="http://cityquest.ru/result/<?=$id?>">http://cityquest.ru/result/<?=$id?></a></p>
<? } else { ?>
	<p>Фотографии вашей команды вы можете найти в наших альбомах в соц. сетях: <a href="https://www.facebook.com/cityquestru/photos_stream">https://www.facebook.com/cityquestru/photos_stream</a> и <a href="https://vk.com/albums-75922071">https://vk.com/albums-75922071</a></p>
<? } ?>