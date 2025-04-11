<header class="header">
	<div class="container">
		<div class="header__row">
			<div class="logo"><a href="<?= HOST ?>index.php">Sushi Shop</a></div>
			<nav class="header__nav">
				<ul class="header__nav-list">
				<?php
				if (isset($_SESSION['user'])) {
					if ($_SESSION['user']['role'] === 'admin') {
						echo '<li><a href="' . HOST . 'admin.php">Панель администратора</a></li>';
					} else {
						echo '<li><a href="' . HOST . 'order-history.php">История заказов</a></li>';
					}
					echo '<li><a href="' . HOST . 'logout.php">Выход</a></li>';
				} else {
					echo '<li><a href="' . HOST . 'login.php">Вход</a></li>';
					echo '<li><a href="' . HOST . 'register.php">Регистрация</a></li>';
				}
				?>
				</ul>
			</nav>
		</div>
	</div>
</header>