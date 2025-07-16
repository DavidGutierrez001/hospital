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

				const id_paciente = btn.getAttribute("data-id");
				const contentLoader = document.querySelector(".content-loader");
				const contentHistorial = document.getElementById("contentHistorial");
				contentHistorial.textContent = "";

				if (id_paciente) {
					contentLoader.classList.remove("d-none");
					setTimeout(() => {
						fetch("/hospital/historial/get_historial_by_id/" + id_paciente)
							.then((response) => response.json())
							.then((data) => {
								contentLoader.classList.add("d-none");
								if (data.success) {
									contentHistorial.innerHTML = `
                            <section class="d-flex my-3 gap-3 p-3 rounded-3">
                                        <div class="d-flex gap-3">
                                            <span class="profile-pacient rounded-3"> </span>
                                            <div class="d-flex flex-column gap-2">
                                                <h6 class="fw-bold">${
																									data.historial[
																										"paciente_primer_apellido"
																									]
																								} ${
										data.historial["paciente_segundo_apellido"]
									} ${data.historial["paciente_primer_nombre"]} ${
										data.historial["paciente_segundo_nombre"]
									}</h6>
                                                <h6 class="small fw-medium opacity-50">${
																									data.historial[
																										"paciente_email"
																									]
																								}</h6>
                                                <div class="d-flex gap-3 align-items-center flex-wrap">
                                                    <div class="d-flex gap-1 align-items-center">
                                                        <i class="bi bi-person-fill"></i>
                                                        <span class="small text-secondary">${
																													data.historial[
																														"genero"
																													]
																												}</span>
                                                    </div>
                                                    <div class="d-flex gap-1 align-items-center">
                                                        <i class="bi bi-geo-alt-fill"></i>
                                                        <span class="small text-secondary">${
																													data.historial[
																														"direccion"
																													]
																												}</span>
                                                    </div>
                                                    <div class="d-flex gap-1 align-items-center">
                                                        <i class="bi bi-cake2-fill"></i>
                                                        <span class="small text-secondary">${
																													data.historial[
																														"fecha_nacimiento"
																													]
																												}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="d-flex flex-column my-3 gap-3 p-3 rounded-3">
                                        <div class="accordion" id="historialAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingMedico">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMedico" aria-expanded="false" aria-controls="collapseMedico">
                                                        Médico y Motivo de Consulta
                                                    </button>
                                                </h2>
                                                <div id="collapseMedico" class="accordion-collapse collapse" aria-labelledby="headingMedico" data-bs-parent="#historialAccordion">
                                                    <div class="accordion-body d-flex justify-content-between align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="title-module fw-bold">MÉDICO:</h6>
                                                            <span class="fw-medium small text-secondary">${
																															data.historial[
																																"medico_primer_apellido"
																															]
																														} ${
										data.historial["medico_segundo_apellido"]
									} ${data.historial["medico_primer_nombre"]} ${
										data.historial["medico_segundo_nombre"]
									}</span>
                                                            <span class="fw-medium small text-secondary"> </span>
                                                        </div>
                                                        <div>
                                                            <h6 class="title-module fw-bold">MOTIVO CONSULTA</h6>
                                                            <span class="fw-medium small fw-bold">${
																															data.historial[
																																"motivo_consulta"
																															]
																														}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingDiagnostico">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiagnostico" aria-expanded="false" aria-controls="collapseDiagnostico">
                                                        Diagnóstico
                                                    </button>
                                                </h2>
                                                <div id="collapseDiagnostico" class="accordion-collapse collapse" aria-labelledby="headingDiagnostico" data-bs-parent="#historialAccordion">
                                                    <div class="accordion-body">
                                                        <h6 class="title-module fw-bold">DIAGNÓSTICO:</h6>
                                                        <span class="fw-medium small text-secondary">${
																													data.historial[
																														"diagnostico"
																													]
																												}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTratamiento">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTratamiento" aria-expanded="false" aria-controls="collapseTratamiento">
                                                        Tratamiento
                                                    </button>
                                                </h2>
                                                <div id="collapseTratamiento" class="accordion-collapse collapse" aria-labelledby="headingTratamiento" data-bs-parent="#historialAccordion">
                                                    <div class="accordion-body">
                                                        <h6 class="title-module fw-bold">TRATAMIENTO</h6>
                                                        <span class="fw-medium small text-secondary">${
																													data.historial[
																														"tratamiento"
																													]
																												}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingAntecedentes">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAntecedentes" aria-expanded="false" aria-controls="collapseAntecedentes">
                                                        Antecedentes Familiares
                                                    </button>
                                                </h2>
                                                <div id="collapseAntecedentes" class="accordion-collapse collapse" aria-labelledby="headingAntecedentes" data-bs-parent="#historialAccordion">
                                                    <div class="accordion-body">
                                                        <h6 class="title-module fw-bold">ANTECEDENTES FAMILIARES</h6>
                                                        <span class="fw-medium small text-secondary">${
																													data.historial[
																														"antecedentes_familiares"
																													]
																												}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingEstiloVida">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstiloVida" aria-expanded="false" aria-controls="collapseEstiloVida">
                                                        Estilo de Vida
                                                    </button>
                                                </h2>
                                                <div id="collapseEstiloVida" class="accordion-collapse collapse" aria-labelledby="headingEstiloVida" data-bs-parent="#historialAccordion">
                                                    <div class="accordion-body">
                                                        <h6 class="title-module fw-bold">ESTILO DE VIDA</h6>
                                                        <span class="fw-medium small text-secondary">${
																													data.historial[
																														"estilo_vida"
																													]
																												}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingNotasGenerales">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotasGenerales" aria-expanded="false" aria-controls="collapseNotasGenerales">
                                                        Notas Generales
                                                    </button>
                                                </h2>
                                                <div id="collapseNotasGenerales" class="accordion-collapse collapse" aria-labelledby="headingNotasGenerales" data-bs-parent="#historialAccordion">
                                                    <div class="accordion-body">
                                                        <h6 class="title-module fw-bold">NOTAS GENERALES</h6>
                                                        <span class="fw-medium small text-secondary">${
																													data.historial[
																														"notas_generales"
																													]
																												}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="p-3 lh-2-5 rounded-3 d-flex justify-content-center align-items-center gap-2">
                                        <span class="title-module fw-bold">Proxima Cita</span>
                                        <span class="fw-medium small fw-bold">
                                            ${!data.historial["proxima_cita"] || data.historial["proxima_cita"] === "null"
                                                ? "Sin fecha programada"
                                                : data.historial["proxima_cita"]
                                            }
                                        </span>
                                    </section>
                                `;
								} else {
									console.error(
										"Error al cargar el historial médico:",
										data.message
									);
								}
							});
					}, 500);
				}
			});
		});
	}

	document.addEventListener("click", function (e) {
		if (!offcanvas.contains(e.target)) {
			offcanvas.classList.add("off");
		}
	});
});
