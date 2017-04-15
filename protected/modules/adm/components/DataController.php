<?php
class DataController extends Controller
{
	public $defaultAction = 'view';
	
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform actions
				'users'=>array('@'),
				'roles'=>array('1')
			),
			array ('deny')
		);
	}
}
?>