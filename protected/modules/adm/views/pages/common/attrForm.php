<?php
/**
 * Генерация формы для редактирования с поддержкой yii-валидации на jQuery
 */
$form = $this->beginWidget('CActiveForm', array(
        'id'=>'wform',
		'htmlOptions'=>array('class'=>'write'),
		'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
		'clientOptions' => array('validateOnSubmit'=>true, 'validateOnChange'=>false)
));

$labels = $model->attributeLabels();
$errors = $model->getErrors();
$modelName = get_class($model);
$maxlengths = array('date'=>10);

if ($model->isNewRecord) {
	$attributes = array();
	foreach (array_keys($model->getMetaData()->columns) as $name)
		$attributes[$name] = $model->getAttribute($name);
} else {
	$attributes = $model->attributes;
}

foreach ($attributes as $name=>$value)
{
	if ($model->isAttributeSafe($name)) {
		echo '
		<div class="group">
			<div><label>', $labels[$name], '</div>
			<div>';

		if (!empty($errors[$name])) {
			$error = is_array($errors[$name]) ? reset($errors[$name]) : $errors[$name];
		} else
			$error = '';
		
		// Выбор элемента для ввода в зависимости от переданных параметров
		if (isset($lists['select'][$name])) {
			echo '
				<select name="', $modelName, '[', $name, ']">';
			foreach ($lists['select'][$name] as $v=>$text)
				echo '
					<option value="', $v, (($v == $value) ? '" selected="selected">' : '">'), $text, '</option>';
			echo '
				</select>';

		} else {
			$maxlength = $model->tableSchema->columns[$name]->size ? $model->tableSchema->columns[$name]->size : $maxlengths[$model->tableSchema->columns[$name]->dbType];
			echo '
				<input type="text" id="', "{$modelName}_$name", '" name="', $modelName, '[', $name, ']" value="', htmlspecialchars($value), '"', ' maxlength="',  $maxlength, '">';
		}

		echo '	
				<span class="error-wrapper">', $form->error($model, $name, array('class' =>'error', 'errorCssClass'=>'', 'successCssClass'=>'', 'validatingCssClass'=>'error')), '</span>
			</div>
		</div>';
	
	}
}	
	echo '
		<div class="group last">
			<div></div>
			<div>
				<input type="submit" value="', ($model->isNewRecord ? 'Add' : 'Save'), '">
				&nbsp;&nbsp;
				<a href="', $this->createUrl("$this->id/$this->defaultAction"), '">Cancel</a>
			</div>
		</div>';
	
$this->endWidget();
?> 