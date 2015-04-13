<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='column1';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	public $description = '';
	public $keywords = '';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $quest_menu=array(
				array(
					'label'=>'Сводная таблица',
					'url'=>array('/quest/adminschedule/ymd')
				),
				array(
					'label'=>'Управление квестами',
					'url'=>array('/quest/admin')
				),
			);
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $user_menu = array(array('label'=>'Управление пользователями','url'=>array('/user/admin')));
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $city_menu=array(array('label'=>'Управление городами', 'url'=>array('/city/admin')));

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();



	public $cities;
	public $city = 1;
	
	public $language;


	public function init()
	{
		if ($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html') {
			header("HTTP/1.1 301 Moved Permanently");
 			header('Location: /');
 			die;
		} elseif ($_SERVER['REQUEST_URI'] == '/contact/') {
			header("HTTP/1.1 301 Moved Permanently");
 			header('Location: /contact');
 			die;
		} elseif ($_SERVER['REQUEST_URI'] == '/giftcard/') {
			header("HTTP/1.1 301 Moved Permanently");
 			header('Location: /giftcard');
 			die;
		} elseif ($_SERVER['REQUEST_URI'] == '/franchise/') {
			header("HTTP/1.1 301 Moved Permanently");
 			header('Location: /franchise');
 			die;
		}

		$this->cities = City::model()->findAll();
		$this->language = 'ru';

		if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){
			// $this->language = 'kz';
			$this->city = 2;
		} else {
			$this->city = 1;
		}

		if (isset( Yii::app()->request->cookies['lang'] )){
			$this->language = Yii::app()->request->cookies['lang']->value;
		}

		if (isset($_GET['from']) && $_GET['from'] == 'advaction'){
			$cookie = new CHttpCookie('from', 'advaction');
			$cookie->expire = time()+60*60*24*7;
			Yii::app()->request->cookies['from'] = $cookie;
		}

		Yii::app()->setLanguage($this->language);
	}
}