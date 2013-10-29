<h1>Управление страницами</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'metadata-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
        array(
            'name'=>'post_type',
            'type'=>'raw',
            'value'=>'$data->pageType',
            'filter'=>Metadata::getPostTypes(),
        ),
        'meta_title',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update}',
		),
	),
)); ?>
