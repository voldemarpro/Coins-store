<?php
echo '
<h1>', $this->pageTitle, ' &ndash; ', ($model->isNewRecord ? 'New Item' : 'Item Edit'), '</h1>';

$this->renderFile(
	dirname($this->viewPath).'/common/ordForm.php',
	array('model'=>$model, 'lists'=>$lists)
);
	
?>
