<?php
class LoginForm extends CFormModel
{
	public $login;
	public $pwd;

	private $identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('login, pwd', 'required')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'login'=>'Login',
			'pwd'=>'Password'
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate ($attribute, $params)
	{
		if (!$this->hasErrors())
			$this->identity = new ManagerIdentity($this->login, $this->pwd);
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if ($this->identity === null) {
			$this->identity = new ManagerIdentity($this->login, $this->pwd);
			$this->identity->authenticate();
		}
		
		if ($this->identity->errorCode === ManagerIdentity::ERROR_NONE) {
			Yii::app()->user->login($this->identity);
			return true;
		} else {
			if ($this->identity->errorCode === ManagerIdentity::ERROR_USERNAME_INVALID)
				$message = 'Invalid login or password';
			else
				$message = 'Unknown authentication error';

			Yii::app()->user->setFlash('loginError', $message);

			return false;
		}
	}
}
