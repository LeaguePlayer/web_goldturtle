<h1 class="title">Выбор зала</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'place-list',
    'dataProvider'=>$dataProvider,
    'itemView'=>'_placeitem',
    'template'=>'{items}{pager}',
    'pager'=>array(
        'cssFile'=>false,
        'prevPageLabel'=>'',
        'nextPageLabel'=>'',
        'maxButtonCount'=>10,
        'header'=>false,
        'htmlOptions'=>array(
            'class'=>'pagination'
        )
    )
)); ?>