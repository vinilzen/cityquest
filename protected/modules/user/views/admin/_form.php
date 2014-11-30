<div class="">
	<div class="form row">

	<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')); ?>

		<?php echo CHtml::errorSummary(array($model)); ?>

		<div class="form-group">
			<div class="my_form_label col-sm-5"></div>
			<div class="my_form_control col-sm-7 ">
				<span class="note">
					<?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?>
				</span>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'name',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeTextField($model,'username',array('class'=>'form-control', 'maxlength'=>20)); ?>
				<?php echo CHtml::error($model,'username'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'password',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activePasswordField($model,'password',array('class'=>'form-control', 'maxlength'=>128)); ?>
				<?php echo CHtml::error($model,'password'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'phone',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeTextField($model,'phone',array('class'=>'form-control', 'maxlength'=>18)); ?>
				<?php echo CHtml::error($model,'phone'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'username',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeTextField($model,'email',array('class'=>'form-control', 'maxlength'=>128)); ?>
				<?php echo CHtml::error($model,'email'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'superuser',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeDropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('class'=>'form-control')); ?>
				<?php echo CHtml::error($model,'superuser'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'status',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus'),array('class'=>'form-control')); ?>
				<?php echo CHtml::error($model,'status'); ?>
			</div>
		</div>

		<?php if ($model->superuser == 2) { ?>
			<div class="form-group set_moderator_quests">
				<?php echo CHtml::activeLabelEx($model,'quests',array('class'=>'control-label my_form_label col-sm-5')); ?>
				<div class="my_form_control col-sm-7 ">
					<?php echo CHtml::checkBoxList('User[quests][]', explode(',', $model->quests), $quests); ?>
					<?php echo CHtml::error($model,'quests'); ?>
				</div>
			</div>
		<?php } ?>

		<div class="form-group buttons">
			<div class="my_form_label col-sm-5"></div>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', array('class'=>'btn')); ?>
			</div>
		</div>


	<?php echo CHtml::endForm(); ?>

	</div>
</div>