<?php

/* @var $form TbActiveForm */

//$this->breadcrumbs=array(
	//'Usuarios',
//);


$usuarios_totales = User::model()->count();
$usuarios_activos = User::model()->countByAttributes(array('status'=>1));
$usuarios_inactivos = User::model()->countByAttributes(array('status'=>0));
$personal_shoppers = User::model()->countByAttributes(array('personal_shopper'=>1));
$aplicantesPs = User::model()->countByAttributes(array('personal_shopper'=>2));
$usuarios_facebook = User::model()->count('facebook_id IS NOT NULL');
$usuarios_twitter = User::model()->count('twitter_id IS NOT NULL');

?>
<div class="container margin_top">

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
    
  <div class="page-header">
    <h1>Administrar usuarios</h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_totales; ?></p>
        Usuarios Totales</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_activos; ?></p>
        Usuarios Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_inactivos; ?></p>
        Usuarios Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $personal_shoppers; ?></p>
        Personal Shoppers</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $aplicantesPs; ?></p>
        Aplicantes a PS</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_facebook; ?></p>
        Usuarios de Facebook </td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_twitter; ?> </p>
        Usuarios de Twitter</td>
    </tr>
  </table>
  <hr/>
  <div class="row margin_top margin_bottom ">
    <div class="span4">
    	<?php
    	echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id'=>'search-form'))
			. '<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>'
		    . CHtml::textField('nombre', (isset($_GET['string'])) ? $_GET['string'] : '', array('id'=>'textbox_buscar', 'class'=>'span3', 'placeholder'=>'Buscar'))
		    . CHtml::endForm();
			
		?>
      
        
      </div>
    </div>
    <div class="span3">
        <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 3'),
                "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters')) ?>
    </div>
    <div class="span3"><a href="#" class="btn crear-filtro">Crear búsqueda avanzada</a></div>
    <div class="span2"><a href="#modalNuevoUsuario" class="btn btn-success" data-toggle="modal">Crear usuario</a></div>
  </div>

    <hr/>
        <?php  $this->renderPartial("_filters"); ?>
    <hr/>
   <?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped table-condensed">
    <tr>
      <th rowspan="2" scope="col"><input name="Check" type="checkbox" value="Check"></th>
      <th colspan="3" rowspan="2" scope="col">Usuario</th>
      <th colspan="2" scope="col">Pedidos</th>
      <th rowspan="2" scope="col">Saldo Disponible</th>
      <th colspan="2" scope="col">Ingresos al Portal</th>
      <th rowspan="2" scope="col">Fecha de Registro</th>
      <th rowspan="2" scope="col"></th>
    </tr>
        <tr>
      <th scope="col">Pedidos</th>
      <th scope="col">Direcciones</th>
      <th scope="col">#</th>
      <th scope="col">Ultima Fecha</th>
    </tr>
    {items}
    </table>
    {pager}
	';
	$pagerParams=array(
            'header'=>'',
            'prevPageLabel' => Yii::t('contentForm','Previous'),
            'nextPageLabel' => Yii::t('contentForm','Next'),
            'firstPageLabel'=> Yii::t('contentForm','First'),
            'lastPageLabel'=> Yii::t('contentForm','Last'),
            'htmlOptions'=>array(
                'class'=>'pagination pagination-right'));
	

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_user',
	    'template'=>$template,
	    'summaryText' => "Mostrando {start} - {end} de {count} Resultados",
	    'afterAjaxUpdate'=>" function(id, data) {
								
		
							/*$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});*/
						   
							} ",
		'pager'=>$pagerParams,					
	));    
	
	
	Yii::app()->clientScript->registerScript('search',
	    "var ajaxUpdateTimeout;
	    var ajaxRequest;
	    $('#textbox_buscar').keyup(function(e){
	    	
			
			if(e.which == 13) {
                        
                        $('.crear-filtro').click();
				
				ajaxRequest = $(this).serialize();
	        clearTimeout(ajaxUpdateTimeout);
	        ajaxUpdateTimeout = setTimeout(function () {
	            $.fn.yiiListView.update(
	// this is the id of the CListView
	                'list-auth-items',
	                {data: ajaxRequest}
	            )
	        },
	// this is the delay
	        300);
		        
		    }
	        	/*else{
	        		
	        		window.location.href = document.URL;
	        	}*/
				
				
				
	        
	    });"
	);
		
	
	?> 
	
  <hr/>
   <div class="row">
   	<div class="margin_top pull-left">
      <a href="<?php echo Yii::app()->baseUrl."/user/admin/reportexls" ?>" title="Exportar a Excel" class="btn btn-info">Exportar a Excel</a>
      <a href="<?php echo Yii::app()->baseUrl."/user/admin/usuariosZoho" ?>" title="Exportar Usuarios Zoho" class="btn btn-info">Exportar Usuarios Zoho</a>
    </div>
  <!--<div class="span3"><select class="span3">
        <option>Seleccionar usuarios</option>
        <option>Lorem</option>
        <option>Ipsum 2</option>
        <option>Lorem</option>
      </select></div>
      <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>-->
   </div>
</div>
<!-- /container -->



<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
                                'id' => 'modalNuevoUsuario',
                            ),
                            array(
                                'class' => 'modal fade hide',
                                'tabindex' => "-1",
                                'role' => "dialog",
                                'aria-labelledby' => "myModalLabel",
                                'aria-hidden' => "true",
                                'style' => "display: none;",
                            
                            ))?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Registrar usuario</h3>
    </div>
    <div class="modal-body">
      <?php
      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
          'id' => 'newUser-form',
          'htmlOptions' => array('enctype' => 'multipart/form-data'),
          'type' => 'horizontal',
          // 'type'=>'inline',
          //'enableClientValidation' => true,
          'enableAjaxValidation' => true,
          'clientOptions' => array(
              'validateOnSubmit' => true,
          ),
      ));
      ?>
      <?php echo $form->errorSummary(array($modelUser,$profile)); ?>
      <fieldset> 
        
          
        <div class="control-group">
          <label class="control-label">Crear Usuario</label>
          <div class="controls">
            <?php echo CHtml::dropDownList("tipoUsuario", '', array(
                                        0 => 'Usuario',
                                        1 => 'Personal Shopper',
                                        2 => 'Administrador')); ?>
          </div>
        </div>
        
        <?php echo $form->textFieldRow($modelUser,'email',array('placeholder'=>'Correo Electrónico',)); ?>    
        
        <?php echo $form->textFieldRow($profile,'first_name', array('placeholder'=>'Nombre',)); ?>   
          
        <?php echo $form->textFieldRow($profile,'last_name', array('placeholder'=>'Apellido',)); ?>  
        
       <div class="control-group">
           
           <?php
           echo CHtml::label('Fecha de Nacimiento *', CHtml::activeId($profile, 'birthday'), array('class' => 'control-label required'));
           ?>
           
               <div class="controls row">    
                    <?php            
                    echo $form->DropDownList($profile, 'day', User::getDaysArray(), array('class' => 'span1'));
                    echo ' ';
                    echo $form->DropDownList($profile, 'month', User::getMonthsArray(), array('class' => 'span1'));
                    echo ' ';
                    echo $form->DropDownList($profile, 'year', User::getYearsArray(), array('class' => 'span1'));
                    echo $form->hiddenField($profile, 'birthday'); 
                    echo $form->error($profile, 'birthday');
                    ?>
               </div>

           
       </div>     
          
          
        <div class="control-group">
          <label class="control-label">Sexo</label>
          <div class="controls">
            <?php echo CHtml::dropDownList("genero", '', array(1 => 'Mujer', 2 => 'Hombre')); ?>
          </div>
        </div>  
        
        
                      
      </fieldset>
    
    <?php $this->endWidget(); ?>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>    
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'label' => 'Crear',
        'type' => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        //'size' => 'large', // null, 'large', 'small' or 'mini'
        //'block' => 'true',
        'htmlOptions' => array('onclick' => 'js:$("#newUser-form").submit();')
    ));
    ?>
  </div>                    

<?php $this->endWidget()?>
<script>
	$('#search-form').attr('action','');
	$('#search-form').submit(function () {
		 return false;
		});
	
</script>
<script >
function modal(id){

	$.ajax({
		type: "post",
		'url' :'<?php echo  CController::createUrl('admin/contrasena');?>',
		data: { 'id':id}, 
		'success': function(data){
			$('#myModal').html(data);
			$('#myModal').modal(); 
		},
		'cache' :false});

}
function cambio(id){
	
	if($("#psw1").val()==$("#psw2").val())
	{	
		var psw=$("#psw2").val();
		$.ajax({
			type: "post",
			'url' :'<?php echo  CController::createUrl('admin/contrasena');?>',
			data: { 'psw':psw,
			'id':id}, 
			'success': function(data){
				
			window.location.reload();
			},
			'cache' :false});
	}
	else{
		alert("Ambos campos deben coincidir");		
	}

}
function carga(id){

	$.ajax({
		type: "post",
		'url' :'<?php echo  CController::createUrl('admin/saldo');?>',
		data: { 'id':id}, 
		'success': function(data){
			$('#saldoCarga').html(data);
			$('#saldoCarga').modal(); 
		},
		'cache' :false});

}
function saldo(id){	
		
		var cant=$("#cant").val();
       	var desc=0;
        if(cant.length>1){
	        if(cant.indexOf(',')==(cant.length-2))
	        	cant+='0';
			if(cant.indexOf(',')==-1)
				cant+=',00';
				}
        var pattern = /^\d+(?:\,\d{0,2})$/ ;
       
       if($('#discount').attr('checked')=='checked')
       	desc=1;
       
        
        if (pattern.test(cant)||cant.length<2) { 
          	cant=cant.replace(',','.');
           
           $.ajax({
			type: "post",
			'url' :'<?php echo  CController::createUrl('admin/saldo');?>',
			data: { 'cant':cant,
			'id':id,'desc':desc}, 
			'success': function(data){
				window.location.reload();	                                    
			},
			'cache' :false});
        }else{
        	alert("Formato de cantidad no válido");
         }     
}





</script>