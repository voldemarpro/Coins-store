<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $this->pageTitle ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en" />
	<link rel="stylesheet" type="text/css" href="/style/common.css">
	
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/store.adm.js"></script>
	<!--[if lt IE9]>
		<script type="text/javascript" src="/js/respond.js"></script>
	<![endif]-->
</head>

<body>
	<div id="header">
		<div>
			<ul><?php

			$pg_now = 0;
			$pages = array(
					0 => array('vname' => 'products',	'name' => 'Products'),
					1 => array('vname' => 'orders',		'name' => 'Orders'),
					2 => array('vname' => 'users',		'name' => 'Users'),
					3 => array('vname' => 'managers',	'name' => 'Managers')
				);
			foreach ($pages as $pg_i=>$p) {
				if ($this->id == "{$p['vname']}") 
					$pg_now = $pg_i;
				echo '
				<li', ($this->id == "{$p['vname']}" ? ' class="active"' : ''), '><a href="/', $this->module->name, '/', $p['vname'], '">', $p['name'], '</a></li>';
			}
			
			?> 
			</ul>
			<div class="auth">
				<?php echo '<span>', Yii::app()->user->name,  '</span><a href="/', $this->module->name, '/logout">log out</a>' ?> 
			</div>
		</div>
	</div>
	
	<div class="wrapper">
		<div class="content"><?php

		echo $content;
		if (Yii::app()->errorHandler->error) echo '
			<div>
				<a href="/', $pages[$pg_now]['vname'], '/">Back to «', $pages[$pg_now]['name'], '»</a>
			</div>';		
		
		?> 
		</div>
	</div>	
</body>
</html>