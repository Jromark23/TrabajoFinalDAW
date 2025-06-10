<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Congrexia - <?= $titulo; ?></title>
	<link rel="icon" href="/build/img/favicon.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="/build/css/app.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<!-- Banner de cookies  -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />

	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<!-- <script
		src="https://www.paypal.com/sdk/js?client-id=BAA7HMUhOEFfWowkMxV5OpilFpZ2LFWnKVMpyIZGVs7eTl4lPYWt7cHxOjO0XfURD7VLoJpH4bT3tClALI&components=hosted-buttons&disable-funding=venmo&currency=EUR">
	</script> -->
	<script
		src="https://www.sandbox.paypal.com/sdk/js?client-id=AXSRRWOn38sM4QG14_dTCXaYd8HruGZl9ENAtlUBDsnLPasLjT7xiF1cz27IThVtH08dH9rx73bbX5q7&currency=EUR">
	</script>

	<!-- Librería de Cookie Consent  -->
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>

</head>

<body class="layout">
	<?php
	include_once __DIR__ . '/templates/header.php';

	echo $contenido;

	include_once __DIR__ . '/templates/footer.php';
	?>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>

	<script src="/build/js/main.min.js"></script>
</body>

</html>