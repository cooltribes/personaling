<?php 
	$this->breadcrumbs=array(
	'Tienda',
	);
?>

<!-- BAR ON -->
<section class="bard_tienda">

	 	<ul class="nav unstyled">
  			<li class="item">Tienda de prendas:</li>
  		<?php 
  			foreach($categorias as $padre){
  				echo '<li class="itemThumbnails tienda_iconos">
  				<div class="dropdown">
	  				<a href="#" lass="dropdown-toggle" data-toggle="dropdown">
	  					<img class="img-categoria" title="'.$padre->nombre.'" src="'.$padre->urlImagen.'">	
	  					<b class="caret caretthumbs"></b>	
	  				</a>
					<ul class="dropdown-menu thumbnails ">';
					foreach($padre->subcategorias as $hijo){
						
						echo '<li class=""> 
		              		<a href="#" >
		              			<img src="'.$hijo->urlImagen.'" width="60">
		              		</a>                	
		              		<div class="caption">
		                  		<p>'.$hijo->nombre.'</p>
			                </div>
	              			</li>';
						
					}
					
					echo '</ul> 
				</div>   				
  			</li>';
				
  			}
  		
  		?>
  		

  			
  			
  			<li class="itemThumbnails tienda_iconos">
  				<div class="dropdown">
	  				<a href="#" class="dropdown-toggle" data-toggle="dropdown" class="color_b">
	  					Color:
	  					<span id="color_titulo"> <img src="/images/colores/C_Multicolor.jpg" alt="Color" width="44">		
	  					</span><b class="caret caretthumbs"></b>
	  				</a>
					<ul class="dropdown-menu dropdown-colors thumbnails ">
						
					<?php foreach($colores as $color){
						echo '<li class="colors"> 
		              		
		              			'.
		              			
		              			CHtml::ajaxLink (
			              			CHtml::image(Yii::app()->baseUrl ."/images/colores/". $color->path_image, "".$color->valor,array('class'=>'color','id'=>$color->id,'name'=>'color','width'=>'44','style'=>'cursor:pointer')),
	                              	CController::createUrl('tienda/upa'), 
                             		array('update' => '#catalogo'),array('class'=>'scolor'))
		              			.'
		              		               	
	              		</li>';
					}  ?>        			          			          			          			          				          				   	          				          				          				          			  				          			                			         			            			      			              																
					</ul>  
				</div>
  			</li>  					  			
			<li class="item">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
						<div class="dropinput" >
							<span id="precio_titulo">Filtrar por precio</span>
							<small> 
								<b class="caret"></b>
							</small>
						</div>
					</a>
					<ul class="dropdown-menu" >
						
					<?php
						
							echo'<li><a class="precio" href="#">Hasta '.Yii::app()->numberFormatter->formatCurrency($rangos[0]["max"], 'Bs').'</a></li>';
							echo'<li><a class="precio" href="#">De '.Yii::app()->numberFormatter->formatCurrency($rangos[1]["min"], '').' a '
							.Yii::app()->numberFormatter->formatCurrency($rangos[1]["max"], 'Bs').'</a></li>';
							echo'<li><a class="precio" href="#">De '.Yii::app()->numberFormatter->formatCurrency($rangos[2]["min"], '').' a '
							.Yii::app()->numberFormatter->formatCurrency($rangos[2]["max"], 'Bs').'</a></li>';
								echo'<li><a class="precio" href="#">Más de '.Yii::app()->numberFormatter->formatCurrency($rangos[3]["min"], 'Bs').'</a></li>';
					?>															
					</ul>  
				</div>	
			</li>

			<li class="item">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<div class="dropinput">
							<span id="marca_titulo" >Filtrar por marca</span>
							<small>
								<b class="caret"></b>
							</small>
						</div>						
					</a>
					<ul class="dropdown-menu">	
						
						<?php
							foreach($marcas as $marca){
								echo'<li><a class="marca" href="#">'.$marca->nombre.'</a></li>';
							}
						?>
						<li><a class="marca" href="#">Todos</a></li>											
					</ul>  	
				</div>	
			</li>			
			<li class="item itemInput">
				<div class="contenedorInput">
					<input type="text" class="" placeholder="Buscar"> 
					<button class="btn btn-danger btn-buscar" type="button"><i class="icon-search"></i></button>	
				</div>
			</li>	
		</ul>	 

</section>

<!-- BAR OFF -->
<!-- PRODUCTOS ON -->

<div class="margin_top tienda_productos">
      <div class="row">
		<div class="items" id="catalogo">
			
			<?php
					$this->renderPartial('_datos',array(
					'prods'=>$dataProvider,'pages'=>$pages,'data'=>$data));   
				
			
			
			
			?>																						
		</div>
    </div>
</div>
<!-- PRODUCTOS OFF -->
<script>
		$(".precio").click(function() { 
            	
            	$('#precio_titulo').html($(this).html());
              	
		});
       
         $(".marca").click(function() { 
            	
            	$('#marca_titulo').html($(this).html());

		});  
		
		$(".scolor").click(function() { 
            	
            	$('#color_titulo').html($(this).html());
              	
		});                       
	
	
</script>

<script>


function encantar(id)
   	{
            
   		var idProd = id;
   		//alert("id:"+idProd);		
   		
   		$.ajax({
	        type: "post",
                dataType: "json",
	        url: "../producto/encantar", // action Tallas de Producto
	        data: { 'idProd':idProd}, 
	        success: function (data) {
				if(data.mensaje === "ok")
				{					
					var a = "♥";					
					//$("#meEncanta").removeClass("btn-link");
					$("a#like"+id).addClass("like-active");
					$("a#like"+id).text(a);
					
				}
				
				if(data === "no")
				{
					alert("Debes ingresar con tu cuenta de usuario o registrarte antes de dar Me Encanta a un producto");
					//window.location="../../user/login";
				}
				
				if(data.mensaje === "borrado")
				{
					var a = "♡";
					
					//alert("borrando");
					
					$("a#like"+id).removeClass("like-active");
					//$("#meEncanta").addClass("btn-link-active");
					$("a#like"+id).text(a);

				}
					
	       	}//success
	       })
   		
   		
   	}  
   	
   	
</script>
