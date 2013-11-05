<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Enviar',
);

?>
<div class="container">
	<h1>Gift Card</h1>
	<section class="bg_color3  span12 margin_bottom_small padding_medium box_1">

		<form class="form-horizontal personaling_form ">
		<fieldset>
			<legend>Enviar Gift Card</legend>
			<aside class="muted padding_small">
				<span class="margin_right_medium ">Monto: 400,00 </span>
				<span class="margin_right_medium ">Desde: 12/12/2013 </span>
				<span class="margin_right_medium ">Hasta: 12/12/2014 </span>
			</aside>
			<div>
				<p class="lead">1. Selecciona una Gift Card</p>
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
					<p class="lead">2. Personalizala</p>	
					<div class="control-group">
						<label class="control-label" for="inputMonto">Para</label>
						<div class="controls row-fluid ">
				      			<input class="input-xlarge" type="text" id="inputPara" placeholder="Para">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputMonto">Email</label>
						<div class="controls row-fluid">
				      			<input class="input-xlarge" type="text" id="inputEmail" placeholder="Email">
						</div>
					</div>			
			  		<div class="control-group">
					    <label class="control-label" for="inputPassword">Mensaje</label>
					    <div class="controls">
							<textarea class="input-xlarge" rows="3" placeholder="Haz recibido un Gift Card de Personaling"></textarea>			
					    </div>
				    </div>   
				</div>	
				<div class="span5">
					<img src="http://placehold.it/450x250">
				</div>
			</div>
			<div class="control-group row margin_top">
				<div class="controls pull-right">
				  <button type="submit" class="btn btn-danger">Enviar Gift Card</button>
				</div>
			</div>			
		</fieldset>
		</form>


	</section>
</div>
