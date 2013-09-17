<?php
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Detalle'=>array('detalles','id'=>$orden->id),
	'Devoluciones',
);

?>

	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

<div class="container margin_top">
	<h1> Devoluciones </h1>  
	<hr/>
   <div> 
     <h3 class="braker_bottom margin_top">Productos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
        	<th scope="col"></th>
        	<th scope="col">Referencia</th>
			<th scope="col">Nombre</th>
			<th scope="col">Color</th>
			<th scope="col">Talla</th>
			<th scope="col">Motivo</th>          
        </tr>

        <tr>
        	<td>
        		<input type="checkbox" value="">
        	</td>
        	<td>111</td>
        	<td>Prenda bonita</td>
        	<td> Gris </td>
        	<td> 10 </td>
        	<td class="span3">
				<select class="input-medium">
				  <option>Cambio de talla</option>
				  <option>Cambio por otro articulo</option>
				  <option>Devolución por prenda dañada</option>
				  <option>Devolución por insatisfacción</option>
				  <option>Devolución por pedido equivocado</option>
				</select>        		
        	</td>
        </tr>

        <tr>
        	<td>
        		<input type="checkbox" value="">
        	</td>
        	<td>111</td>
        	<td>Prenda bonita</td>
        	<td> Gris </td>
        	<td> 10 </td>
        	<td class="span3">
				<select class="input-medium">
				  <option>Motivo</option>
				  <option>Motivo 1</option>
				  <option>Motivo 2</option>
				  <option>Motivo 3</option>
				  <option>Motivo 4</option>
				</select>        		
        	</td>
        </tr>

        <tr>
        	<td>
        		<input type="checkbox" value="">
        	</td>
        	<td>111</td>
        	<td>Prenda bonita</td>
        	<td> Gris </td>
        	<td> 10 </td>
        	<td class="span3">
				<select class="input-medium">
				  <option>Motivo</option>
				  <option>Motivo 1</option>
				  <option>Motivo 2</option>
				  <option>Motivo 3</option>
				  <option>Motivo 4</option>
				</select>        		
        	</td>
        </tr>

        <tr>
        	<th colspan="6"><div class="text_align_right"><strong>Resumen</strong></div></th>
        </tr>        
        <tr>
        	<td colspan="5"><div class="text_align_right"><strong>Monto a devolver:</strong></div></td>
        	<td  class="text_align_right">000,00 Bs</td>
        </tr>
        <tr>
        	<td colspan="5"><div class="text_align_right"><strong>Monto por envio a devolver:</strong></div></td>
        	<td  class="text_align_right">000,00 Bs</td>
        </tr>
    	</table>
    	<div class="pull-right"><a href="#" title="Añadir productos" class="btn btn-warning">Hacer devolucion</a>
    	</div>
	</div>


</div>
<!-- /container --> 

