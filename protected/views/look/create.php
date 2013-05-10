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
  // this/e.target is current target element.

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the column we dropped on.
    //dragSrcEl.innerHTML = this.innerHTML;
    
   	nuevo_objeto = $(e.dataTransfer.getData('text/html'));
	nuevo_objeto.css('position','absolute');
	nuevo_objeto.css('top','0');
	nuevo_objeto.css('left','0');
	//nuevo_objeto.find('img').unwrap();
	nuevo_objeto.find('img').attr('id','img'+nuevo_objeto.attr('id'));
	nuevo_objeto.append('<span>x</span>');
	//alert(nuevo_objeto.html());
    if (this.innerHTML.indexOf("Crea tus Looks aqui") >=0)
    	$(this).html(	nuevo_objeto );
    else
    	$(this).append(	nuevo_objeto );
    	
	$(".new",this).draggable( {
    cursor: 'move',
    containment: 'document',
   // stop: handleDragStop
	} );
   
  //.wrap('<div class="new" />')
  //alert($("img",this).last().attr('src'));
  $("span",this).last().click(function(){
  	//alert('x');
  	$(this).parent().remove();
  });
  $("img",this).last().resizable({
      aspectRatio: 1
    });    	
//"<h1>Crea tus Looks aqui</h1><p>Empieza arrastrando los elementos del panel de la derecha hasta aca. Basta con hacer clic sobre ellos y moverlos hasta este recuadro</p>"    
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
      <?php echo CHtml::hiddenField('productos_id'); ?> <?php echo CHtml::hiddenField('colores_id'); ?> <?php echo CHtml::hiddenField('left'); ?> <?php echo CHtml::hiddenField('top'); ?> <?php echo CHtml::hiddenField('width'); ?> <?php echo CHtml::hiddenField('height'); ?> <?php echo CHtml::hiddenField('tipo'); ?>
      <?php $this->endWidget(); ?>
    </section>
    <section class="span4">
      <div class="">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab" title="Todos los productos">Productos</a></li>
          <li><a href="#tab2" data-toggle="tab" title="Productos que ya has utilizado para hacer otros looks">Antes Usados</a></li>
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

	$cat = Categoria::model()->findAllByAttributes(array('padreId'=>'1',));
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
                <div class="span2"> <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> Action <span class="caret"></span> </a>
                  <ul class="dropdown-menu">
                    <li>COlor <img src="http://placehold.it/90"/></li>
                  </ul>
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
            <p>Se cargaria por Ajax (lo que se tenga que cargar)</p>
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
	productos_id = productos_id.substring(0, productos_id.length-1);
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
	//count = 6;
	//alert(productos_id);
	if (count >= 3){
		
		$("#form_productos").submit();
	} else {
		bootbox.alert("Debes tener al menos seis productos");
		
		
	}
	
    <?php
    /* 
    	echo CHtml::ajax(array(
            'url'=>array('look/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogPublicar div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogPublicar div.divForForm form').submit(addPublicar);
                }
                else
                {
                    $('#dialogPublicar div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogPublicar').modal('hide') \",3000);
                }
 
            } ",
            )) 
          */  
            ?>;
    return false; 
 
}
 
</script> 
