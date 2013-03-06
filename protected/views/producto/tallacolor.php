<script language="JavaScript">
$(document).ready(function() {
	
});
</script>
<?php
$this->breadcrumbs=array(
	'Productos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Tallas y Colores',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Tallas y Colores</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form enctype="multipart/form-data" class="form-horizontal" id="registration-form" action="/aiesec/user/registration?template=1" method="post">
          <fieldset>
            <legend>Elige las tallas disponibles para este producto: </legend>
            <p class="margin_bottom muted"> Haz click sobre los botones para elegir las tallas </p>
            <div class="control-group">
              <label class="control-label required">Vestidos y Trajes:</label>
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
				        array('label'=>'32',
				       // 'buttonType' => 'ajaxLink',
				        /*
				        'ajaxOptions'=>array(
							 'type'=>'post',
							 'url'=>array('producto/addTallacolor', 'id'=>$model->id),
							 'success' => "function( data )
			                  {
			                    // handle return data
			                    alert( data );
			                  }",
						)
						 * 
						 */),
				        array('label'=>'34'),
				        array('label'=>'36'),
				        array('label'=>'38'),
				        array('label'=>'40'),
				        array('label'=>'42'),
				        array('label'=>'44'),
				    ),
				)); ?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label required">Vestidos y Trajes:</label>
              <div class="controls">
                <div class="btn-group" data-toggle="buttons-checkbox">
                  <button type="button" class="btn btn-inverse">XS</button>
                  <button type="button" class="btn btn-inverse">S</button>
                  <button type="button" class="btn btn-inverse">M</button>
                  <button type="button" class="btn btn-inverse">L</button>
                  <button type="button" class="btn btn-inverse">X</button>
                </div>
                <div style="display:none" class=" muted">Ayuda</div>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label required">Pantalones:</label>
              <div class="controls">
                <div class="btn-group" data-toggle="buttons-checkbox">
                  <button type="button" class="btn btn-inverse">24</button>
                  <button type="button" class="btn btn-inverse">26</button>
                  <button type="button" class="btn btn-inverse">28</button>
                  <button type="button" class="btn btn-inverse">30</button>
                  <button type="button" class="btn btn-inverse">32</button>
                  <button type="button" class="btn btn-inverse">34</button>
                </div>
                <div style="display:none" class=" muted">Ayuda</div>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label required">Zapatos:</label>
              <div class="controls">
                <div class="btn-group" data-toggle="buttons-checkbox">
                  <button type="button" class="btn btn-inverse">35</button>
                  <button type="button" class="btn btn-inverse">36</button>
                  <button type="button" class="btn btn-inverse">37</button>
                  <button type="button" class="btn btn-inverse">38</button>
                  <button type="button" class="btn btn-inverse">39</button>
                  <button type="button" class="btn btn-inverse">40</button>
                  <button type="button" class="btn btn-inverse">41</button>
                  <button type="button" class="btn btn-inverse">42</button>
                </div>
                <div style="display:none" class=" muted">Ayuda</div>
              </div>
            </div>
          </fieldset>
          <fieldset class="margin_top">
            <legend>Elige los <span class="color1">colores</span> disponibles para este producto: </legend>
            <div class="row">
              <div class="span6">
                <p class="margin_bottom muted">Utiliza el buscador para encontrar y seleccionar los colores que correspondan</p>
              </div>
              <a href="#myModal"  role="button" data-toggle="modal" class="btn btn-small pull-right"><i class="icon-plus"></i> Crear un nuevo color</a> </div>
            <div class="control-group">
              <label class="control-label required">Color</label>
              <div class="controls">
              	<?php
              	$this->widget('bootstrap.widgets.TbSelect2', array(
	'asDropDownList' => false,
	'name' => 'clevertech',
	'options' => array(
		'tags' => array('Negro mate','Titanio', 'Azul', ' Negro Violento','Agua Marina'),
		'placeholder' => 'disciplines',
		'width' => '40%',
		'tokenSeparators' => array(',', ' ')
)));	
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
		    'htmlOptions'=>array('id'=>'buttonStateful'),
		    'ajaxOptions'=>array(
		    	    'type' => 'POST',
    				'beforeSend' => "function( request )
                     {
                       $('.btn-group a.active').each(function(index){
                       		alert($(this).html());
                       })
                     }",
			),
		)); ?>
          <fieldset class="margin_top">
            <legend>Combinaciones: </legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
              <tr>
                <th scope="col">Color</th>
                <th scope="col">Talla</th>
                <th scope="col">SKU/CÃ³digo</th>
                <th scope="col">Cantidad</th>
                <th scope="col">ImÃ¡genes</th>
                <th scope="col">Acciones</th>
              </tr>
            </table>
          </fieldset>
        </form>
        <hr/>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer">Restablecer</a></li>
          <li><a href="#" title="Duplicar">Duplicar</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"> </i>Borrar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
    <h3 id="myModalLabel">Agregar nuevo color</h3>
  </div>
  <div class="modal-body">
    <p class="alert alert-info">Puedes usar cualquier de las opciones a continuaciÃ³n:</p>
    <h4>1. Usar el Color-picker</h4>
    <input type="text" placeholder="Haz click para escoger un color" >
    <hr/>
    <h4>2. O Sube una imagen</h4>
    <p>La imagen sera redimensionada y cortada a 70 x 70 pixeles</p>
    <label>Elige una imagen:</label>
    <div class="input-append">
      <input class="span3"  type="text">
      <span class="add-on"><i class="icon-search"></i></span> </div>
  </div>
  <div class="modal-footer"> <a href="#" title="eliminar">Cancelar</a> <a href="" title="ver" class="btn btn-info">Guardar</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->

