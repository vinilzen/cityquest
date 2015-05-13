<?php
	/* @var $this QuestController */
	/* @var $model Quest */
	/* @var $form CActiveForm */
?>

<div class="form col-md-8 col-lg-6 col-sm-12">

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



	<div class="form-group<?=( isset($errors['price_am']) || isset($errors['price_pm']) )?' has-error':''?>">
		<?=$form->labelEx($model,'price_am', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-3">
			<?=$form->textField($model,'price_am',array('size'=>10,'maxlength'=>10,'class'=>'form-control'))?>
			<?=$form->error($model,'price_am', array('class'=>'help-block'))?>
		</div>
		<?=$form->labelEx($model,'price_pm', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-3">
			<?=$form->textField($model,'price_pm',array('size'=>10,'maxlength'=>10,'class'=>'form-control'))?>
			<?=$form->error($model,'price_pm', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=( isset($errors['price_weekend_am']) || isset($errors['price_weekend_pm']) )?' has-error':''?>">
		<?=$form->labelEx($model,'price_weekend_am', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-3">
			<?=$form->textField($model,'price_weekend_am',array('size'=>10,'maxlength'=>10,'class'=>'form-control'))?>
			<?=$form->error($model,'price_weekend_am', array('class'=>'help-block'))?>
		</div>
		<?=$form->labelEx($model,'price_weekend_pm', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-3">
			<?=$form->textField($model,'price_weekend_pm',array('size'=>10,'maxlength'=>10,'class'=>'form-control'))?>
			<?=$form->error($model,'price_weekend_pm', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['addres']))?' has-error':''?>">
		<?=$form->labelEx($model,'addres', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'addres',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'addres', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['addres_additional']))?' has-error':''?>">
		<?=$form->labelEx($model,'addres_additional', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'addres_additional',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'addres_additional', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['metro']))?' has-error':''?>">
		<?=$form->labelEx($model,'metro', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textField($model,'metro',array('size'=>60,'maxlength'=>128,'class'=>'form-control'))?>
			<?=$form->error($model,'metro', array('class'=>'help-block'))?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['time_preregistration']))?' has-error':''?>">
		<?=$form->labelEx($model,'time_preregistration', array('class' => 'control-label col-sm-3'))?>

		<div class="col-sm-9">
			<div class="input-group bootstrap-timepicker">
				<input type="text" class="form-control input-timepicker24" value="00:00">
				<span class="input-group-btn">
					<a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
				</span>
			</div>
			<p class="help-block">(чч:мм)</p>
			<?=$form->hiddenField($model,'time_preregistration')?>
			<?=$form->error($model,'time_preregistration', array('class'=>'help-block'))?>
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

	<div class="form-group<?=(isset($errors['mail_for_notifications']))?' has-error':''?>">
		<?=$form->labelEx($model,'mail_for_notifications', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<?=$form->textArea($model,'mail_for_notifications',array('rows'=>2, 'cols'=>50,'class'=>'form-control'))?>
			<?=$form->error($model,'mail_for_notifications', array('class'=>'help-block'))?>
		</div>
	</div>
	
	<div class="form-group hide">
		<div class="col-sm-offset-3 col-sm-9">
				<? //echo (file_exists('.'.$img_path))?'<img src="'.$img_path.'" width="100" />':''; ?>
			<div class="checkbox">
				<label>
					<? // $form->checkBox($model,'del_img' )?>
					<? // $form->labelEx($model,'del_img') ?>
				</label>
			</div>
		</div>
	</div>
	<div class="form-group hide">
		<div class="col-sm-offset-3 col-sm-9">
			<?=CHtml::activeFileField($model, 'image')?>
		</div>
	</div>


	<div class="form-group<?=(isset($errors['cover']))?' has-error':''?>">
		<?=$form->labelEx($model,'cover', array('class' => 'control-label col-sm-3'))?>
		<div class="col-sm-9">
			<img src="/images/thumbnail/<?=$model->cover?>" width="80" id="quest_cover_image" alt="">
			<div class="btn btn-default form-control" id="selectCover" data-toggle="modal" data-target="#ModalSetCover">
				Выбрать обложку квеста</div>
			<?=$form->error($model,'cover', array('class'=>'help-block'))?>
			<?=$form->hiddenField($model,'cover')?>
		</div>
	</div>

	<div class="form-group<?=(isset($errors['cover']))?' has-error':''?>">
		<label class="control-label col-sm-3">Изображения квеста</label>
		<div class="col-sm-9">
			<div class="photos">
			<?
				$ids = array();
				foreach ($model->photo as $image) {
					$ids[] = $image->id;
					echo '<img data-id="'.$image->id.'" class="quest_photo" src="/images/thumbnail/'.$image->name.'" > ';
				}
			?>
			</div>
			<input type="hidden" name="photo" value="<?=implode($ids,',')?>">
			<div class="btn btn-default form-control" id="selectImage" data-toggle="modal" data-target="#ModalSelectImage">
				Выбрать изображения квеста</div>
		</div>
	</div>
	

	<div class="form-group buttons">
		<div class="col-sm-offset-3 col-sm-9">
			<?=CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'), array('class'=>'btn btn-default'))?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="modal fade" id="ModalSetCover" tabindex="-1" role="dialog" aria-labelledby="ModalSetCoverLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=Yii::t('app','Select cover')?></h4>
      </div>
      <div class="modal-body"><div class="row"></div></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('app','Close')?></button>
        <button type="button" class="btn btn-primary select_cover"><?=Yii::t('app','Select')?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalSelectImage" tabindex="-1" role="dialog" aria-labelledby="ModalSelectImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=Yii::t('app','Select images')?></h4>
      </div>
      <div class="modal-body"><div class="row"></div></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('app','Close')?></button>
        <button type="button" class="btn btn-primary select_photo"><?=Yii::t('app','Select')?></button>
      </div>
    </div>
  </div>
</div>