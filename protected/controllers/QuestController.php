<?php

class QuestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $pageImg=NULL;

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
				'actions'=>array('redirect','index','view', 'schedule'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete', 'sort','adminschedule', 'ajaxschedule', 'getavailablequest', 'getseances'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 1",
			),
			array('allow',
				'actions'=>array('adminschedule', 'ajaxschedule', 'getavailablequest', 'getseances'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser > 1",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Sort
	 */
	public function actionSort()
	{

		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (!Yii::app()->user->isGuest){

				if ( isset($_POST['sort']) && count($_POST['sort']) > 0 ) {

					try {

						foreach ($_POST['sort'] as $key => $value) {
							$model=$this->loadModel((int)$key);
							$model->sort = (int)$value;
							echo $model->id.' - '.$value.'<br>';
							if ($model->save()){
								echo 'save'.$model->id.'!';
							} else {
								echo 'BUG '.$model->id.'!';
								var_dump($model->getErrors());
								die;
							}
						}

						die;

						echo CJavaScript::jsonEncode(array('success'=>1));

					} catch (Exception $e) {
						
						echo CJavaScript::jsonEncode(
							array(
								'success'=>0, 
								'message'=> 'Ошибка сохранения', 
								'errors'=>$model->getErrors()
							)
						);
					}

				} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нету доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRedirect($id)
	{
		$quest = Quest::model()->findByPk((int)$id);
		if ($quest && $quest->link != '') {
			$this->redirect(array('view','link'=>$quest->link), true, 301);
		} else {
			$this->actionView((int)$id);
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($link)
	{
		$this->layout='//layouts/quest';
		$start_date = date('Ymd', strtotime('now'));
		$end_date = date('Ymd', strtotime('+2 week'));

		$holidays = Holiday::model()->findAll();
		$holiday_list = array();
		foreach ($holidays as $holiday) {
			array_push($holiday_list, $holiday->holiday_date);
		}

		$quests = Quest::model()->findAll(array(
		    "condition" => "status = 2 AND city_id = ".$this->city,
		    "order" => "sort ASC",
		    "limit" => 200,
		));

		$cities = City::model()->findAll();
		$city_array = array();
		foreach ($cities AS $city){
			$city_array[$city->id] = $city;
		}

		$other_quests = array();
		
		$now = false;
		$next = false;
		$prev = false;
		foreach ($quests AS $quest){

			if ( 
				(is_numeric($link) && ($quest->id != $link))
				|| 
				(!is_numeric($link) && ($quest->link != $link))
			){
				$other_quests[$quest->id] = $quest;
			}
		}
		foreach ($quests AS $quest){
			if ($now){
				$next = $quest;
				break;
			}
			if (
				(is_numeric($link) && ($quest->id == $link))
				|| 
				(!is_numeric($link) && ($quest->link == $link))
			){
				$model = $quest;
				$id = $quest->id;
				$now = true;
			} else {
				$prev = $quest;
			}
		}

		if (!isset($model)) {
			throw new CHttpException(404, 'Квест не найден!');
		}


		$locations_array = array();
		$locations = Location::model()->findAll();
		$location = Location::model()->findByPk($model->location_id);
		
		foreach ($locations as $l) {
			$locations_array[$l->id] = $l;
		}

		if (!$next) {
			reset($quests);
			$next = current($quests);
		}

		if (!$prev) $prev = end($quests);

		$bookings = array();
		$bookings = Booking::model()->with('competitor')->findAllByAttributes(
			array('quest_id'=>$id),
			'date >= :start_date AND date <= :end_date',
			array(
				'start_date'=> $start_date,
				'end_date'=> $end_date,
			));

		$bookings_by_date = array();

		foreach ($bookings as $booking) {
			if (!isset($bookings_by_date[$booking->date]))
				$bookings_by_date[$booking->date] = array();

			$bookings_by_date[$booking->date][$booking->time] = $booking->attributes;
			$bookings_by_date[$booking->date][$booking->time]['name'] = isset($booking->competitor)?$booking->competitor->username:'';
		}

		$bookings_winner = Booking::model()->findAllByAttributes(
			array('quest_id'=>$model->id),
			array(
				'condition'=>'date LIKE :month AND winner_photo != "" AND result != "" AND result != "0"',
				'order'=>'date DESC',
				'params'=>array('month'=>'%201505%')
			)
		);

		$bookings_winner_jun = Booking::model()->findAllByAttributes(
			array('quest_id'=>$model->id),
			array(
				'condition'=>'date LIKE :month AND winner_photo != "" AND result != "" AND result != "0"',
				'order'=>'date DESC',
				'params'=>array('month'=>'%'.(int)date("Ym").'%')
			)
		);
		
		$bookings_winner_array = array();
		$bookings_winner_array_jun = array();

		foreach ($bookings_winner AS $b){
			if (!isset($bookings_winner_array[$b->date])) {
				$bookings_winner_array[$b->date] = array();
			}
			$bookings_winner_array[$b->date][] = $b;
		}
		foreach ($bookings_winner_jun AS $b){
			if (!isset($bookings_winner_array_jun[$b->date])) {
				$bookings_winner_array_jun[$b->date] = array();
			}
			$bookings_winner_array_jun[$b->date][] = $b;
		}

		if ($model->schedule == '') {

			if (isset($model->times) && is_numeric($model->times) && isset(Yii::app()->params['times'][(int)$model->times]))
				$times = Yii::app()->params['times'][(int)$model->times];
			else 
				$times = Yii::app()->params['times'][1];

		} else {

			$times = explode(',', $model->schedule);
			
		}

		$promo_days_array = $this->getPromoDays($model->id, $start_date, $end_date);

		header("Last-Modified: " . gmdate("D, d M Y H:i:s", $model->update_time) . " GMT");
		$this->render('view',array(
			'location'=>$location,
			'locations'=>$locations_array,
			'promo_days'=>$promo_days_array,
			'model'=>$model,
			'cities'=>$city_array,
			'booking' => $bookings_by_date,
			'bookings_winner_array' => $bookings_winner_array,
			'bookings_winner_array_jun' => $bookings_winner_array_jun,
			'times' => $times,
			'holidays' => $holiday_list,
			'other_quests' => $other_quests,
			'prev' => $prev,
			'next' => $next,
		));
	}

	private function getPromoDays($quest_id, $start_date, $end_date)
	{
		$promo_days = PromoDays::model()->findAllByAttributes(
			array('quest_id'=>$quest_id),
			'day >= :start_date AND day <= :end_date',
			array(
				'start_date'=> $start_date,
				'end_date'=> $end_date,
			)
		);
		$promo_days_array = array();
		foreach ($promo_days as $pd) {
			if (!isset($promo_days_array[$pd->day])){
				$promo_days_array[$pd->day] = array();
			}
			$promo_days_array[$pd->day] = $pd;
		}
		return $promo_days_array;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout='//layouts/admin_column';
		$model=new Quest;
		$cities = City::model()->findAllByAttributes( array('active'=>1) );

		if(isset($_POST['Quest']))
		{

			$_POST['Quest']['author_id'] = Yii::app()->user->id;

			// drafts at the end of the list
			if ($_POST['Quest']['status'] == 1){
				$_POST['Quest']['sort'] = 100;
			}
			
			$model->attributes=$_POST['Quest'];

			//var_dump($model->attributes); die;

			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'cities' => $cities
		));
	}

	function updatePhoto($model, $photo_ids) {
 		
 		QuestPhoto::model()->deleteAll("quest_id=:qid", array(":qid" => $model->id));
		
		if ($photo_ids!=''){
			$ids = explode(',', $photo_ids);
			foreach ($ids as $id) {
				$photo_model  = Photo::model()->findByPk($id);
				if ($photo_model) {
					$quest_photo = new QuestPhoto;
					$quest_photo->quest_id = $model->id;
					$quest_photo->photo_id = $id;
					$quest_photo->save(false);
				}
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout='//layouts/admin_column';
		$model = Quest::model()->findByPk($id);
		
		$message_success = '';

		$bookings = array();
		$bookings = Booking::model()->with('competitor')->findAllByAttributes(
			array('quest_id'=>$id),
			'date >= :start_date AND date <= :end_date',
			array(
				'start_date'=> date('Ymd', strtotime('-1 day')),
				'end_date'=> date('Ymd', strtotime('+13 day')),
			));

		$cities = City::model()->findAllByAttributes( array('active'=>1) );
		// Yii::app()->getModule('user')->user()->city_id
		// $locations = Location::model()->findAllByAttributes( array('city_id' =>$this->city_model->id) );
		$locations = Location::model()->findAll();

		$bookings_by_date = array();

		foreach ($bookings as $booking) {
			if (!isset($bookings_by_date[$booking->date]))
				$bookings_by_date[$booking->date] = array();

			$bookings_by_date[$booking->date][$booking->time] = $booking->attributes;
			$bookings_by_date[$booking->date][$booking->time]['name'] = $booking->name != '' ? $booking->name : $booking->competitor->username;
			
			if (isset($booking->competitor->id)){
				$competitor_id = $booking->competitor->id;
			} else {
				$competitor_id = 0;
			}
			$bookings_by_date[$booking->date][$booking->time]['user_id'] = $booking->competitor_id != 1 ? $competitor_id : '';

		}

		if(isset($_POST['photo'])) {
			$this->updatePhoto($model, $_POST['photo']);
		}

		if(isset($_POST['Quest'])) {
			$model->attributes=$_POST['Quest'];

			if (
				isset($_POST['Quest']['location_id']) && 
				Location::model()->findByPk($_POST['Quest']['location_id'])
			) {

				$model->location_id = (int)$_POST['Quest']['location_id'];

				$model->image = CUploadedFile::getInstance($model,'image');
				
				$isValid = true;

				if ($model->validate()) {
					if($model->save()){
						$message_success = 'Изменения успешно сохранены';
						//Если отмечен чекбокс «удалить файл» 
						if($model->del_img)
							if(file_exists('./images/q/'.$id.'.jpg'))
								unlink('./images/q/'.$id.'.jpg');

						//сохранить файл на сервере в каталог /images/q/ под именем {id}.jpg
						if ($model->image)
							$model->image->saveAs('./images/q/'.$model->id.'.jpg');

					} else throw new CHttpException(500, 'Ошибка сохранения');
				} else $isValid = false;
			} else throw new CHttpException(500, 'Не найдена локация квеста!');
			if ($isValid) $model= Quest::model()->findByPk($id);
		}


		if (isset($model->times) && is_numeric($model->times) && isset(Yii::app()->params['times'][(int)$model->times]))
			$times = Yii::app()->params['times'][(int)$model->times];
		else 
			$times = Yii::app()->params['times'][1];

		$this->render('update',array(
			'model'=>$model,
			'booking' => $bookings_by_date,
			'times' => $times,
			'cities' => $cities,
			'locations' => $locations,
			'errors'=>$model->getErrors(),
			'message_success' => $message_success,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if ($_SERVER['REQUEST_URI'] == '/quest/') {
			$this->redirect('/', true, 301);
		}

		Yii::beginProfile('quest_index');
		
		$quests = Quest::model()->findAll(array(
		    "condition" => "status > 1 AND city_id = ".$this->city,
		    "order" => "status ASC, sort ASC",
		    "limit" => 12,
		));

		Yii::endProfile('quest_index');

		$start_date = date('Ymd', strtotime('0 day'));
		$end_date = date('Ymd', strtotime( '+10 day' ));

		$quests_with_promo = array();
		foreach ($quests as $q) {
			$promo_days = $this->getPromoDays($q->id, $start_date, $end_date);
			if (count($promo_days) > 0) $quests_with_promo[] = $q->id;
		}
		// foreach ($quests as $key => $value) { echo $value->id.'#'.$value->title.', '.$value->sort.' - '.$value->status.'<br>';	}
        
        $this->layout = '//layouts/index';
        
        $locations_array = array();
		$locations = Location::model()->findAll();
		foreach ($locations as $location) {
			$locations_array[$location->id] = $location;
		}
		$this->render('index',array(
			'quests'=>$quests,
			'locations'=>$locations_array,
			'quests_with_promo'=>$quests_with_promo,
		));
	}

	/**
	 *  all schedule for models.
	 */
	public function actionAjaxschedule($ymd = '')
	{
		$this->layout='//layouts/admin_column';


		$user_city_id = Yii::app()->getModule('user')->user()->city_id;
		$holidays = Holiday::model()->findAllByAttributes( array('city'=>$user_city_id));
		$holiday_list = array();
		foreach ($holidays as $holiday) {
			array_push($holiday_list, $holiday->holiday_date);
		}
		
		if ($ymd === '' || !is_numeric($ymd) || strlen($ymd) !== 8){
			$YMDate = date('Ymd', strtotime( "now" ));
		} else {
			$YMDate = (int)$ymd;
		}

		$this->render('ajaxschedule', array(
			'ymd' => $YMDate,
			'holidays' => $holiday_list,
			'discounts' => Discounts::model()->findALL(),
			'sources' => Sources::model()->findALL(),
			'payments' => Payments::model()->findALL(),
		));
	}

	/**
	 *  all schedule for models.
	 */
	public function actionAdminschedule($ymd = '')
	{
		$this->layout='//layouts/admin_column';

		$user_city_id = Yii::app()->getModule('user')->user()->city_id;
		
		$holidays = Holiday::model()->findAllByAttributes( array('city'=>$user_city_id));
		$holiday_list = array();
		foreach ($holidays as $holiday) {
			array_push($holiday_list, $holiday->holiday_date);
		}
		
		if ($ymd === '' || !is_numeric($ymd) || strlen($ymd) !== 8){
			$YMDate = date('Ymd', strtotime( "now" ));
		} else {
			$YMDate = (int)$ymd;
		}

		$offset = 30;
		$prev = -1;
		$next = $prev + $offset;

		if (isset($_GET['d'])) {
			$start = (int)$_GET['d'];
			$prev = ((int)$_GET['d']/$offset - 1)*$offset;
			$next = $prev + 2*$offset;
		}

		$start_date = date('Ymd', strtotime( '+'.$prev.' day' ));
		$end_date = date('Ymd', strtotime( '+'.$next.' day' ));

		if(Yii::app()->request->isAjaxRequest){
			echo md5(serialize($twoweek_bookings_arr));
			Yii::app()->end();
		} else {

			/*if (Yii::app()->getModule('user')->user()->superuser > 1){
				$user_city_id = $this->city_model->id;
			}*/
			
			$criteria=new CDbCriteria(array(
				'condition'=>"status = 2 && city_id = ".$user_city_id,
				'limit'=>20,
				'order'=>"status ASC, sort ASC"
			));
			
			if (Yii::app()->getModule('user')->user()->superuser > 1){

				if ( Yii::app()->getModule('user')->user()->superuser == 2 ){

					$moderator_quests = Yii::app()->getModule('user')->user()->quests;

					if ($moderator_quests && $moderator_quests != ''){
						$criteria->addInCondition("id", explode(',', $moderator_quests));
					} else {
						$this->render('adminschedule',array(
							'ymd' => $YMDate,
							'holidays' => $holiday_list,
						));
						Yii::app()->end();
					}
				} else if (Yii::app()->getModule('user')->user()->superuser == 3) {
					if (Yii::app()->getModule('user')->user()->locations != '') {

						$criteria->addInCondition(
							'location_id',explode(',', Yii::app()->getModule('user')->user()->locations)
						);

					} else {

						$this->render('adminschedule',array(
							'ymd' => $YMDate,
							'holidays' => $holiday_list
						));
						Yii::app()->end();
					}
				}
			}

			$users = User::model()->findALL(array("condition"=>"superuser = 0"));
			

			$quests = Quest::model()->findAll($criteria);
			$quests_array = array();
			$quest_ids = array();

			if (count($quests)>0){


				foreach ($quests AS $quest){
					$quest_ids[] = $quest->id;
					$quests_array[$quest->id] = array();
					$quests_array[$quest->id]['q'] = $quest;
					$quests_array[$quest->id]['promo_days'] = $this->getPromoDays($quest->id, $start_date, $end_date);
					$quests_array[$quest->id]['booking'] = array();
				}

				$bookings = Booking::model()->findAllByAttributes(
					array(
						'quest_id' => $quest_ids,
						'date' => $YMDate,
					)
				);

				if (count($bookings)>0){
					foreach ($bookings as $b) {
						$quests_array[$b->quest_id]['bookings'][$b->time] = $b;
					}
				}
			}

			$twoweek_bookings_arr = $this->getTwoWeekBookings($start_date, $end_date, $quest_ids);

			$this->render('adminschedule',array(
				'twoweek_bookings_arr' => $twoweek_bookings_arr,
				'quests' => $quests_array,
				'ymd' => $YMDate,
				'users' => $users,
				'holidays' => $holiday_list,
				'arr_hash' => md5(serialize($twoweek_bookings_arr)),
				'discounts' => Discounts::model()->findALL(),
				'sources' => Sources::model()->findALL(),
				'payments' => Payments::model()->findALL(),
			));
		}
	}

	public function actionGetseances($qid) {
		$this->layout=false;

		$quest = $this->loadModel($qid);

		header('Content-type: application/json');
		echo CJavaScript::jsonEncode(
			array(
				'success'=>1,
				'seances'=> ($quest->schedule == '') ? Yii::app()->params['times'][(int)$quest->times] : explode(',', $quest->schedule) 
			)
		);

        Yii::app()->end();
	}

	public function actionGetavailablequest() {

		$user_city_id = Yii::app()->getModule('user')->user()->city_id;
		$empty = false;

		$criteria=new CDbCriteria(array(
			'condition'=>"status = 2 && city_id = ".$user_city_id,
			'limit'=>20,
			'order'=>"status ASC, sort ASC"
		));

		$user = Yii::app()->getModule('user')->user();
		
		if ( $user->superuser > 1){

			if ( $user->superuser == 2 ){

				$moderator_quests = $user->quests;

				if ($moderator_quests && $moderator_quests != ''){
					$criteria->addInCondition("id", explode(',', $moderator_quests));
					$empty = false;
				} else $empty = true;

			} else if ($user->superuser == 3) {
				if ($user->locations != '') {

					$criteria->addInCondition(
						'location_id',explode(',', $user->locations)
					);

					$empty = false;

				} else $empty = true;
			}

		}

		if (!$empty){
			$quests = Quest::model()->findAll($criteria);
		} else {
			$quests = array();
		}


		$this->layout=false;
		header('Content-type: application/json');
		echo CJavaScript::jsonEncode(
			array(
				'success'=>1,
				'quests'=>$quests
			)
		);

        Yii::app()->end();

	}


	private function getTwoWeekBookings($start_date, $end_date, $quest_ids){

		$criteria=new CDbCriteria(array(
			'condition' => 'date >=:today && date < :twoweek && competitor_id > -1 ',
			'params' => array(
				'today'=>$start_date,
				'twoweek'=> $end_date
			)
		));
		$criteria->addInCondition('quest_id', $quest_ids);

		$twoweek_bookings = Booking::model()->findAll($criteria);

		$twoweek_bookings_arr = array();
		if (count($twoweek_bookings)>0){
			foreach ($twoweek_bookings as $booking) {

				if (!isset($twoweek_bookings_arr[$booking->date])){
					$twoweek_bookings_arr[$booking->date] = array();
				}
				$twoweek_bookings_arr[$booking->date][] = $booking;
			}
		}

		//var_dump($twoweek_bookings_arr[20150523]); die;
		return $twoweek_bookings_arr;
	}

	/**
	 * Lists all schedule for models.
	 */
	public function actionSchedule($ymd = '')
	{

		$this->layout='//layouts/page';

		if ($ymd === '' || !is_numeric($ymd) || strlen($ymd) !== 8)
			$YMDate = date('Ymd', strtotime( "now" ));
		else
			$YMDate = (int)$ymd;

		$quests=Quest::model()->findAllByAttributes(array('status' => 2));
		$quests_array = array();

		if (count($quests)>0){
			$quest_ids = array();
			foreach ($quests AS $quest){
				$quest_ids[] = $quest->id;
				$quests_array[$quest->id] = array();
				$quests_array[$quest->id]['q'] = $quest;
				$quests_array[$quest->id]['booking'] = array();
			}

			$bookings=Booking::model()->findAllByAttributes(
				array(
					'quest_id' => $quest_ids,
					'date' => $YMDate,
				)
			);
			if (count($bookings)>0){
				foreach ($bookings as $b) {
					$quests_array[$b->quest_id]['bookings'][$b->time] = $b;
				}
			}
		}

		$this->render('schedule',array(
			'quests' => $quests_array,
			'ymd' => $YMDate,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($selected_city = 1)
	{
		$this->layout='//layouts/admin_column';

		$user_city_id = Yii::app()->getModule('user')->user()->city_id;

		/*if (Yii::app()->getModule('user')->user()->superuser == 3) {
			if (Yii::app()->getModule('user')->user()->locations != '') {
				$criteria = new CDbCriteria();
				$criteria->addInCondition('location_id',explode(',', Yii::app()->getModule('user')->user()->locations));
				$criteria->order="sort ASC";
			}
		}*/

		$criteria = new CDbCriteria();
		$criteria->condition='city_id='.(int)$user_city_id;
		$criteria->order="sort ASC";

		$model=new Quest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Quest']))
			$model->attributes=$_GET['Quest'];

		$this->render('admin',array(
			'models'=>Quest::model()->findAll($criteria),
			'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Quest the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Quest::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Quest $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='quest-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
