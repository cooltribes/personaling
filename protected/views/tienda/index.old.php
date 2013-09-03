<?php
	/* @var $this TiendaController */
	//$this->breadcrumbs=array(
	//'Tienda',
	//);
?>
<div class="page-header">
<h1>Tienda</h1>
</div>
<div class="margin_top" id="tienda">
  <div class="row">

<!-- FILTROS MOBILE ON -->
	<div class="visible-phone row-fluid margin_bottom_medium">
		<h4>Buscar por:</h4>
			<select class="span12">
				<option>Categorias</option>
				<option>Categorias</option>
				<option>Categorias</option>
			</select>
			<select class="span12">
				<option>Colores</option>
				<option>Colores</option>
				<option>Colores</option>
			</select>
	      
	 </div>
<!-- FILTROS MOBILE OFF -->

<!-- PRODUCTOS ON -->

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
	    'afterAjaxUpdate'=>" function(id, data) {
	    							
						$(document).ready(function() {
						  // Handler for .ready() called.
							  
							var imag;
							var original;
							var segunda;
							
							$('.producto').hover(function(){
								if ($(this).find('img').length > 1){
								$(this).find('img').eq(0).hide();
								
								$(this).find('img').eq(0).next().show();
								}
							},function(){
								if ($(this).find('img').length > 1){
								$(this).find('img').eq(0).show();
								
								$(this).find('img').eq(0).next().hide();
								}
							}); 						
							
						});
	    				
						} ",
	    'template'=>$template,
	));    
	?>
	<!-- PRODUCTOS OFF -->
	
	<!-- FILTROS DESKTOP ON -->

    <div class="span3 hidden-phone">
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
        <form id="formu" class="no_margin_bottom form-search form-horizontal">

          
          <select id="cate1" class="span3" name="cate1">
            <option value="0">Buscar por prenda</option>
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
            <input id="busqueda" name="busqueda" type="text" placeholder="Buscar por palabras clave" width=223px>
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
	
	
	// Codigo para actualizar el list view cuando presionen ENTER
	
	Yii::app()->clientScript->registerScript('query',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		
		$(document).keypress(function(e) {
		    if(e.which == 13) {
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
		    }
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
        <h5 class="hidden-phone">Looks con estas prendas:</h5><br/>
       		<div id="looks" class="clearfix hidden-phone">
       		</div>
        </div>
    </div>
    	<!-- FILTROS DESKTOP OFF -->

  </div>
</div>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

	<?php $this->endWidget(); ?>

<script> 

$(document).ready(function(){	
   	
   	var todos = new Array();
   	var dosel = new Array();
   		
   	$(".ids").each( function(clave,valor) {
		todos.push( $(this).attr("value") ); // agrego cada uno a un array
	});	
	
	var uno;
	
	for(uno=0; uno<4; uno++)
	{
		dosel.push(randomFrom(todos));	
	}
	
	// alert(todos[dosel[0]]);
	// con esto ya tengo dos productos random de todos los que se estan mostrando
	
			$.ajax({
	        type: "post",
	        url: "imageneslooks", // action 
	        dataType:"json",
	        data: { 'pro1':todos[dosel[0]], 'pro2':todos[dosel[1]], 'pro3':todos[dosel[2]], 'pro4':todos[dosel[3]]}, 
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

    <!-- Button to trigger modal -->
    
     
    <!-- Modal 
    <div id="myModal" class="modal hide tienda_modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Nombre del producto</h3>
    </div>
    <div class="modal-body">
   
   <div class="row-fluid">
   <div class="span7"><div class="carousel slide" id="myCarousel">
                <ol class="carousel-indicators">
                  <li class="" data-slide-to="0" data-target="#myCarousel"></li>
                  <li data-slide-to="1" data-target="#myCarousel" class="active"></li>
                  <li data-slide-to="2" data-target="#myCarousel" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item">
                    <img alt="Nombre del producto" src="http://www.personaling.com/site/images/producto/54/149_orig.jpg" width="450px" height="450px" />
                    
                  </div>
                  <div class="item active">
                          <img alt="Nombre del producto" src="http://www.personaling.com/site/images/producto/25/129_orig.jpg"  width="450px" height="450px" />
                    
                  </div>
                  <div class="item">
                <img alt="Nombre del producto" src="http://www.personaling.com/site/images/producto/15/80.jpg"  width="450px" height="450px" />
                   
                  </div>
                </div>
                <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>
                <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>
              </div></div>
              <div class="span5">
          <div class="row-fluid call2action">
            <div class="span7">
              <h4 class="precio"><span>Subtotal</span> Bs. 
              	150</h4>
            </div>
            <div class="span5">
              	<a class="btn btn-warning btn-block" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a>
             
            </div>
          </div>
          <p class="muted t_small CAPS">Selecciona Color y talla </p>
          
          <div class="row-fluid">
            <div class="span6">
              <h5>Colores</h5>
              <div class="clearfix colores" id="vCo">
              	<div title="Rojo" class="coloress" style="cursor: pointer" id="8"><img src="/site/images/colores/C_Rojo.jpg"></div>              </div>
            </div>
            <div class="span6">
              <h5>Tallas</h5>
              <div class="clearfix tallas" id="vTa">
              	<div title="talla" class="tallass" style="cursor: pointer" id="10">S</div>         	     	
              </div>
            </div>
          </div>
          
          
              
              </div>
              
              </div>
   
   
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
    </div>
    -->

    
<script>

$(document).ready(function() {
  // Handler for .ready() called.
  
	var imag;
	var original;
	var segunda;

	$('.producto').hover(function(){		
		if ($(this).find("img").length > 1){
		$(this).find("img").eq(0).hide();
		
		$(this).find("img").eq(0).next().show();
		}
	},function(){
		if ($(this).find("img").length > 1){
		$(this).find("img").eq(0).show();
		
		$(this).find("img").eq(0).next().hide();
		}
	});
	
});
	
</script>