<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Create City', 'url'=>array('create')),
	array('label'=>'View City', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage City', 'url'=>array('admin')),
);
?>


<div class="block">
	<div class="block-title">
		<h2>Редактировать город "<?php echo $model->name; ?>"</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
		<div class="col-sm-12">&nbsp;</div>
	</div>
</div>
