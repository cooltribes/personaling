<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Aplicar',
);

?>
<div class="container">
	<h1>Gift Card</h1>
	<section class="bg_color3  margin_bottom_small padding_medium box_1">

		<form class="form-horizontal personaling_form">
		<fieldset>
			<legend>Aplicar Gift Card</legend>
			<div class="margin_bottom text_align_center">
				<img src="http://placehold.it/450x250">
			</div>				
			<div class="row margin_top">
				<div class="span6">					
					<div class="control-group">
						<label class="control-label" for="inputGiftcard">Código Gift Card</label>
						<div class="controls ">
				      			<input class="input-xxlarge" type="text" id="inputGiftcard" placeholder="Código Gift Card">
						</div>
					</div>			  
				</div>	
			</div>
			<div class="control-group row margin_top">
				<div class="controls pull-right">
				  <button type="submit" class="btn btn-medium btn-warning">Aplicar Gift Card</button>
				</div>
			</div>			
		</fieldset>
		</form>


	</section>
</div>
