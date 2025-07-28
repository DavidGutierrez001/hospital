document.addEventListener("DOMContentLoaded", function () {

	if (!navigator.onLine) {
		Swal.fire({
            icon: "error",
            text: "No hay conexión a Internet",
		});
	}
});
