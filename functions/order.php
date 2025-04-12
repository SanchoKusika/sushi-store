<?php
require_once(ROOT . "db.php");

function placeOrder($orderData, $cartItems) {
	$totalPrice = 0;
	foreach ($cartItems as $item) {
		$quantity = intval($item['counter']);
		$price = floatval($item['price']);
		$totalPrice += $quantity * $price;
	}

	$deliveryCost = ($totalPrice > 0 && $totalPrice < 600) ? 250 : 0;
	$totalPriceWithDelivery = $totalPrice + $deliveryCost;

	$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : NULL;

	$order = R::dispense('orders');
	$order->user_id = $userId;
	$order->name = $orderData['name'];
	$order->phone = $orderData['phone'];
	$order->email = $orderData['email'];
	$order->address = $orderData['address'];
	$order->total_price = $totalPriceWithDelivery;
	$order->delivery_cost = $deliveryCost;
	$orderId = R::store($order);

	foreach ($cartItems as $item) {
		$orderItem = R::dispense('orderitems');
		$orderItem->order_id = $orderId;
		$orderItem->product_id = $item['id'];
		$orderItem->quantity = intval($item['counter']);
		$orderItem->price = floatval($item['price']);
		R::store($orderItem);
	}

	return $orderId;
}
?>
