<?php
/* @var $this PromoDaysController */
/* @var $model PromoDays */

$this->breadcrumbs=array(
	'Promo Days'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PromoDays', 'url'=>array('index')),
	array('label'=>'Create PromoDays', 'url'=>array('create')),
	array('label'=>'Update PromoDays', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PromoDays', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PromoDays', 'url'=>array('admin')),
);
?>

<h1>View PromoDays #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quest_id',
		'day',
		'price_am',
		'price_pm',
	),
)); ?>
