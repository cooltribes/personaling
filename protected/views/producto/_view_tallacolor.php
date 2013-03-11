<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'Tallacolor-Form',
    //'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
)); ?>

<table id="table_tallacolor" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
              <tr>
                <th scope="col">Color</th>
                <th scope="col">Talla</th>
                <th scope="col">SKU/Código</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Imágenes</th>
                <th scope="col">Acciones</th>
              </tr>
 <?php foreach($tallacolor as $i=>$item): ?>          
              <tr>
                <td>
                	<?php echo $form->textFieldRow($item, 'color', array('class'=>'input-small', 'disabled'=>true)); ?>
                	
                </td>
                <td>
                	<?php echo $form->textFieldRow($item, 'talla_id', array('class'=>'input-small', 'disabled'=>true)); ?>
                	
                </td>
                
                <td><input name="" type="text" class="input-small input-sku"></td>
                <td><input name="" type="text" class="input-small input-cant"></td>
                
                <td><img src="http://placehold.it/30"/> <img src="http://placehold.it/30"/> <img src="http://placehold.it/30"/> <br/>
                  <a href="#" class="btn btn-mini margin_top_xsmall"><i class="icon-picture"></i> Agregar/editar imágenes</a></td>
                <td><a href="#" class="pull-right btn btn-mini margin_left_xsmall"><i class="icon-edit"></i></a> <a href="#"></a> <a href="#" class="pull-right"><i class="icon-trash"></i></a></td>
              </tr>
 <?php endforeach; ?>             

 </table>
 
<?php $this->endWidget(); ?>