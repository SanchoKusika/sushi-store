<?php
require("config.php");
require("db.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
	header("Location: index.php");
	exit;
}
require(ROOT . "functions/adminAction.php");

$adminMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		if ($action === 'add_product') {
			$result = addProduct($_POST, $_FILES['productImage']);
			$adminMessage = ($result === true) ? "Товар успешно добавлен." : $result;
		} elseif ($action === 'update_product') {
			$result = updateProduct($_POST['product_id'], $_POST, $_FILES['productImage']);
			$adminMessage = ($result === true) ? "Товар успешно обновлён." : $result;
		} elseif ($action === 'delete_product') {
			$result = deleteProduct($_POST['product_id']);
			$adminMessage = ($result === true) ? "Товар успешно удалён." : $result;
		}
	}
}

$products = getAllProducts();
$users = getAllUsers();
$orders = getAllOrders();

include(ROOT . "templates/head.tpl");
include(ROOT . "templates/header.tpl");
?>

<main class="admin">
	<aside class="admin__sidebar">
		<nav class="admin__nav">
			<a href="#" class="admin__nav-link admin__nav-link--active" data-tab="add-product">Добавить/Изменить
				товар</a>
			<a href="#" class="admin__nav-link" data-tab="products">Список товаров</a>
			<a href="#" class="admin__nav-link" data-tab="users">Пользователи</a>
			<a href="#" class="admin__nav-link" data-tab="order-history">История заказов</a>
		</nav>
	</aside>

	<section class="admin__content">
		<div id="add-product" class="admin__tab admin__tab--active">
			<h2 class="admin__title">Добавить товар</h2>
			<?php if ($adminMessage): ?>
			<div class="alert alert-info">
				<?= $adminMessage; ?>
			</div>
			<?php endif; ?>
			<form class="admin__form" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="action" value="add_product">
				<div class="mb-3">
					<label for="productTitle" class="form-label">Название товара</label>
					<input type="text" class="form-control" id="productTitle" name="title"
						placeholder="Введите название товара" required>
				</div>
				<div class="mb-3">
					<label for="productPrice" class="form-label">Цена</label>
					<input type="number" step="0.01" class="form-control" id="productPrice" name="price"
						placeholder="Введите цену товара" required>
				</div>
				<div class="mb-3">
					<label for="productWeight" class="form-label">Вес</label>
					<input type="number" class="form-control" id="productWeight" name="weight"
						placeholder="Введите вес товара" required>
				</div>
				<div class="mb-3">
					<label for="productImage" class="form-label">Изображение</label>
					<input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
				</div>
				<button type="submit" class="btn btn-primary">Добавить товар</button>
			</form>
			<hr>
			<h2 class="admin__title mt-4">Изменить / Удалить товар</h2>
			<?php if ($products): ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Изображение</th>
							<th>Название</th>
							<th>Цена</th>
							<th>Вес</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($products as $product): ?>
						<tr>
							<td><?= $product->id ?></td>
							<td>
								<img src="<?= HOST . $product->image ?>" alt="<?= htmlspecialchars($product->title) ?>"
									style="width: 50px; height: 50px; object-fit: cover;">
							</td>
							<td><?= htmlspecialchars($product->title) ?></td>
							<td><?= $product->price ?> ₽</td>
							<td><?= $product->weight ?> г</td>
							<td>
								<button type="button" class="btn btn-sm btn-warning edit-product-btn" data-product='<?= json_encode([
									"id" => $product->id,
									"title" => $product->title,
									"price" => $product->price,
									"weight" => $product->weight
								]) ?>'>Редактировать
								</button>
								<form method="POST" style="display:inline-block;"
									onsubmit="return confirm('Удалить товар?');">
									<input type="hidden" name="action" value="delete_product">
									<input type="hidden" name="product_id" value="<?= $product->id ?>">
									<button type="submit" class="btn btn-sm btn-danger">Удалить</button>
								</form>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php else: ?>
			<p>Нет товаров.</p>
			<?php endif; ?>
		</div>

		<div id="products" class="admin__tab">
			<h2 class="admin__title">Список товаров</h2>
			<?php if ($products): ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Изображение</th>
							<th>Название</th>
							<th>Цена</th>
							<th>Вес</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($products as $product): ?>
						<tr>
							<td><?= $product->id ?></td>
							<td>
								<img src="<?= HOST . $product->image ?>" alt="<?= htmlspecialchars($product->title) ?>"
									style="width: 50px; height: 50px; object-fit: cover;">
							</td>
							<td><?= htmlspecialchars($product->title) ?></td>
							<td><?= $product->price ?> ₽</td>
							<td><?= $product->weight ?> г</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php else: ?>
			<p>Нет товаров.</p>
			<?php endif; ?>
		</div>

		<div id="users" class="admin__tab">
			<h2 class="admin__title">Пользователи</h2>
			<?php if ($users): ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Логин</th>
							<th>Роль</th>
							<th>Дата регистрации</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $user): ?>
						<tr>
							<td><?= $user->id ?></td>
							<td><?= htmlspecialchars($user->login) ?></td>
							<td><?= $user->role ?></td>
							<td><?= $user->created_at ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php else: ?>
			<p>Нет пользователей.</p>
			<?php endif; ?>
		</div>

		<div id="order-history" class="admin__tab">
			<h2 class="admin__title">История заказов</h2>
			<?php if ($orders): ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID заказа</th>
							<th>Пользователь</th>
							<th>Имя</th>
							<th>Телефон</th>
							<th>Email</th>
							<th>Адрес доставки</th>
							<th>Итого</th>
							<th>Доставка</th>
							<th>Дата заказа</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($orders as $order): ?>
						<tr>
							<td><?= $order->id ?></td>
							<td><?php
							if ($order->user_id) {
								$user = R::load('users', $order->user_id);
								echo htmlspecialchars($user->login);
							} else {
								echo "Гость";
							}
							?>
							</td>
							<td><?= htmlspecialchars($order->name) ?></td>
							<td><?= $order->phone ?></td>
							<td><?= $order->email ?></td>
							<td><?= htmlspecialchars($order->address) ?></td>
							<td><?= $order->total_price ?> ₽</td>
							<td><?= $order->delivery_cost ?> ₽</td>
							<td><?= $order->created_at ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php else: ?>
			<p>Нет заказов.</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php include(ROOT . "templates/footer.tpl"); ?>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="POST" enctype="multipart/form-data" id="editProductForm">
			<input type="hidden" name="action" value="update_product">
			<input type="hidden" name="product_id" id="editProductId">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editProductModalLabel">Редактировать товар</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label for="editProductTitle" class="form-label">Название товара</label>
						<input type="text" class="form-control" id="editProductTitle" name="title" required>
					</div>
					<div class="mb-3">
						<label for="editProductPrice" class="form-label">Цена</label>
						<input type="number" step="0.01" class="form-control" id="editProductPrice" name="price"
							required>
					</div>
					<div class="mb-3">
						<label for="editProductWeight" class="form-label">Вес</label>
						<input type="number" class="form-control" id="editProductWeight" name="weight" required>
					</div>
					<div class="mb-3">
						<label for="editProductImage" class="form-label">Изображение</label>
						<input type="file" class="form-control" id="editProductImage" name="productImage"
							accept="image/*">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
					<button type="submit" class="btn btn-primary">Сохранить изменения</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	document.querySelectorAll('.edit-product-btn').forEach(button => {
		button.addEventListener('click', function () {
			const productData = JSON.parse(this.getAttribute('data-product'));
			document.getElementById('editProductId').value = productData.id;
			document.getElementById('editProductTitle').value = productData.title;
			document.getElementById('editProductPrice').value = productData.price;
			document.getElementById('editProductWeight').value = productData.weight;
			var editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
			editModal.show();
		});
	});
</script>