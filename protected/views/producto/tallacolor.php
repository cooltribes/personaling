<script language="JavaScript">

//$(document).ready(function() {
	
//});

</script>
<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Tallas y Colores',
);

?> 

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Tallas y Colores</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>6)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
      	<!--
        <form enctype="multipart/form-data" class="form-horizontal" id="registration-form" action="/aiesec/user/registration?template=1" method="post">
        -->
          <fieldset>
            <legend>Elige las tallas disponibles para este producto: </legend>
            <p class="margin_bottom muted"> Haz click sobre los botones para elegir las tallas </p>
            <div id="div_tallas">
            <div class="control-group">
              <label class="control-label required">Bolsos y Otros:</label>
              <div class="controls">
              	 <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'type' => 'primary',
				   
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => array(
				        array('url'=>'#0','label'=>'U',
				       ),
				       
				    ),
				)); ?>
              </div>
              </div>
            <div class="control-group">
              <label class="control-label required">Ropa</label>
              <div class="controls">
                <!-- 
                <div class="btn-group" data-toggle="buttons-checkbox">
                  <button type="button" class="btn btn-inverse">32</button>
                  <button type="button" class="btn btn-inverse">34</button>
                  <button type="button" class="btn btn-inverse">36</button>
                  <button type="button" class="btn btn-inverse">38</button>
                  <button type="button" class="btn btn-inverse">40</button>
                  <button type="button" class="btn btn-inverse">42</button>
                  <button type="button" class="btn btn-inverse">44</button>
                </div>
                <div style="display:none" class=" muted">Ayuda</div>
                -->
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'type' => 'primary',
				   
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => array(
				        /*
				        array('label'=>'32',
				        'buttonType' => 'ajaxLink',
				        
				        'ajaxOptions'=>array(
							 'type'=>'post',
							 'url'=>array('producto/addTallacolor', 'id'=>$model->id),
							 'success' => "function( data )
			                  {
			                    // handle return data
			                    alert( data );
			                  }",
						)
						  
						 ),
						 * */
				       
				        array('label'=>'32','url'=>'#1'),
				        array('label'=>'34','url'=>'#2'),
				        array('label'=>'36','url'=>'#3'),
				        array('label'=>'38','url'=>'#4'),
				        array('label'=>'40','url'=>'#5'),
				        array('label'=>'42','url'=>'#6'),
				        array('label'=>'44','url'=>'#7'),
				        array('label'=>'46','url'=>'#26'),
				    ),
				)); ?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label required">Ropa</label>
              <div class="controls">
                
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'type' => 'primary',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => array(
					    array('label'=>'2XS','url'=>'#24'),
				        array('label'=>'XS','url'=>'#9'),
				        array('label'=>'S','url'=>'#10'),
				        array('label'=>'M','url'=>'#11'),
				        array('label'=>'L','url'=>'#12'),
				        array('label'=>'XL','url'=>'#13'),
				        array('label'=>'2XL','url'=>'#23'),
				        array('label'=>'3XL','url'=>'#25'),
				    ),
				)); ?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label required">Pantalones:</label>
              <div class="controls">
               <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'type' => 'primary',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => array(
				        array('label'=>'24','url'=>'#14'),
				        array('label'=>'26','url'=>'#15'),
				        array('label'=>'28','url'=>'#16'),
				        array('label'=>'30','url'=>'#18'),
				        array('label'=>'32','url'=>'#1'),
				        array('label'=>'34','url'=>'#2'),
				    ),
				)); ?> 
              </div>
            </div>
            <div class="control-group">
              <label class="control-label required">Zapatos:</label>
              <div class="controls">
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'type' => 'primary',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => array(
				        array('label'=>'35','url'=>'#19'),
				        array('label'=>'36','url'=>'#3'),
				        array('label'=>'37','url'=>'#20'),
				        array('label'=>'38','url'=>'#4'),
				        array('label'=>'39','url'=>'#21'),
				        array('label'=>'40','url'=>'#5'),
				        array('label'=>'41','url'=>'#22'),
				        array('label'=>'42','url'=>'#6'),
				    ),
				)); ?>
               
              </div>
            </div>
            </div>
          </fieldset>
          <fieldset class="margin_top">
            <legend>Elige los <span class="color1">colores</span> disponibles para este producto: </legend>
            <div class="row">
              <div class="span6">
                <p class="margin_bottom muted">Utiliza el buscador para encontrar y seleccionar los colores que correspondan</p>
              </div>
              <!--
              <a href="#myModal"  role="button" data-toggle="modal" class="btn btn-small pull-right"><i class="icon-plus"></i> Crear un nuevo color</a> 
              -->

			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'icon'=>'plus',
			    'label'=>'Crear un nuevo color',
			    //'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			    'size'=>'small', // null, 'large', 'small' or 'mini'
			    'htmlOptions'=> array(
				      'data-toggle'=>'modal',
						'data-target'=>'#dialogColor', 
				        'onclick'=>"{addColor();}"
				       ),
				       
			)); ?>	        
				        
              </div>
            <div class="control-group">
              <label class="control-label required">Color</label>
              <div class="controls">
              	<?php
              	 $colores = Color::model()->findAll(array('order'=>'valor')); // ordena alfeticamente por nombre
				 foreach($colores as $i => $row){
					$data[$i]['text']= $row->valor;
					$data[$i]['id'] = $row->id;
				 }
				$this->widget('bootstrap.widgets.TbSelect2',array(
				'asDropDownList' => false,
	'name' => 'clevertech',
	'options' => array(
		 'placeholder'=> "Seleccione un color",
		 'multiple'=>true,
		 //'data'=>$data,
		 ////'data'=>array(array('id'=>1,'text'=>'rafa'),array('id'=>2,'text'=>'lore')),
		// 'data'=> CHtml::listData(Color::model()->findAll(),'id', 'valor'),
		 'width' => '40%',
		  
		  'ajax' => array(  
                                //'url'=> 'http://api.rottentomatoes.com/api/public/v1.0/movies.json',  
                                'url'=> CController::createUrl('color/getColores'),  
                            'dataType' => 'json',  
                            'data' => 'js: function (term,page) {  
                                        return {  
                                        //term: term, // Add all the query string elements here seperated by ,  
                                        search: term,
                                        page_limit: 10,  
                                               };  
                                                             }',        
                            'results' => 'js: function (data,page) {return {results: data};}',  
                            ),  
          //  'formatResult'    => 'js:function(data){  
                                //var markup = data.id + " - ";  
                               // markup += data.text;  
			// 					var markup = data.text;
          //                      return markup;  
         //                   }',
         //   'formatSelection' => 'js: function(data) {  
          //                      return data.text;  
          //                  }',
	),
			)
				);
				/*
              	$this->widget('bootstrap.widgets.TbSelect2', array(
	'asDropDownList' => false,
	'name' => 'clevertech',
	'options' => array(
		'tags'=>$tags,
		//'tags' => array(1=>'Negro mate',2=>'Titanio', 3=>'Azul', 4=>' Negro Violento',5=>'Agua Marina'),
		//'tags'=> CHtml::listData($colores, 
        //        'id', 'valor'),
		//'tags' => array(array('id'=>1,'text'=>'Negro mate')),
		'placeholder' => 'colores',
		'width' => '40%',
		'tokenSeparators' => array(',', ' ')
)));	
*/
?>
              	<!--
                <div class="input-append">
                  <input class="span5"  type="text">
                  <span class="add-on"><i class="icon-search"></i></span> </div>
                <div class="well margin_top_small">
                  <ul class="thumbnails thumbnails_colorer">
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Negro mate </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Titanio </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Azul </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Azul </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Azul </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Negro Violento </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Agua Marina </label>
                    </li>
                    <li>
                      <label> <img src="http://placehold.it/70"/>
                        <input type="checkbox" class="checkbox">
                        Vino tinto </label>
                    </li>
                  </ul>
                </div>
                
                <div style="display:none" class=" muted">Ayuda</div>
                -->
              </div>
            </div>
          </fieldset>
          <?php $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxButton',
		    'type'=>'primary',
		    'label'=>'Generar',
		    'loadingText'=>'loading...',
		    'url'=>array('producto/addtallacolor'),
		    'htmlOptions'=>array('id'=>'buttonStateful'),
		    'ajaxOptions'=>array(
		    	    'type' => 'POST',
		    	    
    				'beforeSend' => "function( request )
	                     {
	                       var tallas = '';
	                       $('.btn-group a.active').each(function(index){
	                       		//tallas += $(this).html()+',';
	                       		tallas += $(this).attr('href');
	                       });
						   //tallas = tallas.substring(0, tallas.length-1);
	                       var colores = '';
	                       $('.select2-search-choice div').each(function(index){
	                       		colores +=$(this).html()+ ',';
	                       });
	                       colores = colores.substring(0, colores.length-1);
	                       this.data += '&colores='+colores+'&tallas='+tallas;
	                     }",
                     'success' => "function( data )
		                  {
		                    // handle return data
		                    $('#fieldset_tallacolor').html(data);
		                  }",
		                  'data'=>array('id'=>$model->id),
			),
		)); ?>
          <fieldset class="margin_top" >
            <legend>Combinaciones: </legend>
            <div id="fieldset_tallacolor">
<?php 
	if (count($model->preciotallacolor))
		$this->renderPartial('_view_tallacolor',array('tallacolor'=>$model->preciotallacolor)); 
?></div>
          </fieldset>
        <!--
        </form>
        -->
        <hr/>
      </div>
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
                 <?php 
		 
		 $this->widget('bootstrap.widgets.TbButton', array(
				    'buttonType'=>'ajaxButton',
				    'type'=>'danger',
				    'label'=>'Guardar',
				    'block'=>'true',
				   	'size'=> 'large',
				    'url'=> CController::createUrl('producto/tallacolor',array('id'=>$model->id)) ,
				    'htmlOptions'=>array('id'=>'buttonGuardar'),
				    'ajaxOptions'=>array(
				    	    'type' => 'POST',
				    	    'data'=> "js:$('#Tallacolor-Form').serialize()",
		                    'success' => "function( data )
				                  {

				                   data = JSON.parse( data );
				                   if(data.status=='success'){
				                        $('.error').hide();
				                        $('#yw0').html('<div class=\"alert in alert-block fade alert-success\">Se guardaron las cantidades</div>');
									}else{
										id = data.id;
										delete data['id'];
				                        $.each(data, function(key, val) {
				                        	key_tmp = key.split('_');
											key_tmp.splice(1,0,id);
				                        	key = key_tmp.join('_');
					                        $('#Tallacolor-Form #'+key+'_em_').text(val);                                                    
					                        $('#Tallacolor-Form #'+key+'_em_').show();
				                        });
									}
				                  }",
					),
				)); 
		
				?> 
                <ul class="nav nav-stacked nav-tabs margin_top">
                    <li>
                    	
                 <?php 
		 
					echo CHtml::ajaxLink(
					 "Guardar y avanzar",
					CController::createUrl('producto/tallacolor',array('id'=>$model->id)),
					  array( // ajaxOptions
					    'type' => 'POST',
					    'beforeSend' => "function( request )
					                     {
											$('#fieldset_tallacolor input').each(function(){
										    if($.trim($(this).val()) == ''){
										        alert('Vacio');
										    }
											});					                     	
					                     
					                     }",
					    'success' => "function( data )
					                  {
						                   data = JSON.parse( data );
						                   if(data.status=='success'){
						                   		window.location.href = '".Controller::createUrl('producto/imagenes',array('id'=>$model->id))."';
						                        //$('.error').hide();
						                        //$('#yw0').html('<div class=\"alert in alert-block fade alert-success\">Se guardaron las cantidades</div>');
											}else{
												id = data.id;
												delete data['id'];
						                        $.each(data, function(key, val) {
						                        	key_tmp = key.split('_');
													key_tmp.splice(1,0,id);
						                        	key = key_tmp.join('_');
							                        $('#Tallacolor-Form #'+key+'_em_').text(val);                                                    
							                        $('#Tallacolor-Form #'+key+'_em_').show();
						                        });
											}
					                  }",
					    'data' => "js:$('#Tallacolor-Form').serialize()",
					  ),
					  array( //htmlOptions
					    'href' => CController::createUrl('producto/tallacolor',array('id'=>$model->id)),
					  ),
					  array('id'=>'buttonGuardar')
					);		 


				   
				 //    echo CHtml::ajaxLink(
					//   "Guardar y avanzar",
					//  CController::createUrl('producto/tallacolor',array('id'=>$model->id)),
					//   array(
				   
				 //    	    'type' => 'POST',
				 //    	    'data'=> "js:$('#Tallacolor-Form').serialize()",
				 //    	    'beforeSend '=> 'function()
				 //    	    {
				 //    	    	alert("hola");
				    	    
				 //    	    }',				                  
		   //                  'success' => "function( data )
				 //                  {

				     //               data = JSON.parse( data );
				     //               if(data.status=='success'){
				     //               		window.location.href = '".Controller::createUrl('producto/imagenes',array('id'=>$model->id))."';
				     //                    //$('.error').hide();
				     //                    //$('#yw0').html('<div class=\"alert in alert-block fade alert-success\">Se guardaron las cantidades</div>');
									// }else{
									// 	id = data.id;
									// 	delete data['id'];
				     //                    $.each(data, function(key, val) {
				     //                    	key_tmp = key.split('_');
									// 		key_tmp.splice(1,0,id);
				     //                    	key = key_tmp.join('_');
					    //                     $('#Tallacolor-Form #'+key+'_em_').text(val);                                                    
					    //                     $('#Tallacolor-Form #'+key+'_em_').show();
				     //                    });
									// }
				 //                  }",
					// ),
					// array('id'=>'buttonGuardar')
				//); 
		
				?>                     	
                    </li>
                    <li><a id="nuevo" style="cursor: pointer" title="Guardar y crear nuevo producto">Guardar y crear nuevo producto</a></li>
                    <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
                    <!-- <li><a href="#" title="Duplicar">Duplicar Producto</a></li> -->
                    <!-- <li><a href="#" title="Guardar"><i class="icon-trash"> </i> Borrar Producto</a></li> -->
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

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'dialogColor')); ?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>
<!--
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 
</div>
-->
<!------------------- MODAL WINDOW OFF ----------------->
<script type="text/javascript">
// here is the magic
function addColor()
{
    <?php echo CHtml::ajax(array(
            'url'=>array('color/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
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
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
<?php 
$script = "
	
	$('#div_tallas .btn-group').on('click', 'a', function(e) {
		if ($(this).attr('href') == '#0'){
			//alert('entro');
			$('#div_tallas a.active').each(function(){
				if ($(this).attr('href') != '#0')
					$(this).removeClass('active');
			});
			//$(this).siblings('.active').removeClass('active');
			//if (!($(this).hasClass('active')))
			
		}
		if ($('a[href=\"#0\"]').hasClass('active') && $(this).attr('href') != '#0')
			return false;
		//alert('rafa');
		//if (($(this).hasClass('active')))
				
		//if (($(this).hasClass('active')))
		//	$(this).removeClass('active');
		 //alert($(this).attr('href'));
		 /*
		 var ids = 0;
		 $(this).siblings('.active').each(function(){
		 	//alert($(this).attr('href').substring(1));
		 	ids += parseInt($(this).attr('href').substring(1));
			
		 });
		 if (!($(this).hasClass('active')))
		 	ids += parseInt($(this).attr('href').substring(1));
		
		 $(this).parent().next('input').val(ids);*/
		 //return false;
		 e.preventDefault();
	 });
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>

<script type="text/javascript">
	$('input, textArea').each(function(){
    if($.trim($(this).val()) == ''){
        console.log(this,'is empty');
    }
	});
</script>