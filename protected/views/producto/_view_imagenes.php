<script type="text/javascript">
    $(document).ready(function(){
var uno=0;

        $("#ul_imagenes span").live('click',function(){

            var span = $(this);
			
            $.ajax({
                type:"POST",
                url: "<?php echo CController::createUrl('producto/eliminar'); ?>",
                cache:false,
               	data: "id="+$(this).parent().parent().attr('id').replace('img_',''),
                success: function(data){

                    if(data=='OK'){
                        
                        span.parent().parent().fadeOut('medium', function() {
						    // Animation complete.
						    span.parent().parent().remove(); // se quita el elemento
						    
						    var order = $("#ul_imagenes").sortable("serialize") + '&action=actualizar_orden';
								
					    	$.ajax({
		                        type:"POST",
		                        url: "<?php echo CController::createUrl('producto/orden'); ?>",
		                        cache:false,
		                        data: order,
		                        success: function(data){
		
		                            $("#respuesta").empty();
		                            $("#respuesta").html(data);
		                        }
		                    });
					    
					  });
                    
                    }else{

                    }
                    
                
                    
               }
            });
			
        })

        $(function() {
            $("#ul_imagenes").sortable({
                opacity: 0.3,
                cursor: 'move',
                update: function() {
 
                    //alert("movi");

                    var order = $(this).sortable("serialize") + '&action=actualizar_orden';
                    //alert(order);

                    $.ajax({
                        type:"POST",
                        url: "<?php echo CController::createUrl('producto/orden'); ?>",
                        cache:false,
                        data: order,
                        success: function(data){

                            $("#respuesta").empty();
                            $("#respuesta").html(data);
                        }
                    });
                }
            });
        });

    });
</script>
<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Imágenes',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Imágenes</small></h1>
  </div>
  <!-- SUBMENU ON --> 
  
  <?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>4)); ?>
  <?php 
  
   Yii::app()->clientScript->registerScript('form_sending', "
            $('#producto-form').submit(function(){
                $('#wrapper_content').addClass('loading');
            });
            ");
  
  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action' => CController::createUrl('Producto/multi', array('id' => $model->id)),
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
  
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form enctype="multipart/form-data" class="form-stacked personaling_form" id="registration-form" action="/aiesec/user/registration?template=1" method="post">
          <fieldset>
            <legend>Subir imágenes del producto: </legend>
            <div class="well well-large">
              <?php
            	$this->widget('CMultiFileUpload', array(
                'name' => 'url',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'El archivo está duplicado.', // useful, i think
                'denied' => 'Tipo de archivo invalido.', // useful, i think
            ));
			
			?>
              <?php echo $form->error($imagen, 'url'); ?>
              <div class="margin_top_small">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'label'=>'Subir imagen',
		)); ?>
              </div>
            </div>
            <?php $this->endWidget(); ?>
          </fieldset>
        </form>
        <hr/>
        <div class="well well-small">
          <h3>Instrucciones:</h3>
          <ul>
            <li> Ten en cuenta que la primera imagen será la principal del producto</li>
            <li>Arrastra las imagenes para organizarlas</li>
          </ul>
        </div>
        <div class="clearfix productos_del_look">
          <?php
			$imagenes = $model->imagenes;

			if (count($imagenes) > 0) {
			
			$contador = 0;
        	$lis = array();

	        foreach ($imagenes as $img) {
	            $contador++;
				//Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url)
	            $lis['img_' . $img->id] =
	            		'<div >'.
	                    CHtml::image($img->getUrl(array('type'=>'thumb')), "Imagen " . $img->id, array("width" => "150", "height" => "150")) . 
	                    '<span>X</span>'.
	                    '<div class="metadata_top">'.
	                    CHtml::dropDownList('color_id'.$img->id,$img->color_id,$model->getColores(),array('prompt'=>'Seleccione','class'=>'span2 colores','onchange'=>'js:addColor('.$img->id.')')).
	                    '</div></div>'; 
						

			}			


	        $this->widget('zii.widgets.jui.CJuiSortable', array(
	            'items' => $lis,
	            'options' => array(
	                'delay' => '100',
	            ),
	            'htmlOptions' => array(
	                'id' => 'ul_imagenes',
	                'class' => 'grid_imagenes',
	            )
	        ));
	        ?>
          <?php
			}
        
        ?>
        </div>
      </div>
      </ul>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR OFF --> 
        <script > 
			// Script para dejar el sidebar fijo Parte 1
			function moveScroller() {
				var move = function() {
					var st = $(window).scrollTop();
					var ot = $("#scroller-anchor").offset().top;
					var s = $("#scroller");
					if(st > ot) {
						s.css({
							position: "fixed",
							top: "70px"
						});
					} else {
						if(st <= ot) {
							s.css({
								position: "relative",
								top: "0"
							});
						}
					}
				};
				$(window).scroll(move);
				move();
			}
		</script>
        <div id="scroller-anchor"></div>
        <div id="scroller">
          <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'label'=>'Guardar',
		)); ?>
          <ul class="nav nav-stacked nav-tabs margin_top">
            <li><a href="#" title="Guardar y Siguiente" id="limpiar">Guardar y avanzar</a></li>
            <li><a href="#" title="Guardar y crear nuevo producto" id="limpiar">Guardar y crear nuevo producto</a></li>
          </ul>
        </div>
      </div>
      <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });
		</script> 
      <!-- SIDEBAR OFF --> 
      
    </div>
  </div>
</div>
<!-- /container --> 
<script type="text/javascript">
// here is the magic
function addColor(id)
{
	var image_id = id;
	var color_id = $("#color_id"+id).val(); 
	//alert($(this).val());
    <?php echo CHtml::ajax(array(
            'url'=>array('producto/imagenColor'),
           // 'data'=> "js:$(this).serialize()",
           'data' => array('id'=>'js:image_id','color_id'=>'js:color_id'),
            'type'=>'post',
            'dataType'=>'json',
           /*
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
                    $('#dialogColor div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogColor').modal('hide') \",3000);
                }
 
            } ",*/
            ))?>;
    return false; 
 
}
 
</script> 
