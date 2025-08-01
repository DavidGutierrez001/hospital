document.addEventListener("DOMContentLoaded", function () {
	const switchForMedico = document.querySelectorAll(".switchForMedico");
	const medicoExportarSpan = document.querySelectorAll(".medico_exportar_span");

	switchForMedico.forEach((switchMedico) => {
		switchMedico.addEventListener("change", function () {
			if (this.checked) {
				medicoExportarSpan.forEach((span) => {
					span.innerHTML = `
						<input type="text" class="form-control" id="medico_exportar" name="medico_exportar" placeholder="Documento del médico" maxlength="11" autocomplete="off" required>
					`;
				});
			} else {
				medicoExportarSpan.forEach((span) => {
					span.innerHTML = "";
				});
			}
		});
	});
});
