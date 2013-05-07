<div class="container margin_top">
  <div class="page-header">
    <h1>Tus Pedidos</h1>
      <hr/>
    <!-- Menu ON -->
    
    <div class="navbar">
  <div class="navbar-inner margin_bottom margin_top_medium">
    <ul class="nav ">
      <li class="active"><a href="#" title="Tus pedidos activos">Pedidos activos</a></li>
      <li><a href="#" title="tu avatar">Historial de pedidos</a></li>
    </ul>
  </div>
</div>
    <!-- Menu OFF -->
    
  </div>
  
    <?php
  
$template = '{summary}
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th scope="col">Número de Orden</th>
      <th scope="col">Fecha</th>
      <th scope="col">Monto</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>
    </tr>
    {items}
    </table>
    {pager}
	';
    
  $this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datosUsuario',
	    'template'=>$template,
	    'enableSorting'=>'true',
	    'afterAjaxUpdate'=>" function(id, data) {
						    	
							$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});
						   
							} ",
		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));
	
	?>
  

  <hr/>
</div>
<!-- /container -->