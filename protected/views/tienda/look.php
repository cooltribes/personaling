<?php
$this->pageTitle = 'Looks';
Yii::app()->clientScript->registerMetaTag('Looks', 'title', null, null, null);
Yii::app()->clientScript->registerMetaTag('Looks personalizados por expertos en moda: celebrities, fashion bloggers y personal shoppers', 'description', null, null, null);
Yii::app()->clientScript->registerMetaTag('personal shopper online, ropa online, looks, asesoría ropa personalizada, moda, fashion bloggers, personal shopper gratis', 'keywords', null, null, null);
?>
<?php 
if(isset($_GET['fb']) && $_GET['fb'] == 'true'){
    Yii::app()->clientScript->registerScript('script1', "<!-- Facebook Conversion Code for Leads España -->
    var fb_param = {};
    fb_param.pixel_id = '6016397659254';
    fb_param.value = '0.01';
    fb_param.currency = 'EUR';
    (function(){
    var fpw = document.createElement('script');
    fpw.async = true;
    fpw.src = '//connect.facebook.net/en_US/fp.js';
    var ref = document.getElementsByTagName('script')[0];
    ref.parentNode.insertBefore(fpw, ref);
    })();
    ", CClientScript::POS_HEAD, 1);
} 

$this->breadcrumbs = array(
    'Tu Personal Shopper',
);
$user = User::model()->findByPk(Yii::app()->user->id);
$status_register = -1;
$perfil_propio = 1;
if (isset($user)){
	$status_register = 	$user->status_register;
	 if ($user->status_register !=User::STATUS_REGISTER_ESTILO)
	 	$perfil_propio = 0;
} else {
	$perfil_propio = 0; 
}	
 $model = new RegistrationForm;
?>

<div class="container">
    <div class="span12">
        <!--    <h1>Todos los looks</h1>-->

        <div class="row-fluid margin_bottom_medium">
            <div class="span6 text_align_right">
                <?php
                //var_dump(Yii::app()->getRequest()->getUrlReferrer());
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Todos los looks',
                    'buttonType' => 'button',
                    'type' => $todosLosLooks?'danger':'',
                    'size' => 'large',
                    //'disabled' => true,
                    'htmlOptions' => array(
                        'id' => 'btnTodos',
                        'onclick' => 'js:clickTodos()',
                        'role' => 'button',
                        'class' => $todosLosLooks?'':'btn-rectangle',
                        'data-toggle' => 'modal',
                    ),
                ));
                ?>
            </div>
            <div class="span6">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Looks para ti',
                    'buttonType' => 'button',
                    
                    'type' => $todosLosLooks?'':'danger',
                    'size' => 'large',
                    'htmlOptions' => array(
                        'id' => 'btnMatch', 
                        'onclick' => 'js:clickPersonal('.$status_register.',"'.Yii::app()->createUrl("/user/profile/tuestilo").'","'.Yii::app()->createUrl("/user/profile/tutipo").'")',
                        'class' => $todosLosLooks?'btn-rectangle':'',
                    ),
                ));
                ?>
            </div>
        </div>


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
                    <li class="filtros-header">Filtrar por: <?php echo Yii::app()->session['registerStep']; ?></li>
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ocasiones <b class="caret"></b></a>
                        <ul class="dropdown-menu ">
                            <?php $categorias = Categoria::model()->findAllByAttributes(array('padreId' => '2')); ?>
                            <?php
                            if (count($categorias))
                                foreach ($categorias as $categoria) {
                                    ?>              

                                    <?php
                                    $children = $categoria->getChildren();
                                    $show = false;
                                    foreach ($children as $child) {
                                        if ($child->hasLooks()) {
                                            $show = true;
                                            break;
                                        }
                                    }
                                    if ($show) {
                                        ?>    

                                        <li> 
                                            <?php
                                            echo CHtml::ajaxLink($categoria->nombre, Yii::app()->createUrl('tienda/ocasiones'), array(// ajaxOptions
                                                'type' => 'POST',
                                                'dataType' => 'json',
                                                'beforeSend' => "function( request, opts )
                                 {
                                   // Set up any pre-sending stuff like initializing progress indicators
                                   if ($('#ocasion_actual').val() == '" . $categoria->id . "'){
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
                               $('#ocasion_actual').val('" . $categoria->id . "');
                               $('.dropdown').removeClass('open');
                                $('#div_ocasiones').html(data.div);
                                $('#div_ocasiones').show();
                                $('#div_shopper').hide();
                                $('.sub_menu').removeClass('hide');
                              }",
                                                'data' => array('padreId' => $categoria->id)
                                                    ), array(//htmlOptions
                                                // 'href' => Yii::app()->createUrl( 'tienda/ocasiones' ),
                                                'href' => '#',
                                                //'class' => 'thumbnail',
                                                'id' => 'categoria' . $categoria->id,
                                                'draggable' => "false",
                                                    )
                                            );
                                            ?>  	

                                        </li>
                                        <?php
                                    } //endif show
                                }
                            ?>              


                        </ul>
                    </li>
                    <!-- Filtro por Precios ON -->
                    <style>
                        li.active-range a{
                            color: #ffffff;
                            background: #6d2d56;
                        }
                    </style>
                    <li id="li_rangos" class="dropdown">

                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Precios <b class="caret"></b></a> 
						<?php Yii::app()->clientScript->registerScript('rangoprecios', "
						$.get('/develop/tienda/rangoslook',function(data){
							$('#li_rangos').append(data);
							    $('#price-ranges a.price-filter').click(function(e){
							        var id = $(this).attr('id');
							        if($('#rango_actual').val() !== id){
							            $(this).parent().siblings().removeClass('active-range');
							            $(this).parent().addClass('active-range');
							            $('#rango_actual').val(id); 
							            refresh();
							        }
							    });
						})
						"); ?>

                    </li>
                    <!-- Filtro por Precios OFF -->
                    <li>
                        <a id="btnShoppers" href="" onclick="js:show_shopper();" >Personal Shoppers </a>

                    </li>

                    <!-- ******   Filtrar por perfil  *****    -->

                        <?php if (Yii::app()->user->id && false) { ?>  
                        <li>
    <?php
    echo CHtml::dropDownList("Filtros", "", CHtml::listData(Filter::model()->findAllByAttributes(array('type' => '0', 'user_id' => Yii::app()->user->id)), "id_filter", "name"), array('empty' => '-- Tus Perfiles --', 'id' => 'all_filters', 'class' => 'input-medium',
        'style' => 'margin-bottom: 0;margin-top: 5px;'))
    ?>          	
                        </li>


                        <li>
                            <div class="margin_left_small"><a href="#modalFiltroPerfil" class="btn btn-danger crear-filtro" data-toggle="modal"><i class="icon-plus icon-white"></i>Nuevo perfil</a></div>

                        </li>
                        <li>
                            <div class="margin_left_small hide"><a href="#" class="btn  editar-filtro"><i class="icon-edit"></i>Editar Perfil</a></div>          	
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
                /*
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
                  ); *//*
                  ?>
                  <div class="btn-group">

                  <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Buscar','type'=>'danger')); ?>
                  </div>
                  </div>
                  <?php $this->endWidget(); */
                ?>
            </nav>
            <!--/.nav-collapse --> 
        </div>
        <input type="hidden" value="" id="ocasion_actual" />

        <input type="hidden" id="rango_actual" name="precios" value="" />     
        <input type="hidden" id="perfil_propio" name="perfil_propio" value="<?php echo $perfil_propio; ?>" />     


        <div class="navbar-inner sub_menu hide">
            <div id="div_ocasiones"></div>
            <div id="div_shopper" style="display: none">
                <form id="form_shopper">
                    <nav class="  ">
                        <ul class="nav">
<?php $personal_shopper = User::model()->findAll(array('condition' => 'personal_shopper=1')); ?>
<?php
foreach ($personal_shopper as $shopper) {
    if (count($shopper->looks)) {
        ?>

                                    <li>
                                        <label>
                                            <input type="checkbox" name="check_shopper[]" value="<?php echo $shopper->id; ?>" id="check_ocasion<?php echo $shopper->id; ?>" onclick="js:refresh()" class="check_shopper"><?php echo $shopper->profile->first_name . ' ' . $shopper->profile->last_name; ?>
                                        </label>
                                    </li>	
        <?php
    }
}
?>
                        </ul>
                    </nav>
                </form> 
            </div>    	    
        </div>
    </div>
</div>

<!-- SUBMENU OFF -->
<div class="container" id="tienda_looks">
    <?php if(empty($looks)){ ?>
    <p>
       Ups! Estamos seguros que con un pequeño cambio en alguna característica
       encontraremos un look para ti. Nuestros Personal Shoppers se mueren por
       ayudarte, vuelve a intentarlo
    </p>
        
    <?php } ?>
<?php
$this->renderPartial('_look', array(
    'looks' => $looks,
    'pages' => $pages,
));
?>
</div>

<!-- /container -->
<?php

function replace_accents($string) {
    return str_replace(array(' ', 'à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý'), array('', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y'), $string);
}

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/filtersLooks.js");

$this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'modalFiltroPerfil',
        ), array(
    'class' => 'modal span9 hide fade',
    'tabindex' => "-1",
    'role' => "dialog",
    'aria-labelledby' => "myModalLabel",
    'aria-hidden' => "true",
    'style' => "display: none;",
))
?>
<style>
    #modalFiltroPerfil legend{
        line-height: 32px;
        margin-bottom: 0px;
    }

    #modalFiltroPerfil.in > .modal-body {
        max-height: 657px;
    }
    
    .thumbnails > li.margin_bottom_zero{
        margin-bottom: 0;
    }

    #modalFiltroPerfil ul .thumbnail{
       height: 225px;
    }
    
    #modalFiltroPerfil.in {
        top: 45%;
    }
    
</style>
<!--MODAL HEADER-->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Crea un perfil para alguien más (Una amiga, tu mamá, etc.)</h3>
</div>
<!--MODAL BODY-->
<div class="modal-body ">
    <!--NOMBRE PERFIL-->
    <div class="control-group form-inline" >
        <div id="campo-nombre">
            <?php echo CHtml::label("¿Para quién vas a comprar?", "profile-name", array('class' => 'control-label margin_right_small')); ?>
            <?php echo CHtml::textField('profile-name', '', array('placeholder' => 'Escribe su nombre')); ?> 
        </div>
    </div>   
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'newFilter-form',
        //'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'personaling_form'),
        'type' => 'inline',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <?php // echo $form->errorSummary(array($modelUser,$profile));  ?>
    <fieldset>    
        <legend>
            ¿Cuáles son sus características?
        </legend>  

<!--        CARACTERISTICAS-->
        <div class="control-group" >
            <div class="controls row-fluid" id="caracteristicas">
                    <?php $clase = (isset($editar) && $editar) ? 'control-group span2' : 'span2'; ?>
                    <?php $clase2 = (isset($editar) && $editar) ? 'span10' : 'span8'; ?>
                <div class="<?php echo $clase; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'altura'));
                    echo $form->dropDownListRow($profile, $field->varname, 
                            Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'contextura'));
                    echo $form->dropDownListRow($profile, $field->varname, 
                            Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'pelo'));
                    echo $form->dropDownListRow($profile, $field->varname, 
                            Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'ojos'));
                    echo $form->dropDownListRow($profile, $field->varname, 
                            Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'piel'));
                    echo $form->dropDownListRow($profile, $field->varname, Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
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

                $tipoActivo = isset($profile->$nombre_tmp) ? $profile->$nombre_tmp : '';
                ?>
                <!--UL TIPO DE CUERPO-->
                <ul class="thumbnails" id="tipo_cuerpo">
                <?php foreach (Profile::range($field->range) as $key => $tipo) { ?>

                        <li class="span3 margin_bottom_zero <?php if ($tipoActivo == $key) echo 'active'; ?>" id="tipo_<?php echo $key; ?>">
                            <a href="#" title="Elegir este tipo de cuerpo">
                                <div class="thumbnail"> 
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/' . replace_accents($tipo) . '.jpg', "Imagen " . $tipo, array("width" => "270", "height" => "400")); ?>
                                    <div class="caption text_align_center CAPS">
                                        <p ><?php echo $tipo; ?></p>
                                    </div>
<!--                                    <caption>
                                        <p class="  color6 text_align_center margin_top_small_minus  ">                  
                                    <?php
                                    switch ($key) {
                                        case 1:
                                            echo "Los hombros y caderas están casi alineados y la cintura no es tan definida";
                                            break;
                                        case 2:
                                            echo "Los hombros y caderas están alineados y la cintura es muy definida";
                                            break;
                                        case 4:
                                            echo "Los hombros y la cintura es pequeñita con unas caderas pronunciadas";
                                            break;
                                        case 8:
                                            echo "Los hombros proporcionalmente anchos y caderas pequeñitas";
                                            break;
                                    }
                                    ?>
                                        </p>
                                    </caption>                    -->
                                </div>
                            </a>    

                        </li>
                                        <?php } ?>
                </ul>
            </div>
        </div>   

    </fieldset>

<?php $this->endWidget(); ?>

     
</div> 
<!--MODAL FOOTER-->
<div class="modal-footer margin_top_medium_minus">
    
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'label' => 'Guardar y Seleccionar Perfil',
        'type' => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        //'size' => 'large', // null, 'large', 'small' or 'mini'
        //'block' => 'true',
        'htmlOptions' => array('id' => 'save-search', 'class' => 'controls'), //'onclick' => 'js:$("#newFilter-form").submit();')
    ));
    ?> 
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    
</div>  
<?php $this->endWidget() ?>

<!-- Modal Registro ON -->
<div id="ModalRegistro" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl("/user/registration"),
	'id'=>'registration-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
            <h4 class="text_align_center">
                ¿No tienes todavía cuenta? ¿Qué estás esperando?<br><br>
                Registrate aquí 
            </h4>
            <div class="row" id="boton_facebook">
                <a title="Registrate con facebook" class="transition_all span3 offset1" href="#">Regístrate con Facebook</a>
            </div>
            <section class="bg_color3 margin_top_xsmall  padding_small_top padding_small_right padding_small_left">
        
                    <fieldset>
                        <legend class="text_align_center no_margin_bottom">O <br> llena los campos a continuación: </legend>  
                        <div class="control-group row-fluid">
                        	<div class="controls">
                        	<!--[if IE 9]> 
                        		<label>Correo:</label>
                        	<![endif]--> 
                        	<?php echo $form->textFieldRow($model,'email',array("class"=>"span12")); 
                        	echo $form->error($model,'email');
                        	?>
                        	</div>
                        </div>

                        <div class="control-group row-fluid">
                        	<div class="controls">	
                        	<!--[if IE 9]> 
                        		<label>Contraseña:</label>
                        	<![endif]--> 
                        	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span12')); 
                        	echo $form->error($model,'password');
                        	?>
                        	</div>
                        </div>
                           <hr>
                    </fieldset>
  
            </section>
    </div>    
    <div class="modal-footer">        
        		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
		    'label'=>'Siguiente',
		    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'large', // null, 'large', 'small' or 'mini'
		   'htmlOptions'=>array('class'=>'span5'),
		)); ?>
    </div>
    <p class="text_align_center">Si ya tienes cuenta accede <a href="<?php echo Yii::app()->getBaseUrl(); ?>/user/login/">de manera habitual.</a></p>
    <?php $this->endWidget(); ?>  
</div>
<a href="#" id="gotop" class="go-top" title="<?php echo Yii::t('contentForm','Back to top'); ?>"><img src="<?php echo Yii::app()->baseUrl."/images/backtop.png"; ?>" /></a>

<?php if(true){?>
<div id="myModalRegalo" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">¡Enhorabuena!</h3>
   
  </div>
  <div class="modal-body">
 		 <h4><?php echo Yii::t('contentForm','Who said '.Yii::app()->params['registerGift'].'{currSym} is nothing ?');?></h4>
  </div>
  <div class="modal-footer">  <button class="btn closeModal" data-dismiss="modal" aria-hidden="true">Aceptar</button>
  </div>
</div><?php }?>

<!-- Modal Registro OFF -->

 



<script type="text/javascript">


    var actionGuardarFiltro = '<?php echo $this->createUrl('guardarFiltro'); ?>';

    $('#remove').click(function(e) {
        removeFilter('<?php echo $this->createUrl('/orden/removeFilter'); ?>');
    });


    function show_shopper() {
        $('#div_ocasiones').hide();
        $('#div_shopper').show();
    }
// here is the magic
// magic ???
    function refresh(reset)
    {
        if ($("#looks").infinitescroll)
            $("#looks").infinitescroll("destroy");

        cargarLocal();
        var datosRefresh = $('.check_ocasiones, .check_shopper, #newFilter-form, #rango_actual, #perfil_propio').serialize();

        if (reset) {
            datosRefresh += '&reset=true';
        }
        console.log(datosRefresh);
<?php
echo CHtml::ajax(array(
    'url' => array('tienda/look'),
    'data' => "js:datosRefresh",
    //'data' => array( 'ocasiones' => 55 ),
    'type' => 'post',
    'dataType' => 'json',
    'global' => 'false',
    'beforeSend' => 'function(){
                        $("body").addClass("aplicacion-cargando");

            }',
    'complete' => 'function(){
                        $("body").removeClass("aplicacion-cargando");
                        
                    }',
    'success' => "function(data)
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
                  // $('#tienda_looks').html(data);
                   // setTimeout(\"$('#dialogColor').modal('hide') \",3000);
                }
                
                
 
            } ",
))
?>;
                                return false;

                            }

</script>
<script>
    function moveScroller() {
        var move = function() {
            var st = $(window).scrollTop();
            var ot = $("#scroller-anchor").offset().top;
            var s = $("#scroller");
            if (st > ot) {
                s.css({
                    position: "fixed",
                    top: "60px",
                });
            } else {
                if (st <= ot) {
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
            dataType: 'json',
            url: "<?php echo $this->createUrl("look/encantar"); ?>", // action Tallas de look
            data: {'idLook': idLook},
            success: function(data) {

                if (data.mensaje == "ok")
                {
                    var a = "♥";

                    //$("#meEncanta").removeClass("btn-link");
                    $("#meEncanta" + idLook).addClass("btn-link-active");
                    $("span#like" + idLook).text(a);

                }

                if (data.mensaje == "no")
                {
                    alert("Debe primero ingresar como usuario");
                    //window.location="../../user/login";
                }

                if (data.mensaje == "borrado")
                {
                    var a = "♡";

                    //alert("borrando");

                    $("#meEncanta" + idLook).removeClass("btn-link-active");
                    $("span#like" + idLook).text(a);

                }

            }//success
        })

    }

    $(document).ready(function() {

        //Si venia de otro lugar para crear un perfil
<?php
if (isset(Yii::app()->session["modalOn"])) {
    unset(Yii::app()->session["modalOn"]);
    ?>
            $("#modalFiltroPerfil").modal("show");
<?php } ?>

<?php if (isset(Yii::app()->session["profileOn"])) { ?>
            var idElem = "<?php echo Yii::app()->session["profileOn"] ?>";

            //$("#dropdownUser a.sub_perfil_item#"+idElem).click();        
            clickPerfil(idElem);
            //console.log("ready");

    <?php unset(Yii::app()->session["profileOn"]);
}
?>


        $("#btnShoppers").click(function(e) {
            e.preventDefault();
            $('.sub_menu').removeClass('hide');
        });
        
        
        $(window).scroll(function() {
				if ($(this).scrollTop() > 200&&$(this).scrollTop()+200<$('#wrapper_footer').offset().top) {
					
					$('.go-top').fadeIn(600);
				} else if ($(this).scrollTop() > 200) 
					
					$('.go-top').fadeIn(600);
				
				 else {
					$('.go-top').fadeOut(600);
				}

			});
			
			// Animate the scroll to top
			$('.go-top').click(function(event) {
				event.preventDefault();
				
				$('html, body').animate({scrollTop: 0}, 300);
			});
			
			$('.closeModal').click(function(event) {
				$('#myModalRegalo').remove();
			});

 
    });


</script>

<script type="text/javascript">

    $(function() {
        moveScroller();
    });
</script>





