<?php
/**
 *	Контроллер оформления заказа
 */
class OrderController extends Controller
{
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('*'),
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Вывод формы
	 */
	public function actionIndex()
	{
		$this->render('index', array('model'=>new OrderForm));
	}

	/**
	 * Создание заказа
	 */
	public function actionCreate()
	{
		$model = new OrderForm;

		if (!empty($_POST['OrderForm']) && !empty($_POST['OrderForm']['User']) && !empty($_POST['OrderForm']['Order'])) {
			$inp = $_POST['OrderForm']['User'];
			$inp['first_name'] =  mb_strtoupper($inp['first_name'], 'utf-8');
			$inp['last_name'] =  mb_strtoupper($inp['last_name'], 'utf-8');
			$model->user->attributes = $inp;
			
			// ищем покупателя в нашей БД
			$altUser = User::model()->findByAttributes(array(
				'email'=>htmlspecialchars($model->user->email)
			)); 
			
			if ($altUser) {
				if ($model->user->first_name == $altUser['first_name'] && $model->user->last_name == $altUser['last_name']) {
					$validUser = true;
					$model->user->id = $altUser->id;
				}
			} elseif ($model->user->validate()) {
				$validUser = true;
				$validUser = $validUser && $model->user->save(false);
			} else
				$validUser = false;
			
			if ($validUser) {
				$inp = $_POST['OrderForm']['Order'];
				$inp['user_id'] = $model->user->id;
				$inp['card_valid_thru'] = date('Y-m-d', strtotime($inp['card_valid_thru']));
				$inp['amount'] = $model->products[$inp['prod_id']]->price;
				$inp['amount'] *= round($model->order->payCurrencies[$inp['pay_curr']]['factor']);
				
				$inp['pay_sum'] = $inp['amount']; // заказ полностью оплачен
					
				if (preg_match('/'.Order::PATT_VISA.'/', $inp['card_number']))
					$inp['pay_type'] = Order::PAY_VISA;
				else
					$inp['pay_type'] = Order::PAY_MCARD;
						
				$model->order->attributes = $inp;

				if ($model->order->validate()) {
					$model->order->card_number = MyAesCodec::encrypt($inp['card_number']);
					$model->order->card_code = MyAesCodec::encrypt($inp['card_code']);
					if ($model->order->save(false)) { // Сохраняем без повторной валидации
						//	@todo	отправка уведомления покупателю по эл. почте
						$this->redirect(array("/$this->id/summary/{$model->order->id}"));
						Yii::app()->end();
					}
				}
			} 
		}
		
		$this->render('index', array('model'=>$model));
	}
	
	/**
	 * Резюме по сделанному заказу
	 */	
	public function actionSummary($id = 0)
	{
		$model = $id ? Order::model()->with(array('user', 'product'))->findByPk($id) : null;
		
		if ($model)
			$this->render('summary', array('model'=>$model));	
		else
			throw new CHttpException(404, self::NO_DATA);
	}
}