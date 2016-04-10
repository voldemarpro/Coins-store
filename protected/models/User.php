<?php
class User extends CActiveRecord
{
	public $role = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
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
			array('first_name, last_name, email', 'required'),
			array('first_name, last_name, email', 'length', 'max'=>50),
			array('first_name, last_name', 'match', 'allowEmpty'=>false, 'pattern'=>'/[A-Z]{2,}/i'),
			array('email', 'email', 'allowEmpty'=>false),
			array('email', 'unique'),
			array('first_name, last_name, id', 'safe', 'on'=>'insert')
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
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'phone' => 'Phone'
		);
	}

	public function search()
	{
		return array();
	}
}
