<?php
class UserIdentity extends CUserIdentity {
	protected $_id;

	public function authenticate() {
		

		$user = User::model()->find('login = ?', array($this->username));
		
		if ($user === null || MyAesCodec::encrypt($this->password) !== $user->pwd)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else {
			// В качестве идентификатора будем использовать id, а не username
			$this->_id = $user->id;
			
			// Используется как Yii::app()->user->name.
			$this->username = $user->name;

			$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}
 
	public function getId() {
		return $this->_id;
	}
}
?>