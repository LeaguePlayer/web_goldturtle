<?php
$this->menu=array(
	array('label'=>'Список', 'url'=>array('list')),
);
?>

<h1>Редактирование</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>