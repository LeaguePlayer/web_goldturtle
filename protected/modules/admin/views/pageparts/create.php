<?php
$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>