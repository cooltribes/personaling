<?php
/* @var $this TiendaController */

$this->breadcrumbs=array(
	'Tienda',
);
?>

<div class="container margin_top" id="tienda">
  <div class="row">
    <?php
	$template = '
    <div class="span9 tienda_productos">
      <div class="row">
		{items}
      </div>
      {pager}
    </div>
    ';
	
	$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datos',
	    'template'=>$template,
	));    
	?>
    <div class="span3">
      <div class="shadow_1"> 
        <!-- para filtrar por seleccion de categoria -->
        <?php
	Yii::app()->clientScript->registerScript('cate1',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('#cate1').change(function(){
			ajaxRequest = $('#cate1').serialize();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('tienda/filtrar') . "',
				data: ajaxRequest}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	?>
        <form id="formu" class="no_margin_bottom form-search">
          <select id="cate1" class="span3" name="cate1">
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
          <p></p>
          <div class="input-append">
            <input id="busqueda" name="busqueda" class="" type="text" placeholder="Buscar por palabras clave">
            <button id="boton_search" class="btn btn-danger" type="button"><i class="icon-search icon-white"></i></button>
          </div>
        </form>
        <hr/>
        
        <!-- para filtrar por campo de texto -->
    <?php
	Yii::app()->clientScript->registerScript('busqueda',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('#boton_search').click(function(){
			ajaxRequest = $('#formu').serialize();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('tienda/filtrar') . "',
				data: ajaxRequest}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	?>
	
	
	<!-- para filtrar por color -->
    <?php
	Yii::app()->clientScript->registerScript('color',
		"var ajaxUpdateTimeout;
		var idColor; 
		$('.color').click(function(){
			idColor = $(this).attr('id');
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('tienda/colores') . "',
				data: {'idColor':idColor}
				}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	?>
        <div class="tienda_iconos" id="uno">
          <?php $this->renderPartial('_view_categorias',array('categorias'=>$categorias)) ?>
        </div>
        <hr/>
        <h5>Buscar por colores</h5>
        <div class="clearfix tienda_colores">
			 <?php $this->renderPartial('_view_colores',array('categorias'=>$categorias)) ?>
        </div>
        <hr/>
        <h5>Looks con estas prendas:</h5><br/>
       		<div id="looks" class="clearfix">
       		</div>
        </div>
    </div>
  </div>
</div>

<script> 

$(document).ready(function(){	
   	
   	var todos = new Array();
   	var dosel = new Array();
   		
   	$(".ids").each( function(clave,valor) {
		todos.push( $(this).attr("value") ); // agrego cada uno a un array
	});	
	
	var uno;
	
	for(uno=0; uno<2; uno++)
	{
		dosel.push(randomFrom(todos));	
	}
	
	// alert(todos[dosel[0]]);
	// con esto ya tengo dos productos random de todos los que se estan mostrando
	
			$.ajax({
	        type: "post",
	        url: "imageneslooks", // action 
	        dataType:"json",
	        data: { 'pro1':todos[dosel[0]], 'pro2':todos[dosel[1]]}, 
	        success: function (data) {
				
				if(data.status=="ok")
				{

					$('#looks.clearfix').prepend(data.datos);
				//	$("#looks").html(cont); // cambiando el div
					
				}
					
	       	}//success
	       })
	
	
});
	
function randomFrom(arr){

    var random = Math.floor(Math.random() * arr.length);
    return random;
    
}

</script>