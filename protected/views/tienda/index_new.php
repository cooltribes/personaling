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
  			echo CHtml::hiddenField('padrehid',0); 	
			echo CHtml::hiddenField('hijohid',0); 	
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
						
					<?php 
					echo CHtml::hiddenField('colorhid',0); 
					foreach($colores as $color){
						echo '<li class="colors"><a href="#" value="'.$color->id.'" class="scolor"><img width="44" src="'.Yii::app()->baseUrl ."/images/colores/". $color->path_image.'"/></a></li>';
						
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
							echo CHtml::hiddenField('preciohid',5); 
							echo'<li><a class="precio" href="#" id="0">Hasta '.Yii::app()->numberFormatter->formatCurrency($rangos[0]["max"], 'Bs').' ('.$rangos[0]['count'].')</a></li>';
							echo'<li><a class="precio" href="#" id="1">De '.Yii::app()->numberFormatter->formatCurrency($rangos[1]["min"], '').' a '
							.Yii::app()->numberFormatter->formatCurrency($rangos[1]["max"], 'Bs').' ('.$rangos[1]['count'].')</a></li>';
							echo'<li><a class="precio" href="#" id="2">De '.Yii::app()->numberFormatter->formatCurrency($rangos[2]["min"], '').' a '
							.Yii::app()->numberFormatter->formatCurrency($rangos[2]["max"], 'Bs').' ('.$rangos[2]['count'].')</a></li>';
								echo'<li><a class="precio" href="#" id="3">Más de '.Yii::app()->numberFormatter->formatCurrency($rangos[3]["min"], 'Bs').' ('.$rangos[3]['count'].')</a></li>';
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
							echo CHtml::hiddenField('marcahid',0); 	
							foreach($marcas as $marca){
								echo'<li><a class="marca" value='.$marca->id.' href="#">'.$marca->nombre.'</a></li>';
								 
							}
						?>
						<li><a class="marca" value="0" href="#">Todos</a></li>											
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

<div  class="tienda_productos">
      <div class="row" id="tienda_productos">

			 
			<?php
					$this->renderPartial('_datos',array(
					'prods'=>$dataProvider,'pages'=>$pages),false,false);   
				
				
			
			?>																						

    </div>
</div>






<!-- PRODUCTOS OFF -->
<script>
		$(".precio").click(function() { 
            	
            	$('#precio_titulo').html($(this).html());
            	$('#preciohid').val($(this).attr('id'));
           
            	
              	
		});
       
         $(".marca").click(function() { 
            	
            	$('#marca_titulo').html($(this).html());
            	$('#marcahid').val($(this).attr('value'));
            

		});  
		
		$(".scolor").click(function() { 
            	
            	$('#color_titulo').html($(this).html());
            	$('#colorhid').val($(this).attr('value'));
            	$('#catalogo').html(''); 
            	refresh();

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
   	
function refresh(reset)
{
	//alert($('.check_ocasiones').serialize());
	//alert($('.check_ocasiones').length) 
    var datosRefresh = $('#preciohid, #colorhid, #marcahid').serialize();

    
    //console.log(datosRefresh);
    if(reset){
        datosRefresh += '&reset=true';
    }
    
    <?php echo CHtml::ajax(array(
            'url'=>array('tienda/index'),
            'data'=> "js:datosRefresh",
            //'data' => array( 'ocasiones' => 55 ),
            'type'=>'post',
            'dataType'=>'json',
            'global' => 'false',
            'beforeSend' => 'function(){
                        $("body").addClass("aplicacion-cargando");

            }',
            'complete' => 'function(){
                        $("body").removeClass("aplicacion-cargando");
                        
                    }',
            'success'=>"function(data)
            {
                           
                if (data.status == 'failure')
                {
                    $('#dialogColor div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogColor div.divForForm form').submit(addColor);
                    alert('FAIL');
                }
                else
                {
           
                   $('#tienda_productos').html(data.div);
             
		
                }
                
                
 
            } ",
            ))?>;
    return false; 
 
}
</script>