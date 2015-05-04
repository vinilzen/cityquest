<?php
/* @var $this PromoDaysController */
/* @var $model PromoDays */

$this->breadcrumbs=array(
	'Promo Days'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PromoDays', 'url'=>array('index')),
	array('label'=>'Create PromoDays', 'url'=>array('create')),
	array('label'=>'View PromoDays', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PromoDays', 'url'=>array('admin')),
);
?>

<h1>Update PromoDays <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>