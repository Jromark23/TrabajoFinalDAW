<footer class="footer">
	<div class="footer__grid">
		<!-- <div class="footer__contenido"> -->
		<!-- <h3 class="footer__logo">
				&#60;  Congrexia Events >
			</h3> -->
		<picture>
			<source srcset="/public/build/img/logol.webp" type="image/webp">
			<source srcset="/public/build/img/logol.png" type="image/png">
			<img class="footer__img" src="/public/build/img/logol.png" alt="Imagen ponente">
		</picture>
		<!-- </div> -->


		<nav class="rrss">
			<!-- rel="noopener noreferrer" evita que la pestaña que abres tenga acceso a window.opener y pueda suplantar la
		pestaña original -->
			<a class="rrss__enlace" href="https://facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook"></a>
			<a class="rrss__enlace" href="https://x.com/" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"></a>
			<a class="rrss__enlace" href="https://youtube.com/" target="_blank" rel="noopener noreferrer" aria-label="YouTube"></a>
			<a class="rrss__enlace" href="https://instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"></a>
			<a class="rrss__enlace" href="https://tiktok.com/" target="_blank" rel="noopener noreferrer" aria-label="TikTok"></a>
			<a class="rrss__enlace" href="https://github.com/" target="_blank" rel="noopener noreferrer" aria-label="GitHub"></a>
		</nav>

		<!-- <p class="footer__texto">
			Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi est voluptates iste, recusandae ut cupiditate earum necessitatibus.
		</p> -->
		<div class="footer__contacto">
			<p class="footer__texto"><strong>Dirección:</strong> Av. del Oeste, s/n, 28922 Alcorcón, Madrid</p>
			<p class="footer__texto"><strong>Correo: </strong> jroman@joelroman.site</a></li>
			<p class="footer__texto"><strong>Teléfono:</strong> 612345678</p>
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