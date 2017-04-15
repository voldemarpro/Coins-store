<?php
class OrdersController extends DataController
{
	public $pageTitle = 'Orders';
	
	/**
     * Выбор всех записей с пагинацией
     */	
	public function actionView()
	{
		$dataProvider = new CActiveDataProvider('Order', array(
			'criteria' => array(
				'with'=>'product',
				'together'=>true
			),
			'sort'=>array(
				'defaultOrder' => '`t`.`id`'
			),
			'pagination'=>array(
				'pageVar'=>'page',
				'pageSize'=>30
			)
		));
		
		$payCurrencies = array();
		foreach ($dataProvider->model->payCurrencies as $i=>$val)
			$payCurrencies[$i] = $val['name'];
		
		$dateTimes = CHtml::listData($dataProvider->data, 'date_time', 'date_time');
		foreach ($dateTimes as &$dt)
			$dt = date('M, jS <br/> H:i:s');
		unset($dt);
		
		$this->render('view', array(
			'dataProvider'=>$dataProvider,
			'grid'=>array(
				'attributes'  => array(
					array('id'),
					array('date_time'=>'date_time'),
					array('product'=>'name'),
					array('amount'),
					array('pay_type'=>'pay_type'),
					array('pay_sum'),
					array('pay_curr'=>'pay_curr')
				),
				'lists'=>array(
					'pay_type'=>$dataProvider->model->payTypes,
					'pay_curr'=>$payCurrencies,
					'date_time'=>$dateTimes
				),
				'grand_attr'=>0,
				'actions'=>array('delete')
			)
		));
	}
	
	/*
	public function actionAdd()
	{
		// Модель, для которой написан контроллер
		$grandModel = new Author;
		
		if (count($_POST))
			$this->write($grandModel);
		
		$this->renderWrite($grandModel);		
	}
	*/
	
    /**
     * Редактирование записи
     */		
	public function actionEdit($id = 0)
	{
		$grandModel = $id ? Order::model()->with(array('user', 'product'))->findByPk($id) : null;
		
		if ($grandModel) {
			$this->write($grandModel);
			$this->renderWrite($grandModel);		
		} else {
			throw new CHttpException(404, self::NO_DATA);
		}
	}
	
	public function actionDelete($id = 0)
	{
		if ($id)
			if ($model = Order::model()->findByPk($id))
				$model->delete();
		
		$this->redirect(
			array($this->defaultAction)
		);
	}
	
	private function write($grandModel)
	{
		if (isset($_POST[get_class($grandModel)]))
		{
			$grandModel->attributes = $_POST[get_class($grandModel)];
			if ($grandModel->save())
				$this->redirect(
					array($this->defaultAction)
				);
		}
	}
	
    /**
     * Вывод шаблона с формой для редактирования
     */		
	private function renderWrite($grandModel) {
		$products = Product::model()->findAll();
		$this->render('write', array(
			'model'=>$grandModel,
			'lists'=>array(
					'select'=>array('prod_id'=>CHtml::listData($products, 'id', 'name'))
				)
		));
	}
}
?>