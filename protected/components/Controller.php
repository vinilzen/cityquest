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
	public $city_model;

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
	public $cities_array;
	public $city = 1;
	public $city_name = 'Москва';
	
	public $language;


	public function init()
	{
		if ($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html' || $_SERVER['REQUEST_URI'] == '/quest/') {
 			
 			$this->redirect('/', true, 301);

		} elseif ($_SERVER['REQUEST_URI'] == '/contact/') {
 			
 			$this->redirect('/contact', true, 301);

		} elseif ($_SERVER['REQUEST_URI'] == '/giftcard/') {
 			
 			$this->redirect('/giftcard', true, 301);

		} elseif ($_SERVER['REQUEST_URI'] == '/franchise/') {
 			
 			$this->redirect('/franchise', true, 301);

		} elseif ($_SERVER['REQUEST_URI'] == '/rules/') {

 			$this->redirect('/rules', true, 301);

		}	

		$this->cities = City::model()->findAll();
		$this->cities_array = array();
		$this->language = 'ru';

		if (strpos($_SERVER['HTTP_HOST'], '.kz') > 0){
			$this->city_model = City::model()->findByPk(2);
			$this->city = 2;
			$this->city_name = 'Астана';
			$this->cities_array[$this->city] = $this->city_model;
		} else {
			
			$url_segments = explode('.',$_SERVER['HTTP_HOST']);

			if ( count($url_segments)==3 ) {
				foreach ($this->cities as $city) {
					if($city->subdomain == $url_segments[0]) {
						$this->cities_array[$city->id] = $city;
						$this->city_model = $city;
						$this->city = $city->id;
						$this->city_name = $city->name;
						break;
					}
				}
			} else {
				$this->city_model = City::model()->findByPk(1);
				$this->city = 1;
				$this->city_name = 'Москва';
				$this->cities_array[$this->city] = $this->city_model;
			}
		}

		if (isset( Yii::app()->request->cookies['lang'] )){
			$this->language = Yii::app()->request->cookies['lang']->value;
		}

		if (isset($_GET['from']) && $_GET['from'] == 'advaction'){
			$cookie = new CHttpCookie('from', 'advaction');
			$cookie->expire = time()+60*60*24*90;
			Yii::app()->request->cookies['from'] = $cookie;
		}

		if (isset($_GET['admitad_uid']) && $_GET['admitad_uid'] != ''){
			$cookie = new CHttpCookie('admitad_uid', $_GET['admitad_uid']);
			$cookie->expire = time()+60*60*24*90;
			Yii::app()->request->cookies['admitad_uid'] = $cookie;
		}

		Yii::app()->setLanguage($this->language);
	}
}