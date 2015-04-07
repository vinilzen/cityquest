<?php
/* @var $this PaymentsController */
/* @var $model Payments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payments-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('role'=>'form', 'class' => 'form-horizontal'),
)); ?>

	<div class="row">
		<div class="col-sm-offset-3 col-sm-9">
			<p class="note"><?=Yii::t('app','Fields with')?> <span class="required">*</span> <?=Yii::t('app','are required')?>.</p>
		</div>
	</div>

	<?=$form->errorSummary($model)?>

	<div class="form-group">
		<?=$form->labelEx($model,'name', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'name',array('size'=>45,'maxlength'=>45))?>
		</div>
		<?=$form->error($model,'name')?>
	</div>

	<div class="form-group buttons">
		<div class="col-sm-offset-3 col-sm-9">
			<?=CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'), array('class'=>'btn btn-default'))?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->