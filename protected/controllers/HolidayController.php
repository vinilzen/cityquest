<?php

class HolidayController extends Controller
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
				'actions'=>array('get'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'create','update'),
				'expression'=>"Yii::app()->getModule('user')->user()->superuser == 1",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Holiday;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['holiday']))
		{
			$model->attributes=$_POST['holiday'];
			if($model->save())
				echo 'save';
		}
		die;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{

		$this->layout=false;

		header('Content-type: application/json');

		$model=Holiday::model()->findByAttributes(array(
			'holiday_date'=>(int)$_POST['date']
		));

		if ($model && $_POST['is_holiday']==1){
			if ($model->delete())
				echo CJavaScript::jsonEncode(
					array(
						'success'=>1, 
						'message'=> 'Выходной удалён!'
					)
				);
			else
				echo CJavaScript::jsonEncode(
					array(
						'success'=>0, 
						'message'=> 'Ошибка удаления выходного', 
						'errors'=>$model->getErrors()
					)
				);
		} else if (!$model && $_POST['is_holiday']==0){
			$model=new Holiday;
			$model->city = (int)$_POST['city'];
			$model->holiday_date = (int)$_POST['date'];

			if($model->save())
				echo CJavaScript::jsonEncode(
					array(
						'success'=>1, 
						'message'=> 'Выходной добавлен!'
					)
				);
			else
				echo CJavaScript::jsonEncode(
					array(
						'success'=>0, 
						'message'=> 'Ошибка сохранения', 
						'errors'=>$model->getErrors()
					)
				);
		} else {
			echo CJavaScript::jsonEncode(
				array(
					'success'=>1,
					'same'=>1,
					'message'=> 'Суббота и Воскресенье всегда выходные!'
				)
			);
		}

		Yii::app()->end();
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
		$dataProvider=new CActiveDataProvider('City');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionGet($start, $end)
	{
		$criteria = new CDbCriteria;
		$criteria->addBetweenCondition('holiday_date', $start, $end);
		$models = Holiday::model()->findAll($criteria);

        $this->layout=false;
        header('Content-type: application/json');
        echo CJSON::encode( array(
        		'success'=>1,
        		'days'=>$models
        	)
        );
        Yii::app()->end();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new City('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['City']))
			$model->attributes=$_GET['City'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return City the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Holiday::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param City $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
