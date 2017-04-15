<?php
/**
 *	Первичный контроллер
 */
class HomeController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl'
		);
	}

	/**
	 * Specifies the access control rules.
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'error', 'summary'),
				'users'=>array('*'),
			)
		);
	}

	/**
	 * Auth/role based home page
	 */
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest)
			Yii::app()->runController('order');
		else
			$this->render('hello');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
?>