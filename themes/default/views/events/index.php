<?php
/* @var $this EventsController */
/* @var $dataProvider CActiveDataProvider */
/* @var $type const */
?>


<ul class="event_switcher">
    <li class="<?php if ($type == Events::TYPE_NEWS) echo "current "; ?>news">
        <a <?php if ($type != Events::TYPE_NEWS): ?>href="<?=Events::getNewsUrl($this->place);?>"<?php endif; ?>><?php echo $this->place['alias'] === 'bar' ? 'Новости бара' : 'Новости ресторана' ?></a>
    </li>
    <li class="<?php if ($type == Events::TYPE_CHRONICLE) echo "current "; ?>chronicle">
        <a <?php if ($type != Events::TYPE_CHRONICLE): ?>href="<?=Events::getChroniclesUrl($this->place);?>"<?php endif; ?>>Светская хроника</a>
    </li>
</ul>


<?php if ($type == Events::TYPE_NEWS): ?>
<!--<h1 class="title">Новости ресторана</h1>-->
<?php else: ?>
<!--<h1 class="title">Светская хроника</h1>-->
<?php endif; ?>

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
