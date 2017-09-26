<?php

	require_once 'core/core.php';

	if (mb_strlen($_POST['login']) < 1) {
		header ("Location: log_in.php?msg=w1");
		exit;
	}

	if (mb_strlen($_POST['password']) < 4) {
		header ("Location: log_in.php?msg=w3");
		exit;
	}

	$userlist_query = 'SELECT * FROM user';
	$stm = $todo->prepare($userlist_query);
	$stm->execute();

	$extracted = [];

	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
		$extracted[] = $row;
	}

	foreach ($extracted as $row) {
		if ($_POST['login'] === $row['login']) {
			if (md5($_POST['login'] . $_POST['password']) === $row['password']) {
				//устанавливаем данные пользователья в сессии
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['user'] = $row['login'];
				unset($_POST['password']);
				header('Location: list.php');
				exit;
			}
		}
	}

	header ('Location: log_in.php?msg=w4');