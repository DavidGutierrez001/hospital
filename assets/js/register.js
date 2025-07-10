document.addEventListener("DOMContentLoaded", function () {

	const containForm = document.getElementById("containForm");
	const btnNext = document.getElementById("btnNext");
	const step1 = document.getElementById("step1");
	const step2 = document.getElementById("step2");
	const stepInfo = document.getElementById("stepInfo");
	const showPassword = document.getElementById("showPassword");
	const password = document.getElementById("password");


	if (showPassword && password) {
		showPassword.addEventListener("click", function () {
			if (password.type === "password") {
				password.type = "text";
				showPassword.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
			} else {
				password.type = "password";
				showPassword.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
			}
		});
	} else {
		console.warn("No se encontró el botón 'Mostrar contraseña' o el input.");
	}

	
	if (btnNext) {
		btnNext.addEventListener("click", handleNextClick);
	}

	
	if (step1) {
		step1.addEventListener("keydown", function (e) {
			if (e.key === "Enter") {
				e.preventDefault();
				handleNextClick();
			}
		});
	}

	
	if (containForm) {
		containForm.addEventListener("submit", function (e) {
			if (step1.classList.contains("active")) {
				e.preventDefault();
				handleNextClick();
			}
		});
	}

	// Delay utilitario
	function wait(ms) {
		return new Promise((resolve) => setTimeout(resolve, ms));
	}


	async function handleNextClick() {
		const email = document.getElementById("email");
		const password = document.getElementById("password");
		const btnText = document.getElementById("btnText");
		const errorEmail = document.getElementById("errorEmail");
		errorEmail.classList.add("d-none");

		if (!email.checkValidity() || !password.checkValidity()) {
			containForm.classList.remove("shake-horizontal");
			void containForm.offsetWidth;
			containForm.classList.add("shake-horizontal");

			email.classList.toggle("input-error", !email.checkValidity());
			password.classList.toggle("input-error", !password.checkValidity());
			return;
		}

		email.classList.remove("input-error");
		password.classList.remove("input-error");
		btnText.textContent = "";
		btnText.classList.add("loader");

		try {
			const [resp] = await Promise.all([
				fetch("/hospital/verify_email", {
					method: "POST",
					headers: { "Content-Type": "application/json" },
					body: JSON.stringify({ email: email.value }),
				}),
				wait(500),
			]);

			const data = await resp.json();
			const errorEmail = document.getElementById("errorEmail");

			btnText.textContent = "Continuar";
			btnText.classList.remove("loader");

			if (!data.valido) {
				email.classList.add("input-error");
				errorEmail.classList.remove("d-none");
				return;
			} else {
				errorEmail.classList.add("d-none");
			}
		} catch (err) {
			console.error("Error al verificar el correo:", err);

			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Error al verificar el correo. Intenta más tarde.",
				confirmButtonText: "Aceptar",
			});

			btnText.textContent = "Continuar";
			btnText.classList.remove("loader");
			return;
		}

	
		step2.innerHTML = `
			<div class="d-flex gap-3">
				<div class="flex-grow-1">
					<label for="primerNombre" class="form-label">Primer Nombre<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="primerNombre" name="primer_nombre" required autocomplete="off">
				</div>
				<div class="flex-grow-1">
					<label for="segundoNombre" class="form-label">Segundo Nombre</label>
					<input type="text" class="form-control" id="segundoNombre" name="segundo_nombre" autocomplete="off">
				</div>
			</div>
			<div class="d-flex gap-3">
				<div class="flex-grow-1">
					<label for="primerApellido" class="form-label">Primer Apellido<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="primerApellido" name="primer_apellido" required autocomplete="off">
				</div>
				<div class="flex-grow-1">
					<label for="segundoApellido" class="form-label">Segundo Apellido</label>
					<input type="text" class="form-control" id="segundoApellido" name="segundo_apellido" autocomplete="off">
				</div>
			</div>
			<div class="d-flex flex-column">
				<label for="id_rol" class="form-label">Rol</label>
				<select name="id_rol" id="rol" class="">
					<option value="" selected disabled>Selecciona un rol</option>
					<option value="1">Paciente</option>
					<option value="2">Médico</option>
					<option value="3">Recepcionista</option>
					<option value="4">Farmacéutico</option>
				</select>
			</div>
			<div class="d-flex gap-3 lh-3">
				<button type="button" id="btnBack" class="lh-2-5 flex-grow-0 d-flex justify-content-center align-items-center text-center gap-3 text-secondary">
					<i class="bi bi-arrow-left"></i>
				</button>
				<button type="submit" class="btn-create-account lh-2-5 flex-grow-1 justify-content-center align-items-center d-flex gap-3 text-white">
					Crear Cuenta
				</button>
			</div>
		`;

		const stepTitle = document.getElementById("stepTitle");
		
		if (step1.classList.contains("active")) {
			step1.classList.remove("active");
			step2.classList.add("active");

			stepInfo.textContent = "PASO 2 DE 2";
			stepTitle.textContent = "Completa tus datos";
		}

		const btnBack = document.getElementById("btnBack");
		btnBack.addEventListener("click", function () {
			step2.classList.remove("active");

			step1.classList.add("active");
			stepInfo.textContent = "PASO 1 DE 2";
			stepTitle.textContent = "Crea tu cuenta";

			setTimeout(() => {
				step2.textContent = "";
			}, 400);
		});
	}
});
