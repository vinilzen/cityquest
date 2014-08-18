<?php

class RecoveryController extends Controller
{
    public $layout = "//layouts/main";
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionChange () {

		$form = new UserChangePass;
		
		header('Content-type: application/json');


		if (Yii::app()->user->id) {

			if(isset($_POST['UserChangePassword'])) {

				$form2 = new UserChangePassForm;
		    	$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));

				$form2->attributes=$_POST['UserChangePassword'];
				if($form2->validate()) {
					$find->password = Yii::app()->controller->module->encrypting($form2->password);
					$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
					if ($find->status==0) {
						$find->status = 1;
					}
					$find->save();
					Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
					$this->redirect(Yii::app()->controller->module->recoveryUrl);
				}
			} 

		} else {
        	echo CJSON::encode(array(
        			'success' => 0,
        			'error' => 1,
        			'msg' => 'Вы не авторизованы!'
        		));
		}

		Yii::app()->end();
	}

	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
				if ($email&&$activkey) {
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = Yii::app()->controller->module->encrypting($form2->password);
								$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {

						header('Content-type: application/json');

			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) {
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
							
							$subject = UserModule::t("Вы запросили восстановление пароля для сайта {site_name}", array( '{site_name}'=>Yii::app()->name ));

			    			$message = "Вы запросили восстановление пароля для сайта ".Yii::app()->name.".<br>".
			    						"Чтобы создать новый пароль, перейдите по  <a href='".$activation_url."' target='_blank'>ссылке</a>";
							
			    			UserModule::sendMail($user->email,$subject,$message);

				        	echo CJSON::encode(array(
				        			'success' => 1,
				        			'error' => 0,
				        			'msg' => UserModule::t("Пожалуйста проверьте свой Email. Инструкции для восстановления пароля были отправлены на вашу почту."),
				        			'subject' => $subject,
				        			'message' => $message,
				        		));
			    			

			    			Yii::app()->end();
							// Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. An instructions was sent to your email address."));
			    			// $this->refresh();
			    		} else {

				        	echo CJSON::encode(array(
				        			'success' => 0,
				        			'error' => 1,
				        			'msg' => 'Некорректные данные',
				        			'errors' => $form->getErrors(),
				        		));
			    		}
			    	} else {
		    			$this->render('recovery',array('form'=>$form));
			    	}
		    	}
		    }
	}

}