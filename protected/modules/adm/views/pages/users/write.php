<?php
echo '
<h1>', $this->pageTitle, ' &ndash; ', ($model->isNewRecord ? 'New Item' : 'Item Edit'), '</h1>';

$this->renderFile(
	dirname($this->viewPath).'/common/attrForm.php',
	array('model'=>$model)
);
	
?>
