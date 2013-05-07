<?php
// $this->breadcrumbs=array(
	//'Look',
// );
?>

<div class="container margin_top" id="carrito_compras">
  <div class="row">
    <div class="span12">
      <div class="row detalle_look"> 
        <!-- Columna Principal ON-->
        <article class="span8 columna_principal">
          <div class="row">
            <div class="span6">
            	<input id="idLook" type="hidden" value="<?php echo $model->id ?>" />
              <h1><?php echo $model->title; ?></h1>
              <p class="margin_top_small_minus"> <small>Look <a href="#" title="playero">Playero</a>,  Estilo <a href="#" title="casual"><?php echo $model->getTipo(); ?></a> | Disponible hasta: 18/03/2013 | 100% Disponible</small></p>
            </div>
            <div class="span2 share_like">
              <div class="pull-right">
              	
              	<?php
            	$entro = 0;
				
				$like = LookEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'look_id'=>$model->id));
            	
            	if(isset($like)) // le ha dado like al look
				{
					//echo "p:".$like->producto_id." us:".$like->user_id;
					$entro=1;
					?>
						
						<button id="meEncanta" onclick='encantar()' title="Me encanta" class="btn-link btn-link-active">
							<span id="like" class="entypo icon_personaling_big">&hearts;</span>
						</button>
               		<?php	
					
				}
					
					if($entro==0) // no le ha dado like
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
          </div>
          <div class="imagen_principal"> <span class="label label-important margin_top_medium">Promoción</span> <?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$model->id)), "Look", array("width" => "770", "height" => "770", 'class'=>'img_1')); ?> </div>
          <div class="hidden-phone clearfix vcard">
            <div class="pull-left margin_right_small avatar "><img class="pull-left photo  img-circle" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/hipster_girl.jpg"/></div>
            <div class="pull-left"> <span class="muted">Look creado por: </span>
              <h5><a href="#" title="profile" class="url"><span class="fn">Daniel Kosan</span> <i class="icon-chevron-right"></i></a></h5>
              <p  class="note"><strong>Bio</strong>: Lorem ipsum dolor sit amet deserunt mollit anim</p>
            </div>
          </div>
          <hr/>
          <h3>Descripcion del look</h3>
          <p><?php echo $model->description; ?> </p>
        </article>
        <!-- Columna Principal OFF --> 
        
        <!-- Columna Secundaria ON-->
        <div class="span4 columna_secundaria"> 
          <!-- Boton de comprar  -->
          <div class="row call2action">
            <div class="span2">
              <h4 class="precio" ><span>Subtotal</span><div id="price">Bs. <?php echo $model->getPrecio(); ?></div></h4>
            </div>
            <div class="span2">
              <div class=""> 
                <!--	<a href="bolsa_de_compras.php" title="agregar a la bolsa" class="btn btn-danger"> Añadir a la bolsa</a> -->
                <?php 
		 
		 $this->widget('bootstrap.widgets.TbButton', array(
				    'buttonType'=>'ajaxButton',
				    'type'=>'warning',
				    'label'=>'Añadir a la bolsa',
				    //'block'=>'true',
				   	'size'=> 'large',
				   // 'url'=>array('producto/tallacolor'),
				   'url'=> CController::createUrl('bolsa/agregar') ,
				    'htmlOptions'=>array('id'=>'buttonGuardar'),
				    'ajaxOptions'=>array(
				    	    'type' => 'POST', 
				    	    'data'=> "js:$('#producto-form').serialize()",
		    				
		    				'beforeSend' => "function( request )
			                     {
			                       /*	
			                       var color_id = '';
			                       $('.colores').each(function(index){
			                       		color_id += $(this).val()+',';
			                       });
								   color_id = color_id.substring(0, color_id.length-1);
			                       var talla_id = '';
			                       $('.tallas').each(function(index){
			                       		talla_id +=$(this).val()+ ',';
			                       });
			                       talla_id = talla_id.substring(0, talla_id.length-1);
			                       */
			                       //alert(talla_id);
			                       //this.data += '&talla_id='+talla_id+'color_id='+color_id;
			                       
			                       
			                       //return false;
			                       if ( $(\"input[name='producto[]']:checked\").length <= 0 ){
			                       	 alert('debe seleccionar por lo menos una prenda');
			                       	 return false;
			                       }
			                       
			                       $('.tallas').each(function(){
			                       		if ($(this).val()==''){
			                       			
			                       			if ($(this).parent().prev('input').prop('checked')){
			                       				alert('debe seleccionar todas las tallas');
			                       				return false;
			                       			}
			                       		}
			                       		
			                       });
			                      // return false;
			                       
			                     }",
							   
							 
		                     'success' => "function( data )
				                  {
				                 		
				                 	if(data.indexOf('ok')>=0)
									{
										window.location='../bolsa/index'; 
									}
									
									
				                 //alert(data);
								  /*
								    // handle return data
				                   // alert( data );
				                   // $('#table_tallacolor').append(data);
				                   data = JSON.parse( data );
				                    if(data.status=='success'){
				                        // $('#formResult').html('form submitted successfully.');
				                        //alert('si');
				                        // $('#Tallacolor-Form')[0].reset();
				                        $('#yw0').html('<div class=\"alert in alert-block fade alert-success\">Se guardaron las cantidades</div>');
									}
				                         else{
				                         	id = data.id;
											 delete data['id'];
				                         	
				                        $.each(data, function(key, val) {
				                        	key_tmp = key.split('_');
											key_tmp.splice(1,0,id);
				                        	key = key_tmp.join('_');
											
				                        	//alert('#Tallacolor-Form #'+key+'_em_');
				                        	 
				                        $('#Tallacolor-Form #'+key+'_em_').text(val);                                                    
				                        $('#Tallacolor-Form #'+key+'_em_').show();
				                        });
										}
										 */
				                  }",
				                //  'data'=>array('id'=>$model->id),
					),
				)); 
		
				?>
              </div>
            </div>
          </div>
          
          <!-- Productos del look ON -->
          <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'producto-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
		)); ?>
          <?php echo CHtml::hiddenField('look_id',$model->id); ?>
          <div class="productos_del_look">
            <div class="row-fluid">
              <?php if($model->productos)
			  			foreach ($model->lookhasproducto as $lookhasproducto){ 
			  				 $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$lookhasproducto->producto_id,'orden'=>'1'));
			?>
              <div class="span6"> <a href="pagina_producto.php" title="Nombre del Producto"> 
                <!-- <img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_1.jpg" title="Nombre del producto" class="imagen_producto" /> 
              		-->
                <?php $image = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array('class'=>'imagen_producto'));  ?>
                <?php echo CHtml::link($image, array('producto/detalle', 'id'=>$lookhasproducto->producto_id)); ?>
                <?php //$color_id = @LookHasProducto::model()->findByAttributes(array('look_id'=>$model->id,'producto_id'=>$lookhasproducto->producto_id))->color_id ?>
                <?php $color_id = $lookhasproducto->color_id; ?>
                </a>
                <?php if ( $lookhasproducto->producto->getCantidad(null,$color_id) > 0 ){ ?>
                <?php echo CHtml::checkBox("producto[]",true,array('onclick'=>'js:updatePrice();','value'=>$lookhasproducto->producto_id.'_'.$color_id)); ?>
                <?php } else { ?>
                 <?php echo CHtml::checkBox("producto[]",false,array('readonly'=>true,'disabled'=>true,'value'=>$lookhasproducto->producto_id.'_'.$color_id)); ?>	
					
                <?php } ?>
               
                <div class="metadata_top">
                  <?php // echo Chtml::hiddenField("color[]",$color_id); ?>
                  <?php // echo Chtml::hiddenField("producto[]",$producto->id); ?>
                  <?php echo CHtml::dropDownList('talla'.$lookhasproducto->producto_id.'_'.$color_id,'',$lookhasproducto->producto->getTallas($color_id),array('onchange'=>'js:updateCantidad(this);','prompt'=>'Seleccione','class'=>'span5 tallas')); ?> </div>
                <div class="metadata_bottom">
                  <h5><?php echo $lookhasproducto->producto->nombre; ?></h5>
                  <div class="row-fluid">
                    <div class="span7"><span>Bs. 
                    	<?php foreach ($lookhasproducto->producto->precios as $precio) {
   					echo Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento); // precio
   					}
	
			?>
                    	
                    </span></div>
                    <div class="span5"> <span id="cantidad<?php echo $lookhasproducto->producto_id.'_'.$color_id; ?>"><?php echo $lookhasproducto->producto->getCantidad(null,$color_id); ?> unds.</span></div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php $this->endWidget(); ?>
          <!-- Productos del look OFF -->
          
          <div class="braker_horz_top_1"> <span class="entypo icon_personaling_medium">&#128197;</span> Fecha estimada de entrega: 00/00/2013 - 00/00/2013
            <hr/>
            <img src="http://placehold.it/180x150" align="banner"/> <img src="http://placehold.it/180x150" align="banner"/> </div>
        </div>
        <!-- Columna secundaria OFF --> 
      </div>
      <div class="braker_horz_top_1">
        <h3>Otros Looks que te pueden gustar</h3>
        <div id="myCarousel" class="carousel slide"> 
          
          <!-- Carousel items -->
          <div class="carousel-inner">
            <div class="active item">
              <div class="row">
                <div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></div>
                <div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_2.jpg" width="370" height="370" alt="Nombre del Look"></div>
                <div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_3.jpg" width="370" height="370" alt="Nombre del Look"></div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></div>
                <div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_2.jpg" width="370" height="370" alt="Nombre del Look"></div>
                <div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/look_sample_pequeno_3.jpg" width="370" height="370" alt="Nombre del Look"></div>
              </div>
            </div>
          </div>
          <!-- Carousel nav --> 
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a> </div>
      </div>
      <div class="braker_horz_top_1">
        <div class="row">
          <div class="span6">
            <h3>Otros Productos que te pueden gustar</h3>
            <div class="row">
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_7.jpg" ></a></div>
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_8.jpg" ></a></div>
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_9.jpg" ></a></div>
            </div>
          </div>
          <div class="span4 offset2">
            <h3>Vistos recientemente</h3>
            <div class="row">
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_11.jpg" ></a></div>
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_12.jpg" ></a></div>
            </div>
          </div>
        </div>
      </div>
      <div class="text_align_center">
        <hr/>
        <img src="http://placehold.it/970x90"/> </div>
    </div>
    
    <!-- /container --> 
  </div>
</div>
<!-- Modal Window -->

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Detalles</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="span3"> <img src="http://placehold.it/400x450"/>
        <p class="margin_top_small"><a href="#" title="looks relacionados">12 looks</a> creados con esta prenda</p>
      </div>
      <div class="span2"><span class="label label-important margin_top_medium">ON SALE</span>
        <h3>Nombre de la prenda </h3>
        <p class="muted">Marca / Diseñador <br/>
          2 und. disponibles</p>
        <h4>Precio: Bs. 3.500</h4>
        <strong>Descripción</strong>:
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolor </div>
    </div>
  </div>
  <div class="modal-footer"> <a href="#" class="btn btn-warning">Añadir al Look</a> </div>
</div>

<!-- // Modal Window -->
<script>
	function updateCantidad(object){
		//alert(object.id.substring(5));
		//alert(object.value);
		//var talla = this.val();
		//var prendas = $(this).attr('id');
		//alert(talla);
		//alert(prendas);
		<?php
		//'colores'=>'js:colores',
		echo CHtml::ajax(array(
            'url'=>array('producto/updateCantidad'),
            'data'=> array('talla'=>'js:object.value','prenda'=>'js:object.id.substring(5)'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
                  	//$('#price').html('Bs.'+data.div);
                  	$('#'+data.id).fadeOut(400,function() { $(this).html(data.div+ ' unds.').fadeIn(400); });
                  //alert(data.div);

                }

 
            } ",
            )) 
		?>		
	}
	function updatePrice(){
		var prendas = '';
		//var colores = '';
		$("input[name='producto[]']:checked").each(function(){
			//tempo = $(this).val().split('_');
			//prendas += tempo[0]+',';
			//colores += tempo[1]+',';
			prendas += $(this).val()+',';
		});
		//alert(prendas);
		<?php
		//'colores'=>'js:colores',
		echo CHtml::ajax(array(
            'url'=>array('look/updatePrice'),
            'data'=> array('prendas'=>'js:prendas','look_id'=>'js:$("#look_id").val()'),
            
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
                  	//$('#price').html('Bs.'+data.div);
                  	$('#price').fadeOut(400,function() { $(this).html('Bs.'+data.div).fadeIn(400); });
                  //alert(data.div);

                }

 
            } ",
            )) 
		?>
		
	}
	
	
	   
   	function encantar()
   	{
   		var idLook = $("#idLook").attr("value");
   		//alert("id:"+idLook);		
   		
   		$.ajax({
	        type: "post",
	        url: "encantar", // action Tallas de look
	        data: { 'idLook':idLook}, 
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
					alert("Debe primero ingresar como usuario");
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
