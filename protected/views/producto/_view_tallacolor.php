<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'Tallacolor-Form',
    //'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
    
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),    
)); ?>

<table id="table_tallacolor" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
              <tr>
                <th scope="col">Color</th>
                <th scope="col">Talla</th>
                <th scope="col">SKU/Código</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Url Externa</th>
                <th scope="col">Acciones</th>
              </tr> 
 <?php foreach($tallacolor as $i=>$item): ?>          
              <tr>
                <td>
                	<?php echo $form->textFieldRow($item, "[$i]color", array('class'=>'input-small', 'disabled'=>true)); ?>
                	<?php echo $form->hiddenField($item,"[$i]color_id"); ?>
                </td>
                <td>
                	<?php echo $form->textFieldRow($item, "[$i]talla", array('class'=>'input-small', 'disabled'=>true)); ?>
                	<?php echo $form->hiddenField($item,"[$i]talla_id"); ?>
                </td>
                
                <td>
                	
                	<?php echo $form->textFieldRow($item, "[$i]sku", array('placeholder'=>'SKU','class'=>'input-small sku')); ?>
                	<?php echo $form->error($item,"[$i]sku"); ?>
                </td>
                <td>
                	
                	<?php 
                    if (isset($producto))
                        if($producto->tipo == 1){ // es externo, cantidad siempre en 1 
	                        $item->cantidad = 1;
	                    }
	                   
                    echo $form->textFieldRow($item, "[$i]cantidad", array('class'=>'input-small')); 
                    ?>
                	<?php echo $form->error($item,"[$i]cantidad"); ?>
                </td>
                <td>
                    
                    <?php echo $form->textFieldRow($item, "[$i]url_externo", array('class'=>'input-small')); ?>
                    <?php echo $form->error($item,"[$i]url_externo"); ?>
                </td>
                
                <!--<td><img src="http://placehold.it/30"/> <img src="http://placehold.it/30"/> <img src="http://placehold.it/30"/> <br/>
                  <a href="#" class="btn btn-mini margin_top_xsmall"><i class="icon-picture"></i> Agregar/editar imágenes</a></td>-->
                <td>
                    <div class="dropdown"> 
                        <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                            <i class="icon-cog"></i> <b class='caret'></b>
                        </a> 
                        <!-- Link or button to toggle dropdown -->
                        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                            <li>
                                <?php echo CHtml::link('<i class="icon-list-alt"></i>  Ver cambios',
                                        $this->createUrl("/producto/historial", array("id"=>$item->id))
                                ); ?>                                
                            </li>
                            <li>
                                <a href="#" onclick="suprimir(<?php echo $item->id ?>)"><i class="icon-trash"></i>
                                    Eliminar
                                </a>
                                <?php echo $form->hiddenField($item,"[$i]id"); ?>                           
                            </li>                                              
                        </ul>
                    </div>
                	
                	
                </td>
              </tr>
 <?php endforeach; ?>             

 </table>
 
<?php $this->endWidget(); ?>

<script> 
	
	function suprimir(id){
		$.ajax({
	        type: "post", 
	        url: "../suprimir", // action 
	        data: { 'id':id}, 
	        success: function (data) {
				if(data=="ok")
				{
					alert(id);
				}
				location.reload();
	       	}//success
	       })	
	      
	   //  alert(guia);	
		
	}
	
</script>