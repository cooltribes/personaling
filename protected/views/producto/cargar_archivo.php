<?php

/* $this->breadcrumbs = array(
    'Productos' => array('admin'),
    'Cargar',
);*/
?>

<div class="page-header">
            <h1>Cargar Archivo</h1>
</div> 
	
<div class="bg_color3 margin_bottom_small padding_small box_1">
            <?php
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'url',
                        'accept' => 'txt', // useful for verifying files
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
                                'id'=>'buttonCargaA',
                            ),
                        ));
                        ?>
	</div>
</div> 