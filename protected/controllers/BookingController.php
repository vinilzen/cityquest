<?php

class BookingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' actions
				'actions'=>array('create', 'decline'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update', 'confirm'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
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


	/**
	 * Creates a new model.
	 * 
	 */
	public function actionCreate()
	{
		Yii::beginProfile('actionCreate');
		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (!Yii::app()->user->isGuest){

				if (isset($_POST['quest_id']) && is_numeric($_POST['quest_id']) && strlen($_POST['time']) == 5 ){


					Yii::beginProfile('get_quest');
					$quest = Quest::model()->findByPk($_POST['quest_id']);
					Yii::endProfile('get_quest');

					if ($quest) {

						Yii::beginProfile('get_booking');
						$booking = Booking::model()->findByAttributes(
							array('quest_id'=>$quest->id),
							'date =:today AND time =:time',
							array(
								'today'=>(int)$_POST['ymd'],
								'time'=>$_POST['time']
							)
						);
						Yii::endProfile('get_booking');

						if (!$booking) {

							$model=new Booking;

							$model->comment = $_POST['comment'];
							$model->time = $_POST['time'];
							$model->price = (int)$_POST['price'];
							$model->date = (int)$_POST['ymd'];
							$model->phone = $_POST['phone'];
							$model->result = isset($_POST['result'])?$_POST['result']:0;
							$model->name = $_POST['name'];
							$model->quest_id = (int)$_POST['quest_id'];

							$model->competitor_id = (isset($_POST['user']) && $_POST['user'] == -1) ? -1 : (int)Yii::app()->user->id;

							if ( isset($_POST['user']) && $_POST['user'] != -1 && $_POST['user'] != '' && $_POST['user'] != 0 ) {
								
								$user_model = Yii::app()->getModule('user')->user($_POST['user']);

								if($user_model){
									$model->competitor_id = $user_model->id;
								} else {									
									$user_model = Yii::app()->getModule('user')->user();
									$user_model->phone = $_POST['phone'];	
								}
							} else {
								$user_model = Yii::app()->getModule('user')->user();
								$user_model->phone = $_POST['phone'];
							}

							if (isset(Yii::app()->request->cookies['from'])){
								$model->affiliate = Yii::app()->request->cookies['from'];
							}

							if ( $user_model->save() && $model->save() ){
								if (
										!Yii::app()->getModule('user')->user()->superuser > 0
										||
										(isset($user_model) && $model->competitor_id == $user_model->id)

									) {

									$email = Yii::app()->getModule('user')->user()->email;
									if (isset($user_model) && $model->competitor_id == $user_model->id){
										$email = $user_model->email;
									}

									Yii::beginProfile('sendMail-'.Yii::app()->getModule('user')->user()->email);
									$this->sendMail(
										$email, //Cityquest. Бронирование квеста «НАЗВАНИЕ КВЕСТА» ДАТА ВРЕМЯ
										"CityQuest. Бронирование квеста «".$quest->title."» ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." ".$model->time,
										"Здравствуйте, ".Yii::app()->getModule('user')->user()->username."! <br><br>
										
										Вы записались на квест <a href='http://cityquest.ru/quest/view?id=".$quest->id."' target='_blank' >«".$quest->title."»</a> ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." в ".$model->time." <br>
										Не забудьте, для участия вам понадобится команда от 2 до 4 человек.<br><br>

										Мы ждем вас по адресу <a href='https://www.google.com/maps/preview?q=москва,+".urlencode($quest->addres)."' target='_blank'>".$quest->addres.".</a> <br><br>
										Игра начнется, когда вся команда соберется. Мы просим не опаздывать, иначе у вас останется меньше времени на прохождение.<br><br>

										До встречи,<br>
										Команда CityQuest<br>
										<a href='http://cityquest.ru' target='_blank'>www.cityquest.ru</a><br>
										8 (495) 749-96-09");
									Yii::endProfile('sendMail-'.Yii::app()->getModule('user')->user()->email);
								}

								if (!isset($_POST['user']) || (isset($_POST['user']) && $_POST['user'] != -1)){
									
									Yii::beginProfile('sendMail_2');
									$this->sendMail(
										'ilya@cityquest.ru, e.roslovets@cityquest.ru',
										"CityQuest. Бронирование квеста «".$quest->title."» ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." ".$model->time,
										"Здравствуйте, ".Yii::app()->getModule('user')->user()->username."! <br><br>
										
										Вы записались на квест <a href='http://cityquest.ru/quest/view?id=".$quest->id."' target='_blank' >«".$quest->title."»</a> ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." в ".$model->time." <br>
										Не забудьте, для участия вам понадобится команда от 2 до 4 человек.<br><br>

										Мы ждем вас по адресу <a href='https://www.google.com/maps/preview?q=москва,+".urlencode($quest->addres)."' target='_blank'>".$quest->addres.".</a>");

									Yii::endProfile('sendMail_2');
								}
							

								echo CJavaScript::jsonEncode(array(
									'success'=>1,
									'id'=>$model->id,
									'a' => urlencode($quest->addres)
								));

							} else {

								echo CJavaScript::jsonEncode(
									array(
										'success'=>0, 
										'message'=> 'Ошибка сохранения', 
										'errors'=>$model->getErrors()
									)
								);
							}
						} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Квест "'.$quest->title.'" на дату '.$_POST['ymd'].' и время '.$_POST['time'].' уже занят'));
					} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Квест не найден'));
				} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нету доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');

		Yii::endProfile('actionCreate');
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionConfirm()
	{

		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (!Yii::app()->user->isGuest){

				if (isset($_POST['id']) && is_numeric($_POST['id'])){
					$model=$this->loadModel((int)$_POST['id']);
					$model->status = (int)$_POST['confirm'];

					if($model->save())
						echo CJavaScript::jsonEncode(array('success'=>1));
					else
						echo CJavaScript::jsonEncode(
							array(
								'success'=>0, 
								'message'=> 'Ошибка сохранения', 
								'errors'=>$model->getErrors()
							)
						);
				} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нету доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (!Yii::app()->user->isGuest){

				if (isset($_POST['id']) && is_numeric($_POST['id'])){

					$model=$this->loadModel((int)$_POST['id']);
					
					$model->comment = $_POST['comment'];
					$model->time = $_POST['time'];
					$model->price = (int)$_POST['price'];
					$model->date = (int)$_POST['ymd'];
					$model->phone = $_POST['phone'];
					$model->result = $_POST['result'];
					$model->name = $_POST['name'];
					// $model->competitor_id = (int)Yii::app()->user->id;

					if($model->save()){
						//Yii::log(CJSON::encode($model->getAttributes()), 'info', 'bookingController.update');

						echo CJavaScript::jsonEncode(array('success'=>1));
					} else {
						echo CJavaScript::jsonEncode(
							array(
								'success'=>0, 
								'message'=> 'Ошибка сохранения', 
								'errors'=>$model->getErrors()
							)
						);
					}
				} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нет доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');
	}

	/**
	 * Deletes a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{

		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (isset($_POST['id']) && is_numeric($_POST['id'])){

				try {

					$model = $this->loadModel( (int)$_POST['id'] );

					Yii::log(json_encode($model->getAttributes(), JSON_UNESCAPED_UNICODE), 'info', 'bookingController.delete');

					$model->delete();

					echo CJavaScript::jsonEncode(array('success'=>1));

				} catch (Exception $e) {

					echo CJavaScript::jsonEncode(
						array(
							'success'=>0, 
							'message'=> 'Ошибка Удаления', 
							'errors'=>$e->getMessage()
						)
					);

				} 
				
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Бронирование не найдено');
	}

	/**
	 * Decline a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDecline()
	{

		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (isset($_POST['id']) && is_numeric($_POST['id'])){

				try {

					$booking = $this->loadModel( (int)$_POST['id'] );

					if ($booking->competitor_id === Yii::app()->user->id ){
						
						$booking->delete();
						echo CJavaScript::jsonEncode(array('success'=>1));

					} else {
						echo CJavaScript::jsonEncode(
							array(
								'success'=>0, 
								'message'=> 'Ошибка Удаления', 
								'errors'=>$e->getMessage()
							)
						);
					}


				} catch (Exception $e) {

					echo CJavaScript::jsonEncode(
						array(
							'success'=>0, 
							'message'=> 'Ошибка Удаления', 
							'errors'=>$e->getMessage()
						)
					);

				} 
				
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Бронирование не найдено');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Booking');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Booking the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Booking::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Booking $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='booking-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
