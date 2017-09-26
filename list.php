<?php

	require_once 'core/core.php';

	loginCheck ();

	### Извлекаем данные текущего пользователя

	$sql_query = 'SELECT task.id, description, assigned_user_id, is_done, date_added, user.login FROM task LEFT JOIN user ON task.user_id = user.id /**/ LEFT JOIN user AS user_assigned ON task.assigned_user_id = user_assigned.login /**/ WHERE user_id = ?;';
	$stm = $todo->prepare($sql_query);
	$stm->execute([getAuthUserId()]);

	$extracted = [];

	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
		$extracted[] = $row;
	}

	### Требования других пользователей

	$sql_query2 = 'SELECT task.id, description, assigned_user_id, is_done, date_added, user.login FROM task LEFT JOIN user ON task.user_id = user.id /* LEFT JOIN user AS user_assigned ON task.assigned_user_id = user_assigned.login /**/ WHERE assigned_user_id = ? && user_id != ?;';
	$stm2 = $todo->prepare($sql_query2);
	$stm2->execute([getAuthUserId(), getAuthUserId()]);

	$extracted2 = [];

	while ($row2 = $stm2->fetch(PDO::FETCH_ASSOC)) {
		$extracted2[] = $row2;
	}

	### Извлкаем таблицу пользователей

	$users_query = 'SELECT id, login FROM user';
	$usr_stm = $todo->prepare($users_query);
	$usr_stm->execute();

	$extracted_users = [];

	while ($usr_row = $usr_stm->fetch(PDO::FETCH_ASSOC)) {
		$extracted_users[] = $usr_row;
	}

	### Выводим сообщения обработчиков

	if ($_GET['m'] === 's1') {
		$message = 'Дело успешно выполнено';	
	} elseif ($_GET['m'] === 's2') {
		$message = 'Дело удалено';
	} elseif ($_GET['m'] === 's3') {
		$message = 'Назначен новый ответственный';
	} elseif ($_GET['m'] === 's4') {
		$message = 'Дело успешно добавлено';
	} else {
		$message = '';
	}

	/*echo "<pre>";
	print_r($extracted);
	echo "</pre>";*/

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TODO | List</title>
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
				<a href="index.php" class="navbar-brand">TODO | List</a>

			</div>
			<div class="navbar-collapse navbar-top collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#">Список дел</a></li>
					<li class="active"><a href="#">Привет, <?=getAuthorizedUser()?>!</a></li>
					<li><a href="log_out.php">Выйти</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">

		<h2>Список дел</h2>
		
		<div style="height: 16px">
			<span id="msg"><?=$message?></span>
		</div>
		
		<hr>
		
		<table class="table">
			<tr><th>Описание</th><th>Автор</th><th>Статус</th><th>Дата публикации</th><th>Ответственный</th><th><i class="fa fa-check-circle"></th><th><i class="fa fa-trash"></th><th>Закрепить за пользователем</th></tr>
			<?php
				$td = '</td><td>';
				foreach ($extracted as $row) {
					if ($row['is_done'] == 1) {
						$row['is_done'] = '<span class="text-success">Выполнено</span>';
					} elseif ($row['is_done'] == 0) {
						$row['is_done'] = '<span class="text-danger">В процессе</span>';
					} else {
						$row['is_done'] = '<span class="text-warning">Неизвестно</span>';
					}

					$mark_as_done = '<a title="Отметить как выполненное" href="done.php?id=' . $row['id'] . '"><i class="fa fa-check-circle text-success"></i></a>';
					$delete_btn = '<a title="Удалить" href="delete.php?id=' . $row['id'] . '"><i class="fa fa-trash text-danger"></i></a>';

					### Извлекаем login пользователя через заданный id

					$user_db = $todo->prepare('SELECT login FROM user WHERE id = ?');
					$user_db->execute([$row['assigned_user_id']]);
					$assigned_user_name = $user_db->fetch(PDO::FETCH_ASSOC)['login'];

					if ($row['assigned_user_id'] === getAuthUserId()) {
						$assigned_user_name = 'Вы';
					}

					### Выводим таблицу

					echo '<tr><td>' . 
						$row['description'] .$td. 
						$row['login'] . $td . 
						$row['is_done'] .$td. $row['date_added'] . $td . 
						$assigned_user_name .$td. 
						$mark_as_done .$td. 
						$delete_btn . $td . 
						'<form action="reassign.php?id=' . $row['id'] . '"  method="post"><select name="reassign">';
					foreach ($extracted_users as $reassign_to_user) {
						echo '<option>' . $reassign_to_user['login'] . '</option>';
					}
					echo '</select><button type="submit">Переложить ответственность</button></form></td></tr>';
				}
			?>
		</table>

		<hr>

		<h2>Что требуют от вас другие позьзователи:</h2>

		<table class="table">
			<tr><th>Описание</th><th>Автор</th><th>Статус</th><th>Дата публикации</th><th>Ответственный</th><th><i class="fa fa-check-circle"></th></tr>
			<?php
				foreach ($extracted2 as $row2) {
					if ($row2['is_done'] == 1) {
						$row2['is_done'] = '<span class="text-success">Выполнено</span>';
					} elseif ($row['is_done'] == 0) {
						$row2['is_done'] = '<span class="text-danger">В процессе</span>';
					} else {
						$row2['is_done'] = '<span class="text-warning">Неизвестно</span>';
					}

					$mark_as_done2 = '<a href="done.php?id=' . $row2['id'] . '"><i class="fa fa-check-circle text-success"></i></a>';
					$delete_btn2 = '<a href="delete.php?id=' . $row2['id'] . '"><i class="fa fa-trash text-danger"></i></a>';

					### Извлекаем login пользователя через заданный id

					$user_db = $todo->prepare('SELECT login FROM user WHERE id = ?');
					$user_db->execute([$row2['assigned_user_id']]);
					$assigned_user_name = $user_db->fetch(PDO::FETCH_ASSOC)['login'];

					### Выводим таблицу

					echo '<tr><td>' . 
						$row2['description'] .$td. 
						$row2['login'] . $td . 
						$row2['is_done'] .$td. 
						$row2['date_added'] . $td . 
						$assigned_user_name .$td. 
						$mark_as_done2 . '</td></tr>';
				}
			?>
		</table>

		<?php 

		?>

		<hr>
		<hr>
		
		<h2>Добавить дело</h2>

		<hr>
		
		<div class="col-md-8 col-md-offset-2">
			<form action="add.php" method="post">
				<textarea class="form-control" name="description"></textarea>
				<button type="submit" class="btn btn-success form-control">Добавить</button>
			</form>
		</div>
	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		$('#msg').fadeOut(5000);
	</script>
</body>
</html>