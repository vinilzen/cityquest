<?php

/**
 * This is the model class for table "{{promo_days}}".
 *
 * The followings are the available columns in table '{{promo_days}}':
 * @property integer $id
 * @property integer $quest_id
 * @property string $day
 * @property string $price_am
 * @property integer $price_pm
 */
class PromoDays extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{promo_days}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quest_id, price_pm', 'numerical', 'integerOnly'=>true),
			array('day, price_am', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, quest_id, day, price_am, price_pm', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'quest_id' => 'Quest',
			'day' => 'Day',
			'price_am' => 'Price Am',
			'price_pm' => 'Price Pm',
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
		$criteria->compare('quest_id',$this->quest_id);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('price_am',$this->price_am,true);
		$criteria->compare('price_pm',$this->price_pm);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PromoDays the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
