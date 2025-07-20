document.addEventListener("DOMContentLoaded", function () {
	loadCalendar();

	const elements = {
		formStep1: document.getElementById("formStep1"),
		formStep2: document.getElementById("formStep2"),
		formStep3: document.getElementById("formStep3"),
		btnNext: document.getElementById("btnNext"),
		btnBackStep1: document.getElementById("btnBackStep1"),
		messageAlert: document.getElementById("message-alert"),
		contentMedicos: document.getElementById("contentMedicos"),
		form: document.getElementById("citasForm"),
		btnReagendar: document.getElementById("btnReagendar"),
		reagendarCita: document.querySelectorAll(".reagendarCita"),
	};

	function loadCalendar() {
		const calendarEl = document.querySelector("#calendar");
		if (!calendarEl) return;

		const calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: "listMonth",
			themeSystem: "bootstrap5",
			headerToolbar: {
				left: "",
				center: "listDay,listWeek,listMonth",
				right: "",
			},
			height: "100%",
			selectable: false,
			locale: "es",
			timeZone: "local",
			eventTimeFormat: {
				hour: "numeric",
				minute: "2-digit",
				hour12: true,
			},
			events: "/hospital/citas/get_next_citas_json",
			buttonText: {
				today: "Hoy",
				month: "Mes",
				week: "Semana",
				day: "Día",
			},
		});
		calendar.render();
	}

	function showLoader(button, show = true) {
		if (show) {
			button.dataset.original = button.innerHTML;
			button.disabled = true;
			button.innerHTML = `<span class="loader-button"></span>`;
		} else {
			button.disabled = false;
			button.innerHTML = button.dataset.original || "Continuar";
		}
	}

	function renderMedico(medico) {
		return `
			<div style="background-color: var(--fondo-terciario);" class="d-flex flex-column w-100 rounded-3 p-3">
				<label class="d-flex w-100 justify-content-between align-items-center medico-radio-label">
					<input type="radio" name="medico" value="${medico.id_medico}" class="d-none" />
					<div class="d-flex flex-column justify-content-center">
						<h5 class="title-module mb-0">${
							medico.primer_nombre
						} ${medico.segundo_nombre ?? ""} ${medico.primer_apellido}</h5>
						<p class="card-text fs-6 mb-0">Médico ${medico.nombre_especialidad}</p>
					</div>
					<span class="select-medico btn-green d-flex justify-content-center align-items-center text-white p-3" style="cursor: pointer;">Seleccionar</span>
				</label>
			</div>
		`;
	}

	function confirmarAccion(texto, url, onSuccess) {
		Swal.fire({
			title: "¿Estás seguro?",
			text: texto,
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Sí, continuar",
			cancelButtonText: "No",
		}).then((result) => {
			if (result.isConfirmed) {
				fetch(url, { method: "POST" })
					.then((res) => res.json())
					.then(onSuccess)
					.catch(() => {
						Swal.fire("Error", "No se pudo completar la acción.", "error");
					});
			}
		});
	}

	if (elements.formStep1) {
		elements.btnNext.addEventListener("click", function () {
			const datos = new FormData();
			datos.append("fecha_cita", document.getElementById("fecha_cita").value);
			datos.append("hora_inicio", document.getElementById("hora_inicio").value);
			datos.append(
				"especialidad",
				document.getElementById("especialidades").value
			);
			datos.append("duracion", document.getElementById("duracion").value);

			showLoader(elements.btnNext);
			elements.messageAlert.classList.add("d-none");

			fetch("/hospital/citas/verify_available_citas", {
				method: "POST",
				body: datos,
			})
				.then((res) => res.json())
				.then((res) => {
					showLoader(elements.btnNext, false);

					if (
						res.status === "success" &&
						Array.isArray(res.medicos) &&
						res.medicos.length > 0
					) {
						elements.formStep1.classList.add("inactive");
						elements.formStep2.classList.remove("inactive");
						elements.btnBackStep1.classList.remove("d-none");

						elements.contentMedicos.innerHTML = res.medicos
							.map(renderMedico)
							.join("");

						document
							.querySelectorAll(".medico-radio-label")
							.forEach((label) => {
								label.querySelector(".select-medico").onclick = function (e) {
									e.preventDefault();
									label.querySelector('input[type="radio"]').checked = true;
									elements.formStep2.classList.add("inactive");
									elements.formStep3.classList.remove("inactive");
								};
							});
					} else {
						elements.messageAlert.classList.remove("d-none");
						elements.messageAlert.textContent = res.message;
					}
				})
				.catch((error) => {
					console.error("Error en el fetch:", error);
					showLoader(elements.btnNext, false);
					elements.messageAlert.classList.remove("d-none");
					elements.messageAlert.textContent =
						"Error al verificar disponibilidad de médicos.";
				});
		});
	}

	if (elements.form) {
		elements.form.addEventListener("submit", (e) => {
			e.preventDefault();

			const formData = new FormData(elements.form);
			const data = {};
			formData.forEach((value, key) => (data[key] = value));

			if (data.medico) {
				fetch("/hospital/citas/create_cita", {
					method: "POST",
					body: formData,
				})
					.then((res) => res.json())
					.then((res) => {
						if (res.status === "success") {
							Swal.fire("Cita guardada", res.message, "success").then(() =>
								location.reload()
							);
						} else {
							Swal.fire("Error", res.message, "error");
						}
					})
					.catch((err) => {
						console.error("Error al guardar la cita:", err);
						Swal.fire("Error", "No se pudo guardar la cita.", "error");
					});
			}
		});
	}

	document.querySelectorAll(".btnDelete").forEach((button) => {
		button.addEventListener("click", function () {
			const idCita = this.dataset.id;
			confirmarAccion(
				"Esta acción cancelará la cita.",
				`/hospital/citas/cancel_cita/${idCita}`,
				(data) => {
					if (data.status === "success") {
						Swal.fire("Cancelado", data.message, "success").then(() =>
							location.reload()
						);
					} else {
						Swal.fire("Error", data.message, "error");
					}
				}
			);
		});
	});

	document.querySelectorAll(".btnReagendar").forEach((button) => {
		button.addEventListener("click", function () {
			const idCita = this.dataset.id;

			const form = document.getElementById(`reagendarCita-${idCita}`);
			if (!form) {
				console.warn(`Formulario reagendarCita-${idCita} no encontrado`);
				return;
			}

			console.log("Reagendando cita:", idCita);

			fetch("/hospital/citas/reagendar_cita", {
				method: "POST",
				body: new FormData(form),
			})
				.then((res) => res.json())
				.then((data) => {
					if (data.status === "success") {
						Swal.fire("Cita reagendada", data.message, "success").then(() =>
							location.reload()
						);
					} else {
						Swal.fire("Error", data.message, "error");
					}
				})
				.catch((error) => {
					console.error("Error al reagendar:", error);
					Swal.fire("Error", "No se pudo reagendar la cita.", "error");
				});
		});
	});

	elements.btnBackStep1?.addEventListener("click", function () {
		elements.formStep1.classList.remove("inactive");
		elements.formStep2.classList.add("inactive");
		elements.formStep3.classList.add("inactive");
		elements.btnBackStep1.classList.add("d-none");
	});
});
