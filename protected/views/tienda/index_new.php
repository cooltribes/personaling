<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.tabSlideOut.v1.3.js" type="text/javascript"></script>
 <script type="text/javascript">
    $(function(){
        $('.slide-out-div').tabSlideOut({
            tabHandle: '.handle',                     //class of the element that will become your tab
          //  pathToTabImage: '<?php echo Yii::app()->baseUrl; ?>/images/icon_twitter_2.png', //path to the image for the tab //Optionally can be set using css
            imageHeight: '210px',                     //height of tab image           //Optionally can be set using css
           // imageWidth: '40px',                       //width of tab image            //Optionally can be set using css
            tabLocation: 'right',                      //side of screen where tab lives, top, right, bottom, or left
            speed: 300,                               //speed of animation
            action: 'click',                          //options: 'click' or 'hover', action to trigger animation
            topPos: '244px',                          //position from the top/ use if tabLocation is left or right
            leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
            fixedPosition: false                      //options: true makes it stick(fixed position) on scroll
        });

    });
 	 $(function() {
    	$( "#accordion" ).accordion({
    		collapsible:true,
    		active:false,
    		icons: { "header": "ui-icon-carat-1-e", "activeHeader": "ui-icon-carat-1-n" },
    		autoHeight: false,
   			navigation: true
    	});
  	});

    </script>

    
    

 

<?php
if(isset($seo)){
	$this->pageTitle = $seo->title;
	Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}

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
<div class="navbar navbar-fixed-top" style="background-color:black; padding:0 20px 0 20px" id="mobilefilters">

		<div class="container">
			<!--<a class="btn btn-navbar" data-toggle="collapse" data-target="#collapse_0"></a>
				<a href="/develop/" class="brand">Personaling</a>
				<div class="nav-collapse" id="collapse_0">
					<ul class="pull-right nav" id="yw0">
						<li><a href="/develop/looks-personalizados">Looks</a></li>
						<li id="tienda_menu" class="active"><a href="/develop/tienda-ropa-personalizada">Tienda</a></li>
						<li id="magazine"><a target="_blank" href="http://personaling.com/magazine">Magazine</a></li>
						<li id="ingresa"><a href="/develop/inicio-personaling">Accede</a></li>
						<li><a class=" btn-danger btn" href="/develop/registro-personaling">Regístrate</a></li>
					</ul>
				</div>-->
				<div style="width:100%; height:40px; background-color:black; line-height: 40px; vertical-align: middle">
					<!--<div style="width:18%; float:left">
						<div style="background-color: white; width:50px; height: 30px; margin-top: 10px">
							db
						</div> 
					</div>-->
					<div style="width:50%; float:left">
						<input type="text" class="input-medium" placeholder="<?php echo Yii::t('contentForm','Search');?>" id="text_search" maxlength="50" >
					</div>
					<div style="width:50%; float:left; text-align: right; ">
						<div id="mobFiltrar" style="border: solid #FFF 1px; width: 90%; float: right; height: 28px; margin: 10px 0 10px 0; line-height: 30px; color: white; text-align: center; ">
							Filtrar ››
						</div>	
							
					</div>
				</div>
			
			</div>

	</div>
<div class="navbar navbar-fixed-top hide" id="mobilefilters-expanded">

	<div class="container">
		<div id="accordion">
		<?php foreach($categorias as $padre){
				echo "<h3>".$padre->nombre."<span id='summ".$padre->nombre."' class='summ summCat'></span><h3/><div class='paraFiltrar'>";
				foreach($padre->subcategorias as $hijo){
					echo "<a class='hijo' name='".$padre->nombre."' value='".$hijo->id."'>".$hijo->nombre."</a><br/>";
				}
				echo "</div>";
		}?>
			  
		<?php echo "<h3>".Yii::t('contentForm','Color')."<span id='summColor' class='summ'></span></h3><div class='paraFiltrar'>"; 
		
			foreach($colores as $color){ 
				echo '<a value="'.$color->id.'" title="'.$color->valor.'" class="scolor">'.$color->valor.'</a></br>'; 
			}
							
				echo "</div>";		?>
				
		<?php echo "<h3>".Yii::t('contentForm','By price')." <span id='summPrecio' class='summ'></span></h3> <div class='paraFiltrar'>"; 
		
			echo'<a class="precio"  id="0">Hasta '.number_format($rangos[0]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[0]['count'].')</span></a></br>';
			echo'<a class="precio"  id="1">De '.number_format($rangos[1]["min"],0,",",".").' a '
				.number_format($rangos[1]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[1]['count'].')</span></a></br>';
			echo'<a class="precio"  id="2">De '.number_format($rangos[2]["min"],0,",",".").' a '
				.number_format($rangos[2]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[2]['count'].')</span></a></br>';
			echo'<a class="precio"  id="3">Más de '.number_format($rangos[3]["min"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[3]['count'].')</span></a></br>';
			echo'<a class="precio"  id="5">'.Yii::t('contentForm','All price').'</a>';
							
				echo "</div>";		?>
		
		

			<h3><?php echo Yii::t('contentForm','By brand')."<span id='summMarca' class='summ'></span>";?></h3>

			  <?php
			  echo "<div class='paraFiltrar'>";
			  foreach($marcas as $marca){
								$cien="not_cien";
								if($marca->is_100chic){
									$cien="cien";
								}
								
								echo'<a class="marca '.$cien.'" value='.$marca->id.' >'.$marca->nombre.'</a><br/>';
								 
							}
				echo "</div>"
			  
			  ?>
			   
		</div>
	</div>
</div>     
	 
<div class="navbar navbar-fixed-top register-mob-bar"  >
	<div>
		<div class="rmb-title">Bienvenido a Personaling</div>
		<a class="rmb-white" href="<?php echo Yii::app()->baseUrl; ?>/inicio-personaling">Accede</a>
		 
		<a class="rmb-black" href="<?php echo Yii::app()->baseUrl; ?>/registro-personaling">¡Registrate!</a>			
	
			
	</div>
	
</div>




<div id="deskfilters">
<div id="banner100chic" style=" display:none; " class="margin_top ">
	<div class="margin_bottom">
		<img src="<?php echo Yii::app()->baseUrl; ?>/images/080banner.jpg" alt="Titina Penzini">
	</div>
	<div class="">
		<a href="#" onclick="unchic()" ><span class="entypo">&larr; </span>	<?php echo Yii::t('contentForm','Back to shop');?></a>
	</div>
</div>
<!-- BAR ON -->
<?php if(Yii::app()->user->isGuest&&Yii::app()->params['registerGift']) {?>
<div class="slide-out-div">
            <div class="handle" href="#"><div class="rotate">Gana un bono de 5 EUR&nbsp;&nbsp;&nbsp;<img src="<?php echo Yii::app()->baseUrl; ?>/images/backtopWhite.png" width="20px" height="20px"> </div></div>
           <div class="row-fluid margin_top_medium">
           		<div class="span12">
           				Al registrarte y completar tu perfil.<br/><br/>
           				Disfruta ya de la primera Shopping Experience única<br/>y repetible.<br/>
           				<a class="span8 offset2 margin_top_small btn btn-danger regYa" href="<?php echo Yii::app()->baseUrl;?>/user/registration">¡Registrate YA!</a>
           		</div>
           	
           </div>
</div><?php }?>

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

						// reviso outlet para ver si se incluye en el filtro
						if(isset(Yii::app()->session['outlet']))
							echo CHtml::hiddenField('outlet',Yii::app()->session['outlet']);
						else {
							echo CHtml::hiddenField('outlet','false');
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
				
			} ?>
			
			
			
	


		
	
	<li class="item" id="li_chic">

				<div class="dropdown" id="dd080" >
					<a href="#" class="dropdown-toggle a080" data-toggle="dropdown" >
						<div class="dropdown080" >
								<span id="100chic" name="1" ><img src='<?php echo Yii::app()->baseUrl."/images/080botonnegro.jpg";?>'/></span>
							<?php if(isset(Yii::app()->session['100chic']))
								echo CHtml::hiddenField('chic_hid','1');
							else {
								echo CHtml::hiddenField('chic_hid','0');
							}?>
							
							<!--<small> 
								<b class="caret"></b>
							</small>-->
						</div>
					</a>
	</li>
		<!--			<ul class="dropdown-menu" >
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
					<input type="text" class="input-medium" placeholder="<?php echo Yii::t('contentForm','Search');?>" id="text_search" maxlength="50" > 
					<button class="btn btn-danger btn-buscar" id="btn_search" type="button"><i class="icon-search"></i></button>	
				</div>
			</li>	
		</ul>	 

</section>
<div class="row ">
<?php	echo CHtml::hiddenField('texthid','');
		echo CHtml::hiddenField('resethid',0);?>
	<div class="offset10 span2 margin_bottom_small margin_top_small_minus">
		<a href="" class="btn btn-block" id="reset"><?php echo Yii::t('contentForm','Clean Filters');?></a>
	</div>
</div>
</div>


<div></div>



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
            	if($('#preciohid').val()!='0'){
            		$('#summPrecio').html($(this).html());
            	}else{
            		$('#summPrecio').html('');
            	}
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
            	if($('#preciohid').val()!='0'){
            			$('#summMarca').html(titulo);
            	}else{
            		$('#summMarca').html('');
            	}
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
                if($('#colorhid').val()==0){
                	$('#color_titulo').html('<img src="<?php echo Yii::app()->baseUrl."/images/colores/allcolors.png";?>" alt="Color" width="44"/>');
                	$('#summColor').html('');
                }
                    
                else{
                	$('#color_titulo').html($(this).html());
                	$('#summColor').html($(this).attr('title'));
                }
                  
                $('#text_search').val('');
                preRefresh()

		});  
		
		$("#100chic").click(function() { 
				$('#chic_hid').val('1');
				$('#banner100chic').fadeIn(3000);
				preRefresh();
			});
		$("#100chic").bind( "touchstart", function(e){
			$('#chic_hid').val('1');
			$('#banner100chic').fadeIn(3000);
			preRefresh();
		} );	
			
		function unchic(){
				$('#chic_hid').val('0');
				$('#banner100chic').fadeOut(3000);
				preRefresh();
				$('#100chic').html("<img src='<?php echo Yii::app()->baseUrl."/images/080botonnegro.jpg";?>'/>");
		}		
		
		$(".hijo").click(function() { 
            	

            	$(".hijo").css('outline','none');
            	$(this).css('outline','solid 2px #ffd660');            	
            	$('.padre').css('outline','none');
            	$('#'+$(this).attr('name')).css('outline','solid 2px #ffd660');
            	$('#cathid').val($(this).attr('value'));
            	$('.summCat').html('');
            	if($('#cathid').val()!='0')
            		$('#summ'+$(this).attr('name')).html($(this).html());
            	else
            		$('#summ'+$(this).attr('name')).html('');
            	
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
		
		$("body").click(function() { 
         	if($( "#dd080" ).hasClass( "open" )&&!$('#chic_hid').val()){
         		$('#100chic').html("<img src='<?php echo Yii::app()->baseUrl."/images/080botonnegro.jpg";?>'/>");       	
         	}

		});
		
		$(".dropdown080").click(function() { 
			white080();
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

function white080(){
	$('#100chic').html("<img src='<?php echo Yii::app()->baseUrl."/images/080botonblanco.jpg";?>'/>");
}
function encantar(id)
   	{
            
   		var idProd = id;
   		//alert("id:"+idProd);		
   		
   		$.ajax({
	        type: "post",
                dataType: "json",
	        url: "<?php echo $this->createUrl("producto/encantar"); ?>", // action Tallas de Producto
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
	mixpanel.track("Filtros");
	$('#accordion').addClass('hide');
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

	var datosRefresh = $('#preciohid, #colorhid, #marcahid, #cathid, #texthid, #padrehid, #resethid, #chic_hid, #outlet').serialize();
  


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
           		/*console.log(data.div);	
           		alert(data.status);*/
           		
           		
                if (data.status == 'failure')
                {
                    $('#dialogColor div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogColor div.divForForm form').submit(addColor);
                    

                } else
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
			$("#mobFiltrar").click(function() { 
            	if($('#mobilefilters-expanded').hasClass('hide')){
            		$('#mobilefilters-expanded').removeClass('hide');
            	}else{
            		$('#mobilefilters-expanded').addClass('hide');
            	}

			});
			//$('#accordion').addClass('hide');
			$('.handle').show();
			$('.slide-out-div').show();
			<?php
			if(isset(Yii::app()->session['080'])){
				echo "$('#chic_hid').val('1');	$('#banner100chic').fadeIn(3000);	preRefresh(); white080();";
				unset (Yii::app()->session['080']);
			}
			?>
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
