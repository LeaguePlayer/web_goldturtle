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

    public static function getPartTypes()
    {
        return array(
            self::PART_TYPE_FOOTER => 'Подвал'
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
			array('type', 'numerical', 'integerOnly'=>true),
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
		);
	}
	
	

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
