<?php

/**
 * This is the model class for table "tbl_quest".
 *
 * The followings are the available columns in table 'tbl_quest':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $addres
 * @property string $metro
 * @property integer $times
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property TblUser $author
 */
class Quest extends CActiveRecord
{

	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_SOON=3;


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
			array('title, content, addres, metro, times, status, author_id', 'required'),
			array('times, status, create_time, update_time, author_id', 'numerical', 'integerOnly'=>true),
			array('title, addres, metro', 'length', 'max'=>128),
			array('del_img', 'boolean'),
			array('image', 'file',
			'types'=>'jpg',
			'maxSize'=>5000 * 5000 * 5, // 5MB
			'allowEmpty'=>'true',
			'tooLarge'=>'The file was larger than 5MB. Please upload a smaller file.',
            ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, addres, metro, times, status, create_time, update_time, author_id', 'safe', 'on'=>'search'),
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
			'addres' => 'Addres',
			'metro' => 'Metro',
			'times' => 'Times',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
			'image' => 'Image',
			'del_img'=>'Delete image?',
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
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('author_id',$this->author_id);

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
