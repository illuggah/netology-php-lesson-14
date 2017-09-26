<?php

	require_once 'core/core.php';

	loginCheck ();

	$sql_query = 'UPDATE task SET is_done = 1 WHERE id = ?';
	$stm = $todo->prepare($sql_query);
	$stm->execute([$_GET['id']]);

	header("Location: list.php?m=s1");