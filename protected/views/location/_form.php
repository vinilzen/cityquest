<?php
/* @var $this LocationController */
/* @var $model Location */
/* @var $form CActiveForm */
?>

<div class="form col-sm-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'location-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data', 'role'=>'form', 'class' => 'form-horizontal'),
)); ?>

	<div class="form-group">
		<p class="note">Fields with <span class="required">*</span> are required.</p>
		<?=$form->errorSummary($model)?>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'name', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'name',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'name')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'address', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'address', array('class'=>'form-control'))?>
			<?=$form->error($model,'address')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'tel', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'tel', array('class'=>'form-control'))?>
			<?=$form->error($model,'tel')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'contact_email', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'contact_email', array('class'=>'form-control'))?>
			<?=$form->error($model,'contact_email')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'notification_email', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'notification_email', array('class'=>'form-control'))?>
			<?=$form->error($model,'notification_email')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'metro', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'metro', array('class'=>'form-control'))?>
			<?=$form->error($model,'metro')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'address_additional', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'address_additional', array('class'=>'form-control'))?>
			<?=$form->error($model,'address_additional')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'parking', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'parking', array('class'=>'form-control'))?>
			<?=$form->error($model,'parking')?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['city_id']))?' has-error':''?>">
		<label class="control-label col-sm-3 required" for="city_id">Город <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'city_id', CHtml::listData($cities, 'id', 'name'), array('class'=>'form-control'))?>
		</div>
	</div>

	<div class="row buttons">
		<div class="col-sm-3"></div>
		<div class="col-sm-9">
			<?=CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'), array('class'=>'btn btn-default'))?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->