// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina
(function () {

	const ctx = document.getElementById('myChart');

	obtenerDatos();
	async function obtenerDatos() {
		const url = '/api/regalos'
		const respuesta = await fetch(url);
		const resultado = await respuesta.json();



		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: resultado.map(regalo => regalo.nombre),
				datasets: [{
					label: 'Regalos solicitados',
					data: resultado.map(regalo => regalo.total),
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 205, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(201, 203, 207, 0.2)'
					],
					borderColor: [
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)',
						'rgb(153, 102, 255)',
						'rgb(201, 203, 207)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							callback: function (value) {
								return Number.isInteger(value) ? value : null;
							}
						}
					}
				}
			}
		});
	}








})();


