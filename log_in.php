<?php

	if ($_GET['msg'] === 'w1') {
		$message = 'Введите логин!';
	} elseif ($_GET['msg'] === 'w3') {
		$message = 'Пароль не должен содержать менее четырех символов!';
	} elseif ($_GET['msg'] === 'w4') {
		$message = 'Неверный логин или пароль';
	} elseif ($_GET['msg'] === 'w5') {
		$message = 'Пожалуйста, авторизуйтесь!'; 
	} elseif ($_GET['msg'] === 's') {
		$message = 'Вы успешно зарегистрированы!';
	} else {
		$message = 'Вход';
	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TODO | Log In</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style>
		body {font-size: 11pt;}
	</style>
</head>
<body style="background-color: #e5eeed">
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-top">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">TODO | Log In</a>

			</div>
			<div class="navbar-collapse navbar-top collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="log_in.php">Вход</a></li>
					<li><a href="sign_up.php">Регистрация</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="row vertical-offset-100">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?=$message?></h3>
					</div>
					<div class="panel-body">
	                    <form method="POST" action="log_in_handler.php">
	                        <fieldset>
	                            <div class="form-group">
	                                <input class="form-control" placeholder="Login" name="login" type="text">
	                            </div>
	                            <div class="form-group">
	                                <input class="form-control" placeholder="Password" name="password" type="text">
	                            </div>
	                            <input class="btn btn-success btn-block" type="submit" value="Войти">
	                        </fieldset>
	                    </form>
	                    <a href="sign_up.php" style="margin-top: 16px;" class="btn btn-warning btn-block">Зарегистрироваться</a>
	                </div>
	            </div>
	        </div>
	    </div>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>