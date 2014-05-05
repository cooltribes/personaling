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
        <div class="page-header">
            <h1>Importar Productos</h1>
        </div>
        <div class="bg_color3   margin_bottom_small padding_small box_1">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'action' => CController::createUrl('importar'),
                    'id' => 'form-validar',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                echo TbHtml::hiddenField("valido", 1);
            
            ?>
            <fieldset>
                <legend>1.- Subir archivo para revisión previa:</legend>
                
                <div class="well span5">
                    
                    <?php
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'validar',
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
                            'label' => 'Cargar Archivo',
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
                        'name' => 'url',
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
                            'label' => 'Cargar Archivo',
                            'htmlOptions' => array(
                                'name' => 'cargar'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <legend>3.- Descargar archivo Excel para generar el Inbound: </legend>
                <div class="well span5">
                    <div class="">
                        <?php
                            
                            $this->widget('bootstrap.widgets.TbButton', array(
                                'buttonType' => 'submit',
                                'type' => 'info',
                                'label' => 'Descargar Archivo',
                                'htmlOptions' => array(
                                    'name' => 'generar'
                                ),
                            ));
                            ?>
                        
                    </div>                    
                </div>
                <legend>4.- Subir Excel para Inbound: </legend>
                <div class="well span5">
                    <?php
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'inbound',
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
                            'label' => 'Cargar Archivo',
                            'htmlOptions' => array(
                                'name' => 'cargarIn'
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


<hr/>

<?php
if ($total > 0 || $actualizar > 0) {
    echo "<h3> Se importaron " . $total . " productos. </h3>";
    echo "</br>";
    echo "<h3> Se actualizaron " . $actualizar . " productos. </h3>";
    echo "</br></br>" . $tabla;
}
?>