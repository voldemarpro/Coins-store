<?php
class WebUser extends CWebUser {
	
	private $_model = null;

	public function getRole() {
		if ($user = $this->getModel())
			// в таблице User есть поле role
			return $user->role;
	}

	private function getModel() {
		if (!$this->isGuest && $this->_model === null)
			if ($this->id > 0) {
				$this->_model = User::model()->findByPk($this->id, array('select'=>'role'));
			} else {
				$this->_model =	new User('devLogin');
				$this->_model->attributes = $this->_model->getDevAttr();
			}
		
		return $this->_model;
	}
}
?>