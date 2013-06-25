<?php
$this->breadcrumbs=array(
	'Looks'=>array('admin'),
	'Crear',
);

?>
<style>
.column.over {
	border: 1px dashed #000;
}
.canvas.over {
	border: 1px dashed #000;
}
</style>
<script language="JavaScript">
var dragSrcEl = '';
function handleDragStart(e) {
	
  this.style.opacity = '0.4';  // this / e.target is the source node.
   dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
  if (this.id.substring(0,12) == "div_producto"){
  	var datos = this.id.substring(12).split('_'); 
  	e.dataTransfer.setData('producto_id', datos[0]);
  	e.dataTransfer.setData('color_id', datos[1]);
} else {
	var datos = this.id.substring(10); 
  	e.dataTransfer.setData('adorno_id', datos);
}
  
  e.dataTransfer.setData("mouse_position_x",e.clientX - e.target.offsetLeft ); // coordenadas del mouse donde agarre el div
  e.dataTransfer.setData("mouse_position_y",e.clientY - e.target.offsetTop  );
  
}
function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
  this.classList.add('over');
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}
function handleDrop(e) {

	var mouse_position_x = e.dataTransfer.getData("mouse_position_x");
    var mouse_position_y = e.dataTransfer.getData("mouse_position_y");
    x = e.clientX - e.currentTarget.offsetLeft - mouse_position_x;
    y = e.clientY - e.currentTarget.offsetTop - mouse_position_y;

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the column we dropped on.
    //dragSrcEl.innerHTML = this.innerHTML;
    var contenedor = this;
    if (e.dataTransfer.getData('color_id')){
    	var urlVar = "<?php echo Yii::app()->createUrl('producto/getImage'); ?>";
    	var dataVar = {'id':e.dataTransfer.getData('producto_id'),'color_id':e.dataTransfer.getData('color_id')};
    }else{
    	var urlVar = "<?php echo Yii::app()->createUrl('adorno/getImage'); ?>";
    	var dataVar = {'id':e.dataTransfer.getData('adorno_id')}
    }
    
    $.ajax({
	  url: urlVar,
	  data: dataVar
	}).done(function( html ) {
		
		// alert(html);

		nuevo_objeto = $(html);
		nuevo_objeto.css('position','absolute');
		nuevo_objeto.css('top',y);
		nuevo_objeto.css('left',x);
		//nuevo_objeto.find('img').unwrap();
		nuevo_objeto.find('img').attr('id','img'+nuevo_objeto.attr('id'));
		nuevo_objeto.append('<span>x</span>');
		
		//alert(nuevo_objeto.html());
		var ident = nuevo_objeto.find('img').attr('src');
			
	$('<img/>').attr('src', ident).load(function() {
		    
		    if (contenedor.innerHTML.indexOf("Crea tus Looks aqui") >=0)
				$(contenedor).html(	nuevo_objeto );
		    else
		    	$(contenedor).append(nuevo_objeto);
		    	
			//Hace draggable al obejto	
			$(".new",contenedor).draggable( {
		    cursor: 'move',
		    containment: 'document',
		    start: function( event, ui ) { 
		    	ui.helper.siblings().css('z-index',9); 
		    	ui.helper.css('z-index',10); 
		    }
		   // stop: handleDragStop
			});
		
			$("span",contenedor).last().click(function(){
		  		$(this).parent().remove();
		  	});
		  	// Hace resizable al objeto
		  	var height = nuevo_objeto.find('img').attr('height');
		  	var width = nuevo_objeto.find('img').attr('width');
		  	
		  	$("img",contenedor).last().resizable({
		    	aspectRatio: width/height
		  	});
	 });
	    
});
    //alert(e.dataTransfer.getData('producto_id'));
    //alert(e.dataTransfer.getData('text/html'));
   	//nuevo_objeto = $(e.dataTransfer.getData('text/html'));
   	
    
  }

  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.
var cols = document.querySelectorAll('.column');
  [].forEach.call(cols, function (col) {
    col.classList.remove('over');
    col.style.opacity = '1';
  });
}
$(document).ready(function() {

/*
var cols = document.querySelectorAll('.column');
var i = 0;
while (i <  cols.length) {
 col = cols[i];

  col.addEventListener('dragstart', handleDragStart, false);
  //col.addEventListener('dragenter', handleDragEnter, false);
  col.addEventListener('dragover', handleDragOver, false);
  //col.addEventListener('dragleave', handleDragLeave, false);  
  //col.addEventListener('drop', handleDrop, false);
  col.addEventListener('dragend', handleDragEnd, false);  
  i++;
}
*/
var canvas = document.querySelectorAll('.canvas');
i = 0;
while (i <  canvas.length) {
 col = canvas[i];

  col.addEventListener('dragstart', handleDragStart, false);
  col.addEventListener('dragenter', handleDragEnter, false);
  col.addEventListener('dragover', handleDragOver, false);
  col.addEventListener('dragleave', handleDragLeave, false);  
  col.addEventListener('drop', handleDrop, false);
  col.addEventListener('dragend', handleDragEnd, false);  
 
  i++;
}

});
/*
[].forEach.call(cols, function(col) {
	alert("lore");
  col.addEventListener('dragstart', handleDragStart, false);
});	
*/
</script>
<div class="container margin_top" id="crear_look">
  <div class="page-header">
    <h1>Crear look</h1>
    <!-- FLASH ON -->
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>
    <!-- FLASH OFF --> 
    
  </div>
  <div class="clearfix margin_bottom_medium">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Publicar',
	    'type'=>'danger',
		'buttonType' => 'ajaxSubmit',
	    'htmlOptions'=> array(
		     // 'data-toggle'=>'modal',
			//	'data-target'=>'#dialogPublicar',
				'class'=>'pull-right margin_left_small', 
		        'onclick'=>"{addPublicar(1);}"
		       ),	    
	)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Guardar borrador',
	   // 'type'=>'danger',

	    'htmlOptions'=> array(
		     // 'data-toggle'=>'modal',
			//	'data-target'=>'#dialogPublicar',
				'class'=>'pull-right', 
		        'onclick'=>"{addPublicar(0);}"
		       ),	    
	)); ?>
  </div>
  <hr/>
  <div class="row">
    <section class="span8">
      <div class="well">
        <h4> Titulo de la Campana  - Desde 00/00/2012 hasta 00/00/2012 </h4>
        <a href="#" title="Borrar" class="btn"><i class="icon-trash"></i></a> <a href="#" title="Flip" class="btn"><i class="icon-resize-horizontal"></i> Flip</a> <a href="#" title="Copiar" class="btn">Copiar</a> <a href="#" title="Traer al frente" class="btn"> Traer al frente</a> <a href="#" title="Llevar atrás" class="btn"> Llevar atrás</a>
        <hr/>
        <!-- CANVAS ON -->
        <div class="well well-large canvas" style="overflow:hidden;position: relative;width: 670px;height: 670px">
          <?php 
        
        if (count($model->lookhasproducto)){
        	?>
          <?php
              foreach($model->lookhasproducto as $hasproducto){
              	$producto = $hasproducto->producto;
				$tallacolores=Preciotallacolor::model()->findAllBySql(
				'SELECT * FROM tbl_precioTallaColor WHERE producto_id=:producto_id AND cantidad >= :cantidad GROUP BY color_id',
				array(':cantidad'=>1, ':producto_id'=>$producto->id)
				);
				
				
              ?>
          <div class="new" id="div<?php echo $producto->id."_".$hasproducto->color_id; ?>" style="position: absolute; top: <?php echo $hasproducto->top;?>px; left: <?php echo $hasproducto->left;?>px;">
            <?php
					if ($producto->mainimage)
					$image = CHtml::image(Yii::app()->baseUrl . $producto->mainimage->url, "Imagen", array("width" => $hasproducto->width, "height" => $hasproducto->height));
					else 
					$image = CHtml::image("http://placehold.it/180");	
					echo $image;
					//echo $hasproducto->width.'/'.$hasproducto->height;
					?>
            <input type="hidden" name="producto_id" value="<?php echo $producto->id; ?>">
            <input type="hidden" name="color_id" value="<?php echo $hasproducto->color_id; ?>">
            <span>x</span> </div>
          <?php 
              	$script = "	$('#div".$producto->id."_".$hasproducto->color_id." ').draggable( {
    cursor: 'move',
    containment: 'document',
  
	} ); 
  $('#div".$producto->id."_".$hasproducto->color_id." > span').last().click(function(){
  	
  	$(this).parent().remove();
  });   
$('#div".$producto->id."_".$hasproducto->color_id." > img').on('load', function () { $(this).resizable({
      aspectRatio: 1
    });	
    });	
    
 ";
              	Yii::app()->clientScript->registerScript('drag'.$producto->id."_".$hasproducto->color_id,$script);
              	?>
          <?php 
				} 
				?>
        <?php
        	
        foreach($model->lookHasAdorno as $hasAd){
	        $adorno = Adorno::model()->findByPk($hasAd->adorno_id);
				
			?>
	        <div class="new ui-draggable" id="adorno<?php echo $adorno->id; ?>" style="position: absolute; top: <?php echo $hasAd->top;?>px; left: <?php echo $hasAd->left;?>px;">
	        
	        <?php
				$image = CHtml::image(Yii::app()->baseUrl.'/images/adorno/'.$adorno->path_image, $adorno->nombre, array("width" => $hasAd->width, "height" => $hasAd->height));				
				echo $image;
			?>
	        
	        <input type="hidden" name="adorno_id" value="<?php echo $adorno->id; ?>">
	        <span>x</span>
	        </div>
	        <?php 
	        
	        $script = "	$('#adorno".$adorno->id."').draggable( {
	    		cursor: 'move',
	   	 		containment: 'document',
	  			} ); 
	 
	 		$('#adorno".$adorno->id." > span').last().click(function(){
	 			$(this).parent().remove();
	  		});
			   
			$('#adorno".$adorno->id." > img').on('load', function () {
				$(this).resizable({
					aspectRatio: 1
				});	
		    });	
		 	";
	        
	        Yii::app()->clientScript->registerScript('drag'.$adorno->id,$script);
        } // foreach de adornos

        	
        } else {
        	?>
          <h1>Crea tus Looks aqui</h1>
          <p>Empieza arrastrando los elementos del panel de la derecha hasta aca. Basta con hacer clic sobre ellos y moverlos hasta este recuadro</p>
          <?php        	
        }
		?>
        </div>
        
        <!-- CANVAS OFF --> 
      </div>
      <!--
      <form method="POST" id="form_productos">
      	<input id="productos_id" type="hidden" value="1,2,3,4" />
      </form>
      -->
      <?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'form_productos',
    //'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
)); ?>
      <?php echo CHtml::hiddenField('productos_id'); ?> <?php echo CHtml::hiddenField('colores_id'); ?> <?php echo CHtml::hiddenField('left'); ?> <?php echo CHtml::hiddenField('top'); ?>
      <?php echo CHtml::hiddenField('width'); ?> <?php echo CHtml::hiddenField('height'); ?> <?php echo CHtml::hiddenField('tipo'); ?>
      
      <?php echo CHtml::hiddenField('adornos_id'); ?>
      <?php echo CHtml::hiddenField('left_a'); ?>
      <?php echo CHtml::hiddenField('top_a'); ?>
      <?php echo CHtml::hiddenField('width_a'); ?>
      <?php echo CHtml::hiddenField('height_a'); ?>

      <?php $this->endWidget(); ?>
    </section>
    <section class="span4">
      <div class="">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab" title="Todos los productos">Productos</a></li>
          <li><a href="#tab2" data-toggle="tab" title="Productos que ya has utilizado para hacer otros looks">Adornos</a></li>
          <li><a href="#tab3" data-toggle="tab" title="Looks que has hecho">Tus Looks</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="row">
              <form id="formu" class="no_margin_bottom form-search">
                <div class="span2">
                  <select id="padreId" class="span2" name="padreId">
                    <option value="0">Buscar por Categoria</option>
                    <?php 

	$cat = Categoria::model()->findAllByAttributes(array('padreId'=>'1',),array('order'=>'nombre ASC'));
	nodos($cat); 
	
	function nodos($items){
		
		foreach ($items as $item){
			
			if($item->padreId==1)
			{
				echo "<option value='".$item->id."' name='".$item->id."'>"; // cada option tiene entonces el id de su categoria
				echo $item->nombre;
				echo "</option>";
			}
			else {
				echo "<option value='".$item->id."' name='".$item->id."'> &nbsp;&nbsp;&nbsp;";
				echo $item->nombre;
				echo "</option>";
			}
			
			if ($item->hasChildren()){
				nodos($item->getChildren());
			}
		}	
		return 1;
	}
?>
                  </select>
        <?php
        	$marcas = Marca::model()->findAll(array('order'=>'nombre'));
        	
        ?>         
                  
        <!-- marcas -->
        <div class="margin_top_small margin_bottom_small">
        	<select id="marcas" class="span2" name="marcas">
        		<option selected>Buscar por Marca</option>
        		<?php
        			foreach($marcas as $uno){
        				echo "<option value='".$uno->id."'> ".$uno->nombre." </option>";
        			}
        		?>
        	</select>	
        </div>
         
	<?php
	Yii::app()->clientScript->registerScript('marca',
		"
		$('#marcas').change(function(){". CHtml::ajax(
						 
			array( // ajaxOptions
				'url'=>Yii::app()->createUrl( 'look/marcas'),
				'type' => 'POST',
				'beforeSend' => "function( request )
				{
					// Set up any pre-sending stuff like initializing progress indicators
				}",
				'success' => "function( data )
				{
				// handle return data
				//alert( data );
					$('#div_categorias').html(data);
				}",
					'data' => "js:$('#marcas').serialize()",
				),
				array( //htmlOptions
					'href' => Yii::app()->createUrl( 'look/marcas' ),
					'class' => 'thumbnail',
					
					'draggable'=>"false",
				)
			).
			
		"return false;
		});",CClientScript::POS_READY
	);
	
	?>
                  
                  
                </div>
                <?php
	Yii::app()->clientScript->registerScript('busqueda',
		"
		$('#padreId').change(function(){". CHtml::ajax(
						 
						  array( // ajaxOptions
						    'url'=>Yii::app()->createUrl( 'look/categorias'),
						    'type' => 'POST',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                  }",
						    'data' => "js:$('#formu').serialize()",
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						    'class' => 'thumbnail',
						  
						    'draggable'=>"false",
						  )
						).
			
		"return false;
		});",CClientScript::POS_READY
	);
	
	?>
                <div class="span2"> 
                
                <div class="dropdown">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
Filtrar por Colores <span class="caret"></span></a>
  <!-- Link or button to toggle dropdown -->
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
  <?php 
  $colores = Color::model()->findAll();
  foreach($colores as $color){
  	$imagen = CHtml::image(Yii::app()->baseUrl.'/images/colores/'.$color->path_image,$color->valor,array('height'=>'20'));
	  
  	echo '<li>';
  	
	echo CHtml::ajaxLink(
						  $imagen.'  '.$color->valor,
						  Yii::app()->createUrl( 'look/colores'),
						  array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                  }",
						    'data' => array( 'color_id' => $color->id, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						   // 'class' => 'thumbnail',
						    'id' => 'colores'.$color->id,
						    'draggable'=>"false",
						    'tabindex'=>'-1',
						  )
						);
	echo '</li>';
  }
  ?>	
  </ul>
</div>

</div>
		                        
                <!-- <div class="span1"> <a href="#" title="cuadricula"></a> <a href="#" title="cuadritula"><i class="icon-th"></i></a> <a href="#" title="lista"><i class="icon-th-list"></i></a> </div>-->
              </form>
            </div>
            <hr/>
            <div id="div_categorias">
              <?php $this->renderPartial('_view_categorias',array('categorias'=>$categorias)) ?>
            </div>
          </div>
          <div class="tab-pane" id="tab2">
            <p>
        <div id="div_prendas">
              <?php $this->renderPartial('_view_adornos',array('productos'=>Adorno::model()->findAll())) ?>
            </div>
            	
            </p>
          </div>
          <div class="tab-pane" id="tab3">
            <p>También se cargaria por Ajax (lo que se tenga que cargar)</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 --> 
<!--
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	-->
</div>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'dialogPublicar')); ?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>

<!------------------- MODAL WINDOW OFF -----------------> 
<script type="text/javascript">

	function actualizar()
	{
		alert("llegó");
	}


// here is the magic
function addPublicar(tipo)
{
	var productos_id = '';
	var color_id = '';
	var left = '';
	var top = '';
	var height = '';
	var width = ''; 
	var count = 0;
	
	var adornos_id = '';
	var left_a = '';
	var top_a = '';
	var height_a = '';
	var width_a = '';
	var count_a = 0;
	
	$('.canvas input[name="producto_id"]').each(function(item){
		productos_id += $(this).val()+',';
		color_id += $(this).next().val()+',';
		position = $(this).parent().position();
		image = $(this).parent().find('img');
		width += image.width() + ',';
		height += image.height() + ',';
		left += position.left + ',';
		top += position.top + ',';
		count++;
	});
	
	// para los adornos
	
	$('.canvas input[name="adorno_id"]').each(function(item){
		adornos_id += $(this).val()+',';
		position = $(this).parent().position();
		image = $(this).parent().find('img');
		width_a += image.width() + ',';
		height_a += image.height() + ',';
		left_a += position.left + ',';
		top_a += position.top + ',';
		count_a++;
	});
	
	productos_id = productos_id.substring(0, productos_id.length-1);
	adornos_id = adornos_id.substring(0, adornos_id.length-1);
	//alert(productos_id);
	//alert(left);
	//productos_id = "1,2,3,4";
	
	$("#productos_id").val(productos_id);
	$("#colores_id").val(color_id.substring(0, color_id.length-1));
	$("#left").val(left.substring(0, left.length-1));
	$("#top").val(top.substring(0, top.length-1));
	$("#height").val(height.substring(0, height.length-1));
	$("#width").val(width.substring(0, width.length-1));
	$("#tipo").val(tipo);
	
	// ahora los de los adornos
	$("#adornos_id").val(adornos_id);
	$("#left_a").val(left_a.substring(0, left_a.length-1));
	$("#top_a").val(top_a.substring(0, top_a.length-1));
	$("#height_a").val(height_a.substring(0, height_a.length-1));
	$("#width_a").val(width_a.substring(0, width_a.length-1));
	
	//count = 6;
	//alert(productos_id);
	if (count >= 3){
		$("#form_productos").submit();
	} else {
		bootbox.alert("Debes tener al menos seis productos");
	}

    return false; 
}
 
</script> 
