<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $phone
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
	 * @var string $quests
	 * @var string $locations
	 * @var string $city_id
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
	
		return ((Yii::app()->getModule('user')->isAdmin()) ? 
			array(
				array('username, email, phone', 'required'),
				array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
				array('phone', 'length', 'max'=>18, 'min' => 5,'message' => UserModule::t("Incorrect phone (length between 5 and 12 characters).")),
				array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
				array('email', 'email'),
				array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
				array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
				array('superuser', 'in', 'range'=>array(0,1,2,3)),
				array('username, email, createtime, lastvisit, superuser, status', 'required'),
				array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly'=>true),
				array('username, email, phone', 'safe', 'on'=>'search'),
			)
			:
			(
				(Yii::app()->user->id==$this->id) ? 

				array(
					array('username, email, phone', 'required'),
					array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
					array('phone', 'length', 'max'=>18, 'min' => 5,'message' => UserModule::t("Incorrect phone (length between 5 and 12 characters).")),
					array('email', 'email'),
					array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),

				) : array()
			));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array();
		if (isset(Yii::app()->getModule('user')->relations))
			$relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>UserModule::t("username"),
			'name'=>UserModule::t("name"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'id' => UserModule::t("Id"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'lastvisit' => UserModule::t("Last visit"),
			'phone' => UserModule::t("Phone"),
			'quests' => Yii::t('app','Quest'),
			'locations' => Yii::t('app','Locations'),
			'superuser' => 'Роль',
			'moderator' => 'Модератор',
			'city_id' => Yii::t('app','City'),
			'status' => UserModule::t("Status"),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array('condition'=>'status='.self::STATUS_ACTIVE),
            'notactvie'=>array('condition'=>'status='.self::STATUS_NOACTIVE),
            'banned'=>array('condition'=>'status='.self::STATUS_BANED),
            'superuser'=>array('condition'=>'superuser=1'),
            'admin'=>array('condition'=>'superuser=3'),
            'moderator'=>array('condition'=>'superuser=2'),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, createtime, lastvisit, superuser, status',
            ),
        );
    }
	
	public function defaultScope() {
        return array(
            'select' => 'id, username, email, phone, createtime, lastvisit, superuser, status, quests, locations, fb_link, fb_id, vk_id, city_id',
        );
    }

    public static function listQuests($quests) {
		$titles = array();
    	foreach ($quests as $q) {
			array_push($titles, $q->title);
		}
		return implode(', ', $titles);
	}

    public static function listLocations($locations) {
		$names = array();
    	foreach ($locations as $l) {
			array_push($names, $l->name);
		}
		return implode(', ', $names);
	}
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('Пользователь'),
				'1' => UserModule::t('Суперадмин'),
				'2' => UserModule::t('Модератор квеста'),
				'3' => UserModule::t('Модератор'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

	/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id, true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

}