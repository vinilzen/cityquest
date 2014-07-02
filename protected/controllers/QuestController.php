<?php

class QuestController extends Controller
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
		// return array('rights',);
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
				'actions'=>array('create','update','admin','delete'),
				'users'=>array('admin'),
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
		$model=$this->loadModel($id);

		$bookings = array();
		$bookings = Booking::model()->with('competitor')->findAllByAttributes(
			array('quest_id'=>$id),
			'date >= :start_date AND date <= :end_date',
			array(
				'start_date'=> date('Ymd', strtotime('now')),
				'end_date'=> date('Ymd', strtotime('+1 week')),
			));


		$bookings_by_date = array();

		foreach ($bookings as $booking) {
			if (!isset($bookings_by_date[$booking->date]))
				$bookings_by_date[$booking->date] = array();

			$bookings_by_date[$booking->date][$booking->time] = $booking->attributes;
			$bookings_by_date[$booking->date][$booking->time]['name'] = $booking->competitor->username;

		}

		// echo '<pre>'; print_r($bookings_by_date); die;

		$this->render('view',array(
			'model'=>$model,
			'booking' => $bookings_by_date,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Quest;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Quest']))
		{

			// var_dump(Yii::app()->user->id); die;

			$_POST['Quest']['author_id'] = Yii::app()->user->id;
			$model->attributes=$_POST['Quest'];
			// $model->attributes->;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$bookings = array();
		$bookings = Booking::model()->with('competitor')->findAllByAttributes(
			array('quest_id'=>$id),
			'date >= :start_date AND date <= :end_date',
			array(
				'start_date'=> date('Ymd', strtotime('now')),
				'end_date'=> date('Ymd', strtotime('+1 week')),
			));


		$bookings_by_date = array();

		foreach ($bookings as $booking) {
			if (!isset($bookings_by_date[$booking->date]))
				$bookings_by_date[$booking->date] = array();

			$bookings_by_date[$booking->date][$booking->time] = $booking->attributes;
			$bookings_by_date[$booking->date][$booking->time]['name'] = $booking->competitor->username;

		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Quest']))	
		{
			$model->attributes=$_POST['Quest'];

			$model->image = CUploadedFile::getInstance($model,'image');

			if($model->save()){

				//Если отмечен чекбокс «удалить файл» 
				if($model->del_img)
					if(file_exists('./images/q/'.$id.'.jpg'))
						unlink('./images/q/'.$id.'.jpg');

				
				//сохранить файл на сервере в каталог /images/q/ под именем {id}.jpg
				if ($model->image)
					$model->image->saveAs('./images/q/'.$model->id.'.jpg');

				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'booking' => $bookings_by_date,
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
		$dataProvider=new CActiveDataProvider('Quest', array(
    		'criteria'=>array(
        		'condition'=>'status=2',
        		'order'=>'sort DESC',
        		'limit'=>20,
        	)
        ));

		$dataProviderSoon=new CActiveDataProvider('Quest', array(
    		'criteria'=>array(
        		'condition'=>'status=3',
        		'order'=>'sort DESC',
        		'limit'=>20,
        	)
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'dataProviderSoon'=>$dataProviderSoon,
		));
	}


	/**
	 * Lists all schedule for models.
	 */
	public function actionSchedule($ymd = '')
	{

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
	public function actionAdmin()
	{
		$model=new Quest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Quest']))
			$model->attributes=$_GET['Quest'];

		$this->render('admin',array(
			'model'=>$model,
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
