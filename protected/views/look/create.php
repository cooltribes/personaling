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
    if (this.innerHTML.indexOf("Crea tus Looks aqui") >=0)
    	this.innerHTML = e.dataTransfer.getData('text/html');
    else
    	this.innerHTML += e.dataTransfer.getData('text/html');
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
  <div class="clearfix margin_bottom_medium">
  	 
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Publicar',
	    'type'=>'danger',

	    'htmlOptions'=> array(
		     // 'data-toggle'=>'modal',
			//	'data-target'=>'#dialogPublicar',
				'class'=>'pull-right margin_left_small', 
		        'onclick'=>"{addPublicar();}"
		       ),	    
	)); ?>  	
	
  	<a href="#" title="Guardar borrador" class="btn pull-right">Guardar borrador</a> 
  </div><hr/>
  <div class="row">
    <section class="span8">
      <div class="well">
        <h4> Titulo de la Campana  - Desde 00/00/2012 hasta 00/00/2012 </h4>
        <a href="#" title="Borrar" class="btn"><i class="icon-trash"></i></a> <a href="#" title="Flip" class="btn"><i class="icon-resize-horizontal"></i> Flip</a> <a href="#" title="Copiar" class="btn">Copiar</a> <a href="#" title="Traer al frente" class="btn"> Traer al frente</a> <a href="#" title="Llevar atrás" class="btn"> Llevar atrás</a>
        <hr/>
        <!-- CANVAS ON -->
        <div class="well well-large canvas">
          <h1>Crea tus Looks aqui</h1>
          <p>Empieza arrastrando los elementos del panel de la derecha hasta aca. Basta con hacer clic sobre ellos y moverlos hasta este recuadro</p>
        </div>
        <!-- CANVAS OFF --> 
      </div>
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
              <div class="span2">
                <select class="span2">
                  <option>Buscar por categoria</option>
                  <option>Categoria 1</option>
                  <option>Categoria 2</option>
                  <option>Categoria 3</option>
                </select>
              </div>
              <div class="span2">
                <input name="" type="text" placeholder="Buscar por palabra clave" class="span2">
              </div>
              <div class="span1"> <a href="#" title="cuadricula"></a> <a href="#" title="cuadritula"><i class="icon-th"></i></a> <a href="#" title="lista"><i class="icon-th-list"></i></a> </div>
            </div>
            <hr/>
            <div id="div_categorias">
            <?php $this->renderPartial('_view_categorias',array('categorias'=>$categorias)) ?>
            </div>
            <!--
            <ul class="thumbnails">

              
              <li class="span2" > 
              	<div class=" column" draggable="true"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Tops</p>
                </div>
                </div>
              </li>
              <li class="span2 column"  draggable="true"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Franelas</p>
                </div>
              </li>
              <li class="span2 column"  draggable="true"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Shorts</p>
                </div>
              </li>
              <li class="span2 column"  draggable="true"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Pantalones</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Tops</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Franelas</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Shorts</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Pantalones</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Tops</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Franelas</p>
                </div>
              </li>
              <li class="span2 column"> <a class="thumbnail" href="#"> <img alt="180" src="http://placehold.it/180"> </a>
                <div class="caption">
                  <p>Shorts</p>
                </div>
              </li>
            
            </ul>
           
            <div class="pagination pagination-small pull-right">
              <ul>
                <li class="disabled"><span>&laquo;</span></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">Next</a></li>
              </ul>
            </div>
            -->
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
	--></div>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'dialogPublicar')); ?>	
<div class="divForForm"></div> 
<?php $this->endWidget(); ?>

<!------------------- MODAL WINDOW OFF ----------------->
<script type="text/javascript">
// here is the magic
function addPublicar()
{
	var productos_id = '';
	$(".canvas input").each(function(item){
		productos_id += $(this).val()+',';
	});
	alert(productos_id);
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
