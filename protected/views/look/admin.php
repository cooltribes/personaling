<?php

	$this->breadcrumbs=array(
		'Look',
	);	

?>
<div class="container margin_top">
    <div class="page-header">
        <h1>Administrar Looks</small></h1>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
        <tr>
            <th scope="col" colspan="6"> Totales </th>
        </tr>
        <tr>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotal(); ?> </p>
                Totales</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getAprovados(); ?> </p>
                Aprovados</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getPorAprovar(); ?> </p>
                Por Aprovar</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalxStatus(4); ?></p>
                Por Enviar</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalxStatus(5); ?></p>
                Cancelados </td>
            <td><p class="T_xlarge margin_top_xsmall"> 182 </p>
                Devueltos</td>
        </tr>
    </table>
    <hr/>
    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                <input class="span3" id="prependedInput" type="text" placeholder="Buscar">
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
        <div class="span2">
        
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'label'=>'Crear Look',
			'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'normal', // null, 'large', 'small' or 'mini'
			'url' => 'create',
		)); ?>        	
        </div>
    </div>
    <hr/>
<?php
$template = '{summary}
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col"></th>
            <th colspan="2" scope="col">Look</th>
            <th scope="col">Precio</th>
            <th scope="col">Vendidos</th>
            <th scope="col">Ventas Bs.</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha de Carga</th>
            <th scope="col">Progreso de la campaña</th>
            <th scope="col">Acción</th>
        </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_look',
	    'template'=>$template,
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
	<!--    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col"></th>
            <th colspan="2" scope="col">Look</th>
            <th scope="col">Precio</th>
            <th scope="col">Vendidos</th>
            <th scope="col">Ventas Bs.</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha de Carga</th>
            <th scope="col">Progreso de la campaña</th>
            <th scope="col">Acción</th>
        </tr>
        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS">ActiveWear de Negro</span></strong><br/>
                <strong>ID</strong>: 0001<br/>
                <strong>Nro. Items</strong>: 6 </td>
            <td><strong>P.S.</strong>: Heidi Garcia<br/>
                <strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
            <td>650,00</td>
            <td>10</td>
            <td>6500,00</td>
            <td>Por aprobar</td>
            <td>Dic. 01,2012</td>
            <td> Finaliza en: 17 Mayo 2013
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 70%;"></div>
                </div></td>
            <td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal"><i class="icon-eye-open"></i></a></td>
        </tr>
        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS">ActiveWear de Negro</span></strong><br/>
                <strong>ID</strong>: 0001<br/>
                <strong>Nro. Items</strong>: 6 </td>
            <td><strong>P.S.</strong>: Heidi Garcia<br/>
                <strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
            <td>650,00</td>
            <td>10</td>
            <td>6500,00</td>
            <td>Activo</td>
            <td>Dic. 01,2012</td>
            <td> Finaliza en: 17 Mayo 2013
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 70%;"></div>
                </div></td>
            <td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal"><i class="icon-eye-open"></i></a></td>
        </tr>
        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS">ActiveWear de Negro</span></strong><br/>
                <strong>ID</strong>: 0001<br/>
                <strong>Nro. Items</strong>: 6 </td>
            <td><strong>P.S.</strong>: Heidi Garcia<br/>
                <strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
            <td>650,00</td>
            <td>10</td>
            <td>6500,00</td>
            <td>Por aprobar</td>
            <td>Dic. 01,2012</td>
            <td> Finaliza en: 17 Mayo 2013
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 70%;"></div>
                </div></td>
            <td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal"><i class="icon-eye-open"></i></a></td>
        </tr>
        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS">ActiveWear de Negro</span></strong><br/>
                <strong>ID</strong>: 0001<br/>
                <strong>Nro. Items</strong>: 6 </td>
            <td><strong>P.S.</strong>: Heidi Garcia<br/>
                <strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
            <td>650,00</td>
            <td>10</td>
            <td>6500,00</td>
            <td>Por aprobar</td>
            <td>Dic. 01,2012</td>
            <td> Finaliza en: 17 Mayo 2013
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 70%;"></div>
                </div></td>
            <td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal"><i class="icon-eye-open"></i></a></td>
        </tr>
        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS">ActiveWear de Negro</span></strong><br/>
                <strong>ID</strong>: 0001<br/>
                <strong>Nro. Items</strong>: 6 </td>
            <td><strong>P.S.</strong>: Heidi Garcia<br/>
                <strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
            <td>650,00</td>
            <td>10</td>
            <td>6500,00</td>
            <td>Por aprobar</td>
            <td>Dic. 01,2012</td>
            <td> Finaliza en: 17 Mayo 2013
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 70%;"></div>
                </div></td>
            <td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal"><i class="icon-eye-open"></i></a></td>
        </tr>
    </table>
    
    <div class="pagination pagination-right">
      <ul>
            <li class="disabled"><a href="#">&laquo;</a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">Siguiente</a></li>
      </ul>
</div>
-->
    <hr/>
    <div class="row">
        <div class="span3">
            <select class="span3">
                <option>Seleccionar usuarios</option>
                <option>Lorem</option>
                <option>Ipsum 2</option>
                <option>Lorem</option>
            </select>
        </div>
        <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
        <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
    </div>
</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
<?php $this->endWidget(); ?>

<!------------------- MODAL WINDOW OFF ----------------->

