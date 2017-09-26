<?php

	function isAuthorized () {
		return !empty($_SESSION['user']);
	}

	function loginCheck () {
		if (!isAuthorized()) {
			header ('Location: log_in.php?msg=w5');
			die;
		}
	}

	function getAuthorizedUser () {
		return isset($_SESSION['user']) ? $_SESSION['user'] : null;
	}

	function getAuthUserId () {
		return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
	}

	function logout () {
		if (isAuthorized) {
			session_destroy();
		}
		header('Location: index.php');
	}