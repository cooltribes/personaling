<?php

//$this->breadcrumbs=array(
	//'Usuarios',
//);


$usuarios_totales = User::model()->count();
$usuarios_activos = User::model()->countByAttributes(array('status'=>1));
$usuarios_inactivos = User::model()->countByAttributes(array('status'=>0));
$personal_shoppers = User::model()->countByAttributes(array('personal_shopper'=>1));
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
      <select class="span3">
        <option>Filtros prestablecidos</option>
        <option>Filtro 1</option>
        <option>Filtro 2</option>
        <option>Filtro 3</option>
      </select>
    </div>
    <div class="span3"><a href="#" class="btn">Crear nuevo filtro</a></div>
    <div class="span2"><a href="#modalNuevoUsuario" class="btn btn-success" data-toggle="modal">Crear usuario</a></div>
  </div>
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

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-user',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_user',
	    'template'=>$template,
/*	    'afterAjaxUpdate'=>" function(id, data) {
						    	
							$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});
						   
							} ",
*/		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));    
	
	
	Yii::app()->clientScript->registerScript('search',
	    "var ajaxUpdateTimeout;
	    var ajaxRequest;
	    $('#textbox_buscar').keyup(function(){
	        ajaxRequest = $(this).serialize();
	        clearTimeout(ajaxUpdateTimeout);
	        ajaxUpdateTimeout = setTimeout(function () {
	            $.fn.yiiListView.update(
	// this is the id of the CListView
	                'list-user',
	                {data: ajaxRequest}
	            )
	        },
	// this is the delay
	        300);
	    });"
	);
		
	
	?> 
	
  <hr/>
   <div class="row">
   <div class="span3"><select class="span3">
        <option>Seleccionar usuarios</option>
        <option>Lorem</option>
        <option>Ipsum 2</option>
        <option>Lorem</option>
      </select></div>
      <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
      </div>
</div>
<!-- /container -->

<div id="modalNuevoUsuario" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Registrar usuario</h3>
  </div>
  <div class="modal-body">
      <?php
      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
          'id' => 'newuser-form',
          'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
          'type' => 'horizontal',
          // 'type'=>'inline',
          'enableClientValidation' => true,
          'clientOptions' => array(
              'validateOnSubmit' => true,
          ),
      ));
      ?>
<!--    <form class="form-horizontal">
      <fieldset>  
        <div class="control-group">
          <label class="control-label">Crear Usuario</label>
          <div class="controls">
            <select>
              <option>Usuario</option>
              <option>Personal Shopper</option>
              <option>Administrador</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">Correo Electrónico</label>
          <div class="controls">
            <input type="text" placeholder="Correo Electrónico">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">Contraseña</label>
          <div class="controls">
            <input type="password" placeholder="Contraseña">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">Nombre</label>
          <div class="controls">
            <input type="text" placeholder="Nombre">
          </div>
        </div>    
        <div class="control-group">
          <label class="control-label" for="inputPassword">Apellido</label>
          <div class="controls">
            <input type="text" placeholder="Apellido">
          </div>
        </div>               
      </fieldset>
    </form>-->
    <?php $this->endWidget(); ?>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-danger">Crear</button>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'label' => 'Crear',
        'type' => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        //'size' => 'large', // null, 'large', 'small' or 'mini'
        //'block' => 'true',
        'htmlOptions' => array('onclick' => 'js:$("#newuser-form").submit();')
    ));
    ?>
  </div>
</div>

