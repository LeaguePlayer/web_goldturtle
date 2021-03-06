<?php

/**
 * This is the model class for table "{{events}}".
 *
 * The followings are the available columns in table '{{events}}':
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $preview_clickable
 * @property string $description
 * @property string $html_content
 * @property integer $gallery
 * @property integer $place_id
 * @property integer $type
 * @property string $public_date
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 * @property integer $update_time
 */
class Events extends EActiveRecord
{
	const TYPE_NEWS = 0;
	const TYPE_CHRONICLE = 1;
	
	public static function getTypes($type = null)
	{
		$types = array(
			self::TYPE_NEWS => 'Новость',
			self::TYPE_CHRONICLE => 'Хроника',
		);
		if ( $type === null )
			return $types;
		
		return $types[$type];
	}
	
	
	public function tableName()
	{
		return '{{events}}';
	}

	
	public function rules()
	{
		return array(
			array('title, html_content, place_id, type', 'required'),
			array('gallery, place_id, type, status, sort, create_time, update_time, preview_clickable', 'numerical', 'integerOnly'=>true),
			array('title, meta_title', 'length', 'max'=>256),
			array('description, public_date, event_day, meta_description, meta_keywords', 'safe'),
			// The following rule is used by search().
			array('id, title, image, description, html_content, gallery, place_id, type, public_date, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	
	public function relations()
	{
		return array(
			'place'=>array(self::BELONGS_TO, 'Places', 'place_id'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Загловок',
			'image' => 'Превью к новости',
			'preview_clickable' => 'Открывать превью во всплывающем окне',
			'description' => 'Краткое описание',
			'html_content' => 'Контент',
			'gallery' => 'Галерея',
			'place_id' => 'Ресторан',
			'type' => 'Новость или хроника',
			'public_date' => 'Дата публикации',
			'event_day' => 'Дата проведения',
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
				'class' => 'admin.behaviors.UploadableImageBehavior',
				'versions' => array(
					'small' => array(
						'centeredpreview' => array(90, 90),
					),
					'medium' => array(
						'centeredpreview' => array(167, 101),
					),
					'big' => array(
						'resize' => array(322, 0),
					),
					'stretch' => array(
						'resize' => array(730, 0),
					),
				),
			),
			'galleryManager' => array(
				'class' => 'admin.extensions.imagesgallery.GalleryBehavior',
				'idAttribute' => 'gallery',
				'versions' => array(
					'small' => array(
						'resize' => array(90, 90),
					),
					'medium' => array(
						'resize' => array(200, 0),
					),
				),
				'name' => false,
				'description' => true,
			),
		));
	}

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('html_content',$this->html_content,true);
		$criteria->compare('gallery',$this->gallery);
		$criteria->compare('place_id',$this->place_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('public_date',$this->public_date,true);
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
		return 'События ресторана';
	}

	public function beforeSave()
	{
		$this->public_date = date('Y-m-d H:i:s', strtotime($this->public_date));
		$this->event_day = date('Y-m-d H:i:s', strtotime($this->event_day));
		return parent::beforeSave();
	}
	
	public static function getNewsUrl($place)
	{
        $get = array('events_type' => 'news');
        if ($place['alias'] !== 'restourant')
            $get['place'] = $place['alias'];
		return Yii::app()->urlManager->createUrl('/events/index', $get);
	}
	
	public static function getChroniclesUrl($place)
	{
        $get = array('events_type' => 'chronicle');
        if ($place['alias'] !== 'restourant')
            $get['place'] = $place['alias'];
		return Yii::app()->urlManager->createUrl('/events/index', $get);
	}
	
	public static function lastNews($place_id, $limit = 5)
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'public_date DESC';
		$criteria->limit = $limit;
		$criteria->addCondition('place_id=:place_id AND type=:type AND status=:status');
		$criteria->params[':place_id'] = $place_id;
		$criteria->params[':type'] = self::TYPE_NEWS;
		$criteria->params[':status'] = self::STATUS_PUBLISH;
		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public static function lastChronicles($place_id, $limit = 5)
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'public_date DESC';
		$criteria->limit = $limit;
		$criteria->addCondition('place_id=:place_id AND type=:type AND status=:status');
		$criteria->params[':place_id'] = $place_id;
		$criteria->params[':type'] = self::TYPE_CHRONICLE;
		$criteria->params[':status'] = self::STATUS_PUBLISH;
		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public function viewUrl($place = false)
	{
        if (!$place) {
            $place = $this->place;
            $alias = $place->alias;
        } else {
            $alias = $place['alias'];
        }
        $get = array('id' => $this->id);
        if ($alias !== 'restourant')
            $get['place'] = $alias;
		return Yii::app()->urlManager->createUrl('events/view', $get);
	}
	
	private $_dateArray;
	protected function getDateArray($attribute)
	{
		if ($this->_dateArray[$attribute] === null) {
			$this->_dateArray[$attribute] = explode('.', date('d.m.Y.H.i', strtotime($this->{$attribute})) );
		}
		return $this->_dateArray;
	}
	public function getDay($attribute)
	{
        $dateArray = $this->getDateArray($attribute);
        return $dateArray[$attribute][0];
	}
	public function getMonth($attribute)
	{
        $dateArray = $this->getDateArray($attribute);
		return SiteHelper::russianMonth($dateArray[$attribute][1]);
	}
	public function getYear($attribute)
	{
        $dateArray = $this->getDateArray($attribute);
		return $dateArray[$attribute][2];
	}
	public function getTime($attribute)
	{
        $dateArray = $this->getDateArray($attribute);
		if (($dateArray[$attribute][3] == 0) and ($dateArray[$attribute][4] == 0))
			return null;
		return $dateArray[$attribute][3].'.'.$dateArray[$attribute][4];
	}
	
	public function getGallery() {
		return $this->galleryManager->getGallery();
	}

    public function afterFind()
    {
        parent::afterFind();
        $this->public_date = date('d-m-Y', strtotime($this->public_date));
        $this->event_day = date('d-m-Y H:i', strtotime($this->event_day));
    }

    public function isPreviewClickable()
    {
        return $this->preview_clickable != 0;
    }
}
