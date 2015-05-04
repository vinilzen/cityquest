<?php
/* @var $this PromoDaysController */
/* @var $model PromoDays */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promo-days-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'quest_id'); ?>
		<?php echo $form->textField($model,'quest_id'); ?>
		<?php echo $form->error($model,'quest_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'day'); ?>
		<?php echo $form->textField($model,'day',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_am'); ?>
		<?php echo $form->textField($model,'price_am',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price_am'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_pm'); ?>
		<?php echo $form->textField($model,'price_pm'); ?>
		<?php echo $form->error($model,'price_pm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->