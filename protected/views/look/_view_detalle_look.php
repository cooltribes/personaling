<!-- Modal 1 -->

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?php echo $model->title; ?></h3>
    </div>
    <div class="modal-body">
      <div class="text_align_center">
      	
      	<?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$model->id)), "Look", array("width" => "300", "height" => "300", 'class'=>'img-polaroid')); ?>
      	</div>
      <hr/>
        <div >
        <h4>Productos</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed"> 
        	<?php foreach($model->lookhasproducto as $lookhasproducto){ ?>     
<tr> <th scope="row"><?php echo $lookhasproducto->producto->nombre; ?></th>
 <td><?php echo $lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id); ?> disponibles</td>
<td>           <?php   echo $lookhasproducto->producto->getPrecio(); ?> Bs.</td>

 
</tr>
<?php } ?>
<!--
<tr> <th scope="row">Mango - Camisa Y</th>
 <td>20 disponibles</td>
 <td>650,00 Bs.</td>
</tr>
<tr> <th scope="row">Aldo - Zapatos Z</th>
 <td> 8 disponibles</td>
<td>715,00 Bs</td>
</tr><tr>
<th scope="row">Accessorize - Accesorios A,B y C</th>
<td>30 disponibles</td>

<td>  50,00 Bs.</td>
  </tr>
 -->
</table>
            <h4>Precios</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed">
                <tr>
                    <th scope="row">Precio base</th>
                    <td> Bs. 700,00 </td>
                </tr>
                <tr>
                    <th scope="row">Precio con descuento</th>
                    <td> Bs. <?php echo $model->getPrecio(); ?></td>
                </tr>
                <tr>
                    <th scope="row">Descuento %</th>
                    <td>7.15%</td>
                </tr>
                <tr>
                    <th scope="row">Descuento Bs.</th>
                    <td>Bs. 50,00</td>
                </tr>
            </table>
            <hr/>
            <h4>Estadísticas</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed">
                <tr>
                    <th scope="row">Vistas</th>
                    <td>120</td>
                </tr>
                <tr>
                    <th scope="row">Looks que lo usan</th>
                    <td>18</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="modal-footer"> 
    	<a href="#" title="eliminar" class="btn"><i class="icon-trash"></i> Eliminar</a> 
    	<a href="#" title="Exportar" class="btn"><i class="icon-share-alt"></i> Exportar</a> 
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Editar',
			'icon'=>'edit',
			'url' => CController::createUrl('look/edit',array('id'=>$model->id)),
			//'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			//'size'=>'large', // null, 'large', 'small' or 'mini'
		)); ?>
 <?php $this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Ver',
			'icon'=>'eye-open',
			'url' => CController::createUrl('look/view',array('id'=>$model->id)),
			'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			//'size'=>'large', // null, 'large', 'small' or 'mini'
		)); ?>
    	
    	
    	<!-- <a href="" title="ver" class="btn btn-info" target="_blank"><i class="icon-eye-open icon-white"></i> Ver</a> -->
    </div>
