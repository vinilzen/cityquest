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
				'backColor'=>0x0a1630,
				'transparent'=>true,
				'foreColor'=>0xFFFFFF,
				'maxLength'=>6,
				'minLength'=>3,
				'height'=>39,
				'width'=>140,
				'offset'=>1,
			),
		);
	}

    public function accessRules() {
        return array(
        	array('allow', 
        		'actions' => array('captcha'),
        		'users' => array('*')
        	),
        	array('allow',
				'actions'=>array('editmailtpl'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 2",
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
		return mail($email,"=?UTF-8?B?".base64_encode($subject)."?=",$message,$headers);
	}

	private function getUserIP() {
		if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
				$addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
				return trim($addr[0]);
			} else {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	public function actionGiftcard()
	{
		$msg = '';
		$show_captcha = 0;
		$code = 0;
		$test_text = "us_".time();

		Yii::app()->user->setFlash('notice', md5($test_text));
		$cookie = isset(Yii::app()->request->cookies['myuid']) ? Yii::app()->request->cookies['myuid']->value : '';

		if (isset($_POST['message'])){

			// log
			$captcha_model = new Captcha;
			$captcha_model->ip = $this->getUserIP();
			$captcha_model->name = $_POST['name'];
			$captcha_model->info = $_SERVER['HTTP_USER_AGENT'];
			$captcha_model->time_attempt = time();
			$captcha_model->save();


			$count_try = Captcha::model()->count("time_attempt>:time_attempt AND ip=:ip",
				array(
					"time_attempt" => time()-60*1, // 10 min
					"ip" => $captcha_model->ip,
			));


			if ( 	$_POST['message'] != '' || isset($_POST['captcha']) || $count_try > 5 ||
					md5($cookie) != $_POST['my_text'] || Yii::app()->request->isAjaxRequest
			) { // пусто от людей и куки и js
				$show_captcha = 1;
				$captcha=Yii::app()->getController()->createAction("captcha");
				$code = $captcha->verifyCode;
			}

			if (isset($_POST['name']) && $_POST['name'] != '' && isset($_POST['phone']) 
				&& $_POST['phone'] != '' && isset($_POST['addres']) && $_POST['addres'] != ''
			){
				if ($show_captcha == 0 || (isset($_POST['captcha']) && $_POST['captcha'] == $code)){
					$this->sendMail(
						'ilya@cityquest.ru, e.roslovets@cityquest.ru',
						//'marchukilya@gmail.com',
						"CityQuest. Заказ подарочной карты",
						"Имя - ".$_POST['name']."<br>".
						"Телефон -  ".$_POST['phone']."<br>".
						"Адрес - ".$_POST['addres'] );
					$msg = 'Мы получили ваш заказ, в ближайшее время с вами свяжутся по указаному номеру!';
					Yii::app()->user->setFlash('success', $msg);
					$_POST['name'] = '';
					$_POST['phone'] = '';
					$_POST['addres'] = '';
					$show_captcha = 0;
				} else {
					if (isset($_POST['captcha']) && $_POST['captcha'] != $code){
						Yii::app()->user->setFlash('error', 'Не верный код с картинки');
					}
				}
			}
		}

		Yii::app()->request->cookies['myuid'] = new CHttpCookie('myuid', $test_text);
		$this->pageTitle = Yii::app()->name . ' - Подарочные карты';
	    $this->render('giftcard',array(
	    	'msg'=>$msg,
	    	'show_captcha'=>$show_captcha,
	    	'name' => isset($_POST['name']) ? $_POST['name'] : '',
			'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
			'addres' => isset($_POST['addres']) ? $_POST['addres'] : '',
	    ));
	}

	public function actionFranchise()
	{
		$this->pageTitle = Yii::app()->name . ' - Франшиза';
	    $this->render('pages/franchise');
	}

	public function actionPress()
	{
		$this->pageTitle = Yii::app()->name . ' - Пресса о нас';
	    $this->render('press');
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

	public function actionEditmailtpl($success = 1)
	{
		$this->layout='//layouts/admin_column';

		$filename = $success ? 'result_success' : 'result_notqualify';

		$file_tpl = dirname(__FILE__).'/../views/mail/'.$filename.'.php';
		$msg = '';
		if (isset($_POST['tpl'])){
			file_put_contents($file_tpl, $_POST['tpl']);
			$msg = 'Изменения успешно сохранены';
		}

		$mail_tpl = file_get_contents($file_tpl, true);

		$this->render('edit_mail',array(
			'not' => $success ? '' : 'не ',
			'text' => $mail_tpl,
			'msg' => $msg,
		));
	}
}
