<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>


<div class="form col-sm-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data', 'role'=>'form', 'class' => 'form-horizontal'),
)); ?>
	<div class="form-group">
		<p class="note">Fields with <span class="required">*</span> are required.</p>
		<?php echo $form->errorSummary($model); ?>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'name', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'name',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'name')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'country', array('class' => 'control-label col-sm-3')	)?>
		<div class="col-sm-9">
			<?=$form->textField($model,'country', array('class'=>'form-control'))?>
			<?=$form->error($model,'country')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'active', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'active', array('class'=>'form-control'))?>
			<?=$form->error($model,'active')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'languages', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'languages', array('class'=>'form-control'))?>
			<?=$form->error($model,'languages')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'subdomain', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'subdomain', array('class'=>'form-control'))?>
			<?=$form->error($model,'subdomain')?>
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
		<?=$form->labelEx($model,'addres', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'addres', array('class'=>'form-control'))?>
			<?=$form->error($model,'addres')?>
		</div>
	</div>
	<div class="form-group">
		<?=$form->labelEx($model,'giftcard_text', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'giftcard_text', array('rows'=>8, 'class'=>'form-control'))?>
			<?=$form->error($model,'giftcard_text')?>
		</div>
	</div>
	<div class="form-group">
		<?=$form->labelEx($model,'franchise_text', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'franchise_text', array('rows'=>9, 'class'=>'form-control'))?>
			<?=$form->error($model,'franchise_text')?>
		</div>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'giftcard_mail', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'giftcard_mail', array( 'class'=>'form-control'))?>
			<?=$form->error($model,'giftcard_mail')?>
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