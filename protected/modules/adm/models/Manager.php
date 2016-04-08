<?php
class Manager extends CActiveRecord
{
	public $role = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{managers}}';
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Правила валидации
	 */	
	public function rules()
	{
		return array(
			array('login, name', 'required'),
			array('login', 'unique', 'allowEmpty'=>false, 'caseSensitive'=>false),
			array('id', 'safe', 'on'=>'devLogin'),
			array('pwd', 'required', 'on'=>'insert')
		);
	}

	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => '#',
			'login' => 'Login',
			'pwd' => 'Pasword',
			'name' => 'Name'
		);
	}
	
    /**
     * Мастер-аккаунт разработчика
     */
	public function getDevAttr() {
		return array(
			'id' => -1,
			'login' => UserIdentity::DEV_LOGIN_HASH,
			'name' => 'Developer',
			'pwd' => UserIdentity::DEV_PWD_HASH
		);
	}
	
	public function search()
	{
		return array();
	}
}
