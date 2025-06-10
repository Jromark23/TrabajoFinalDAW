<?php
// Obtenemos la ruta para que si es validar, añada una clase extra
$rutaActual = $_SERVER['REQUEST_URI'];
$esValidar = strpos($rutaActual, '/registro/validar') !== false;
$validado_hide = $esValidar ? ' validado__hide' : '';
?>
<header class="header">
	<div class="header__contenedor">
		<nav class="header__navegacion">

			<?php if (is_user()) { ?>
				<?php if (is_admin()) {
					//Solo mostrara si el usuario tb es admin
				?>
					<a href="/admin/dashboard" class="header__enlace">Administrar</a>
				<?php } ?>
				<form action="/logout" class="header__form" method="POST">
					<?= csrf() ?>
					<input type="submit" class="header__submit" value="Cerrar sesión">
				</form>
			<?php } else { ?>
				<a href="/registro" data-scroll="localizador" class="header__enlace">Registro</a>
				<a href="/login" data-scroll="localizador" class="header__enlace">Iniciar Sesión</a>
			<?php } ?>
		</nav>

		<div class="header__contenido">
			<a href="/" data-scroll="inicio">
				<picture>
					<source srcset="/public/build/img/logol.webp" type="image/webp">
					<source srcset="/public/build/img/logol.png" type="image/png">
					<img class="header__img" src="/public/build/img/logol.png" alt="Imagen ponente">
				</picture>
			</a>
			<div class="header__div <?= $validado_hide ?>">
				<p class="header__texto">14 - 15 junio 2025</p>
				<!-- <p class="header__texto">On line - Presencial</p> -->

				<a href="/registro" data-scroll="inicio" class="header__boton">Comprar entradas</a>
			</div>
		</div>
	</div>
</header>

<div class="barra__oculto">
<button class="hamburguesa" id="btnHamburguesa" aria-label="Abrir menú" type="button">
	<i class="fas fa-bars"></i>
</button>
</div>
<div class="barra <?= $validado_hide ?>" id="barraMenu">
	<div class="barra__contenido">
		<a href="/" data-scroll="inicio">
			<h2 class="barra__logo nav__enlace" id="inicio">
				Inicio
			</h2>
		</a>
		<nav class="nav">
			<a href="/nosotros" data-scroll="inicio" class="nav__enlace <?= pagina_actual('/nosotros') ?
																			'nav__enlace--actual' : '' ?>">Evento</a>

			<a href="/entradas" data-scroll="inicio" class="nav__enlace <?= pagina_actual('/entradas') ?
																			'nav__enlace--actual' : '' ?>">Entradas</a>

			<a href="/talleres" data-scroll="inicio" class="nav__enlace <?= pagina_actual('/talleres') ?
																			'nav__enlace--actual' : '' ?>">Talleres</a>

			<a href="/eventos" data-scroll="inicio" class="nav__enlace <?= pagina_actual('/eventos') ?
																			'nav__enlace--actual' : '' ?>">Conferencias</a>

			<a href="/registro" data-scroll="inicio" class="nav__enlace <?= pagina_actual('/registro') ?
																			'nav__enlace--actual' : '' ?>">Comprar Entrada</a>
		</nav>
	</div>
</div>
