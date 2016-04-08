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
			array('email', 'email')
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
