<?php
/* @var $this PartnersController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1 class="title"><?=$title?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemsCssClass'=>'partners-list',
	'itemView'=>'_view',
	'template'=>'{items}',
)); ?>
