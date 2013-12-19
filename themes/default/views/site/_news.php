<?php
/* @var $this EventsController */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="topics news">
	<a href="<?php echo $dataProvider->model->getNewsUrl($this->place); ?>" class="action">Показать все новости</a>
	<h2 class="caption"><?php echo $this->place['alias'] === 'bar' ? 'Новости бара' : 'Новости ресторана' ?></h2>
	<div class="clear"></div>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_event_view',
		'template'=>'{items}',
		'emptyText'=>'Нет новостей'
	)); ?>
</div>