<?php

class LoginController extends Controller
{
    public $layout = "//layouts/main";
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(Yii::app()->request->isAjaxRequest){
			header('Content-type: application/json');

			if (Yii::app()->user->isGuest) {

				$model=new UserLogin;

				if(isset($_POST['UserLogin']))
				{
					$model->attributes=$_POST['UserLogin'];
					// validate user input and redirect to previous page if valid
					
					if($model->validate()) {

						echo CJSON::encode(array(
			        			'success' => 1,
			        			'error' => 0,
			        			'msg' => 'Вы успешно авторизовались!'
			        		));

					} else
						echo CJSON::encode(array(
			        			'success' => 0,
			        			'error' => 1,
			        			'msg' => 'Ошибка авторизации',
			        			'errors' => $model->getErrors(),
			        		));
				} else
					echo CJSON::encode(array(
		        			'success' => 0,
		        			'error' => 1,
		        			'msg' => 'Неверный запрос'
		        		));
				
			} else
	        	echo CJSON::encode(array(
	        			'success' => 0,
	        			'error' => 1,
	        			'msg' => 'Вы уже авторизованы!'
	        		));

	       	Yii::app()->end();
		} else {
			$this->redirect('/');
		}
	}

}