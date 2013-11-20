<?php

	$cs = Yii::app()->clientScript;
	$cs->registerCssFile($this->getAssetsUrl().'/css/style.css?v=6');
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
	$cs->registerScriptFile($this->getAssetsUrl().'/js/common.js?v=3', CClientScript::POS_END);
?><!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<meta name='yandex-verification' content='4606e8ea19a4c639' />
		<link id="favicon" type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
    	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
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
                    <div class="perspective">
                        <span class="logo"><img src="<?php echo $this->place['logo']; ?>" alt=""></span>
                    </div>
					<a href="<?php echo $this->createUrl('site/index', $getPlace); ?>"></a>
				</div>
                <div class="select_place">
                    <ul>
                        <?php foreach ( $this->allPlaces as $place ): ?>
                            <li <?if($place->id === $this->place['id']):?>class="current"<?endif;?>><a <?if($place->id !== $this->place['id']):?> href="<?=$place->getChangeUrl();?>"<? endif; ?>><?=$place->title;?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
				<div class="h-content">
					<ul class="main_menu">
                        <li <?php if ($this->currentPage == 'employees') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'employees') echo "href='".$this->createUrl('/employees/index', $getPlace)."'"; ?>>Команда</a></li>
                        <li class="separator"></li>
                        <li <?php if ($this->currentPage == 'ineriors') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'ineriors') echo "href='".$this->createUrl('/interiors/index', $getPlace)."'"; ?>>Фотографии</a></li>
                        <li class="separator"></li>
                        <li <?php if ($this->currentPage == 'partners') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'partners') echo "href='".$this->createUrl('/partners/index', $getPlace)."'"; ?>>Партнеры</a></li>
                        <li class="separator"></li>
                        <li <?php if ($this->currentPage == 'jobs') echo "class='current'"; ?>><a <?php if ($this->currentPage != 'jobs') echo "href='".$this->createUrl('/jobs/index', $getPlace)."'"; ?>>Вакансии</a></li>
					</ul>

					<div class="clear"></div>

					<ul class="action_menu">
                        <li><a class="menu" href="<?php echo $this->createUrl('/menu/index', $getPlace); ?>">Меню</a></li>
                        <li><a class="news" href="<?php echo Events::getNewsUrl($this->place); ?>">События</a></li>
                        <li><a class="reviews" href="<?php echo $this->createUrl('/reviews/index', $getPlace); ?>">Отзывы</a></li>
                        <li><a class="news" href="<?php echo Pages::getUrlByAlias('contacti'); ?>">Контакты</a></li>
						<li><a class="order fancybox-ajax" href="<?php echo $this->createUrl('/site/order') ?>">Забронировать столик</a></li>
					</ul>
				</div>
			</section>

			<?php if ( $this->is_home() and $this->sliderManager !== null ): ?>
			<?php Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl().'/js/lib/jquery.slides.min.js', CClientScript::POS_END); ?>
			<section class="slider">
				<div class="viewport-wrap">
					<div id="slides" style="display: none;" data-duration="<?php echo Settings::getOption('slider_duration'); ?>">
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
            <div class="content">
                <?php echo Pageparts::getContent(Pageparts::PART_TYPE_FOOTER, $this->place); ?>
            </div>
			<p class="amobile"><a href="http://amobile-studio.ru/"></a><span>Всегда только лучшие идеи</span></p>
		</footer>


		<!--LiveInternet counter--><script type="text/javascript"><!--
		document.write("<a href='http://www.liveinternet.ru/click' "+
		"target=_blank><img src='//counter.yadro.ru/hit?t39.6;r"+
		escape(document.referrer)+((typeof(screen)=="undefined")?"":
		";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
		screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
		";"+Math.random()+
		"' alt='' title='LiveInternet' "+
		"border='0' width='0' height='0'><\/a>")
		//--></script><!--/LiveInternet-->


		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
		(function (d, w, c) {
		    (w[c] = w[c] || []).push(function() {
		        try {
		            w.yaCounter22791595 = new Ya.Metrika({id:22791595,
		                    clickmap:true,
		                    trackLinks:true,
		                    accurateTrackBounce:true});
		        } catch(e) { }
		    });
		 
		    var n = d.getElementsByTagName("script")[0],
		        s = d.createElement("script"),
		        f = function () { n.parentNode.insertBefore(s, n); };
		    s.type = "text/javascript";
		    s.async = true;
		    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
		 
		    if (w.opera == "[object Opera]") {
		        d.addEventListener("DOMContentLoaded", f, false);
		    } else { f(); }
		})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/22791595" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->


	</body>
</html>