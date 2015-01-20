<h1>Шаблон письма для тех, кто <?php echo $not; ?>прошел квест</h1>
<form action="" method="POST">
	<div class="form-group">
		<label for="exampleInputFile">Содержимое шаблона</label>
		<textarea name="tpl" class="form-control" rows="10"><?php echo $text; ?></textarea>
		<p class="help-block">Имена переменных в скобках <&nbsp;?php *** ?> нельзя менять!</p>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Save</button>
	</div>
	<? if (isset($msg) && $msg != '') { ?>
		<div class="form-group" id="msg_fade">
			<div class="alert alert-success" role="alert"><?php echo $msg; ?></div>
		</div>
		<script>
			var s = document.getElementById('msg_fade').style;
			s.opacity = 1; // sets the opacity to be fully opaque
			(function fade() { // function will automatically execute itself
			    if ((s.opacity-=.1) < 0) // decrements the opacity by .1 AND checks if the opacity is less than 0
			        s.display="none"; // if the opacity has dropped below 0, hide the element altogether
			    else
			        setTimeout(fade,100);  // otherwise, run this function again in 40ms
			})();
		</script>
	<? } ?>
</form>