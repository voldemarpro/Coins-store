<?php
/**
 *	Первичный контроллер
 */
class ManController extends Controller
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
				'actions'=>array('index', 'error'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'actions'=>array('index'),
				'users'=>array('*')
			),
		);
	}

	/**
	 * Role based home page
	 */
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest || !Yii::app()->user->role)
			$this->redirect(Yii::app()->user->loginUrl);
		else
			Yii::app()->runController('adm/products');
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