<?php
class WebUser extends CWebUser {
	
	private $_model = null;

	public function getRole() {
		if ($user = $this->getModel())
			return $user->role;
	}

	private function getModel() {
		if (!$this->isGuest && $this->_model === null)
			$this->_model = User::model()->findByPk($this->id);

		return $this->_model;
	}
}
?>