<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'), 
)); ?>

    <?php echo $form->dropDownListControlGroup($model, 'type', Events::getTypes(), array('class'=>'span8', 'displaySize'=>1)); ?>

    <div class='control-group'>
        <?php echo CHtml::activeLabelEx($model, 'event_day'); ?>
        <?php $this->widget('application.extensions.datetimepicker.BJuiDateTimePicker', array(
            'model' => $model,
            'attribute' => 'event_day',
            'type' => 'datetime',
            'options' => array(
                'controlType' => 'select',
                'dateFormat'=>'dd-mm-yy',
            ),
        )); ?>
        <?php echo $form->error($model, 'event_day'); ?>
    </div>

	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>256)); ?>

	<div class='control-group'>
        <?php echo CHtml::activeLabelEx($model, 'image'); ?>
        <?php echo TbHtml::imageRounded($model->getThumb('medium')); ?><br>
        <?php echo $form->fileField($model,'image', array('class'=>'span8')); ?>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <?php echo $form->checkBoxControlGroup($model, 'preview_clickable'); ?>

	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'html_content'); ?>
		<?php $this->widget('admin_ext.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'html_content',
		)); ?>
		<?php echo $form->error($model, 'html_content'); ?>
	</div>

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
	<?php echo $form->dropDownListControlGroup($model, 'place_id', CHtml::listData(Places::model()->findAll(), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1)); ?>

	

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'public_date'); ?>
		<?php $this->widget('application.extensions.datetimepicker.BJuiDateTimePicker', array(
			'model' => $model,
			'attribute' => 'public_date',
			'type' => 'date',
			'options' => array(
				'controlType' => 'select',
                'dateFormat'=>'dd-mm-yy',
			),
		)); ?>
		<?php echo $form->error($model, 'public_date'); ?>
	</div>

    <?php echo $form->textFieldControlGroup($model,'meta_title',array('class'=>'span8', 'rows'=>10)); ?>
    <?php echo $form->textAreaControlGroup($model,'meta_description',array('class'=>'span8', 'rows'=>10)); ?>
    <?php echo $form->textAreaControlGroup($model,'meta_keywords',array('class'=>'span8', 'rows'=>6)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', Events::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Сохранить',
		)); ?>
		
		<?php if ( !$model->isNewRecord ): ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Посмотреть',
				'url'=>$model->viewUrl(),
				'htmlOptions'=>array('class'=>'f-iframe', 'data-fancybox-type'=>'iframe')
			)); ?>
		<?php endif; ?>
	</div>

		

<?php $this->endWidget(); ?>
