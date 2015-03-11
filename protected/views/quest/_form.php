<?php
	/* @var $this QuestController */
	/* @var $model Quest */
	/* @var $form CActiveForm */
?>

<div class="form col-sm-6">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quest-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data', 'role'=>'form', 'class' => 'form-horizontal'),
)); ?>
	<div class="form-group">
		<p class="note help-block">Fields with <span class="required">*</span> are required.</p>

		<?=$form->errorSummary($model)?>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'title', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'title',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'title')?>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'content', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'content',array('rows'=>8, 'cols'=>50,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'content')?>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'addres', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'addres',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'addres')?>
	</div>

	<div class="form-group">
		<?=$form->labelEx($model,'metro', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'metro',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'metro')?>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-3 required" for="status">Начало часа<span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'times', array(
				1=>'начинаем квесты с 00:00',
				3=>'начинаем квесты с 00:15',
				2=>'начинаем квесты с 00:30',
				4=>'начинаем квесты с 10:15',
			),array('class'=>'form-control'))?>
			<p class="help-block">Нельзя менять если кто-то уже записался</p>
		</div>
		<?=$form->error($model,'times')?>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-3 required" for="status">Статус <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'status', array(
				1=>Yii::t('app','Draft'),
				2=>Yii::t('app','Active'),
				3=>Yii::t('app','In development'),
			),array('class'=>'form-control'))?>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-3 required" for="city_id">Город <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'city_id', CHtml::listData($cities, 'id', 'name'), array('class'=>'form-control'))?>
		</div>
	</div>


	<div class="form-group">
		<?=$form->labelEx($model,'start_text', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'start_text',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'start_text')?>
	</div>

	
	<div class="form-group">
		<?=$form->labelEx($model,'page_title', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'page_title',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'page_title')?>
	</div>
	<div class="form-group">
		<?=$form->labelEx($model,'description', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'description',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'description')?>
	</div>
	<div class="form-group">
		<?=$form->labelEx($model,'keywords', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'keywords',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
		</div>
		<?=$form->error($model,'keywords')?>
	</div>

	<? $img_path = '/images/q/'.$model->id.'.jpg'; ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
				<?=(file_exists('.'.$img_path))?'<img src="'.$img_path.'" width="100" />':''?>
			<div class="checkbox">
				<label>
					<?=$form->checkBox($model,'del_img' )?><?=$form->labelEx($model,'del_img')?>
				</label>
			</div>
		</div>
	</div>
	

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<?=CHtml::activeFileField($model, 'image')?>
		</div>
	</div>

	<div class="form-group buttons">
		<div class="col-sm-offset-3 col-sm-9">
			<?=CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'), array('class'=>'btn btn-default'))?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->