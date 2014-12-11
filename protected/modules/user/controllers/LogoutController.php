<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->request->cookies['cookie_name'] = new CHttpCookie('logout', 1);
		Yii::app()->user->logout();
		$this->redirect('/');
	}

}