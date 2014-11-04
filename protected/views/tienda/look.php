<?php
$personal_shopper = User::model()->findAll(array('condition' => 'personal_shopper=1'));
$categorias = Categoria::model()->findAllByAttributes(array('padreId' => '2'));
if(isset($seo)){
    $this->pageTitle = $seo->title;
    Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}

$this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'Looks Personalizados'));

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
<style>
	#mobFiltrar{
                  border: solid #FFF 1px; 
                  width: 100%; float: right; 
                  height: 28px; 
                  margin: 10px 0 10px 0; 
                  line-height: 30px; 
                  color: white; 
                  text-align: center; 
                  }

                  
               
</style>
<script>
	$(function() {
    	$( "#accordion" ).accordion({
    		collapsible:true,
    		active:false,
    		icons: { "header": "ui-icon-carat-1-e", "activeHeader": "ui-icon-carat-1-n" },
    		autoHeight: false,
   			navigation: true
    	});
  	});
	
</script>
<div class="navbar navbar-fixed-top mobilefilters" id="mobilefilters" align="center">

		<div class="container">
			
				<div class="mobileOptions">
					<div style="width:30%; float:left;">
						<?php
                    //var_dump(Yii::app()->getRequest()->getUrlReferrer());
	                    $this->widget('bootstrap.widgets.TbButton', array(
	                        
	                        //'label' => 'Todos <span class="to_cut">los looks</span>',
	                        'buttonType' => 'button',
	                 

	                        //'disabled' => true,
	                        'htmlOptions' => array(
	                            'id' => 'btnTodos',
	                            'onclick' => 'js:clickTodos()',
	                            'role' => 'button',
	                            'class' => $todosLosLooks?'':'lighted',
	                            'data-toggle' => 'modal',
	                            'value'=>'Todos <span class="to_cut">los looks</span>'
	                            
	                        ),
	                    ));
                    ?>
						
                        </div>
                        <div style="width:30%; float:left; margin: 0 5% 0 5%">
						
                        <?php
                        //parametros para saber de donde se origina la peticion
                        $params = array(
                            "ref" => "looks",
                        );
                        $this->widget('bootstrap.widgets.TbButton', array(
                        'label' =>'Looks para ti',
                        
                        'buttonType' => 'button',
                        'htmlOptions' => array(
                            'id' => 'btnMatch', 
                            'onclick' => 'js:clickPersonal('.$status_register.',"'.
                            Yii::app()->createUrl("/user/profile/tuestilo", $params).'","'.
                            Yii::app()->createUrl("/user/profile/tutipo", $params).'")',
                         'class' => $todosLosLooks?'lighted':'',   
                        ),
                    ));
						
						?>
						
					
					</div>
					<div style="width:30%; float:left;">
						<div id="mobFiltrar">
							Filtrar ››
						</div>
					</div>
					
				</div>
			
		</div>

</div>
<?php PC::debug('Execute Time (before filter):'.(microtime(true)-$time_start), 'debug,time'); ?>
<?php //TODO: Mejorar estos filtros ?>
<div class="navbar navbar-fixed-top" id="mobilefilters-expanded">

	<div class="container">
		<div id="accordion" class="hide">
			<?php
					if (count($categorias))
                                foreach ($categorias as $categoria): ?>
                                	<h3><?php echo $categoria->nombre; ?></h3>
                                    <div>
                                        <?php foreach($categoria->subcategorias as $child): ?>
                                            <label>
                                            <input type="checkbox" name="check_ocasiones[]" value="<?php echo $child->id; ?>" id="check_ocasion<?php echo $child->id;?>" onclick="js:refresh()" class="check_ocasiones">
                                              <?php echo $child->nombre; ?>
                                              </label>
                                        <?php endforeach; ?>
									</div>
                                <?php endforeach; ?>

						<?php //$rangos= Look::model()->getRangosPrecios(); ?>

            <?php PC::debug('Execute Time (before precios):'.(microtime(true)-$time_start), 'debug,time'); ?>
            <h3>Precios</h3>
                        <div id="div_rangos"></div>
            <?php Yii::app()->clientScript->registerScript('rangoprecios_mobile', "
						$.get('".Yii::app()->createUrl('tienda/rangoslookmobile')."',function(data){

							$('#div_rangos').append(data);


						})
						"); ?>


            <?php PC::debug('Execute Time (before personal shopper):'.(microtime(true)-$time_start), 'debug,time'); ?>
				<h3>Personal Shoppers</h3>	
				<div>
						
					<form id="form_shopper">
	                    <nav class="  ">
	                        

							<?php
							foreach ($personal_shopper as $shopper) {
							    //if (count($shopper->looks)) {
                                if ($shopper->haslooks){
							        ?>
                                }
							<label>
							        <input type="checkbox" name="check_shopper[]" value="<?php echo $shopper->id; ?>" id="check_ocasion<?php echo $shopper->id; ?>" onclick="js:refresh()" class="check_shopper"><?php echo $shopper->profile->first_name . ' ' . $shopper->profile->last_name; ?>
							</label>
							                                  
							        <?php
							    }
							}
							?>
	                       
	                    </nav>
	                </form>
	           </div> 
        	
		</div>
	</div>
</div>
<?php PC::debug('Execute Time (end filter):'.(microtime(true)-$time_start), 'debug,time'); ?>



<?php
$this->breadcrumbs = array(
    'Looks',
);

?>
<?php if(!Yii::app()->user->isGuest){ ?>
<img 
src="<?php echo $this->createUrl("/site/conversion"); ?>?campaignID=15920&productID=23773
&conversionType=lead&https=0&transactionID=<?php echo Yii::app()->user->id; ?>"
width="1" height="1" border="0" alt="" />
<?php } ?>


<style>
    #scroller{
        background-color: white;
    }
</style>
<script>

$("#mobFiltrar").click(function() { 
            	if($('#accordion').hasClass('hide')){
            		$('#accordion').removeClass('hide');
            	}else{
            		$('#accordion').addClass('hide');
            	}

			});

	$('#btnTodos').html('Todos <span class="to_cut">los looks</span>');
	$('#btnMatch').html('<span class="to_cut">Looks</span><span class="to_upper"> p</span>ara <span class="to_upper">t</span>i');


	$('#btn-gift').tooltip({
    title:"Hemos abonado<br/><?php echo Yii::app()->params['registerGift']." ".Yii::t('contentForm','currSym');?><br/>a tu balance para comprar YA",
    trigger:"manual",
    placement:"bottom"
    
});


	
</script>
<?php PC::debug('Execute Time (before filter guest):'.(microtime(true)-$time_start), 'debug,time'); ?>
<div id="deskfilters">
    <div class="container" id="scroller-anchor">
	   <div class="container" id="scroller">
            <div class="container">
                <div class="alert in" id="alert-msg" style="display: none">
                    <button type="button" class="close">&times;</button> 
                    
                    <div class="msg"></div>
                </div>
                
                <?php
                // este bloque no se debe mostrar si el usuario es hombre
                if((isset($user) && $user->profile->sex == 1) || !isset($user)){
                    ?>
                    <div class="margin_top_medium botones" style="width:100%">
                        <div class="btlooks">
                            <?php
                            //var_dump(Yii::app()->getRequest()->getUrlReferrer());
                            $this->widget('bootstrap.widgets.TbButton', array(
                                'label' => 'Todos los looks',
                                'buttonType' => 'button',
                                //'type' => $todosLosLooks?'danger':'',
                                //'size' => 'large',
                                //'disabled' => true,
                                'htmlOptions' => array(
                                    'id' => 'btnTodos',
                                    'onclick' => 'js:clickTodos()',
                                    'role' => 'button',
                                    'class' => $todosLosLooks?'all btn-large btn-danger':'all btn-large lighted',
                                    'data-toggle' => 'modal',
                                    
                                ),
                            ));
                            ?>
                        </div>
                        <div  class="btmatch" style="float:left; width:20%">
                            <?php
                            
                            $this->widget('bootstrap.widgets.TbButton', array(
                                'label' => 'Looks para ti',
                                'buttonType' => 'button',
                                
                                //'type' => $todosLosLooks?'':'danger',
                                //'size' => 'large',
                                'htmlOptions' => array(
                                    'id' => 'btnMatch', 
                                    'onclick' => 'js:clickPersonal('.$status_register.',"'.
                                    Yii::app()->createUrl("/user/profile/tuestilo", $params).'","'.
                                    Yii::app()->createUrl("/user/profile/tutipo", $params).'")',
                                    'class' => $todosLosLooks?'match btn-large lighted':'match btn-large btn-danger',
                                ),
                            ));
                            ?>
                        </div>
                        <div class="spacerlook">&nbsp;
          				</div>
                    </div>

                    <?php
                }
                ?>
            </div>

<!-- SUBMENU ON -->

<div class="container margin_top_medium">
    <div class="navbar  nav-inverse barra-margen">
        <div class="navbar-inner" id="barraFiltros">
            <nav class="  ">
                <ul class="nav">
                    <li class="filtros-header">Filtrar por: <?php echo Yii::app()->session['registerStep']; ?></li>
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ocasiones <b class="caret"></b></a>
                        <ul class="dropdown-menu ">
                            <?php //$categorias = Categoria::model()->findAllByAttributes(array('padreId' => '2')); ?>
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
						$.get('".Yii::app()->createUrl('tienda/rangoslook')."',function(data){
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
							    $('.price-mobile').click(function(e){
							        var id = $(this).attr('id');
							        if($('#rango_actual').val() !== id){
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
            <div id="div_shopper">
                <form id="form_shopper">
                    <nav class="  ">
                        <ul class="nav">
<?php //$personal_shopper = User::model()->findAll(array('condition' => 'personal_shopper=1')); ?>
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

    </div>
</div>

</div>

<!-- SUBMENU OFF -->
<?php PC::debug('Execute Time (end filter guest):'.(microtime(true)-$time_start), 'debug,time'); ?>
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
<?php PC::debug('Execute Time (end look):'.(microtime(true)-$time_start), 'debug,time'); ?>
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
       /*height: 225px;*/
    }
    #modalFiltroPerfil ul .thumbnail img{
       height: 225px;
    }
    
    #modalFiltroPerfil.in {
        top: 45%;
    }
    #modalFiltroPerfil{
        width: 820px
    }
    #modalFiltroPerfil .caption p{
        font-size: 13px;
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
        
<!--        <legend>
            ¿Cuáles son sus características?
        </legend>  -->

<!--        CARACTERISTICAS-->
        <div class="control-group" >
            <div class="controls row-fluid" id="caracteristicas">
                    <?php $clase = (isset($editar) && $editar) ? 'control-group span2' : 'span2'; ?>
                    <?php $claseLong = (isset($editar) && $editar) ? 'control-group span3' : 'span3'; ?>
                    <?php $clase2 = (isset($editar) && $editar) ? 'span10' : 'span8'; ?>
                
                <div class="<?php echo $clase; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'altura'));
                    echo $form->dropDownListRow($profile, $field->varname, 
                            Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
                    ?>
                </div>
                <div class="<?php echo $claseLong; ?>">
                    <?php
                    $field = ProfileField::model()->findByAttributes(array('varname' => 'contextura'));
                    echo $form->dropDownListRow($profile, $field->varname, 
                            Profile::range($field->range), array('class' => $clase2, 'prompt' => 'Ninguno'));
                    ?>
                </div>
                <div class="<?php echo $claseLong; ?>">
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
                                    <?php echo CHtml::image(Yii::app()->baseUrl .
                                            '/images/' . replace_accents($tipo) . 
                                            '.jpg', "Imagen " . $tipo,
                                            array(
//                                                "width" => "270", "height" => "400"
                                                )
                                            ); 
                                    ?>
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
  
<?php if($gift){
	echo "<script>$('#btn-gift').tooltip('show');</script>";?>
<!--<div id="myModalRegalo" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
 <div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
   <!--  <h3 id="myModalLabel">¡Enhorabuena!</h3>-->
 <!--  
  </div>
  <div class="modal-body">
 		 <h4><?php echo Yii::t('contentForm','Who said '.Yii::app()->params['registerGift'].'{currSym} is nothing ?');?></h4>
  </div>
  <div class="modal-footer">  <button class="btn closeModal" data-dismiss="modal" aria-hidden="true">Aceptar</button>
  </div>
</div>--><?php }?>

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
        //console.log(datosRefresh);
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
                        $(\'html, body\').animate({scrollTop: 0}, 300);
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
            var btnTodos = $(".botones, .botones2");
            var btn2 = $(".botones2");
            var filtros = $(".filtros-header");
            var barra = $("#barraFiltros");
            var margen = $(".barra-margen");
            
            if (st > ot - 80) {
                s.css({
                    position: "fixed",
                    top: "49px",
                });
                $(".botones").css({
                	"width":"auto",
                	"right":"3%",
                });
                $(".btlooks #btnTodos,.btmatch #btnMatch").css({
                	"width":"165px",
                	
                });
                 $(".btlooks").css({
                	"width":"auto",
                	"margin-left":"0",
                	"margin-right": "4%",
                	
                	
                });
                
                btnTodos.css({
                    position: "absolute",
                    top: "8px",
                    "z-index": 1
                });
                barra.css({
                    "padding-top": "7px",
                    "padding-bottom": "8px",
             
                    
                });
                margen.css({
                    "margin-bottom": "0px"
                });
                
                
                
                
                btn2.addClass("offset6");                
                filtros.hide();
                
            } else if (st <= ot) {
            	 $(".botones").css({
                	"width":"100%",
                	"position":"relative"
                });
                
                $(".btlooks").css({
                	"width":"20%",
                	"margin-left":"36%",
                	"margin-right": "1%",
                	
                	
                });
            	
                s.css({
                    position: "relative",
                    top: ""
                });
                btnTodos.css({
                    position: "relative",
                    top: "0px",
                    "z-index": 0
                });
                barra.css({
                    "padding-top": "0px",
                    "padding-bottom": "0px",
                    
                });
                $('#looks').css('margin-top','20px');
                margen.css({
                    "margin-bottom": "20px"
                });
                
                btn2.removeClass("offset6");
                filtros.show();
                
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
            var tiendaGetfilter = "<?php echo CController::createUrl("/tienda/getFilter"); ?>";        

            //$("#dropdownUser a.sub_perfil_item#"+idElem).click();        
            clickPerfil(idElem, tiendaGetfilter);
            //console.log("ready");

    <?php unset(Yii::app()->session["profileOn"]);
}
?>


        $("#btnShoppers").click(function(e) {
            e.preventDefault();
            if( $('.sub_menu').hasClass('hide'))
                $('.sub_menu').removeClass('hide');
            else
                $('.sub_menu').addClass('hide')
        }); 
        
        
        $(window).scroll(function() {
                $('.sub_menu').addClass('hide');

                
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

$(function() {
        moveScroller();
    });
/* 
$('.match').click(function(event) {

      if($( ".match" ).hasClass( "lighted" )) {
          $(".match").removeClass("lighted");
          $(".match").addClass("btn-danger");
          $(".all").addClass("lighted");
          $(".all").removeClass("btn-danger");
      } 
      else{
          $(".match").addClass("lighted");
          $(".match").removeClass("btn-danger");
          $(".all").removeClass("lighted");
          $(".all").addClass("btn-danger");
      }  
               
});
 
$('.all').click(function(event) {

         if($( ".all" ).hasClass( "lighted" )) {
          $(".match").addClass("lighted");
          $(".match").removeClass("btn-danger");
          $(".all").removeClass("lighted");
          $(".all").addClass("btn-danger");
      }
      else{
          $(".match").removeClass("lighted");
          $(".match").addClass("btn-danger");
          $(".all").addClass("lighted");
          $(".all").removeClass("btn-danger");
          
         
      }         
                
});
 
   */
     
 
</script>