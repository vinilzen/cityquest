<?
 $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
?>

<div class="row">
	<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<h3 class="text-center login-title"><?=UserModule::t("Login")?></h3>
		<div class="row social_auth">
			<div class="col-xs-6 text-right">
				<a class="vk" href="https://oauth.vk.com/authorize?client_id=4659293&scope=uid,first_name,last_name,sex,bdate,email&redirect_uri=http://cq.il/user/login/vkauth&response_type=code"></a>
			</div>
			<div class="col-xs-6 text-left">
			    <div id="fb_logincustom_btn" onclick="loginFb();"></div>
			</div>
			<div class="col-xs-12">
				<div class="orTbl">
					<div class="orRow">
						<div class="orCell orL"></div>
						<div class="orCell orC"><span>или</span></div>
						<div class="orCell orR"></div>
					</div>
				</div>
			</div>
	    </div>
	</div>

	<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
			<div class="success"><?=Yii::app()->user->getFlash('loginMessage')?></div>
		<?php endif; ?>

		<!-- 
			<p><?=UserModule::t("Please fill out the following form with your login credentials:")?></p>
		-->

		<div class="form">
		<?=CHtml::beginForm()?>

			<!--
				<p class="note"><?=UserModule::t('Fields with <span class="required">*</span> are required.')?><p>
			-->
			
			<?=CHtml::errorSummary($model)?>
			
			<div class="form-group">
				<?=CHtml::activeTextField($model,'username', array(
					'class'=>'form-control',
					'placeholder'=>'Email',
					))?>
			</div>
			
			<div class="form-group">
				<?=CHtml::activePasswordField($model,'password', array(
					'class'=>'form-control',
					'placeholder'=>'Пароль',
					))?>
			</div>
			
			<div class="form-group hide">
				<p class="hint">
					<?=CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?>
					|
					<?=CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl);?>
				</p>
			</div>

			<div class="form-group submit" id="myAuth">
				<input type="hidden" name="UserLogin[rememberMe]" id="UserLogin_rememberMe" value="1" />
				<?=CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btn-default btn-block btn-lg'))?>
			</div>
			
		<?=CHtml::endForm()?>
		</div><!-- form -->

		<?
		$form = new CForm(array(
		    'elements'=>array(
		        'username'=>array(
		            'type'=>'text',
		            'maxlength'=>32,
		        ),
		        'password'=>array(
		            'type'=>'password',
		            'maxlength'=>32,
		        ),
		        'rememberMe'=>array(
		            'type'=>'checkbox',
		        )
		    ),

		    'buttons'=>array(
		        'login'=>array(
		            'type'=>'submit',
		            'label'=>'Login',
		        ),
		    ),
		), $model);
		?>
	</div>
</div>