<?php
/* @var $this PromoDaysController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Promo Days',
);

$this->menu=array(
	array('label'=>'Create PromoDays', 'url'=>array('create')),
	array('label'=>'Manage PromoDays', 'url'=>array('admin')),
);
?>

<h1>Promo Days</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
