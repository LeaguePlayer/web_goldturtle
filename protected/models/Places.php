<?php

/**
 * This is the model class for table "{{places}}".
 *
 * The followings are the available columns in table '{{places}}':
 * @property integer $id
 * @property string $image
 * @property string $title
 * @property string $html_description
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 * @property integer $update_time
 */
class Places extends EActiveRecord
{
	public function tableName()
	{
		return '{{places}}';
	}

	
	public function rules()
	{
		return array(
			array('title', 'required'),
			array('status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('title, alias, meta_title', 'length', 'max'=>256),
			array('html_description, meta_description, meta_keywords', 'safe'),
			// The following rule is used by search().
			array('id, image, title, html_description, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	
	public function relations()
	{
		return array(
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'Логотип',
			'title' => 'Название места',
            'alias' => 'Идентификатор',
			'html_description' => 'Описание',
			'status' => 'Статус',
			'sort' => 'Вес для сортировки',
			'create_time' => 'Дата создания',
			'update_time' => 'Дата последнего редактирования',
		);
	}
	
	
	public function behaviors()
	{
		return CMap::mergeArray(parent::behaviors(), array(
			'UploadableImageBehavior' => array(
				'class' => 'UploadableImageBehavior',
				'versions' => array(
					'small' => array(
						'resize' => array(90, 0),
					),
					'medium' => array(
						'resize' => array(160, 0),
					),
				)
			),
		));
	}

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('alias',$this->alias,true);
		$criteria->compare('html_description',$this->html_description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->order = 'status, create_time DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function translition()
	{
		return 'Рестораны';
	}

    public function beforeSave()
    {
        if ( parent::beforeSave() ) {
            if ( empty($this->alias) ) {
                $this->alias = SiteHelper::translit($this->title);
            }
            return true;
        }
        return false;
    }

    public function getChangeUrl()
    {
        $get = ( $this->alias === 'restourant' ) ? array() : array('place'=>$this->alias);
        return Yii::app()->urlManager->createUrl('/site/index', $get);
    }
}
