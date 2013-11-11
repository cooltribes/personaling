<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Enviar',
);

?>
<div class="container">
    
    <!-- FLASH ON --> 
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            ),
        )
    ); ?>	
    <!-- FLASH OFF --> 
	<h1>Gift Card</h1>
	<section class="bg_color3  span12 margin_bottom_small padding_medium box_1">
                <?php $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
                    'id' => 'form-enviarGift',
                    'type' => 'horizontal',
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    )
                )); ?>
		
		<fieldset>
			<legend>Enviar Gift Card</legend>
			<aside class="muted padding_small">
                            <span class="margin_right_medium ">
                                Monto: <strong><?php echo $model->monto . " Bs."; ?></strong>
                            </span>
                            <span class="margin_right_medium ">
                                Válida Desde: <strong><?php echo date("d/m/Y", $model->getInicioVigencia()); ?></strong>
                            </span>
                            <span class="margin_right_medium ">
                                Válida Hasta: <strong><?php echo date("d/m/Y", $model->getFinVigencia()); ?> </strong>
                            </span>
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
					<p class="lead">2. Personalízala</p>                                       
                                        
                                        
                                        <?php echo $form->errorSummary($envio); ?>
                                       
                                        <?php echo $form->textFieldRow($envio, 'nombre'); ?>
                                        
                                        <?php echo $form->textFieldRow($envio, 'email'); ?>
                                        
                                        <?php echo $form->textAreaRow($envio, 'mensaje'); ?>
                                        
                                        
					<div class="control-group">
						<label class="control-label" for="inputMonto">Para</label>
						<div class="controls row-fluid ">
				      			<input class="input-xlarge" type="text" id="inputPara" 
                                                               placeholder="Nombre del destinatario">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputMonto">Email</label>
						<div class="controls row-fluid">
				      			<input class="input-xlarge" type="text" id="inputEmail" 
                                                               placeholder="Email del destinatario">
						</div>
					</div>			
			  		<div class="control-group">
					    <label class="control-label" for="inputPassword">Mensaje</label>
					    <div class="controls">
							<textarea class="input-xlarge" rows="3" placeholder="Escribe un mensaje..."></textarea>			
					    </div>
				    </div>   
				</div>	
				<div class="span5">
					<img src="http://placehold.it/450x250">
				</div>
			</div>
			<div class="control-group row margin_top">
				<div class="controls pull-right">                                   
                                    <button type="submit" name="Enviar" class="btn btn-danger"><i class="icon-envelope icon-white"></i> Enviar</button>                                  
				</div>
			</div>			
		</fieldset>
		
                <?php $this->endWidget(); ?>

	</section>
</div>
