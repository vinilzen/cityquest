<?php

/**
 * This is the model class for table "tbl_booking".
 *
 * The followings are the available columns in table 'tbl_booking':
 * @property integer $id
 * @property string $comment
 * @property integer $status
 * @property string $time
 * @property integer $create_time
 * @property string $email
 * @property string $phone
 * @property integer $result
 * @property integer $quest_id
 * @property integer $competitor_id
 * @property string  $affiliate
 * 
 * @property string  $winner_photo
 *
 * The followings are the available model relations:
 * @property TblQuest $quest
 * @property TblUser $competitor
 */
class Booking extends CActiveRecord
{


	const STATUS_CONFIRMED=1;
	const STATUS_NOTCONFIRMED=0;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_booking';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, time, quest_id, competitor_id', 'required'),
			array('status, create_time, quest_id', 'numerical', 'integerOnly'=>true),
			// array('winner_photo', 'file','types'=>'jpg', 'allowEmpty'=>true, 'on'=>'update'),
			array('winner_photo, comment','length', 'max'=>255, 'on'=>'insert, update'),
			array('competitor_id', 'numerical', 'integerOnly'=>false),
			array('email, phone, name,affiliate', 'length', 'max'=>128),
			array('result', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, comment, status, time, result, create_time, email, phone, quest_id, competitor_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		
		Yii::import('application.modules.user.models.*');

		return array(
			'quest' => array(self::BELONGS_TO, 'Quest', 'quest_id'),
			'competitor' => array(self::BELONGS_TO, 'User', 'competitor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'comment' => Yii::t('app','Comment'),
			'status' => Yii::t('app','Status'),
			'time' => Yii::t('app','Time'),
			'create_time' => Yii::t('app','Create Time'),
			'email' => Yii::t('app','Email'),
			'name' => Yii::t('app','Name'),
			'phone' => Yii::t('app','Phone'),
			'result' => Yii::t('app','Result'),
			'quest_id' => Yii::t('app','Quest'),
			'competitor_id' => Yii::t('app','Competitor'),
			'affiliate' => Yii::t('app','Affiliate'),
			'source' => Yii::t('app','Sources'),
			'discount' => Yii::t('app','Discounts'),
			'payment' => Yii::t('app','Payments'),
			'winner_photo' => Yii::t('app','Winer photo'),
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
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('affiliate',$this->affiliate);
		$criteria->compare('quest_id',$this->quest_id);
		$criteria->compare('competitor_id',$this->competitor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	* This is invoked before the record is saved.
	* @return boolean whether the record should be saved.
	*/
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
				$this->create_time=time();
			return true;
		}
		else
			return false;
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Booking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
