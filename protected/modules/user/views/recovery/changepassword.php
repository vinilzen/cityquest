<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password"); ?>


<div class="container">
	<div class="row rules">
		<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 text-center">
			<h1>Сменить пароль</h1>
			<br>

			<div class="form text-left">
			<?php echo CHtml::beginForm('','post',array('role'=>'form', 'class' => 'form-horizontal')); ?>

				<?php echo CHtml::errorSummary($form); ?>
				
				<div class="form-group">
					<?php // echo CHtml::activeLabelEx($form,'password',array('class' => 'col-sm-3')); ?>
					<div class="col-sm-12">
						
						<?php echo CHtml::activePasswordField($form,'password', array('class' => 'form-control input-lg', 'placeholder' => 'Пароль')); ?>
						<!-- <p class="help-block"><?php echo UserModule::t("Minimal password length 4 symbols."); ?></p> --> 
					</div>
				</div>
				
				<div class="form-group">
					<?php // echo CHtml::activeLabelEx($form,'verifyPassword',array('class' => 'col-sm-3')); ?>
					<div class="col-sm-12">
						<?php echo CHtml::activePasswordField($form,'verifyPassword', array('class' => 'form-control input-lg', 'placeholder' => 'Повторите пароль')); ?>
					</div>
				</div>
				
				<!-- <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p> --> 
				
				<div class="form-group submit text-center">
					<?php echo CHtml::submitButton(UserModule::t("Save"), array('class'=>"btn btn-lg btn-default btn-primary")); ?>
				</div>

			<?php echo CHtml::endForm(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>