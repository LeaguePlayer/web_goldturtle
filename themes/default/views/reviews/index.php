<h1 class="title"><?=$title?></h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
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