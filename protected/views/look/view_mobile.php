<?php
$this->pageTitle=Yii::app()->name . " - " . $model->title;
  Yii::app()->clientScript->registerMetaTag('Personaling - '.$model->title.' - '.$model->getPrecio().' '.Yii::t('contentForm', 'currSym'), null, null, array('property' => 'og:title'), null); // registro del meta para facebook
  Yii::app()->clientScript->registerMetaTag($model->description.' Creado por: '.$model->user->profile->first_name.' '.$model->user->profile->last_name, null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 

  //Metas de Twitter CARD ON

  Yii::app()->clientScript->registerMetaTag('product', 'twitter:card', null, null, null);
  Yii::app()->clientScript->registerMetaTag('@personaling', 'twitter:site', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->title, 'twitter:title', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->description, 'twitter:description', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->getPrecio().' '.Yii::t('contentForm', 'currSym'), 'twitter:data1', null, null, null);
  Yii::app()->clientScript->registerMetaTag('Subtotal', 'twitter:label1', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->user->profile->first_name.' '.$model->user->profile->last_name, 'twitter:data2', null, null, null);  
  Yii::app()->clientScript->registerMetaTag('Creado por', 'twitter:label2', null, null, null);
  Yii::app()->clientScript->registerMetaTag('personaling.com', 'twitter:domain', null, null, null);

  //Metas de Twitter CARD OFF


?>







<div class="container detalle_look_mobile span8" id="carrito_compras">
	
	
	<input id="idLook" type="hidden" value="<?php echo $model->id ?>" />
   	<h1><?php echo $model->title; ?></h1>
   	<p class="margin_top_small_minus"><?php echo Yii::t('contentForm','By'); ?>: <a href="<?php echo $model->user->profile->getUrl();?>" title="casual"><b><?php echo $model->user->profile->first_name." ".$model->user->profile->last_name; ?></b></a></p>
	<div class="row-fluid">
            <?php Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->createUrl('look/getImage',array('id'=>$model->id,'w'=>770,'h'=>770)), null, null, array('property' => 'og:image'), null);  // Registro de <meta> para compartir en Facebook
                  //Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->createUrl('look/getImage',array('id'=>$model->id)), 'twitter:image:src', null, null, null); //Registro de meta para Card de Twitter

            ?>
            <div class="span12" ><div class="imagen_principal"><?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$model->id,'w'=>770,'h'=>770)), "Look", array('class'=>'img_1')); ?> </div></div>

   	</div>
   	<div class="span8 no_margin_left ">
	   	<div class="margin_top_xsmall precioslook">
	   		<?php
	                if(!is_null($model->tipoDescuento) && $model->valorDescuento > 0){
	                  ?>
	                  <h4 class="precio pSeparadas">
	                  	
		                  	<span class="leyenda"><?php echo Yii::t('contentForm' , 'Piezas Separadas'); ?></span>
		                  	<span class="monto"><?php echo Yii::t('contentForm', 'currSym').' '.$model->getPrecioProductosDescuento(); ?></span>
		               
	                  </h4>
	                  <h4 class="precio" ><div id="price"><span><?php echo Yii::t('contentForm' , 'Look Completo'); ?></span><?php echo Yii::t('contentForm', 'currSym').' '.$model->getPrecioDescuento(); ?></div></h4>
	                  
	                  <?php
	                }else{
	                  ?>
	                  <h4 class="precio" >
	                  	<span><?php echo Yii::t('contentForm' , 'Subtotal'); ?></span>
	                  	<div id="price">
	                  		<?php echo Yii::t('contentForm', 'currSym').' '.$model->getPrecioDescuento(); ?>
	                  	</div>
	                  	</h4>
	                  
	                  <?php 
	                  
	                  }
	                ?>
	   	</div>
	   	
	   	
	   	
	   	<div>
	   		
	   		
	   		<?php

                // verificar si el look tiene productos de terceros y cambiar el texto del boton de compra
                $button_text = 'Buy';
                if($model->hasProductosExternos()){
                  $button_text = 'Load to shopping cart';
                }

         $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'ajaxButton',
                    'id'=>'btn-compra', 
                    'type'=>'warning',
                    'label'=>Yii::t('contentForm', $button_text),
                    'block'=>'true',
                     //  'size'=> 'large',
                       
                     //Si es invitado enviar los productos a una
                     //URL distinta por ajax
                   'url'=> Yii::app()->user->isGuest ? CController::createUrl('producto/agregarBolsaGuest'):
                         CController::createUrl('bolsa/agregar2'),
             
                    'htmlOptions'=>array('id'=>'buttonGuardar'),
                    'ajaxOptions'=>array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'data'=> "js:$('#producto-form').serialize()",

                            'beforeSend' => "function( request )n
                                 {
                                   
                                   
                                                                      var entro = true;	
                                   if ( $(\"input[name='producto[]']:checked\").length <= 0 ){
                                   		entro = false;
                                        alert('".Yii::t('contentForm' , 'Must select at least one item')."');
                                        return false;
                                   }

                                   $('.tallas').each(function(){
                                           if ($(this).val()==''){

                                               if ($(this).parent().prev('input').prop('checked')){
                                               		entro = false;
                                                		
                                                   $('#alertSizes').show();
                                                   return false;
                                               }
                                           }

                                   });
                                   if (entro){
                                   		if ($('#buttonGuardar').attr('disabled')==true)
                                   			return false;
                                   		$('#buttonGuardar').attr('disabled', true);
								   }else{
                                        return false;
                                    }
                                   
                                 }",


                             'success' => "function( data )
                                  {
                                    console.log(data);
                                    var invitado = ".(Yii::app()->user->isGuest ? "true":"false")."
                                     if(invitado){
                                        agregarBolsaGuest(data);
                                     }else{
                                        
                                         if(data.status == 'ok')
                                        {
                                          ga('ec:addProduct', {
                                            'id': data.id,
                                            'name': data.name,
                                            'category': data.category,
                                            'brand': data.brand,
                                            'variant': data.variant,
                                            'price': data.price,
                                            'quantity': data.quantity,
                                          });
                                          ga('ec:setAction', 'add');
                                          ga('send', 'event', 'UX', 'click', 'add to cart');     // Send data using an event.
                                          window.location='".$this->createUrl('bolsa/index')."';
                                        }                                     
                                    }
                                  }",
                    ),
                ));

                ?>
	   		
	   		
	   		
	   		
	   	</div>
	   	
	   	
	   	
	   	
	   	
	   	
	   	
	   	
		<div class="complete margin_top_small">
			<div class="fifth">
			      <a href="<?php $perfil = $model->user->profile; echo $perfil->getUrl(); ?>" title="perfil" class="url margin_left_xsmall">
				            <?php echo CHtml::image($model->user->getAvatar(),'Avatar',array("width"=>"55", "class"=>"photo  img-circle")); //,"height"=>"270" ?>
				  </a>
		    </div>
		    <div class="fifth4 margin_left_xsmall_minus">
			   
				 <span class="muted"><?php echo Yii::t('contentForm' , 'Look created by'); ?>: </span>
				<h5><a href="<?php echo $perfil->getUrl(); ?>" title="perfil" class="url"><span class="fn"> <?php echo $model->user->profile->first_name.' '.$model->user->profile->last_name; ?></span> </a></h5>
			
			</div>
		
		</div>
		
		<div>
			<?php echo $model->description; ?> 
		</div>
		
			
			
		<div class="marcas">
              
              Marcas en este look:
        
                <?php foreach ($model->getMarcas() as $marca){ ?>
	             
	                  	<?php echo CHtml::image($marca->getImageUrl(true),$marca->nombre, array('width'=>60, 'height'=>60,'title'=>$marca->nombre));
                      ?>
	                           	
                <?php } ?>              
      
              
              
        </div>
			
			<!-- <p class="muted t_small CAPS braker_bottom"><?php echo Yii::t('contentForm' , 'Select the size'); ?> </p> 
	          <p class="muted t_small "><?php echo Yii::t('contentForm' , 'You can buy separate clothes that you like'); ?></p>
	
	          <!-- Productos del look ON -->
	          <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	            'id'=>'producto-form',
	            'enableAjaxValidation'=>false,
	            'type'=>'horizontal',
	        )); ?>
	          <?php echo CHtml::hiddenField('look_id',$model->id); ?>
	          <div class="productos_del_look">
	            <div class="row-fluid">
	              <?php 
	              if($model->productos)
	                foreach ($model->lookhasproducto as $lookhasproducto){
	                  // $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$lookhasproducto->producto_id,'orden'=>'1'));
	                  $image_url = $lookhasproducto->producto->getImageUrl($lookhasproducto->color_id,array('type'=>'thumb'));
	                  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$image_url, null, null, array('property' => 'og:image'), null);  // Registro de <meta> para compartir en Facebook                              
	                  ?>
	                  <div class="span6"> 
	                    
	                    <div class="pull-right">
	                    	   <?php $color_id = $lookhasproducto->color_id; ?>
	                    	<?php 
	                    if ( $lookhasproducto->producto->getCantidad(null,$color_id) > 0 && $lookhasproducto->producto->estado == 0){ 
	                      ?>
	                      <?php echo CHtml::checkBox("producto[]",true,array('onclick'=>'js:updatePrice();','value'=>$lookhasproducto->producto_id.'_'.$color_id)); ?>
	                      <?php } else { ?>
	                      <?php echo CHtml::checkBox("producto[]",false,array('readonly'=>true,'disabled'=>true,'value'=>$lookhasproducto->producto_id.'_'.$color_id)); ?>
	
	                      <?php 
	                    } 
	                    ?>
	                    	
	                    	
	                    </div>
	                    
	                    <a href="pagina_producto.php" title="Nombre del Producto">
	                      <!-- <img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_1.jpg" title="Nombre del producto" class="imagen_producto" />
	                      -->
	                      <?php      
	                      $prod = Producto::model()->findByPk($lookhasproducto->producto_id);
	                      ?>
	
	                      <?php $image = CHtml::image($image_url, "Imagen ", array('class'=>'imagen_producto'));  ?>
	                      <?php echo CHtml::link($image, $prod->getUrl() ); ?>
	                      <?php //$color_id = @LookHasProducto::model()->findByAttributes(array('look_id'=>$model->id,'producto_id'=>$lookhasproducto->producto_id))->color_id ?>
	                   
	                    </a>
	                    
	
	                    <div class="metadata_top">
	                      <?php // echo Chtml::hiddenField("color[]",$color_id); ?>
	                      <?php // echo Chtml::hiddenField("producto[]",$producto->id); ?>
	                      <?php 
	                      //if($lookhasproducto->producto->tipo == 0){
	                        if($lookhasproducto->producto->estado == 0){
	                          echo CHtml::dropDownList('talla'.$lookhasproducto->producto_id.'_'.$color_id,'0',$lookhasproducto->producto->getTallas($color_id),array('onchange'=>'js:updateCantidad(this);','prompt'=>Yii::t('contentForm' , 'Size'),'class'=>'span5 tallas')); 
	                        }else{
	
	                          echo CHtml::dropDownList('talla'.$lookhasproducto->producto_id.'_'.$color_id,'0',array(),array('onchange'=>'js:updateCantidad(this);','prompt'=>Yii::t('contentForm' , 'Size'),'class'=>'span5 tallas')); 
	
	                        }
	                      /*}else{
	                        echo $lookhasproducto->producto->tienda->name;
	                      }*/
	                      ?>
	                    </div>
	                    <div class="metadata_bottom">
	                      <h5><?php echo $lookhasproducto->producto->nombre; ?></h5>
	                      <div class="row-fluid">
	                        <div class="span7"><span> <?php echo Yii::t('contentForm', 'currSym'); ?>
	                        <?php foreach ($lookhasproducto->producto->precios as $precio) {
	                        echo Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento); // precio
	                        }
	
	                        ?>
	
	                        </span></div>
	                        <div class="span5"> <span id="cantidad<?php echo $lookhasproducto->producto_id.'_'.$color_id; ?>">
	                        <?php 
	                        if($lookhasproducto->producto->estado == 0){                        
	
	                        echo $lookhasproducto->producto->getCantidad(null,$color_id);
	
	                        }else{
	
	                        echo "0";
	
	                        }
	
	                        ?> unds.</span></div>
	                      </div>
	                    </div>
	                  </div>
	                  <?php
	                }
	                ?>
	            </div>
	          </div>
	          <?php $this->endWidget(); ?>
	          <!-- Productos del look OFF -->
		
			
			
			
			<?php
	
	         $this->widget('bootstrap.widgets.TbButton', array(
	                    'buttonType'=>'ajaxButton',
	                    'id'=>'btn-compra', 
	                    'type'=>'warning',
	                    'label'=>Yii::t('contentForm', $button_text),
	                    'block'=>'true',
	                     //  'size'=> 'large',
	                  //Si es invitado enviar los productos a una
	                     //URL distinta por ajax
	                   'url'=> Yii::app()->user->isGuest ? CController::createUrl('producto/agregarBolsaGuest'):
	                         CController::createUrl('bolsa/agregar2'),
	             
	                    'htmlOptions'=>array('id'=>'buttonGuardar','class'=>'span8 no_margin_left'),
	                    'ajaxOptions'=>array(
	                            'type' => 'POST',
	                            'data'=> "js:$('#producto-form').serialize()",
	                            'dataType' => 'json',
	                            'beforeSend' => "function( request )
	                                 {                                  
	                                   
	                                  var entro = true; 
	                                   if ( $(\"input[name='producto[]']:checked\").length <= 0 ){
	                                      entro = false;
	                                        alert('".Yii::t('contentForm' , 'Must select at least one item')."');
	                                        return false;
	                                   }
	
	                                   $('.tallas').each(function(){
	                                           if ($(this).val()==''){
	
	                                               if ($(this).parent().prev('input').prop('checked')){
	                                                  entro = false;
	                                                 
	                                                   $('#alertSizes').show();
	                                                   return false;
	                                               }
	                                           }
	
	                                   });
	                                   if (entro){
	                                     
	                                      if ($('#buttonGuardar').attr('disabled')==true)
	                                        return false;
	                                      $('#buttonGuardar').attr('disabled', true);
	                                   }else{
	                                        return false;
	                                    }
	                                   
	                                 }",
	
	
	                             'success' => "function( data )
	                                  {
	                                    var invitado = ".(Yii::app()->user->isGuest ? "true":"false")."
	                                     if(invitado){
	                                        agregarBolsaGuest(data);
	                                     }else{
	                                        if(data.status == 'ok')
	                                        {
	                                          for (var index = 0; index < data.productos.length; ++index) {
	                                              console.log(data.productos[index]);
	                                              ga('ec:addProduct', {
	                                                'id': data.productos[index].id,
	                                                'name': data.productos[index].name,
	                                                'category': data.productos[index].category,
	                                                'brand': data.productos[index].brand,
	                                                'variant': data.productos[index].variant,
	                                                'price': data.productos[index].price,
	                                                'quantity': data.productos[index].quantity,
	                                              });
	                                              ga('ec:setAction', 'add');
	                                              ga('send', 'event', 'UX', 'click', 'add to cart');     // Send data using an event.
	                                          }
	                                          ga('ec:addProduct', {
	                                            'id': data.id,
	                                            'name': data.name,
	                                            'category': data.category,
	                                            'brand': data.brand,
	                                            'variant': data.variant,
	                                            'price': data.price,
	                                            'quantity': data.quantity,
	                                          });
	                                          ga('ec:setAction', 'add');
	                                          ga('send', 'event', 'UX', 'click', 'add to cart');     // Send data using an event.
	                                          window.location='".$this->createUrl('bolsa/index')."';
	                                        }                                     
	                                    }
	                                  }",
	                                //  'data'=>array('id'=>$model->id),
	                    ),
	                )); ?>

		<div class="margin_top_medium">
			
			<div class="addthis braker_horz">
    		<div class="complete margin_top_medium">
  				<div class="half">
    
     			</div>
     		<div class="half">
     			
     			<?php if(!Yii::app()->user->isGuest){
   
		        $like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$model->id));
		 
		
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
		       	
		       			<a class="btn" id="btn-encanta" onclick="encantar()">
		       				<span class="entypo icon_personaling_medium"> &nbsp; </span> 
		       				<?php echo Yii::t('contentForm','Like'); ?>
		       			</a> &nbsp;
		        <?php
		        }
		        ?>
		       		<small id="total-likes">
		        <?php 
		          $cuantos = UserEncantan::model()->countByAttributes(array('producto_id'=>$model->id));   
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
		
</div>


<script>
	$('.btn.btn-warning.btn-block').html('<i class="icon-shopping-cart icon-white"></i> Comprar');
	
</script>
