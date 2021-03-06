<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление <?php echo $model->translition(); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'partners-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('partners')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id
    )',
	'columns'=>array(
		array(
			'header'=>'Фото',
			'type'=>'raw',
			'value'=>'TbHtml::imageRounded($data->getThumb("small"))'
		),
		'name',
        array(
            'name'=>'place_id',
            'type'=>'raw',
            'value'=>'$data->place->title',
            'filter'=>CHtml::listData(Places::model()->findAll(), 'id', 'title')
        ),
		array(
			'name'=>'site',
			'type'=>'raw',
			'value'=>'$data->linkWithSite',
		),
		array(
			'name'=>'status',
			'type'=>'raw',
			'value'=>'Partners::getStatusAliases($data->status)',
			'filter'=>Partners::getStatusAliases()
		),
		'sort',
		array(
			'name'=>'create_time',
			'type'=>'raw',
			'value'=>'$data->createDate'
		),
		array(
			'name'=>'update_time',
			'type'=>'raw',
			'value'=>'$data->updateDate'
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sort_grid', "$(document).ready(sortGrid('partners'));", CClientScript::POS_END); ?>
