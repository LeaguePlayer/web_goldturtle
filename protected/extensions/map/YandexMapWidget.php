<?php

class YandexMapWidget extends CWidget
{
    protected $address;

    public function init()
    {
        $this->address = Settings::getOption('address');
        return true;
    }

    protected function registerScripts()
    {
        Yii::app()->clientScript->registerScript('yandexmap', "
            $(document).ready(function() {
				ymaps.ready(function () {
					var myMap;
					// Создание экземпляра карты и его привязка к созданному контейнеру.
					ymaps.geocode('".$this->address."', {
						results: 1
					}).then(function (res) {
						var firstGeoObject = res.geoObjects.get(0);
						myMap = new ymaps.Map('map-mini', {
							center: firstGeoObject.geometry.getCoordinates(),
							zoom: 16,
							behaviors: ['default']
						});

						// Создание метки с пользовательским макетом балуна.
						var myPlacemark = window.myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
							addres: $('#address').text(),
							balloonContentHeader: 'Адрес',
            				balloonContentBody: $('#address').text(),
						}, {
							iconImageHref: '".$this->owner->getAssetsUrl()."/img/marker.png',
							// Не скрываем иконку при открытом балуне.
							// hideIconOnBalloonOpen: false,
							// И дополнительно смещаем балун, для открытия над иконкой.
							//balloonOffset: [9, -40]
						});

						myMap.geoObjects.add(myPlacemark);
					});
				});
			});
        ", CClientScript::POS_END);
    }

    public function run()
    {
        $this->registerScripts();
        $this->render('map', array('address'=>$this->address));
    }
}