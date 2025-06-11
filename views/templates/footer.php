<footer class="footer">
	<div class="footer__grid">
		<!-- <div class="footer__contenido"> -->
		<!-- <h3 class="footer__logo">
				&#60;  Congrexia Events >
			</h3> -->
		<a href="/">
			<picture>
				<source srcset="/public/build/img/logol.webp" type="image/webp">
				<source srcset="/public/build/img/logol.png" type="image/png">
				<img class="footer__img" src="/public/build/img/logol.png" alt="Imagen ponente">
			</picture>
		</a>
		<!-- </div> -->


		<nav class="rrss">
			<!-- rel="noopener noreferrer" evita que la pestaña que abres tenga acceso a window.opener y pueda suplantar la
		pestaña original -->
			<a class="rrss__enlace" href="https://facebook.com/congrexiaevents" target="_blank" rel="noopener noreferrer" aria-label="Facebook"></a>
			<a class="rrss__enlace" href="https://x.com/congrexiaevents" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"></a>
			<a class="rrss__enlace" href="https://youtube.com/congrexiaevents" target="_blank" rel="noopener noreferrer" aria-label="YouTube"></a>
			<a class="rrss__enlace" href="https://instagram.com/congrexiaevents" target="_blank" rel="noopener noreferrer" aria-label="Instagram"></a>
			<a class="rrss__enlace" href="https://tiktok.com/congrexiaevents" target="_blank" rel="noopener noreferrer" aria-label="TikTok"></a>
		</nav>

		<div class="footer__contacto">
			<p class="footer__texto">
				<strong>Dirección:</strong>
				<a	class="footer__enlace--normal"
					href="https://www.google.com/maps/search/?api=1&amp;query=Av.%20del%20Oeste%2C%20s%2Fn%2C%2028922%20Alcorc%C3%B3n%2C%20Madrid"
					target="_blank"
					rel="noopener">
					Av. del Oeste, s/n, 28922 Alcorcón, Madrid
				</a>
			</p>
			<p class="footer__texto">
				<strong>Correo:</strong>
				<a class="footer__enlace--normal" href="mailto:jroman@joelroman.site">
					jroman@joelroman.site
				</a>
			</p>
			<p class="footer__texto">
				<strong>Teléfono:</strong>
				<a class="footer__enlace--normal" href="tel:+34612345678">
					612 345 678
				</a>
			</p>
		</div>

	</div>

	<p class="footer__copyright">
		Congrexia Events&copy;
		<span class="footer__copyright--peque">
			Todos los derechos reservados &copy; <?= date('Y') ?>
		</span>
		<a class="footer__enlace" data-scroll="inicio" href="/politica-cookies">Política de Cookies</a>
		<a class="footer__enlace" data-scroll="inicio" href="/politica-privacidad">Política de Privacidad</a>
	</p>
</footer>