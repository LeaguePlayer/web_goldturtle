<?php

	$cs = Yii::app()->clientScript;
	$cs->registerCssFile($this->getAssetsUrl().'/css/style.css');
	$cs->registerCssFile($this->getAssetsUrl().'/css/adipoli.css');
	$cs->registerCssFile($this->getAssetsUrl().'/css/fancybox/jquery.fancybox.css');
	$cs->registerCssFile($this->getAssetsUrl().'/css/jquery.ui/overcast/jquery-ui-1.10.3.custom.min.css');
	//$cs->registerCssFile($this->getAssetsUrl().'/css/fancybox/jquery.fancybox-buttons.css');
	
	$cs->registerCoreScript('jquery');
	$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.stalactite.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.fancybox.js', CClientScript::POS_END);
	//$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.fancybox-buttons.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.adipoli.min.js', CClientScript::POS_END);
	$cs->registerScriptFile('http://api-maps.yandex.ru/2.0.27/?load=package.standard&lang=ru-RU', CClientScript::POS_HEAD);
	$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.adipoli.min.js', CClientScript::POS_END);
	
	$cs->registerCoreScript('jquery.ui');
	
	$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.timepicker.addon.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.ui.timepicker.ru.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl().'/js/common.js', CClientScript::POS_END);
?><!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $this->title; ?></title>
		<!--[if IE]>
	    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        
	    <![endif]-->
	</head>
	<body <?php $this->is_home() ? print 'class="background"' : print '';?>>
		<header id="header" class="<?php if ($this->currentPage == 'main') echo 'h_main'; ?>">
			<section class="fix-width top">
                <?php
                    $getPlace = ( $this->place['alias'] !== 'restourant' ) ? array('place'=>$this->place['alias']) : array();
                ?>
				<div class="logo_container">
                    <span class="logo"><img src="<?php echo $this->place['logo']; ?>" alt=""></span>
					<a href="<?php echo $this->createUrl('site/index', $getPlace); ?>"></a>
				</div>
				<div class="h-content">
					<div class="city gray">Тюмень</div>

					<ul class="main_menu">
						<li <?php if ($this->currentPage == 'main') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'main') echo "href='".$this->createUrl('site/index', $getPlace)."'"; ?>>Главная</a></li>
						<li class="separator"></li>
						<li <?php if ($this->currentPage == 'about') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'about') echo "href='".Pages::getUrlByAlias('about')."'"; ?>>О нас</a></li>
						<li class="separator"></li>
						<li <?php if ($this->currentPage == 'contacti') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'contacti') echo "href='".Pages::getUrlByAlias('contacti')."'"; ?>>Контакты</a></li>
						<li class="separator"></li>
						<li <?php if ($this->currentPage == 'jobs') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'jobs') echo "href='".$this->createUrl('/jobs/index', array('place'=>$this->place['alias']))."'"; ?>>Вакансии</a></li>
						<li class="separator"></li>
						<li <?php if ($this->currentPage == 'banners') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'banners') echo "href='".Banners::listUrl()."'"; ?>>Реклама</a></li>
						<li class="separator"></li>
						<li <?php if ($this->currentPage == 'partners') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'partners') echo "href='".$this->createUrl('/partners/index', $getPlace)."'"; ?>>Партнеры</a></li>
					</ul>

					<div class="clear"></div>

					<ul class="action_menu">
						<li><a class="room" href="<?php echo $this->createUrl('/site/place'); ?>">Выбор зала</a></li>
						<li><a class="news" href="<?php echo Events::getNewsUrl($this->place); ?>">Новости</a></li>
						<li><a class="chronic" href="<?php echo Events::getChroniclesUrl($this->place); ?>">Светская хроника</a></li>
						<li><a class="order fancybox-ajax" href="<?php echo $this->createUrl('/site/order', array('place'=>$this->place['alias'])) ?>">Забронировать столик</a></li>
					</ul>

					<ul class="socials">
						<!-- <li><a class="twitter" href="#" target="_blank"></a></li> -->
						<li><a class="facebook" href="https://www.facebook.com/pages/Ресторан-Бар-Золотая-Черепаха/344894012283405" target="_blank"></a></li>
						<li><a class="vkontakte" href="http://vk.com/zolotayacherepaha" target="_blank"></a></li>
					</ul>
				</div>
			</section>

			<?php if ( $this->is_home() and $this->sliderManager !== null ): ?>
			<?php Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.slides.min.js', CClientScript::POS_END); ?>
			<section class="slider">
				<div class="viewport-wrap">
					<div id="slides" style="display: none;">
						<?php foreach ($this->sliderManager->galleryPhotos as $slide): ?>
							<img src="<?php echo $slide->getPreview('big'); ?>">
						<?php endforeach; ?>
					</div>
				</div>
			</section>
			<?php endif; ?>
		</header>

		<?php echo $content;?>
		
		<?php if ( $this->renderYandexMap ): ?>
			<?php //$cs->registerCssFile($this->getAssetsUrl().'/css/print_map.css', 'print'); ?>
			<?php $cs->registerScriptFile($this->getAssetsUrl().'/js/print_block.js', CClientScript::POS_END); ?>
			<section id="map"></section>
			<div class="map_actions fix-width">
				<h1 class="title">Добро пожаловать и приятного аппетита!</h1>
				<a href="#" class="print_map printBlock" data-target_selector="#map">Напечатать карту</a>
			</div>
		<?php endif; ?>

		<footer id="footer" class="fix-width center">
			<p class="reserved">(с) Ресторан Золотая Черепаха</p>
			<ul class="f_menu">
				<li><a href="/">Главная</a></li>
				<li><a href="<?php echo Pages::getUrlByAlias('about', $this->place); ?>">О нас</a></li>
				<li><a href="<?php echo Pages::getUrlByAlias('contacti', $this->place); ?>">Контакты</a></li>
				<li><a href="<?php echo Banners::listUrl($this->place); ?>">Реклама</a></li>
				<li><a href="<?php echo $this->createUrl('/partners/index', array('place'=>$this->place['alias'])); ?>">Партнеры</a></li>
			</ul>
			<ul class="socials">
				<!-- <li><a class="twitter" href="#" target="_blank"></a></li> -->
				<li><a class="facebook" href="https://www.facebook.com/pages/Ресторан-Бар-Золотая-Черепаха/344894012283405" target="_blank"></a></li>
				<li><a class="vkontakte" href="http://vk.com/zolotayacherepaha" target="_blank"></a></li>
			</ul>
			<p class="amobile"><a href="http://amobile-studio.ru/"></a><span>Всегда только лучшие идеи</span></p>
		</footer>
	</body>
</html>