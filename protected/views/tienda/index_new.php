<?php #echo Yii::app()->session['outlet'];
PC::debug('Execute Time (start view):'.(microtime(true)-$time_start), 'debug,time');
$seo = SeoStatic::model()->findByAttributes(array('name'=>'Tienda'));
if(isset($seo)){
    $this->pageTitle = $seo->title;
    Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
	
	Yii::app()->clientScript->registerMetaTag($seo->title, null, null, array('property' => 'og:title'), null); 
	Yii::app()->clientScript->registerMetaTag($seo->description, null, null, array('property' => 'og:description'), null);
}
else{
	Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST']."/tienda-ropa-personalizada", null, null, array('property' => 'og:title'), null); 
	Yii::app()->clientScript->registerMetaTag('La primera shopping experience con las mejores marcas de ropa y complementos.', null, null, array('property' => 'og:description'), null);
}
Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'], null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'], null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url .'images/icono_preview.jpg', null, null, array('property' => 'og:image'), null);


?>





    
    

 

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
        $this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'Tienda Personalizada'));

?>
<?php $stopSales = false; ?>
<?php if ($stopSales): ?>
	<!-- MODAL TEMPORAL DE SUSPENCION DE VETNAS  ON-->
	<div id="ModalSuspencion" class="modal fade in"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	  </div>   
	<!-- MODAL TEMPORAL DE SUSPENCION DE VETNAS  OFF-->
<?php endif; ?>
<div class="navbar navbar-fixed-top mobilefilters" id="mobilefilters">

		<div class="container">
			
				<div class="mobileOptions">
					
					<div class="moLeft">
						<input type="text" class="input-medium text_search" placeholder="<?php echo Yii::t('contentForm','Search');?>" id="text_search" maxlength="50" >
					</div>
					<div class="moRight">
						<div id="mobFiltrar">
							Filtrar ››
						</div>	
							
					</div>
				</div>
			
			</div>

</div>
<?php 	PC::debug('Execute Time (start filter):'.(microtime(true)-$time_start), 'debug,time'); ?>
<div class="navbar navbar-fixed-top" id="mobilefilters-expanded">

	<div class="container">
		<div id="accordion" class="hide">
		<?php foreach($categorias as $padre): ?>
            <h3><?php echo $padre->nombre; ?><span id='summ<?php echo $padre->nombre; ?>' class='summ summCat'></span><h3/><div class='paraFiltrar'>
            <?php foreach($padre->subcategorias as $hijo): ?>
                <a class='hijo' name='<?php echo $padre->nombre; ?>' value='<?php echo $hijo->id; ?>'><?php $hijo->nombre; ?></a><br/>
            <?php endforeach; ?>
            <a name="<?php echo $padre->nombre; ?>" href="#" class="todos allhijos" value="<?php echo strtoupper($padre->id); ?>">&nbsp
            <?php
            switch (strtoupper($padre->nombre)) {
                case 'ROPA':
                    echo Yii::t('contentForm','All the')." ".$padre->nombre;
                    break;
                default:
                    echo Yii::t('contentForm','All the1')." ".$padre->nombre;
                    break;
            }
            ?>
            </a></div>
        <?php endforeach; ?>
        <?php
        /*foreach($categorias as $padre){
				echo "<h3>".$padre->nombre."<span id='summ".$padre->nombre."' class='summ summCat'></span><h3/><div class='paraFiltrar'>";
				foreach($padre->subcategorias as $hijo){
					echo "<a class='hijo' name='".$padre->nombre."' value='".$hijo->id."'>".$hijo->nombre."</a><br/>";
				}
				echo '<a name="'.$padre->nombre.'" href="#" class="todos allhijos" value="'.strtoupper($padre->id).'">&nbsp';
						switch (strtoupper($padre->nombre)) {
							case 'ROPA':
								echo Yii::t('contentForm','All the')." ".$padre->nombre;
								break;
							
							default:
								echo Yii::t('contentForm','All the1')." ".$padre->nombre;							
								break;
						}
						echo '</a></div>';
		}*/
        ?>
        <h3><?php echo Yii::t('contentForm','Color'); ?><span id='summColor' class='summ'></span></h3><div><div class='paraFiltrar'>
        <?php foreach($colores as $color): ?>
            <a value="<?php echo $color->id; ?>" title="<?php echo $color->valor; ?>" class="scolor"><?php echo $color->valor; ?></a></br>
        <?php endforeach; ?>
        <a href="#" value="0" class="todos scolor" ><?php echo Yii::t('contentForm','All colors'); ?></a></div></div>
        <h3><?php echo Yii::t('contentForm','By price'); ?> <span id='summPrecio' class='summ'></span></h3> <div class='paraFiltrar'>
        <a class="precio"  id="0">Hasta <?php echo number_format($rangos[0]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym'); ?>
            <span class="color4">(<?php echo $rangos[0]['count']; ?>)</span>
        </a></br>
        <a class="precio"  id="1">De <?php echo number_format($rangos[1]["min"],0,",",".").' a '.number_format($rangos[1]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym');?>
            <span class="color4">(<?php echo $rangos[1]['count']; ?>)</span>
        </a></br>
        <a class="precio"  id="2">De <?php echo number_format($rangos[2]["min"],0,",",".").' a '.number_format($rangos[2]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym'); ?>
            <span class="color4">(<?php echo $rangos[2]['count']; ?>)</span>
        </a></br>
        <a class="precio"  id="3">Más de <?php echo number_format($rangos[3]["min"],0,",",".").' '.Yii::t('contentForm', 'currSym'); ?>
            <span class="color4">(<?php echo $rangos[3]['count']; ?>)</span>
        </a></br>
        <a class="precio"  id="5"><?php echo Yii::t('contentForm','All price'); ?></a>

        </div>

		<?php

        /*echo "<h3>".Yii::t('contentForm','Color')."<span id='summColor' class='summ'></span></h3><div><div class='paraFiltrar'>";
		
			foreach($colores as $color){ 
				echo '<a value="'.$color->id.'" title="'.$color->valor.'" class="scolor">'.$color->valor.'</a></br>'; 
			}
							
				echo '<a href="#" value="0" class="todos scolor" >'.Yii::t('contentForm','All colors').'</a></div></div>';
        echo "<h3>".Yii::t('contentForm','By price')." <span id='summPrecio' class='summ'></span></h3> <div class='paraFiltrar'>";
		
			echo'<a class="precio"  id="0">Hasta '.number_format($rangos[0]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[0]['count'].')</span></a></br>';
			echo'<a class="precio"  id="1">De '.number_format($rangos[1]["min"],0,",",".").' a '
				.number_format($rangos[1]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[1]['count'].')</span></a></br>';
			echo'<a class="precio"  id="2">De '.number_format($rangos[2]["min"],0,",",".").' a '
				.number_format($rangos[2]["max"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[2]['count'].')</span></a></br>';
			echo'<a class="precio"  id="3">Más de '.number_format($rangos[3]["min"],0,",",".").' '.Yii::t('contentForm', 'currSym').' <span class="color4">('.$rangos[3]['count'].')</span></a></br>';
			echo'<a class="precio"  id="5">'.Yii::t('contentForm','All price').'</a>';
							
				echo "</div>";	*/	?>


<?php 	PC::debug('Execute Time (by brand):'.(microtime(true)-$time_start), 'debug,time'); ?>
			<h3><?php echo Yii::t('contentForm','By brand') ?><span id='summMarca' class='summ'></span></h3>
            <div><div class='paraFiltrar'>
<?php
            foreach($marcas as $marca):
                   $cien = "not cien";
								/*$cien="not_cien";
								if($marca->is_100chic){
									$cien="cien";
								}

								echo'<a class="marca '.$cien.'" value='.$marca->id.' >'.$marca->nombre.'</a><br/>';
								*/
			?>
				<a class="marca <?php echo $cien; ?>" href="#" value='<?php echo $marca->id; ?>'><?php echo $marca->nombre; ?></a><br/>
<?php
			endforeach;

			//	echo '<a class="marca" value="0" href="#">'.Yii::t('contentForm','All Brands').'</a></div></div>';
			  
			  ?>
                <a class="marca" value="0" href="#"><?php echo Yii::t('contentForm','All Brands'); ?></a></div></div>
            <?php 	PC::debug('Execute Time (by brand):'.(microtime(true)-$time_start), 'debug,time'); ?>
			   <h3 class="mobReset" id="reset"><?php echo Yii::t('contentForm','Clean Filters');?></h3>
		</div>
	</div>
</div>     
<?php if(Yii::app()->user->isGuest){	 ?> 
	<div class="navbar navbar-fixed-top register-mob-bar"  >
		<div>
			<div class="rmb-title">Bienvenido a Personaling</div>
			<a class="rmb-white" href="<?php echo Yii::app()->baseUrl; ?>/inicio-personaling">Accede</a>
			 
			<a class="rmb-black" href="<?php echo Yii::app()->baseUrl; ?>/registro-personaling">¡Registrate!</a>			
		
				
		</div>
		
	</div>
<?php }?>



<?php 	PC::debug('Execute Time (deskfilters):'.(microtime(true)-$time_start), 'debug,time'); ?>
<div id="deskfilters">
<div id="banner100chic" style=" display:none; " class="margin_top ">
	<div class="margin_bottom">
		<img src="<?php echo Yii::app()->baseUrl; ?>/images/<?php echo Yii::app()->language; ?>/especial/080banner.jpg" alt="080">
	</div>
	<div class="">
		<a href="#" onclick="unchic()" ><span class="entypo">&larr; </span>	<?php echo Yii::t('contentForm','Back to shop');?></a>
	</div>
</div>
<!-- BAR ON -->

<?php if(Yii::app()->user->isGuest&&Yii::app()->params['registerGift']):?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tabSlideOut.v1.3.js', CClientScript::POS_HEAD); ?>
	<?php $script = "
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

	    	$( '#accordion' ).accordion({
	    		collapsible:true,
	    		active:false,
	    		icons: { 'header': 'ui-icon-carat-1-e', 'activeHeader': 'ui-icon-carat-1-n' },
	    		autoHeight: false,
	   			navigation: true
	    	});
	";
	?>
	<?php Yii::app()->clientScript->registerScript("tabslideout",$script,CClientScript::POS_READY); ?>	
	<div class="slide-out-div">
	            <div class="handle" href="#"><div class="rotate">Gana un bono de 5 <?php echo Yii::t('contentForm','currSym');?>&nbsp;&nbsp;&nbsp;<img src="<?php echo Yii::app()->baseUrl; ?>/images/backtopWhite.png" width="20px" height="20px"> </div></div>
	           <div class="row-fluid margin_top_medium">
	           		<div class="span12">
	           				Al registrarte y completar tu perfil.<br/><br/>
	           				Disfruta ya de la primera Shopping Experience única<br/>y repetible.<br/>
	           				<a class="span8 offset2 margin_top_small btn btn-danger regYa" href="<?php echo Yii::app()->baseUrl;?>/user/registration">¡Registrate YA!</a>
	           		</div>
	           	
	           </div>
	</div>
<?php endif; ?>
<?php 	PC::debug('Execute Time (end filter):'.(microtime(true)-$time_start), 'debug,time'); ?>

<section class="bard_tienda">

	 	<ul class="nav unstyled">
  			<li class="item">	<?php echo Yii::t('contentForm','Filter');?>:</li>
  		<?php 
			echo CHtml::hiddenField('padrehid',isset(Yii::app()->session['f_padre'])?Yii::app()->session['f_padre']:0);
			echo CHtml::hiddenField('cathid',isset(Yii::app()->session['f_cat'])?Yii::app()->session['f_cat']:0);	
			$i=0; 
		    $ruta='/images/'.Yii::app()->language.'/categorias/';			
  			foreach($categorias as $padre){
  				$ruta_padre=Yii::app()->baseUrl .$ruta. $padre->urlImagen;
  				echo '<li class="itemThumbnails tienda_iconos">
			  			<img id="'.$padre->nombre.'" class="img-categoria padre" style="cursor:pointer" title="'.$padre->nombre.'" value="'.$padre->id.'" src="'.$ruta_padre.'">			  			
		  				<div class="dropdown">
			  				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  					<b class="caret caretthumbs"></b>	
			  				</a>
			  				<div class="dropdown-menu">
							<ul class="thumbnails ">';
							foreach($padre->subcategorias as $hijo){
								$ruta_hijo=Yii::app()->baseUrl .$ruta. $hijo->urlImagen;
								echo '<li class=""> 
				              		<a class="hijo" name="'.$padre->nombre.'" value="'.$hijo->id.'" href="#" >
				              			<img src="'.$ruta_hijo.'" width="60">
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
  				/*
				$i++;
				if($i>=3){
					break;
				}
				*/
				if(++$i > 2) break;
  			}  		
  		?>
            <?php 	PC::debug('Execute Time (end categorias):'.(microtime(true)-$time_start), 'debug,time'); ?>
  			<li class="itemThumbnails tienda_iconos itemcolor">
  				<div class="dropdown">
	  				<a href="#" class="dropdown-toggle" data-toggle="dropdown" class="color_b">
	  					<?php echo Yii::t('contentForm','Color');?>: &nbsp
	  					<span id="color_titulo"> <img src="<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/allcolors.png";?>" alt="Color" width="44"/>		
	  					</span><b class="caret caretthumbs"></b>
	  				</a>
	  				<div class="dropdown-menu dropdown-colors">
						<ul class=" thumbnails ">
							
						<?php 
						echo CHtml::hiddenField('colorhid',isset(Yii::app()->session['f_color'])?Yii::app()->session['f_color']:0);
						echo CHtml::hiddenField('outlet',isset(Yii::app()->session['outlet'])?Yii::app()->session['outlet']:0);

						foreach($colores as $color)
							echo '<li class="colors"><a href="#" value="'.$color->id.'" title="'.$color->valor.'" class="scolor"><img width="44" src="'.Yii::app()->baseUrl ."/images/".Yii::app()->language."/colores/". $color->path_image.'"/></a></li>';
						?>        			          			          			          			          				          				   	          				          				          				          			  				          			                			         			            			      			              																
						</ul>  
						<a href="#" value="0" class="todos scolor CAPS" ><?php echo Yii::t('contentForm','All colors');?></a>
					</div>
				</div>
  			</li>
            <?php 	PC::debug('Execute Time (end color):'.(microtime(true)-$time_start), 'debug,time'); ?>
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
							echo CHtml::hiddenField('preciohid',isset(Yii::app()->session['p_index'])?Yii::app()->session['p_index']:5);
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
            <?php 	PC::debug('Execute Time (end precio):'.(microtime(true)-$time_start), 'debug,time'); ?>
			<?php if (Yii::app()->params['mostrarMarcas']): ?>
				<li class="item item-marcas">
                            <?php 
                            //Agregar la opcion de Todas las marcas al listado existente
                            $marcasListData = CHtml::listData($marcas, "id" , "nombre");
                            $marcasListData[0] = Yii::t('contentForm','All Brands');

                            
                            $this->widget('bootstrap.widgets.TbSelect2',array(                                    
                                    'asDropDownList' => true,
                                    'name' => 'filtroMarcas',
                                    'data' => $marcasListData,
                                    'value' => 0,
                                    
                                    'htmlOptions' => array(
//                                        'class' => 'span2',
                                    ),
                                    'options' => array(
                                        'formatNoMatches' => "",
                                        'placeholder'=> Yii::t('contentForm','By brand'),
                                        'containerCssClass'=> "container-marcas",
                                        'dropdownCssClass'=> "drop-down-menu dropdown-marcas",

                                        ),
                                    )
                                );
                            
                            //Campo hidden para guardar la marca seleccionada
                            echo CHtml::hiddenField('marcahid',0);

                            ?>
						<?php $mostrarMarcaTitulo = false; ?>                           
						<?php if ($mostrarMarcaTitulo):   ?>                         
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
						<?php endif; ?>

				</li>
			<?php else: ?>

				<?php echo CHtml::hiddenField('marcahid',isset(Yii::app()->session['f_marca'])?Yii::app()->session['f_marca']:0); ?>
				
			<?php endif; ?>
            <?php 	PC::debug('Execute Time (end marcas):'.(microtime(true)-$time_start), 'debug,time'); ?>
	
	<li class="item" id="li_chic">

				<div class="dropdown" id="dd080" >
					<a href="#" class="dropdown-toggle a080" data-toggle="dropdown" >
						<div class="dropdown080" >
								<span id="100chic" name="1" ><img src='<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/especial/080botonnegro.jpg";?>'/></span>
							<?php 
/*
							if(isset(Yii::app()->session['100chic']))
								echo CHtml::hiddenField('chic_hid','1');
							else {
								echo CHtml::hiddenField('chic_hid','0');
							}*/
							?>

							<?php echo CHtml::hiddenField('chic_hid',isset(Yii::app()->session['100chic'])?'1':'0'); ?>

							
							<!--<small> 
								<b class="caret"></b>
							</small>-->
						</div>
					</a>
	</li>
<?php $params_100chic = false; ?>
<?php if ($params_100chic): ?>
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
			</li> 
<?php else: ?>
			<li class="item itemInput">
				<div class="contenedorInput">
					<input type="text" class="input-medium text_search" placeholder="<?php echo Yii::t('contentForm','Search');?>" id="deskText" maxlength="50" > 
					<button class="btn btn-danger btn-buscar" id="btn_search" type="button"><i class="icon-search"></i></button>	
				</div>
			</li>	
		</ul>
<?php endif; ?>	 

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
<?php PC::debug('Execute Time (start produto):'.(microtime(true)-$time_start), 'debug,time'); ?>
<!-- PRODUCTOS ON -->

<div  class="tienda_productos">
      <div class="row" id="tienda_productos">
			<?php
					$this->renderPartial('_datos',array(
							'prods'=>$dataProvider,
							'pages'=>$pages,
						),false,false);
			?>																						

    </div>
</div>

<?php 
/*
Yii::app()->clientScript->registerScript('list_productos', "
						$.get('".Yii::app()->createUrl('tienda/store')."',{'page':1},function(data){
							$('#tienda_productos').append(data.div);
						},'json')
						"); 
*/
?>

<?php PC::debug('Execute Time (after renderPartial):'.(microtime(true)-$time_start), 'debug,time'); ?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
				'id'=>'myModal',
				'htmlOptions'=>array(
						'class'=>'modal_grande hide fade',
						'tabindex'=>'-1',
						'role'=>'dialog',
						'aria-labelleby'=>'myModalLabel',
						'aria-hidden'=>'true'
						)
				)
			); 
?>
<?php $this->endWidget(); ?>
<a href="#" id="gotop" class="go-top" title="<?php echo Yii::t('contentForm','Back to top'); ?>"><img src="<?php echo Yii::app()->baseUrl."/images/backtop.png"; ?>" /></a>
<?php 
//Mostrar un Modal si no ha completado el perfil y solo si es mujer
$completarPerfil = false;
if (!Yii::app()->user->isGuest){
	$user = User::model()->findByPk(Yii::app()->user->id);
	$completarPerfil = $user->profile->sex == Profile::G_FEMENINO && ($user->status_register == User::STATUS_REGISTER_NEW || 
            $user->status_register == User::STATUS_REGISTER_TIPO);
	if ($completarPerfil){
       if($user->status_register == User::STATUS_REGISTER_NEW) $url =  Yii::app()->createUrl("/user/profile/tutipo");
       elseif($user->status_register == User::STATUS_REGISTER_TIPO) $url =  Yii::app()->createUrl("/user/profile/tuestilo");
?>

<?php
	$this->beginWidget('bootstrap.widgets.TbModal', array(
	    'id' => 'modalCompletarPerfil',
	        ), array(
	    'class' => 'modal fade hide',
	    'tabindex' => "-1",
	    'role' => "dialog",
	    'aria-labelledby' => "myModalLabel",
	    'aria-hidden' => "true", 
	));
?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>¡Tu perfil es tu ADN Personaling!</h3>
        </div>

        <div class="modal-body">
            <div class="row-fluid">
                <div class="span10 offset1">
                    <h4>                 
                        Recuerda rellenar los datos de tu perfil y
                        disfruta de un maravilloso mundo de looks adaptados para ti.
                    </h4>                
                </div>
                
            </div>
            <div class="row-fluid margin_top_medium margin_bottom_medium">
                <div class="span12 text_align_center">
                    <?php echo TbHtml::link("Rellenar Perfil", $url,
                        array(
                        "class" => "btn btn-danger",
                        )); ?>                    
                </div>

            </div>
            
            
        </div>

                         

<?php $this->endWidget(); ?>


<?php }
}
?>


<!-- PRODUCTOS OFF -->
<?php PC::debug('Execute Time (end produto):'.(microtime(true)-$time_start), 'debug,time'); ?>
<script>

<?php /*Mostrar el Modal*/
if (!Yii::app()->user->isGuest && $completarPerfil){
 ?>
   $('#modalCompletarPerfil').modal('show')  
     
<?php } ?>
		
    $(".precio").click(function() {  
            
            var html=$(this).html();
            $('#precio_titulo').html(html);  
            if(html.length>45){
                if(html.length>50)
                    $('#precio_titulo').css('font-size','12px');

                var arr=html.split('<span');
                arr=arr[0].split('De');
                html=arr[1];
                
                $('#precio_titulo').html(arr[1]);
         
                 
            }else{
                 $('#precio_titulo').css('font-size','14px');
            }
            $('#precio_titulo').html(html);    
            

            $('#preciohid').val($(this).attr('id'));
            $('#summPrecio').html('');
                        //$('#catalogo').remove(); 
            //$('#tienda_productos').html(''); 
            $('.text_search').val(''); 
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
        $('.text_search').val(''); 
        $('#chic_hid').val('0');
        preRefresh();


    });

    //Evento change del select para filtros de Marcas
    $("#filtroMarcas").change(function(){
        var valor = $(this).val();
        
        //asignar al campo hidden el valor de la marca seleccionada
        $('#marcahid').val(valor);        
        //limpiar el campo de busqueda por texto
        $('.text_search').val('');
        //No 100chic
        $('#chic_hid').val('0');
        
        //Si es una marca cien o no_cien ?¿
        //Mostrar el banner
        if($(this).hasClass("cien")){
            
            $('#chic_hid').val('1');
            $('#banner100chic').fadeIn(3000);
            
        }else if($(this).hasClass("not_cien")){
            
            $('#chic_hid').val('0');
            $('#banner100chic').fadeOut(3000);
            
        }        
        
        //Hacer la consulta
        preRefresh();

//        console.log(valor);
    });  

    $(".100chic").click(function() { 

    $('#marcahid').val($(this).attr('value'));
    $('#chic_hid').val('1');
    //$('#catalogo').remove();
    //$('#tienda_productos').html(''); 
    $('.text_search').val('');  

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
            $('#color_titulo').html('<img src="<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/allcolors.png";?>" alt="Color" width="44"/>');
            $('#summColor').html('');
    }

    else{
            $('#color_titulo').html($(this).html());
            $('#summColor').html($(this).attr('title'));
    }

    $('.text_search').val('');
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
                    $('#100chic').html("<img src='<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/especial/080botonnegro.jpg";?>'/>");
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
    $('.text_search').val(''); 
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
    $('.text_search').val(''); 
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
    $('.text_search').val(''); 
    preRefresh();

    });

    $("body").click(function() { 
    if($( "#dd080" ).hasClass( "open" )&&!$('#chic_hid').val()){
            $('#100chic').html("<img src='<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/especial/080botonnegro.jpg";?>'/>");       	
    }

    });

    $(".dropdown080").click(function() { 
                white080();
        });
		
		
    $("#btn_search").click(function() { 


            if($('#deskText').val().length>2){
    $('#catalogo').remove();
    $('#cathid').val('0');
    $('#colorhid').val('0');
    $('#marcahid').val('0');
    $('#preciohid').val('5');
    $('#texthid').val($('#deskText').val()   );
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

    $(".mobReset").click(function() { 


    $('.summ').html('');

    });


    $('.text_search').keyup(function(e){
		    if(e.keyCode == 13)
		    {
		        if($(this).val().length>2){
		    		$('#catalogo').remove();
	               	$('#cathid').val('0');
	               	$('#colorhid').val('0');
	               	$('#marcahid').val('0');
	               	$('#preciohid').val('5');
	               	$('#texthid').val($(this).val());
	               	if($(this).attr('id')!='deskTest')
	               			$('#deskTest').val('');
	            	$('#tienda_productos').html(''); 
	            	preRefresh();
		    		
		    	}
		    	
		    }
		});
		
	
	
</script>
 
<script>

function white080(){
	$('#100chic').html("<img src='<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/especial/080botonblanco.jpg";?>'/>");
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
            	if($('#accordion').hasClass('hide')){
            		$('#accordion').removeClass('hide');
            	}else{
            		$('#accordion').addClass('hide');
            	}

			});
	
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
