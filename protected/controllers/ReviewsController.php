<?php

class ReviewsController extends Controller
{
	public $layout='//layouts/col_2';

	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'ajaxOnly + loadMore',
		);
	}

	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('loadMore', 'add', 'index'),
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
        $criteria->compare('status', Reviews::STATUS_PUBLISH);
        $criteria->compare('place_id', $this->place['id']);
        $criteria->order = 'create_time DESC';
        $dataProvider = new CActiveDataProvider('Reviews', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $metadata = Metadata::fetch(Metadata::POST_TYPE_REVIEWS);
        $this->title = $metadata->meta_title;//.' | '.$this->place['meta_title'];
        Yii::app()->clientScript->registerMetaTag($metadata->meta_keywords, 'Keywords');
        Yii::app()->clientScript->registerMetaTag($metadata->meta_description, 'Description');
        $this->render('index', array(
            'title'=>!empty($metadata->title) ? $metadata->title : 'Отзывы',
            'dataProvider'=>$dataProvider
        ));
    }

	
	public function actionLoadMore()
	{
		if (isset($_POST['page']))
            $_GET['page'] = Yii::app()->request->getPost('page');
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('status=:status');
		$criteria->params[':status'] = Reviews::STATUS_PUBLISH;
		$criteria->order = 'create_time DESC';
		$dataProvider = new CActiveDataProvider('Reviews', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 3,
				'pageVar' => 'page',
			),
		));
		echo $this->renderPartial('application.extensions.reviews.views.ajax_reviews', array(
			'dataProvider'=>$dataProvider,
		), true);
	}
	
	public function actionAdd()
	{
		$model = new Reviews;
		$model->place_id = $this->place['id'];
		
		if ( isset($_POST['Reviews']) ) {
			$model->attributes = $_POST['Reviews'];
			$model->status = Reviews::STATUS_CLOSED;
			if ( $model->save() ) {
				Yii::app()->user->setFlash('SUCCESS_REVIEW', 'Спасибо за отзыв! Нам не безразлично Ваше мнение.');
			}
		}
		
		if ( Yii::app()->request->isAjaxRequest ) {
			$this->renderPartial('_form', array('model'=>$model));
			Yii::app()->end();
		}
		
		$this->render('_form', array('model'=>$model));
	}
}
