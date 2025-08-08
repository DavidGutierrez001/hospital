document.addEventListener("DOMContentLoaded", function () {
	const btnLogin = document.querySelector("#btnLogin");

	if (btnLogin) {
		btnLogin.addEventListener("click", function (e) {
			e.preventDefault();
			const btnText = document.querySelector("#btnText");
			const loadingSpinner = document.querySelector("#loadingSpinner");

			if (btnText) {
				btnText.innerHTML = "";
				loadingSpinner.classList.remove("d-none");
			}

			try {
				const email = document.querySelector("#email").value;
				const password = document.querySelector("#password").value;

				if (!email || !password) {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: "Por favor, completa todos los campos.",
					});
					if (btnText) {
						btnText.innerHTML = "Iniciar sesión";
						loadingSpinner.classList.add("d-none");
					}
					return;
				}

				setTimeout(() => {
					document.getElementById("form").submit();
				}, 500);
				
			} catch (error) {
				if (btnText) {
					btnText.innerHTML = "Iniciar sesión";
				}
				loadingSpinner.classList.remove("d-none");
			}
		});
	}
});
