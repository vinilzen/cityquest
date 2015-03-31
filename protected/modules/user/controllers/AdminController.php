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
			array('allow',
				'actions'=>array('view'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 2",
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
		$this->user_menu=array();
		$model=new User('search');
		$model->unsetAttributes();

		if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

		$this->render('index',array(
			'model'=>$model
		));
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$quests = array();

		if ($model->superuser == 2 && $model->quests){
			$quests_list = explode(',',$model->quests);
			if ($quests_list && count($quests_list)>0){
				foreach ($quests_list as $key => $value) {
					$quest = Quest::model()->findByPk((int)$value);
					if ($quest){
						$quests[$quest->id] = $quest;
					}
				}
			}
		}

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
			'quests'=>$quests,
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
		
		if(isset($_POST['User'])) {
			$model->attributes=$_POST['User'];
			
			if ($_POST['User']['quests']){
				$model->quests = implode(',', $_POST['User']['quests']);
			} else {
				$model->quests = '';
			}

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

		$quest_titels = array();

		$criteria=new CDbCriteria(array(
			'order'=>"status ASC, sort ASC"
		));

		$cities = City::model()->findAll();

		$quests = Quest::model()->findAll($criteria);
		if ($quests && count($quests)>0){
			foreach ($quests as $q) {
				$status_str = $q->status==1?Yii::t('app','Draft'):$q->status==2?Yii::t('app','Active'):Yii::t('app','In development');
				$quest_titels[$q->id] = $q->title.' ('.$status_str.')';
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'quests'=>$quest_titels,
			'quests_obj'=>$quests,
			'cities'=>$cities,
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