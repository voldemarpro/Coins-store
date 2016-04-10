<?php
class OrderForm extends CFormModel
{
	public $user; 
	public $order;
	public $products;

	public function init()
	{
		$this->user = new User;
		$this->order = new Order;
		$this->products = Product::model()->findAll(
			array('condition'=>'`archive`=0', 'index'=>'id')
		);
	}

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		// Правила валидации берем из моделей для покупателя и заказа
		$rules = array_merge($this->user->rules(), $this->order->rules());
		
		foreach ($rules as $i=>$rule)
			if (in_array('id', explode(',', $rule[0])) || $rule[1] == 'safe')
				unset ($rules[$i]);
		
		return $rules;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array_merge(
			$this->user->attributeLabels(),
			$this->order->attributeLabels()
		);
	}

}
