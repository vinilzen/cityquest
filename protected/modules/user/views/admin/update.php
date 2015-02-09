<?php ?>

<h1><?php echo "#".$model->id.' '.$model->username; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('View User'),array('view','id'=>$model->id)),
		),
	)); 

	echo $this->renderPartial('_form', array('model'=>$model, 'quests'=>$quests)); ?>