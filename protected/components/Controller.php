<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	const NO_DATA = 'No data to display';	
	
	private $_pageTitle;

	public function init() {
		// @var string the default layout for the controller view.
		$this->layout = Yii::app()->user->role ? '//layouts/cms' : '//layouts/site';
	}
	
	// @return array action filters
	public function filters()
	{
		return array(
			'accessControl' // perform access control for CRUD operations
		);
	}

	public function getViewPath() {
		if (!empty($this->module) && !empty($this->module->name))
			$pathBase = $this->module->getViewPath();
		else
			$pathBase = Yii::app()->getViewPath();

		return $pathBase.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR.$this->getId();
	}
	
	public function setPageTitle($value)
	{
		$this->_pageTitle = $value;
	}
	
	public function getPageTitle()
	{
		if ($this->_pageTitle !== null)
			return $this->_pageTitle;
		else
			return $this->_pageTitle = Yii::app()->name;
	}
}