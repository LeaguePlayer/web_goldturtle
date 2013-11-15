<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pageparts-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->dropDownListControlGroup($model,'type', Pageparts::getPartTypes(), array('class'=>'span8', 'empty' => 'Не задано', 'displaySize'=>1)); ?>

    <?php echo $form->dropDownListControlGroup($model, 'place_id', CHtml::listData(Places::model()->findAll(), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Не задано')); ?>

	<div class='control-group'>
        <?php echo CHtml::activeLabelEx($model, 'content'); ?>
        <?php $this->widget('admin_ext.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'content',
        )); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
