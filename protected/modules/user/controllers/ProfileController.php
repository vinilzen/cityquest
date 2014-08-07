<?php

class ProfileController extends Controller
{
    public $layout = "//layouts/profile";
	public $defaultAction = 'profile';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
		$bookings = Booking::model()->with('quest')->findAllByAttributes(
			array('competitor_id'=>Yii::app()->user->id),
			'date >=:today',
			array('today'=>date('Ymd'))
		);

	    $this->render('profile',array(
	    	'model'=>$model,
	    	'bookings'=>$bookings
	    ));
	}

	/**
	 * Edit Profile ajax
	 * @return json
	 */
	public function actionEdit()
	{
		if(Yii::app()->request->isAjaxRequest){


			$this->layout=false;
			header('Content-type: application/json');

			if (Yii::app()->user->id) {

				$model = Yii::app()->getModule('user')->user();
				$model->username = $_POST['username'];
				$model->phone = $_POST['phone'];

				// var_dump($model->attributes); die;

				if ( $model->save() ) {

					echo CJavaScript::jsonEncode(array('success'=>1, 'message'=>'Изменения успешно сохранены'));

				} else echo CJSON::encode(array(
										'success' => 0,
										'error' => 1,
										'errors' => $model->getErrors(),
									));

			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нет доступа'));

			Yii::app()->end();

		} else echo 'Error Request!';

		die;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit_()
	{
		$model = $this->loadUser();
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if ( $model->validate() ) {
				$model->save();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			}
		}

		$this->render('edit',array(
			'model'=>$model
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect('/'); // Yii::app()->controller->module->loginUrl
		}
		return $this->_model;
	}
}