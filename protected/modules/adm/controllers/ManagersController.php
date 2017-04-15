<?php
class ManagersController extends DataController
{
    public $pageTitle = 'Managers';
	
	/**
     * Выбор всех записей с пагинацией
     */
	public function actionView()
	{
		$dataProvider = new CActiveDataProvider('Manager', array(
			'pagination'=>array(
				'pageVar'=>'page',
				'pageSize'=>4
			),
			'sort'=>array(
				'defaultOrder' => '`name`'
			)	
		));

		$this->render('view', array(
			'dataProvider'=>$dataProvider,
			'grid'=>array(
				'attributes' => array(
					array('name')
				),
				'grand_attr'=>0,
				'actions'=>array('delete')
			)				
		));
	}
	
    /**
     * Добавление записи
     */
	public function actionAdd()
	{
		// Модель, для которой написан контроллер
		$grandModel = new Manager;
		
		if (isset($_POST[get_class($grandModel)])) {
			$grandModel->attributes = $_POST[get_class($grandModel)];
			if ($grandModel->validate()) {
				$grandModel->pwd = MyAesCodec::encrypt($grandModel->pwd);
				if ($grandModel->save(false))
					$this->redirect(array($this->defaultAction));
			}
		}
		
		$this->renderWrite($grandModel);		
	}
	
    /**
     * Редактирование записи
     */	
	public function actionEdit($id = 0)
	{
		$grandModel = $id ? Manager::model()->findByPk($id) : null;

		if ($grandModel) {
			if (isset($_POST['Manager'])) {
				$old_pwd = $grandModel->pwd;
				$grandModel->attributes = $_POST['Manager'];
				if ($grandModel->validate()) {
					if ($grandModel->pwd)
						$grandModel->pwd = MyAesCodec::encrypt($user->pwd);
					else 
						$grandModel->pwd = $old_pwd;
					
					if ($grandModel->save(false))
						$this->redirect(array($this->defaultAction));
				}
			} else {
				$grandModel->pwd = MyAesCodec::decrypt($grandModel->pwd);
			}
			
			$this->renderWrite($grandModel);		
		} else {
			throw new CHttpException(404, self::NO_DATA);
		}
	}
	
    /**
     * Удаление записи
     */		
	public function actionDelete($id = 0)
	{
		if ($id && $id != Yii::app()->user->id)
			if ($model = Manager::model()->findByPk($id))
				$model->delete();
		
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