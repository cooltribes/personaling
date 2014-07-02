<?php
/* @var $this OrdenController */
 /*
$this->breadcrumbs=array(
	'Egresoss'=>array('admin'),
	'Detalle'=>array('egresos','id'=>$movimiento->id),

);*/
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
	<h1> Egreso #<?php echo $movimiento->id; ?></h1>  
	<input type="hidden" id="mov_id" value="<?php echo $movimiento->id; ?>" />
	<hr/>
	<div class="row">
		<div class="span12">
		<h4>"<?php echo $movimiento->comentario;?>"</h4>
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
			<th scope="col">Valor<br/>Unitario(<?php echo Yii::t('contentForm','currSym'); ?>)</th>
			<th scope="col">Cantidad</th>


		        
        </tr>
		
		<?php
		
			//INDIVIDUALES
			
			

			$separados=Movimientohaspreciotallacolor::model()->getxMovimiento($movimiento->id);			
			foreach($separados as $prod){
				$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod['preciotallacolor_id'])); // consigo existencia actual
				$indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
				$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
				$marca=Marca::model()->findByPk($indiv->marca_id);
				$talla=Talla::model()->findByPk($ptc->talla_id);
				$color=Color::model()->findByPk($ptc->color_id);
				
                                $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id,'color_id'=>$color->id),array('order'=>'orden'));
                                $contador=0;
                                $foto = "";
                                $label = $color->valor;
                                //$label = "No hay foto</br>para el color</br> ".$color->valor;
                                 if(!is_null($ptc->imagen))
                                  {
                                     $foto = CHtml::image(Yii::app()->baseUrl.str_replace(".","_thumb.",$ptc->imagen['url']), "Imagen ", array("width" => "40", "height" => "40"));

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
               echo("<td>".$marca->nombre."</td>");
               echo(   "<td>".$indiv->nombre."</td>");
                echo("<td>".$color->valor."</td>");                         
               
              
               echo("<td>".$talla->valor."</td>");
			   echo("<td>".$prod['costo']."</td>");
			   echo("<td>".$prod['cantidad']."</td>");	              
			}
			
	   
      ?>
	   

    	</table>
    	
    	
	</div>

</div> 
<!-- /container --> 
