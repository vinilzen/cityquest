<?
	$this->pageTitle= 'Подарочный сертификат на квест в реальности в Москве - CityQuest';
	$this->description= 'Подарочная карта CityQuest. Реальные игры secret room escape в Москве. Лучший подарок на день рождения и другой веселый праздник!';
	$this->keywords= 'escape room, room escape games, escape room Москва, комната room escape, подарок, подарочная карта';


	if ($this->city == 1)
		$city = 'Москве';
	elseif($this->city == 2)
		$city = 'Астане';
	else 
		$city = $this->city_name.'е';



?>
<div class="row rules">
	<div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
	<h1 class="h3 text-center">Сертификат на квест в <?=$city?></h1>
	<?=$this->city_model->giftcard_text?>
	</div>
</div>
<div class="row">
	
	<script>var my_text='<?=Yii::app()->user->getFlash('notice')?>';</script>
	
	<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<?=(isset($msg) && $msg != '')?'<p style="color:#efefef;padding-bottom:16px;">'.$msg.'</p><script>var ordergiftcard=1;</script>':''?>
		<form role="form" id="bookgift-form" action="" method="POST">
			<div class="form-group" id="form-group-reg-name">
				<input required="" class="form-control" placeholder="Имя" 
					id="bookgift-name" name="name" type="text" value="<?=$name?>">
			</div>
			<div class="form-group" id="form-group-reg-phone">
				<input required="" value="<?=$phone?>" class="form-control" 
					placeholder="+7(___)-___-__-__" id="bookgift-phone" name="phone" type="text" maxlength="17" autocomplete="off">
			</div>
			<div class="form-group" id="form-group-reg-addres">
				<input required="" value="<?=$addres?>" class="form-control" 
					placeholder="Адрес" id="bookgift-addres" name="addres" type="addres">
			</div>
			<div class="form-group">
				<textarea name="comment" class="form-control" id="bookgift-comment" placeholder="Комментарий" rows="1"><?=$comment?></textarea>
			</div>
			<div style="display:none;">
				<input type="text" name="message" value="">
				<input type="text" id="mytxt" name="my_text" value="">
			</div>
			<? if ($show_captcha == 1) { ?>
			<div class="form-group" id="form-group-reg-captcha">
				<div class="row">
					<div class="col-xs-12 text-center">
						<label>Необходимо вписать код с картинки</label>
						<?
							$error = Yii::app()->user->getFlash('error');
							if ( $error != '') echo '<p class="text-danger">'.$error.'</p>';
						?>
					</div>
					<div class="col-xs-6">
						<input required="" class="form-control" placeholder="Код с картинки" id="bookgift-captcha" name="captcha" type="text">
					</div>
					<div class="col-xs-6 text-right">
						<? $this->widget('CCaptcha',array('clickableImage' =>true,'buttonLabel' =>'')); ?>
					</div>
				</div>
			</div>
			<? } ?>
			<div id="myModalAuth">
				<button class="btn btn-default btn-block btn-lg" type="submit">Заказать</button>
			</div>
		</form>


		<div style="display: none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
			<meta itemprop="bestRating" content="5" />
			<meta itemprop="ratingValue" content="5" />
			<meta itemprop="ratingCount" content="42" />
		</div>
	</div>
</div>