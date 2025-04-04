function adminTabs() {
	const navLinks = document.querySelectorAll(".admin__nav-link");
	const tabs = document.querySelectorAll(".admin__tab");

	navLinks.forEach((link) => {
		link.addEventListener("click", function(e) {
			e.preventDefault();
			navLinks.forEach((link) =>
				link.classList.remove("admin__nav-link--active")
			);
			tabs.forEach((tab) => tab.classList.remove("admin__tab--active"));
			this.classList.add("admin__nav-link--active");
			const tabId = this.getAttribute("data-tab");
			document.getElementById(tabId).classList.add("admin__tab--active");
		});
	});
}

export default adminTabs;
