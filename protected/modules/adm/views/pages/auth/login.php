<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $this->pageTitle ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/style/common.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en" />
	<script src="/js/jquery.min.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="logo">
			<img src="/i/books.png" alt="" />
			<h1>Мои Книги</h1>
		</div>
		<div class="login-form-wrapper">
			<form method="post" action="" />
				<div>
					<label>Логин</label>
					<input type="text" name="LoginForm[login]" />
				</div>
				<div>
					<label>Пароль</label>
					<input type="password" name="LoginForm[pwd]" />
				</div>
				<div><input type="submit" value="Войти" /></div>
			</form>
			<div class="error"><?php echo Yii::app()->user->getFlash('loginError') ?></div>
		</div>
		<script>
			$('form').submit(function() {
				var empty = false;
				$(this).find('input').each(function() {
					if (!$.trim(this.value))
						empty = true;
				});
				if (empty) return false;
			});
		</script>
	</div>
</body>
</html>
