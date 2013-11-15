<?php
$this->breadcrumbs=array(
	"Фотографии"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Добавление альбома</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>