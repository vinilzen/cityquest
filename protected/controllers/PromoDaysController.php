<?php

class PromoDaysController extends Controller
{

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 1",
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 1",
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
		$model=new PromoDays;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PromoDays']))
		{
			$this->layout=false;
			header('Content-type: application/json');
			$model->attributes=$_POST['PromoDays'];

			if($model->save()) {
				echo CJSON::encode( array('success'=>1) );
				//$this->redirect(array('view','id'=>$model->id));
			} else {
				echo CJSON::encode(
					array(
						'success'=>0,
						'errors'=>$model->getErrors()
					)
				);
			}

			Yii::app()->end();
		}

		/*
			$this->render('create',array(
				'model'=>$model,
			));
		*/
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PromoDays']))
		{
			$model->attributes=$_POST['PromoDays'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		$model = $this->loadModel((int)$_POST['id'])->delete();
		$this->layout=false;
		header('Content-type: application/json');
		echo CJSON::encode( array('success'=>1) );
		Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$qid = $_POST['qid'];
		$models = PromoDays::model()->findAllByAttributes(
			array('quest_id'=>(int)$qid),
			'day >= :today',
			array('today'=>date('Ymd'))
		);

        $this->layout=false;
        header('Content-type: application/json');
        echo CJSON::encode( array('days'=>$models) );
        Yii::app()->end();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PromoDays('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PromoDays']))
			$model->attributes=$_GET['PromoDays'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PromoDays the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{

		$model=PromoDays::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PromoDays $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='promo-days-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
