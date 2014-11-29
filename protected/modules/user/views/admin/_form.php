<div class="col-sm-8">
	<div class="form row">

	<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')); ?>

		<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

		<?php echo CHtml::errorSummary(array($model)); ?>

		<div class="form-group">
			<div class="col-sm-5">
				<?php echo CHtml::activeLabelEx($model,'username'); ?>
			</div>
			<div class="col-sm-7">
				<?php echo CHtml::activeTextField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo CHtml::error($model,'username'); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-5">
				<?php echo CHtml::activeLabelEx($model,'password'); ?>
			</div>
			<div class="col-sm-7">
				<?php echo CHtml::activePasswordField($model,'password',array('maxlength'=>128)); ?>
				<?php echo CHtml::error($model,'password'); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-5">
				<?php echo CHtml::activeLabelEx($model,'phone'); ?>
			</div>
			<div class="col-sm-7">
				<?php echo CHtml::activeTextField($model,'phone',array('maxlength'=>18)); ?>
				<?php echo CHtml::error($model,'phone'); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-5">
				<?php echo CHtml::activeLabelEx($model,'email'); ?>
			</div>
			<div class="col-sm-7">
				<?php echo CHtml::activeTextField($model,'email',array('maxlength'=>128)); ?>
				<?php echo CHtml::error($model,'email'); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-5">
				<?php echo CHtml::activeLabelEx($model,'superuser'); ?>
			</div>
			<div class="col-sm-7">
				<?php echo CHtml::activeDropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
				<?php echo CHtml::error($model,'superuser'); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-5">
				<?php echo CHtml::activeLabelEx($model,'status'); ?>
			</div>
			<div class="col-sm-7">
				<?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus')); ?>
				<?php echo CHtml::error($model,'status'); ?>
			</div>
		</div>

		<?php if ($model->superuser == 2) { ?>
			<div class="form-group set_moderator_quests">
				<div class="col-sm-5">
					<?php echo CHtml::activeLabelEx($model,'quests'); ?>
				</div>
				<div class="col-sm-7">
					<?php echo CHtml::checkBoxList('User[quests][]', explode(',', $model->quests), $quests); ?>
					<?php echo CHtml::error($model,'quests'); ?>
				</div>
			</div>
		<?php } ?>

		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>


	<?php echo CHtml::endForm(); ?>

	</div>
</div>