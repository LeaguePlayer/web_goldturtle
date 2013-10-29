<?php

class PagesController extends Controller
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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionView($alias = null)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('status=:status');
		$criteria->params[':status'] = Pages::STATUS_PUBLISH;
		
		if ( $alias === null ) {
			$id = Yii::app()->request->getParam('id');
			$model = $this->loadModel('Pages', $id, $criteria);
		} else {
			$model = Pages::model()->findByAttributes(array('alias'=>$alias), $criteria);
			if ( $model === null ) {
				throw new CHttpException(404, 'Указанная страница не найдена');
			}
		}
		$this->title = $model->title;
		$this->currentPage = $alias;
		if ( $alias === 'contacti' ) {
			$this->renderYandexMap = true;
		}

        Yii::app()->clientScript->registerMetaTag($model->meta_keywords, 'Keywords');
        Yii::app()->clientScript->registerMetaTag($model->meta_description, 'Description');
		$this->render('view',array(
			'model'=>$model,
		));
	}
}
