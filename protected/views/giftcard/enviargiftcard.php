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

		<form class="form-horizontal">
		<fieldset>
			<legend>Enviar Gift Card</legend>
			<div>
				<ul class="thumbnails">
					<li> <img src="http://placehold.it/200x100"> </li>
					<li> <img src="http://placehold.it/200x100"> </li>
					<li> <img src="http://placehold.it/200x100"> </li>
					<li> <img src="http://placehold.it/200x100"> </li>												
					<li> <img src="http://placehold.it/200x100"> </li>			
				</ul>


			</div>	
			<div class="row">	
				<div class="span4">	
					<div class="control-group">
						<label class="control-label" for="inputMonto">Para</label>
						<div class="controls row-fluid">
				      			<input type="text" id="inputPara" placeholder="Para">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputMonto">Email</label>
						<div class="controls row-fluid">
				      			<input type="text" id="inputEmail" placeholder="Email">
						</div>
					</div>			
			  		<div class="control-group">
					    <label class="control-label" for="inputPassword">Mensaje</label>
					    <div class="controls">
							<textarea rows="3" placeholder="Haz recibido un Gift Card de Personaling"></textarea>			
					    </div>
				    </div>   
					<div class="control-group row">
						<div class="controls pull-right">
						  <button type="submit" class="btn btn-danger">Crear Gift Card</button>
						</div>
					</div>
				</div>	
				<div class="span8">
					<img src="http://placehold.it/450x250">
				</div>
			</div>
		</fieldset>
		</form>


	</section>
</div>
