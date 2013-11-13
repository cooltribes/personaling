<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */


$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Generar Masivo' =>array('createMasivo'),
        'Seleccionar Usuarios' => array('seleccionarusuarios'),
        'Envío Masivo',
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
                                       
                                        <?php echo $form->textFieldRow($envio, 'nombre', array(
                                            'placeholder' => 'Nombre del destinatario'
                                        )); ?>
                                        
                                        <?php echo $form->textFieldRow($envio, 'email', array(
                                            'placeholder' => 'Email del destinatario')); ?>
                                        
                                        <?php echo $form->textAreaRow($envio, 'mensaje', array(
                                            'placeholder' => 'Escribe un mensaje')); ?>
                                         
                                        <?php echo CHtml::link('<i class = "icon-gift icon-white"></i> Aplicar Gift Card', "#modalGiftcard" , array(
                                            'class' => 'btn btn-info',
                                            'data-toggle' => 'modal',
                                        )) ?>
					   
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
<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
    'id'=>'modalGiftcard',
    'htmlOptions'=>array(
//        'class'=>'modal hide fade',
//        'tabindex'=>'-1',
//        'role'=>'dialog',
//        'aria-labelleby'=>
//        'myModalLabel',
//        'aria-hidden'=>'true'
        )
    )); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Modal header</h3>
</div>
<div class="modal-body">
    
<section class="bg_color3  margin_bottom_small padding_medium box_1">
    <?php $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
            'id' => 'form-enviarGift',
            'type' => 'inline',
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array('class' => 'personaling_form')
        )); ?>

        <fieldset>
                <legend>Aplicar Gift Card</legend>
                <!-- FLASH ON --> 
                <?php $this->widget('bootstrap.widgets.TbAlert', array(
                        'block'=>true, // display a larger alert block?
                        'fade'=>true, // use transitions?
                        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                        'alerts'=>array( // configurations per alert type
                            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                        ),
                    )
                ); ?>	
                <!-- FLASH OFF --> 
                <div class="margin_bottom text_align_center">
                        <img src="http://placehold.it/450x250">
                </div>				
                <div class="row margin_top text_align_center">
                        <div class="span7">
                            <?php /* ?>
                             * 
                             * <?php echo $form->textFieldRow($model, "campo1"); ?> <span>-</span>
                              <?php echo $form->textFieldRow($model, "campo2"); ?> <span>-</span>
                               <?php echo $form->textFieldRow($model, "campo3"); ?> <span>-</span>
                                <?php echo $form->textFieldRow($model, "campo4"); ?> <span>-</span>
                             * 
                            <?php */ ?>

                            <?php 
                                $classError = "";
                                if($model->hasErrors()){
                                    $classError = "error";
//                                            echo "<pre>";
//                                            print_r($model->getErrors());
//                                            echo "</pre>";

                                    $cReq = 0;
                                    $cLen = 0;
                                    foreach($model->errors as $att => $error){
                                        $cReq += in_array("req", $error) ? 1:0;
                                        $cLen += in_array("len", $error) ? 1:0;
                                    }
                                    $model->clearErrors();
//                                            echo "clear";
//                                            echo "<pre>";
//                                            print_r($model->getErrors());
//                                            echo "</pre>";

                                    if($cReq){
                                       $model->addError("campo1", "Debes escribir el código de tu Gift Card completo"); 
                                    }
                                    if($cLen){
                                       $model->addError("campo1", "Los campos deben ser de 4 caracteres cada uno."); 
                                    }

//                                            echo "req {$cReq} len {$cLen}";

                                }
                            ?>

                           <div class="control-group <?php echo $classError; ?>">						
                                <div class="controls">
                                    <?php echo CHtml::activeLabel($model, "campo1"); ?>

                                    <?php echo CHtml::activeTextField($model, "campo1", array('class' => 'input-mini margin_left_small',
                                        'maxlength'=>'4')); ?> <span>-</span>                                                        
                                    <?php echo CHtml::activeTextField($model, "campo2", array('class' => 'input-mini',
                                        'maxlength'=>'4')); ?> <span>-</span>                                                        
                                    <?php echo CHtml::activeTextField($model, "campo3", array('class' => 'input-mini',
                                        'maxlength'=>'4')); ?> <span>-</span>                                                        
                                    <?php echo CHtml::activeTextField($model, "campo4", array('class' => 'input-mini',
                                        'maxlength'=>'4')); ?>

                                </div>						
                           </div> 

<!--					<div class="control-group">
                                        <label class="control-label" for="inputGiftcard">Ingresa el código de tu Gift Card</label>
                                        <div class="controls ">

                                                <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX"> <span>-</span>
                                                <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX"> <span>-</span>
                                                <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX">
                                        </div>
                                </div>			  -->
                        </div>	
                </div>
                <?php echo $form->errorSummary($model, "Corrije los siguientes errores:"); ?>
                <div class="control-group row margin_top">
                        <div class="controls pull-right">
                          <button type="submit" class="btn btn-medium btn-warning">Aplicar Gift Card</button>
                        </div>
                </div>			
        </fieldset>

    <?php $this->endWidget(); ?>


</section>    
    
    
    
</div>
<div class="modal-footer">    
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-danger">Save changes</a>
</div>

<?php $this->endWidget(); ?>