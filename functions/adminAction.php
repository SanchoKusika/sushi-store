<?php
require_once(ROOT . "db.php");

function addProduct($data, $file) {
	if (!empty($data['title']) && !empty($data['price']) && !empty($data['weight'])) {
		$product = R::dispense('products');
		$product->title = $data['title'];
		$product->price = $data['price'];
		$product->weight = $data['weight'];

		if ($file && $file['error'] == 0) {
			$uploadDir = ROOT . 'assets/img/roll/';
			$filename = basename($file['name']);
			$targetFile = $uploadDir . $filename;
			if (move_uploaded_file($file['tmp_name'], $targetFile)) {
				$product->image = 'assets/img/roll/' . $filename;
			} else {
				return "Ошибка загрузки изображения";
			}
		}

		R::store($product);
		return true;
	}
	return "Заполните все обязательные поля";
}

function updateProduct($id, $data, $file) {
	$product = R::load('products', $id);
	if (!$product->id) {
		return "Продукт не найден";
	}
	$product->title = $data['title'];
	$product->price = $data['price'];
	$product->weight = $data['weight'];

	if ($file && $file['error'] == 0) {
		$uploadDir = ROOT . 'assets/img/roll/';
		$filename = basename($file['name']);
		$targetFile = $uploadDir . $filename;
		if (move_uploaded_file($file['tmp_name'], $targetFile)) {
			$product->image = 'assets/img/roll/' . $filename;
		} else {
			return "Ошибка загрузки изображения";
		}
	}
	R::store($product);
	return true;
}

function deleteProduct($id) {
	$product = R::load('products', $id);
	if ($product->id) {
		R::trash($product);
		return true;
	}
	return "Продукт не найден";
}

function getAllProducts() {
	return R::findAll('products');
}

function getAllUsers() {
	return R::findAll('users');
}

function getAllOrders() {
	return R::findAll('orders');
}
?>
