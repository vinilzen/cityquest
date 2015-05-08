<?php

/**
 * This is the model class for table "{{city}}".
 *
 * The followings are the available columns in table '{{city}}':
 * @property integer $id
 * @property string $name
 * @property string $languages
 * @property string $country
 * @property string $subdomain
 * @property integer $active
 * 
 * @property string $tel
 * @property string $addres
 * @property string $giftcard_text
 * @property string $franchise_text
 * @property string $giftcard_mail
 *
 * The followings are the available model relations:
 * @property Quest[] $quests
 */
class City extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{city}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, country', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('giftcard_text, franchise_text', 'length', 'max'=>1024),
			array('name, country, tel, addres, giftcard_mail', 'length', 'max'=>128),
			array('languages', 'length', 'max'=>10),
			array('subdomain', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, active, languages', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'quest' => array(self::HAS_MANY, 'Quest', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('app','Title'),
			'active' => Yii::t('app','Active'),
			'country' => Yii::t('app','Country'),
			'languages' => Yii::t('app','Languages'),
			'subdomain' => Yii::t('app','Subdomain'),

			'addres' => Yii::t('app','Addres'),
			'tel' => Yii::t('app','Phone'),
			'giftcard_text' => Yii::t('app','Giftcard text'),
			'franchise_text' => Yii::t('app','Franchise text'),
			'giftcard_mail' => Yii::t('app','Giftcard mail'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('subdomain',$this->subdomain);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
