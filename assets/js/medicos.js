document.addEventListener("DOMContentLoaded", function (e) {
	document.addEventListener("click", function (e) {
		const btnBack = e.target.closest("#btnBack");
		if (btnBack) {
			window.location.href = "medicos";
			return;
		}

		const btnUpdate = e.target.closest("#btnUpdate");
		if (btnUpdate) {
			e.preventDefault();
			const formulario = document.querySelector("#formMedico");
			const id = btnUpdate.dataset.id;
			if (!formulario) {
				console.error("Formulario no encontrado");
				return;
			}
			fetch(`/hospital/medicos/update/${id}`, {
				method: "POST",
				body: new FormData(formulario),
			})
				.then((res) => res.json())
				.then((data) => {
					Swal.fire({
						title: data.success ? "¡Éxito!" : "Error",
						text: data.message,
						icon: data.success ? "success" : "error",
						timer: 2000,
						timerProgressBar: true,
					}).then(() => {
						if (data.success) {
							window.location.href = "/hospital/dashboard/medicos";
						}
					});
				})
				.catch((err) => console.error("Error en actualización:", err));
		}

		const btnNext = e.target.closest("#btnNext");
		if (btnNext) {
			const formStep1 = document.querySelector("#formStep1");
			const formStep2 = document.querySelector("#formStep2");
			const btnBackStep1 = document.querySelector("#btnBackStep1");

			if (formStep1 && formStep2) {
				formStep1.classList.add("inactive");
				formStep2.classList.remove("inactive");
			}
			if (formStep1.classList.contains("inactive")) {
				btnBackStep1.classList.remove("d-none");
			}
		}

		const btnBackStep1 = e.target.closest("#btnBackStep1");
		if (btnBackStep1) {
			const formStep1 = document.querySelector("#formStep1");
			const formStep2 = document.querySelector("#formStep2");
			if (formStep1 && formStep2) {
				formStep1.classList.remove("inactive");
				formStep2.classList.add("inactive");
				btnBackStep1.classList.add("d-none");
			}
			return;
		}

		const btnEdit = e.target.closest(".btnEdit");
		if (btnEdit) {
			e.preventDefault();
			const id = btnEdit.getAttribute("data-id");
			fetch("/hospital/medicos/view_editar/" + id)
				.then((res) => res.text())
				.then((html) => {
					document.getElementById("dashboardContent").innerHTML = html;
				})
				.catch((err) => console.error("Error al cargar vista editar:", err));
			return;
		}
	});

	const btnCreate = document.getElementById("btnCreate");
	if (btnCreate) {
		btnCreate.addEventListener("click", function (e) {
			e.preventDefault();

			const formMedico = document.querySelector("#formMedico");
			if (!formMedico) {
				console.error("Formulario de médico no encontrado");
				return;
			}

			fetch("/hospital/medicos/create", {
				method: "POST",
				body: new FormData(formMedico),
			})
				.then((res) => res.json())
				.then((data) => {
					Swal.fire({
						title: data.success ? "¡Éxito!" : "Error",
						text: data.message,
						icon: data.success ? "success" : "error",
						timer: data.success ? 2000 : false,
						timerProgressBar: true,
					}).then(() => {
						if (data.success) {
							window.location.href = "/hospital/dashboard/medicos";
						}
					});
				})
				.catch((err) => {
					console.error("Error al procesar la solicitud:", err);
					Swal.fire({
						title: "Error",
						text: "Ocurrió un error al comunicarse con el servidor.",
						icon: "error",
					});
				});
		});
	}

	const btnDelete = document.querySelectorAll(".btnDelete");
	if (btnDelete.length > 0) {
		btnDelete.forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const id = this.id;
				Swal.fire({
					title: "¿Estás seguro?",
					text: "Esta acción no se puede deshacer.",
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: "Sí, eliminar",
					cancelButtonText: "Cancelar",
				}).then((result) => {
					if (result.isConfirmed) {
						fetch(`/hospital/medicos/delete/${id}`, {
							method: "DELETE",
						})
							.then((res) => res.json())
							.then((data) => {
								Swal.fire({
									title: data.success ? "¡Éxito!" : "Error",
									text: data.message,
									icon: data.success ? "success" : "error",
								}).then(() => {
									if (data.success) window.location.reload();
								});
							})
							.catch((err) => console.error("Error al eliminar:", err));
					}
				});
			});
		});
	}
});
