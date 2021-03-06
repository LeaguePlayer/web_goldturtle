<h1>Управление <?php echo $model->translition(); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'places-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
		array(
			'header'=>'Фото',
			'type'=>'raw',
			'value'=>'TbHtml::imageRounded($data->getThumb("small"))'
		),
		'title',
        'alias',
		array(
			'name'=>'status',
			'type'=>'raw',
			'value'=>'Places::getStatusAliases($data->status)',
			'filter'=>array(Places::getStatusAliases())
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
			'template'=>'{update}',
		),
	),
)); ?>
