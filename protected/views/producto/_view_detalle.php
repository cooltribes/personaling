
<div class="container margin_top" id="carrito_compras">
  <div class="row margin_bottom_large">
    <div class="span12">
      <div class="row">
       <!-- Columna principal ON -->
        <article class="span8">
          <div class="row">
            <div class="span6">
              <h1> <?php echo $producto->nombre; ?> <span class="label label-important"> ON SALE</span></h1>
            </div>
            <div class="span2">
              <div class="pull-right"><i class="icon-heart"></i> <i class="icon-share"></i> </div>
            </div>
          </div>
          <div class="row">
            <?php
            
            	echo "<div class='span6'> 
            			<!-- FOTO principal ON -->";
            	
            	$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
	
			foreach ($ima as $img){
					
				if($img->orden==1)
				{
					echo CHtml::image(Yii::app()->baseUrl . $img->url, "Imagen ", array("width" => "770", "height" => "640", 'id'=>'principal'));
					//  <img src="http://placehold.it/770x640" />
					echo "<!-- FOTO principal OFF -->";
	          		echo "</div>";	
					
					echo " <div class='span2 margin_bottom'> 
            				<!-- FOTOS Secundarias ON -->";
				
					//imprimiendo igual la primera 
					$pri = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
					echo CHtml::image(Yii::app()->baseUrl . $pri->url, "Imagen ", array("width" => "170", "height" => "145",'class'=>'margin_bottom_small', 'value'=>$pri->id));					
							
				}
								
				if($img->orden!=1){
					//luego el resto para completar el scroll					
					echo CHtml::image(Yii::app()->baseUrl . $img->url, "Imagen ", array("width" => "170", "height" => "145",'class'=>'margin_bottom_small', 'value'=>$img->id));
					// <img src="http://placehold.it/170x145" class="margin_bottom_small"/>
				}
			}
			
			echo "</div>";
            
			/*
			 * 
            <div class="span2 margin_bottom"> 
            <!-- FOTOS Secundarias ON -->
            	<img src="http://placehold.it/170x145" class="margin_bottom_small"/> 
                <img src="http://placehold.it/170x145" class="margin_bottom_small"/> 
            <!-- FOTOS Secundarias OFF -->
             </div>
			 * 
			 * */
			
            ?>


          </div>
        </article>
		<!-- Columna principal OFF -->


		<!-- Columna Secundaria ON -->
        <div class="span4 margin_bottom margin_top padding_top">
          <div class="row">
            <div class="span2">
              <h4 >Precio: Bs. 
              	
              <?php foreach ($producto->precios as $precio) {
   					echo Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento); // precio
   					}
	
			?></h4>
            </div>
            <div class="span2"> <a href="bolsa_de_compras.php" title="agregar a la bolsa" class="btn btn-warning pull-right"><i class="icon-shopping-cart icon-white"></i> Añadir a la bolsa</a> </div>
          </div>
          <div class="row">
            <div class="span2">
              <h5>Tallas</h5>
              <div class="clearfix"> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/><img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> 
              </div>
            </div>
            <div class="span2">
              <h5>Colores</h5>
              <div class="clearfix"> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/><img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> 
              </div>
            </div>
          </div>
          <div class="margin_top">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#detalles">Detalles</a></li>
              <li><a href="#Envio">Envio</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="detalles">
                <div class="clearfix"> 
                  <h4> <?php
                  	
                  	if($producto->proveedor==1)
						echo "Aldo"; 
						
					if($producto->proveedor==2)
						echo "Desigual";
					
					if($producto->proveedor==3)
						echo "Accessorize";
					
					if($producto->proveedor==4)
						echo "SuiteBlanco";
					
					if($producto->proveedor==5)
						echo "Mango";
					
					if($producto->proveedor==6 || $producto->proveedor==0)
						echo "Otro proveedor"; 
					 
					 ?></h4>
                  <img src="http://placehold.it/70x70" class="img-circle pull-right" />
                  <p><strong>Bio</strong>: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmoofficia deserunt mollit anim id</p>
                  <p><a href="#">Ver looks de esta marca</a></p>
                  <p><strong>Descripción</strong>: <?php echo $producto->descripcion; ?></p>
                  </div>
              </div>
              <div class="tab-pane" id="Recomendaciones">Recomendaciones</div>
              <div class="tab-pane" id="Envio">Envio</div>
            </div>
          </div>
          <hr/>
          <p><i class="icon-calendar"></i> Fecha estimada de entrega: 00/00/2013 - 00/00/2013 </p>
        </div>
		<!-- Columna Secundaria OFF -->
      </div>
    </div>
  </div>
  <hr/>
  <h3>Looks recomendados que incluyen este producto</h3>
  <div class="row">
    <div class="span4"><img src="http://placehold.it/370"/></div>
    <div class="span4"><img src="http://placehold.it/370"/></div>
    <div class="span4"><img src="http://placehold.it/370"/></div>
  </div>
</div>

<!-- /container -->

<script>
$(document).ready(function(){
	
   $(".margin_bottom_small").click(function(){
      
     	var image = $("#principal");
     	var thumbnail = $(this).attr("src");
          	
      //  alert(thumbnail);
          	
     	$("#principal").fadeOut("slow",function(){
     		$("#principal").attr("src", thumbnail);
     	});

      	$("#principal").fadeIn("slow",function(){});
      });
      
   });
</script>