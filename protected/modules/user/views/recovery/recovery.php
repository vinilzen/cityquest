<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore"); ?>


<div class="container">
	<div class="row rules">
		<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 text-center">
			<h1>Восстановить пароль</h1>
			<br>
		</div>

		<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 text-center">


			<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
			<div class="success">
				<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
			</div>
			<?php else: ?>

			<div class="form">
			<?php echo CHtml::beginForm(); ?>

				<?php echo CHtml::errorSummary($form); ?>
				
				<div class="form-group">
					<?php //echo CHtml::activeLabel($form,'email'); ?>
					<?php echo CHtml::activeTextField($form,'email', array('class' => 'form-control input-lg', 'placeholder' => 'Email')); ?>
					<p class="help-block">Чтобы восстановить пароль, введите Email </p>
					<br>
				</div>
				
				<div class="form-group submit">
					<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class'=>"btn btn-lg btn-default btn-primary")); ?>
				</div>

			<?php echo CHtml::endForm(); ?>
			</div><!-- form -->
			<?php endif; ?>
		</div>
	</div>
</div>