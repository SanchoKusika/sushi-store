<?php
require("config.php");
require("db.php");
require(ROOT . "functions/auth.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login = trim($_POST['login']);
	$password = trim($_POST['password']);

	$result = register_user($login, $password);

	if ($result === true) {
		header("Location: index.php");
		exit;
	} else {
		$errors = $result;
	}
}
?>

<?php include(ROOT . "templates/head.tpl"); ?>
<?php include(ROOT . "templates/header.tpl"); ?>

<main>
	<div class="auth-container">
		<div class="card shadow">
			<div class="card-body">
				<h3 class="card-title text-center mb-4">Регистрация</h3>
				<?php
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger">';
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                    echo '</div>';
                }
                ?>
				<form action="" method="POST">
					<div class="mb-3">
						<label for="login" class="form-label">Логин</label>
						<input type="text" class="form-control" id="login" name="login" placeholder="Введите логин" required />
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Пароль</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" required />
					</div>
					<button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
				</form>
				<p class="text-center mt-3">Уже есть аккаунт? <a href="<?= HOST ?>login.php" class="fw-bold">Войти</a></p>
			</div>
		</div>
	</div>
</main>

<?php
include(ROOT . "templates/footer.tpl");
?>
