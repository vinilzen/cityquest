<?php

class BookingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $pageImg;

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
				'actions'=>array('index','view', 'get', 'getbyday'),
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('reports', 'upload'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser > 0",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionGet($day,$quest)
	{

		$bookings_arr = array();

		$bookings = Booking::model()->findAllByAttributes(
			array(
				'quest_id'=>$quest,
				'date'=>$day
			)
		);

		foreach ($bookings as $b) {
			$attr = $b->getAttributes();
			if ($b->competitor_id > 0){
				$user = User::model()->findByPk($b->competitor_id);
				/*echo 'b'; var_dump($b);
				echo '<br>u'; var_dump($user);
				echo '<hr>';*/
				$attr['fb_id'] = $user->fb_id;
				$attr['vk_id'] = $user->vk_id;
				$attr['user_id'] = $user->id;
			} else {
				$attr['fb_id'] = 0;
				$attr['vk_id'] = 0;
				$attr['user_id'] = 0;
			}
			$bookings_arr[] = $attr;
		}

		header('Content-type: application/json');
		echo CJavaScript::jsonEncode(
			array(
				'success'=>1,
				'bookings'=>$bookings_arr
			)
		);

        Yii::app()->end();
	}

	public function actionGetByDay($day, $city)
	{
		
		$quests = Quest::model()->findAll(array(
		    "condition" => "status = 2 AND city_id = ".$city,
		    "order" => "sort ASC",
		    "limit" => 200,
		));

		$quests_ids = array();
		foreach ($quests as $q) {
			$quests_ids[] = $q->id;
		}

		$criteria=new CDbCriteria(array(
			'condition'=>"date = ".$day." && name != 'CQ'"
		));

	    $criteria->addInCondition("quest_id", $quests_ids);
		$bookings = Booking::model()->findAll($criteria);

		header('Content-type: application/json');
		echo CJavaScript::jsonEncode(
			array(
				'success'=>1,
				'bookings'=>$bookings,
				'quests'=>$quests
			)
		);

        Yii::app()->end();
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$quest = Quest::model()->findByPk($model->quest_id);

		$quests = Quest::model()->findAll(array(
		    "condition" => "status = 2 AND city_id = ".$this->city." AND id !=".$model->quest_id,
		    "order" => "sort ASC",
		    "limit" => 10,
		));

		$this->render('view',array(
			'model'=>$model,
			'quest'=>$quest,
			'quests'=>$quests,
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

	public function actionReports() {
		$this->layout='//layouts/admin_column';
	
		$user_city_id = Yii::app()->getModule('user')->user()->city_id;

		$criteria=new CDbCriteria(array(
			'condition'=>"status = 2 && city_id = ".$user_city_id,
			'limit'=>50,
			'order'=>"sort ASC",
		));

		if (UserModule::isModerator()){

			$moderator_quests = Yii::app()->getModule('user')->user()->quests;
			$moderator_quests_array = explode(',', $moderator_quests);

			if ($moderator_quests && $moderator_quests != ''){
				$criteria->addInCondition("id", $moderator_quests_array);
			} else {
				$this->render('reports',array(
					'quests' => array(),
				));
				die;
			}
		}

		$available_quests = $quests = Quest::model()->findAll($criteria);

		$from = isset($_POST['from'])? $_POST['from'] : '';
		$to = isset($_POST['to'])? $_POST['to'] : '';
		$message = '';

		if ( isset($_POST['quest']) && isset($_POST['from']) && $_POST['from']!='' && isset($_POST['to']) && $_POST['to']!='' ) {


			$quest_ids = array_keys($_POST['quest']);
			$criteria->addInCondition("id", $quest_ids);
			$quests = Quest::model()->findAll($criteria);

			$discounts = Discounts::model()->findALL();
			$discounts_array = array();
			foreach ($discounts as $d) $discounts_array[$d->id] = $d->name;

			$sources = Sources::model()->findALL();
			$sources_array = array();
			foreach ($sources as $s) $sources_array[$s->id] = $s->name;

			$payments = Payments::model()->findALL();
			$payments_array = array();
			foreach ($payments as $p) $payments_array[$p->id] = $p->name;


			/* INIT PHPEXCEL */
				$phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.vendor');
			    Yii::import('ext.phpexcel.vendor');
			    require_once $phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php';
			    require_once $phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel' . DIRECTORY_SEPARATOR . 'Shared' . DIRECTORY_SEPARATOR . 'String.php';
			    require_once $phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel' . DIRECTORY_SEPARATOR . 'Autoloader.php';
			    Yii::registerAutoloader(array('PHPExcel_Autoloader','Load'), true);    
				$phpExcel = new PHPExcel();
			/* INIT PHPEXCEL */


			/* Set properties */
				$phpExcel->getProperties()->setCreator("Auto reports generator")
					->setLastModifiedBy("Auto reports generator")
					->setTitle("Xlsx Reports Document ". $from . "-" . $to)
					->setDescription("Reports, generated using PHP classes.")
					->setCategory("Reports");
			/* Set properties */

			$from_array = explode('/', $from);
			$to_array = explode('/', $to);

			$ActiveSheetIndex = 0;
			foreach ($quests as $quest) {

				$phpExcel->createSheet(NULL, $ActiveSheetIndex);
				$phpExcel->setActiveSheetIndex($ActiveSheetIndex)
							->setTitle($quest->title);

				// Add column head
				$phpExcel->getActiveSheet()
					->setCellValue('A1', 'Дата')
					->setCellValue('B1', 'Время')
					->setCellValue('C1', 'Цена')
					->setCellValue('D1', 'Тип платежа')
					->setCellValue('E1', 'Причина скидки')
					->setCellValue('F1', 'Откуда узнали')
					->setCellValue('G1', 'Комментарий')
					->setCellValue('H1', 'Не пришли')
					->setCellValue('I1', 'Суммарное кол-во броней за день')
					->setCellValue('J1', 'Cуммарное кол-во сеансов')

					->setCellValue('K1', 'Другое')
					->setCellValue('L1', 'Касса')
					->setCellValue('M1', 'Счет')

					->setCellValue('N1', 'Cумма выручки');

				$bookings = array();
				$bookings = Booking::model()->findAllByAttributes(
					array(
						'quest_id'=>$quest->id
					),
					'date >= :start_date AND date <= :end_date && name!="CQ"',
					array(
						'start_date'=> $from_array[2].$from_array[0].$from_array[1],
						'end_date'=> $to_array[2].$to_array[0].$to_array[1],
					));

				$bookings_by_date = array();

				foreach ($bookings as $booking) {
					if (!isset($bookings_by_date[$booking->date]))
						$bookings_by_date[$booking->date] = array();

					$bookings_by_date[$booking->date][$booking->time] = $booking->attributes;
				}

				ksort($bookings_by_date);

				foreach ($bookings_by_date as $date_key => $times) {
					ksort($times);
					$bookings_by_date[$date_key] = $times;
				}

				$line_number = 2;
				foreach ($bookings_by_date as $date_key =>$times_array) {
					$start_line = $line_number;
					$count_seans = 0;
					$sum_price = 0;

					$sum_other = 0;
					$sum_account = 0;
					$sum_kassa = 0;

					foreach ($times_array as $time_key => $booking) {
						if ($booking['result']!='' && $booking['result']!='0' && $booking['result']!=0) {
							$count_seans++;
							$sum_price += (int)$booking['price'];

							if ($booking['payment'] == 1) {
								$sum_kassa += (int)$booking['price'];
							} elseif ($booking['payment'] == 2) {
								$sum_account += (int)$booking['price'];
							} else {
								$sum_other += (int)$booking['price'];
							}
						}

						$month = substr($date_key, 4,2);
						$day = substr($date_key, 6,2);
						$year = substr($date_key, 0,4);

						$phpExcel->getActiveSheet()
							->setCellValue('A'.$line_number, $year.'-'.$month.'-'.$day)
							->setCellValue('B'.$line_number, $time_key)
							->setCellValue('C'.$line_number, $booking['price'])
							->setCellValue('D'.$line_number, $booking['payment'] ? $payments_array[$booking['payment']] : '-')
							->setCellValue('E'.$line_number, (isset($discounts_array[$booking['discount']]) && $booking['discount']) ? $discounts_array[$booking['discount']] : '-')
							->setCellValue('F'.$line_number, ($booking['source'] && isset($sources_array[$booking['source']])) ? $sources_array[$booking['source']] : '-')
							->setCellValue('G'.$line_number, $booking['comment'])
							->setCellValue('H'.$line_number, ($booking['result']!='' && $booking['result']!='0') ? 'Пришли' : 'Не пришли' )
							->setCellValue('I'.$line_number, count($times_array));

						$line_number++;
					}

					$end_line = $line_number - 1;
					$phpExcel->getActiveSheet()
						 ->setCellValue('J'.$start_line, $count_seans)
						 ->setCellValue('K'.$start_line, $sum_other)
						 ->setCellValue('L'.$start_line, $sum_kassa)
						 ->setCellValue('M'.$start_line, $sum_account)
						 ->setCellValue('N'.$start_line, $sum_price)
						->mergeCells('A'.$start_line.':A'.$end_line)
						->mergeCells('I'.$start_line.':I'.$end_line)
						->mergeCells('J'.$start_line.':J'.$end_line)
						->mergeCells('K'.$start_line.':K'.$end_line)
						->mergeCells('L'.$start_line.':L'.$end_line)
						->mergeCells('M'.$start_line.':M'.$end_line)
						->mergeCells('N'.$start_line.':N'.$end_line);
 				}
 				$ActiveSheetIndex ++;
			}

			$file_name = 'reports'.date('Y_m_d_H_i_s').'.xlsx';


			// Save Excel 2007 file
			$message = date('H:i:s') . "  Записть в файл формата Excel2007 <br>";
			$objWriter = new PHPExcel_Writer_Excel2007($phpExcel);
			$objWriter->save('./'.$file_name);

			$message .= date('H:i:s') . ' Отчет сохранен. Скачать можно <a target="_blank" href="/'.$file_name.'">тут</a>';
		}

		$this->render('reports',array(
			'quests' => $available_quests,
			'from' => $from,
			'to' => $to,
			'message' => $message,
		));
	}


	/**
	 * Creates a new model.
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

						if (!$booking || ($booking && $booking->name == 'CQ' && $booking->competitor_id == -1)) {

							if ($booking && $booking->name == 'CQ' && $booking->competitor_id == -1) {
								$booking->delete();
							}

							$model=new Booking;

							$model->comment = $_POST['comment'];
							$model->time = $_POST['time'];
							$model->price = (int)$_POST['price'];
							$model->date = (int)$_POST['ymd'];
							$model->phone = $_POST['phone'];
							$model->result = isset($_POST['result'])?$_POST['result']:0;
							$model->name = $_POST['name'];
							$model->quest_id = (int)$_POST['quest_id'];

							$model->payment = isset($_POST['payment']) ? $_POST['payment'] : 0;
							$model->source = isset($_POST['source']) ? $_POST['source'] : 0;
							$model->discount = isset($_POST['discount']) ? $_POST['discount'] : 0;

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

								if ( isset($_POST['user']) && $_POST['user'] == 0 ) {
									$model->competitor_id = 0;
								} 
							}

							$count_bs = 0;
							if ($model->competitor_id > 0) {
								$bs = Booking::model()->findAllByAttributes(
									array('competitor_id'=>$model->competitor_id),
									'status =:status',
									array(
										'status'=>0,
									)
								);

								$count_bs = count($bs);
							}

							if (isset(Yii::app()->request->cookies['from'])){
								$model->affiliate = Yii::app()->request->cookies['from'];
							}
							if (isset(Yii::app()->request->cookies['admitad_uid'])){
								$model->affiliate = Yii::app()->request->cookies['admitad_uid'];
							}

							if ( $count_bs < 5 ) {
								if ( $user_model->save() && $model->save() ){

									$location_model = Location::model()->findByPk($quest->location_id);
									$addr = $location_model->address;
									$addr_additional = $location_model->address_additional;
									$city_model = City::model()->findByPk($location_model->city_id);
									$city_name = $city_model->name;

									$subdomain = '';
									$domain = 'ru';
									if ($city_model->subdomain != '' ){
										$subdomain = $city_model->subdomain.'.';
									}
									if ($city_model->id == 2){
										$domain = 'kz';
									}


									$link = "http://".$subdomain."cityquest.".$domain."/quest/".$quest->link;

									if ( !Yii::app()->getModule('user')->user()->superuser > 0) {
										$email = Yii::app()->getModule('user')->user()->email;

										$this->sendMail(
											$email,
											"CityQuest. Бронирование квеста «".$quest->title."» ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." ".$model->time,
											"Здравствуйте, ".Yii::app()->getModule('user')->user()->username."! <br><br>
											
											Вы записались на квест <a href='".$link."' target='_blank' >«".$quest->title."»</a> ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." в ".$model->time." <br>
											Не забудьте, для участия вам понадобится команда от 2 до 4 человек.<br><br>

											Мы ждем вас по адресу <a href='https://www.google.com/maps/preview?q=".$city_name.",+".urlencode($addr)."' target='_blank'>".$addr.".</a><br>"
											.$addr_additional."<br><br>".
											"Игра начнется, когда вся команда соберется. Мы просим не опаздывать, иначе у вас останется меньше времени на прохождение.<br><br>

											До встречи,<br>
											Команда CityQuest<br>
											<a href='http://cityquest.ru' target='_blank'>www.cityquest.ru</a><br>
											8 (495) 749-96-09");
									}

									if (isset($user_model) && $model->competitor_id == $user_model->id && isset($_POST['user']) && $_POST['user'] != -1) {
										$email = $user_model->email;

										$this->sendMail(
											$email,
											"CityQuest. Бронирование квеста «".$quest->title."» ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." ".$model->time,
											"Здравствуйте, ".Yii::app()->getModule('user')->user()->username."! <br><br>
											
											Вы записались на квест <a href='".$link."' target='_blank' >«".$quest->title."»</a> ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." в ".$model->time." <br>
											Не забудьте, для участия вам понадобится команда от 2 до 4 человек.<br><br>

											Мы ждем вас по адресу <a href='https://www.google.com/maps/preview?q=".$city_name.",+".urlencode($addr)."' target='_blank'>".$addr.".</a><br>
											".$addr_additional."<br><br>
											Игра начнется, когда вся команда соберется. Мы просим не опаздывать, иначе у вас останется меньше времени на прохождение.<br><br>

											До встречи,<br>
											Команда CityQuest<br>
											<a href='http://cityquest.ru' target='_blank'>www.cityquest.ru</a><br>
											8 (495) 749-96-09");
									}

									if (!isset($_POST['user']) || (isset($_POST['user']) && $_POST['user'] != -1)){
										


										$notification_mails = explode(',', $this->city_model->booking_alert_mail);

										$locations = Location::model()->findAll();
										if ($locations && count($locations)>0){
											foreach ($locations as $l){
												if ($l->id == $quest->location_id) {
													$notification_mails = array_merge($notification_mails, explode(',',$l->notification_email));					
												}
											}
										}
										if ($quest->mail_for_notifications!='') {
											$notification_mails = array_merge($notification_mails, explode(',',$quest->mail_for_notifications));
										}
										
										$emails = array_unique($notification_mails, SORT_STRING);

										$this->sendMail(
											implode(', ',$emails), 
											"CityQuest. Бронирование квеста «".$quest->title."» ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." ".$model->time,
											"Здравствуйте, ".Yii::app()->getModule('user')->user()->username."! <br><br>
											
											Вы записались на квест <a href='".$link."' target='_blank' >«".$quest->title."»</a> ".substr($model->date, -2, 2)."/".substr($model->date, -4, 2)."/".substr($model->date, 0, 4)." в ".$model->time." <br>
											Не забудьте, для участия вам понадобится команда от 2 до 4 человек.<br><br>

											Мы ждем вас по адресу <a href='https://www.google.com/maps/preview?q=".$city_name.",+".urlencode($addr)."' target='_blank'>".$addr.".</a><br>"
											.$quest->addres_additional
										);
									}
								

									echo CJavaScript::jsonEncode(array(
										'success'=>1,
										'id'=>$model->id,
										'price'=>$model->price,
										'client_id'=>$model->competitor_id,
										'uid'=> (string)Yii::app()->request->cookies['admitad_uid'],
										'a' => urlencode($quest->addres),
										'count'=>$count_bs,
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
							} else {

								echo CJavaScript::jsonEncode(
									array(
										'success'=>0, 
										'message'=> 'Вы превысили лимит бронирований',
										'limit'=>1
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

					$model->payment = isset($_POST['payment']) ? $_POST['payment'] : 0;
					$model->source = isset($_POST['source']) ? $_POST['source'] : 0;
					$model->discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
					// var_dump($model->getAttributes());

					if($model->save()){
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

	public function actionUpload($id)
	{

		$model=$this->loadModel($id);
		$sizeLimit = 5120000;
		$uploadDir = './images/winner_photo/';
		$allowedExtensions = array('jpg','jpeg');
 
        if($model)
        {

			if (isset($_SERVER['HTTP_X_FILE_NAME']) || isset($_GET[$this->uploadName])) {

				$isXhr = true;
				$fileName = isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $_GET[$this->uploadName];
				
				if (isset($_SERVER['CONTENT_LENGTH']))
					$fileSize = (int)$_SERVER['CONTENT_LENGTH'];
				else throw new Exception('Content length is empty.');

			}


			if (isset($fileName)) {
				$pathinfo = pathinfo($fileName);
				if (array_key_exists('extension', $pathinfo) && array_key_exists('filename', $pathinfo))
				{
					$fileExtension = strtolower($pathinfo['extension']);
					$fileNameWithoutExt = $pathinfo['filename'];
				}

				$fileName = str_replace(array('/','\\'),'_',$fileName);
			} else {
				throw new CHttpException(404, 'Incorrect upload name or no file uploaded');
				Yii::app()->end();
        	}

			if ($fileSize == 0) {
				throw new CHttpException(404, 'File is empty');
				Yii::app()->end();
			}

			if ($fileSize > $sizeLimit) {
				throw new CHttpException(404, 'File size exceeds limit');
				Yii::app()->end();
			}


	        $uploadDir = $this->fixDir($uploadDir);
	        if (!is_writable($uploadDir)) {
	        	echo $uploadDir."\r\n"; die;
	            throw new CHttpException(404, 'Upload directory is not writable');
	            Yii::app()->end();
	        }

	        if (!empty($allowedExtensions)) {
	            if (!$this->checkExtension($fileExtension, $allowedExtensions)) {
	                throw new CHttpException(404, 'Invalid file type');
	                Yii::app()->end();
	            }
	        }
	        $newFileName = $id .'.jpg';
	        $savedFile = $uploadDir . $newFileName;


	        if (!$this->save($savedFile)) {
	            throw new CHttpException(404, 'File could not be saved');
	            Yii::app()->end();
	        }

	        $model->winner_photo = $newFileName;
	        $model->save();

	        $watemark = new \Imagick(realpath('./images/logo_text75_sm.png'));
	        $imagick = new \Imagick(realpath($savedFile));
	        $imagick->resizeImage(1000, 1000, null, 1, TRUE);
	        $imagick->compositeImage($watemark,imagick::COMPOSITE_OVER, 20, 20);
	        $imagick->setImageCompressionQuality(80); 
	        $imagick->writeImage($savedFile);

	        echo CJavaScript::jsonEncode(
	        	array(
	        		'success'=>1,
	        		'file'=> $newFileName,
	        	)
	        );


        } else throw new CHttpException(404, 'Страница не найдена');

        Yii::app()->end();
	}

	private function checkExtension($ext, $allowedExtensions) {
        if (!is_array($allowedExtensions))
            return false;
        if (!in_array(strtolower($ext), array_map('strtolower', $allowedExtensions)))
            return false;
        return true;
    }
    
    private function fixDir($dir) {
        if (empty($dir))
            return $dir;
        $slash = DIRECTORY_SEPARATOR;
        $dir = str_replace('/', $slash, $dir);
        $dir = str_replace('\\', $slash, $dir);
        return substr($dir, -1) == $slash ? $dir : $dir . $slash;
    }

    private function errorCodeToMsg($code) {
        switch($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = 'File size exceeds limit.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'File upload stopped by extension.';
                break;
            default:
                $message = 'Unknown upload error.';
                break;
        }
        return $message;
    }

    private function save($path) {
        if (false !== file_put_contents($path, fopen('php://input', 'r')))
            return true;
        return false;
    }

/*    private function setErrorMsg($msg)
    {
        if (empty($errorMsg))
    }*/
}
