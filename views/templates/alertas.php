<?php
	//  Recorremos todas las alertas recibidas, recogemos su clave (exito o no) y el valor de la clave
	foreach ($alertas as $key => $alerta) {
		// recorremos el valor, por si tiene varios mensajes 
		foreach ($alerta as $mensaje) {
?>
	<div class="alerta alerta__<?= $key; ?>">
		<?= $mensaje ?>
	</div>
<?php
		}
	}
?>