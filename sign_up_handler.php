<?php

	require_once 'core/core.php';

	if (mb_strlen($_POST['login']) < 1) {
		header ("Location: sign_up.php?msg=w1");
		exit;
	}

	if (mb_strlen($_POST['password']) < 4) {
		header ("Location: sign_up.php?msg=w3");
		exit;
	}

	$userlist_query = 'SELECT * FROM user';
	$stm = $user_list->prepare($userlist_query);
	$stm->execute();

	$extracted = [];

	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
		$extracted[] = $row;
	}

	foreach ($extracted as $row) {
		if ($row['login'] == $_POST['login']) {
			header ("Location: sign_up.php?msg=w2");
			exit;
		}
	}

	$adduser_query = 'INSERT INTO user (login, password) VALUES (?, ?)';
	$add_stm = $user_list->prepare($adduser_query);
	$passw_hash = md5($_POST['login'] . $_POST['password']);
	$add_stm->execute([$_POST['login'], $passw_hash]);

	header ("Location: log_in.php?msg=s");