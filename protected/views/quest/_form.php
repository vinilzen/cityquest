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
		<p class="note help-block"><?=Yii::t('app','Fields with')?> <span class="required">*</span> <?=Yii::t('app','are required')?>.</p>

		<?=$form->errorSummary($model)?>
	</div>

	<? if ($message_success != '') { ?>
	<div class="form-group has-success">
		<span class="help-block"><?=$message_success?></span>
	</div>	
	<? } ?>

	<div class="form-group<?=(isset($errors['title']))?' has-error':''?>">
		<?=$form->labelEx($model,'title', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'title',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'title', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['content']))?' has-error':''?>">
		<?=$form->labelEx($model,'content', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'content',array('rows'=>8, 'cols'=>50,'class'=>'form-control'))?>
			<?=$form->error($model,'content', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['link']))?' has-error':''?>">
		<?=$form->labelEx($model,'link', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'link',array('size'=>60,'maxlength'=>45,'class'=>'form-control'))?>
			<?=$form->error($model,'link', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['addres']))?' has-error':''?>">
		<?=$form->labelEx($model,'addres', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'addres',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'addres', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['metro']))?' has-error':''?>">
		<?=$form->labelEx($model,'metro', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'metro',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'metro', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['times']))?' has-error':''?>">
		<label class="control-label col-sm-3 required" for="status">Начало часа<span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'times', array(
				1=>'начинаем квесты с 00:00',
				3=>'начинаем квесты с 00:15',
				2=>'начинаем квесты с 00:30',
				4=>'начинаем квесты с 10:15',
				5=>'начинаем квесты с 11:00',
			),array('class'=>'form-control'))?>
			<p class="help-block">Нельзя менять если кто-то уже записался</p>
			<?=$form->error($model,'times', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['status']))?' has-error':''?>">
		<label class="control-label col-sm-3 required" for="status">Статус <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'status', array(
				1=>Yii::t('app','Draft'),
				2=>Yii::t('app','Active'),
				3=>Yii::t('app','In development'),
			),array('class'=>'form-control'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['type']))?' has-error':''?>">
		<label class="control-label col-sm-3 required" for="type">Вид <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'type', array(
				0=>Yii::t('app','Regular'),
				1=>Yii::t('app','Sport'),
				2=>Yii::t('app','Perfomance'),
			),array('class'=>'form-control'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['difficult']))?' has-error':''?>">
		<label class="control-label col-sm-3 required" for="difficult">Сложность <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'difficult', array(
				0=>Yii::t('app','Base'),
				1=>Yii::t('app','Medium'),
				2=>Yii::t('app','High'),
			),array('class'=>'form-control'))?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<div class="checkbox">
				<label>
					<?=$form->checkBox($model,'actor' )?>
					<?=$form->labelEx($model,'actor')?>
				</label>
			</div>
		</div>
	</div>
	

	<div class="form-group<?=(isset($errors['city_id']))?' has-error':''?>">
		<label class="control-label col-sm-3 required" for="city_id">Город <span class="required">*</span></label>
		<div class="col-sm-9">
			<?=$form->dropDownList($model,'city_id', CHtml::listData($cities, 'id', 'name'), array('class'=>'form-control'))?>
		</div>
	</div>


	<div class="form-group<?=(isset($errors['start_text']))?' has-error':''?>">
		<?=$form->labelEx($model,'start_text', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'start_text',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
			<?=$form->error($model,'start_text', array('class'=>'help-block'))?>
		</div>
	</div>

	
	<div class="form-group<?=(isset($errors['page_title']))?' has-error':''?>">
		<?=$form->labelEx($model,'page_title', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'page_title',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
			<?=$form->error($model,'page_title', array('class'=>'help-block'))?>
		</div>
	</div>
	<div class="form-group<?=(isset($errors['description']))?' has-error':''?>">
		<?=$form->labelEx($model,'description', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'description',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
			<?=$form->error($model,'description', array('class'=>'help-block'))?>
		</div>
	</div>
	<div class="form-group<?=(isset($errors['keywords']))?' has-error':''?>">
		<?=$form->labelEx($model,'keywords', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'keywords',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
			<?=$form->error($model,'keywords', array('class'=>'help-block'))?>
		</div>
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