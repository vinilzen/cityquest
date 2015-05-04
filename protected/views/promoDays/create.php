<?php
/* @var $this PromoDaysController */
/* @var $model PromoDays */

$this->breadcrumbs=array(
	'Promo Days'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PromoDays', 'url'=>array('index')),
	array('label'=>'Manage PromoDays', 'url'=>array('admin')),
);
?>

<h1>Create PromoDays</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>