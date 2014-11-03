<?php 
        $producto = Producto::model()->findByPk($id);
        
        if($producto->tipo){
            $left="span4";
            $right="span8";
            $tienda=Tienda::model()->findByPk($producto->tienda_id);
            if(strlen($tienda->urlVista)>9)
                $msj="Ir a ".$tienda->urlVista;
            else
                $msj="Comprar en ".$tienda->urlVista;
        }
            
        else{
            $tienda=null;
            $left="span7";
            $right="span5";
        }
        
?>   


<div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h3 id='myModalLabel'>
        <a href='<?php echo $producto->getUrl();?>' title='<?php echo $producto->nombre;?>'>
            <?php echo $producto->nombre;?>
        </a>
    </h3>
</div>

<div class='row-fluid'>
        <div class='span7'>
             <div class='carousel slide imagen_principal' id='myCarousel'>
         <?php 
            $ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
         ?>
                <div class="carousel-inner" id="carruselImag">
    <?php    foreach ($ima as $img){
                    
            if($img->orden==1)
            { 
                $colorPredet = $img->color_id;
                
                echo '<div class="item active">';   
                echo  CHtml::image($img->getUrl(array('ext'=>'jpg')), "Personaling - ".$producto->nombre, array("width" => "450", "height" => "450"));
                echo '</div>';
            }
                
            if($img->orden!=1){
                if($colorPredet == $img->color_id)
                {
                    echo '<div class="item">';
                    echo CHtml::image($img->getUrl(array('ext'=>'jpg')), "Personaling - ".$producto->nombre, array("width" => "450", "height" => "450"));
                    echo '</div>';
                }
            }// que no es la primera en el orden
        } ?>
        
                </div>
                  <a data-slide="prev" href="#myCarousel" class="left carousel-control">&lsaquo;</a>
                  <a data-slide="next" href="#myCarousel" class="right carousel-control">&rsaquo;</a>
            </div>
                        
             
        </div>
        

        <div class="span5">
            <div class="row-fluid call2action">
               
               
                <div class="<?php echo $left; ?>">
                    <?php   $precio_producto = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id)); 
        if($precio_producto){
            if(!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0){
              switch ($precio_producto->tipoDescuento) {
                case 0:
                  $porcentaje = $precio_producto->valorTipo;
                  break;
                case 1:
                  $porcentaje = ($precio_producto->valorTipo * 100) / $precio_producto->precioImpuesto;
                  break;
                default:
                  break;
              }
              $precio_mostrar = $precio_producto->precioImpuesto;?>
                <span class="preciostrike strikethrough color9 T_mediumLarge">
                  <?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->format("#,##0.00",$precio_mostrar); ?>
                </span>
                <span class='T_large'>|</span>
                <span class='pDescuento'><?php echo Yii::t('contentForm', 'currSym')." ".Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioDescuento);?>
                    
                </span>
                <br/> 
                <span class="conDescuento">
                    Con <?php echo Yii::app()->numberFormatter->format("#",$porcentaje);?> % de descuento
                </span>
<?php        }else{ ?>
                <div class="pDetalle">
                    <span><?php echo Yii::t('contentForm', 'currSym');?></span>
                    <?php echo Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioImpuesto)?>
                </div>
<?php            }
        }
?>
                
                </div>
            
                <div class="<?php echo $right; ?> margin_top_xsmall">
<?php       if(is_null($tienda)) { ?>
            <a class="btn btn-warning btn-block"  style="width:85px" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a>
<?php       }else{ ?>
            <a class="btn btn-warning btn-block" style="width:167px" target="_blank" href="<?php echo $producto->url_externo; ?>" title="<?php echo $msj; ?>" ><?php echo $msj;?></a>
            <?php }?>
                </div>
            
                
            
            
            </div>
                
            <p class="muted t_small CAPS">Selecciona Color y talla </p>
            
            
            <div class="row-fluid">
<?php   if($producto->mymarca->is_100chic){ ?>
       
               <div class="span12">
                   <img src="<?php echo Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/especial/080bannerprevia.jpg';?>" />
               </div>

<?php    } ?>  


                <div class="span6">
                     <h5>Colores</h5>
                        <div class="clearfix colores" id="vCo">
                            
                            
<?php       $valores = Array();
            $cantcolor = Array();
            $cont1 = 0;
              

            // revisando cuantos colores distintos hay 
            foreach ($producto->preciotallacolor as $talCol){ 


                if($talCol->cantidad > 0){
                    $color = Color::model()->findByPk($talCol->color_id);
                    
                    if(in_array($color->id, $cantcolor)){   // no hace nada para que no se repita el valor          
                    }
                    else {
                        array_push($cantcolor, $color->id);
                        $cont1++;
                    }   
                }
            }
                
            if( $cont1 == 1){ // Si solo hay un color seleccionelo
                $color = Color::model()->findByPk($cantcolor[0]);      ?>                      
                <div value='solo' id="<?php echo $color->id; ?>" style='cursor: pointer' class='coloress active' title='<?php echo $color->valor;?>'>
                    <img src='<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image;?>'>
                </div>       
<?php      }
            else{
                foreach ($producto->preciotallacolor as $talCol) {
                    if($talCol->cantidad > 0){ // que haya disp
                        $color = Color::model()->findByPk($talCol->color_id);       
                                
                        if(in_array($color->id, $valores)){ // no hace nada para que no se repita el valor          
                        }
                        else{ ?>
                            <div id="<?php echo $color->id;?>" style='cursor: pointer' class='coloress' title='<?php echo $color->id;?>'>
                                <img src='<?php echo Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image;?>'>
                            </div>
                            
<?php                   array_push($valores, $color->id);
                        }
                    }
                }
                
            } // else ?>                     
                            
                            
                        </div>
                     
                </div> <!-- colores -->
                
                <div class="span6">
                    <h5>Tallas</h5>
                    <div class="clearfix tallas" id="vTa">     
                        
<?php      
        $valores = Array();
        $canttallas= Array();
        $cont2 = 0;
                
        foreach ($producto->preciotallacolor as $talCol){ 
            if($talCol->cantidad > 0){
                $talla = Talla::model()->findByPk($talCol->talla_id);
                        
                if(in_array($talla->id, $canttallas)){  // no hace nada para que no se repita el valor          
                }
                else{
                    array_push($canttallas, $talla->id);
                    $cont2++;
                }
                            
            }
        }

        if( $cont2 == 1){ // Si solo hay un color seleccionelo
            $talla = Talla::model()->findByPk($canttallas[0]); ?>
            <div value='solo' id="<?php echo $talla->id;?>" style='cursor: pointer' class='tallass active' title='talla'>
                <?php echo $talla->valor; ?>
           </div>
            <?php    }
        else{               
          
     foreach ($producto->availableSizes as $talla) {
            
                ?>
                        <div id="<?php echo $talla->id;?>" style='cursor: pointer' class='tallass' title='talla'>
                            <?php echo $talla->valor; ?>                            
                        </div>
<?php         }   
               
        }// else
  ?>                        
                        
                        
                        
                        
                    </div>                   
                    
                </div> <!-- tallas -->

                
                
                
            </div>
            
            
            <div class="row-fluid"> <hr/>
<?php       $marca = Marca::model()->findByPk($producto->marca_id); ?>
            <h5>Marca</h5>
            <div class="thumbnails">
                <img width="66px" height="66px" src="<?php echo Yii::app()->baseUrl .'/images/'.Yii::app()->language.'/marca/'. str_replace(".","_thumb.",$marca->urlImagen);?>"/>
            </div>             
                
            </div>
            
        
        
        
        </div><!-- derecha -->



 

</div>

<div class="modal-footer">
    <a href="<?php echo $producto->getUrl(); ?>" class="btn btn-info pull-left"> Ver el producto </a>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
</div>

<div id="alertRegister" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
        <div class="modal-header">
            <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <h4>'.Yii::t('contentForm','Please complete your registration to make a purchase on Personaling.').'</h4>    
        </div>
        <div class="modal-footer">
            <div class="row-fluid">
                <a class="btn btn-danger span3" href="<?php echo Yii::app()->baseUrl;?>/registro-personaling">'.Yii::t('contentForm','Complete Registration').'</a>
                <div class="span6"></div>
                <button class="btn closeModal span3" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            </div>
        </div>
</div>




<script>
    function agregarBolsaGuest(producto, talla, color){
<?php
        echo CHtml::ajax(array(
                    'url'=>array('/producto/agregarBolsaGuest'),
                    'data'=>array('producto'=>'js:producto',
                                            'talla'=>'js:talla',
                                            'color'=>'js:color'),
                        'dataType'=>'JSON',
                        'type'=>'POST',
                        'success'=>"function(data)
                        {
                            if(data.status == 'success'){                  
                                
                                $('#myModal').on('hidden', function () {
                                    desplegarBolsaGuest(data);
                                    
                                });
                                $('#myModal').modal('hide');
                                
                                

                            }

                        } ",
                        ));
?>        
        
    }//finBolsaGuest
    
    $("body").removeClass("aplicacion-cargando");
    var bandera=false;
    $(document).ready(function() {
        $('.closeModal').click(function(event){
            $('#alertRegister').hide();
        });
        
        $('.coloress').click(function(ev){
            ev.preventDefault();
            var prueba = $("#vTa div.tallass.active").attr("value");
            if(prueba == 'solo'){
                $(this).addClass('coloress active');
                $('#vTa div.tallass.active').attr('value','0');
            }
            else{
                $("#vCo").find("div").siblings().removeClass("active");
                var dataString = $(this).attr("id");
                var prod = $("#producto").attr("value");
                $(this).removeClass('coloress');
                $(this).addClass('coloress active');

<?php           echo CHtml::ajax(array(
                    'url'=>array('producto/tallaspreview'),
                    'data'=>array('idTalla'=>"js:$(this).attr('id')",'idProd'=>$id),
                    'type'=>'post',
                    'dataType'=>'json',
                    'success'=>"function(data)
                    {
                        //alert(data.datos);
                        
                        $('#vTa').fadeOut(100,function(){
                            $('#vTa').html(data.datos); // cambiando el div
                        });
            
                        $('#vTa').fadeIn(20,function(){});
                        
                        $('#carruselImag').fadeOut(100,function(){
                            $('#carruselImag').html(data.imagenes); 
                        });
            
                        $('#carruselImag').fadeIn(20,function(){});
                        
                        //$('#carruselImag').html(data.imagenes);
                        
                        
                    } ",
                    ));
?>


            return false;
        }
    });
    $(".tallass").click(function(ev){                               
        ev.preventDefault();
        var prueba = $("#vCo div.coloress.active").attr("value");        
        if(prueba == 'solo'){
            $(this).addClass('tallass active');
            $("#vCo div.coloress.active").attr("value","0");
        }
        else{
            $("#vTa").find("div").siblings().removeClass("active");
            var dataString = $(this).attr("id");
            var prod = $("#producto").attr("value");
            $(this).removeClass('tallass');        
            $(this).addClass('tallass active');
<?php       echo CHtml::ajax(array(
                    'url'=>array('producto/colorespreview'),
                    'data'=>array('idColor'=>"js:$(this).attr('id')",'idProd'=>$id),
                    'type'=>'post',
                    'dataType'=>'json',
                    'success'=>"function(data)
                    {
                        //alert(data.datos);
                        
                        $('#vCo').fadeOut(100,function(){
                            $('#vCo').html(data.datos); // cambiando el div
                        });
            
                        $('#vCo').fadeIn(20,function(){});              

                    } ",
                    ));
?>
           return false;
        }
    });
});

function a(id){
    $("#vTa").find("div").siblings().removeClass("active");
    $("#vTa").find("div#"+id+".tallass").removeClass("tallass");
    $("#vTa").find("div#"+id).addClass("tallass active");
}

function b(id){
    $("#vCo").find("div").siblings().removeClass("active");
    $("#vCo").find("div#"+id+".coloress").removeClass("coloress");
    $("#vCo").find("div#"+id).addClass("coloress active");
}

function c(){
    var talla = $("#vTa").find(".tallass.active").attr("id");
    var color = $("#vCo").find(".coloress.active").attr("id");
    var producto = $("#producto").attr("value");
    // llamada ajax para el controlador de bolsa
    if(talla==undefined && color==undefined){
        alert("Seleccione talla y color para poder aÃ±adir.");
    }
    if(talla==undefined && color!=undefined){
        alert("Seleccione la talla para poder aÃ±adir a la bolsa.");
    }
    if(talla!=undefined && color==undefined){
        alert("Seleccione el color para poder aÃ±adir a la bolsa.");
    }
    if(talla!=undefined && color!=undefined){
        if(bandera==true) 
            return false; 
        bandera = true;
        $("#agregar").click(function(e){e.preventDefault();});
        $("#agregar").addClass("disabled");
        var isGuest =<?php echo(Yii::app()->user->isGuest?"true":"false");?>;
        if(isGuest)
        {
            agregarBolsaGuest(<?php echo $id; ?>, talla, color);
        }
        else{
<?php       echo CHtml::ajax(array(
                    'url'=>array('bolsa/agregar'),
                    'data'=>array('producto'=>$id,'talla'=>'js:$("#vTa").find(".tallass.active").attr("id")','color'=>'js:$("#vCo").find(".coloress.active").attr("id")'),
                    'type'=>'post',
                    'success'=>"function(data)
                    {
                        if(data=='ok'){
                            //alert('redireccionar maÃ±ana');
                            window.location='".Yii::app()->baseUrl."/bolsa/index';
                        }   
                        if(data=='no es usuario'){
                            //$('#alertRegister').show();
                            
                        }
                        
                    } ",
                ));
?>            
        }
        return false;
      
    } // fin if
           
}// fin de c                   
                 
</script>
