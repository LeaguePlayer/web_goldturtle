<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'metadata-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->textFieldControlGroup($model, 'title',array('class'=>'span8','maxlength'=>256)); ?>

    <?php echo $form->textFieldControlGroup($model, 'meta_title',array('class'=>'span8','maxlength'=>256)); ?>

	<?php //echo $form->dropDownListControlGroup($model,'post_type', Metadata::getPostTypes(), array('class'=>'span8', 'empty' => 'Не задано', 'displaySize'=>1)); ?>

	<?php echo $form->textAreaControlGroup($model,'meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaControlGroup($model,'meta_keywords',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
