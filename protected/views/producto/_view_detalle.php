	<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>

<?php  
 $baseUrl = Yii::app()->baseUrl;
 $cs = Yii::app()->getClientScript();
 $cs->registerScriptFile($baseUrl.'/js/jquery.zoom.js');

?>

<!-- FLASH OFF -->
<div class="container margin_top" id="carrito_compras">
  <div class="row detalle_producto">
    <div class="span12">
      <div class="row"> 
        <!-- Columna principal ON -->
        <article class="span8">
          <div class="row">
            <div class="span6">
            	<input id="producto" type="hidden" value="<?php echo $producto->id ?>" />
              <h1> <?php echo $producto->nombre; ?> <span class="label label-important"> ON SALE</span></h1>
            </div>
            <div class="span2 share_like">
            	
            	<?php
            	$entro = 0;
				
				$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$producto->id));
            	
            	if(isset($like)) // le ha dado like
				{
					//echo "p:".$like->producto_id." us:".$like->user_id;
					$entro=1;
					?>
						<button id="meEncanta" onclick='encantar()' title="Me encanta" class="btn-link btn-link-active">
               				<span id="like" class="entypo icon_personaling_big">&hearts;</span>
               			</button>
               		<?php	
					
				}
					
					if($entro==0)
					{
						echo "<button id='meEncanta' onclick='encantar()' title='Me encanta' class='btn-link'>
               			<span id='like' class='entypo icon_personaling_big'>&#9825;</span>
               			</button>";
					}

               	?>
               	
                <div class="btn-group">
                  <button class="dropdown-toggle btn-link" data-toggle="dropdown"><span class="entypo icon_personaling_big">&#59157;</span></button>
                  <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                    <!-- AddThis Button BEGIN -->
                    
                    <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                    <li><a class="addthis_button_tweet"></a></li>
                    <li><a class="addthis_button_pinterest_pinit"></a></li>
                  </ul>
                  <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                  <!-- AddThis Button END --> 
                  
                </div>
            </div>
          </div>
          <div class="row">
          	<?php
             	
             	$colorPredet="";
             	
            	echo "<div class='span6'><div class='imagen_principal'> 
            			<!-- FOTO principal ON -->";
            	
            	$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
	
			foreach ($ima as $img){
					
				if($img->orden==1)
				{
					$colorPredet = $img->color_id;
					echo CHtml::image(Yii::app()->baseUrl . $img->url, "producto", array('id'=>'principal'));
					echo "<!-- FOTO principal OFF -->";
	          		echo "</div>";	
	          		echo "</div>";	
					
					echo " <div class='span2'> 
            				<!-- FOTOS Secundarias ON -->
            				<div class='imagenes_secundarias'> 
            				";
				
					//imprimiendo igual la primera en thumbnail
					$pri = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
					echo CHtml::image(Yii::app()->baseUrl . $pri->url, "Imagen ", array("width" => "90", "height" => "90",'id'=>'thumb'.$pri->id,'class'=>'miniaturas_listado_click','style'=>'cursor: pointer'));					
							
				}
				
				if($img->orden!=1){
					if($colorPredet == $img->color_id)
					{
						//luego el resto para completar el scroll					
						echo CHtml::image(Yii::app()->baseUrl . $img->url, "Imagen ", array("width" => "90", "height" => "90", 'id'=>'thumb'.$img->id, 'class'=>'miniaturas_listado_click','style'=>'cursor: pointer'));
						
					}// color
				}// que no es la primera en el orden
			}
			
			echo "</div></div>";
            
			/*
            <!-- FOTOS Secundarias OFF -->
			 * */
			
            ?>
            
          </div>
        </article>
        <!-- Columna principal OFF --> 
        
        <!-- Columna Secundaria ON -->
        <div class="span4 columna_secundaria margin_bottom margin_top padding_top">
          <div class="row call2action">
            <div class="span2">
              <h4 class="precio" ><span>Subtotal</span> Bs. 
              	<?php foreach ($producto->precios as $precio) {
   					echo Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento); // precio
   					}
	
			?></h4>
            </div>
            <div class="span2">
              <div class="btn-group"> <a class="btn btn-warning" ><span class="entypo color3">&#128274;</span></a>
              	<a onclick="c()" id="agregar" title="agregar a la bolsa" class="btn btn-warning"> Añadir a la bolsa </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="span2">
              <h5>Colores</h5>
              <div id="vCo" class="clearfix colores">
              	<?php

              	$valores = Array();
				              	
				foreach ($producto->preciotallacolor as $talCol) {
              		
              		if($talCol->cantidad > 0) // que haya disp
					{
						$color = Color::model()->findByPk($talCol->color_id);		
						
						if(in_array($color->id, $valores)){	// no hace nada para que no se repita el valor			
						}
						else{
							echo "<div id=".$color->id." style='cursor: pointer' class='coloress' title='".$color->valor."'><img src='/site/images/colores/".$color->path_image."'></div>"; 
							array_push($valores, $color->id);
						}
						
						/*
						<a href="#" title="color"><img  src="http://placehold.it/40/22F28A/22F28A"/></a>
	              		<a href="#" title="color"><img  src="http://placehold.it/40/3691AD/3691AD"/></a>
	              		<a href="#" title="color"> <img  src="http://placehold.it/40/AD3682/AD3682"/></a>
	              		<a href="#" title="color"><img  src="http://placehold.it/40/FF9600/FF9600"/></a>
						* */
					}
   				}
              	?>
              </div>
            </div>
            <div class="span2">
              <h5>Tallas</h5>
              <div id="vTa" class="clearfix tallas">
              	<?php

              	$valores = Array();
				              	
				foreach ($producto->preciotallacolor as $talCol) {
              	
					if($talCol->cantidad > 0) // que haya disp
					{
					
						$talla = Talla::model()->findByPk($talCol->talla_id);
	
						if(in_array($talla->id, $valores)){	// no hace nada para que no se repita el valor			
						}
						else{
							echo "<div id=".$talla->id." style='cursor: pointer' class='tallass' title='talla'>".$talla->valor."</div>"; 
							array_push($valores, $talla->id);
						}
						
						/*
						<a href="#" title="tallas"> <img  src="http://placehold.it/40x40"/></a>
		              	<a href="#" title="tallas"> <img  src="http://placehold.it/40x40"/></a>
		              	<a href="#" title="tallas"> <img  src="http://placehold.it/40x40"/></a>
		              	<a href="#" title="tallas"> <img  src="http://placehold.it/40x40"/></a>
						* */
					}
   				}
              	?>         	     	
              </div>
            </div>
          </div>
          <div class="margin_top">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#detalles">Detalles</a></li>
              <li><a href="#Envio">Envio</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="detalles">
                <div class="clearfix">
                  <h4><?php
                  	
                  	if($producto->proveedor==1)
						echo "Aldo"; 
						
					if($producto->proveedor==2)
						echo "Desigual";
					
					if($producto->proveedor==3)
						echo "Accessorize";
					
					if($producto->proveedor==4)
						echo "SuiteBlanco";
					
					if($producto->proveedor==5)
						echo "Mango";
					
					if($producto->proveedor==6 || $producto->proveedor==0)
						echo "Otro proveedor"; 
					 
					 ?></h4>
                  <p>Grandes Marcas 1 tienda.</p>
                  <!-- <p><a href="#">Ver looks de esta marca</a></p>-->
                  <p><strong>Descripción</strong>: <?php echo $producto->descripcion; ?></p> </div>
              </div>
              <div class="tab-pane" id="Envio">Envio</div>
            </div>
          </div>
          <div class="braker_horz_top_1">
           <p> <span class="entypo icon_personaling_medium">&#128197;</span>
              Fecha estimada de entrega: <?php echo date("d/m/Y"); ?> - <?php echo date('d/m/Y', strtotime('+1 week'));  ?>  </p>    
              <hr />
          </div>
        </div>
        <!-- Columna Secundaria OFF --> 
      </div>
    </div>
  </div>
  <div class="braker_horz_top_1">
    <h3>Looks recomendados con este producto</h3>
    <div id="myCarousel" class="carousel slide"> 
      
      <!-- Carousel items -->
      <div class="carousel-inner">
        <div class="active item">
          <div class="row">
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_2.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_3.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
          </div>
        </div>
        <div class="item">
          <div class="row">
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_2.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_3.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
          </div>
        </div>
      </div>
      <!-- Carousel nav --> 
      <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a> </div>
  </div>
</div>

<!-- /container -->
<?php 

//$cs = Yii::app()->getClientScript();
//$cs->registerScript("unodos","$('.imagen_principal').zoom()",CClientScript::POS_READY);

?>
 
<script>
$(document).ready(function(){

var source = $('#principal').attr("src");
var imgZ = source.replace(".","_orig.");
$('.imagen_principal').zoom({url: imgZ});

	$(".imagen_principal").hover(function(){
		var source = $('#principal').attr("src");
		
		var imgZ = source.replace(".","_orig.");
		$('.imagen_principal').css('display','block').zoom({url: imgZ});
	});
	
   $(".miniaturas_listado_click").click(function(){
     	var image = $("#principal");
     	var thumbnail = $(this).attr("src");
     	
     	// primero cargo la imagen del zoom y aseguro que al momento de hacer el cambio de imagen principal esté listo el zoom
     	var source = thumbnail;	
		var imgZ = source.replace(".","_orig.");
     	$('.imagen_principal').css('display','block').zoom({url: imgZ});
          
        // cambio de la principal  	
     	$("#principal").fadeOut("slow",function(){
     		$("#principal").attr("src", thumbnail);
     	});

      	$("#principal").fadeIn("slow",function(){});

   });

   	$(".coloress").click(function(ev){ // Click en alguno de los colores -> cambia las tallas disponibles para el color
   		ev.preventDefault();
   		//alert($(this).attr("id"));
   		
   		// para quitar el active en caso de que ya alguno estuviera seleccionado
   		$("#vCo").find("div").siblings().removeClass('active');
   		
   		var dataString = $(this).attr("id");
     	var prod = $("#producto").attr("value");

     	$(this).removeClass('coloress');
  		$(this).addClass('coloress active'); // añado la clase active al seleccionado
  		   
     	$.ajax({
	        type: "post",
	        url: "../tallas", // action Tallas de Producto
	        data: { 'idTalla':dataString , 'idProd':prod}, 
	        dataType:"json",
	        success: function (data) {
	        	
		        if(data.status == 'ok')
		        {
		        	//alert(data.datos);
					var cont="";
					$.each(data.datos,function(clave,valor) {
					  	//0 -> id, 1 -> valor
					  	cont = cont + "<div onclick='a("+valor[0]+")' id='"+valor[0]+"' style='cursor: pointer' class='tallass' title='talla'>"+valor[1]+"</div>";
					  	
					});
					//alert(cont); 
					
					$("#vTa").fadeOut("slow",function(){
			     		$("#vTa").html(cont); // cambiando el div
			     	});
			
			      	$("#vTa").fadeIn("slow",function(){});
							   
					
					// ahora cambiar las imagenes a las del color 
					
						var zona="";
						var thumbs="";
						var contador=0;
						
					// luego muestro	
						$.each(data.imagenes,function(clave,valor) {
						  	//0 -> url | 1 -> orden | 2 -> id imagen
						  	
						  	// conseguir cual es el menor en el orden para determinar el color 	
						  	if( contador == 0) {
						  		var Url = "<?php echo Yii::app()->baseUrl; ?>" + valor[0];
						  		zona="<img id='principal' src='"+Url+"' alt'producto'>";
						  		contador++;
						  	}
						  	
						  	var base = "<?php echo Yii::app()->baseUrl; ?>";						  	
						  	thumbs = thumbs + "<img onclick='minis("+valor[2]+")' width='90' height='90' id='thumb"+valor[2]+"' class='miniaturas_listado_click' src='"+base + valor[0]+"' alt='Imagen' style='cursor: pointer' >";
						  	
						  	objImage = new Image();
						  	var source = '/site'+valor[0];
						  	var imgZ = source.replace(".","_orig.");
						  //	alert(imgZ);			
							objImage.src = imgZ;
							
										  	
						});
						
						//alert(thumbs); 		   
						
						// cambiando la imagen principal :@
						$(".imagen_principal").fadeOut("10",function(){
							$(".imagen_principal").html(zona);
							
								var source = $('#principal').attr("src");
								var imgZ = source.replace(".","_orig.");
								$('.imagen_principal').css('display','block').zoom();
							
						});
						  	
						$(".imagen_principal").fadeIn("10",function(){});
						
						
						// cambiando los thumbnails
						$(".imagenes_secundarias").fadeOut("slow",function(){ 
							$(".imagenes_secundarias").html(thumbs); 
						});
						  	
						$(".imagenes_secundarias").fadeIn("slow",function(){});
						
						
							        	
		        }

	       	}//success
	       })
	     
   		
   	});   
   

   	$(".tallass").click(function(ev){ // click en tallas -> recarga los colores para esa talla
   		ev.preventDefault();
   		//alert("TALLAS");
   		//alert($(this).attr("id")); 
   		
   		// para quitar el active en caso de que ya alguno estuviera seleccionado
   		$("#vTa").find("div").siblings().removeClass('active');
   		
   		var dataString = $(this).attr("id");
     	var prod = $("#producto").attr("value");
     
     	$(this).removeClass('tallass');
  		$(this).addClass('tallass active'); // añado la clase active al seleccionado
     
     	$.ajax({
	        type: "post",
	        url: "../colores", // action Colores de Producto
	        data: { 'idColor':dataString , 'idProd':prod}, 
	        dataType:"json",
	        success: function (data) {
	        	
		        if(data.status == 'ok')
		        {
		        	//alert(data.datos);
					var cont="";
					$.each(data.datos,function(clave,valor) {
					  	//0 -> id, 1 -> valor
					  	cont = cont + "<div onclick='b("+valor[0]+")' id='"+valor[0]+"' style='cursor: pointer' class='coloress' title='"+valor[1]+"'><img src='/site/images/colores/"+valor[2]+"'></div>";
					  	
					});
					//alert(cont); 
					
					$("#vCo").fadeOut("slow",function(){
			     		$("#vCo").html(cont); // cambiando el div
			     	});
			
			      	$("#vCo").fadeIn("slow",function(){});
					
					//$("#vTa").html(cont);
							        	
		        }
	       	}//success
	       })
   		
   	}); // tallas
   	 
      
}); // ready

	$(".imagen_principal").hover(function(){
		var source = $('#principal').attr("src");
		var imgZ = source.replace(".","_orig.");
		$('.imagen_principal').zoom({url: imgZ});			
	});
	
	/*	
	$(".imagen_principal").live({
		hover: function() {
	   		var source = $('#principal').attr("src");
			var imgZ = source.replace(".","_orig.");
			$('.imagen_principal').zoom({url: imgZ});			
		}
	});
	*/
	
	function minis(idImagen){		
		var thumbnail = $('#thumb'+idImagen).attr("src");
		//alert(thumbnail);
	    
	    // primero cargo la imagen del zoom y aseguro que al momento de hacer el cambio de imagen principal esté listo el zoom
	    var source = thumbnail;	
		var imgZ = source.replace(".","_orig.");
	   	$('.imagen_principal').zoom({url: imgZ});

		 // cambio de la principal  	 
	     $("#principal").fadeOut("slow",function(){
	     	$("#principal").attr("src", thumbnail);
	     });
	
	     $("#principal").fadeIn("slow",function(){});
	}
   
   function a(id){ // seleccion de talla

			$("#vTa").find("div").siblings().removeClass('active');
			
			$("#vTa").find("div#"+id+".tallass").removeClass("tallass");
			$("#vTa").find("div#"+id).addClass("tallass active");
   }
   
   function b(id){ // seleccion de color
   	
   			$("#vCo").find("div").siblings().removeClass('active');	
   		
   			$("#vCo").find("div#"+id+".coloress").removeClass("coloress");
			$("#vCo").find("div#"+id).addClass("coloress active");   		
   }
   
   function c(){ // comprobar quienes están seleccionados
   		
   		var talla = $("#vTa").find(".tallass.active").attr("id");
   		var color = $("#vCo").find(".coloress.active").attr("id");
   		var producto = $("#producto").attr("value");
   		
   		// llamada ajax para el controlador de bolsa
 		  
 		if(talla==undefined && color==undefined) // ninguno
 		{
 			alert("Seleccione talla y color para poder añadir.");
 		}
 		
 		if(talla==undefined && color!=undefined) // falta talla
 		{
 			alert("Seleccione la talla para poder añadir a la bolsa.");
 		}
 		
 		if(talla!=undefined && color==undefined) // falta color
 		{
 			alert("Seleccione el color para poder añadir a la bolsa.");
 		}   
 		   
 		if(talla!=undefined && color!=undefined)
 		{
 			
 		$.ajax({
	        type: "post",
	        url: "../../bolsa/agregar", // action Tallas de Producto
	        data: { 'producto':producto, 'talla':talla, 'color':color}, 
	        success: function (data) {
				
				if(data=="ok")
				{
					//alert("redireccionar mañana");
					window.location="../../bolsa/index";
				}
				
				if(data=="no es usuario")
				{
					alert("Debes primero ingresar con tu cuenta de usuario o registrarte");
				}
					
	       	}//success
	       })
 			
 			
 		}// cerro   


   }
   
   	function encantar()
   	{
   		var idProd = $("#producto").attr("value");
   		//alert("id:"+idProd);		
   		
   		$.ajax({
	        type: "post",
	        url: "../encantar", // action Tallas de Producto
	        data: { 'idProd':idProd}, 
	        success: function (data) {
				
				if(data=="ok")
				{					
					var a = "♥";
					
					//$("#meEncanta").removeClass("btn-link");
					$("#meEncanta").addClass("btn-link-active");
					$("span#like").text(a);
					
				}
				
				if(data=="no")
				{
					alert("Debes ingresar con tu cuenta de usuario o registrarte antes de dar 'Me Encanta' a un producto");
					//window.location="../../user/login";
				}
				
				if(data=="borrado")
				{
					var a = "♡";
					
					//alert("borrando");
					
					$("#meEncanta").removeClass("btn-link-active");
					$("span#like").text(a);
					
				}
					
	       	}//success
	       })
   		
   		
   	}
   
   
</script>
