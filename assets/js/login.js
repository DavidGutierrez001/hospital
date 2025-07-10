document.addEventListener("DOMContentLoaded", function () {
	const btnLogin = document.querySelector("#btnLogin");

	if (btnLogin) {
		btnLogin.addEventListener("click", function (e) {
			e.preventDefault();
			const btnText = document.querySelector("#btnText");

			if (btnText) {
				btnText.innerHTML = "";
				btnText.classList.add("loader-button");
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
						btnText.classList.remove("loader-button");
					}
					return;
				}

				setTimeout(() => {
					document.getElementById("form").submit();
				}, 500);
			} catch (error) {
				console.error("Login failed:", error.message);
				alert(error.message);
				if (btnText) {
					btnText.innerHTML = "Iniciar sesión";
					btnText.classList.remove("loader-button");
				}
			}
		});
	}
});
