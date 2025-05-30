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
					<input type="submit" class="header__submit" value="Cerrar sesión">
				</form>
			<?php } else { ?>
				<a href="/registro" data-scroll="localizador" class="header__enlace">Registro</a>
				<a href="/login" data-scroll="localizador" class="header__enlace">Iniciar Sesión</a>
			<?php } ?>
		</nav>

		<div class="header__contenido">
			<a href="/" data-scroll="inicio">
				<h1 class="header__logo">
					&#60;ProyectoFinal />
				</h1>

				<p class="header__texto">14 - 15 junio 2025</p>
				<p class="header__texto header__texto--modalidad">On line - Presencial</p>

				<a href="/registro" data-scroll="inicio" class="header__boton">Comprar entradas</a>
			</a>
		</div>
	</div>
</header>
<div class="barra">
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