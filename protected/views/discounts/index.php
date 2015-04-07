<?php
/* @var $this DiscountsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Discounts',
);

$this->menu=array(
	array('label'=>'Create Discounts', 'url'=>array('create')),
	array('label'=>'Manage Discounts', 'url'=>array('admin')),
);
?>

<h1>Discounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
