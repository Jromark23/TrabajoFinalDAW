<header class="dashboard__header">
	<div class="dashboard__header--grid">
		<a href="/">
			<h2 class="dashboard__logo">
				&#60;  Congrexia Events     />
			</h2>
		</a>

		<nav class="dashboard__nav">
			<a href="/" class="dashboard__nav-texto">Inicio</a>
			<form action="/logout" class="dashboard__form" method="POST">
				<?= csrf() ?>
				<input type="submit" class="dashboard__nav-texto" value="Cerrar sesión">
			</form>
		</nav>
	</div>
</header>