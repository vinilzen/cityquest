<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Location', 'url'=>array('index')),
	array('label'=>'Create Location', 'url'=>array('create')),
	array('label'=>'View Location', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Location', 'url'=>array('admin')),
);
?>



<div class="block">
	<div class="block-title">
		<h2><?=Yii::t('app','Update')?> <?=Yii::t('app','Location')?> "<?php echo $model->name; ?>"</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php $this->renderPartial('_form', array(
            'model'=>$model, 
            'errors'=>$errors,
            'cities'=>$cities,
            'message_success'=>$message_success
          )); ?>
		</div>
		<div class="col-sm-12">&nbsp;</div>
	</div>
</div>