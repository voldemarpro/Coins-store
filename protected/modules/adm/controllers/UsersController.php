<?php
class UsersController extends DataController
{
	public $pageTitle = 'Users';
	
	/**
     * Выбор всех записей с пагинацией
     */	
	public function actionView()
	{			
		$dataProvider = new CActiveDataProvider('User', array(
			'criteria' => array(
				'with'=>array('ordersCount'),
				'together'=>true
			),
			'sort'=>array(
				'defaultOrder' => '`t`.`first_name`'
			),
			'pagination'=>array(
				'pageVar'=>'page',
				'pageSize'=>30
			)
		));
		
		$this->render('view', array(
			'dataProvider'=>$dataProvider,
			'grid'=>array(
				'attributes'  => array(
					array('first_name'),
					array('last_name'),
					array('email'),
					array('ordersCount'=>'id')
				),
				'grand_attr'=>0,
				'actions'=>array('delete')
			)		
		));
	}
	
    /**
     * Добавление записи
	 
	public function actionAdd()
	{
		$user = new User;
		
		if (isset($_POST['User'])) {
			$user->attributes = $_POST['User'];
			if ($user->save())
				$this->redirect(array($this->defaultAction));
		}
		
		$this->renderWrite($user);		
	}
	*/
	
    /**
     * Редактирование записи
     */		
	public function actionEdit($id = 0)
	{
		$user = ($id != 0) ? User::model()->findByPk($id) : null;
		
		if ($user) {
			if (isset($_POST['User'])) {
				$user->attributes = $_POST['User'];
				if ($user->save())
					$this->redirect(array($this->defaultAction));
			}
			
			$this->renderWrite($user);	
		
		} else
			throw new CHttpException(404, self::NO_DATA);
	}
	
    /**
     * Удаление записи
     */		
	public function actionDelete($id = 0)
	{
		if ($id) 
			if ($model = User::model()->findByPk($id))
				if (!$model->orders || $model->orders->delete())
					$model->delete();

		$this->redirect(array($this->defaultAction));
	}
	
    /**
     * Вывод шаблона с формой для редактирования
     */		
	private function renderWrite($model) {
		$this->render('write', array(
			'model'=>$model
		));
	}	
}
?>