document.addEventListener("DOMContentLoaded", function () {
	const btnmenu = document.getElementById("btnMenu");
	const navbar = document.getElementById("navbar");

	btnmenu.addEventListener("click", function () {
		navbar.classList.toggle("active");
	});
});
