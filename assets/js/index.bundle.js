!(function () {
	"use strict";
	var t = function () {
			const t = document.querySelector(".cart-wrapper"),
				e = document.querySelector("[data-cart-empty]"),
				r = document.querySelector("#order-form");
			t.children.length > 0
				? (e.classList.add("none"), r.classList.remove("none"))
				: (e.classList.remove("none"), r.classList.add("none"));
		},
		e = function () {
			const t = document
					.querySelector(".cart-wrapper")
					.querySelectorAll(".price__currency"),
				e = document.querySelector(".total-price"),
				r = document.querySelector(".delivery-cost"),
				n = document.querySelector("[data-cart-delivery]");
			let c = 0;
			t.forEach((t) => {
				const e = t
					.closest(".cart-item")
					.querySelector("[data-counter]");
				c += parseInt(t.innerText) * parseInt(e.innerText);
			});
			const i = c + (c > 0 && c < 600 ? 250 : 0);
			(e.innerText = i),
				c >= 600 || 0 === c
					? (r.classList.add("free"), (r.innerText = "бесплатно"))
					: (r.classList.remove("free"), (r.innerText = "250 ₽")),
				n.classList.toggle("none", 0 === c);
		};
	window.addEventListener("click", function (r) {
		let n;
		("plus" !== r.target.dataset.action &&
			"minus" !== r.target.dataset.action) ||
			(n = r.target
				.closest(".counter-wrapper")
				.querySelector("[data-counter]")),
			"plus" === r.target.dataset.action && (n.innerText = ++n.innerText),
			"minus" === r.target.dataset.action &&
				(parseInt(n.innerText) > 1
					? (n.innerText = --n.innerText)
					: r.target.closest(".cart-wrapper") &&
					  1 === parseInt(n.innerText) &&
					  (r.target.closest(".cart-item").remove(), t(), e())),
			r.target.hasAttribute("data-action") &&
				r.target.closest(".cart-wrapper") &&
				e();
	}),
		(function () {
			const r = document.querySelector(".cart-wrapper");
			window.addEventListener("click", function (n) {
				if (n.target.hasAttribute("data-cart")) {
					const c = n.target.closest(".card"),
						i = {
							id: c.dataset.id,
							imgSrc: c
								.querySelector(".product-img")
								.getAttribute("src"),
							title: c.querySelector(".item-title").innerText,
							itemsInBox: c.querySelector("[data-items-in-box]")
								.innerText,
							weight: c.querySelector(".price__weight").innerText,
							price: c.querySelector(".price__currency")
								.innerText,
							counter:
								c.querySelector("[data-counter]").innerText,
						},
						a = r.querySelector(`[data-id="${i.id}"]`);
					if (a) {
						const t = a.querySelector("[data-counter]");
						t.innerText =
							parseInt(t.innerText) + parseInt(i.counter);
					} else {
						const t = `<div class="cart-item" data-id="${i.id}">\n\t\t\t\t\t\t\t\t<div class="cart-item__top">\n\t\t\t\t\t\t\t\t\t<div class="cart-item__img">\n\t\t\t\t\t\t\t\t\t\t<img src="${i.imgSrc}" alt="${i.title}">\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<div class="cart-item__desc">\n\t\t\t\t\t\t\t\t\t\t<div class="cart-item__title">${i.title}</div>\n\t\t\t\t\t\t\t\t\t\t<div class="cart-item__weight">${i.itemsInBox} / ${i.weight}</div>\n\n\t\t\t\t\t\t\t\t\t\t\x3c!-- cart-item__details --\x3e\n\t\t\t\t\t\t\t\t\t\t<div class="cart-item__details">\n\n\t\t\t\t\t\t\t\t\t\t\t<div class="items items--small counter-wrapper">\n\t\t\t\t\t\t\t\t\t\t\t\t<div class="items__control" data-action="minus">-</div>\n\t\t\t\t\t\t\t\t\t\t\t\t<div class="items__current" data-counter="">${i.counter}</div>\n\t\t\t\t\t\t\t\t\t\t\t\t<div class="items__control" data-action="plus">+</div>\n\t\t\t\t\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t\t\t\t\t<div class="price">\n\t\t\t\t\t\t\t\t\t\t\t\t<div class="price__currency">${i.price}</div>\n\t\t\t\t\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t\t\x3c!-- // cart-item__details --\x3e\n\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>`;
						r.insertAdjacentHTML("beforeend", t);
					}
					(c.querySelector("[data-counter]").innerText = "1"),
						t(),
						e();
				}
			});
		})(),
		(function () {
			const t = document.querySelectorAll(".admin__nav-link"),
				e = document.querySelectorAll(".admin__tab");
			t.forEach((r) => {
				r.addEventListener("click", function (r) {
					r.preventDefault(),
						t.forEach((t) =>
							t.classList.remove("admin__nav-link--active")
						),
						e.forEach((t) =>
							t.classList.remove("admin__tab--active")
						),
						this.classList.add("admin__nav-link--active");
					const n = this.getAttribute("data-tab");
					document
						.getElementById(n)
						.classList.add("admin__tab--active");
				});
			});
		})();
})();
