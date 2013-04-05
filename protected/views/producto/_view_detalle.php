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
              <button href="#" title="Me encanta" class="btn-link"><span class="entypo icon_personaling_big">&#9825;</span></button>
              <button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="left" data-toggle="popover" id="share" class="btn-link"  data-original-title="Compartelo" href="#" title=""> <span class="entypo icon_personaling_big">&#59157;</span> </button>
            </div>
          </div>
          <div class="row">
          	<?php
             
            	echo "<div class='span6 imagen_principal'> 
            			<!-- FOTO principal ON -->";
            	
            	$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
	
			foreach ($ima as $img){
					
				if($img->orden==1)
				{
					echo CHtml::image(Yii::app()->baseUrl . $img->url, "producto", array('id'=>'principal'));
					echo "<!-- FOTO principal OFF -->";
	          		echo "</div>";	
					
					echo " <div class='span2'> 
            				<!-- FOTOS Secundarias ON -->
            				<div class='imagenes_secundarias'> 
            				";
				
					//imprimiendo igual la primera en thumbnail
					$pri = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
					echo CHtml::image(Yii::app()->baseUrl . $pri->url, "Imagen ", array("width" => "90", "height" => "90",'value'=>$pri->id,'class'=>'miniaturas_listado_click'));					
							
				}
				
				if($img->orden!=1){
					//luego el resto para completar el scroll					
					echo CHtml::image(Yii::app()->baseUrl . $img->url, "Imagen ", array("width" => "90", "height" => "90", 'value'=>$img->id, 'class'=>'miniaturas_listado_click'));
				}
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
              <div class="btn-group"> <a class="btn btn-danger" ><span class="entypo color3">&#128274;</span></a>
              	<a onclick="c()" id="agregar" title="agregar a la bolsa" class="btn btn-danger"> Añadir a la bolsa </a>
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
							echo "<div id=".$color->id." style='cursor: pointer' class='coloress' title='color'>".$color->valor."</div>"; 
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
                  <p><strong>Bio</strong>: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmoofficia deserunt mollit anim id</p>
                  <p><a href="#">Ver looks de esta marca</a></p>
                  <p><strong>Descripción</strong>: <?php echo $producto->descripcion; ?></p> </div>
              </div>
              <div class="tab-pane" id="Envio">Envio</div>
            </div>
          </div>
          <div class="braker_horz_top_1">
           <p> <span class="entypo icon_personaling_medium">&#128197;</span>
              Fecha estimada de entrega: 00/00/2013 - 00/00/2013  </p>            
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
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="images/look_sample_pequeno_2.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="images/look_sample_pequeno_3.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
          </div>
        </div>
        <div class="item">
          <div class="row">
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="images/look_sample_pequeno_2.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
            <div class="span4"><a href="Look_seleccionado.php" title="Nombre del look"><img src="images/look_sample_pequeno_3.jpg" width="370" height="370" alt="Nombre del Look"></a></div>
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

$('.imagen_principal').css('display','block').zoom();

	$(".imagen_principal").hover(function(){
		var source = $('#principal').attr("src");
		$('.imagen_principal').css('display','block').zoom({url: source});
	});

   $(".miniaturas_listado_click").click(function(){
      
     	var image = $("#principal");
     	var thumbnail = $(this).attr("src");
          	
     	$("#principal").fadeOut("slow",function(){
     		$("#principal").attr("src", thumbnail);
     	});

      	$("#principal").fadeIn("slow",function(){});
      	
      	// cambiando la imagen que se va a hacer zoom
     	var source = thumbnail;
     	$('.imagen_principal').css('display','block').zoom({url: source});
   });
      
      
   	$(".coloress").click(function(ev){ // Click en alguno de los colores -> cambia las tallas disponibles para el color
   		ev.preventDefault();
   		//alert("COLOR");
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
					
					//$("#vTa").html(cont);
							        	
		        }
	       	}//success
	       })
   		
   	});   
   

   	$(".tallass").click(function(ev){
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
					  	cont = cont + "<div onclick='b("+valor[0]+")' id='"+valor[0]+"' style='cursor: pointer' class='coloress' title='color'>"+valor[1]+"</div>";
					  	
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
   	 
      
   });
   
   function a(id){ // seleccion de talla

			$("#vTa").find("div").siblings().removeClass('active');
			
			$("#vTa").find("div#"+id+".tallass").removeClass("tallass");
			$("#vTa").find("div#"+id).addClass("tallass active");
   		//	$("#"+id+".tallass").removeClass("tallass");
  		//	$("#"+id).addClass("tallass active");
		
		// falta si le vuelvo a dar click deseleccione la anterior
   }
   
   function b(id){ // seleccion de color
   	
   			$("#vCo").find("div").siblings().removeClass('active');	
   		
   			$("#vCo").find("div#"+id+".coloress").removeClass("coloress");
			$("#vCo").find("div#"+id).addClass("coloress active");
   			
   			//$("#"+id+".coloress").removeClass("coloress");
  			//$("#"+id).addClass("coloress active");
		
		// falta si le vuelvo a dar click deseleccione la anterior
   		
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
					alert("Debe primero ingresar como usuario");
				}
					
	       	}//success
	       })
 			
 			
 		}// cerro   


   }
   
   
</script>
