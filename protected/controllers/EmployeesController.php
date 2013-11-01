<?php

class EmployeesController extends Controller
{
	public $layout='//layouts/col_2';

	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'create_time';
		$criteria->addCondition('status=:status');
		$criteria->compare('place_id', $this->place['id']);
		$criteria->params[':status'] = Employees::STATUS_PUBLISH;
		$dataProvider=new CActiveDataProvider('Employees', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 10
			)
		));
        $metadata = Metadata::fetch(Metadata::POST_TYPE_EMPLOYEES);
        $this->title = $metadata->meta_title.' | '.$this->place['meta_title'];
        Yii::app()->clientScript->registerMetaTag($metadata->meta_keywords, 'Keywords');
        Yii::app()->clientScript->registerMetaTag($metadata->meta_description, 'Description');
        $this->currentPage = 'employees';
		$this->render('index',array(
            'title'=>!empty($metadata->title) ? $metadata->title : 'Наша команда',
			'dataProvider'=>$dataProvider,
		));
	}
}
