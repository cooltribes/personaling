<?php 
//$this->breadcrumbs=array(
//	'Looks'=>array('admin'),
//	'Crear',
//);

?>
<style>
.column.over {
	border: 1px dashed #000;
}
.canvas.over {
	border: 1px dashed #000;
}
.content-loading  { 
  background: white url('<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>') center center no-repeat; 
}
.ocultar {
	display:none;
}
</style>
<script language="JavaScript">
 

var dragSrcEl = '';
function handleDragStart(e) {
	
$('.canvas').css('background',"white url('<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>') center center no-repeat");
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
    if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }
  this.classList.add('over');
  return false;
}

function handleDragLeave(e) {
	
   if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }
  this.classList.remove('over');  // this / e.target is previous target element.
  return false;
}
function handleDrop(e) {
	
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }
	//Calcular la posicion del scroll

	if ($('#tab1').hasClass('active')){
		scrollTop = $('#div_categorias').scrollTop();
	} else {
		scrollTop = $('#div_prendas').scrollTop();	
	}

	var mouse_position_x = e.dataTransfer.getData("mouse_position_x");
    var mouse_position_y = e.dataTransfer.getData("mouse_position_y");
    x = e.clientX - e.currentTarget.offsetLeft - mouse_position_x;
    y = e.clientY - e.currentTarget.offsetTop - scrollTop - mouse_position_y;
	//alert('scroll: '+$('#div_categorias').scrollTop()+' clientY: '+e.clientY+' OffsetTop: '+e.currentTarget.offsetTop+' mouse: '+mouse_position_y);
	//alert(y);

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
 
  if (dragSrcEl != this) {
  	//console.log('handleDrop='+dragSrcEl);
  	var p_id = e.dataTransfer.getData('producto_id');
    // Set the source column's HTML to the HTML of the column we dropped on.
    //dragSrcEl.innerHTML = this.innerHTML; 
    var contenedor = this;
    if (e.dataTransfer.getData('color_id')){
    	var color_id = e.dataTransfer.getData('color_id');
    	var producto_id = e.dataTransfer.getData('producto_id');
    	
    	var urlVar = "<?php echo Yii::app()->createUrl('site/productoImagenPng'); ?>";
    	urlVar += '/producto/'+producto_id+'/color/'+color_id+'/w/270/h/270';
    	//urlVar = "http://personaling.es:1337/api/imagen/"+e.dataTransfer.getData('producto_id')+"/color/"+e.dataTransfer.getData('color_id');
    	//var dataVar = {'id':e.dataTransfer.getData('producto_id'),'color_id':e.dataTransfer.getData('color_id')};
    }else{
    	var adorno_id = e.dataTransfer.getData('adorno_id');
    	var urlVar = "<?php echo Yii::app()->createUrl('adorno/getImage'); ?>";
    	var dataVar = {'id':e.dataTransfer.getData('adorno_id')}
    }
    /*
    $.ajax({ 
	   dataType: "json",
	  url: urlVar,
	 // data: dataVar
	}).done(function( json ) {
	*/	
		//alert(json);
		//html = '<div class="new" id="div142_22"><img width="270" height="270" src="/develop/images/producto/142/137_thumb.png" alt><input type="hidden" name="producto_id" value="142"><input type="hidden" name="color_id" value="22"></div>';
		//html = '<div class="new" id="div'+json[0].tbl_producto_id+'_'+json[0].color_id+'"><img src="/develop/'+json[0].url+'" alt><input type="hidden" name="producto_id" value="'+json[0].tbl_producto_id+'"><input type="hidden" name="color_id" value="'+json[0].color_id+'"></div>';
		html = '<div class="new" id="div'+producto_id+'_'+color_id+'"><input type="hidden" name="producto_id" value="'+producto_id+'"><input type="hidden" name="color_id" value="'+color_id+'"></div>';
		
		//alert(html);
		nuevo_objeto = $(html);
		nuevo_objeto.css('position','absolute');
		nuevo_objeto.css('top',y);
		nuevo_objeto.css('left',x);
		nuevo_objeto.css('z-index',0);
		//nuevo_objeto.find('img').unwrap();
		var img = new Image();
		//img.attr('id','img'+nuevo_objeto.attr('id'));
		img.onload = function(){

			//alert(this.width + 'x' + this.height);
			$(this).attr('width',this.width);
			$(this).attr('height',this.height);
			$(this).attr('id','img'+nuevo_objeto.attr('id'));

		   // $(".new",contenedor).click( function(){
		   // 	alert('clic');
		    //});	
			
////////////////////////// Hace draggable al objeto	/////////////////////////////////
			$(".new",contenedor).draggable( {
				//axis: 'y', 
				containment: 'parent',
		    cursor: 'move',
		   // containment: 'document',
		    start: function( event, ui ) { 
		    	// calcular el mayor z-index y sumarle uno
		    	var mayor = 0;
		    	ui.helper.siblings().each(function(index){
		    		
		    		if (isNaN($(this).css('z-index')))
		    			compara = 0;
		    		else
		    			compara = $(this).css('z-index');
		    			
		    		if (parseInt(compara) > parseInt(mayor))
		    			mayor = compara;
		    		
		    	});
		    	//alert(mayor);
		    	//ui.helper.css('z-index',parseInt(mayor)+1); 
		    	mayor++;
		    	ui.helper.css('z-index',mayor);
		    	
		    }
		   // stop: handleDragStop
			});
			
/////////////////// EVENTO PARA ROTACION ///////////////////////////////
			$('.rotar',contenedor).draggable({
				
			    handle: '.rotar',
			    opacity: 0.01, 
			    helper: 'clone',
			    drag: function(event, ui){
			        var grados = ui.position.left*-1;
			        if (grados > 360)
			        	grados = grados - 360;
			        var rotateCSS = 'rotate(' + grados + 'deg)';
			
			        $(this).parent().css({
			            '-moz-transform': rotateCSS,
			            '-webkit-transform': rotateCSS
			        });
			    } 
			});
		
			$("span",contenedor).last().click(function(){
		  		$(this).parent().remove();
		  	});
////////////////// Hace resizable al objeto /////////////////////////////
		  	
		  	var height = nuevo_objeto.find('img').attr('height');
		  	var width = nuevo_objeto.find('img').attr('width');
		  	
		  	$("img",contenedor).last().resizable({
		    	aspectRatio: width/height
		  	}).parent('.ui-wrapper').css('margin','0px').click(function(){
		  		$('.seleccionado').removeClass('seleccionado');
		  		$(this).addClass('seleccionado');
		  		
		  	});
		  	
		  	$('.canvas').css('background',"white");
		  	$('.canvas').css('z-index',"0");
		  	$('.eliminar',contenedor).removeClass('ocultar');
		  	$('.rotar',contenedor).removeClass('ocultar');
		  	
		};
		//img.src = '/develop/'+json[0].url;
		img.src = urlVar;
		//
		nuevo_objeto.append(img);
			nuevo_objeto.append('<span class="eliminar ocultar"><i class=" icon-remove"></i></span>');
			nuevo_objeto.append('<div class="rotar ocultar"> <i class=" icon-repeat"></i></div>');
		  if (contenedor.innerHTML.indexOf("<h1>") >=0)
			$(contenedor).html(	nuevo_objeto );
	    else
	    	$(contenedor).append(nuevo_objeto);		
		//alert(nuevo_objeto.html());
		//var ident = nuevo_objeto.find('img').attr('src');
/*			
	$('<img/>').attr('src', ident).load(function() {
		    
		    if (contenedor.innerHTML.indexOf("<h1>") >=0)
				$(contenedor).html(	nuevo_objeto );
		    else
		    	$(contenedor).append(nuevo_objeto);
		   // $(".new",contenedor).click( function(){
		   // 	alert('clic');
		    //});	
			//Hace draggable al obejto	
			$(".new",contenedor).draggable( {
				//axis: 'y', 
				containment: 'parent',
		    cursor: 'move',
		   // containment: 'document',
		    start: function( event, ui ) { 
		    	// calcular el mayor z-index y sumarle uno
		    	var mayor = 0;
		    	ui.helper.siblings().each(function(index){
		    		
		    		if (isNaN($(this).css('z-index')))
		    			compara = 0;
		    		else
		    			compara = $(this).css('z-index');
		    			
		    		if (parseInt(compara) > parseInt(mayor))
		    			mayor = compara;
		    		
		    	});
		    	//alert(mayor);
		    	//ui.helper.css('z-index',parseInt(mayor)+1); 
		    	mayor++;
		    	ui.helper.css('z-index',mayor);
		    	
		    }
		   // stop: handleDragStop
			});
			// EVENTO PARA ROTACION 
			$('.rotar',contenedor).draggable({
				
			    handle: '.rotar',
			    opacity: 0.01, 
			    helper: 'clone',
			    drag: function(event, ui){
			        var grados = ui.position.left*-1;
			        if (grados > 360)
			        	grados = grados - 360;
			        var rotateCSS = 'rotate(' + grados + 'deg)';
			
			        $(this).parent().css({
			            '-moz-transform': rotateCSS,
			            '-webkit-transform': rotateCSS
			        });
			    } 
			});
		
			$("span",contenedor).last().click(function(){
		  		$(this).parent().remove();
		  	});
		  	// Hace resizable al objeto
		  	var height = nuevo_objeto.find('img').attr('height');
		  	var width = nuevo_objeto.find('img').attr('width');
		  	
		  	$("img",contenedor).last().resizable({
		    	aspectRatio: width/height
		  	}).parent('.ui-wrapper').css('margin','0px').click(function(){
		  		$('.seleccionado').removeClass('seleccionado');
		  		$(this).addClass('seleccionado');
		  		
		  	});
		  	
		  	$('.canvas').css('background',"white");
		  	$('.canvas').css('z-index',"0");
	 //});
	    
});
*/
    //alert(e.dataTransfer.getData('producto_id'));
    //alert(e.dataTransfer.getData('text/html'));
   	//nuevo_objeto = $(e.dataTransfer.getData('text/html'));
   	
    
  }

  return false;
}

function handleDragEnd(e) {
	
  // this/e.target is the source node.
//if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {handleDrop(e);}
  
var cols = document.querySelectorAll('.column');
  [].forEach.call(cols, function (col) {
    col.classList.remove('over');
    col.style.opacity = '1';
  });
  $('.canvas').css('background',"white center center no-repeat");
  
}
$(window).load(function(){
	$('#btn_siguiente').removeAttr('disabled');
	
});
$(document).ready(function() {
	$('#div_invisible').show();


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
$('#btn_frente').click(function(){
	var mayor = 0;
	$('.seleccionado').parent().siblings().each(function(index){
		
		if (isNaN($(this).css('z-index')))
			compara = 0;
		else
			compara = $(this).css('z-index');
			
		if (parseInt(compara) > parseInt(mayor))
			mayor = compara;
		
	});
	
	//ui.helper.css('z-index',parseInt(mayor)+1);
	
	mayor++;
	 
	$('.seleccionado').parent().css('z-index',mayor);
});
$('#btn_atras').click(function(){
	var menor = 9999;
	$('.seleccionado').parent().siblings().each(function(index){
		
		if (isNaN($(this).css('z-index')))
			compara = 9999;
		else
			compara = $(this).css('z-index');
			
		if (parseInt(compara) <= parseInt(menor))
			menor = compara;
		
	});
	//alert(mayor);
	//ui.helper.css('z-index',parseInt(mayor)+1); 
	if (menor == 9999)
		menor = 0;
	else
		menor--;
	
	$('.seleccionado').parent().css('z-index',menor);
});

});
/*
[].forEach.call(cols, function(col) {
	alert("lore");
  col.addEventListener('dragstart', handleDragStart, false);
});	
*/
</script>
<div class="container margin_top_small" id="crear_look">
  
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
  

  <?php
	$list = CHtml::listData($models, 'id', 'nombre');
  ?>
  <?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'form_productos',
    //'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
)); ?>
  <div class="row">
    <section class="span8">
      <div class="well">
        <h4><?php echo $form->labelEx($model,'campana_id', array('class' => 'control-label')); ?> <?php echo $form->dropDownList($model, 'campana_id',
              $list,
              array('empty' => 'Seleccione una campaña', 'options' => array($model->campana_id => array('selected' => true))));
		?>

            <a  title="Traer al frente" class="btn" id="btn_frente"><?php echo Yii::t('contentForm', 'Bring front'); ?></a>
            <a  title="Llevar atrás" class="btn" id="btn_atras"> <?php echo Yii::t('contentForm', 'Send back') ?></a>
             <?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>Yii::t('contentForm', 'Save draft'),
	   // 'type'=>'danger',

	    'htmlOptions'=> array(
	    //'style'=>'padding:4px 6px',
		     // 'data-toggle'=>'modal',
			//	'data-target'=>'#dialogPublicar',
				//'class'=>'pull-right', 
		        'onclick'=>"{addPublicar(0);}"
		       ),	    
	)); ?>
            
            <?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>Yii::t('contentForm', 'Next'),
	    'type'=>'danger',
		'buttonType' => 'button',
	    'htmlOptions'=> array(
	   // 'style'=>'padding:4px 6px',
		     // 'data-toggle'=>'modal',
			//	'data-target'=>'#dialogPublicar',
				//'class'=>'pull-right margin_left_small', 
		        'onclick'=>"{addPublicar(1);}",
		        'disabled'=>'disabled',
		        'id'=>'btn_siguiente',
		       ),	    
	)); ?>
            <div id="campana_id_error" style="font-size: small; color: red; display: none;"></div>
        </h4>
      
        <!--
        <a href="#" title="Borrar" class="btn"><i class="icon-trash"></i></a> <a href="#" title="Flip" class="btn"><i class="icon-resize-horizontal"></i> Flip</a> <a href="#" title="Copiar" class="btn">Copiar</a> <a href="#" title="Traer al frente" class="btn"> Traer al frente</a> <a href="#" title="Llevar atrás" class="btn"> Llevar atrás</a>
        
        -->
        <hr/>

        <!-- CANVAS ON -->
        <div class=" margin_left_xsmall canvas" style="z-index:0;overflow:hidden;position: relative;width: 710px;height: 710px;-webkit-user-drop: element;" id="div_canvas" dropzone="move s:text/plain">
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
          <div class="new" id="div<?php echo $producto->id."_".$hasproducto->color_id; ?>" style="z-index: <?php echo $hasproducto->zindex; ?>; position: absolute; top: <?php echo $hasproducto->top;?>px; left: <?php echo $hasproducto->left;?>px; -webkit-transform: rotate(<?php echo $hasproducto->angle; ?>deg);">
            <?php
					//if ($producto->mainimage)  
					//$image = CHtml::image(Yii::app()->baseUrl . $producto->mainimage->url, "Imagen", array("width" => $hasproducto->width, "height" => $hasproducto->height));
					//else 
					//$image = CHtml::image("http://placehold.it/180");	
					//echo $image; 
					//echo $hasproducto->width.'/'.$hasproducto->height;
			?>

              <?php if ($model->id >= 638){
                  echo CHtml::image( Yii::app()->createUrl('site/productoImagenPng').'/producto/'.$producto->id.'/color/'.$hasproducto->color_id.'/w/270/h/270', "Imagen", array("width" => $hasproducto->width, "height" => $hasproducto->height));
              } else {
                  echo CHtml::image($producto->getImageUrl($hasproducto->color_id,array('ext'=>'png')), "Imagen", array("width" => $hasproducto->width, "height" => $hasproducto->height));
              }
              ?>
            <input type="hidden" name="producto_id" value="<?php echo $producto->id; ?>">
            <input type="hidden" name="color_id" value="<?php echo $hasproducto->color_id; ?>">
            <span class="eliminar"><i class=" icon-remove"></i></span>
			<div class="rotar"> <i class=" icon-repeat"></i></div>
			 </div> 
          <?php 
              	$script = "$('.canvas').css('z-index',0);	$('#div".$producto->id."_".$hasproducto->color_id." ').draggable( {
    cursor: 'move',

    containment: 'parent',
    start: function( event, ui ) { 
	// calcular el mayor z-index y sumarle uno
	var mayor = 0;
	ui.helper.siblings().each(function(index){
		
		if (isNaN($(this).css('z-index')))
			compara = 0;
		else
			compara = $(this).css('z-index');
		if (compara > mayor)
			mayor = compara;
		
	});
	
	ui.helper.css('z-index',parseInt(mayor)+1); 
}
  
	} ); 
	
				$('#div".$producto->id."_".$hasproducto->color_id." > .rotar').draggable({
			    handle: '.rotar',
			    opacity: 0.01, 
			    helper: 'clone',
			    drag: function(event, ui){
			        var grados = ui.position.left*-1;
			        if (grados > 360)
			        	grados = grados - 360;
			        var rotateCSS = 'rotate(' + grados + 'deg)';
			
			        $(this).parent().css({
			            '-moz-transform': rotateCSS,
			            '-webkit-transform': rotateCSS
			        });
			    } 
			});
			
  $('#div".$producto->id."_".$hasproducto->color_id." > span').last().click(function(){
  	
  	$(this).parent().remove();
  });   
	
	var load_handler = function() {
		var height = $(this).attr('height');
		var width = $(this).attr('width');
		 $(this).resizable({
      		aspectRatio: width/height
    	}).parent('.ui-wrapper').css('margin','0px').click(function(){
		  		$('.seleccionado').removeClass('seleccionado');
		  		$(this).addClass('seleccionado');
		  		
		 	});	
	}
	$('#div".$producto->id."_".$hasproducto->color_id." > img').filter(function() {
	    return this.complete;
	}).each(load_handler).end().load(load_handler);		
	
	
	
   
    
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
          <div class="new ui-draggable" id="adorno<?php echo $adorno->id; ?>" style="z-index: <?php echo $hasAd->zindex; ?>; position: absolute; top: <?php echo $hasAd->top;?>px; left: <?php echo $hasAd->left;?>px;-webkit-transform: rotate(<?php echo $hasAd->angle; ?>deg);">
            <?php
				$image = CHtml::image(Yii::app()->baseUrl.'/images/adorno/'.$adorno->path_image, $adorno->nombre, array("width" => $hasAd->width, "height" => $hasAd->height));				
				echo $image;
			?>
            <input type="hidden" name="adorno_id" value="<?php echo $adorno->id; ?>">
            <span class="eliminar"><i class=" icon-remove"></i></span>
			<div class="rotar"> <i class=" icon-repeat"></i></div> </div>
          <?php 
	        
	        $script = "	$('#adorno".$adorno->id."').draggable( {
	    		cursor: 'move',
	   	 		containment: 'document',
	   	 				    start: function( event, ui ) { 
		    	// calcular el mayor z-index y sumarle uno
		    	var mayor = 0;
		    	ui.helper.siblings().each(function(index){
		    		
		    		if (isNaN($(this).css('z-index')))
		    			compara = 0;
		    		else
		    			compara = $(this).css('z-index');
		    		if (parseInt(compara) > parseInt(mayor))
		    			mayor = compara;
		    		
		    	});
		    	
		    	ui.helper.css('z-index',parseInt(mayor)+1); 
		    }
	  			} ); 
	 $('#adorno".$adorno->id." > .rotar').draggable({
			    handle: '.rotar',
			    opacity: 0.01, 
			    helper: 'clone',
			    drag: function(event, ui){
			        var grados = ui.position.left*-1;
			        if (grados > 360)
			        	grados = grados - 360;
			        var rotateCSS = 'rotate(' + grados + 'deg)';
			
			        $(this).parent().css({
			            '-moz-transform': rotateCSS,
			            '-webkit-transform': rotateCSS
			        });
			    } 
			});
	 		$('#adorno".$adorno->id." > span').last().click(function(){
	 			$(this).parent().remove();
	  		});
			   
			

		var load_handler = function() {
			var height = $(this).attr('height');
			var width = $(this).attr('width');
			 $(this).resizable({
	      		aspectRatio: width/height
	    	}).parent('.ui-wrapper').css('margin','0px').click(function(){
			  		$('.seleccionado').removeClass('seleccionado');
			  		$(this).addClass('seleccionado');
			  		
			 	});	
		}
		$('#adorno".$adorno->id." > img').filter(function() {
		    return this.complete;
		}).each(load_handler).end().load(load_handler);			    
		 	";
	        
	        Yii::app()->clientScript->registerScript('drag'.$adorno->id,$script);
        } // foreach de adornos

        	
        } else {
        	?>
          <div class="margin_left_small">
          <h1><?php echo Yii::t('contentForm', 'Create your Look here'); ?></h1>
          <p><?php echo Yii::t('contentForm', 'Start by dragging the panel items right up here. Just click on them and move them to this box.'); ?></p>
          </div>
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
      
      <?php echo CHtml::hiddenField('productos_id'); ?> 
      <?php echo CHtml::hiddenField('colores_id'); ?> 
      <?php echo CHtml::hiddenField('left'); ?> 
      <?php echo CHtml::hiddenField('top'); ?> 
      <?php echo CHtml::hiddenField('width'); ?> 
      <?php echo CHtml::hiddenField('height'); ?> 
      <?php echo CHtml::hiddenField('tipo'); ?> 
      <?php echo CHtml::hiddenField('angle'); ?>
      <?php echo CHtml::hiddenField('index'); ?> 
      
      <?php echo CHtml::hiddenField('adornos_id'); ?> 
      <?php echo CHtml::hiddenField('left_a'); ?> 
      <?php echo CHtml::hiddenField('top_a'); ?> 
      <?php echo CHtml::hiddenField('width_a'); ?> 
      <?php echo CHtml::hiddenField('height_a'); ?> 
      <?php echo CHtml::hiddenField('angle_a'); ?>
      <?php echo CHtml::hiddenField('index_a'); ?>
      <?php $this->endWidget(); ?>
    </section>
    <section class="span4">
      <div class="">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab" title="Todos los productos"><?php echo Yii::t('contentForm', 'Products'); ?></a></li>
          <!--
            <li><a href="#tab2" data-toggle="tab" title="Productos que ya has utilizado para hacer otros looks"><?php //echo Yii::t('contentForm', 'Decorations'); ?></a></li>
          -->
          <li><a href="#tab3" data-toggle="tab" title="Productos destacados"><?php echo Yii::t('contentForm', 'Featured Products'); ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="row-fluid">
              <form id="formu" class="no_margin_bottom form-search">
                <div class="span6">
                  <select id="padreId" class="span12" name="padreId">
                    <option value="0"><?php echo Yii::t('contentForm', 'Search by Categories'); ?></option>
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
				$texto = 'Todos';
				switch ($item->nombre) {
					case 'Ropa':
						$texto = 'Toda la ropa';
						break;
					case 'Zapatos':
						$texto = 'Todos los zapatos';
						break;
					case 'Complementos':
						$texto = 'Todos los complementos';
						break;
					default:
						# code...
						break;
				}
				echo "<option value='".$item->nombre."' name='".$item->padreId."'> &nbsp;&nbsp;&nbsp;";
				echo $texto;
				echo "</option>";
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
                    <select id="marcas" class="span12" name="marcas">
                      <option selected><?php echo Yii::t('contentForm', 'All Brands'); ?></option>
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
				'url'=>Yii::app()->createUrl( 'look/categorias'),
				'type' => 'POST',
				'beforeSend' => "function( request )
				{
					// Set up any pre-sending stuff like initializing progress indicators
					$('body').addClass('aplicacion-cargando');
				}",
				'success' => "function( data )
				{
				// handle return data
				//alert( data );
					$('#div_categorias').html(data);
					$('body').removeClass('aplicacion-cargando');
				}",
					'data' => "js:$('#formu').serialize()+'&colores='+$('#colores').val()",
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
						                       	$('body').addClass('aplicacion-cargando');
						                       // Set up any pre-sending stuff like initializing progress indicators
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                    $('body').removeClass('aplicacion-cargando');
						                  }",
						    'data' => "js:$('#formu').serialize()+'&colores='+$('#colores').val()",
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
                <div class="span6">
			    <?php if (Yii::app()->params['mostrarChic']): ?>
				<!-- Opciones 100% chic ON -->
				
				 <?php $marcas = Marca::model()->findAll(array('order'=>'nombre'));  ?>
                  <div class="margin_bottom_small ">
                  	<select id="marcachic" name="100chic" id="" class="span12">
                  		<option value="100% chic">Marcas 100% Chic</option>
                  		<?php
        					foreach($marcas as $marca){
        						if ($marca->is_100chic)	
        							echo "<option value='".$marca->id."'> ".$marca->nombre." </option>";
        					}
        				?>
                  	</select>

                  </div>
                  <?php endif; ?>
                  
<?php
	Yii::app()->clientScript->registerScript('marcachic',
		"
		$('#marcachic').change(function(){
				$('#marcas').val($('#marcachic').val());
				
			". CHtml::ajax(
						 
			array( // ajaxOptions
				'url'=>Yii::app()->createUrl( 'look/categorias'),
				'type' => 'POST',
				'beforeSend' => "function( request )
				{
					// Set up any pre-sending stuff like initializing progress indicators
					$('body').addClass('aplicacion-cargando');
					
				}",
				'success' => "function( data )
				{
				// handle return data
				//alert( data );
					$('#div_categorias').html(data);
					$('body').removeClass('aplicacion-cargando');
				}",
					'data' => "js:$('#formu').serialize()+'&colores='+$('#colores').val()",
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
				<!-- Opciones 100% chic OFF -->


                  <div class="dropdown" > <a class="btn dropdown-toggle" id="a_colores" data-toggle="dropdown" href="#"> <?php echo Yii::t('contentForm', 'Filter by Colors'); ?> <span class="caret"></span></a> 
                    <!-- Link or button to toggle dropdown -->
                    
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" id="crear_look_colores">
  	<?php
  	echo '<li>';
  	
	echo CHtml::ajaxLink(
						  "Todos",
						  Yii::app()->createUrl( 'look/categorias'),
						  array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request,settings )
						                     {
						                       	$('body').addClass('aplicacion-cargando');
						                       // Set up any pre-sending stuff like initializing progress indicators
						                       $('#colores').val('');
						                       
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#a_colores').html('Todos <span class=\"caret\"></span>');
						                    $('#a_colores').dropdown('toggle');
						                    $('#div_categorias').html(data);
											$('body').removeClass('aplicacion-cargando');
						                  }",
						     'data' => "js:$('#formu').serialize()+'&colores='",
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						   // 'class' => 'thumbnail',
						    'id' => 'colores0',
						    'draggable'=>"false",
						    'tabindex'=>'-1',
						  )
						);
	echo '</li>';   
	?>                 	
                      <?php 
  $colores = Color::model()->findAllByAttributes(array('padreID'=>'0'));
  foreach($colores as $color){
  	$ruta=Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/colores/'.$color->path_image;
  	$imagen = CHtml::image($ruta,$color->valor,array('height'=>'20','class'=>'img_crear_look_colores'));
	  
  	echo '<li>';
  	
	echo CHtml::ajaxLink(
						  $imagen.'  '.$color->valor,
						  Yii::app()->createUrl( 'look/categorias'),
						  array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request,settings )
						                     {
						                       	$('body').addClass('aplicacion-cargando');
						                       // Set up any pre-sending stuff like initializing progress indicators
						                       $('#colores').val('".$color->id."');
						                       
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#a_colores').html('".$imagen.'  '.$color->valor." <span class=\"caret\"></span>');
						                    $('#a_colores').dropdown('toggle');
						                    $('#div_categorias').html(data);
											$('body').removeClass('aplicacion-cargando');
						                  }",
						     'data' => "js:$('#formu').serialize()+'&colores=".$color->id."'",
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
              <?php echo CHtml::hiddenField('colores'); ?>
            </div>
            <hr/>
           
            <div id="div_categorias" >
            	<div id="div_invisible" style="display: none">
              <?php $this->renderPartial('_view_categorias',array('categorias'=>$categorias,'categoria_padre'=>0)) ?>
              </div>
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
              <p>
              <div id="div_prendas">
                  <?php $this->renderPartial('_view_productos',array('productos'=>Producto::model()->noeliminados()->activos()->featured()->findAll(),'page'=>1)) ?>
              </div>
              </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<div id="alertLook" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
 <div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
     <h3><?php echo Yii::t('contentForm','Remember');?></h3>
 
  </div>
  <div class="modal-body">
 		 <h4 id="alertText"></h4>
 		 
  </div>
  <!--<div class="modal-footer">   
 		<button class="btn closeModal" data-dismiss="modal" aria-hidden="true">Aceptar</button>
  </div>-->
</div>

<!-- /container --> 



<!-- Modal 1 --> 
<!--
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	-->
</div>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'dialogPublicar')); ?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>


<style>
    body .buorg{
        position: absolute;
        z-index: 111111;
        width: 100%;
        top: 0px;
        left: 0px;
        border-bottom: 1px solid #A29330;
        background: #fdf2ab;
        text-align: left;
        cursor: pointer;
        font-family: Arial,Helvetica,sans-serif;
        color: #000;
        font-size: 12px;
    }
    body .buorg div {
        padding: 15px 36px 15px 10px;
    }
    body .buorg div i{
       margin: 0px 20px;
    }
    
    body #buorgclose {
        position: absolute;
        right: 1.5em;
        top: 1em;
        height: 20px;
        width: 19px;
        padding-left: 12px;
        font-weight: bold;
        font-size: 14px;
        padding: 0;
    }
    
</style>
<script type="text/javascript"> 
    var $buoop = {
        vs: {i:10,f:21,o:10,s:6,n:19},
        test: false,
        reminder: 0.1,  //horas para recordatorio                 
        text: "Tu navegador (%s) <b>no soporta</b> las funcionalidades de ésta página. \n\
            Es posible que algunas características para crear un look <b>no funcionen correctamente</b>. Puedes\n\
            <b>continuar bajo tu riesgo</b> o <a %s >Actualizar tu navegador</a>",                       
        newwindow: true,
        //url: "youtube",
       
    };
    
    $buoop.ol = window.onload; 
    
    window.onload=function(){ 
     try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
     var e = document.createElement("script"); 
     e.setAttribute("type", "text/javascript"); 
     e.setAttribute("src", "<?php echo Yii::app()->baseUrl . "/js/updateBrowser.js"; ?>"); 
     document.body.appendChild(e); 
    } 
    
</script>

<script type="text/javascript">
    


    

	function actualizar()
	{
		alert("llegó");
	}


// here is the magic
function addPublicar(tipo)
{
	var productos_id = '';
	var products_array;
	var color_id = '';
	var left = '';
	var top = '';
	var height = '';
	var width = ''; 
	var angle = '';
	var index = '';
	var count = 0;
	
	var adornos_id = '';
	var left_a = '';
	var top_a = '';
	var height_a = '';
	var width_a = '';
	var count_a = 0;
	var angle_a = '';
	var index_a = '';
	
	if($('#Look_campana_id').val() != ''){
        try{
            $('#campana_id_error').hide('slow');
            $("#productos_id").val('');
            $('.canvas input[name="producto_id"]').each(function(item){
                //console.log($(this).val());
                productos_id += $(this).val()+',';
                color_id += $(this).next().val()+',';
                position = $(this).parent().position();
                /* CALCULO DEL ANGULO */
                tr = $(this).parent().css('-webkit-transform');

                if(typeof tr === 'undefined'){
                    angle += '0,';
                } else {
                    if(tr != 'none'){
                        var values = tr.split('(')[1];
                            values = values.split(')')[0];
                            values = values.split(',');
                        var a = values[0];
                        var b = values[1];
                        var c = values[2];
                        var d = values[3];
                        angle += (Math.round(Math.atan2(b, a) * (180/Math.PI)) ) + ',';
                    } else {
                        angle += '0,';
                    }
                }
                /* CALCULO DEL Z-INDEX */
                //index = $(this).parent().css('z-index');
                if (isNaN($(this).parent().css('z-index')))
                    index += '0,';
                else
                    index += $(this).parent().css('z-index') + ',';

                //alert(angle);
                image = $(this).parent().find('img');
                width += image.width() + ',';
                height += image.height() + ',';
                left += position.left + ',';
                top += position.top + ',';
                //console.log('count');
                count++;
            });

            // para los adornos

            $('.canvas input[name="adorno_id"]').each(function(item){
                /* CALCULO DEL ANGULO */
                tr = $(this).parent().css('-webkit-transform');
                if(typeof tr === 'undefined'){
                    angle_a += '0,';
                } else {
                    if(tr != 'none'){
                        var values = tr.split('(')[1];
                            values = values.split(')')[0];
                            values = values.split(',');
                        var a = values[0];
                        var b = values[1];
                        var c = values[2];
                        var d = values[3];
                        angle_a += (Math.round(Math.atan2(b, a) * (180/Math.PI)) ) + ',';
                    } else {
                        angle_a += '0,';
                    }
                }
                /* CALCULO DEL Z-INDEX */
                //index = $(this).parent().css('z-index');
                if (isNaN($(this).parent().css('z-index')))
                    index_a += '0,';
                else
                    index_a += $(this).parent().css('z-index') + ',';
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

            // check forr repeated products
            //console.log(productos_id);
            products_array = productos_id.split(',');
            products_array.sort();
            var last = products_array[0];
            var repeated = false;
            for (var i=1; i<products_array.length; i++) {
                if (products_array[i] == last){
                    repeated = true;
                }
                last = products_array[i];
            }

            if(repeated){
                $('#alertText').html('<?php echo Yii::t('contentForm','You should not add repeated items.')?>');
                $('#alertLook').show();
                return false;
            }



            //alert(left);
            //productos_id = "1,2,3,4";

            $("#productos_id").val(productos_id);
            $("#colores_id").val(color_id.substring(0, color_id.length-1));
            $("#left").val(left.substring(0, left.length-1));
            $("#top").val(top.substring(0, top.length-1));
            $("#height").val(height.substring(0, height.length-1));
            $("#width").val(width.substring(0, width.length-1));
            $("#angle").val(angle.substring(0, angle.length-1));
            $("#index").val(index.substring(0, index.length-1));
            $("#tipo").val(tipo);

            // ahora los de los adornos
            $("#adornos_id").val(adornos_id);
            $("#left_a").val(left_a.substring(0, left_a.length-1));
            $("#top_a").val(top_a.substring(0, top_a.length-1));
            $("#height_a").val(height_a.substring(0, height_a.length-1));
            $("#width_a").val(width_a.substring(0, width_a.length-1));
            $("#angle_a").val(angle_a.substring(0, angle_a.length-1));
            $("#index_a").val(index_a.substring(0, index_a.length-1));

            //count = 6;
            //alert(productos_id);
            //count = count + count_a;
            console.log(count);
            if (count >= 6){
                $("#form_productos").submit();
            } else {
                $('#alertText').html('<?php echo Yii::t('contentForm','You should add six items at least.')?>');
                $('#alertLook').show();
            }

            return false;
        }
        catch(err) {
            $('#alertText').html('Hubo un error: '+err.message);
            $('#alertLook').show();
            return false;
        }
    }else{
    	$('#campana_id_error').html('Debes seleccionar una campaña');
    	$('#campana_id_error').show('slow');
        return false;
    }
}

$('.closeModal').click(function(event) {
			$('#alertLook').hide();
		});
 
</script> 
