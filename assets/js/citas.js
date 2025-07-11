document.addEventListener("DOMContentLoaded", function () {

	loadCalendar();
	function loadCalendar() {
		const calendarEl = document.querySelector("#calendar");
		const calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: "listWeek",
			themeSystem: "bootstrap5",
			headerToolbar: {
				left: "prev,next",
				center: "listWeek",
				right: "dayGridMonth,timeGridWeek,timeGridDay",
			},
			height: "100%",
			selectable: false,
			locale: "es",
			events: "/hospital/citas/get_next_citas_json",
			buttonText: {
				today: "Hoy",
				month: "Mes",
				week: "Semana",
				day: "Día",
				list: "Lista",
			},
		});
		calendar.render();
	}

	const formStep1 = document.getElementById("formStep1");
	const formStep2 = document.getElementById("formStep2");
	const formStep3 = document.getElementById("formStep3");
	const btnNext = document.getElementById("btnNext");
	const btnBackStep1 = document.getElementById("btnBackStep1");
	const messageAlert = document.getElementById("message-alert");

	if (formStep1) {
		btnNext.addEventListener("click", function () {
			const datos = new FormData();
			const fechaCita = document.getElementById("fecha_cita").value;
			const horaInicio = document.getElementById("hora_inicio").value;
			const especialidad = document.getElementById("especialidades").value;
			const duracion = document.getElementById("duracion").value;

			datos.append("fecha_cita", fechaCita);
			datos.append("hora_inicio", horaInicio);
			datos.append("especialidad", especialidad);
			datos.append("duracion", duracion);

			const originalHTML = btnNext.innerHTML;
			btnNext.disabled = true;
			btnNext.innerHTML = `<span class="loader-button"></span>`;
			messageAlert.classList.add("d-none");

			setTimeout(() => {
				fetch("/hospital/citas/verify_available_citas", {
					method: "POST",
					body: datos,
				})
					.then((res) => res.json())
					.then((res) => {
						btnNext.innerHTML = originalHTML;
						btnNext.disabled = false;

						if (
							res.status === "success" &&
							Array.isArray(res.medicos) &&
							res.medicos.length > 0
						) {
							formStep1.classList.add("inactive");
							formStep2.classList.remove("inactive");
							btnBackStep1.classList.remove("d-none");

							let html = "";

							res.medicos.forEach((medico) => {
								html += `
								<div style="background-color: var(--fondo-terciario);" class="d-flex flex-column w-100 rounded-3 p-3">
									<label class="d-flex w-100 justify-content-between align-items-center medico-radio-label">
										<input type="radio" name="medico" value="${medico.id_medico}" class="d-none" />
										<div class="d-flex flex-column justify-content-center">
											<h5 class="title-module mb-0">${medico.primer_nombre} ${
									medico.segundo_nombre ?? ""
								} ${medico.primer_apellido}</h5>
											<p class="card-text fs-6 mb-0">Médico ${medico.nombre_especialidad}</p>
										</div>
										<span style="cursor: pointer;" class="select-medico btn-green d-flex justify-content-center align-items-center text-white p-3">Seleccionar</span>
									</label>
								</div>
							`;
							});

							document.getElementById("contentMedicos").innerHTML = html;

							document
								.querySelectorAll(".medico-radio-label")
								.forEach((label) => {
									label.querySelector(".select-medico").onclick = function (e) {
										e.preventDefault();
										label.querySelector('input[type="radio"]').checked = true;

										console.log(
											"Seleccionado:",
											label.querySelector('input[type="radio"]').value
										);

										formStep2.classList.add("inactive");
										formStep3.classList.remove("inactive");
									};
								});
						} else {
							if (messageAlert) {
								messageAlert.classList.remove("d-none");
								messageAlert.textContent = res.message;
							}
						}
					})
					.catch((error) => {
						console.error("Error en el fetch:", error);
						btnNext.innerHTML = originalHTML;
						btnNext.disabled = false;

						if (messageAlert) {
							messageAlert.classList.remove("d-none");
							messageAlert.textContent =
								"Error al verificar disponibilidad de médicos.";
						}
					});
			}, 500);
		});
	}

	const form = document.getElementById("citasForm");

	form.addEventListener("submit", (e) => {
		e.preventDefault();

		const formData = new FormData(form);
		const data = {};

		// Recorremos los datos para depurarlos
		formData.forEach((value, key) => {
			data[key] = value;
		});

		console.log("Formulario enviado:", data);

		if (data.medico) {
			fetch("/hospital/citas/create_cita", {
				method: "POST",
				body: formData,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.status === "success") {
						Swal.fire({
							title: "Cita guardada",
							text: data.message,
							icon: "success",
							confirmButtonText: "Aceptar",
						}).then(() => {
							location.reload();
						});
					} else {
						Swal.fire({
							title: "Error",
							text: data.message,
							icon: "error",
							confirmButtonText: "Aceptar",
						});
					}
				})
				.catch((error) => {
					console.error("Error al guardar la cita:", error);
					Swal.fire({
						title: "Error",
						text: data.message || "No se pudo guardar la cita.",
						icon: "error",
						confirmButtonText: "Aceptar",
					});
				});
		}
	});

	document.querySelectorAll(".btnDelete").forEach((button) => {
		button.addEventListener("click", function () {
			const idCita = this.dataset.id;

			Swal.fire({
				title: "¿Estás seguro?",
				text: "Esta acción cancelará la cita.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Sí, cancelar",
				cancelButtonText: "No, salir",
			}).then((result) => {
				if (result.isConfirmed) {
					fetch("/hospital/citas/cancel_cita/" + idCita, {
						method: "POST",
					})
						.then((res) => res.json())
						.then((data) => {
							if (data.status === "success") {
								Swal.fire("Cancelado", data.message, "success").then(() => {
									location.reload();
								});
							} else {
								Swal.fire("Error", data.message, "error");
							}
						})
						.catch(() => {
							Swal.fire("Error", "No se pudo cancelar la cita.", "error");
						});
				}
			});
		});
	});

	const btnReagendar = document.getElementById("btnReagendar");

	if (btnReagendar) {
		btnReagendar.addEventListener("click", function () {
			const reagendarCita = document.getElementById("reagendarCita");
			const idCita = reagendarCita.querySelector('input[name="id_cita"]').value;
			console.log("ID de cita a reagendar:", idCita);
			if (idCita) {
				fetch("/hospital/citas/reagendar_cita", {
					method: "POST",
					body: new FormData(reagendarCita),
				})
					.then((res) => res.json())
					.then((data) => {
						if (data.status === "success") {
							Swal.fire({
								title: "Cita reagendada",
								text: data.message,
								icon: "success",
								confirmButtonText: "Aceptar",
							}).then(() => {
								location.reload();
							});
						} else {
							Swal.fire({
								title: "Error",
								text: data.message,
								icon: "error",
								confirmButtonText: "Aceptar",
							});
						}
					})
					.catch((error) => {
						console.error("Error al reagendar la cita:", error);
						Swal.fire({
							title: "Error",
							text: data.message || "No se pudo reagendar la cita.",
							icon: "error",
							confirmButtonText: "Aceptar",
						});
					});
			}
		});
	}

	btnBackStep1.addEventListener("click", function () {
		formStep1.classList.remove("inactive");
		formStep2.classList.add("inactive");
		formStep3.classList.add("inactive");
		btnBackStep1.classList.add("d-none");
	});
});
