	<footer class="footer">
		<div class="container">
			<div class="footer__copyright">
				<h1>&#169; Sushi Shop</h1>
			</div>
		</div>
	</footer>
<script src="<?= HOST ?>assets/js/index.bundle.js"></script>
<script>
document.getElementById('orderForm').addEventListener('submit', function(e) {
	const cartWrapper = document.querySelector(".cart-wrapper");
	const cartItems = [];
	cartWrapper.querySelectorAll(".cart-item").forEach(item => {
		cartItems.push({
			id: item.dataset.id,
			counter: item.querySelector("[data-counter]").innerText,
			price: item.querySelector(".price__currency").innerText
		});
	});
	document.getElementById('cartData').value = JSON.stringify(cartItems);
});
</script>
</body>
</html>