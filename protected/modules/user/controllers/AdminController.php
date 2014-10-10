<?php

class AdminController extends Controller
{
    public $layout = "//layouts/admin";
	public $defaultAction = 'admin';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view'),
				'expression'=> "(Yii::app()->getModule('user')->user()->superuser == 1)",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->user_menu=array(
				array('label'=>'Управление пользователями', 'url'=>array('/user/admin'), 'active' => true),
				array('label'=>'Добавить пользователя', 'url'=>array('/user/admin/create')),
			);

		$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();

		$bookings = Booking::model()->with('quest')->findAllByAttributes(
			array('competitor_id'=>$model->id),
			'date >:today OR (date = :today AND time >:time) ',
			array(
				'today'=>date('Ymd'),
				'time'=>date('H:i'),
			)
		);
		
		$bookings_old = Booking::model()->with('quest')->findAllByAttributes(
			array('competitor_id'=>$model->id),
			'date < :today OR (date = :today AND time < :time) ',
			array(
				'today'=>date('Ymd'),
				'time'=>date('H:i'),
			)
		);

		$this->render('view',array(
			'model'=>$model,
			'bookings'=>$bookings,
			'bookings_old'=>$bookings_old,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$model->createtime=time();
			$model->lastvisit=time();
			if( $model->validate() ) {
				
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				$model->save();

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();


		$old_password = User::model()->notsafe()->findByPk($model->id);
		
		// echo '<pre>'; var_dump($old_password->password); echo '</pre>'; die;

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if($model->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);


				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$model->delete();
			$this->redirect(array('/user/admin'));
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
}