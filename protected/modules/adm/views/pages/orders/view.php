<?php
$this->renderFile(
	dirname($this->viewPath).'/common/grid.php',
	array('dataProvider'=>$dataProvider, 'grid'=>$grid)
);
?> 