<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Comprar',
);

?>
<div class="container">
	<h1>Gift Card</h1>
	<section class="bg_color3  margin_bottom_small padding_medium box_1">

		<form class="form-horizontal personaling_form ">
		<fieldset>
			<legend>Comprar Gift Card</legend>
			<div class="margin_bottom">
				<p class="lead">1. Elige como enviarla</p>
				<div class="btn-group" data-toggle="buttons-radio">
				  <button type="button" class="btn btn-info">Email</button>
				  <button type="button" class="btn btn-info">Impreso</button>
				</div>
			</div>				
			<div>
				<p class="lead">2. Selecciona una Gift Card</p>
				<ul class="thumbnails">
					<li> <img src="http://placehold.it/200x100"> </li>
					<li> <img src="http://placehold.it/200x100"> </li>
					<li> <img src="http://placehold.it/200x100"> </li>
					<li> <img src="http://placehold.it/200x100"> </li>												
					<li> <img src="http://placehold.it/200x100"> </li>			
				</ul>

			</div>	
			<div class="row margin_top">
				<div class="span6">	
					<p class="lead">3. Define los detalles</p>
					<div class="control-group">
						<label class="control-label" for="inputPara">Costo</label>
						<div class="controls row-fluid">
							<select class="span6">
							  <option>100,00 Bs.</option>
							  <option>200,00 Bs.</option>
							  <option>300,00 Bs.</option>
							  <option>400,00 Bs.</option>
							  <option>500,00 Bs.</option>
							</select>
						</div>
					</div>						
					<div class="control-group">
						<label class="control-label" for="inputPara">Para</label>
						<div class="controls row-fluid ">
				      			<input class="span6" type="text" id="inputPara" placeholder="Para">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputEmail">Email</label>
						<div class="controls row-fluid">
				      			<input class="span6" type="text" id="inputEmail" placeholder="Email">
						</div>
					</div>			
			  		<div class="control-group">
					    <label class="control-label" for="inputMensaje">Mensaje</label>
					    <div class="controls row-fluid">
							<textarea id="inputMensaje" class="span6" rows="3" placeholder="Haz recibido un Gift Card de Personaling"></textarea>			
					    </div>
				    </div>   
				</div>	
				<div class="span5">
					<img src="http://placehold.it/450x250">
				</div>
			</div>
			<div class="control-group row margin_top">
				<div class="controls pull-right">
				  <button type="submit" class="btn btn-medium btn-warning">Comprar Gift Card</button>
				</div>
			</div>			
		</fieldset>
		</form>


	</section>
</div>
