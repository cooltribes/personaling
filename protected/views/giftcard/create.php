<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Generar',
);

?>
<div class="container">
	<h1>Gift Card</h1>
	<section class="bg_color3  span9 offset1 margin_bottom_small padding_small box_1">
		<form class="form-horizontal">
		<fieldset>
			<legend>Generar Gift Card</legend>
			<div class="control-group">
			<label class="control-label" for="inputMonto">Monto</label>
			<div class="controls">
				<select class="span3">
				  <option>300,00</option>
				  <option>400,00</option>
				  <option>500,00</option>
				  <option>1000,00</option>
				</select>
			</div>
			</div>
	<!-- 	  <div class="control-group">
		    <label class="control-label" for="inputPassword">Mensaje</label>
		    <div class="controls">
				<textarea rows="3" placeholder="Haz recibido un Gift Card de Personaling"></textarea>			
		    </div>
		  </div> -->
			<div class="control-group">
				<label class="control-label" for="inputMonto">Fecha Desde</label>	  	
				<div class="controls row-fluid">
	      			<input type="text" id="inputEmail" placeholder="Desde">
				</div>							    
			</div>
			<div class="control-group">
				<label class="control-label" for="inputMonto">Fecha Hasta</label>	  	
				<div class="controls row-fluid">
	      			<input type="text" id="inputEmail" placeholder="Hasta">
				</div>							    
			</div>	  

			<div class="control-group row">
				<div class="controls pull-right">

				  <button type="submit" class="btn btn-danger">Crear y enviar Gift Card</button>
				</div>
			</div>
		</fieldset>
		</form>


	</section>
</div>
