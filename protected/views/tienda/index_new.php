<?php 
	$this->breadcrumbs=array(
	'Tienda',
	);
?>

<!-- BAR ON -->
<section class="bard_tienda">

	 	<ul class="nav unstyled">
  			<li class="item">Filtrar:</li>
  		<?php 
  			if(isset(Yii::app()->session['f_padre']))
						echo CHtml::hiddenField('padrehid',Yii::app()->session['f_padre']);
					else {
						echo CHtml::hiddenField('padrehid',0);
				}
  			
  			
			if(isset(Yii::app()->session['f_cat']))
						echo CHtml::hiddenField('cathid',Yii::app()->session['f_cat']);
					else {
						echo CHtml::hiddenField('cathid',0);
				} 
			$i=0;	
  			foreach($categorias as $padre){
  				echo '<li class="itemThumbnails tienda_iconos">
		  			<img id="'.$padre->nombre.'" class="img-categoria padre" style="cursor:pointer" title="'.$padre->nombre.'" value="'.$padre->id.'" src="'.$padre->urlImagen.'">			  			
	  				<div class="dropdown">
		  				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  					<b class="caret caretthumbs"></b>	
		  				</a>
		  				<div class="dropdown-menu">
						<ul class="thumbnails ">';
						foreach($padre->subcategorias as $hijo){
							
							echo '<li class=""> 
			              		<a class="hijo" name="'.$padre->nombre.'" value="'.$hijo->id.'" href="#" >
			              			<img src="'.$hijo->urlImagen.'" width="60">
				              		<div class="caption">
				                  		<p>'.$hijo->nombre.'</p>
					                </div>
			              		</a>                	
		              			</li>';
							
						}
						echo '</ul>
						<a name="'.$padre->nombre.'" href="#" class="todos allhijos" value="'.strtoupper($padre->id).'">&nbsp';
						switch (strtoupper($padre->nombre)) {
							case 'ROPA':
								echo "TODA LA ".strtoupper($padre->nombre);
								break;
							
							default:
								echo "TODOS LOS ".strtoupper($padre->nombre);								
								break;
						}
						echo '</a>
					</div>   				
  			</li>';
				$i++;
				if($i>=3){
					break;
				}
  			}
  		
  		?>
  		

  			
  			
  			<li class="itemThumbnails tienda_iconos itemcolor">
  				<div class="dropdown">
	  				<a href="#" class="dropdown-toggle" data-toggle="dropdown" class="color_b">
	  					Color: &nbsp
	  					<span id="color_titulo"> <img src="<?php echo Yii::app()->baseUrl."/images/colores/allcolors.png";?>" alt="Color" width="44"/>		
	  					</span><b class="caret caretthumbs"></b>
	  				</a>
	  				<div class="dropdown-menu dropdown-colors">
						<ul class=" thumbnails ">
							
						<?php 
						if(isset(Yii::app()->session['f_color']))
							echo CHtml::hiddenField('colorhid',Yii::app()->session['f_color']);
						else {
							echo CHtml::hiddenField('colorhid',0);
						}
						foreach($colores as $color){
							echo '<li class="colors"><a href="#" value="'.$color->id.'" title="'.$color->valor.'" class="scolor"><img width="44" src="'.Yii::app()->baseUrl ."/images/colores/". $color->path_image.'"/></a></li>';
							
						}  
							
						?>        			          			          			          			          				          				   	          				          				          				          			  				          			                			         			            			      			              																
						</ul>  
						<a href="#" value="0" class="todos scolor" >TODOS LOS COLORES</a>
					</div>
				</div>
  			</li>  					  			
			<li class="item">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
						<div class="dropinput" >
								<span id="precio_titulo">Por precio</span>
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

							echo'<li><a class="precio" href="#" id="0">Hasta '.number_format($rangos[0]["max"],0,",",".").' Bs <span class="color12">('.$rangos[0]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="1">De '.number_format($rangos[1]["min"],0,",",".").' a '
							.number_format($rangos[1]["max"],0,",",".").' Bs <span class="color12">('.$rangos[1]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="2">De '.number_format($rangos[2]["min"],0,",",".").' a '
							.number_format($rangos[2]["max"],0,",",".").' Bs <span class="color12">('.$rangos[2]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="3">Más de '.number_format($rangos[3]["min"],0,",",".").' Bs <span class="color12">('.$rangos[3]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="5">Todos los precios</a></li>';
					?>		
					</ul>  
				</div>	
			</li>
			<li class="item">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<div class="dropinput">
							<span id="marca_titulo" >Por marca</span>
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
			<li class="item">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
						<div class="dropdown100Chic" >
								<span id="100chic" name="1" >100% chic</span>
							<small> 
								<b class="caret"></b>
							</small>
						</div>
					</a>
					<ul class="dropdown-menu" >
						<?php
						if(isset(Yii::app()->session['100chic']))
								echo CHtml::hiddenField('chic_hid','1');
							else {
								echo CHtml::hiddenField('chic_hid','0');
							}
						foreach($marcas as $marca){
								if($marca->is_100chic){
									
										echo'<li><a class="100chic" value='.$marca->id.' href="#">'.$marca->nombre.'</a></li>';
								}
								
							}	
						?>
					</ul>  
				</div>			
			</li>
			<li class="item itemInput">
				<div class="contenedorInput">
					<input type="text" class="input-medium" placeholder="Buscar" id="text_search"> 
					<button class="btn btn-danger btn-buscar" id="btn_search" type="button"><i class="icon-search"></i></button>	
				</div>
			</li>	
		</ul>	 

</section>
<div class="row ">
<?php	echo CHtml::hiddenField('resethid',0);?>
	<div class="offset10 span2 margin_bottom_small margin_top_small_minus">
		<a href="" class="btn btn-block" id="reset">Limpiar Filtros</a>
	</div>
</div>
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
            	
            	var titulo;
            	titulo=$(this).html();
            	if(titulo.length>13){
            		titulo=titulo.substring(0,10);
            		titulo=titulo+'...';
            	}
            	$('#chic_hid').val('0');
            	$('#marca_titulo').html(titulo);
            	
            	$('#marcahid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	
            	refresh();
            

		});
		
		$(".100chic").click(function() { 
            	
            	          	
            	$('#marcahid').val($(this).attr('value'));
            	$('#chic_hid').val('1');
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val('');  
            	refresh();
            

		});  
		
		$(".scolor").click(function() { 
            	
            	
            	$('#colorhid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	if($('#colorhid').val()==0)
            		$('#color_titulo').html('<img src="<?php echo Yii::app()->baseUrl."/images/colores/allcolors.png";?>" alt="Color" width="44"/>');
            	else
            		$('#color_titulo').html($(this).html());
            	$('#text_search').val(''); 
            	refresh();

		});  
		
		$("#100chic").click(function() { 
				$('#chic_hid').val('1');
				refresh();
			});
		
		$(".hijo").click(function() { 
            	

            	$(".hijo").css('outline','none');
            	$(this).css('outline','solid 2px #6c1b4f');            	
            	$('.padre').css('outline','none');
            	$('#'+$(this).attr('name')).css('outline','solid 2px #6c1b4f');
            	$('#cathid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	refresh();
            	

		});
		
		$(".padre").click(function() { 
            	
				$(".hijo").css('outline','none');
            	$(".padre").css('outline','none');
            	$(this).css('outline','solid 2px #6c1b4f');
            	$('#padrehid').val($(this).attr('value'));
            	$('#cathid').val('0');
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	refresh();
 
		});
		 
		$(".allhijos").click(function() { 
            	
				$(".hijo").css('outline','none');
            	$(".padre").css('outline','none');
            	$('#padrehid').val($(this).attr('value'));
            	$('#cathid').val('0');
            	$('#'+$(this).attr('name')).css('outline','solid 2px #6c1b4f');
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	refresh();

		});
		
		
		$("#btn_search").click(function() { 
            	
			if($('#text_search').val().length>2){
               	$('#catalogo').remove();
               	$('#cathid').val('0');
               	$('#colorhid').val('0');
               	$('#marcahid').val('0');
               	$('#preciohid').val('5');
               	$('#texthid').val($('#text_search').val()   );
            	$('#tienda_productos').html(''); 
            	refresh();
           }

		});
		
		$("#reset").click(function() { 
            	

               	$('#catalogo').remove();
               	$('#resethid').val('1');
            	$('#tienda_productos').html(''); 
            	refresh();

		});
		
		
		$('#text_search').keyup(function(e){
		    if(e.keyCode == 13)
		    {
		        if($(this).val().length>2){
		    		$('#catalogo').remove();
	               	$('#cathid').val('0');
	               	$('#colorhid').val('0');
	               	$('#marcahid').val('0');
	               	$('#preciohid').val('5');
	               	$('#texthid').val($('#text_search').val()   );
	            	$('#tienda_productos').html(''); 
	            	refresh();
		    		
		    	}
		    	
		    }
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
    	var datosRefresh = $('#preciohid, #colorhid, #marcahid, #cathid, #texthid, #padrehid, #resethid ,#chic_hid').serialize();
  


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
 
