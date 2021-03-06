<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'dishes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>256)); ?>

	<?php echo $form->textAreaControlGroup($model,'description',array('class'=>'span8','maxlength'=>256)); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'gallery'); ?>
		<?php if ($model->galleryManager->getGallery() === null) {
			echo '<p class="help-block">Прежде чем загружать изображения, нужно сохранить текущее состояние</p>';
		} else {
			$this->widget('admin_ext.imagesgallery.GalleryManager', array(
				'gallery' => $model->galleryManager->getGallery(),
				'controllerRoute' => '/admin/gallery',
			));
		} ?>
	</div>

    <?php echo $form->textFieldControlGroup($model,'meta_title',array('class'=>'span8', 'rows'=>10)); ?>
    <?php echo $form->textAreaControlGroup($model,'meta_description',array('class'=>'span8', 'rows'=>10)); ?>
    <?php echo $form->textAreaControlGroup($model,'meta_keywords',array('class'=>'span8', 'rows'=>6)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'place_id', CHtml::listData(Places::model()->findAll(), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', Dishes::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
