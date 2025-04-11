<?php
require("config.php");
require("db.php");

include(ROOT . "templates/head.tpl");
include(ROOT . "templates/header.tpl");
?>

<main class="admin">
	<aside class="admin__sidebar">
		<nav class="admin__nav">
			<a href="#" class="admin__nav-link admin__nav-link--active" data-tab="add-product">Добавить товар</a>
			<a href="#" class="admin__nav-link" data-tab="products">Товар</a>
			<a href="#" class="admin__nav-link" data-tab="users">Пользователи</a>
			<a href="#" class="admin__nav-link" data-tab="order-history">История заказов</a>
		</nav>
	</aside>

	<section class="admin__content">
		<div id="add-product" class="admin__tab admin__tab--active">
			<h2 class="admin__title">Добавить товар</h2>
			<form class="admin__form">
				<div class="mb-3">
					<label for="productTitle" class="form-label">Название товара</label>
					<input type="text" class="form-control" id="productTitle" placeholder="Введите название товара" required />
				</div>
				<div class="mb-3">
					<label for="productPrice" class="form-label">Цена</label>
					<input type="number" class="form-control" id="productPrice" placeholder="Введите цену товара" required />
				</div>
				<div class="mb-3">
					<label for="productWeight" class="form-label">Вес</label>
					<input type="number" class="form-control" id="productWeight" placeholder="Введите вес товара" required />
				</div>
				<div class="mb-3">
					<label for="productImage" class="form-label">Изображение</label>
					<input type="file" class="form-control" id="productImage" accept="image/*" />
				</div>
				<button type="submit" class="btn btn-primary">Добавить товар</button>
			</form>
		</div>

		<div id="products" class="admin__tab">
			<h2 class="admin__title">Товар</h2>
			<p>Список товаров отображается здесь.</p>
		</div>

		<div id="users" class="admin__tab">
			<h2 class="admin__title">Пользователи</h2>
			<p>Список пользователей отображается здесь.</p>
		</div>

		<div id="order-history" class="admin__tab">
			<h2 class="admin__title">История заказов</h2>
			<p>История заказов отображается здесь.</p>
		</div>
	</section>
</main>

<?php
include(ROOT . "templates/footer.tpl");
?>
