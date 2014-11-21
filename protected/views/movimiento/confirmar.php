<?php
/* @var $this OrdenController 
 
$this->breadcrumbs=array(
	'Devoluciones'=>array('admin'),
	'Detalle'=>array('detalles','id'=>$devolucion->id),

);
*/
?>

	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

<div class="container margin_top">
	<h1>Egreso por mercadeo</h1>  

	<hr/>
	<div class="row">
		<div class="span4">
			<!-- <div class="margin_left_small margin_top">
				<p class="T_xlarge"><?php //echo number_format($devolucion->montodevuelto, 2, ',', '.');  ?></p>
				<span>Monto a Devolver</span>
			</div> -->
		</div>

		
		
	</div>
	</div>

   <div> 
     <h3 class="braker_bottom">Productos</h3>
      <table id="myTable" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
        	<th scope="col"></th>
        	<th scope="col">Referencia</th>
			<th scope="col">Marca</th>
			<th scope="col">Nombre</th>
			<th scope="col">Color</th>
			<th scope="col">Talla</th>
			<th scope="col">Costo(<?php echo Yii::t('contentForm','currSym'); ?>)</th>
			<th scope="col">Cantidad</th>
			<th scope="col">Total prenda</th>
			


		        
        </tr>
		
		<?php
			$total=0;
			foreach($ptcs as $key => $ptc){
			
				$indiv = $ptc->producto;
				
				$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
				
				
                                $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id,'color_id'=>$ptc->mycolor->id),array('order'=>'orden'));
                                $contador=0;
                                $foto = "";
                                $label = $ptc->mycolor->valor;
                                //$label = "No hay foto</br>para el color</br> ".$color->valor;
                                 if(!is_null($ptc->imagen))
                                  {
                                    $ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id,'color_id'=>$ptc->mycolor->id),array('order'=>'orden ASC'));
                                    if(sizeof($ima)==0)
                                        $ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id),array('order'=>'orden ASC'));
                                    if(sizeof($ima)==0) 
                                        $foto=CHtml::image('http://placehold.it/50x50', "producto", array('id'=>'principal','rel'=>'image_src','width'=>'50px'));
                                    else
                                        $foto=CHtml::image($ima[0]->getUrl(array('ext'=>'png')), "producto", array('id'=>'principal','rel'=>'image_src','width'=>'50px'));
                                                         
                                  }
                                    else {
                                        $foto="No hay foto</br>para el color";
                                    } 
                            
                                
				echo("<tr>");
//				echo("<td>".$indiv->codigo."</td>");// Referencia
//				echo("<td>".CHtml::link($indiv->nombre, $this->createUrl('producto/detalle', array('id'=>$indiv->id)), array('target'=>'_blank'))."</td>"); // nombre
				/*Datos resumidos + foto*/
				echo("<td style='text-align:center'><div>".$foto."<br/>".$label."</div></td>");
                 
				echo('<td style="vertical-align: middle">'.$indiv->codigo.'</td>');
               echo("<td>".$indiv->mymarca->nombre."</td>");
               echo(   "<td>".$indiv->nombre."</td>");
                echo("<td>".$ptc->mycolor->valor."</td>");                         
               
              
               echo("<td>".$ptc->mytalla->valor."</td>");
			   echo("<td>".$indiv->getCosto(true)."</td>");
			   echo("<td>".$cantidades[$key]."</td>");
			   echo("<td>".Yii::app()->numberFormatter->format("#,##0.00",$indiv->getCosto(false)*$cantidades[$key])."</td></tr>");
				$total+=$indiv->getCosto(false)*$cantidades[$key];			  	
			              
			}
			
	   
      ?>
	   <tr>
	   	<td  align="right" colspan="7"><strong>TOTAL</strong></td>
	   	<td><?php echo array_sum($cantidades);?></td>
	   	<td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$total);?></td>
	   </tr>
		
    	</table>
    	
    	
	</div>
	
	<div class="row">
		<div class="span12">
			<textarea id="comentario" name="comentario" rows="3" cols="50" class="span12" maxlength="250" placeholder="Describe el motivo de este egreso de mercancía"></textarea>
		</div>
		<div class="span12">
			<a class="btn btn-danger margin_top pull-right"  href='#' onclick="$('#alertTipo').modal();">Registrar Egreso</a>
		</div>
		
	</div>

</div> 
<!-- /container --> 
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'alertTipo','htmlOptions'=>array('class'=>'modal hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<div class="modal-header">
        <h3 ><?php echo Yii::t('contentForm','Important');?></h3>
 </div>
  <div class="modal-body">
 		 <h3><?php echo Yii::t('contentForm','You should select the destination of this expenditure');?></h3>

 		 
  </div>
  <div class="modal-footer">
  	<div class="row-fluid">
 		 	<div class="span6" align="center">
 		 		<button class="btn btn-danger closeModal" data-dismiss="modal" aria-hidden="true" onclick="aceptar('<?php echo implode(',',$ids); ?>','<?php echo implode(',',$cantidades); ?>','<?php echo $total; ?>',0)"><i class='icon-thumbs-up icon-white'></i> Mercadeo</button>
 		 	</div>
 		 	<div class="span6" align="center">
 		 		<button class="btn btn-danger closeModal" data-dismiss="modal" aria-hidden="true" onclick="aceptar('<?php echo implode(',',$ids); ?>','<?php echo implode(',',$cantidades); ?>','<?php echo $total; ?>',1)"><i class='icon-thumbs-down icon-white'></i> Prenda dañada</button>
 		 	</div>
 		 </div>
  	
  </div>


<?php $this->endWidget(); ?>






<script type="text/javascript"> 
	
 	function aceptar(ids,cantidades,total,tipo){
		
		 

			comentario=$('#comentario').val();

 		$.ajax({
                        type: "post", 
                        url: "registrarEgreso", // action 
                        data: { 'ids':ids, 'cantidades':cantidades,'total':total,'comentario':comentario,'tipo':tipo}, 
                        success: function (data) {

                            if(data=="ok")
                               window.location.replace("<?php echo Yii::app()->baseUrl;?>/movimiento/adminEgresos");
                          		
                           if(data=="error")
                                    location.reload();
                            if(data=='no')
                            	location.reload();      
                         }
                    });
 		
 	}
 	

  

  	
  	
  	
	
</script>