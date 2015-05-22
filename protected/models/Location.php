<?php

/**
 * This is the model class for table "{{location}}".
 *
 * The followings are the available columns in table '{{location}}':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $tel
 * @property string $contact_email
 * @property string $notification_email
 * @property string $metro
 * @property integer $city_id
 * 
 * @property integer $address_additional
 * @property integer $parking
 */
class Location extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('name, address, contact_email, notification_email, parking', 'length', 'max'=>128),
			array('address_additional', 'length', 'max'=>256),
			array('tel, metro', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, tel, contact_email, metro, city_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'name' => Yii::t('app','Name'),
			'address' => Yii::t('app','Address'),
			'tel' => Yii::t('app','Tel'),
			'notification_email' => Yii::t('app','Email for notification'),
			'contact_email' => Yii::t('app','Email for contact'),
			'metro' => Yii::t('app','Metro'),
			'city_id' => Yii::t('app','City'),
			'address_additional' => Yii::t('app','Additional address info'),
			'parking' => Yii::t('app','Parking'),
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('metro',$this->metro,true);
		$criteria->compare('city_id',$this->city_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
