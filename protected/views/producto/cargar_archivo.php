<?php

$this->breadcrumbs = array(
    'Productos' => array('admin'),
    'Cargar',
);
?>
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


<div class="page-header">
	
            <h1>Cargar Archivos</h1>
</div> 
	
<div class="bg_color3 margin_bottom_small padding_small box_1">
	<?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'action' => CController::createUrl('cargar'),
                    'id' => 'form-validar',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
            
      ?>
     
    <fieldset>       
   
	<legend>Cargar archivo de reglas y/o de recomendaciones:</legend>
	<div class="well span5">

	<?php 
       $this->widget('CMultiFileUpload', array(
                        'name' => 'archivo',
                        'accept' => 'txt|xls|xlsx', // Tipo de archivo que se permite
                        'denied' => 'Tipo de archivo inválido.', // Mensaje tipo de archivo
                        'id' => 'reglas',
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
                                 'id' => 'buttonCargaA',
                            ),
                        ));
                        ?>
		</div>
	</div>

</div>
	</fieldset>
	<?php $this->endWidget(); ?>

<script type="text/javascript">

$('#buttonCargaA').click(function(e) {
    var btn = $(this);
    
    var res = confirm("El archivo será cargado.\n¿Desea continuar?");
    if (res == true) {
        btn.button('loading'); // call the loading function
        $("body").addClass("aplicacion-cargando");

    } else {
       e.preventDefault();
    }
//alert("Archivo cargado con éxito");
});


</script>

