document.addEventListener("DOMContentLoaded", function () {
	// Modo oscuro/claro
	const savedTheme = localStorage.getItem("theme") || "light";
	document.documentElement.setAttribute("data-theme", savedTheme);

	const btnTheme = document.getElementById("btnTheme");
	if (btnTheme) {
		btnTheme.addEventListener("click", () => {
			const currentTheme = document.documentElement.getAttribute("data-theme");
			const newTheme = currentTheme === "dark" ? "light" : "dark";
			document.documentElement.setAttribute("data-theme", newTheme);
			localStorage.setItem("theme", newTheme);
		});
	}

	// Logout
	const btnLogout = document.getElementById("btnLogout");
	if (btnLogout) {
		btnLogout.addEventListener("click", () => {
			Swal.fire({
				title: "Atención!",
				text: "Estas a punto de cerrar sesión. ¿Estás seguro?",
				icon: "warning",
				iconColor: "var(--texto)",
				confirmButtonText: "Sí, cerrar sesión",
				cancelButtonText: "Cancelar",
				confirmButtonColor: "var(--nav-selected)",
				cancelButtonColor: "var(--nav-selected)",
				background: "var(--fondo-hover-secundario)",
				showCancelButton: true,
				color: "var(--texto)",
			}).then((result) => {
				if (result.isConfirmed) {
					fetch("logout")
						.then((res) => {
							if (res.ok) {
								window.location.href = "/hospital";
							} else {
								throw new Error("Error al cerrar sesión");
							}
						})
						.catch((err) => {
							Swal.fire({
								title: "Error",
								text: err.message,
								icon: "error",
							});
						});
				}
			});
		});
	}

	const sidebarBtn = document.querySelector("#sidebarBtn");
	const sidebarContent = document.querySelector("#sidebarContent");
	const Backdrop = document.getElementById("backDrop");

	if (sidebarBtn && sidebarContent) {
		// Toggle sidebar al hacer click en el botón
		sidebarBtn.addEventListener("click", (e) => {
			e.stopPropagation(); // Evita que el click se propague al document
			sidebarContent.classList.toggle("active");
			Backdrop.classList.toggle("active");
		});

		// Cerrar sidebar al hacer click fuera de él
		document.addEventListener("click", (e) => {
			const isClickInsideSidebar = sidebarContent.contains(e.target);
			const isClickOnButton = e.target.closest("#sidebarBtn");

			if (
				sidebarContent.classList.contains("active") &&
				!isClickInsideSidebar &&
				!isClickOnButton
			) {
				sidebarContent.classList.remove("active");
				Backdrop.classList.remove("active");
			}
		});
	} else {
		console.warn("#sidebarBtn o #sidebarContent no encontrados");
	}

	const originalIcon = `<i style="color: var(--texto);" class="bi bi-copy fs-6"></i>`;

	document.querySelectorAll(".copyButton").forEach((btn) => {
		btn.addEventListener("click", function () {
			const textToCopy = btn
				.closest(".copy-container")
				?.querySelector(".copyText")?.textContent;

			if (!textToCopy) return;

			document.querySelectorAll(".copyButton").forEach((b) => {
				b.innerHTML = originalIcon;
			});

			navigator.clipboard
				.writeText(textToCopy)
				.then(() => {
					btn.innerHTML = `<i class="bi bi-check-circle-fill text-success fs-6"></i>`;
				})
				.catch(() => {
					btn.innerHTML = `<i class="bi bi-x-circle text-danger fs-6"></i>`;
				});
		});
	});
});
