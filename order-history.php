<?php
require("config.php");
require("db.php");

include(ROOT . "templates/head.tpl");
include(ROOT . "templates/header.tpl");
?>

<main>
	<div class="container my-5">
		<h2 class="order-title mb-4">История заказов</h2>

		<div class="order-item mb-3">
			<div class="order-item__img">
				<img src="<?= HOST ?>assets/img/roll/california-hit.jpg" alt="Калифорния хит" />
			</div>
			<div class="order-item__desc">
				<div class="order-item__title">Калифорния хит</div>
				<div class="order-item__weight">180 г</div>
				<div class="order-item__info">
					<div class="order-item__quantity">Количество: 2 шт.</div>
					<div class="order-item__price">Итого: 600 ₽</div>
					<div class="order-item__delivery">Доставка: 250 ₽</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
include(ROOT . "templates/footer.tpl");
?>
