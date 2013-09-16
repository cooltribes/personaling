<?php 
  $this->breadcrumbs=array(
  'Usuarios'=>array('admin'),
  'Editar',);
  if(isset($_GET['id']))
  	$usid=$_GET['id'];
  else
  	$usid=0;
?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Avatar</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>4)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
      <!--  <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">-->
          <fieldset>
            <legend >Avatar: </legend>
            
            
            
            
            <article>
            	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'avatar-form',
			'htmlOptions'=>array('class'=>'personaling_form','enctype'=>"multipart/form-data"),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>  
    <fieldset>
                  <h1>Tu Avatar</hpas1>
<p>Puedes editar o cambiar el avatar usando las opciones a continuación:</p>
    	<div id="container" class="text_align_center margin_top" >
    		
    		 <?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270","class"=>"img_1")); ?>
    		</div>
  <!--       <div class="text_align_center">
      		<div id="boton_original" class="btn">original</div> 
      		<div id="boton_mas" class="btn">+</div> 
      		<div id="boton_menos" class="btn">-</div> 
    		</div>
   -->          	

    	 <div class="braker_horz_top_1 ">
      <label for="fileToUpload">Elige la imagen que deseas subir</label><br />
           <!--
      <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="multiple" />
      -->
      <input type="file" name="filesToUpload" id="filesToUpload" class="well well-small"/>
      <?php echo CHtml::hiddenField('valido','1'); ?>
      <?php echo CHtml::hiddenField('avatar_x','0'); ?>
      <?php echo CHtml::hiddenField('avatar_y','0'); ?>
       <?php echo CHtml::hiddenField('user',$usid); ?>
<?php /*?>      <div id="dropTarget">O arrasta la imagen hasta aqui</div><?php */?>
      <output id="filesInfo"></output>
      
         <div class="form-actions"> <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'label'=>'Haz click aqui para subir la imagen',
		)); ?>
      </div>
      </div>
    
    
  
    
    </fieldset>
<?php $this->endWidget(); ?>
            	
            	
            	
            	
            </article>
            
            
            
            
            
            
           
          </fieldset>
       <!-- </form> -->
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR ON --> 
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
							top: "70px",
              width: "239px"              
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
        <div>
          <div id="scroller-anchor"></div>
          <!-- <div id="scroller"> <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>-->
            <ul class="nav nav-stacked nav-tabs margin_top">
              <li><a href="#" title="Restablecer" id="limpiar"> <i class="icon-repeat"></i> Limpiar Formulario</a></li>
              <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
              <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
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
</div>
<!-- /container --> 
<script>
var ImagenW;
var ImagenH;
      function drawImage(imageObj,tempW,tempH) { 
        document.getElementById("container").innerHTML = "";
        var stage = new Kinetic.Stage({
          container: "container",
          width: 270,
          height: 270
        });
        
        var layer = new Kinetic.Layer();

        ImagenW = tempW;
		ImagenH = tempH;
        var darthVaderImg = new Kinetic.Image({
          image: imageObj,
          x: stage.getWidth() / 2 - tempW / 2,
          y: stage.getHeight() / 2 - tempH / 2,
          width: tempW,
          height: tempH,
          draggable: true,
		  
		  dragBoundFunc: function(pos) {
            
			//console.log(this.getWidth());
			//console.log(ImagenW);
			//console.log(this.getImage());
			//console.log(this);
			//console.log(tempW);
			//console.log((stage.getWidth()-tempW)+":"+pos.x+"|"+tempW+"|"+stage.getWidth());
			var newX = pos.x < (stage.getWidth()-ImagenW) ? (stage.getWidth()-ImagenW) : (pos.x >= 0 ? 0 : pos.x);
			//console.log(newX);
			var newY = pos.y < (stage.getHeight()-ImagenH) ? (stage.getHeight()-ImagenH) : (pos.y >= 0 ? 0 : pos.y);
			//newX = pos.x >= 0 ? 0 : pos.x;
			//newY = pos.y >= 0 ? 0 : pos.y;
            return {
              x: newX,
              y: newY
            };
          }
		  
        });
		
		// Rotate here
		//darthVaderImg.rotate(Math.PI / 4); 
        
        
        // add cursor styling
        darthVaderImg.on('mouseover', function() {
			
          document.body.style.cursor = 'pointer';
        });
        darthVaderImg.on('mouseout', function() {
          document.body.style.cursor = 'default';
        });

        layer.add(darthVaderImg);
        //stage.clear();
        stage.add(layer);
		var originalW = darthVaderImg.getWidth();
		var originalH = darthVaderImg.getHeight();
		document.getElementById('boton_original').addEventListener('click', function() {
			//darthVaderImg.setWidth(100);
			//console.log(darthVaderImg.getWidth());
        	 alert(
              "   X/Y:"+
              darthVaderImg.getAbsolutePosition().x+"/"+
              darthVaderImg.getAbsolutePosition().y+" -- Width/Height:"+
              darthVaderImg.getWidth()+"/"+
              darthVaderImg.getHeight()          
          );
        	//darthVaderImg.setScale(1, 1);
			//ImagenW = originalW;
			//ImagenH = originalH;
        	//layer.draw();
      },false);
      $("#avatar-form").submit(function(evt){

     // document.getElementById('avatar-form').addEventListener('submit', function(evt) {
			//darthVaderImg.setWidth(100);
			//console.log(darthVaderImg.getWidth());
			//alert('asd');
			//evt.preventDefault();
			//document.getElementById('avatar_x').value =  darthVaderImg.getAbsolutePosition().x;
			//document.getElementById('avatar_y').value =  darthVaderImg.getAbsolutePosition().y;
			$('#avatar_x').val(darthVaderImg.getAbsolutePosition().x);
			$('#avatar_y').val(darthVaderImg.getAbsolutePosition().y);
			//$("#avatar-form").submit();
			//$(this).submit();
			/*
        	 alert(
              "   X/Y:"+
              darthVaderImg.getAbsolutePosition().x+"/"+
              darthVaderImg.getAbsolutePosition().y+" -- Width/Height:"+
              darthVaderImg.getWidth()+"/"+
              darthVaderImg.getHeight()          
          );*/
        	//darthVaderImg.setScale(1, 1);
			//ImagenW = originalW;
			//ImagenH = originalH;
        	//layer.draw();
     // },false);
     });
      /*
		darthVaderImg.on('dblclick', function() {
		
        	if (darthVaderImg.getWidth()*2 ==ImagenW){
	        	this.setScale(1, 1);
				ImagenW = darthVaderImg.getWidth()/2;
				ImagenH = darthVaderImg.getHeight()/2;        		
        	} else {
	        	this.setScale(2, 2);
				ImagenW = darthVaderImg.getWidth()*2;
				ImagenH = darthVaderImg.getHeight()*2;
			}
        layer.draw();
      });*/
      document.getElementById('boton_mas').addEventListener('click', function() {
		
        	
	        	darthVaderImg.setScale(2, 2);
				ImagenW = darthVaderImg.getWidth()*2;
				ImagenH = darthVaderImg.getHeight()*2;
			
        layer.draw();
      });
      document.getElementById('boton_menos').addEventListener('click', function() {
		
        	
	        	darthVaderImg.setScale(1, 1);
				ImagenW = darthVaderImg.getWidth()/2;
				ImagenH = darthVaderImg.getHeight()/2;
			
        layer.draw();
      });
      }
function convertToRadians(degree) {
            return degree*(Math.PI/180);
        }
function fileSelect(evt) {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var files = evt.target.files;
 
        var result = '';
        var file;
        for (var i = 0; file = files[i]; i++) {
            // if the file is not an image, continue
            if (!file.type.match('image.*')) {
                continue;
            }
  
            reader = new FileReader();
            /*
                 fr   = new FileReader; // to read file contents

			    fr.onloadend = function() {
			        // get EXIF data
			        var exif = EXIF.readFromBinaryFile(new BinaryFile(this.result));
			
			        // alert a value
			        alert(exif.Make);
			    };
			
			    fr.readAsBinaryString(file); // read the file
			    */
				reader.onload = (function (tFile) {
                	return function (evt) {
                		//var canvas = document.getElementById('myCanvas');
				      	//var context = canvas.getContext('2d');
				      	var imageObj = new Image();
			        	//var exif = EXIF.readFromBinaryFile(new BinaryFile(evt.target.result)); // get EXIF data
			        	//alert(exif.Orientation);				
						imageObj.onload = function() {
				      		var MAX_WIDTH = 270;
				        	var MAX_HEIGHT = 270;
				        	var MIN_WIDTH = 270;
				        	var MIN_HEIGHT = 270;
							var tempW = imageObj.width;
				        	var tempH = imageObj.height;
				        	
							/*if (tempW > tempH) {
				            	if (tempW > MAX_WIDTH) {
				               		tempH *= MAX_WIDTH / tempW;
				               		tempW = MAX_WIDTH;
				            	} 
				        	} else {
				            	if (tempH > MAX_HEIGHT) {
				               		tempW *= MAX_HEIGHT / tempH;
				               		tempH = MAX_HEIGHT;
				            	}
				        	}*/
							console.log(tempW+":"+tempH);
							if (tempW>MIN_WIDTH && tempH>MIN_HEIGHT) {
							   image_ratio = tempW/tempH;
							   zoom = image_ratio > 1
									 ? MIN_HEIGHT / tempH
									 : MIN_WIDTH / tempW
									 ;
							
							   tempW = tempW * zoom;
							   tempH = tempH * zoom;
							}
							
							console.log(tempW+":"+tempH);
							console.log('orientation='+exif.Orientation);
							//canvas.width = tempW;
        					//canvas.height = tempH;
							if (exif.Orientation==6){
								height_old = canvas.height;
     							width_old = canvas.width;
								//canvas.width  = height_old;
								//canvas.height = width_old;
	 							//context.translate(canvas.width, 0);
	
     							// rotate 45 degrees clockwise
      							//context.rotate(Math.PI / 2);
	  							//context.translate(canvas.height,0);
     							// imageObj.onload = function() {
     							//	imageObj.rotate(45);
        						context.drawImage(imageObj,(canvas.height / 2)-(tempW/2),(canvas.width / 2)-(tempH/2),tempW,tempH);
        						$("#log").html("x,y:"+((canvas.width / 2)-(imageObj.height/2))+", "+((canvas.height / 2)-(imageObj.width/2))+" canvas.width:"+canvas.width+" canvas.height:"+canvas.height+" this.width"+imageObj.width+" this.height:"+imageObj.height);
							}else{
								//context.drawImage(imageObj,(canvas.width / 2)-(tempW/2),(canvas.width / 2)-(tempH/2),tempW,tempH);
								drawImage(imageObj,tempW,tempH);
							}			
											  
				        		//context.drawImage(imageObj, 0,0 , 100, 100);
				      	};
				     		// imageObj.src = evt.target.result;
				       	imageObj.src = "data:image/jpeg;base64,"+window.btoa(evt.target.result);
                   			// var div = document.createElement('div');
                    		//div.innerHTML = '<img style="width: 90px;" src="' + evt.target.result + '" />';
                    //document.getElementById('filesInfo').appendChild(div);
                	};
            }(file));
            reader.readAsBinaryString(file);
        }
    } else {
        alert('The File APIs are not fully supported in this browser.');
    }
}
function dragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy';
}
$(document).ready(function() { 
/*
      var imageObj = new Image();
      imageObj.onload = function() {
        drawImage(this);
      };
      imageObj.src = 'http://www.html5canvastutorials.com/demos/assets/darth-vader.jpg';

*/
	/*var dropTarget = document.getElementById('dropTarget');
	dropTarget.addEventListener('dragover', dragOver, false);
	dropTarget.addEventListener('drop', fileDrop, false);*/
	document.getElementById('filesToUpload').addEventListener('change', fileSelect, false);
		 	
});



</script>
