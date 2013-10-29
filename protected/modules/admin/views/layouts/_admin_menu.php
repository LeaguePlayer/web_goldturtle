<?php

$menuItems = array(
    array('label'=>'Настройки', 'url'=>'/admin'),
    array('label'=>'Разделы', 'url'=>'#', 'items' => array(
        array('label'=>'Помещения', 'url'=>'#', 'items' => array(
            array('label'=>'Создать', 'url'=>"/admin/places/create"),
            array('label'=>'Список', 'url'=>"/admin/places/list"),
        )),
        array('label'=>'Слайдер', 'url'=>'#', 'items' => array(
            array('label'=>'Создать', 'url'=>"/admin/slider/create"),
            array('label'=>'Список', 'url'=>"/admin/slider/list"),
        )),
        array('label'=>'Сотрудники', 'url'=>'#', 'items' => array(
            array('label'=>'Создать', 'url'=>"/admin/employees/create"),
            array('label'=>'Список', 'url'=>"/admin/employees/list"),
        )),
        array('label'=>'Новости', 'url'=>'#', 'items' => array(
            array('label'=>'Создать', 'url'=>"/admin/events/create"),
            array('label'=>'Список', 'url'=>"/admin/events/list"),
        )),
        array('label'=>'Реклама', 'url'=>'#', 'items' => array(
            array('label'=>'Создать', 'url'=>"/admin/banners/create"),
            array('label'=>'Список', 'url'=>"/admin/banners/list"),
        )),
        array('label'=>'Меню', 'url'=>'#', 'items' => array(
            array('label'=>'Добавить', 'url'=>"/admin/menu/create"),
            array('label'=>'Список', 'url'=>"/admin/menu/list"),
        )),
        array('label'=>'Блюда', 'url'=>'#', 'items' => array(
            array('label'=>'Добавить', 'url'=>"/admin/dishes/create"),
            array('label'=>'Список', 'url'=>"/admin/dishes/list"),
        )),
        array('label'=>'Вакансии', 'url'=>'#', 'items' => array(
            array('label'=>'Добавить', 'url'=>"/admin/jobs/create"),
            array('label'=>'Список', 'url'=>"/admin/jobs/list"),
        )),
        array('label'=>'Партнеры', 'url'=>'#', 'items' => array(
            array('label'=>'Добавить', 'url'=>"/admin/partners/create"),
            array('label'=>'Список', 'url'=>"/admin/partners/list"),
        )),
        array('label'=>'Интерьер', 'url'=>'#', 'items' => array(
            array('label'=>'Добавить', 'url'=>"/admin/interiors/create"),
            array('label'=>'Список', 'url'=>"/admin/interiors/list"),
        )),
        array('label'=>'Страницы', 'url'=>'#', 'items' => array(
            array('label'=>'Создать', 'url'=>"/admin/pages/create"),
            array('label'=>'Список', 'url'=>"/admin/pages/list"),
        )),
        array('label'=>'Отзывы', 'url'=>'#', 'items' => array(
            array('label'=>'Добавить', 'url'=>"/admin/reviews/create"),
            array('label'=>'Список', 'url'=>"/admin/reviews/list"),
        )),
    )),
    array('label'=>'Метаданные страниц', 'url'=>'/admin/metadata/list'),
);

/*
$menuItems = array(
    array('label'=>'Настройки', 'url'=>'/admin'),
    array('label'=>'Разделы', 'url'=>'#', 'items' => array(
        array('label'=>'Сотрудники', 'url'=>"/admin/employees/list"),
        array('label'=>'Новости', 'url'=>"/admin/events/list"),
        array('label'=>'Рестораны', 'url'=>"/admin/places/list"),
        array('label'=>'Слайдер', 'url'=>"/admin/slider/list"),
        array('label'=>'Страницы', 'url'=>"/admin/pages/list"),
        array('label'=>'Реклама', 'url'=>"/admin/banners/list"),
        array('label'=>'Отзывы', 'url'=>"/admin/reviews/list"),
        array('label'=>'Меню', 'url'=>"/admin/menu/list"),
        array('label'=>'Блюда', 'url'=>"/admin/dishes/list"),
        array('label'=>'Вакансии', 'url'=>"/admin/jobs/list"),
        array('label'=>'Партнеры', 'url'=>"/admin/partners/list"),
        array('label'=>'Интерьер', 'url'=>"/admin/interiors/list"),
    )),
);
*/
?>
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'color'=>'inverse', // null or 'inverse'
    'brandLabel'=> CHtml::encode(Yii::app()->name),
    'brandUrl'=>'/',
    'fluid' => true,
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>$menuItems,
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Выйти', 'url'=>'/admin/user/logout'),
            ),
        ),
    ),
)); ?>