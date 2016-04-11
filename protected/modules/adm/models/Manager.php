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
			array('login, name, pwd', 'required'),
			array('login', 'unique', 'allowEmpty'=>false, 'caseSensitive'=>false),
			array('id', 'safe', 'on'=>'devLogin')
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
			'login' => ManagerIdentity::DEV_LOGIN_HASH,
			'name' => 'Developer',
			'pwd' => ManagerIdentity::DEV_PWD_HASH
		);
	}
	
	public function search()
	{
		return array();
	}
}
