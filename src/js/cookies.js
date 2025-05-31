// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina
(function () {
	window.addEventListener("load", function () {
		window.cookieconsent.initialise({
			palette: {
				popup: { background: "#000" },
				button: { background: "#f1d600" }
			},
			theme: "classic",
			position: "bottom-right",
			type: "opt-in",
			content: {
				message: "Este sitio utiliza cookies para mejorar tu experiencia.",
				dismiss: "Aceptar",
				deny: "Rechazar",
				link: "Leer más",
				href: "/politica-cookies"
			},
			onInitialise: function (status) {
				if (this.hasConsented()) {
					cargarScriptsDeTerceros();
				}
			},
			onStatusChange: function (status) {
				if (this.hasConsented()) {
					cargarScriptsDeTerceros();
				} else {
					bloquearScriptsDeTerceros();
				}
			}
		});
	});

	function cargarScriptsDeTerceros() {
		if (!window.gaScriptCargado) {
			var gaScript = document.createElement("script");
			gaScript.type = "text/javascript";
			gaScript.src = "https://www.googletagmanager.com/gtag/js?id=TU_ID_GA";
			gaScript.async = true;
			document.head.appendChild(gaScript);

			window.dataLayer = window.dataLayer || [];
			function gtag() { dataLayer.push(arguments); }
			gtag('js', new Date());
			gtag('config', 'TU_ID_GA');

			window.gaScriptCargado = true;
		}
	}

	function bloquearScriptsDeTerceros() {
		var gaTag = document.getElementById("ga-script");
		if (gaTag) {
			gaTag.parentNode.removeChild(gaTag);
		}
	}
})();


