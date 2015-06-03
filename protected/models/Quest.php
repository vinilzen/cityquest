<?php

/**
 * This is the model class for table "tbl_quest".
 *
 * The followings are the available columns in table 'tbl_quest':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $start_text
 * @property string $addres
 * 
 * @property string $addres_additional
 * 
 * @property string $metro
 * @property integer $times
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 * @property integer $city_id
 * @property integer $link
 * 
 * @property integer $type
 * @property integer $difficult
 * @property integer $actor
 * 
 * @property integer $cover
 * @property integer $price_am
 * @property integer $price_pm
 * @property integer $price_weekend_am
 * @property integer $price_weekend_pm
 * 
 * @property integer $time_preregistration
 * @property integer $mail_for_notifications
 * 
 * @property integer $page_title
 * @property integer $description
 * @property integer $keywords
 * 
 * @property integer $location_id
 *
 * The followings are the available model relations:
 * @property TblUser $author
 */
class Quest extends CActiveRecord
{

	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_SOON=3;

	const TYPE_DEFAULT = 0;
	const TYPE_SPORT = 1;
	const TYPE_PERFOMANCE = 2;

	const DIFFICULT_BASE = 0;
	const DIFFICULT_MEDIUM = 1;
	const DIFFICULT_HIGH = 2;


	// assortiment_img value
	public $image;
	// Delete picture boolean
	public $del_img;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_quest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price_am, price_pm, price_weekend_am, price_weekend_pm, title, content, addres, times, status, author_id, city_id, location_id, link', 'required'),
			array('price_am, price_pm, price_weekend_am, price_weekend_pm, times, status, sort, create_time, update_time, author_id, type, difficult, actor, time_preregistration', 'numerical', 'integerOnly'=>true),
			array('title, addres, addres_additional, cover, start_text, metro, page_title, mail_for_notifications', 'length', 'max'=>128),
			array('description, keywords, schedule', 'length', 'max'=>256),
			array('del_img', 'boolean'),
			array('image', 'file',
				'types'=>'jpg',
				'maxSize'=>5000 * 5000 * 5, // 5MB
				'allowEmpty'=>'true',
				'tooLarge'=>'The file was larger than 5MB. Please upload a smaller file.',
            ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, addres, metro, times, sort, status, create_time, update_time, author_id', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'booking' => array(self::HAS_MANY, 'Booking', 'quest_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
			'photo' => array(self::MANY_MANY, 'Photo', '{{quest_photo}}(quest_id, photo_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'start_text' => 'Текст перед запуском',
			'addres' => Yii::t('app','Addres'),
			'addres_additional' => Yii::t('app','Addres additional'),
			'metro' => 'Metro',
			'sort' => 'Sort',
			'times' => 'Times',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => Yii::t('app','Update Time'),
			'author_id' => Yii::t('app','Author'),
			'city_id' => Yii::t('app','City'),
			'location_id' => Yii::t('app','Location'),
			'image' => Yii::t('app','Image'),
			'del_img'=>Yii::t('app','Delete image?'),
			'page_title'=>Yii::t('app','Page Title'),
			'description'=>Yii::t('app','Description'),
			'keywords'=>Yii::t('app','Keywords'),
			'link'=>Yii::t('app','Link'),
			'type'=>Yii::t('app','Type'),
 			'difficult'=>Yii::t('app','Difficult'),
 			'actor'=>Yii::t('app','Actor'),
 			'cover'=>Yii::t('app','Cover'),
 			'price_am'=>Yii::t('app','Price Am workday'),
 			'price_pm'=>Yii::t('app','Price Pm workday'),
 			'price_weekend_am'=>Yii::t('app','Price Am weekend'),
 			'price_weekend_pm'=>Yii::t('app','Price Pm weekend'),
 			'time_preregistration'=>Yii::t('app','Time close registration before Quest'),
 			'mail_for_notifications'=>Yii::t('app','Email for notifications'),
 			'schedule'=>Yii::t('app','Schedule'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addres',$this->addres,true);
		$criteria->compare('metro',$this->metro,true);
		$criteria->compare('times',$this->times);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('link',$this->link);

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
			{
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
			}
			else
				$this->update_time=time();

			return true;
		}
		else
			return false;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Quest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
