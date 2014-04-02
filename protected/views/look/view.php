<?php
$this->breadcrumbs=array(
  'Todos los looks'=>array('tienda/look'),
  'Look'
);
$this->pageTitle=Yii::app()->name . " - " . $model->title;;
  Yii::app()->clientScript->registerMetaTag('Personaling - '.$model->title.' - '.$model->getPrecio().' Bs.', null, null, array('property' => 'og:title'), null); // registro del meta para facebook
  Yii::app()->clientScript->registerMetaTag($model->description.' Creado por: '.$model->user->profile->first_name.' '.$model->user->profile->last_name, null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 

  //Metas de Twitter CARD ON

  Yii::app()->clientScript->registerMetaTag('product', 'twitter:card', null, null, null);
  Yii::app()->clientScript->registerMetaTag('@personaling', 'twitter:site', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->title, 'twitter:title', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->description, 'twitter:description', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->getPrecio().' Bs.', 'twitter:data1', null, null, null);
  Yii::app()->clientScript->registerMetaTag('Subtotal', 'twitter:label1', null, null, null);
  Yii::app()->clientScript->registerMetaTag($model->user->profile->first_name.' '.$model->user->profile->last_name, 'twitter:data2', null, null, null);  
  Yii::app()->clientScript->registerMetaTag('Creado por', 'twitter:label2', null, null, null);
  Yii::app()->clientScript->registerMetaTag('personaling.com', 'twitter:domain', null, null, null);

  //Metas de Twitter CARD OFF


?>



<div class="container margin_top_small" id="carrito_compras">
  <div class="row">
    <div class="span12">
      <div class="row detalle_look">
        <!-- Columna Principal ON-->
        <article class="span8 columna_principal">
          <div class="row">
            <div class="span6">
                <input id="idLook" type="hidden" value="<?php echo $model->id ?>" />
              <h1><?php echo $model->title; ?></h1>
              <p class="margin_top_small_minus"> <!-- <small>Look <a href="#" title="playero">Playero</a>,   --> <?php echo Yii::t('contentForm','Style'); ?> <a href="#" title="casual"><?php echo $model->getTipo(); ?></a> <!-- | 100% Disponible --></small></p>
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


              </div>
            </div>
          </div>
          <div class="row-fluid">
            <?php Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->createUrl('look/getImage',array('id'=>$model->id,'w'=>770,'h'=>770)), null, null, array('property' => 'og:image'), null);  // Registro de <meta> para compartir en Facebook
                  //Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->createUrl('look/getImage',array('id'=>$model->id)), 'twitter:image:src', null, null, null); //Registro de meta para Card de Twitter

            ?>
            <div class="span12" ><div class="imagen_principal"> <span class="label label-important margin_top_medium"><?php echo Yii::t('contentForm','Promotion'); ?></span> <?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$model->id,'w'=>770,'h'=>770)), "Look", array('class'=>'img_1')); ?> </div></div>

          </div>
          <div class="hidden-phone row-fluid vcard">
            <div class="span2 avatar ">
            <a href="<?php $perfil = $model->user->profile; echo $perfil->getUrl(); ?>" title="perfil" class="url">
            <?php echo CHtml::image($model->user->getAvatar(),'Avatar',array("width"=>"84", "class"=>"pull-left photo  img-circle")); //,"height"=>"270" ?>
            </a>
            </div>
            <div class="span5 braker_right row-fluid">
            <div class="span9">
            <span class="muted"><?php echo Yii::t('contentForm' , 'Look created by'); ?>: </span>
              <h5><a href="<?php echo $perfil->getUrl(); ?>" title="perfil" class="url"><span class="fn"> <?php echo $model->user->profile->first_name.' '.$model->user->profile->last_name; ?></span> <i class="icon-chevron-right"></i></a></h5>
              <p  class="note"><strong><?php echo Yii::t('contentForm','Biography'); ?></strong>: <?php echo $model->user->profile->bio; ?> </p>
            </div>
            <div class="span3">
              <span class="muted" ><?php echo Yii::t('contentForm' , 'On this look'); ?></span>
            </div>
            </div>
            <!-- Marcas en el look ON -->
            <div class="span5 marcas">
              
              
              <ul class="unstyled">
                <?php foreach ($model->getMarcas() as $marca){ ?>
	                 <li >  
	                  	<?php echo CHtml::image($marca->getImageUrl(true),$marca->nombre, array('width'=>60, 'height'=>60));
                      ?>
	                </li>                	
                <?php } ?>              
                                                      
              </ul>
              
              
            </div>
            <!-- Marcas en el look OFF -->            
          </div>
          <hr/>
          <h3><?php echo Yii::t('contentForm' , 'Look description'); ?></h3>
          <p><?php echo $model->description; ?> </p>
        </article>
        <!-- Columna Principal OFF -->

        <!-- Columna Secundaria ON-->
        <div class="span4 columna_secundaria">
          <!-- Boton de comprar  -->
          <div class="row-fluid call2action">
            <div class="span6">
              <h4 class="precio" ><div id="price"><span><?php echo Yii::t('contentForm' , 'Subtotal'); ?></span><?php echo Yii::t('contentForm', 'currSym').' '.$model->getPrecio(); ?></div></h4>
            </div>
            <div class="span6">
              <div class="">
                <!--    <a href="bolsa_de_compras.php" title="agregar a la bolsa" class="btn btn-danger"> Añadir a la bolsa</a> -->
                <?php

         $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'ajaxButton',
                    'id'=>'btn-compra', 
                    'type'=>'warning',
                    'label'=>Yii::t('contentForm' , 'Buy'),
                    'block'=>'true',
                       'size'=> 'large',
                   // 'url'=>array('producto/tallacolor'),
                   'url'=> CController::createUrl('bolsa/agregar') ,
                    'htmlOptions'=>array('id'=>'buttonGuardar'),
                    'ajaxOptions'=>array(
                            'type' => 'POST',
                            'data'=> "js:$('#producto-form').serialize()",

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
                                                   bootbox.alert('".Yii::t('contentForm' , 'You must select all sizes')."');
                                                   return false;
                                               }
                                           }

                                   });
                                   if (entro){
                                   		if ($('#buttonGuardar').attr('disabled')==true)
                                   			return false;
                                   		$('#buttonGuardar').attr('disabled', true);
								   }
                                   
                                 }",


                             'success' => "function( data )
                                  {

                                     if(data.indexOf('ok')>=0)
                                    {
                                        window.location='".$this->createUrl('bolsa/index')."';
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
          <p class="muted t_small CAPS braker_bottom"><?php echo Yii::t('contentForm' , 'Select the size'); ?> </p> 
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
              <?php if($model->productos)
                          foreach ($model->lookhasproducto as $lookhasproducto){
                              // $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$lookhasproducto->producto_id,'orden'=>'1'));
                              $image_url = $lookhasproducto->producto->getImageUrl($lookhasproducto->color_id,array('type'=>'thumb'));
                            Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$image_url, null, null, array('property' => 'og:image'), null);  // Registro de <meta> para compartir en Facebook                              
            ?>
              <div class="span6"> <a href="pagina_producto.php" title="Nombre del Producto">
                <!-- <img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_1.jpg" title="Nombre del producto" class="imagen_producto" />
                      -->
                <?php      
                 $prod = Producto::model()->findByPk($lookhasproducto->producto_id);
                ?>
                 
                <?php $image = CHtml::image($image_url, "Imagen ", array('class'=>'imagen_producto'));  ?>
                <?php echo CHtml::link($image, $prod->getUrl() ); ?>
                <?php //$color_id = @LookHasProducto::model()->findByAttributes(array('look_id'=>$model->id,'producto_id'=>$lookhasproducto->producto_id))->color_id ?>
                <?php $color_id = $lookhasproducto->color_id; ?>
                </a>
                <?php if ( $lookhasproducto->producto->getCantidad(null,$color_id) > 0 && 
                        $lookhasproducto->producto->estado == 0){ ?>
                <?php echo CHtml::checkBox("producto[]",true,array('onclick'=>'js:updatePrice();','value'=>$lookhasproducto->producto_id.'_'.$color_id)); ?>
                <?php } else { ?>
                 <?php echo CHtml::checkBox("producto[]",false,array('readonly'=>true,'disabled'=>true,'value'=>$lookhasproducto->producto_id.'_'.$color_id)); ?>

                <?php } ?>

                <div class="metadata_top">
                  <?php // echo Chtml::hiddenField("color[]",$color_id); ?>
                  <?php // echo Chtml::hiddenField("producto[]",$producto->id); ?>
                  <?php 
                    if($lookhasproducto->producto->estado == 0){
                        echo CHtml::dropDownList('talla'.$lookhasproducto->producto_id.'_'.$color_id,'0',$lookhasproducto->producto->getTallas($color_id),array('onchange'=>'js:updateCantidad(this);','prompt'=>Yii::t('contentForm' , 'Size'),'class'=>'span5 tallas')); 
                    }else{
                        
                        echo CHtml::dropDownList('talla'.$lookhasproducto->producto_id.'_'.$color_id,'0',array(),array('onchange'=>'js:updateCantidad(this);','prompt'=>Yii::t('contentForm' , 'Size'),'class'=>'span5 tallas')); 
                        
                    }
                  
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
              <?php } ?>
            </div>
          </div>
          <?php $this->endWidget(); ?>
          <!-- Productos del look OFF -->
          <div class="row call2action">
                <?php

         $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'ajaxButton',
                    'id'=>'btn-compra', 
                    'type'=>'warning',
                    'label'=>Yii::t('contentForm' , 'Buy'),
                    'block'=>'true',
                       'size'=> 'large',
                   // 'url'=>array('producto/tallacolor'),
                   'url'=> CController::createUrl('bolsa/agregar') ,
                    'htmlOptions'=>array('id'=>'buttonGuardar','class'=>'span2'),
                    'ajaxOptions'=>array(
                            'type' => 'POST',
                            'data'=> "js:$('#producto-form').serialize()",

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
                                                   bootbox.alert('".Yii::t('contentForm' , 'You must select all sizes')."');
                                                   return false;
                                               }
                                           }

                                   });
                                   if (entro){
                                      if ($('#buttonGuardar').attr('disabled')==true)
                                        return false;
                                      $('#buttonGuardar').attr('disabled', true);
                   }
                                   
                                 }",


                             'success' => "function( data )
                                  {

                                     if(data.indexOf('ok')>=0)
                                    {
                                        window.location='".$this->createUrl('bolsa/index')."';
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
          <div class="braker_horz_top_1">            
           
            <span class="entypo icon_personaling_medium">&#128197;</span> <?php echo Yii::t('contentForm' , 'Date estimated delivery'); ?>: <?php echo date("d/m/Y", strtotime('+1 day')); ?> - <?php echo date('d/m/Y', strtotime('+1 week'));  ?>                  
          </div>
          <div class="braker_horz_top_1 addthis clearfix row-fluid">  
          <?php
            // total de likes 
            $cuantos = LookEncantan::model()->countByAttributes(array('look_id'=>$model->id));
                       
            if(isset($like)) // le ha dado like 
				    { ?>
          
          		<div class="span6"><a class="btn btn-danger_modificado" id="btn-encanta" onclick="encantar()" style="cursor: pointer;"><span class="entypo icon_personaling_medium">&nbsp;</span> <?php echo Yii::t('contentForm' , 'Like'); ?> </a>
            <?php
				    }
			      else {?>
			       
			       <div class="span6"><a class="btn" id="btn-encanta" onclick="encantar()" style="cursor: pointer;"><span class="entypo icon_personaling_medium">&nbsp;</span><?php echo Yii::t('contentForm' , 'Like'); ?> </a> 
      			<?php
      				}
      			?>	
      &nbsp; <span id="total-likes" ><?php echo $cuantos; ?></span>
          	
          
          	
          </div>            
          <!-- AddThis Button BEGIN -->
          <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
          <a class="addthis_button_facebook" ></a>
          <a class="addthis_button_twitter" tw:via="personaling"></a>
          <a class="addthis_button_pinterest_share" ></a>
          </div>
          <!-- AddThis Button END --> 
            
            <script type="text/javascript">       
              var addthis_config = {"data_track_addressbar":false,image_exclude: "at_exclude"};
              var addthis_share = {
                  templates : {
                      twitter : "{{title}} {{url}} #MiPersonaling via @personaling "
                  }
              }
            </script> 
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script>           
          </div>
          <div>
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/banner_mango.jpg" width="180" height="150" alt="Banner Accesorize" />             <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/banner_mango.jpg" width="180" height="150" alt="Banner Aldo" />
          </div>
        </div>
        <!-- Columna secundaria OFF -->
      </div>

      <?php if($dataProvider->getItemCount() > 0){ //si hay looks que te puedan gustar para mostrar  ?>

        <div class="braker_horz_top_1" id="tienda_looks">
          <h3>Otros Looks que te pueden gustar</h3>
              <div class="row">
        <?php        
        $cont=0;
        foreach($dataProvider->getData() as $record)
        {
          $lookre = Look::model()->findByPk($record['id']);

          if($lookre->matchOcaciones(User::model()->findByPk(Yii::app()->user->id))){
              if($cont<3){

              //<div class="span4"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; /images/look_sample_pequeno_1.jpg" width="370" height="370" alt="Nombre del Look"></div>

                     $like = LookEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'look_id'=>$lookre->id));

                     if(!isset($like)) // no le ha dado like al look
                  {
                      $cont++;
        ?>

              <div class="span4 look">
                  <article class="item" >
                      <?php echo CHtml::image('../images/loading.gif','Loading',array('id'=>"imgloading".$lookre->id)); ?>
                        <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$lookre->id,'w'=>'368','h'=>'368')), "Look", array("style"=>"display: none","id" => "imglook".$lookre->id,"width" => "368", "height" => "368", 'class'=>'')); ?>

                        <?php echo CHtml::link($image,$lookre->getUrl()); //array('look/view', 'id'=>$lookre->id ?>
                        <?php
                      //"style"=>"display: none",
                          $script = "
										var load_handler = function() {
										    $('#imgloading".$lookre->id."').hide();
										    $(this).show();
										}
										$('#"."imglook".$lookre->id."').filter(function() {
										    return this.complete;
										}).each(load_handler).end().load(load_handler);						 
									 ";									 
              						Yii::app()->clientScript->registerScript('img_script'.$lookre->id,$script);
                        ?>
                    <div class="hidden-phone margin_top_small vcard row-fluid">
                      <div class="span2 avatar ">

                          <?php echo CHtml::image($lookre->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?>
                      </div>
                      <div class="span4"> <span class="muted"><?php echo Yii::t('contentForm' , 'Look created by'); ?>:  </span>
                        <h5><a class="url" title="profile" href="#"><span class="fn">
                          <?php //echo $look->title; ?>
                          <?php echo $lookre->user->profile->first_name; ?> </span></a></h5>
                      </div>
                      <div class="span6"><span class="precio"> <small><?php echo Yii::t('contentForm' , 'currSym'); ?></small> <?php echo $lookre->getPrecio(); ?></span></div>
                    </div>
                    <div class="share_like">
                      <button href="#" title="Me encanta" class="btn-link"><span class="entypo icon_personaling_big">&#9825;</span></button>
                      <div class="btn-group">
                        <button class="dropdown-toggle btn-link" data-toggle="dropdown"><span class="entypo icon_personaling_big">&#59157;</span></button>
                        <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                          <!-- AddThis Button BEGIN -->

                          <li><a class="addthis_button_facebook_like" fb:like:layout="box_count"></a> </li>
                          <li><a class="addthis_button_tweet"></a></li>
                          <li><a class="addthis_button_pinterest_pinit"></a></li>
                        </ul>
                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script>
                        <!-- AddThis Button END -->

                      </div>
                    </div>
                    <span class="label label-important"><?php echo Yii::t('contentForm' , 'Promotion'); ?></span> </article>
                </div>
      <?php
                  } // like
              } // contador
          } // match
      } // foreach
      ?>
                </div>
        </div>
      <?php } //  off si hay looks que te puedan gustar para mostrar ?>

      <div class="braker_horz_top_1">
        <div class="row">
<!--           <div class="span6">
            <h3>Otros Productos que te pueden gustar</h3>
            <div class="row">
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_7.jpg" ></a></div>
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_8.jpg" ></a></div>
              <div class="span2"> <a href="#" ><img width="170" height="170" src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>/images/producto_sample_9.jpg" ></a></div>
            </div>
          </div> -->
          <div class="span11">
            <h3><?php echo Yii::t('contentForm' , 'Recently viewed'); ?></h3>
            <div class="row">
                        <?php
                             //$iterator = new CDataProviderIterator($ultimos_vistos);
                            //foreach($iterator as $view):
                             //    if (isset($view)):
                        foreach($ultimos_vistos->getData() as $record) :
     $producto = Producto::model()->findByPk($record['producto_id']);
     if (isset($producto)):
                         ?>
              <div class="span2">
                  <?php $image = CHtml::image($producto->getImageUrl(), "Imagen", array("width" => "170", "height" => "170"));    ?>
                            <?php echo CHtml::link($image, $producto->getUrl()); ?>

              </div>
                          <?php
                                  endif;
                              endforeach;
                          ?>

            </div>
          </div>
        </div>
      </div>
      <div class="text_align_center">
        <hr/>
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/banner_aldo.jpg" width="970" height="90" alt="Banner blanco" />
      </div>
    </div>

    <!-- /container -->
  </div>
</div>
<!-- Modal Window -->

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4><?php echo Yii::t('contentForm' , 'Details'); ?></h4>
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
            dataType:"json",
            url: "encantar", // action Tallas de look
            data: { 'idLook':idLook},
            success: function (data) {
			 
			//alert(data );
			
                if(data.mensaje=="ok")
                {
                    var a = "♥";

                    //$("#meEncanta").removeClass("btn-link");
                    $("#meEncanta").addClass("btn-link-active");
                    $("span#like").text(a);
					
					$("#total-likes").text(data.total);
					$("#btn-encanta").addClass("btn-danger_modificado");
                }

                if(data.mensaje=="no") 
                {
                    alert("Debe primero ingresar como usuario");
                    //window.location="../../user/login";
                }

                if(data.mensaje=="borrado")
                {
                    var a = "♡";

                    //alert("borrando");
					$("#btn-encanta").removeClass("btn-danger_modificado");
                    $("#meEncanta").removeClass("btn-link-active");
                    $("span#like").text(a);
                    
                    $("#total-likes").text(data.total);

                }

               }//success
           })


       }

</script>
