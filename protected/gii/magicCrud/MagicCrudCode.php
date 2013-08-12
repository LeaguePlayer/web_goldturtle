<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class MagicCrudCode extends CrudCode
{	
	public $baseAdminControllerClass='AdminController';

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter'=>'trim'),
			array('model, controller, baseControllerClass, baseAdminControllerClass', 'required'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass, baseAdminControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
			array('baseControllerClass, baseAdminControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('model', 'validateModel'),
			array('baseControllerClass, baseAdminControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'baseControllerClass'=>'Base Controller Class',
			'adminController'=>'Контроллер админки',
			'baseAdminControllerClass'=>'Базовый класс контроллера админки',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		return "The controller has been generated successfully. You may $link.";
	}
	
	public function getAdminControllerFile()
	{
		if(($module=Yii::app()->getModule('admin'))===null)
			return false;
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}
	
	public function getAdminViewPath()
	{
		return Yii::app()->getModule('admin')->getViewPath().'/'.$this->getControllerID();
	}
	
	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				$this->files[]=new CCodeFile(
					$this->viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		}
		
		$adminTemplatePath = $templatePath.DIRECTORY_SEPARATOR.'admin';
		$adminControllerTemplateFile=$adminTemplatePath.DIRECTORY_SEPARATOR.'controller.php';
		$this->files[]=new CCodeFile(
			$this->adminControllerFile,
			$this->render($adminControllerTemplateFile)
		);
		$adminFiles = scandir($adminTemplatePath);
		foreach($adminFiles as $file)
		{
			if(is_file($adminTemplatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				$this->files[]=new CCodeFile(
					$this->adminViewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($adminTemplatePath.'/'.$file)
				);
			}
		}
	}
	
	public function generateActiveRow($modelClass, $column)
	{
		if ( $column->name === 'sort' ) {
			return;
		}
		if (stripos($column->dbType, 'time')) {
			$genRow = "<div class='control-group'>\n";
			$genRow .= "\t\t<?php echo CHtml::activeLabelEx(\$model, '{$column->name}'); ?>\n";
			$genRow .= "\t\t<?php \$this->widget('admin.extensions.yiiwheels.widgets.datepicker.WhDatePicker', array(
			'model' => '\$model',
			'attribute' => '{$column->name}',
			'pluginOptions' => array(
				'format' => 'mm.dd.yyyy'
			)
		)); ?>\n";
			$genRow .= "\t\t<?php echo \$form->error(\$model, '{$column->name}'); ?>\n";
			$genRow .= "\t</div>\n";
			return $genRow;
		}
		if ($column->name === 'image') {
			$genRow = "<div class='control-group'>\n";
			$genRow .= "\t\t<?php echo CHtml::activeLabelEx(\$model, '{$column->name}'); ?>\n";
			$genRow .= "\t\t<?php echo TbHtml::imageRounded(\$model->getThumb('medium')); ?><br>\n";
			$genRow .= "\t\t<?php echo \$form->fileField(\$model,'{$column->name}', array('class'=>'span8')); ?>\n";
			$genRow .= "\t\t<?php echo \$form->error(\$model, '{$column->name}'); ?>\n";
			$genRow .= "\t</div>\n";
			return $genRow;
		}
		if (stripos($column->name, 'gallery') !==false) {
			$genRow = "<div class='control-group'>\n";
			$genRow .= "\t\t<?php echo CHtml::activeLabelEx(\$model, '{$column->name}'); ?>\n";
			$genRow .= "\t\t<?php if (\$model->galleryManager->getGallery() === null) {
			echo '<p class=\"help-block\">Прежде чем загружать изображения, нужно сохранить текущее состояние</p>';
		} else {
			\$this->widget('admin_ext.imagesgallery.GalleryManager', array(
				'gallery' => \$model->galleryManager->getGallery(),
				'controllerRoute' => '/admin/gallery',
			));
		} ?>\n";
			$genRow .= "\t</div>\n";
			return $genRow;
		}
		if ($column->name === 'status')
			return "<?php echo \$form->dropDownListControlGroup(\$model, 'status', {$modelClass}::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>";
		if ($column->type === 'boolean')
			return "<?php echo \$form->checkBoxControlGroup(\$model,'{$column->name}'); ?>\n";
		if (stripos($column->dbType,'text') !== false) {
			if ( stripos($column->name, 'html') === 0) {
				$genRow = "<div class='control-group'>\n";
				$genRow .= "\t\t<?php echo CHtml::activeLabelEx(\$model, '{$column->name}'); ?>\n";
				$genRow .= "\t\t<?php \$this->widget('admin_ext.ckeditor.CKEditorWidget', array('model' => \$model, 'attribute' => '{$column->name}',\n";
				$genRow .= "\t\t)); ?>\n";
				$genRow .= "\t\t<?php echo \$form->error(\$model, '{$column->name}'); ?>\n";
				$genRow .= "\t</div>\n";
				return $genRow;
			} else {
				return "<?php echo \$form->textAreaControlGroup(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>\n";
			}
		}
		if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
			$inputField='passwordFieldControlGroup';
		else
			$inputField='textFieldControlGroup';

		if ($column->type!=='string' || $column->size===null)
			return "<?php echo \$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span8')); ?>\n";
		else
			return "<?php echo \$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span8','maxlength'=>$column->size)); ?>\n";
	
		
		if ($column->name === 'status')
			return "<?php echo \$form->dropDownListControlGroup(\$model, 'status', {$modelClass}::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>";
	}
	
	
	public function generateGridColumn($modelClass, $column)
	{
		if ( $column->autoIncrement)
			return '';
		if ( stripos($column->dbType, 'time') or $column->name === 'create_time' or $column->name === 'update_time' ) {
			$genColumn = "\t\tarray(\n".
				"\t\t\t'name'=>'{$column->name}',\n".
				"\t\t\t'type'=>'raw',\n";
			if ( $column->name === 'create_time' or $column->name === 'update_time' ) {
				$genColumn .= "\t\t\t'value'=>'SiteHelper::russianDate(\$data->{$column->name}).\' в \'.date(\'H:i\', \$data->{$column->name})'\n";
			} else {
				$genColumn .= "\t\t\t'value'=>'SiteHelper::russianDate(\$data->{$column->name})'\n";
			}
			$genColumn .= "\t\t),\n";
			return $genColumn;
		}
		if ( $column->name === 'image' ) {
			return "\t\tarray(\n".
				"\t\t\t'header'=>'Фото',\n".
				"\t\t\t'type'=>'raw',\n".
				"\t\t\t'value'=>'TbHtml::imageRounded(\$data->getThumb(\"small\"))'\n".
			"\t\t),\n";
		}
		if ( $column->name === 'status' ) {
			return "\t\tarray(\n".
				"\t\t\t'name'=>'status',\n".
				"\t\t\t'type'=>'raw',\n".
				"\t\t\t'value'=>'{$modelClass}::getStatusAliases(\$data->status)',\n".
				"\t\t\t'filter'=>array({$modelClass}::getStatusAliases())\n".
			"\t\t),\n";
		}
		if ( $column->dbType === 'text' ) {
			return '';
		}
		
		return "\t\t'".$column->name."',\n";
	}
	
	public function existUploadableColumns()
	{
		foreach ( $this->tableSchema->columns as $column ) {
			if ( $column->name === 'image' ) {
				return true;
			}
		}
		return false;
	}
}
