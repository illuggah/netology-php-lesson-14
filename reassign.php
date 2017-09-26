<?php

	require_once 'core/core.php';

	loginCheck ();

	### Извлекаем id пользователя через заданный login

	$user_db = $todo->prepare('SELECT id FROM user WHERE login = ?');
	$user_db->execute([$_POST['reassign']]);

	$user = $user_db->fetch(PDO::FETCH_ASSOC)['id'];

	### Перезаписываем assigned_user_id

	$sql_query = 'UPDATE task SET assigned_user_id = ? WHERE id = ?;';
	$stm = $todo->prepare($sql_query);
	$stm->execute([$user, $_GET['id']]);

	header ('Location: list.php?m=s3');