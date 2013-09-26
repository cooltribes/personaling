
<div class="container">
  <div class="page-header">
    <h1>Todos los looks</h1>
  </div>
  <div class="alert in" id="alert-msg" style="display: none">
    <button type="button" class="close" >&times;</button> 
    <!--data-dismiss="alert"-->
    <div class="msg"></div>
  </div>
</div>

<!-- SUBMENU ON -->

<div class="container" id="scroller-anchor">
  <div class="navbar  nav-inverse" id="scroller">
    <div class="navbar-inner"  >
      <nav class="  ">
        <ul class="nav">
          <li class="filtros-header">Filtrar por:</li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ocasiones <b class="caret"></b></a>
            <ul class="dropdown-menu ">
		<?php $categorias = Categoria::model()->findAllByAttributes(array('padreId'=>'2')); ?>
        <?php 
        
        if(count($categorias))
				foreach($categorias as $categoria){
					
		?>              
              <li> 
        <?php echo CHtml::ajaxLink($categoria->nombre,
							 Yii::app()->createUrl( 'tienda/ocasiones'),
							 array( // ajaxOptions
						    'type' => 'POST',
						    'dataType'=>'json',
						    'beforeSend' => "function( request, opts )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                       if ($('#ocasion_actual').val() == '".$categoria->id."'){
						                       	 	$('.dropdown').removeClass('open');
						                       		$('#div_ocasiones').show();
						                    		$('#div_shopper').hide();
						                       	 request.abort();
						                       } 
						                       		
						                       
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                   // alert(data.accion);
						                   $('#ocasion_actual').val('".$categoria->id."');
						                   $('.dropdown').removeClass('open');
						                    $('#div_ocasiones').html(data.div);
						                    $('#div_ocasiones').show();
						                    $('#div_shopper').hide();
						                  }",
						    'data' => array( 'padreId' => $categoria->id )
						  ),
						  array( //htmlOptions
						   // 'href' => Yii::app()->createUrl( 'tienda/ocasiones' ),
						   'href'=>'#',
						    //'class' => 'thumbnail',
						    'id' => 'categoria'.$categoria->id,
						    'draggable'=>"false",
						  )
						  );    
		?>  	
              	 
              </li>
<?php } ?>              

            
            </ul>
          </li>
          <li>
          	<a href="#" onclick="js:show_shopper();" >Personal Shoppers </a>
          	
          </li>
          
            <!-- ******   Filtrar por perfil  *****    -->
          
          <?php if(Yii::app()->user->id){ ?>  
          <li>
                   <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAllByAttributes(array('type' => '0', 'user_id' => Yii::app()->user->id)),
                "id_filter", "name"), array('empty' => '-- Tus Perfiles --', 'id' => 'all_filters',
                    'style' => 'margin-bottom: 0;margin-top: 5px;')) ?>          	
          </li>
          
          <li>
             <div class="span1 hide"><a href="#" class="btn btn-danger editar-filtro"><i class="icon-white icon-edit"></i></a></div>          	
          </li>
          
          <li>
              <div class="span1"><a href="#modalFiltroPerfil" class="btn crear-filtro" data-toggle="modal"><i class="icon-plus"></i></a></div>
          	
          </li>
          <?php } ?>
          
          
          <!--
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perfil <b class="caret"></b></a>
            <ul class="dropdown-menu ">
              <li><a href="#" title="Para Mama">Para Mamá</a> </li>
                <li><a ref="#" title="Para Tia Alberta">Para Tía Alberta </a></li>
              <li><a href="#" title="Para Maria">Para Maria</a> </li>
                            <li class="divider"> </li>

              <li><a href="Crear_Perfil_Secundario_Usuaria_Mi_Tipo.php" title="Crear nuevo perfil secundario"><i class="icon-plus"></i> Crear un nuevo perfil</a> </li>
            </ul>
          </li>
          -->
        </ul>
       
        	<?php /** @var BootActiveForm $form */
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				     'id'=>'searchForm',
  					  'type'=>'search',
  					  'method'=>'get',
				    'htmlOptions'=>array( 'class'=>'navbar-search pull-right hidden-phone'),
				)); ?>
          <div class="input-append">
          <?php // Recordar que aqui va el componente Select2 de la extension del Bootstrap para Yii. La misma que esta en Talla y colores del admin ?>
          
            <?php // echo $form->textFieldRow($model, 'textField', array('placeholder'=>"Buscar por Personal Shopper",'class'=>'')); ?>
            <?php echo CHtml::textField('search','',array('placeholder'=>"Buscar en todos los looks")); ?>
            	<?php
              	/*
              	 $colores = User::model()->findAll(); //array('order'=>'first_name') ordena alfeticamente por nombre
				 foreach($colores as $i => $row){
					$data[$i]['text']= $row->profile->first_name.' '.$row->profile->last_name;
					$data[$i]['id'] = $row->id;
				 }
				$this->widget('bootstrap.widgets.TbSelect2',array(
				'asDropDownList' => false,
	'name' => 'clevertech',
	'options' => array(
		 'placeholder'=> "Buscar por Personal Shopper",
		 'multiple'=>true,
		 'data'=>$data,

	),
			)
				);*/
				?>
            <div class="btn-group">
          
              <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Buscar','type'=>'danger')); ?>
            </div>
          </div>
        <?php $this->endWidget(); ?>
      </nav>
      <!--/.nav-collapse --> 
    </div>
    <input type="hidden" value="" id="ocasion_actual" /> 
    <div class="navbar-inner sub_menu">
    	<div id="div_ocasiones"></div>
		<div id="div_shopper" style="display: none">
				<form id="form_shopper">
					 <nav class="  ">
					        <ul class="nav">
					        	<?php $personal_shopper = User::model()->findAll(array('condition'=>'personal_shopper=1'));	?>
								<?php foreach($personal_shopper as $shopper){?>
					          <li>
					            <label>
					              <input type="checkbox" name="check_shopper[]" value="<?php echo $shopper->id; ?>" id="check_ocasion<?php echo $shopper->id;?>" onclick="js:refresh()" class="check_shopper"><?php echo $shopper->profile->first_name.' '.$shopper->profile->last_name; ?>
					            </label>
					          </li>	
								<?php } ?>
					        </ul>
					 </nav>
				 </form> 
    	</div>    	    
    </div>
  </div>
</div>

<!-- SUBMENU OFF -->
<div class="container" id="tienda_looks">
<?php 
$this->renderPartial('_look',array(
	'looks'=>$looks,
	'pages'=>$pages,
)); 
?>
</div>
  
<!-- /container -->
<<<<<<< HEAD
=======
<style>
    #modalFiltroPerfil{
        width: 880px;
        left: 40%;
        top: -100%;
    }    
    #modalFiltroPerfil.in{
        top: 38%;
    }
    #modalFiltroPerfil.in > .modal-body{
        max-height: 580px;
    }
    
    img.loadingImg{
        margin: 0;
        padding: 0;
    }
    
</style>
>>>>>>> 717dd5a88176a1adee44dd6e8181a67af8237d93



<?php
function replace_accents($string) 
{ 
  return str_replace( array(' ','à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('','a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string); 
} 

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filtersLooks.js");

$this->beginWidget('bootstrap.widgets.TbModal', array(
                                'id' => 'modalFiltroPerfil',
                            ),
                            array(
                                'class' => 'modal span9 hide fade',
                                'tabindex' => "-1",
                                'role' => "dialog",
                                'aria-labelledby' => "myModalLabel",
                                'aria-hidden' => "true",
                                'style' => "display: none;",
                            
                            ))?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Perfil Corporal</h3>
    </div>
    <div class="modal-body margin_top_medium">
        
      <?php 
      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
          'id' => 'newFilter-form',
          //'htmlOptions' => array('enctype' => 'multipart/form-data'),
          'type' => 'horizontal',
          'htmlOptions'=>array('class'=>'personaling_form'),    
          'type'=>'inline',
          'enableClientValidation' => true,
          'enableAjaxValidation' => true,
          'clientOptions' => array(
              'validateOnSubmit' => true,
          ),
      ));
      ?>
      <?php // echo $form->errorSummary(array($modelUser,$profile)); ?>
      <fieldset> 
        
       <div class="control-group" >
              <div class="controls row-fluid" id="caracteristicas">
                <?php $clase = (isset($editar) && $editar)?'control-group span2':'span2'; ?>
                <?php $clase2 = (isset($editar) && $editar)?'span10':'span8'; ?>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));
  				  	echo $form->dropDownListRow($profile,
                                        $field->varname,Profile::range($field->range), 
                                        array('class'=>$clase2, 'prompt' => 'Seleccione'));
                                        
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));
  				  	echo $form->dropDownListRow($profile,$field->varname,
                                        Profile::range($field->range),
                                        array('class'=>$clase2, 'prompt' => 'Seleccione'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));
  				  	echo $form->dropDownListRow($profile,$field->varname,
                                        Profile::range($field->range),
                                        array('class'=>$clase2, 'prompt' => 'Seleccione'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));
  				  	echo $form->dropDownListRow($profile,$field->varname,
                                        Profile::range($field->range),
                                        array('class'=>$clase2, 'prompt' => 'Seleccione'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));
  				  	echo $form->dropDownListRow($profile,$field->varname,
                                        Profile::range($field->range),
                                        array('class'=>$clase2, 'prompt' => 'Seleccione'));
                    ?>
                </div>
              </div>
          </div>
        
          <div class="control-group">
              <div class="controls row-fluid">
                  <?php
                  $field = ProfileField::model()->findByAttributes(array('varname' => 'tipo_cuerpo'));
                  echo $form->hiddenField($profile, $field->varname);
                  $nombre_tmp = $field->varname;
                  
                  $tipoActivo = isset($profile->$nombre_tmp)? $profile->$nombre_tmp:'';
                  
                  ?>
                  <ul class="thumbnails" id="tipo_cuerpo">
                    <?php foreach (Profile::range($field->range) as $key => $tipo) { ?>
                          
                          <li class="span3 <?php if ($tipoActivo == $key) echo 'active'; ?>" id="tipo_<?php echo $key; ?>">
                             <a href="#" title="Elegir este tipo de cuerpo">
                                  <div class="thumbnail" style="height:410px"> 
                                      <?php echo CHtml::image(Yii::app()->baseUrl . '/images/' . replace_accents($tipo) . '.jpg', "Imagen " . $tipo, array("width" => "270", "height" => "400")); ?>
                                      <div class="caption text_align_center CAPS">
                                          <p ><?php echo $tipo; ?></p>
                                      </div>
                                      <caption>
                                          <p class="  color6 text_align_center ">                  
                                              <?php
                                              switch ($key){
                                              case 1:
                                                  echo "Tus hombros y caderas están casi alineados y tu cintura no es tan definida";
                                                  break;
                                              case 2:
                                                  echo "Tus hombros y caderas están alineados y tu cintura es muy definida";
                                                  break;
                                              case 4:
                                                  echo "Tu cuerpo es triángulo si tienes hombros y cintura pequeñita con unas caderas pronunciadas";
                                                  break;
                                              case 8:
                                                  echo "Tu eres proporcionalmente de hombros anchos y caderas pequeñitas";
                                                  break;
                                              }
                                              ?>
                                          </p>
                                      </caption>                    
                                  </div>
                              </a>    

                          </li>
                    <?php } ?>
                  </ul>
              </div>
          </div>   
                      
      </fieldset>
    
    <?php $this->endWidget(); ?>
        
  <div class="modal-footer">
    <div class="span6">
      <div class="control-group form-inline  pull-left" id="campo-nombre">
          <!--[if IE]>
            <?php echo CHtml::label("Indica un nombre para el perfil:", "profile-name", array('class' => 'control-label')); ?>
          <![endif]-->
          <?php echo CHtml::textField('profile-name' ,'', array('placeholder'=>'Nombre del look')); ?>
          <?php //echo CHtml::error($model, $attribute)?>
          <button id="save" class="btn btn-danger controls hide">Guardar Perfil</button>
          <button id="remove" class="btn controls hide">Borrar Perfil</button>
          <?php
          $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType' => 'button',
              'label' => 'Guardar',
              'type' => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
              //'size' => 'large', // null, 'large', 'small' or 'mini'
              //'block' => 'true',
              'htmlOptions' => array('id' => 'save-search','class'=>'controls'),//'onclick' => 'js:$("#newFilter-form").submit();')
          ));
          ?>    
      </div>         
    
<<<<<<< HEAD
    </div>
    <div class="span2">
=======
    <button id="save" class="btn btn-danger pull-left hide">Guardar Perfil</button>
    <button id="remove" class="btn pull-left hide">Borrar Perfil</button>
    
    
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'label' => 'Guardar y Buscar',
        'type' => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        //'size' => 'large', // null, 'large', 'small' or 'mini'
        //'block' => 'true',
        'htmlOptions' => array('id' => 'save-search', 'class' => 'pull-left span2'),//'onclick' => 'js:$("#newFilter-form").submit();')
    ));
    ?>    
    
    <img class="imgloading loadingImg" id="imgloading4" src="../images/loading.gif" alt="Loading" style="display: none;">
    
>>>>>>> 717dd5a88176a1adee44dd6e8181a67af8237d93
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
  </div>                    

<?php $this->endWidget()?>
                
<script type="text/javascript">
    

    var actionGuardarFiltro = '<?php echo $this->createUrl('guardarFiltro'); ?>';
 
    $('#remove').click(function(e) {        
        removeFilter('<?php echo $this->createUrl('/orden/removeFilter'); ?>');
    });  
    
    
function show_shopper(){
	$('#div_ocasiones').hide();
	$('#div_shopper').show();
}
// here is the magic
function refresh()
{
	//alert($('.check_ocasiones').serialize());
	//alert($('.check_ocasiones').length) 
       
       
    cargarLocal();
    <?php echo CHtml::ajax(array(
            'url'=>array('tienda/look'),
            'data'=> "js:$('.check_ocasiones, .check_shopper, #newFilter-form').serialize()",
            //'data' => array( 'ocasiones' => 55 ),
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
                   //	alert(data.condicion);
                   $('#tienda_looks').html(data.div);
                   // setTimeout(\"$('#dialogColor').modal('hide') \",3000);
                }
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
<script>
function moveScroller() {
    var move = function() {
        var st = $(window).scrollTop();
        var ot = $("#scroller-anchor").offset().top;
        var s = $("#scroller");
        if(st > ot) {
            s.css({
                position: "fixed",
                top: "60px",
            });
        } else {
            if(st <= ot) {
                s.css({
                    position: "relative",
                    top: ""
                });
            }
        }
    };
    $(window).scroll(move);
    move();
}
       function encantar(idLook)
       {
           //var idLook = $("#idLook").attr("value");
           //alert("id:"+idLook);

           $.ajax({
            type: "post",
            url: "<?php echo $this->createUrl("look/encantar"); ?>", // action Tallas de look
            data: { 'idLook':idLook},
            success: function (data) {

                if(data=="ok")
                {
                    var a = "♥";

                    //$("#meEncanta").removeClass("btn-link");
                    $("#meEncanta"+idLook).addClass("btn-link-active");
                    $("span#like"+idLook).text(a);

                }

                if(data=="no")
                {
                    alert("Debe primero ingresar como usuario");
                    //window.location="../../user/login";
                }

                if(data=="borrado")
                {
                    var a = "♡";

                    //alert("borrando");

                    $("#meEncanta"+idLook).removeClass("btn-link-active");
                    $("span#like"+idLook).text(a);

                }

               }//success
           })


       }
</script>
<script type="text/javascript"> 
  $(function() {
    moveScroller();
  });
</script>