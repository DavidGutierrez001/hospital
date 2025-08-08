document.addEventListener("DOMContentLoaded", function () {
	const btnmenu = document.getElementById("btnMenu");
	const navbar = document.getElementById("navbar");
	const header = document.getElementById("header");

	btnmenu.addEventListener("click", function () {
		if (navbar.classList.contains("active")) {
			navbar.classList.remove("active");
			header.classList.remove("bg-white");
		} else {
			navbar.classList.add("active");
			header.classList.add("bg-white");
		}
	});

	window.addEventListener("scroll", function () {
		if (window.scrollY > 1) {
			header.classList.add("bg-white");
		} else {
			if (navbar.classList.contains("active")) {
				return;
			}
			header.classList.remove("bg-white");
		}
	});
});
