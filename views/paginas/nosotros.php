<main class="nosotros">
	<h2 class="nosotros__heading" id="info"> <?= $titulo; ?> </h2>
	<p class="nosotros__descripcion">
		Bienvenido al evento mas importante del año
	</p>

	<div class="nosotros__grid">
		<div class="nosotros__imagenes">
			<div <?= animacion_aos(); ?> class="nosotros__imagen">
				<picture>
					<source srcset="build/img/conferencia.avif">
					<source srcset="build/img/conferencia.webp">
					<img src="build/img/conferencia.jpg" alt="imagen de fondo" width="200" height="300">
				</picture>
			</div>
			<div <?= animacion_aos(); ?> class="nosotros__imagen">
				<picture>
					<source srcset="build/img/conferencia2.avif">
					<source srcset="build/img/conferencia2.webp">
					<img src="build/img/conferencia2.jpg" alt="imagen de fondo" width="200" height="300">
				</picture>
			</div>
		</div>
		<div class="nosotros__contenido">
			<h3>¡VIVE EL EVENTO ECONÓMICO DEL AÑO!</h3>
			<div <?= animacion_aos(); ?>>

				<h4>🌟 ¿Estás listo para transformar tu visión del mercado?</h4>
				<p>No te pierdas el Fin de Semana Económico 2024, el encuentro imperdible que reunirá a los mejores ponentes,
					analistas y líderes globales del sector financiero, emprendimiento y estrategia empresarial. </p>
				<p>Durante dos días intensivos, vivirás conferencias magistrales,
					talleres prácticos y networking de alto nivel diseñados para impulsar tu carrera, negocio o inversiones.</p>
			</div>

			<div <?= animacion_aos(); ?>>
				<h4>✨ ¿Por qué es EL EVENTO DEL AÑO?</h4>

				<li><strong>Ponentes de élite:</strong> Expertos con experiencia en Wall Street, organismos internacionales y empresas Fortune 500 compartirán estrategias probadas y tendencias exclusivas.</li>

				<li><strong>Contenido revolucionario:</strong> Desde criptoeconomía hasta mercados emergentes, pasando por innovación disruptiva. ¡Aprende lo que no enseñan en ninguna universidad!</li>

				<li><strong>Talleres interactivos:</strong> Sesiones prácticas donde aplicarás conocimientos en tiempo real junto a mentores.</li>

				<li><strong>Networking premium:</strong> Conecta con inversores, CEOs y emprendedores clave en un ambiente exclusivo.</li>
			</div>

			<div <?= animacion_aos(); ?>>
				<h4>🔥 ¿Qué lograrás en este fin de semana?</h4>

				<li>Dominar herramientas para tomar decisiones financieras más inteligentes.</li>
				<li>Descubrir oportunidades en mercados volátiles.</li>
				<li>Acceder a casos de éxito reales de quienes están transformando la economía global.</li>
				<li>Salir con un plan de acción claro para multiplicar tu impacto profesional.</li>
			</div>

			<div <?= animacion_aos(); ?>>

				<h4>🚀 No es solo un evento… ¡Es tu ventaja competitiva!</h4>
				Este encuentro está diseñado para profesionales, emprendedores e inversores que no se conforman con lo convencional. Si buscas diferenciarte, crecer y conectar con la vanguardia económica, este es tu momento.

				⏳ <strong>¿Te lo vas a perder?</strong> Las plazas vuelan. ¡Reserva ahora y sé parte de la revolución económica!
			</div>
		</div>



	</div>
</main>