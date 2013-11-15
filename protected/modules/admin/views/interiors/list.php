<?php
$this->menu=array(
	array('label'=>'Добавить альбом','url'=>array('create')),
);
?>

<h1>Фотографии</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'interiors-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
		'title',
		array(
			'name'=>'place_id',
			'type'=>'raw',
			'value'=>'$data->place->title',
			'filter'=>CHtml::listData(Places::model()->findAll(), 'id', 'title')
		),
		array(
			'name'=>'status',
			'type'=>'raw',
			'value'=>'Interiors::getStatusAliases($data->status)',
			'filter'=>array(Interiors::getStatusAliases())
		),
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
