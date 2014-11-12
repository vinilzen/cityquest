<?php

class SiteController extends Controller
{
	public $layout='page';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionAbout()
	{
		$this->pageTitle = Yii::app()->name . ' - Правила игры';
	    $this->render('pages/about');
	}

	/**
	* Send mail method
	*/
	public static function sendMail($email,$subject,$message) {
		$helloEmail = Yii::app()->params['helloEmail'];
		$headers = "MIME-Version: 1.0\r\nFrom: CityQuest <$helloEmail>\r\nReply-To: $helloEmail\r\nContent-Type: text/html; charset=utf-8";
		$message = wordwrap($message, 70);
		$message = str_replace("\n.", "\n..", $message);
		return 1; //mail($email,"=?UTF-8?B?".base64_encode($subject)."?=",$message,$headers);
	}

	public function actionGiftcard()
	{
		$msg = '';
		if (isset($_POST['name']) && $_POST['name'] != '' && isset($_POST['phone']) 
			&& $_POST['phone'] != '' && isset($_POST['addres']) && $_POST['addres'] != ''
		){
			$this->sendMail(
				'ilya@cityquest.ru, e.roslovets@cityquest.ru',
				//'marchukilya@gmail.com',
				"CityQuest. Заказ подарочной карты",
				"Имя - ".$_POST['name']."<br>".
				"Телефон -  ".$_POST['phone']."<br>".
				"Адрес - ".$_POST['addres'] );
			$msg = 'Мы получили ваш заказ, в ближайшее время с вами свяжутся по указаному номеру!';
		}

		$this->pageTitle = Yii::app()->name . ' - Подарочные карты';
	    $this->render('giftcard',array('msg'=>$msg));
	}

	public function actionFranchise()
	{
		$this->pageTitle = Yii::app()->name . ' - Франшиза';
	    $this->render('pages/franchise');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$this->pageTitle = Yii::app()->name . ' - Контакты';

		if ( 0 ) {

			$model=new ContactForm;
			if(isset($_POST['ContactForm']))
			{
				$model->attributes=$_POST['ContactForm'];
				if($model->validate())
				{
					$headers="From: {$model->email}\r\nReply-To: {$model->email}";
					mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
					Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
					$this->refresh();
				}
			}
			
			$this->render('contact',array('model'=>$model));
		
		} else {

			$this->render('contact_map');
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
