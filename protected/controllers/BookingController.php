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
				'actions'=>array('create'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update', 'confirm'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (!Yii::app()->user->isGuest){

				if (isset($_POST['quest_id']) && is_numeric($_POST['quest_id'])){
					$quest = Quest::model()->findByPk($_POST['quest_id']);

					if ($quest) {
						$model=new Booking;

						// Uncomment the following line if AJAX validation is needed
						// $this->performAjaxValidation($model);

						$model->comment = $_POST['comment'];
						$model->time = $_POST['time'];
						$model->price = (int)$_POST['price'];
						$model->date = (int)$_POST['ymd'];
						$model->phone = $_POST['phone'];
						$model->name = $_POST['name'];
						$model->quest_id = (int)$_POST['quest_id'];
						$model->competitor_id = (int)Yii::app()->user->id;

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
					} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Квест не найден'));
				} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нету доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');
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
					$model->name = $_POST['name'];
					$model->competitor_id = (int)Yii::app()->user->id;

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
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нет доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{

		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			if (!Yii::app()->user->isGuest){

				if (isset($_POST['id']) && is_numeric($_POST['id'])){

					try {

						$this->loadModel((int)$_POST['id'])->delete();
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
			} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'У вас нет доступа'));

           	Yii::app()->end();

		} else throw new CHttpException(404, 'Страница не найдена');

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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Booking('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Booking']))
			$model->attributes=$_GET['Booking'];

		$this->render('admin',array(
			'model'=>$model,
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
