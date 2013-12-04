<?php

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
	
	
	<hr/>
	
	<div class='alert alert-error margin_top_medium margin_bottom'>
		<h1>No ha sido posible continuar con el pedido.</h1>
	   	<br/>
	   	<p>Motivo: <?php echo $mensaje; ?></p>
	</div>
	
	<p> En 10 segundos esta página será redirigida a la Bolsa de Compras</p>
	<hr/>
		<a href="<?php echo Yii::app()->createUrl('tienda/index'); ?>" class="btn btn-danger" title="seguir comprando">Seguir comprando</a> </div>
<script>

	$(document).ready(function() {
		setTimeout(function(){
			window.location = "<?php echo Yii::app()->createUrl('bolsa/index'); ?>";
		}, 10000); /* 5 seconds */
	});
	
	
</script>