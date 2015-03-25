<?php

class LoginController extends Controller
{
    public $layout = "//layouts/main";
	public $defaultAction = 'login';
    const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';
    
    /**
     * Instance curl.
     * @var resourse
     */
    private $ch;

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

						$user=User::model()->findByAttributes(array('email'=>$model->username));

						$this->lastViset();

						echo CJSON::encode(array(
			        			'success' => 1,
			        			'error' => 0,
			        			'admin' => (int)$user->superuser,
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
			if (Yii::app()->user->isGuest) {
				$this->pageTitle = Yii::app()->name . ' - Авторизация';
				$model=new UserLogin;
			    $this->render('/user/login',array(
			    		'model'=>$model
			    	));
			} else {
				$this->redirect('/');
			}
		}
	}

	/**
	 *   Get user data 
	 */
	public function actionFbauth()
	{
		if (Yii::app()->user->isGuest) {
			if ($_POST['email']){
				$user = $this->getUserByEmail($_POST['email']);
				if ($user){
					Yii::log('The model exist, try connect by Email. '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
					$user->fb_id=$_POST['id'];
					$user->fb_link=$_POST['link'];
					if ($user->save()){
						Yii::log('User exist, and connected by Email. '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
						$this->fb_authenticate($user->email);
					}
				} else {
					Yii::log('user does not exist, we will create a new. '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
					$user = new User;
					//$user->access_token=$_POST['access_token'];
					$user->fb_id=$_POST['fb_id'];
					$user->fb_link=$_POST['link'];
					$user->expires_in = time();// + $_POST['expires_in'];
					$user->createtime=time();
					$user->lastvisit=time();
					$user->email=$_POST['email'];
					$user->phone= '00000';
					$user->status= 1;
					$user->username = $_POST['name'];

					if ($user->validate() && $user->save() ){
						Yii::log('User model is Valid. '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
						$this->fb_authenticate($user->email);
					} else {
						Yii::log('User model is not valid. '.json_encode($user->getAttributes()).' '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
						// var_dump($user->attributes);
						// var_dump($user->getErrors());
						echo 'error'; die;
					}
				}
			} else {
				Yii::log('The model does not contain email. '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
				echo 'error'; die;
			}
		} else {

			Yii::log('User does not Guest. '.Yii::app()->request->requestUri, 'info', 'registration.actionfbauth');
        
			echo CJSON::encode(array(
					'success' => 1,
					'auth' => 1,
					'isGuest' => 0,
					'msg' => 'Вы уже авторизованы!'
				));
			Yii::app()->end();
		}
	}
	/**
	 *   Get user data 
	 */
	public function actionVkauth()
	{
		if (Yii::app()->user->isGuest) {
			$parameters = array(
	            'client_id'     => Yii::app()->params['vk']['appId'],
	            'client_secret' => Yii::app()->params['vk']['secret'],
	            'code'          => $_GET['code'],
	            'redirect_uri'  => 'http://'.$_SERVER['SERVER_NAME'].'/user/login/vkauth'
	        ); 

			//var_dump($parameters); var_dump($url); die;
    		
    		$this->ch = curl_init();
	        $url = $this->getUrl(self::ACCESS_TOKEN_URL, $parameters);


			$rs = json_decode($this->request($url), true);

			if (isset($rs['error'])) {
	            throw new Exception($rs['error'].(!isset($rs['error_description']) ?: ': ' . $rs['error_description']));
	        } else {
	            
	            if (isset($rs['email'])){
	            	$user = $this->getUserByEmail($rs['email']);
	            	if ($user){
	            		$user->vk_id=$rs['user_id'];
	            		$user->save();
	            		$this->vk_authenticate($user->email);
	            	} else {
	            		$api_url = 'https://api.vk.com/method/users.get?user_id='.
	            			$rs['user_id'].'&v=5.27&access_token='.
	            			$rs['access_token'];

	            		$user_info = json_decode($this->request($api_url), true);

						$user = new User;
						$user->access_token=$rs['access_token'];
						$user->vk_id=$rs['user_id'];
						$user->expires_in = time() + $rs['expires_in'];
						$user->createtime=time();
						$user->lastvisit=time();
						$user->email=$rs['email'];
						$user->phone= '00000';
						$user->status= 1;
						$user->username =	$user_info['response'][0]['first_name'].' '.
											$user_info['response'][0]['last_name'];

						if ($user->validate() && $user->save() ){
							$this->vk_authenticate($user->email);
						} else {
							var_dump($user->attributes);
							var_dump($user->getErrors());
							echo 'error';
						}
	            	}
	            }
	        }

	    } else {
			echo CJSON::encode(array(
					'success' => 0,
					'error' => 1,
					'msg' => 'Вы уже авторизованы!'
				));
			Yii::app()->end();
	    }
	}

	private function regVkUser(){
		
	}
    
    /**
     * Concatinate keys and values to url format and return url.
     * @param   string  $url
     * @param   array   $parameters
     * @return  string
     */
    private function getUrl($url, $parameters){
        $piece = array();
        foreach ($parameters as $key => $value)
            $piece[] = $key . '=' . rawurlencode($value);
        
        $url .= '?' . implode('&', $piece);
        return $url;
    }

    /**
     * Executes request on link.
     * @param   string  $url
     * @param   string  $method
     * @param   array   $postfields
     * @return  string
     */
    private function request($url, $method = 'GET', $postfields = array()){
        curl_setopt_array($this->ch, array(
            CURLOPT_USERAGENT       => 'CityQuest App (V0.1)',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_POST            => ($method == 'POST'),
            CURLOPT_POSTFIELDS      => $postfields,
            CURLOPT_URL             => $url
        ));
        
        return curl_exec($this->ch);
    }


	public function actionEmail(){
		var_dump($this->getUserByEmail($_GET['email']));
		die;
	}

	public function getUserByEmail($email = '') {

		$validator = new CEmailValidator;

		if ($email!='' && $validator->validateValue($email))
			return User::model()->active()->findByAttributes(array('email'=>$email));
		else 
			return false;
	}

	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}


	/**
	 * Authenticates the vk.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function vk_authenticate($email)
	{
		$identity=new UserSocIdentity($email,'vk');
		$identity->authenticate();
		switch($identity->errorCode)
		{
			case UserIdentity::ERROR_NONE:
				$duration = 3600*24*30*12;
				Yii::app()->user->login($identity,$duration);
				if (Yii::app()->request->isAjaxRequest){
					echo CJSON::encode(array(
						'success' => 1,
						'auth' => 1,
						'msg' => 'Вы уже авторизованы!'
					));
					Yii::app()->end();
				} else {
					Yii::log('This is not the Ajax request. '.Yii::app()->request->requestUri, 'info', 'registration.vk_authenticate');
					$this->redirect('/');
				} 
				break;
			default:
				var_dump(UserIdentity::errorCode);
		}
	}

	/**
	 * Authenticates the FB
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function fb_authenticate($email)
	{
		$identity=new UserSocIdentity($email,'fb');
		$identity->authenticate();
		switch($identity->errorCode)
		{
			case UserIdentity::ERROR_NONE:
				$duration = 3600*24*30*12;
				Yii::app()->user->login($identity,$duration);
				if (Yii::app()->request->isAjaxRequest) {
					echo CJSON::encode(array(
						'success' => 1,
						'auth' => 1,
						'fb_authenticate' => 1,
						'msg' => 'Вы уже авторизованы!'
					));
					Yii::app()->end();
				} else {
					Yii::log('This is not the Ajax request. '.Yii::app()->request->requestUri, 'info', 'registration.fb_authenticate');
					$this->redirect('/');
				}
				break;
			default:
				var_dump(UserIdentity::errorCode);
		}
	}
}