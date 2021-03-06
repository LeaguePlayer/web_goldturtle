<div class="form order">
    
    <?php if (Yii::app()->user->hasFlash('SUCCESS_ORDER')): ?>
    	<div class="successMessage"><?php echo Yii::app()->user->getFlash('SUCCESS_ORDER'); ?></div>
    	<?php Yii::app()->end(); ?>
    <?php endif; ?>
    
    <h2>Бронирование столика</h2>
		
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'order-form',
		'enableClientValidation'=>false,
	)); ?>

		<div class="row">
			<?php echo $form->label($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array(
				'placeholder' => 'Имя',
			)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>

		<div class="row">
			<?php echo $form->label($model, 'phone'); ?>
			<?php echo $form->textField($model, 'phone', array(
				'placeholder' => 'Телефон',
			)); ?>
			<?php echo $form->error($model, 'phone'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->label($model, 'date'); ?>
			<?php echo $form->textField($model, 'date', array(
				'placeholder' => 'Дата',
			)); ?>
			<?php echo $form->error($model, 'date'); ?>
		</div>

		<div class="button-row">
			<button class="custom-button" type="submit">Забронировать</button>
		</div>

	<?php $this->endWidget(); ?>
</div>
