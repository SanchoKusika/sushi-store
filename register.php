<?php
require("config.php");
require("db.php");

include(ROOT . "templates/head.tpl");
include(ROOT . "templates/header.tpl");
?>

<main>
	<div class="auth-container">
		<div class="card shadow">
			<div class="card-body">
				<h3 class="card-title text-center mb-4">Регистрация</h3>
				<form>
					<div class="mb-3">
						<label for="login" class="form-label">Логин</label>
						<input type="text" class="form-control" id="login" placeholder="Введите логин" required />
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Пароль</label>
						<input type="password" class="form-control" id="password" placeholder="Введите пароль" required />
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
