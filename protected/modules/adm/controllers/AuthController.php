<?php
/**
 *	Контроллер авторизации
 */
class AuthController extends Controller
{
	public $defaultAction = 'login';
	
	public function init() { 
		$this->layout = false;
	}
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('login, logout'),
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Авторизация и перенаправление пользователя
	 */
	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest)
			$this->redirect('/');
		
		$model = new LoginForm;

		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate() && $model->login())
				$this->redirect('/'.$this->module->name);
		}
		$this->render('login', array('model'=>$model));
	}
	
	/**
	 * Выход из учетной записи
	 */	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect("/{$this->module->name}");
	}
}