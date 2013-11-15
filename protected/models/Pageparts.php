<?php

/**
 * This is the model class for table "{{pageparts}}".
 *
 * The followings are the available columns in table '{{pageparts}}':
 * @property integer $id
 * @property integer $type
 * @property string $content
 */
class Pageparts extends CActiveRecord
{
    const PART_TYPE_FOOTER = 1;
    const PART_TYPE_CONTENT_BOX = 2;

    public static function getPartTypes()
    {
        return array(
            self::PART_TYPE_FOOTER => 'Подвал',
            self::PART_TYPE_CONTENT_BOX => 'Блок под слайдером'
        );
    }

    public function getPartType()
    {
        $types = self::getPartTypes();
        return $types[$this->type];
    }

	public function tableName()
	{
		return '{{pageparts}}';
	}

	
	public function rules()
	{
		return array(
			array('type', 'required'),
			array('type, place_id', 'numerical', 'integerOnly'=>true),
            array('content', 'safe'),
			// The following rule is used by search().
			array('id, type, content', 'safe', 'on'=>'search'),
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
			'type' => 'Тип',
			'content' => 'Контент',
			'place_id' => 'Привязка к помещению',
		);
	}
	
	

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('place_id',$this->place_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getContent($type, $place = array())
    {
        $model = self::model()->findByAttributes(array('type'=>$type, 'place_id'=>$place['id']));
        if ( $model === null ) {
        	$model = self::model()->findByAttributes(array('type'=>$type));
        }
        if ( $model !== null ) {
        	$getPlace = ( $place['alias'] !== 'restourant' ) ? array('place'=>$place['alias']) : array();
        	$replacements = array(
        		'link_for_home'=>Yii::app()->urlManager->createUrl('site/index', $getPlace),
        		'link_for_menu'=>Yii::app()->urlManager->createUrl('menu/index', $getPlace),
        		'link_for_events'=>Events::getNewsUrl($place),
        	);
            return SiteHelper::replaceBlocks($model->content, $replacements);
        }
    }

    public function getTypeLabel()
    {
    	$result = $this->partType;
    	$place = Places::model()->findByPk($this->place_id);
    	if ( $place )
    		$result .= ' (' . $place->title . ')';
    	return $result;
    }

}
