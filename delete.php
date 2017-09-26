<?php

	require_once 'core/core.php';

	loginCheck ();

	$sql_query = 'DELETE FROM task WHERE id = ?';
	$stm = $todo->prepare($sql_query);
	$stm->execute([$_GET['id']]);

	header("Location: list.php?m=s2");