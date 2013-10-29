
<h1>Управление контентом</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pageparts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
        array(
            'name'=>'type',
            'type'=>'raw',
            'value'=>'$data->partType',
            'filter'=>Pageparts::getPartTypes(),
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update}',
		),
	),
)); ?>
