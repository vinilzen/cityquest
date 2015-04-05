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
				'actions'=>array('index','view', 'schedule'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete', 'sort', 'adminschedule'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 1",
			),
			array('allow',
				'actions'=>array('adminschedule'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 2",
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
							$model->save();
						}

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
	public function actionView($id)
	{
		$this->layout='//layouts/quest';

		$holidays = Holiday::model()->findAll();
		$holiday_list = array();
		foreach ($holidays as $holiday) {
			array_push($holiday_list, $holiday->holiday_date);
		}

		$quests = Quest::model()->findAll(array(
		    "condition" => "status = 2 AND city_id = ".$this->city,
		    "order" => "status ASC, sort ASC",
		    "limit" => 12,
		));

		$cities = City::model()->findAll();
		$city_array = array();
		foreach ($cities AS $city){
			$city_array[$city->id] = $city;
		}

		$other_quests = array();
		
		foreach ($quests AS $quest){
			if ($quest->id == $id){
				$model = $quest;
			} else {
				$other_quests[$quest->id] = $quest;
			}
		}

		$bookings = array();
		$bookings = Booking::model()->with('competitor')->findAllByAttributes(
			array('quest_id'=>$id),
			'date >= :start_date AND date <= :end_date',
			array(
				'start_date'=> date('Ymd', strtotime('now')),
				'end_date'=> date('Ymd', strtotime('+2 week')),
			));

		$bookings_by_date = array();

		foreach ($bookings as $booking) {
			if (!isset($bookings_by_date[$booking->date]))
				$bookings_by_date[$booking->date] = array();

			$bookings_by_date[$booking->date][$booking->time] = $booking->attributes;
			$bookings_by_date[$booking->date][$booking->time]['name'] = isset($booking->competitor)?$booking->competitor->username:'';
		}

		if (isset($model->times) && is_numeric($model->times) && isset(Yii::app()->params['times'][(int)$model->times]))
			$times = Yii::app()->params['times'][(int)$model->times];
		else 
			$times = Yii::app()->params['times'][1];

		$this->render('view',array(
			'model'=>$model,
			'cities'=>$city_array,
			'booking' => $bookings_by_date,
			'times' => $times,
			'holidays' => $holiday_list,
			'other_quests' => $other_quests
		));
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout='//layouts/admin_column';
		$model= Quest::model()->findByPk($id);

		$bookings = array();
		$bookings = Booking::model()->with('competitor')->findAllByAttributes(
			array('quest_id'=>$id),
			'date >= :start_date AND date <= :end_date',
			array(
				'start_date'=> date('Ymd', strtotime('-1 day')),
				'end_date'=> date('Ymd', strtotime('+13 day')),
			));

		$cities = City::model()->findAllByAttributes( array('active'=>1) );

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

		if(isset($_POST['Quest']))	
		{
			$model->attributes=$_POST['Quest'];

			if (
				isset($_POST['Quest']['city_id']) && 
				City::model()->findByPk($_POST['Quest']['city_id'])
			) {

				$model->city_id = $_POST['Quest']['city_id'];

				$model->image = CUploadedFile::getInstance($model,'image');

				if($model->save()){
					//Если отмечен чекбокс «удалить файл» 
					if($model->del_img)
						if(file_exists('./images/q/'.$id.'.jpg'))
							unlink('./images/q/'.$id.'.jpg');

					//сохранить файл на сервере в каталог /images/q/ под именем {id}.jpg
					if ($model->image) $model->image->saveAs('./images/q/'.$model->id.'.jpg');
				} else {
					throw new CHttpException(500, 'Ошибка сохранения');
				}
			} else {
				throw new CHttpException(500, 'Не найден город квеста!');
			}

			$model= Quest::model()->findByPk($id);
		}


		if (isset($model->times) && is_numeric($model->times) && isset(Yii::app()->params['times'][(int)$model->times]))
			$times = Yii::app()->params['times'][(int)$model->times];
		else 
			$times = Yii::app()->params['times'][1];

		$this->render('update',array(
			'model'=>$model,
			'booking' => $bookings_by_date,
			'times' => $times,
			'cities' => $cities
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

		Yii::beginProfile('quest_index');
		
		$quests = Quest::model()->findAll(array(
		    "condition" => "status > 1 AND city_id = ".$this->city,
		    "order" => "status ASC, sort ASC",
		    "limit" => 12,
		));

		Yii::endProfile('quest_index');

		// foreach ($quests as $key => $value) { echo $value->id.'#'.$value->title.', '.$value->sort.' - '.$value->status.'<br>';	}
        
        $this->layout = '//layouts/index';
		$this->render('index',array(
			'quests'=>$quests,
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

		$twoweek_bookings = Booking::model()->findAllByAttributes(
			array(),
			'date >=:today && date < :twoweek && competitor_id > -1 ',
			array(
				'today'=>date('Ymd', strtotime( '+'.$prev.' day' )),
				'twoweek'=> date('Ymd', strtotime( '+'.$next.' day' ))
			)
		);

		$twoweek_bookings_arr = array();
		if (count($twoweek_bookings)>0){
			foreach ($twoweek_bookings as $booking) {

				if (!isset($twoweek_bookings_arr[$booking->date])){
					$twoweek_bookings_arr[$booking->date] = array();
				}
					$twoweek_bookings_arr[$booking->date][] = $booking;
			}
		}

		// echo '<!--';
			// var_dump($twoweek_bookings_arr[20150409]);
		// echo '-->';

		if(Yii::app()->request->isAjaxRequest){
			echo md5(serialize($twoweek_bookings_arr));
			Yii::app()->end();
		} else {

			$criteria=new CDbCriteria(array(
				'condition'=>"status = 2 && city_id = ".$user_city_id,
				'limit'=>12,
				'order'=>"status ASC, sort ASC"
			));
			
			if (UserModule::isModerator()){

				$moderator_quests = Yii::app()->getModule('user')->user()->quests;

				if ($moderator_quests && $moderator_quests != ''){
					$criteria->addInCondition("id", explode(',', $moderator_quests));
				}
			}

			$users = User::model()->findALL(array("condition"=>"superuser = 0"));

			$quests = Quest::model()->findAll($criteria);
			$quests_array = array();

			if (count($quests)>0){

				$quest_ids = array();

				foreach ($quests AS $quest){
					$quest_ids[] = $quest->id;
					$quests_array[$quest->id] = array();
					$quests_array[$quest->id]['q'] = $quest;
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

				$this->render('adminschedule',array(
					'twoweek_bookings_arr' => $twoweek_bookings_arr,
					'quests' => $quests_array,
					'ymd' => $YMDate,
					'users' => $users,
					'holidays' => $holiday_list,
					'arr_hash' => md5(serialize($twoweek_bookings_arr)),
				));
			} else {
				$this->render('adminschedule',array(
					'twoweek_bookings_arr' => $twoweek_bookings_arr,
					'quests' => array(),
					'ymd' => $YMDate,
					'users' => $users,
					'holidays' => $holiday_list,
					'arr_hash' => md5(serialize($twoweek_bookings_arr)),
				));
			}
		}
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

		$model=new Quest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Quest']))
			$model->attributes=$_GET['Quest'];

		$this->render('admin',array(
			'models'=>Quest::model()->findAll(
						array(
						    // "condition" => "status>1 AND city_id=".(int)$user_city_id,
						    "condition" => "city_id=".(int)$user_city_id,
						    // "order" => "status ASC, sort ASC",
						    "order" => "sort ASC",
						    "limit" => 20,
						)
					),
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
