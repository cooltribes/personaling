<?php
$this->pageTitle = 'Tienda';
Yii::app()->clientScript->registerMetaTag('Tienda', 'title', null, null, null);
Yii::app()->clientScript->registerMetaTag('La primera shopping experience con las mejores marcas de ropa y complementos.', 'description', null, null, null);
Yii::app()->clientScript->registerMetaTag('personal shopper online, ropa online, moda, tienda de ropa online, marcas de ropa, ropa de mujer, venta de ropa online', 'keywords', null, null, null);
?>
<?php 
	$this->breadcrumbs=array(
	'Tienda',
	);
?>

<!-- MODAL TEMPORAL DE SUSPENCION DE VETNAS  ON-->
<!--   <div id="ModalSuspencion" class="modal fade in"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
      <h3>Disculpa los inconvenientes...</h3>
      <p>Por razones de mantenimiento,<br>
        las compras están temporalmente suspendidas.
      </p>
      <p class="pull-right">¡Volveremos Pronto!</p>
    </div>
    <div class="modal-footer">
      <button type="button" id="cerrarModalSuspencion" class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
  </div>   -->
<!-- MODAL TEMPORAL DE SUSPENCION DE VETNAS  OFF-->

<div id="banner100chic" style=" display:none; " class="margin_top ">
	<div class="margin_bottom">
		<img src="<?php echo Yii::app()->baseUrl; ?>/images/bannerTitina.jpg" alt="Titina Penzini">
	</div>
	<div class="">
		<a href="#" onclick="unchic()" ><span class="entypo">&larr; </span>	<?php echo Yii::t('contentForm','Back to shop');?></a>
	</div>
</div>
<!-- BAR ON -->
<section class="bard_tienda">

	 	<ul class="nav unstyled">
  			<li class="item">	<?php echo Yii::t('contentForm','Filter');?>:</li>
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
						<a name="'.$padre->nombre.'" href="#" class="todos allhijos CAPS" value="'.strtoupper($padre->id).'">&nbsp';
						switch (strtoupper($padre->nombre)) {
							case 'ROPA':
								echo Yii::t('contentForm','All the')." ".strtoupper($padre->nombre);
								break;
							
							default:
								echo Yii::t('contentForm','All the1')." ".strtoupper($padre->nombre);							
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
	  					<?php echo Yii::t('contentForm','Color');?>: &nbsp
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
						<a href="#" value="0" class="todos scolor CAPS" ><?php echo Yii::t('contentForm','All colors');?></a>
					</div>
				</div>
  			</li>  					  			
			<li class="item">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
						<div class="dropinput" >
								<span id="precio_titulo"><?php echo Yii::t('contentForm','By price');?></span>
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

							echo'<li><a class="precio" href="#" id="0">Hasta '.number_format($rangos[0]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color12">('.$rangos[0]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="1">De '.number_format($rangos[1]["min"],0,",",".").' a '
							.number_format($rangos[1]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color12">('.$rangos[1]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="2">De '.number_format($rangos[2]["min"],0,",",".").' a '
							.number_format($rangos[2]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color12">('.$rangos[2]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="3">Más de '.number_format($rangos[3]["min"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color12">('.$rangos[3]['count'].')</span></a></li>';
							echo'<li><a class="precio" href="#" id="5">'.Yii::t('contentForm','All price').'</a></li>';
					?>		
					</ul>  
				</div>	
			</li>

			<?php if (Yii::app()->params['mostrarMarcas']){ ?>
			<li class="item">

				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<div class="dropinput">
							<span id="marca_titulo" ><?php echo Yii::t('contentForm','By brand');?></span>
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
								$cien="not_cien";
								if($marca->is_100chic){
									$cien="cien";
								}
								
								echo'<li><a class="marca '.$cien.'" value='.$marca->id.' href="#">'.$marca->nombre.'</a></li>';
								 
							}
							echo CHtml::hiddenField('texthid','');
						?>
						<li><a class="marca" value="0" href="#"><?php echo Yii::t('contentForm','All Brands');?></a></li>											
					</ul>  	
				</div>	

			</li>
			<?php }else{
				if(isset(Yii::app()->session['f_marca']))
								echo CHtml::hiddenField('marcahid',Yii::app()->session['f_marca']); 
							else {
								echo CHtml::hiddenField('marcahid',0);
							}
				echo CHtml::hiddenField('texthid','');
			} ?>
			<li class="item" id="li_chic">

<!-- 			<li class="item" id="li_chic">
>>>>>>> 6b3c77a4efba5677a5d32cc4c06a0cfd1ce8987a
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
						$chics=0;
						foreach($marcas as $marca){
								if($marca->is_100chic){
									
										echo'<li><a class="100chic" value='.$marca->id.' href="#">'.$marca->nombre.'</a></li>';
										$chics++;
								}
								
							}
						if($chics<1){
							echo "<script>$('#li_chic').hide();</script>";
						}
						?>
					</ul>  
				</div>			
			</li> -->
			<li class="item itemInput">
				<div class="contenedorInput">
					<input type="text" class="input-medium" placeholder="<?php echo Yii::t('contentForm','Search');?>" id="text_search"> 
					<button class="btn btn-danger btn-buscar" id="btn_search" type="button"><i class="icon-search"></i></button>	
				</div>
			</li>	
		</ul>	 

</section>
<div class="row ">
<?php	echo CHtml::hiddenField('resethid',0);?>
	<div class="offset10 span2 margin_bottom_small margin_top_small_minus">
		<a href="" class="btn btn-block" id="reset"><?php echo Yii::t('contentForm','Clean Filters');?></a>
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
<a href="#" id="gotop" class="go-top" title="<?php echo Yii::t('contentForm','Back to top'); ?>"><img src="<?php echo Yii::app()->baseUrl."/images/backtop.png"; ?>" /></a>


<!-- PRODUCTOS OFF -->
<script>

		


		
		
		$(".precio").click(function() { 
            	
            	$('#precio_titulo').html($(this).html());
            	$('#preciohid').val($(this).attr('id'));
            	//$('#catalogo').remove(); 
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	preRefresh();
           
            	 
              	
		});
       
         $(".marca").click(function() { 
            	
            	var titulo;
            	titulo=$(this).html();
            	if(titulo.length>13){
            		titulo=titulo.substring(0,10);
            		titulo=titulo+'...';
            	}
            	$('#marca_titulo').html(titulo);
            	
            	$('#marcahid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	$('#chic_hid').val('0');
            	preRefresh();
            

		});
		
		$(".100chic").click(function() { 
            	            	          	
            	$('#marcahid').val($(this).attr('value'));
            	$('#chic_hid').val('1');
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val('');  

            	$('#banner100chic').fadeIn(3000);
            	preRefresh();
        });  
		
		$(".cien").click(function() { 
            	
            	$('#chic_hid').val('1');
            	$('#banner100chic').fadeIn(3000);
            	
        });  
		
		$(".not_cien").click(function() { 
            	
				
            	$('#chic_hid').val('0');
				$('#banner100chic').fadeOut(3000);
            	
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
            	preRefresh();

		});  
		
		$("#100chic").click(function() { 
				$('#chic_hid').val('1');
				$('#banner100chic').fadeIn(3000);
				preRefresh();
			});
			
		function unchic(){
				$('#chic_hid').val('0');
				$('#banner100chic').fadeOut(3000);
				preRefresh();
		}		
		
		$(".hijo").click(function() { 
            	

            	$(".hijo").css('outline','none');
            	$(this).css('outline','solid 2px #ffd660');            	
            	$('.padre').css('outline','none');
            	$('#'+$(this).attr('name')).css('outline','solid 2px #ffd660');
            	$('#cathid').val($(this).attr('value'));
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	preRefresh();
            	

		});
		
		$(".padre").click(function() { 
            	
				$(".hijo").css('outline','none');
            	$(".padre").css('outline','none');
            	$(this).css('outline','solid 2px #ffd660');
            	$('#padrehid').val($(this).attr('value'));
            	$('#cathid').val('0');
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	preRefresh();
 
		});
		 
		$(".allhijos").click(function() { 
            	
				$(".hijo").css('outline','none');
            	$(".padre").css('outline','none');
            	$('#padrehid').val($(this).attr('value'));
            	$('#cathid').val('0');
            	$('#'+$(this).attr('name')).css('outline','solid 2px #ffd660');
            	//$('#catalogo').remove();
            	//$('#tienda_productos').html(''); 
            	$('#text_search').val(''); 
            	preRefresh();

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
            	preRefresh();
           }

		});
		
		$("#reset").click(function() { 
            	

               	$('#catalogo').remove();
               	$('#resethid').val('1');
            	$('#tienda_productos').html(''); 
            	preRefresh();

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
	            	preRefresh();
		    		
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
   
function preRefresh(){
	try{
		 

		$("#catalogo").infinitescroll("destroy");
	
			refresh();
		}
	catch(e){
		 refresh();
		}
}
   
function refresh(reset)
{

	
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
 
<script>
		$(document).ready(function() {

			// Show or hide the sticky footer button
			$(window).scroll(function() {
				if ($(this).scrollTop() > 200&&$(this).scrollTop()+200<$('#wrapper_footer').offset().top) {
					
					$('.go-top').fadeIn(600);
				} else if ($(this).scrollTop() > 200) 
					
					$('.go-top').fadeIn(600);
				
				 else {
					$('.go-top').fadeOut(600);
				}

			});
			
			// Animate the scroll to top
			$('.go-top').click(function(event) {
				event.preventDefault();
				
				$('html, body').animate({scrollTop: 0}, 300);
			})
		});
	</script>
