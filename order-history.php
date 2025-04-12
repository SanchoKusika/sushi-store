<?php
require("config.php");
require("db.php");

if (!isset($_SESSION['user'])) {
	header("Location: login.php");
	exit;
}

$userId = $_SESSION['user']['id'];
$orders = R::find('orders', 'user_id = ?', [$userId]);

include(ROOT . "templates/head.tpl");
include(ROOT . "templates/header.tpl");
?>

<main>
	<div class="container my-5">
		<h2 class="order-title mb-4 fs-3">История заказов</h2>
		<?php if ($orders): ?>
			<?php foreach ($orders as $order): ?>
				<div class="order mb-4 p-4 border rounded shadow-sm">
					<div class="order-header mb-3 d-flex justify-content-between align-items-center">
						<span class="order-number fw-bold">Заказ № <?= $order->id ?></span>
						<span class="order-date text-muted"><?= $order->created_at ?></span>
					</div>
					<div class="order-summary mb-3">
						<p class="mb-0"><strong>Итого:</strong> <?= $order->total_price ?> ₽</p>
						<p class="mb-0"><strong>Доставка:</strong> <?= $order->delivery_cost ?> ₽</p>
						<p class="mb-0"><strong>Адрес доставки:</strong> <?= htmlspecialchars($order->address) ?></p>
					</div>
					<div class="order-items row">
						<?php 
						$orderItems = R::find('orderitems', 'order_id = ?', [$order->id]);
						if ($orderItems):
							foreach ($orderItems as $item):
								$product = R::load('products', $item->product_id);
						?>
							<div class="col-md-3 col-sm-6 mb-3">
								<div class="card order-history-card h-100">
									<img src="<?= HOST . $product->image ?>" class="card-img-top order-history-img" alt="<?= htmlspecialchars($product->title) ?>">
									<div class="card-body d-flex flex-column">
										<h5 class="card-title"><?= htmlspecialchars($product->title) ?></h5>
										<p class="card-text mb-0">
											Количество: <?= $item->quantity ?><br>
											Цена: <?= $item->price ?> ₽
										</p>
										<div class="mt-auto"></div>
									</div>
								</div>
							</div>
						<?php 
							endforeach;
						endif;
						?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<p class="text-center fs-4">Заказы отсутствуют.</p>
		<?php endif; ?>
	</div>
</main>

<?php
include(ROOT . "templates/footer.tpl");
?>
