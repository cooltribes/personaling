<?php
/* @var $form TbActiveForm */

//$this->breadcrumbs=array(
//'Usuarios',
//);


$usuarios_totales = User::model()->count();
$usuarios_activos = User::model()->countByAttributes(array('status' => 1));
$usuarios_inactivos = User::model()->countByAttributes(array('status' => 0));
$personal_shoppers = User::model()->countByAttributes(array('personal_shopper' => 1));
$aplicantesPs = User::model()->countByAttributes(array('personal_shopper' => 2));
$usuarios_facebook = User::model()->count('facebook_id IS NOT NULL');
$usuarios_twitter = User::model()->count('twitter_id IS NOT NULL');
?>
<div class="container margin_top">

<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true, // display a larger alert block?
    'fade' => true, // use transitions?
    'closeText' => '&times;', // close link text - if set to false, no close link is displayed
    'alerts' => array(// configurations per alert type
        'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
        'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
    ),
        )
);
?> 

    <div class="page-header">
        <h1>Remuneración - Personal Shoppers</h1>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table hidden">
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
            echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id' => 'search-form'))
            . '<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>'
            . CHtml::textField('nombre', (isset($_GET['string'])) ? $_GET['string'] : '', array('id' => 'textbox_buscar', 'class' => 'span3', 'placeholder' => 'Buscar'))
            . CHtml::endForm();
            ?>
        </div>
    </div>
    <div class="span3">
        <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 3'), "id_filter", "name"), array('empty' => '-- Filtros Preestablecidos --', 'id' => 'all_filters'))
        ?>
    </div>
    <div class="span3 "><a href="#" class="btn  crear-filtro">Crear nuevo filtro</a></div>
    
</div>

<hr/>
<?php //  $this->renderPartial("_filters"); ?>
<hr/>
<?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped table-condensed">
    <tr>
      <th rowspan="2" scope="col"><input name="Check" type="checkbox" value="Check"></th>
      <th colspan="3" rowspan="2" scope="col">Usuario</th>
      <th colspan="2" scope="col">Ventas</th>
      <th rowspan="2" scope="col">Comisión<br>Actual</th>
      <th colspan="2" scope="col">Saldo (Bs)</th>
      <th rowspan="2" scope="col">Fecha de Registro</th>
      <th rowspan="2" scope="col"></th>
    </tr>
        <tr>
      <th scope="col">Looks Completos</th>
      <th scope="col">Productos</th>
      <th scope="col">Comisiones</th>
      <th scope="col">Total</th>
    </tr>
    {items}
    </table>
    {pager}
	';

$this->widget('zii.widgets.CListView', array(
    'id' => 'list-auth-items',
    'dataProvider' => $dataProvider,
    'itemView' => '_viewPs',
    'template' => $template,
    /* 	    'afterAjaxUpdate'=>" function(id, data) {

      $('#todos').click(function() {
      inputs = $('table').find('input').filter('[type=checkbox]');

      if($(this).attr('checked')){
      inputs.attr('checked', true);
      }else {
      inputs.attr('checked', false);
      }
      });

      } ",
     */ 'pager' => array(
        'header' => '',
        'htmlOptions' => array(
            'class' => 'pagination pagination-right',
        )
    ),
));


Yii::app()->clientScript->registerScript('search', "var ajaxUpdateTimeout;
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
<script>
    $('#search-form').attr('action', '');
    $('#search-form').submit(function() {
        return false;
    });

</script>
<script >
    function modal(id) {

        $.ajax({
            type: "post",
            'url': '<?php echo CController::createUrl('admin/contrasena'); ?>',
            data: {'id': id},
            'success': function(data) {
                $('#myModal').html(data);
                $('#myModal').modal();
            },
            'cache': false});

    }
    function cambio(id) {

        if ($("#psw1").val() == $("#psw2").val())
        {
            var psw = $("#psw2").val();
            $.ajax({
                type: "post",
                'url': '<?php echo CController::createUrl('admin/contrasena'); ?>',
                data: {'psw': psw,
                    'id': id},
                'success': function(data) {

                    window.location.reload();
                },
                'cache': false});
        }
        else {
            alert("Ambos campos deben coincidir");
        }

    }
    function carga(id) {

        $.ajax({
            type: "post",
            'url': '<?php echo CController::createUrl('admin/saldo'); ?>',
            data: {'id': id},
            'success': function(data) {
                $('#saldoCarga').html(data);
                $('#saldoCarga').modal();
            },
            'cache': false});

    }
    function saldo(id) {

        var cant = $("#cant").val();
        var desc = 0;
        if (cant.length > 1) {
            if (cant.indexOf(',') == (cant.length - 2))
                cant += '0';
            if (cant.indexOf(',') == -1)
                cant += ',00';
        }
        var pattern = /^\d+(?:\,\d{0,2})$/;

        if ($('#discount').attr('checked') == 'checked')
            desc = 1;


        if (pattern.test(cant) || cant.length < 2) {
            cant = cant.replace(',', '.');

            $.ajax({
                type: "post",
                'url': '<?php echo CController::createUrl('admin/saldo'); ?>',
                data: {'cant': cant,
                    'id': id, 'desc': desc},
                'success': function(data) {
                    window.location.reload();
                },
                'cache': false});
        } else {
            alert("Formato de cantidad no válido");
        }
    }





</script>