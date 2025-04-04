function calcCartPriceAndDelivery() {
	const cartWrapper = document.querySelector(".cart-wrapper");
	const priceElements = cartWrapper.querySelectorAll(".price__currency");
	const totalPriceEl = document.querySelector(".total-price");
	const deliveryCost = document.querySelector(".delivery-cost");
	const cartDelivery = document.querySelector("[data-cart-delivery]");

	let priceTotal = 0;
	priceElements.forEach((item) => {
		const amountEl = item
			.closest(".cart-item")
			.querySelector("[data-counter]");
		priceTotal += parseInt(item.innerText) * parseInt(amountEl.innerText);
	});

	let deliveryCostValue = priceTotal > 0 && priceTotal < 600 ? 250 : 0;

	const totalWithDelivery = priceTotal + deliveryCostValue;

	totalPriceEl.innerText = totalWithDelivery;

	if (priceTotal >= 600 || priceTotal === 0) {
		deliveryCost.classList.add("free");
		deliveryCost.innerText = "бесплатно";
	} else {
		deliveryCost.classList.remove("free");
		deliveryCost.innerText = "250 ₽";
	}

	cartDelivery.classList.toggle("none", priceTotal === 0);
}

export default calcCartPriceAndDelivery;
