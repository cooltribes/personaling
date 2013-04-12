<?php
/* @var $this TiendaController */

$this->breadcrumbs=array(
	'Tienda',
);
?>

<div class="container margin_top" id="tienda">
  <div class="row">
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
          <p></p>
          <div class="input-append">
            <input id="busqueda" name="busqueda" class="" type="text" placeholder="Buscar por palabras clave">
            <button id="boton_search" class="btn btn-warning" type="button"><i class="icon-search icon-white"></i></button>
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
        <div class="tienda_iconos" id="uno">
          <?php $this->renderPartial('_view_categorias',array('categorias'=>$categorias)) ?>
        </div>
        <hr/>
        <h5>Buscar por colores</h5>
        <div class="clearfix tienda_colores"> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> <img src="http://placehold.it/30x30" /> </div>
        <hr/>
        <h5>Looks con estas prendas:</h5>
        <img src="http://placehold.it/270x200" /> </div>
    </div>
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
  </div>
</div>
