<?php
/**
 *	Работа с продуктами
 */
class ProductsController extends DataController
{
	public $pageTitle = 'Products';
	
	/**
     * Выбор всех записей с пагинацией
     */	
	public function actionView()
	{			
		$dataProvider = new CActiveDataProvider('Product', array(
			'criteria' => array(
				'with'=>array('ordersCount'),
				'together'=>true
			),
			'sort'=>array(
				'defaultOrder' => '`t`.`id`'
			),
			'pagination'=>array(
				'pageVar'=>'page',
				'pageSize'=>3
			)
		));

		$this->render('view', array(
			'dataProvider'=>$dataProvider,
			'grid'=>array(
				'attributes'  => array(
					array('name'),
					array('price'),
					array('ordersCount'=>'id')
				),
				'grand_attr'=>0,
				'actions'=>array('in-archive')
			)
		));
	}
	
    /**
     * Добавление записи
     */
	public function actionAdd()
	{
		// Модель, для которой написан контроллер
		$grandModel = new Product;
		
		if (count($_POST))
			$this->write($grandModel);
		
		$this->renderWrite($grandModel);		
	}
	
    /**
     * Редактирование записи
     */	
	public function actionEdit($id = 0)
	{
		$grandModel = $id ? Product::model()->findByPk($id) : null;
		
		if ($grandModel) {
			$this->write($grandModel);
			$this->renderWrite($grandModel);		
		} else {
			throw new CHttpException(404, self::NO_DATA);
		}
	}
	
    /**
     * Добавление продукта в архив (без удаления)
     */		
	public function actionDelete($id = 0)
	{
		if ($id)
			Product::model()->updateByPk($id, array('archive'=>1));

		$this->redirect(array($this->defaultAction));
	}
	
    /**
     * Запись изменений в БД
     */		
	private function write($grandModel)
	{
		if (isset($_POST[get_class($grandModel)]))
		{
			$isNewRecord = $grandModel->isNewRecord;
			$grandModel->attributes = $_POST[get_class($grandModel)];
			
			if ($grandModel->save())
				$this->redirect(array($this->defaultAction));
		}
	}
	
    /**
     * Вывод шаблона с формой для редактирования
     */		
	private function renderWrite($grandModel) {
		$this->render('write', array(
			'model'=>$grandModel
		));
	}
}
?>