
<h1><?php echo UserModule::t("Create User"); ?></h1>

<?php 
	echo $this->renderPartial('_menu',array(
		'list'=> array(),
	));
	echo $this->renderPartial('_form', array('model'=>$model));
?>