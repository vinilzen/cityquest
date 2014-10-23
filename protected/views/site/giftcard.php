<div class="row rules">
	<div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
		<h3 class="text-center">Подарочная карта</h3>
		<p>Вы можете подарить впечатления от наших квестов своим близким, друзьям и коллегам! Для этого достаточно приобрести нашу фирменную подарочную карту, действующую во всех локациях CityQuest.  Для того, чтобы воспользоваться картой, просто приносите ее с собой на игру.<br></p>

		<p>Карту можно приобрести у нас на квесте, либо воспользоваться доставкой в пределах МКАД.  Подробности Вы можете уточнить по телефону 8 (495) 749-96-09</p>

		<p>Стоимость подарочной карты 3500 руб, стоимость доставки 300 руб.</p>
	</div>
</div>
<div class="row">
	<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<?php if (isset($msg) && $msg != '') echo '<p style="color:#efefef; padding-bottom: 16px;">'.$msg.'</p>'; ?>
		<form role="form" id="bookgift-form" action="" method="POST">
			<div class="form-group" id="form-group-reg-name">
				<input required="" class="form-control" placeholder="Имя" id="bookgift-name" name="name" type="text">
			</div>
			<div class="form-group" id="form-group-reg-phone">
				<input required="" class="form-control" placeholder="+7(___)-___-__-__" id="bookgift-phone" name="phone" type="text" maxlength="17" autocomplete="off">
			</div>
			<div class="form-group" id="form-group-reg-addres">
				<input required="" class="form-control" placeholder="Адрес" id="bookgift-addres" name="addres" type="addres">
			</div>
			<div id="myModalAuth">
				<button class="btn btn-default btn-block btn-lg" type="submit">Заказать</button>
			</div>
		</form>
	</div>
</div>