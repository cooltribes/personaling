<div class="row margin_top">
    <div class="span12"> 
    	
    	<!-- FLASH ON --> 
		<?php
		$this->widget('bootstrap.widgets.TbAlert', array(
			'block' => true, // display a larger alert block? 
		    'fade' => true, // use transitions?
		    'closeText' => '&times;', // close link text - if set to false, no close link is displayed
		    'alerts' => array(// configurations per alert type
		        'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
		        'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
		    ),
		)
		);
		?>	
		<!-- FLASH OFF --> 
    	  
        <div class="page-header">
            <h1>Enviar casos a Zoho desde archivo</h1>
        </div>        
        <div class="bg_color3 margin_bottom_small padding_small box_1">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    //'action' => CController::createUrl('importar'),
                    'id' => 'form-validar',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                
            
            ?>
            <fieldset>                
                <legend>Subir archivo: </legend>
                <div class="well span5">
                   
                    <?php
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'archivoCarga',
                        'accept' => 'xls|xlsx', // useful for verifying files
                        'duplicate' => 'El archivo está duplicado.', // useful, i think
                        'denied' => 'Tipo de archivo inválido.', // useful, i think
                    ));
                    ?>

                    <div class="margin_top_small">	              		    
                        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'type' => 'warning',
                            'icon' => 'upload white',
                            'label' => 'Cargar Archivo',
                            'loadingText'=>'Cargando ...',
                            'htmlOptions' => array(
                                'name' => 'cargar',
                                'id'=>'buttonCargaMD', 
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </fieldset>
            <?php $this->endWidget(); ?>
        </div>	
    </div>
</div>
<script type="text/javascript">

$('#buttonCargaMD').click(function(e) {
    var btn = $(this);
    var res = confirm("El archivo será cargado.\n¿Estás seguro de proceder?");
    if (res == true) {
        btn.button('loading'); // call the loading function
        $("body").addClass("aplicacion-cargando");
       
    } else {
       e.preventDefault();
    }
    
});

</script>