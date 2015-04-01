<?php

class UserController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public $layout = '//layouts/main';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('list', 'export', 'exportlab'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 1",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
	
		$this->layout = "//layouts/admin";
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		// var_dump($this->layout); die;
		$this->layout = "//layouts/admin";

		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANED,
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	public function actionList()
	{
		if(Yii::app()->request->isAjaxRequest){

			$this->layout=false;
			header('Content-type: application/json');

			$val = addcslashes($_GET['val'], '%_'); // escape LIKE's special characters
			$q = new CDbCriteria( array(
			    'condition' => "(username LIKE :val OR email LIKE :val OR phone LIKE :val) AND superuser = 0",         // no quotes around :match
			    'params'    => array(':val' => "%$val%")  // Aha! Wildcards go here
			) );

			$users = User::model()->findALL($q);

			echo CJavaScript::jsonEncode(
				array(
					'success'=>1,
					'data'=>$users,
				)
			);
		} else echo CJavaScript::jsonEncode(array('success'=>0, 'message'=> 'Неправильный запрос'));
	}

	public function actionExport()
	{
		$this->layout=false;
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=export_user.csv");
		header("Pragma: no-cache");
		header("Expires: 0");

		$users = User::model()->findALL(array("condition"=>"superuser = 0"));

		foreach ($users as $user) {
			echo $user->username.','.$user->email.','.$user->phone."\r\n";
		}
		die;
	}

	public function actionExportLab()
	{
		$this->layout=false;
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=export_wlab_user.csv");
		header("Pragma: no-cache");
		header("Expires: 0");

		$sql = "SELECT DISTINCT(competitor_id) FROM tbl_booking WHERE quest_id = 4;";
    	$list = Yii::app()->db->createCommand($sql)->queryAll();
    	$func = function($value) {
			return $value['competitor_id'];
		};

		$b = array_map($func, $list);
    	$ids = implode(",", $b);
    	$sql = "SELECT * FROM tbl_users WHERE superuser=0 AND id NOT IN (".$ids.") ;";
		$users = Yii::app()->db->createCommand($sql)->queryAll();
		// var_dump($users); die;
    	foreach ($users as $user) {
			echo $user['id'].','.$user['username'].','.$user['email'].','.$user['phone']."\r\n";
		}
		die;
	}
}
