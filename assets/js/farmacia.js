document.addEventListener("DOMContentLoaded", function () {
	fetch(
		"https://687c4842b4bc7cfbda888c95.mockapi.io/api/medicamentos/productos"
	).then((response) =>
		response.json().then((data) => {
			console.log(data);
		})
	);
});
