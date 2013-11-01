<?php ?>


<?php $this->beginClip('r_sidebar'); ?>
	<?php $this->widget('application.extensions.reviews.ReviewsWidget'); ?>
<?php $this->endClip(); ?>



<?php echo $this->renderPartial( '_news', array('dataProvider' => Events::lastNews($this->place['id'])) ); ?>
<?php echo $this->renderPartial( '_chronicles', array('dataProvider' => Events::lastChronicles($this->place['id'])) ); ?>