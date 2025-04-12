<?php
require("config.php");
require("db.php");
require(ROOT . "functions/order.php");

$products = R::findAll('products');
$orderSuccess = false;
$orderError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_form'])) {
	if (!isset($_SESSION['user'])) {
		$orderError = 'Чтобы оформить заказ, войдите в аккаунт.';
	} else {
		$name = trim($_POST['name'] ?? '');
		$phone = trim($_POST['phone'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$address = trim($_POST['address'] ?? '');
		$cartJSON = $_POST['cart'] ?? '';
		$cartItems = json_decode($cartJSON, true);

		if (!$cartItems || !is_array($cartItems)) {
			$orderError = 'Корзина пуста или переданы некорректные данные.';
		} else {
			$orderId = placeOrder(
				[
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
					'address' => $address
				],
				$cartItems
			);
			if ($orderId) {
				$orderSuccess = true;
			} else {
				$orderError = 'Ошибка при оформлении заказа.';
			}
		}
	}
}
?>

<?php include(ROOT . "templates/head.tpl"); ?>
<?php include(ROOT . "templates/header.tpl"); ?>

<main>
	<div class="container mb-5">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<?php foreach ($products as $product): ?>
						<div class="col-md-6">
							<div class="card mb-4" data-id="<?= $product->id ?>">
								<img class="product-img" src="<?= HOST . $product->image ?>" alt="<?= htmlspecialchars($product->title) ?>" />
								<div class="card-body text-center">
									<h4 class="item-title"><?= htmlspecialchars($product->title) ?></h4>
									<p><small data-items-in-box class="text-muted">6 шт.</small></p>

									<div class="details-wrapper">
										<div class="items counter-wrapper">
											<div class="items__control" data-action="minus">-</div>
											<div class="items__current" data-counter>1</div>
											<div class="items__control" data-action="plus">+</div>
										</div>

										<div class="price">
											<div class="price__weight"><?= htmlspecialchars($product->weight) ?>г.</div>
											<div class="price__currency"><?= htmlspecialchars($product->price) ?> ₽</div>
										</div>
									</div>

									<button data-cart type="button" class="btn btn-block btn-outline-warning">
										+ в корзину
									</button>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					
					<?php if (empty($products)): ?>
						<div class="col-12 fs-1">
							<p>Товары отсутствуют</p>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card mb-4">
					<div class="card-body">
						<h5 class="card-title">Ваш заказ</h5>
						<div data-cart-empty class="alert alert-secondary" role="alert">
							Корзина пуста
						</div>
						<div class="cart-wrapper"></div>
						<div class="cart-total">
							<p data-cart-delivery class="none">
								<span class="h5">Доставка:</span>
								<span class="delivery-cost">250 ₽</span><br />
								<span class="small">Бесплатно при заказе от&#160;600 ₽</span>
							</p>
							<p>
								<span class="h5">Итого:</span>
								<span class="total-price">0</span>
								<span class="rouble">₽</span>
							</p>
						</div>
					</div>
					<?php if ($orderSuccess): ?>
						<div class="card-body">
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								Спасибо, ваш заказ оформлен успешно!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						</div>
					<?php elseif ($orderError): ?>
						<div class="card-body">
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<?= $orderError; ?>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						</div>
					<?php endif; ?>
					<div id="order-form" class="card-body border-top none">
						<h5 class="card-title">Оформить заказ</h5>
						<form method="POST" id="orderForm">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Ваше имя" required name="name" minlength="2" pattern="[А-Яа-яA-Za-z\s]+" />
								<input type="tel" class="form-control mt-2" placeholder="Ваш номер телефона" required name="phone" />
								<input type="email" class="form-control mt-2" placeholder="Ваш email" required name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
								<input type="text" class="form-control mt-2" placeholder="Адрес доставки" required name="address" minlength="5" />
								<input type="hidden" name="cart" id="cartData" value="" />
								<input type="hidden" name="order_form" value="1" />
							</div>
							<button type="submit" class="btn btn-block btn-outline-warning mt-3">Заказать</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
include(ROOT . "templates/footer.tpl");
?>