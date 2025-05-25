<main class="nosotros">
	<h2 class="nosotros__heading" id="info"> <?= $titulo; ?> </h2>
	<p class="nosotros__descripcion">
		Bienvenido al evento mas importante del año
	</p>

	<div class="nosotros__grid">
		<div <?= animacion_aos(); ?> class="nosotros__imagen">
			<picture>
				<source srcset="build/img/conferencia.avif">
				<source srcset="build/img/conferencia.webp">
				<img src="build/img/conferencia.jpg" alt="imagen de fondo" width="200" height="300">
			</picture>
		</div>

		<div class="nosotros__contenido">
			<p <?= animacion_aos(); ?> class="nosotros__texto">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis possimus fugit inventore molestias et animi, voluptatum ab nemo amet? Laudantium totam expedita omnis repudiandae optio nisi quo, sapiente neque voluptatem.
			</p>

			<p <?= animacion_aos(); ?> class="nosotros__texto">
				Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odit quod labore, eaque, tenetur aperiam commodi voluptas ullam rem alias molestias repudiandae expedita incidunt blanditiis est necessitatibus neque laboriosam? Quisquam, deleniti.
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione cupiditate tenetur ipsa, unde quam neque fugit. Maxime autem voluptates incidunt libero placeat modi quasi numquam. Tempore dolorem illo eum deleniti.
			</p>
		</div>


	</div>
</main>