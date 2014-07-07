<?php
/* @var $this OrdenController */
 
$this->breadcrumbs=array(
	'Devoluciones'=>array('admin'),
	'Detalle'=>array('detalles','id'=>$devolucion->id),

);

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
	<h1> Devolucion #<?php echo $devolucion->id; ?> <small>(Orden #<?php echo $devolucion->orden_id; ?>)</small> </h1>  
	<input type="hidden" id="dev_id" value="<?php echo $devolucion->id; ?>" />
	<hr/>
	<div class="row">
		<div class="span4">
			<div class="margin_left_small margin_top">
				<p class="T_xlarge"><?php echo number_format($devolucion->montodevuelto, 2, ',', '.');  ?></p>
				<span>Monto a Devolver</span>
			</div>
		</div>
		<?php if($devolucion->estado==0){?>
		<div class="span8">
			<a class="btn btn-danger margin_top pull-right" onclick="aceptar(<?php echo $devolucion->id;?>)" href='#'>Aceptar Devolución</a>
		</div>
		<div class="span8">
			<a class="btn margin_top pull-right" href='#' onclick="rechazar(<?php echo $devolucion->id;?>)">Rechazar Devolución</a>
		</div>
		<?php }else{
			echo'
		<div class="span8 margin_top"><p class="T_large pull-right">'.$devolucion->getStatus($devolucion->estado).'</p></div>';
			
		} ?>
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
			<th scope="col">Cantidad a<br/>Devolver</th>
			<th scope="col">Motivo</th>
			<th scope="col"></th>

		        
        </tr>
		
		<?php
		
			//INDIVIDUALES
			
			

			$separados=Devolucionhaspreciotallacolor::model()->getxDevolucion($devolucion->id);			
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
               
              
               echo("<td>".$talla->valor." ".array_search($prod['motivoAdmin'],Devolucion::model()->reasons)."</td>");
			   echo("<td>".$prod['monto']."</td>");
			   if($prod['cantidad']>1)
			   		$dis="";
			   else
			   		$dis="disabled='disabled'";
			   
			   if(is_null($prod['motivoAdmin']))
			   		$motivo=array_search($prod['motivo'],Devolucion::model()->reasons);
			   else
			   		$motivo=array_search($prod['motivoAdmin'],Devolucion::model()->reasons);
			  	
			   		
			  	
			   
			  echo "<td><input type='number' id='cant".$prod['id']."' value='".$prod['cantidad']."' class='input-mini cant' max='".$prod['cantidad']."'  min='0' required='required' ".$dis." /></td>";
			
			
			
		if($devolucion->estado==0)
			echo("<td>".CHtml::dropDownList("motivo".$prod['id'],$motivo,Devolucion::model()->reasons,array('class'=>'motivos'))."<br/><small><strong>Usuario:</strong> ".$prod['motivo']."</small></td>");
		else
			echo("<td><small><strong>Admin:</strong> ".$prod['motivoAdmin']."</small><br/><small><strong>Usuario:</strong> ".$prod['motivo']."</small></td>");
		
                                        
			   
			   
			   if($devolucion->estado==0){
			   echo "
	<td>
	<div class='dropdown pull-right'>
	<a class='dropdown-toggle btn' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='admin_pedidos_detalles.php'>
	<i class='icon-cog'></i> <b class='caret'></b>
	</a> 
          <!-- Link or button to toggle dropdown -->
          <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>";
             if(!$prod['rechazado']&&$devolucion->estado!=5)
				   echo("<li><a href='#' onclick='anular(".$prod['id'].")'><i class='icon-remove'></i> Anular Producto</a></li>");
			   else
				   echo("<li><a href='#' onclick='activar(".$prod['id'].")'><i class='icon-ok'></i> Reaceptar Producto</a></li>");
		
			   	echo("<li><a href='#' onclick='guardar(".$prod['id'].",true)'><i class='icon-check'></i> Actualizar</a></li>");
            
          echo "</ul>
        </div></td>";}
	else{
		if($prod['rechazado']==1){
			echo "<td><i class='icon-remove' title='Producto Anulado para devolución'></i></td>";
		}
		else{
			echo "<td><i class='icon-ok' title='Producto Aceptado para devolución'></i></td>";
		}
	}
              
}
			
	   
      ?>
	   

    	</table>
    	
    	
	</div>

</div> 
<!-- /container --> 

<script type="text/javascript"> 
	
 		$( ".motivos" ).change(function() {
  			var id=$(this).attr("name").replace("motivo", "");
  			guardar(id ,false);
		});
 	
 	function aceptar(id){
 		
 		$.ajax({
                        type: "post", 
                        url: "../aceptarDevolucion", // action 
                        data: { 'id':id}, 
                        success: function (data) {

                            if(data=="ok")
                               window.location.replace("<?php echo Yii::app()->baseUrl;?>/orden/admindevoluciones");
                          		
                           if(data=="error")
                                    location.reload();
                            if(data=='no')
                            	location.reload();      
                         }
                    });
 		
 	}
  	function rechazar(id){
  		$.ajax({
                        type: "post", 
                        url: "../rechazarDevolucion", // action 
                        data: { 'id':id}, 
                        success: function (data) {

                            if(data=="ok")
                                    window.location.replace("<?php echo Yii::app()->baseUrl;?>/orden/admindevoluciones");
                            if(data=="error")
                                    location.reload();
                            if(data=='no')
                            	location.reload();       
                         }
                    });
  		
  	}
  	function anular(id){
  		
  		$.ajax({
                        type: "post", 
                        url: "../anularDevuelto", // action 
                        data: { 'id':id}, 
                        success: function (data) {

                            if(data=="ok")
                                    location.reload();
                            if(data=="error")
                                   location.reload();
                            if(data=='no')
                            	location.reload();       
                         }
                    });
  		
  	}
  	
  	function activar(id){
  		
  		$.ajax({
                        type: "post", 
                        url: "../activarDevuelto", // action 
                        data: { 'id':id}, 
                        success: function (data) {

                            if(data=="ok")
                                    location.reload();
                            if(data=="error")
                                   location.reload();
                            if(data=='no')
                            	location.reload();       
                         }
                    });
  		
  	}
  	
  	function guardar(id,reload){
  		var cantidad=$('#cant'+id).val();
  		var motivo=$('#motivo'+id).val();

  		$.ajax({
                        type: "post", 
                        url: "../cantidadDevuelto", // action 
                        data: { 'id':id, 'cantidad':cantidad, 'motivo':motivo}, 
                        success: function (data) {

                            if(data=="ok")if(reload){location.reload();}
                                    
                            if(data=="error")if(reload){location.reload();}
                                    
                            if(data=='no')if(reload){location.reload();  }
                            	     
                         }
                    });
  		
  	}
  	
  	
  	
  	$('body').on('input','.cant', function(){
 	var a =  parseInt($(this).val());
	var b = parseInt($(this).attr('max'));
 	if(isNaN(a)){
	    	$(this).val('0'); 
	    		   		
	}
	else {
		if(a>b){
			$(this).val('0'); 
					
	   	}
		if(a<1&&a>0){
			$(this).val('0'); 
		}
				
	}
	
	 calcularDevolucion();
  
});
  	
  	
  	
	
</script>