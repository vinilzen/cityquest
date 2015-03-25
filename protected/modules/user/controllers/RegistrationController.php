<?php

class RegistrationController extends Controller
{
    public $layout = "//layouts/main";
	public $defaultAction = 'reg';


	/**
	 * Registration user
	 */
	public function actionRegistration() {
        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;
        
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			Yii::log('This is not the Ajax request', 'info', 'registration');
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
	    if (Yii::app()->user->id) {
	    	Yii::log('The user ('.Yii::app()->user->id.') is already registered', 'info', 'registration');
	    	$this->redirect(Yii::app()->controller->module->profileUrl);
	    } else {
	    	if(isset($_POST['RegistrationForm'])) {
				$model->attributes=$_POST['RegistrationForm'];
				$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
				if($model->validate()&&$profile->validate())
				{
					$soucePassword = $model->password;
					$model->activkey=UserModule::encrypting(microtime().$model->password);
					$model->password=UserModule::encrypting($model->password);
					$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
					$model->createtime=time();
					$model->lastvisit=((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin)?time():0;
					$model->superuser=0;
					$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
					
					if ($model->save()) {

						$profile->user_id=$model->id;
						$profile->save();

						if (Yii::app()->controller->module->sendActivationMail) {

							$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
							UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
						
						}
						
						if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
								
								$identity=new UserIdentity($model->username,$soucePassword);
								$identity->authenticate();
								Yii::app()->user->login($identity,0);
								$this->redirect(Yii::app()->controller->module->returnUrl);

						} else {

							if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
								Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
							} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
								Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
							} elseif(Yii::app()->controller->module->loginNotActiv) {
								Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
							} else {
								Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
							}
							$this->refresh();

						}
					}
				} else $profile->validate();
			}
		    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
	    }
	}

	public function actionReg() {

        $model = new RegistrationForm;

		header('Content-type: application/json');

        if ( is_null(Yii::app()->user->id) ) {

			if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['pass']) ) {
				
				$soucePassword = $model->password = $_POST['pass'];
				$model->activkey = UserModule::encrypting(microtime().$model->password);
				$model->password = UserModule::encrypting($model->password);
				$model->username = $_POST['name'];
				$model->email = $_POST['email'];
				$model->phone = $_POST['phone'];
				$model->createtime = time();
				$model->lastvisit = ((
										Yii::app()->controller->module->loginNotActiv || 
										(
											Yii::app()->controller->module->activeAfterRegister && 
											Yii::app()->controller->module->sendActivationMail==false
										)
									) && Yii::app()->controller->module->autoLogin ) ? time() : 0;

				$model->superuser = 0;
				$model->status = 1;

				if ($model->save()) {

					Yii::log('User save to db. '.Yii::app()->request->requestUri, 'info', 'registration');
	
					$identity=new UserIdentity($model->username,$soucePassword);
					$identity->authenticate();
					Yii::app()->user->login($identity,0);

		        	echo CJSON::encode(array(
		        			'success' => 1,
		        			'error' => 0,
		        			'msg' => 'Регистрация завершена, теперь вам нужно авторизоваться',
		        		));

				} else {

					Yii::log('Error save user. '.json_encode($model->getAttributes()).' - '.Yii::app()->request->requestUri, 'info', 'registration');
		        	echo CJSON::encode(array(
		        			'success' => 0,
		        			'error' => 1,
		        			'msg' => 'Не удалось создать пользователя',
		        			'errors' => $model->getErrors(),
		        		));
				}


			} else {
				Yii::log('You entered is not all data. '.Yii::app()->request->requestUri, 'info', 'registration');
        	
	        	echo CJSON::encode(array(
	        			'success' => 0,
	        			'error' => 1,
	        			'msg' => 'Неверный запрос'
	        		));
			}
        } else {
    
    		Yii::log('The user ('.Yii::app()->user->id.') is already registered. '.Yii::app()->request->requestUri, 'info', 'registration');
        	echo CJSON::encode(array(
        			'success' => 0,
        			'error' => 1,
        			'msg' => 'Вы уже авторизованы!'
        		));
        }

		Yii::app()->end();
	}
}