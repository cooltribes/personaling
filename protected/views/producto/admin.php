<?php
$this->breadcrumbs=array(
	'Productos',
);
?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar Productos</small></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">
<?php
$sql = "select count( * ) as total from tbl_producto where status=1";
$num = Yii::app()->db->createCommand($sql)->queryScalar();
echo $num;
?>
		</p>
        Totales</td>
      <td><p class="T_xlarge margin_top_xsmall">
<?php
$sql = "select count( * ) as total from tbl_producto where estado=0 and status=1";
$num = Yii::app()->db->createCommand($sql)->queryScalar();
echo $num;
?>
      	</p>
        Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 
<?php
$sql = "select count( * ) as total from tbl_producto where estado=1 and status=1";
$num = Yii::app()->db->createCommand($sql)->queryScalar();
echo $num;
?>
		</p>
        Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall">150</p>
        Enviados</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        En tránsito </td>
      <td><p class="T_xlarge margin_top_xsmall"> 182 </p>
        Devueltos</td>
    </tr>
  </table>
  <hr/>
  
    <div class="row margin_top margin_bottom ">
    <div class="span4">
      <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
		<?php echo CHtml::textField('Buscar','Buscar', array('id'=>'prependedInput','class'=>'span3')); //<input class="span3" id="prependedInput" type="text" placeholder="Buscar"> ?>
	</div>
    </div>
    <div class="span3">

       <?php $select=''; echo CHtml::dropDownList('listname', $select, 
              array('M' => 'Male', 'F' => 'Female'),
              array('empty' => '(Filtros Preestablecidos)')); 
              array('class'=>'span3')?>

    </div>
    <div class="span3"><a href="#" class="btn">Crear nuevo filtro</a></div>
    <div class="span2">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'buttonType' => 'link',
	    'label'=>'Añadir producto',
	    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'normal', // null, 'large', 'small' or 'mini'
	    'url' => 'create',
	)); ?>
    </div>
  </div>
  <hr/>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th rowspan="2" scope="col"><input name='check' type='checkbox' id='todos'></th>
      <th rowspan="2" scope="col">Producto</th>
      <th rowspan="2" scope="col">Sku</th>
      <th rowspan="2" scope="col">Categoria</th>
      <th rowspan="2" scope="col">Precio</th>
      <th colspan="3" scope="col">Cantidad</th>
      <th rowspan="2" scope="col">Ventas Bs.</th>
      <th rowspan="2" scope="col">Estado</th>
      <th rowspan="2" scope="col">Fecha de Carga</th>
      <th rowspan="2" scope="col">Progreso de la campaña</th>
      <th rowspan="2" scope="col">Acción</th>
    </tr>
    <tr>
      <th scope="col">Total</th>
      <th scope="col">Disp.</th>
      <th scope="col">Vendido</th>
    </tr>
	  <?php 
	  	$model->status=1;	  
		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$model->search(),
	    'itemView'=>'_authitem',
	));    
	?>
	</tr>
    </table>

	  <hr/>
  <div class="row">
    <div class="span3">
      <select class="span3">
        <option id="accion">Acciones</option>
        <option>Activar</option>
        <option>Inactivar</option>
        <option>Borrar</option>
      </select>
    </div>
    <div class="span1"><a href="" id="procesar" title="procesar" class="btn btn-danger">Procesar</a></div>
    <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
  </div>	  
		  
  </div>
<?php
function compara_fechas($fecha1,$fecha2)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=split("/",$fecha1);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=split("-",$fecha1);
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=split("/",$fecha2);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=split("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2);
        return ($dif);
}
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(document).ready(function(){
 
            $("#todos").click(function() {
 
               inputs = $('table').find('input').filter('[type=checkbox]');
 
               if($(this).attr("checked"))
               {
                     inputs.attr('checked', true);
               } 
                else
               {
                     inputs.attr('checked', false);
               } 	
		});
       
                var selected = new Array();                   
               

 $('#procesar').click(function () {
    var checkValues = $(':checkbox:checked').map(function() {
        return this.id;
    }).get().join();
    alert(checkValues);
  });
       
 
            });
  
</script>	