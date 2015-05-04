<?php
/* @var $this DiscountsController */
/* @var $model Discounts */
/* @var $form CActiveForm */
?>
<div class="form col-sm-6">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discounts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('role'=>'form', 'class' => 'form-horizontal'),
)); ?>

	<p class="note"><?=Yii::t('app','Fields with')?> <span class="required">*</span> <?=Yii::t('app','are required')?>.</p>

	<?=$form->errorSummary($model); ?>

	<div class="form-group<?=(isset($model->getErrors()['key']))?' has-error':''?>">
		<?=$form->labelEx($model,'key', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'key',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
			<?=$form->error($model,'key', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($model->getErrors()['name']))?' has-error':''?>">
		<?=$form->labelEx($model,'name', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'name',array('size'=>500,'maxlength'=>500,'class'=>'form-control')); ?>
			<?=$form->error($model,'name', array('class'=>'help-block'))?>
		</div>
	</div>


	<div class="form-group<?=(isset($model->getErrors()['till_what_time']))?' has-error':''?>">
		<?=$form->labelEx($model,'till_what_time', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'till_what_time',array(
					'size'=>45,
					'maxlength'=>45,
					'class'=>'form-control input-datepicker-close',
					'data-date-format'=>"dd/mm/yy",
					'placeholder'=>"dd/mm/yy",
				)); ?>
			<?=$form->error($model,'till_what_time', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($model->getErrors()['amount']))?' has-error':''?>">
		<?=$form->labelEx($model,'amount', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'amount',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
			<?=$form->error($model,'amount', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group buttons">
		<div class="col-sm-offset-3 col-sm-9">
			<?=CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'), array('class'=>'btn btn-default'))?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->