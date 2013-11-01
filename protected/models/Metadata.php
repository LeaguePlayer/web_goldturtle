<?php

/**
 * This is the model class for table "{{metadata}}".
 *
 * The followings are the available columns in table '{{metadata}}':
 * @property integer $id
 * @property integer $post_type
 * @property string $meta_description
 * @property string $meta_keywords
 */
class Metadata extends CActiveRecord
{
    const POST_TYPE_NEWS = 1;
    const POST_TYPE_CHRONICLES = 2;
    const POST_TYPE_DISHES = 3;
    const POST_TYPE_MENU = 4;
    const POST_TYPE_INTERIORS = 5;
    const POST_TYPE_PLACES = 6;
    const POST_TYPE_EMPLOYEES = 7;
    const POST_TYPE_JOBS = 8;
    const POST_TYPE_BANNERS = 9;
    const POST_TYPE_PARTNERS = 10;
    const POST_TYPE_REVIEWS = 11;

    public static function getPostTypes()
    {
        return array(
            self::POST_TYPE_NEWS => 'Страница "Новости"',
            self::POST_TYPE_CHRONICLES => 'Страница "Хроника"',
            self::POST_TYPE_DISHES => 'Страница "Фото блюд"',
            self::POST_TYPE_MENU => 'Страница "Меню ресторана"',
            self::POST_TYPE_INTERIORS => 'Страница "Интерьер"',
            self::POST_TYPE_PLACES => 'Страница "Выбор зала"',
            self::POST_TYPE_EMPLOYEES => 'Страница "Сотрудники"',
            self::POST_TYPE_JOBS => 'Страница "Вакансии"',
            self::POST_TYPE_BANNERS => 'Страница "Реклама"',
            self::POST_TYPE_PARTNERS => 'Страница "Наши партнеры"',
            self::POST_TYPE_REVIEWS => 'Страница "Отзывы"',
        );
    }


    public function getPageType()
    {
        $types = self::getPostTypes();
        return $types[$this->post_type];
    }


	public function tableName()
	{
		return '{{metadata}}';
	}

	
	public function rules()
	{
		return array(
			array('post_type, title', 'required'),
			array('post_type', 'numerical', 'integerOnly'=>true),
			array('meta_title, title', 'length', 'max'=>256),
            array('meta_description, meta_keywords', 'safe'),
			// The following rule is used by search().
			array('id, post_type, meta_description, meta_keywords', 'safe', 'on'=>'search'),
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
			'title' => 'Заголовок',
			'post_type' => 'Страница',
            'meta_title' => 'Мета-заголовок',
			'meta_description' => 'Описание',
			'meta_keywords' => 'Ключевые слова',
		);
	}

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title);
		$criteria->compare('post_type',$this->post_type);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public static function fetch($post_type)
    {
        return self::model()->findByAttributes(array('post_type'=>$post_type));
    }

}
