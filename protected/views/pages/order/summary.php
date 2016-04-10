<?php
/**
 * Резюме по сделанному заказу
 */
$labels = $model->attributeLabels();
?>
<div class="wrapper">
	<div class="logo">
		<img src="/i/coin-logo.png" alt="" />
		<h1><?php echo "{$this->pageTitle} &ndash; Order Summary" ?></h1>
	</div>
	
	<div class="order-form-wrapper">
		<div class="order-summary"><?php
		
			echo '
			<div class="group"><b>Thanks for your purchase!</b></div>
			
			<div class="group">
				<div>Order #</div>
				<div>		
					', $model->id, '
				</div>
			</div>			
			
			<div class="group">
				<div>', $labels['prod_id'], '</div>
				<div>		
					', $model->product->name, '
				</div>
			</div>
			
			<div class="group">
				<div>', $labels['amount'], '</div>
				<div>		
					', $model->amount, ' ', $model->payCurrencies[$model->pay_curr]['name'], '
				</div>
			</div>
			
			<div class="group">
				<div>', $labels['pay_type'], '</div>
				<div>		
					', $model->payTypes[$model->pay_type], '
				</div>
			</div>';

			
			// Арибуты покупателя
			$userAttr = $model->user->getAttributes();
			$labels = $model->user->attributeLabels();
			unset($userAttr['id']);
			foreach ($userAttr as $name=>$value) {
				echo '
				<div class="group">
					<div>', $labels[$name], '</div>
					<div>
						', $value, '
					</div>
				</div>';
			}
	?> 
		</div>
	</div>
</div>