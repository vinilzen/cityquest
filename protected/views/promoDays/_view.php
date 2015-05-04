<?php
/* @var $this PromoDaysController */
/* @var $data PromoDays */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quest_id')); ?>:</b>
	<?php echo CHtml::encode($data->quest_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('day')); ?>:</b>
	<?php echo CHtml::encode($data->day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_am')); ?>:</b>
	<?php echo CHtml::encode($data->price_am); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_pm')); ?>:</b>
	<?php echo CHtml::encode($data->price_pm); ?>
	<br />


</div>