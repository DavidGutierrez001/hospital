document.addEventListener("DOMContentLoaded", function () {
	const btnRegisterProduct = document.getElementById("btnRegisterProduct");
	const formProducto = document.getElementById("formProducto");
	const searchPacient = document.getElementById("searchPacient");
	const stockProducts = document.getElementById("stockProducts");
	const buttonAdd = document.querySelectorAll(".btn-agregar-producto");

	btnRegisterProduct.addEventListener("click", registerProduct);
	searchPacient.addEventListener("click", searchPacientByDocument);

	function registerProduct(event) {
		event.preventDefault();
		const formData = new FormData(formProducto);

		fetch("/hospital/farmacia/register_product", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					Swal.fire({
						title: "Éxito",
						text: "Producto registrado exitosamente.",
						icon: "success",
					});
					formProducto.reset();
					console.log("Producto registrado:", data.product);
				} else {
					Swal.fire({
						title: "Error",
						text: "Error al registrar el producto: " + data.message,
						icon: "error",
					});
				}
			})
			.catch((error) => console.error("Error:", error));
	}

	function searchPacientByDocument(event) {
		event.preventDefault();

		const button = document.getElementById("searchPacient");
		const input = document.getElementById("documento");
		const valor = input.value.trim();
		const name = input.getAttribute("name");
		const messageSearchPacient = document.getElementById(
			"messageSearchPacient"
		);

		if (valor === "") {
			messageSearchPacient.innerHTML = `<span class="fs-8 text-danger">Ingrese un documento</span>`;
			return;
		}

		button.disabled = true;
		const originalContent = button.innerHTML;
		button.innerHTML = `<span class="spinner-border spinner-border-sm text-white"></span>`;

		const formData = new FormData();
		formData.append(name, valor);

		setTimeout(() => {
			fetch("/hospital/farmacia/searchPacientByDocument", {
				method: "POST",
				body: formData,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						messageSearchPacient.innerHTML = `<span class="fs-8 text-success">Paciente encontrado <i class="bi bi-check-circle-fill text-success"></i></span>`;
						stockProducts.classList.remove("d-none");
					} else {
						messageSearchPacient.innerHTML = `<span class="fs-8 text-danger">Paciente no encontrado <i class="bi bi-x-circle-fill text-danger"></i></span>`;
						input.value = "";
					}
				})
				.catch((error) => console.error("Error:", error))
				.finally(() => {
					button.disabled = false;
					button.innerHTML = originalContent;
				});
		}, 500);
	}

	document.addEventListener("click", function (e) {
		const mainContentProducts = document.getElementById("mainContentProducts");
		const originalMainContentProducts = mainContentProducts.innerHTML;

		const sectionProductos = document.getElementById("sectionProductos");
		const sectionProductosOriginal = sectionProductos.innerHTML;

		const btnEdit = e.target.closest(".btnEdit");

		if (btnEdit) {
			e.preventDefault();
			const id = btnEdit.getAttribute("data-id");

			fetch("/hospital/farmacia/view_editar_products/" + id)
				.then((res) => res.text())
				.then((html) => {
					mainContentProducts.innerHTML = html;
					sectionProductos.innerHTML = "";

					const btnBack = document.getElementById("btnBack");
					if (btnBack) {
						btnBack.addEventListener("click", function () {
							mainContentProducts.innerHTML = originalMainContentProducts;
							sectionProductos.innerHTML = sectionProductosOriginal;
						});
					}
				})
				.catch((err) => console.error("Error al cargar vista editar:", err));
		}
	});

	document.addEventListener("click", function (e) {
		const btnDelete = e.target.closest(".btnDelete");

		if (btnDelete) {
			e.preventDefault();
			const id = btnDelete.dataset.id;

			Swal.fire({
				title: "¿Estás seguro?",
				text: "Esta acción no se puede deshacer.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Sí, eliminar",
				cancelButtonText: "Cancelar",
			}).then((result) => {
				if (result.isConfirmed) {
					fetch(`/hospital/farmacia/delete_product/${id}`, {
						method: "DELETE",
					})
						.then((res) => res.json())
						.then((data) => {
							Swal.fire({
								title: data.success ? "¡Éxito!" : "Error",
								text: data.message,
								icon: data.success ? "success" : "error",
							}).then(() => {
								if (data.success) {
									window.location.reload();
								}
							});
						})
						.catch((err) => console.error("Error al eliminar:", err));
				}
			});
		}
	});

	document.addEventListener("click", function (e) {
		const btnUpdate = e.target.closest("#btnUpdate");
		if (!btnUpdate) return;

		e.preventDefault();
		const id = btnUpdate.dataset.id;
		const form = document.getElementById("formProducto");

		if (!form) {
			console.error("Formulario no encontrado");
			return;
		}

		const formData = new FormData(form);

		fetch(`/hospital/farmacia/update_product/${id}`, {
			method: "POST",
			body: formData,
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success) {
					Swal.fire(
						"Éxito",
						"Producto actualizado correctamente.",
						"success"
					).then(() => {
						location.reload();
					});
				} else {
					Swal.fire(
						"Error",
						data.message || "No se pudo actualizar el producto.",
						"error"
					);
				}
			})
			.catch((err) => {
				console.error("Error al actualizar:", err);
				Swal.fire("Error", "Error de conexión con el servidor.", "error");
			});
	});

	const inputIdProducto = document.getElementById("existenciasIdProducto");
	let id = null;

	document.querySelectorAll(".btnAddExistencias").forEach((btn) => {
		btn.addEventListener("click", () => {
			inputIdProducto.value = btn.value;
			id = btn.value;
		});
	});

	document
		.querySelector(".btnAdd.existencias")
		.addEventListener("click", async () => {
			if (!id) {
				alert("Por favor seleccione un producto antes de agregar existencias.");
				return;
			}
			console.log("Agregando existencias para el producto con ID:", id);
			const form = document.getElementById("formAgregarExistencias");
			const formData = new FormData(form);

			fetch("/hospital/farmacia/agregarExistencias/" + id, {
				method: "POST",
				body: formData,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						alert("Existencias agregadas correctamente.");
						location.reload();
					} else {
						alert(
							"Error: " + (data.message || "No se pudo agregar existencias.")
						);
					}
				})
				.catch((error) => {
					alert("Error al enviar los datos.");
					console.error(error);
				});
		});
});
