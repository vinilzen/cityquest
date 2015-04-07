<?php
/* @var $this DiscountsController */
/* @var $model Discounts */

$this->breadcrumbs=array(
	'Discounts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Discounts', 'url'=>array('index')),
	array('label'=>'Create Discounts', 'url'=>array('create')),
	array('label'=>'Update Discounts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Discounts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Discounts', 'url'=>array('admin')),
);
?>

<h1>View Discounts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'key',
		'name',
	),
)); ?>
