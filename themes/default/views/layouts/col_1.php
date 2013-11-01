<?php /* @var $this Controller */ ?>

<?php if ( !isset($this->clips['l_sidebar']) ): ?>
<?php $this->beginClip('l_sidebar'); ?>
	<?php $this->widget('application.extensions.map.YandexMapWidget'); ?>
    <?php $this->widget('application.extensions.face.FaceOfDayWidget'); ?>

    <?php
        $getPlace = ( $this->place['alias'] !== 'restourant' ) ? array('place'=>$this->place['alias']) : array();
    ?>
<?php $this->endClip(); ?>
<?php endif; ?>


<?php $this->beginContent('//layouts/main'); ?>

<div id="layout" class="fix-width">
	<!-- <begin Left Side> -->

	<aside class="l_side">
		<?php echo $this->clips['l_sidebar'];?>
	</aside>
	<!-- <end Left Side> -->

    <div class="content-box">
        <?php echo Pageparts::getContent(Pageparts::PART_TYPE_CONTENT_BOX); ?>
    </div>
    <div>
        <section class="content col_1">
            <?php echo $content; ?>
        </section>


        <aside class="r_side">
            <?php echo $this->clips['r_sidebar'];?>
        </aside>
        <div class="clear"></div>
    </div>
</div>

<?php $this->endContent(); ?>