<div id="carrito_compras">
  <div class="row detalle_producto">
    <div class="span12">
      <div class="row"> 
 		<article> 
          <?php 
          

		$id=$producto->id;
		$producto = Producto::model()->findByPk($id);
		$tienda=null;
		if($producto->tipo){
			
			$tienda=Tienda::model()->findByPk($producto->tienda_id);
			$msj="Comprar en ".$tienda->urlVista;
		}
			
	
	?>
 

		<h3><?php echo $producto->nombre ?></h3>
   		<div class='span7'>
   		 	<div class='carousel slide imagen_principal' id='myCarousel'>
   		 <?php 
			$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
		 ?>
        		<div class="carousel-inner" id="carruselImag">
	<?php    foreach ($ima as $img){
					
			if($img->orden==1)
			{ 
				$colorPredet = $img->color_id;
				
				echo '<div class="item active">';	
				echo  CHtml::image($img->getUrl(array('ext'=>'jpg')), "Personaling - ".$producto->nombre, array("width" => "450", "height" => "450"));
				echo '</div>';
			}
				
			if($img->orden!=1){
				if($colorPredet == $img->color_id)
				{
					echo '<div class="item">';
					echo CHtml::image($img->getUrl(array('ext'=>'jpg')), "Personaling - ".$producto->nombre, array("width" => "450", "height" => "450"));
					echo '</div>';
				}
			}// que no es la primera en el orden
		} ?>
		
       			</div>
			      <a data-slide="prev" href="#myCarousel" class="left carousel-control">&lsaquo;</a>
			      <a data-slide="next" href="#myCarousel" class="right carousel-control">&rsaquo;</a>
      		</div>
     </div>
        
	  <div class="span5">
	   		<div class="row-fluid">

	<?php
   		$precio_producto = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
	    if($precio_producto){
	        if(!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0){
	          switch ($precio_producto->tipoDescuento) {
	            case 0:
	              $porcentaje = $precio_producto->valorTipo;
	              break;
	            case 1:
	              $porcentaje = ($precio_producto->valorTipo * 100) / $precio_producto->precioImpuesto;
	              break;
	            default:
	              # code...
	              break;
	          }
	          $precio_mostrar = $precio_producto->precioImpuesto;
	          echo '<span class="preciostrike strikethrough color9 T_mediumLarge">'.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->format("#,##0.00",$precio_mostrar)."</span><span class='T_large'>|</span><span class='pDescuento'>".''.Yii::t('contentForm', 'currSym')." ".Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioDescuento).'</span> <span class="conDescuento">Con '.Yii::app()->numberFormatter->format("#",$porcentaje).'% de descuento</span>';
	          //echo '<span class="preciostrike strikethrough">'.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio_mostrar).'</span> | '.''.Yii::t('contentForm', 'currSym')." ".$precio_producto->precioImpuesto.' Con '.round($porcentaje).'% de descuento';
	        }else{
	        	echo '<div class="pDetalle"><span>'.Yii::t('contentForm', 'currSym').'</span>'.Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioImpuesto).'</div>';
			}
	    }?>

        	</div>
     
        
      		<div class="margin_top_xsmall">
	<?php
	

        
       
      /*  if($producto->mymarca->is_100chic)
        	echo '<div class="row-fluid"><div class="span12"><img src="'.Yii::app()->baseUrl.'/images/080bannerprevia.jpg'.'"</div><div class="row-fluid">';
		else*/
			echo '<div class="row-fluid margin_top_small"><div class="row-fluid">';
        echo '<div class="half">';
        echo '<h5>Colores</h5>';
        echo '<div class="clearfix colores" id="vCo">';
        
        	$valores = Array();
            $cantcolor = Array();
            $cont1 = 0;
              	

			// revisando cuantos colores distintos hay 
			foreach ($producto->preciotallacolor as $talCol){ 


				if($talCol->cantidad > 0){
					$color = Color::model()->findByPk($talCol->color_id);
					
					if(in_array($color->id, $cantcolor)){	// no hace nada para que no se repita el valor			
					}
					else {
						array_push($cantcolor, $color->id);
						$cont1++;
					}	
				}
			}
				
			if( $cont1 == 1){ // Si solo hay un color seleccionelo
				$color = Color::model()->findByPk($cantcolor[0]);							
				echo  "<div value='solo' id=".$color->id." class='coloress active' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image."'></div>"; 		
			}
			else{
				foreach ($producto->preciotallacolor as $talCol) {
		        	if($talCol->cantidad > 0){ // que haya disp
						$color = Color::model()->findByPk($talCol->color_id);		
								
						if(in_array($color->id, $valores)){	// no hace nada para que no se repita el valor			
						}
						else{
							echo  "<div id=".$color->id." class='coloress' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image."'></div>"; 
							array_push($valores, $color->id);
						}
					}
		   		}
				
			}  
		?>
			</div>
	</div>
		
   <div class="half">
		<h5>Tallas</h5>
		<div class="clearfix tallas" id="vTa">
		<?php
		$valores = Array();
		$canttallas= Array();
        $cont2 = 0;
              	
		// revisando cuantas tallas distintas hay
		foreach ($producto->preciotallacolor as $talCol){ 
			if($talCol->cantidad > 0){
				$talla = Talla::model()->findByPk($talCol->talla_id);
						
				if(in_array($talla->id, $canttallas)){	// no hace nada para que no se repita el valor			
				}
				else{
					array_push($canttallas, $talla->id);
					$cont2++;
				}
							
			}
		}

		if( $cont2 == 1){ // Si solo hay un color seleccionelo
			$talla = Talla::model()->findByPk($canttallas[0]);
			echo  "<div value='solo' id=".$talla->id." class='tallass active' title='talla'>".$talla->valor."</div>"; 
		}
		else{            	
			foreach ($producto->preciotallacolor as $talCol) {
	        	if($talCol->cantidad > 0){ // que haya disp
					$talla = Talla::model()->findByPk($talCol->talla_id);
		
					if(in_array($talla->id, $valores)){	// no hace nada para que no se repita el valor			
					}
					else{
						echo  "<div id=".$talla->id." class='tallass' title='talla'>".$talla->valor."</div>"; 
						array_push($valores, $talla->id);
					}
				}
	   		}	
	   	}// else
		?>
      
       		</div>
	</div> 
	</div> 
	
	<div>  
       <?php
       
       if(is_null($tienda))
       		echo '<a class="btn btn-warning btn-block margin_top_small" title="Agregar a la bolsa" id="agregar" onclick="c()"> <i class="icon-shopping-cart icon-white"></i> Comprar </a>';
		else
			echo '<a class="btn btn-warning btn-block margin_top_small" target="_blank" href="'.$producto->url_externo.'" title="'.$msj.'" >'.$msj.'</a>';
        	
       ?>
   </div>
	
	
	
    
		<?php $marca = Marca::model()->findByPk($producto->marca_id); ?>
   		<div  class="complete margin_top_small">
	  		<div class="thumbnails margin_top_small">
	   			<div class="fifth4">
	   				<strong><?php echo Yii::t('contentForm','Description'); ?></strong>: <?php echo $producto->descripcion; ?><br/>
	   				<strong><?php echo Yii::t('contentForm','Weight'); ?></strong> <?php echo  $producto->peso; ?>
	    		</div>
	   			<div class="fifth">
	   				<img width="66px" height="66px" src="<?php echo Yii::app()->baseUrl .'/images/marca/'. str_replace(".","_thumb.",$marca->urlImagen)?>"/>
	    		</div> 
	    	 
	    	</div>
    	</div>
    	<div class="addthis braker_horz">
    		<div class="complete margin_top_medium">
  				<div class="half">
    
     		</div>
     		<div class="half">
     			
     			<?php if(!Yii::app()->user->isGuest){
   
		        $like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$producto->id));
		 
		
		              if(isset($like)) // le ha dado like 
		        {
		            ?>
		          
		            	<a class="btn btn-danger_modificado" id="btn-encanta" onclick="encantar()">
		            		<span class="entypo icon_personaling_medium">&nbsp;</span> 
		            		<?php echo Yii::t('contentForm','Like'); ?>
		            	</a> &nbsp;
		              <?php
		        }
		        else {
		        ?>
		       	
		       			<a class="btn lighted" id="btn-encanta" onclick="encantar()">
		       				<span class="entypo icon_personaling_medium"> &nbsp; </span> 
		       				<?php echo Yii::t('contentForm','Like'); ?>
		       			</a> &nbsp;
		        <?php
		        }
		        ?>
		       		<small id="total-likes" class="lighted">
		        <?php 
		          $cuantos = UserEncantan::model()->countByAttributes(array('producto_id'=>$producto->id));   
		          echo $cuantos;
		        ?>
		        	</small>
			<?php } ?>
     			
     		</div>
      		
     			</article>
     		</div>
     	</div>
  	</div>
 </div>
    	
    	<div id="alertRegister" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
		 <div class="modal-header">
		    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
		     <h3 ><?php echo Yii::t('contentForm','Important')?></h3>
		 
		  </div>
		  <div class="modal-body">
		 		 <h4><?php echo  Yii::t('contentForm','Please complete your registration to make a purchase on Personaling.')?></h4>
		 		 
		  </div>  
		  <div class="modal-footer">  
		  	<div class="row-fluid">
		  		<a class="btn btn-danger span3" href="<?php echo Yii::app()->baseUrl;?>/registro-personaling">'.Yii::t('contentForm','Complete Registration').'</a>
		 		<div class="span6"></div>
		 		<button class="btn closeModal span3" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		 	
		  	</div>
		  	
		  	
		  </div>
		</div>

   	<script>	
   		function encantar()
    {
	      var idProd = <?php echo $id;?>;
	
	      $.ajax({
	          type: "post",
	          dataType:"json",
	          url: "<?php echo Yii::app()->baseUrl;?>/producto/encantar", // action Tallas de Producto
	          data: { 'idProd':idProd}, 
	          success: function (data) {
	        
	        if(data.mensaje=="ok") 
	        { 
	          var a = "♥";	          
              $("#total-likes").text(data.total); 
	          $("#btn-encanta").addClass("btn-danger_modificado");
	        }
	        
	        if(data.mensaje=="no")
	        {
	          bootbox.alert("Debes ingresar con tu cuenta de usuario o registrarte antes de dar 'Me Encanta' a un producto");

	        }
	         
	        if(data.mensaje=="borrado")
	        {
	          var a = "♡"; 
	          $("#btn-encanta").removeClass("btn-danger_modificado");
              $("#total-likes").text(data.total);         
	        }
	          
	          }//success
	         });
      
      
    }
    
    
    
    
    
    

		
        function agregarBolsaGuest(producto, talla, color){

       <?php echo CHtml::ajax(array(
	            	'url'=>array('/producto/agregarBolsaGuest'),
			        'data'=>array('producto'=>'js:producto',
                                            'talla'=>'js:talla',
                                            'color'=>'js:color'),
                        'dataType'=>'JSON',
                        'type'=>'POST',
                        'success'=>"function(data)
                        {
                            if(data.status == 'success'){                  
                                
                                $('#myModal').on('hidden', function () {
                                  
                                    desplegarBolsaGuest(data);
                                });
                                $('#myModal').modal('hide');

                            }

                        } ",
                        )); ?>
        } //Cerrar funcion agregarBolsaGuest();
                
		$("body").removeClass("aplicacion-cargando");
		var bandera=false;
		$(document).ready(function() {
		$('.closeModal').click(function(event){
		$('#alertRegister').hide();});
		$('.coloress').click(function(ev){// Click en alguno de los colores -> cambia las tallas disponibles para el color
		ev.preventDefault();
			
				
			var prueba = $("#vTa div.tallass.active").attr("value");
				if(prueba == 'solo'){
   				$(this).addClass('coloress active'); // aÃ±ado la clase active al seleccionado
   				$('#vTa div.tallass.active').attr('value','0');
			}
   			else{
				$("#vCo").find("div").siblings().removeClass("active"); // para quitar el active en caso de que ya alguno estuviera seleccionado
   				var dataString = $(this).attr("id");
     			var prod = $("#producto").attr("value");
     			$(this).removeClass('coloress');
  				$(this).addClass('coloress active');// aÃ±ado la clase active al seleccionado
				
  				<?php echo CHtml::ajax(array(
            		'url'=>array('producto/tallaspreview'),
		            'data'=>array('idTalla'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vTa').fadeOut(100,function(){
			     			$('#vTa').html(data.datos); // cambiando el div
			     		});
			
			      		$('#vTa').fadeIn(20,function(){});
						
						$('#carruselImag').fadeOut(100,function(){
			     			$('#carruselImag').html(data.imagenes); 
			     		});
			
			      		$('#carruselImag').fadeIn(20,function(){});
						
						//$('#carruselImag').html(data.imagenes);
						
		 				
		            } ",
		            )); ?>
		    	 return false; 

				
				} // else
				
			});// coloress click
			
			
		$(".tallass").click(function(ev){ // click en tallas -> recarga los colores para esa talla
			ev.preventDefault();

			var prueba = $("#vCo div.coloress.active").attr("value");

   			if(prueba == 'solo'){
   				$(this).addClass('tallass active'); // aÃ±ado la clase active al seleccionado
   				$("#vCo div.coloress.active").attr("value","0");
   			}
   			else{
		   		$("#vTa").find("div").siblings().removeClass("active"); // para quitar el active en caso de que ya alguno estuviera seleccionado
		   		var dataString = $(this).attr("id");
     			var prod = $("#producto").attr("value");
     
     			$(this).removeClass('tallass');
  				$(this).addClass('tallass active'); // aÃ±ado la clase active al seleccionado
     
     			<?php echo CHtml::ajax(array(
            		'url'=>array('producto/colorespreview'),
		            'data'=>array('idColor'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vCo').fadeOut(100,function(){
			     			$('#vCo').html(data.datos); // cambiando el div
			     		});
			
				      	$('#vCo').fadeIn(20,function(){});				

		            } ",
		            )); ?>
		    		 return false;    
     
				} //else
			}); // tallas click
			
		}); // ready
		
		// fuera del ready
		
		function a(id){// seleccion de talla
			$("#vTa").find("div").siblings().removeClass("active");
			$("#vTa").find("div#"+id+".tallass").removeClass("tallass");
			$("#vTa").find("div#"+id).addClass("tallass active");
   		}
   
   		function b(id){ // seleccion de color
   			$("#vCo").find("div").siblings().removeClass("active");
   			$("#vCo").find("div#"+id+".coloress").removeClass("coloress");
			$("#vCo").find("div#"+id).addClass("coloress active");		
   		}
		
		function c(){ // comprobar quienes estÃ¡n seleccionados
   		
   			var talla = $("#vTa").find(".tallass.active").attr("id");
   			var color = $("#vCo").find(".coloress.active").attr("id");
   			var producto = $("#producto").attr("value");
   		
   			// llamada ajax para el controlador de bolsa
 		  
 			if(talla==undefined && color==undefined){ // ninguno
 				alert("Seleccione talla y color para poder aÃ±adir.");
 			}
 		
 			if(talla==undefined && color!=undefined){// falta talla 
 				alert("Seleccione la talla para poder aÃ±adir a la bolsa.");
 			}
 		
 			if(talla!=undefined && color==undefined){// falta color
 				alert("Seleccione el color para poder aÃ±adir a la bolsa.");
 			}
			
			if(talla!=undefined && color!=undefined){
			 if(bandera==true) return false; bandera = true; 
			$("#agregar").click(function(e){e.preventDefault();});$("#agregar").addClass("disabled"); 

                    var isGuest = <?php echo (Yii::app()->user->isGuest?"true":"false"); ?>;
                     if(isGuest)
                                {                                   
                                
                                    agregarBolsaGuest('.$id.', talla, color);
                                    
                                }else{ 
				
                       <?php echo CHtml::ajax(array(
	            	'url'=>array('bolsa/agregar'),
			        'data'=>array('producto'=>$id,'talla'=>'js:$("#vTa").find(".tallass.active").attr("id")','color'=>'js:$("#vCo").find(".coloress.active").attr("id")'),
			        'type'=>'post',
			        'success'=>"function(data)
			        {
						if(data=='ok'){
							//alert('redireccionar maÃ±ana');
							window.location='../bolsa/index';
						}
						
						if(data=='no es usuario'){
							$('#alertRegister').show();
						}
						
			        } ",
		   		));?>
                         
                        }     //cerrar else para usuarios logueados
                         
				 return false;     
 			} // cerro   
			
		} // c
			
    </script>








