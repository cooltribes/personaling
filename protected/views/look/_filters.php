<div class="row margin_top margin_bottom" id="filters-view" style="display: none">

<div class="span12">
  <div class="alert in" id="alert-msg" style="display: none">
    <button type="button" class="close" >&times;</button> 
    <!--data-dismiss="alert"-->
    <div class="msg"></div>
  </div>
</div>          
    
<?php
    
    echo CHtml::dropDownList('status', '', array('1' => 'Enviado',
    '2' => 'Aprobado'), array('style' => 'display:none'));
    
    echo Chtml::dropDownList('Operadores', '', array('>' => '>', '>=' => '>=',
                            '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), 
                                array('empty' => 'Operador',
                                    'style' => 'display:none'));
    
    echo CHtml::dropDownList('estadosOrden', '', array('1' => 'En espera de pago',
    '2' => 'En espera de confirmación', '3' => 'Pago confirmado', '4' => 'Enviado',
        '5' => 'Cancelado', '6' => 'Pago rechazado', '7' => 'Pago insuficiente',
        '8' => 'Entregado', '9' => 'Devuelto'), array('style' => 'display:none'));
    
    echo CHtml::dropDownList('marca', '', CHtml::listData(Marca::model()->findAll(), 'id', 'nombre'),
                            array('style' => 'display:none'));
							
	    /*************      TIPO DE CUERPO ON   ****************/
    //Para las alturas    
	
	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('altura', '', $valores,
                            array('style' => 'display:none'));
    //Para la contextura
    $field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('contextura', '', $valores,
                            array('style' => 'display:none'));
    //Para cabello
    $field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('pelo', '', $valores,
                            array('style' => 'display:none'));
    //Para ojos
    $field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('ojos', '', $valores,
                            array('style' => 'display:none'));
    //Para piel
    $field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('piel', '', $valores,
                            array('style' => 'display:none'));
    
    //Para tipo_cuerpo
    $field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('tipo_cuerpo', '', $valores,
                            array('style' => 'display:none'));
	  /*************      TIPO DE CUERPO OFF        ****************/

    
    echo CHtml::dropDownList('user_id', '', CHtml::listData(User::model()->with(array(
                               'profile'=>array(),
                            ))->findAll('personal_shopper = 1'), 'id', 'profile.first_name'),
                            array('style' => 'display:none'));
    
    echo CHtml::dropDownList('destacado', '', array('1' => 'Sí',
    '0' => 'No',), array('style' => 'display:none'));
	
	
	 echo CHtml::dropDownList('activo', '', array('1' => 'Sí',
    '0' => 'No',), array('style' => 'display:none'));
	
	 echo CHtml::dropDownList('inactivo', '', array('1' => 'Sí',
    '0' => 'No',), array('style' => 'display:none'));
	
	
	
	
	/*echo Chtml::dropDownList('ocasion', '', array('36' => '>', '37' => '>=',
                            '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), 
                                array('empty' => 'Operador',
                                    'style' => 'display:none'));*/
                                    
    echo CHtml::dropDownList('ocasion', '', CHtml::listData(Categoria::model()->findAllByAttributes(array('urlImagen'=>NULL)), 'id', 'nombre'),
                            array('style' => 'display:none'));
    
    
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filters.js");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/looksFilters.js");
    
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
    'htmlOptions' => array('class' => 'form-stacked span12'),
    'id' => 'form_filtros'
    ));

		
?>
    
    <h4>Nuevo Búsqueda Avanzada:</h4>
    
    <fieldset>
        <div id="filters-container" class="clearfix">
            <div id="filter">
                <div class="control-group">
                    <div class="controls" >
                        <div class="span3" >
                            <?php echo Chtml::dropDownList('dropdown_filter[]', '', array(
                                'view_counter' => 'Visitas',
                                'user_id' => 'Personal Shopper',
                                'status' => 'Estado',
                                'marca' => 'Marcas que contiene',
                                'monto' => 'Monto de Ventas',
                                'cantidad' => 'Cantidad Vendida',
                                'created_on' => 'Fecha de Creación',
                                'campana' => 'Campaña',
                                'precio' => 'Precio',
                                'prendas' => 'Cantidad de Prendas',
                                'destacado' => 'Destacado',
                                'tipo_cuerpo' => 'Tipo de Cuerpo',
                                'ocasion' => 'Ocasion',
                                'activo' => 'Activo',
                                'inactivo' => 'Inactivo',
                                
                                
                                
                                ), array('empty' => '-- Seleccione --', 'class' => 'dropdown_filter span3')); ?> 
                        </div>
                        <div class="span2" >
                            <?php echo Chtml::dropDownList('dropdown_operator[]', '', array('>' => '>', '>=' => '>=',
                            '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), 
                                array('empty' => 'Operador', 'class' => 'dropdown_operator span2')); ?>
                        </div>
                        <div class="span2" >
                            <?php echo Chtml::textField('textfield_value[]', '', array('class' => 'textfield_value span2')); ?>  
                        </div>
                        <div class="span2" >
                           <?php
                        echo Chtml::dropDownList('dropdown_relation[]', '', array('AND' => 'Y', 'OR' => 'O'),
                                array('class' => 'dropdown_relation span2', 'style' => 'display:none'));
                        ?> 
                        </div>
                        
                            <a href="#" class="btn span_add" style="float: right" title="Agregar nuevo campo"> + </a>
                            <a href="#" class="btn btn-danger span_delete" style="display:none; float: right" title="Eliminar campo"> - </a> 
                        
                        
                        
                       
                        
                        

                    </div>
                </div>    
            </div>    
        </div>  
    </fieldset>
    
   <?php $this->endWidget(); ?>

    <div class="span2 pull-right">
        <a href="#" id="filter-remove" class="btn" title="Borrar Filtro">Borrar Filtro</a>
    </div>
    <div class="span2 pull-right">
        <a href="#" id="filter-save" class="btn" title="Buscar con el filtro actual y guardarlo">Buscar y Guardar</a> 
    </div>
    <div class="span2 pull-right" style="display: none">
        <a href="#" id="filter-save2" class="btn" title="Guardar filtro actual">Guardar Filtro</a> 
    </div>
    <div class="span1 pull-right">
        <a href="#" id="filter-search" class="btn btn-danger" title="Buscar con el filtro actual">Buscar</a>  
    </div>
    
    
    
    
</div>
<script type="text/javascript">
/*<![CDATA[*/
   
   //Buscar      
    $('#filter-search').click(function(e) {
        
        e.preventDefault(); 
        
        search('<?php echo CController::createUrl('') ?>');
        
    });
    
    //Buscar y guardar nuevo
    $('#filter-save').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('') ?>', true);
            
    });
    
    //Buscar y guardar filtro actual
    $('#filter-save2').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('') ?>', false);
            
    });
    
    //Seleccionar un filtro preestablecido
    $("#all_filters").change(function(){
	
        getFilter('<?php echo CController::createUrl('orden/getFilter') ?>', $(this).val(), '<?php echo CController::createUrl('') ?>');        	
	
    });
    
    $("#filter-remove").click(function(e){

             e.preventDefault();
             removeFilter('<?php echo CController::createUrl('orden/removeFilter') ?>',$("#all_filters").val());        	

    });    
    
    
/*]]>*/
</script>