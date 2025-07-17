document.addEventListener("DOMContentLoaded", function () {
	const offcanvas = document.getElementById("offcanvasHistorial");
	const showDetails = document.querySelectorAll(".showDetails");
	const closeOffcanvas = document.getElementById("closeOffCanvas");

	closeOffcanvas.addEventListener("click", function () {
		offcanvas.classList.toggle("off");
	});

	if (offcanvas) {
		showDetails.forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.stopPropagation();
				offcanvas.classList.toggle("off");

				const id_historial = btn.getAttribute("data-id");
				const contentLoader = document.querySelector(".content-loader");
				const contentHistorial = document.getElementById("contentHistorial");
				contentHistorial.textContent = "";

				if (id_historial) {
					contentLoader.classList.remove("d-none");
					setTimeout(() => {
						fetch("/hospital/historial/get_historial_by_id/" + id_historial)
							.then((response) => response.json())
							.then((data) => {
								contentLoader.classList.add("d-none");
								if (data.success) {
									document.getElementById("contentHistorial").innerHTML =
										data.historial;
								} else {
									alert(data.message);
								}
							});
					}, 800);
				}
			});
		});
	}

	document.addEventListener("click", function (e) {
		if (!offcanvas.contains(e.target)) {
			offcanvas.classList.add("off");
		}
	});

	const btnAdd = document.getElementById("btnAdd");
	if (btnAdd) {
		const historialForm = document.getElementById("historialForm");

		historialForm.addEventListener("submit", function (e) {
			e.preventDefault();
			const form = e.target;
			const datos = new FormData(form);

			fetch("/hospital/historial/create_historial", {
				method: "POST",
				body: datos,
			})
				.then((res) => res.json())
				.then((data) => {
					Swal.fire({
						icon: data.success ? "success" : "error",
						title: data.success ? "Éxito" : "Error",
						text: data.message,
					}).then(() => {
						if (data.success) {
							window.location.reload();
						}
					});
				})
				.catch((err) => {
					console.error(err);
				});
		});
	}

	const deleteDetails = document.querySelectorAll(".deleteDetails");

	if (deleteDetails) {
		deleteDetails.forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.stopPropagation();
				const id_historial = btn.getAttribute("data-id");

				Swal.fire({
					title: "¿Estás seguro?",
					text: "Esta acción eliminará el historial de este paciente",
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: "Sí, eliminar",
					cancelButtonText: "Cancelar",
				}).then((result) => {
					if (result.isConfirmed) {
						fetch("/hospital/historial/delete_historial/" + id_historial)
							.then((response) => response.json())
							.then((data) => {
								Swal.fire({
									icon: data.success ? "success" : "error",
									title: data.success ? "Éxito" : "Error",
									text: data.message,
								}).then(() => {
									if (data.success) {
										window.location.reload();
									}
								});
							});
					} else {
						return;
					}
				});
			});
		});
	}
});
