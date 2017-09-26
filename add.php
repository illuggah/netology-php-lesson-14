<?php

	require_once 'core/core.php';

	loginCheck ();

	$sql_query = 'INSERT INTO task (description, user_id, assigned_user_id, is_done, date_added) VALUES (?, ?, ?, 0, now())';
	$stm = $todo->prepare($sql_query);
	$stm->execute([$_POST['description'], getAuthUserId(), getAuthUserId()]);

	header("Location: list.php?m=s4");