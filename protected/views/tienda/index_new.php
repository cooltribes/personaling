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
			if(isset(Yii::app()->session['f_cat']))
						echo CHtml::hiddenField('cathid',Yii::app()->session['f_cat']);
					else {
						echo CHtml::hiddenField('cathid',0);
				} 	
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
		              		<a class="hijo" value="'.$hijo->id.'" href="#" >
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
	  					<span id="color_titulo"> <img src="<?php echo Yii::app()->baseUrl."/images/colores/allcolors.png";?>" alt="Color" width="44">		
	  					</span><b class="caret caretthumbs"></b>
	  				</a>
					<ul class="dropdown-menu dropdown-colors thumbnails ">
						
					<?php 
					if(isset(Yii::app()->session['f_color']))
						echo CHtml::hiddenField('colorhid',Yii::app()->session['f_color']);
					else {
						echo CHtml::hiddenField('colorhid',0);
					}
					foreach($colores as $color){
						echo '<li class="colors"><a href="#" value="'.$color->id.'" title="'.$color->valor.'" class="scolor"><img width="44" src="'.Yii::app()->baseUrl ."/images/colores/". $color->path_image.'"/></a></li>';
						
					}  
						echo '<li class="colors"><a href="#" value="0" class="scolor" title="Todos" ><img width="44" src="'.Yii::app()->baseUrl.'/images/colores/allcolors.png" /></a></li>';
					?>        			          			          			          			          				          				   	          				          				          				          			  				          			                			         			            			      			              																
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
							if(isset(Yii::app()->session['p_index'])){
								echo CHtml::hiddenField('preciohid',Yii::app()->session['p_index']);
								}
							else {
								echo CHtml::hiddenField('preciohid',5);
								}

							echo'<li><a class="precio" href="#" id="0">Hasta '.Yii::app()->numberFormatter->formatCurrency($rangos[0]["max"], 'Bs').' ('.$rangos[0]['count'].')</a></li>';
							echo'<li><a class="precio" href="#" id="1">De '.Yii::app()->numberFormatter->formatCurrency($rangos[1]["min"], '').' a '
							.Yii::app()->numberFormatter->formatCurrency($rangos[1]["max"], 'Bs').' ('.$rangos[1]['count'].')</a></li>';
							echo'<li><a class="precio" href="#" id="2">De '.Yii::app()->numberFormatter->formatCurrency($rangos[2]["min"], '').' a '
							.Yii::app()->numberFormatter->formatCurrency($rangos[2]["max"], 'Bs').' ('.$rangos[2]['count'].')</a></li>';
							echo'<li><a class="precio" href="#" id="3">Más de '.Yii::app()->numberFormatter->formatCurrency($rangos[3]["min"], 'Bs').' ('.$rangos[3]['count'].')</a></li>';
							echo'<li><a class="precio" href="#" id="5">Todos los precios</a></li>';
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
							if(isset(Yii::app()->session['f_marca']))
								echo CHtml::hiddenField('marcahid',Yii::app()->session['f_marca']);
							else {
								echo CHtml::hiddenField('marcahid',0);
							}
							foreach($marcas as $marca){
								echo'<li><a class="marca" value='.$marca->id.' href="#">'.$marca->nombre.'</a></li>';
								 
							}
							echo CHtml::hiddenField('texthid','');
						?>
						<li><a class="marca" value="0" href="#">Todas las marcas</a></li>											
					</ul>  	
				</div>	
			</li>			
			<li class="item itemInput">
				<div class="contenedorInput">
					<input type="text" class="" placeholder="Buscar" id="text_search"> 
					<button class="btn btn-danger btn-buscar" id="btn_search" type="button"><i class="icon-search"></i></button>	
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


 <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

	<?php $this->endWidget(); ?>



<!-- PRODUCTOS OFF -->
<script>
		$(".precio").click(function() { 
            	
            	$('#precio_titulo').html($(this).html());
            	$('#preciohid').val($(this).attr('id'));
            	//$('#catalogo').remove(); 
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	refresh();
           
            	
              	
		});
       
         $(".marca").click(function() { 
            	
            	$('#marca_titulo').html($(this).html());
            	$('#marcahid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val('');  
            	refresh();
            

		});  
		
		$(".scolor").click(function() { 
            	
            	$('#color_titulo').html($(this).html());
            	$('#colorhid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	refresh();

		});  
		
		$(".hijo").click(function() { 
            	

            	$('#cathid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	refresh();

		});
		
		$("#btn_search").click(function() { 
            	

               	$('#catalogo').remove();
               	$('#cathid').val('0');
               	$('#colorhid').val('0');
               	$('#marcahid').val('0');
               	$('#preciohid').val('5');
               	$('#texthid').val($('#text_search').val()   );
            	$('#tienda_productos').html(''); 
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

  

 $("#catalogo").infinitescroll("destroy");
 //$("#catalogo").infinitescroll = null;
    	var datosRefresh = $('#preciohid, #colorhid, #marcahid, #cathid, #texthid').serialize();
  
 	

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
						//$("#catalogo").unbind("scroll");
						//$("#catalogo").unbind("smartscroll");
						
						//return false;
						

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