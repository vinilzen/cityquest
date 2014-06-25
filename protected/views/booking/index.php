<?php
/* @var $this BookingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bookings',
);

$this->menu=array(
	array('label'=>'Create Booking', 'url'=>array('create')),
	array('label'=>'Manage Booking', 'url'=>array('admin')),
);
?>

<h1>Bookings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
