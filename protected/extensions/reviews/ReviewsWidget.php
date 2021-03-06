<?php
class ReviewsWidget extends CWidget
{
	private $_run = true;
	public $dataProvider;

	public function init()
	{
		if ( $this->dataProvider === null ) {
			$model = new Reviews;
			$criteria = new CDbCriteria;
			$criteria->order = 'create_time DESC';
            $criteria->compare('status', Reviews::STATUS_PUBLISH);
            $criteria->compare('place_id', $this->owner->place['id']);
			$this->dataProvider = new CActiveDataProvider($model, array(
				'criteria' => $criteria,
				'pagination' => array(
					'pageSize' => 3,
					'pageVar' => 'page',
				),
			));
			
			if ( $this->dataProvider === null ) {
				$this->_run = false;
				return true;
			}
		}
		
		$this->registerScripts();
	}
 
    public function run()
	{
		if ( !$this->_run ) {
			return true;
		}
		$this->render('reviews', array('dataProvider' => $this->dataProvider));
    }
	
	public function registerScripts() {
		$pageCount = ceil($this->dataProvider->totalItemCount / $this->dataProvider->pagination->pageSize);
		$cs = Yii::app()->clientScript;
		$cs->registerScript(__CLASS__,"
$('.paginator').hide();
var page = ".( (int)Yii::app()->request->getParam('page', 1) ).";
var pageCount = ".$pageCount.";

var loadingFlag = false;
var moreButton = $('#reviews').find('.more');
var loader = $('#reviews').find('.loader .arrow').hide();

moreButton.click(function()
{
	if (!loadingFlag) {
		loadingFlag = true;
		loader.show();
		$.ajax({
			type: 'GET',
			url: '".$this->owner->createUrl('/reviews/loadMore')."',
			data: {
				'page': page + 1,
				'".Yii::app()->request->csrfTokenName."': '".Yii::app()->request->csrfToken."',
				LOAD_REVIEWS: true,
			},
			success: function(data)
			{
				page++;                            
				loadingFlag = false;
				loader.hide();
				moreButton.parents('.progress').before(data);
				if (page >= pageCount)
					moreButton.hide();
			}
		});
	}
	return false;
});"
		);
	}
	
	protected function getAssetsUrl() {
        if ($this->_assetsUrl===null){
            $this->_assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets');
        }
		return $this->_assetsUrl;
    }
}
