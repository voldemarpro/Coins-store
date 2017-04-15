<?php
class AdmModule extends CWebModule
{
    public function init() {
        parent::init();
		Yii::app()->setComponents(
			array(
				'user'=>array(
					'class' => 'WebAdmin',
					'loginUrl'=>Yii::app()->createUrl('adm/login'),
					'allowAutoLogin'=>false
				)
			)
		);
    }  
}
?>