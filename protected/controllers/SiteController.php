<?php

class SiteController extends Controller
{
	public $layout = '//layouts/col_2';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/col_1';
		$this->currentPage = 'main';
		$slider = Slider::model()->findByAttributes(array('place_id'=>$this->place['id']));
		if ( $slider !== null and $slider->status == Slider::STATUS_PUBLISH ) {
			$this->sliderManager = $slider->galleryManager->getGallery();
		}
        $this->title = $this->place['meta_title'];
        Yii::app()->clientScript->registerMetaTag($this->place['meta_keywords'], 'Keywords');
        Yii::app()->clientScript->registerMetaTag($this->place['meta_description'], 'Description');
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
    
    public function actionOrder()
    {
        $model = new OrderForm;
		$model->date = date("d-m-Y H:i", time() + 60*60);
		
		if ( isset($_POST['OrderForm']) ) {
			$model->attributes = $_POST['OrderForm'];
			if ( $model->validate() ) {
				$subject = "Заявка с сайта http://cherepaha-rest.ru/";
				$date = SiteHelper::russianDate($model->date)." ".date('H:i', strtotime($model->date));
				$message = "С сайта http://cherepaha-rest.ru/ поступила заявка на бронирование столика.<br>".
						"<strong>Имя</strong>: {$model->name}<br>".
						"<strong>Телефон</strong>: {$model->phone}<br>".
						"<strong>Дата</strong>: {$date}<br>";
						
				SiteHelper::sendMail($subject, $message, Settings::getOption('admin_email'), 'no-repeat@cherepaha-rest.ru');
				Yii::app()->user->setFlash('SUCCESS_ORDER', 'Ваша заявка принята!');
			}
		}
		
		if ( Yii::app()->request->isAjaxRequest ) {
			$this->renderPartial('order', array('model'=>$model));
			Yii::app()->end();
		}
        $this->render('order', array('model'=>$model));
    }

    public function actionPlace()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('status=:status');
        $criteria->params[':status'] = Events::STATUS_PUBLISH;
        $dataProvider=new CActiveDataProvider('Places', array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize'=>100
            ),
        ));
        $metadata = Metadata::fetch(Metadata::POST_TYPE_PLACES);
        $this->title = $metadata->meta_title;
        Yii::app()->clientScript->registerMetaTag($metadata->meta_keywords, 'Keywords');
        Yii::app()->clientScript->registerMetaTag($metadata->meta_description, 'Description');
        $this->render('place', array('dataProvider'=>$dataProvider));
    }
}