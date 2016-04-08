<?php
class WebUser extends CWebUser {
	
	private $_model = null;

	public function getRole() {
		if ($user = $this->getModel())
			return $user->role;
	}

	private function getModel() {
		if (!$this->isGuest && $this->_model === null)
			if ($this->id > 0) {
				$this->_model = Manager::model()->findByPk($this->id);
			} else {
				$this->_model =	new User('devLogin');
				$this->_model->attributes = $this->_model->getDevAttr();
			}
		
		return $this->_model;
	}
}
?>