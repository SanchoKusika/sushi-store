<?php
require_once(ROOT . "db.php");

function register_user($login, $password) {
	$errors = [];

	if (mb_strlen(trim($login)) < 3) {
		$errors[] = "Логин должен быть не менее 3 символов.";
	}
	if (mb_strlen(trim($password)) < 5) {
		$errors[] = "Пароль должен быть не менее 5 символов.";
	}

	$existing = R::findOne('users', 'login = ?', [$login]);
	if ($existing) {
		$errors[] = "Пользователь с таким логином уже существует.";
	}

	if (!empty($errors)) {
		return $errors;
	}

	$user = R::dispense('users');
	$user->login = $login;
	$user->password = password_hash($password, PASSWORD_DEFAULT);
	$user->role = 'user';
	$id = R::store($user);

	$_SESSION['user'] = [
		'id' => $id,
		'login' => $login,
		'role' => 'user'
	];

	return true;
}

function login_user($login, $password) {
	$user = R::findOne('users', 'login = ?', [$login]);

	if ($user && password_verify($password, $user->password)) {
		$_SESSION['user'] = [
			'id' => $user->id,
			'login' => $user->login,
			'role' => $user->role
		];
		return true;
	}

	return "Неверный логин или пароль.";
}

function is_logged_in() {
	return isset($_SESSION['user']);
}

function logout_user() {
	if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
	}
	unset($_SESSION['user']);
	session_destroy();
}
