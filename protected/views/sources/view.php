<?php
/* @var $this SourcesController */
/* @var $model Sources */

$this->breadcrumbs=array(
	'Sources'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Sources', 'url'=>array('index')),
	array('label'=>'Create Sources', 'url'=>array('create')),
	array('label'=>'Update Sources', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sources', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sources', 'url'=>array('admin')),
);
?>

<h1>View Sources #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
