document.addEventListener("DOMContentLoaded", function () {

	document.addEventListener("click", function (e) {
		const btnEdit = e.target.closest(".btnEdit");
		if (btnEdit) {
			e.preventDefault();
			const id = btnEdit.getAttribute("data-id");
			fetch("/hospital/pacientes/view_editar/" + id)
				.then((res) => res.text())
				.then((html) => {
					document.getElementById("dashboardContent").innerHTML = html;
				})
				.catch((err) => console.error("Error al cargar vista editar:", err));
			return;
		}

		const btnBack = e.target.closest("#btnBack");
		if (btnBack) {
			window.location.href = "pacientes";
			return;
		}

		const btnUpdate = e.target.closest("#btnUpdate");
		if (btnUpdate) {
			e.preventDefault();
			const formulario = document.querySelector("#formPaciente");
			const id = btnUpdate.dataset.id;
			if (!formulario) {
				console.error("Formulario no encontrado");
				return;
			}
			fetch(`pacientes/update/${id}`, {
				method: "POST",
				body: new FormData(formulario),
			})
				.then((res) => res.json())
				.then((data) => {
					Swal.fire({
						title: data.success ? "¡Éxito!" : "Error",
						text: data.message,
						icon: data.success ? "success" : "error",
						timer: 3000,
						timerProgressBar: true,
					}).then(() => {
						if (data.success) {
							window.location.href = "/hospital/dashboard/pacientes";
						}
					});
				})
				.catch((err) => console.error("Error en actualización:", err));
			return;
		}

		const btnNext = e.target.closest("#btnNext");
		if (btnNext) {
			const formStep1 = document.querySelector("#formStep1");
			const formStep2 = document.querySelector("#formStep2");
			if (formStep1 && formStep2) {
				formStep1.classList.add("inactive");
				formStep2.classList.remove("inactive");
			}
			return;
		}

		const btnCreate = e.target.closest("#btnCreate");
		if (btnCreate) {
			e.preventDefault();
			const formulario = document.querySelector("#formPaciente");
			if (!formulario) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Formulario no encontrado",
				});
				return;
			}
			fetch("pacientes/create", {
				method: "POST",
				body: new FormData(formulario),
			})
				.then((res) => res.json())
				.then((data) => {
					Swal.fire({
						title: data.success ? "¡Éxito!" : "Error",
						text: data.message,
						icon: data.success ? "success" : "error",
					});
					if (data.success) {
						const modal = bootstrap.Modal.getInstance(
							document.getElementById("addPacient")
						);
						if (modal) modal.hide();
						cargarPacientes();
					}
				})
				.catch((err) => {
					console.error("Error en la solicitud:", err);
					Swal.fire({
						icon: "error",
						title: "Error",
						text: "No se pudo procesar la solicitud",
					});
				});
			return;
		}

		const btnDelete = e.target.closest(".btnDelete");
		if (btnDelete) {
			e.preventDefault();
			const id = btnDelete.dataset.id;
			Swal.fire({
				title: "¿Estás seguro?",
				text: "Esta acción no se puede deshacer",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Sí, eliminar",
				cancelButtonText: "Cancelar",
			}).then((result) => {
				if (result.isConfirmed) {
					fetch(`pacientes/delete/${id}`, {
						method: "POST",
					})
						.then((res) => res.json())
						.then((data) => {
							Swal.fire({
								title: data.success ? "¡Éxito!" : "Error",
								text: data.message,
								icon: data.success ? "success" : "error",
							});
							if (data.success) cargarPacientes();
						})
						.catch((err) => {
							console.error("Error:", err);
							Swal.fire("Error", "No se pudo eliminar el paciente", "error");
						});
				}
			});
		}
	});
});
