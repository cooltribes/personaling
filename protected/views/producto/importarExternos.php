<?php
$this->breadcrumbs = array(
    'Productos' => array('admin'),
    'Importar',
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
<!-- FLASH OFF --> 

<div class="row margin_top">
    <div class="span12">
        <?php
        if ($nuevos > 0 || $actualizados > 0) {
            echo "<h3>Datos del archivo cargado:</h3>";            
            echo "<h4>Nombre: <b>" . $fileName . "</b></h4>";
            echo "<h4>Total de productos que contiene: <b>" . ($nuevos + $actualizados) . "</b></h4>";
            echo "<h4>Productos (Combinación con SKU) nuevos: <b>" . $nuevos . "</b></h4>";
            echo "<h4>Productos (Combinación con SKU) actualizados: <b>" . $actualizados . "</b></h4><br><hr><br>";
            
        }
        ?>        
        <div class="page-header">
            <h1>Importar Productos Externos</h1>
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
                <legend>1.- Realizar la validación previa del archivo:</legend>
                
                <div class="well span5">
                    
                    <?php
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'archivoValidacion',
                        'accept' => 'xls|xlsx', // useful for verifying files
                        'duplicate' => 'El archivo está duplicado.', // useful, i think
                        'denied' => 'Tipo de archivo inválido.', // useful, i think
                    ));
                    ?>
                    
                    <div class="margin_top_small">	              		    
                        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'type' => 'danger',
                            'label' => 'Validar',
                            'icon' => 'ok white',
                            'htmlOptions' => array(
                                'name' => 'validar'
                            ),
                        ));
                        ?>
                    </div>
                    
                </div>
                
                <legend>2.- Subir archivo previamente validado: </legend>
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
                <legend>3.- Descargar archivo Excel para importación: </legend>
                <div class="well span5">
                    <div class="row-fluid">
                        
                        <div class="span5">
                           	<a href="../site/plantillaExternos" class="btn btn-info" <i class="icon-download-alt icon-white"></i> Descargar Plantilla</a>
                            
                        </div>
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
    var res = confirm("El archivo será cargado.\n¿Estás seguro de que ha sido validado ya?");
    if (res == true) {
        btn.button('loading'); // call the loading function
        $("body").addClass("aplicacion-cargando");
       
    } else {
       e.preventDefault();
    }
    
});

</script>


