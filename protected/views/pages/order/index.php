<?php
/**
 * Визуализация формы для заказа
 */

$labels = $model->attributeLabels();
$modelName = get_class($model);
$products = array();
$htmlErrOpts = array('class' =>'error', 'errorCssClass'=>'', 'successCssClass'=>'', 'validatingCssClass'=>'error');

?>
<div class="wrapper">
	<div class="logo">
		<img src="/i/coin-logo.png" alt="" />
		<h1><?php echo "{$this->pageTitle} &ndash; Order" ?></h1>
	</div>
	
	<div class="order-form-wrapper"><?php
		
		$form = $this->beginWidget('CActiveForm', array(
				'id'=>'wform',
				'action'=>"/{$this->id}/create",
				'htmlOptions'=>array('class'=>'order-form'),
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'clientOptions' => array('validateOnSubmit'=>true, 'validateOnChange'=>false)
		));		
		
		echo '
			<p>Note: all fields are required</p>
			
			<div class="group">
				<div><label>', $labels['prod_id'], '</label></div>
				<div>
					<select name="', $modelName, '[', get_class($model->order), '][prod_id]">';
					
					foreach ($model->products as $val) {
						echo '
						<option value="', $val['id'], '">', $val['name'], '</option>';
						
						$products[$val['id']] = $val->attributes;
					}
		echo '			
					</select>	
				</div>
			</div>
			
			
			<div class="group">
				<div><label>', $labels['pay_curr'], '</label></div>
				<div>
					<p>';
					
					foreach ($model->order->payCurrencies as $i=>$val)
						echo '
						<label for="pay_curr_', $i, '"><input type="radio" id="pay_curr_', $i, '" name="', $modelName, '[', get_class($model->order), '][pay_curr]" value="', $i, '"', ($i ? '' : ' checked="checked"'), '/>', $val['name'], '</label>';
		echo '
					</p>
				</div>
			</div>';
			
		// Поля для атрибутов покупателя
		$userAttr = $model->user->getAttributes();
		$errors = $model->user->getErrors();
		unset($userAttr['id']);
		foreach ($userAttr as $name=>$value) {
			echo '
			<div class="group">
				<div><label>', $labels[$name], '</label></div>
				<div>
					<input type="text" id="', get_class($model->user), '_', $name, '" name="', $modelName, '[', get_class($model->user), '][', $name, ']" value="', htmlspecialchars($value), '" />	
					', $form->error($model->user, $name, $htmlErrOpts), '</span>
				</div>
			</div>';
		}
		
		// Поля для атрибутов оплаты заказа (кредитная/дебитовая карта)
		$payAttr = $model->order->getAttributes();
		$payNotes = $model->order->payNotes();
		$errors = $model->order->getErrors();
		echo '
			<div class="group">
				<div></div>
				<div>
					<p><img src="/i/visa_mcard.png" border="0" /></p>
				</div>
			</div>';
		
		foreach ($payAttr as $name=>$value) {
			if (substr($name, 0, 4) == 'card') { 
				echo '
				<div class="group">
					<div><label>', $labels[$name], '</label></div>
					<div>
						<input type="text" id="', get_class($model->order), '_', $name, '" name="', $modelName, '[', get_class($model->order), '][', $name, ']" value="', htmlspecialchars($value), '" />	
						', $form->error($model->order, $name, $htmlErrOpts), '</span>
						', (isset($payNotes[$name]) ? "<small>{$payNotes[$name]}</small>": ''), '
					</div>
				</div>';
			}
		}
		
		echo '
			<div class="group">
				<div><label><b>Order Total</b></label></div>
				<div>
					<p>
						<strong id="order_total"></strong>
					</p>
				</div>
			</div>
			<div class="group last">
				<div></div>
				<div>
					<input type="submit" value="Order Now" />
				</div>
			</div>';
			
		$this->endWidget();
	?> 	
	</div>
	
	<script type="text/javascript">
		if (window.store) {
			var coinsStore = new store({
				prodCtrl: $('select'), 
				currCtrl: $(':radio'),
				amountCtrl: $('#order_total'),
				payCurrencies: $.parseJSON('<?php echo json_encode($model->order->payCurrencies, JSON_FORCE_OBJECT) ?>'),
				products: $.parseJSON('<?php echo json_encode($products, JSON_FORCE_OBJECT) ?>')
			});
		}
		$('[type=text]').last().datepicker();
	</script>
</div>