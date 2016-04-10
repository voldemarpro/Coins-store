<?php
class Order extends CActiveRecord
{
	/**
	 * Регулярное выражение для номера карты VISA
	 * @const string PATT_VISA
	 */	
	const PATT_VISA = '^4[0-9]{12}(?:[0-9]{3})?$';
	/**
	 * Регулярное выражение для номера карты MasterCard
	 * @const string PATT_MCARD
	 */		
	const PATT_MCARD = '^5[1-5][0-9]{14}$';
	
	const PAY_VISA = 0;
	const PAY_MCARD = 1;
	
	/**
	 * Способы оплаты
	 * @var array $payTypes
	 */	
	public $payTypes = array('VISA', 'MasterCard');
	
	public $payCurrencies = array(
		0 => array('name'=>'USD', 'factor'=>1),
		1 => array('name'=>'RUB', 'factor'=>70)
	);
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orders}}';
	}
	
	public function init() {
		parent::init();
		
		$this->date_time = date('Y-m-d H:i:s');
		$this->pay_curr = 0;
	}
	
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('amount, pay_type, pay_sum, prod_id, user_id, card_number, card_code, card_valid_thru', 'required'),
			array('card_number', 'match', 'allowEmpty'=>false, 'pattern'=>'/('.self::PATT_VISA.'|'.self::PATT_MCARD.')/'),
			array('card_code', 'numerical', 'min'=>100, 'max'=>999),
			array('id, user_id, pay_curr, date_time, card_number, card_code', 'safe', 'on'=>'insert')
		);
	}

	/**
	 * @return array Массив с описанием связей
	 */
	public function relations()
	{
		return array(
			'user'  => array(self::BELONGS_TO, 'User', 'user_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'prod_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => '#',
			'date_time' => 'Date Time',
			'user_id' => 'User',
			'prod_id' => 'Product',
			'amount' => 'Order Total',
			'pay_type' => 'Pay Type',
			'pay_sum' => 'Amount Paid',
			'pay_curr' => 'Currency',
			'card_number' => 'Card Number',
			'card_code' => 'CVV/CVC',
			'card_valid_thru' => 'Expiration date'
		);
	}
	
	public function payNotes()
	{
		return array(
			'card_code' => '<a target="_blank" href="https://wikipedia.org/wiki/Card_security_code">What is it?</a>'
		);
	}
	
	/**
	 * Сценарий поиска
	 */	
	public function search()
	{
		// @todo Please modify the following code to define attributes that should be searched.
		$criteria = new CDbCriteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
