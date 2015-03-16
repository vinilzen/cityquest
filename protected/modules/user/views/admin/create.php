
<div class="block">
	<div class="block-title">
		<h2><?=UserModule::t("Create User")?></h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php 
				echo $this->renderPartial('_menu',array(
					'list'=> array(),
				));
				echo $this->renderPartial('_form', array('model'=>$model));
			?>
		</div>
	</div>
</div>