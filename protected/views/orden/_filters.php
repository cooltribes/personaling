<div class="row margin_top margin_bottom" id="filters-view" style="display: block">

<div class="span12">
  <div class="alert in" id="alert-msg" style="display: none">
    <button type="button" class="close" >&times;</button> 
    <!--data-dismiss="alert"-->
    <div class="msg">loren ipsum</div>
  </div>
</div>          
    
<?php
    //Métodos de pago
    echo CHtml::dropDownList('metodosPago', '', array('1' => 'Depósito o Transferencia',
    '2' => 'Tarjeta de Crédito', '4' => 'Mercado Pago'), array('style' => 'display:none'));
    
    echo Chtml::dropDownList('Operadores', '', array('>' => '>', '>=' => '>=',
                            '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), 
                                array('empty' => 'Operador',
                                    'style' => 'display:none'));
    
    echo CHtml::dropDownList('estadosOrden', '', array('1' => 'En espera de pago',
    '2' => 'En espera de confirmación', '3' => 'Pago confirmado', '4' => 'Enviado',
        '5' => 'Cancelado', '6' => 'Pago rechazado', '7' => 'Pago insuficiente',
        '8' => 'Entregado', '9' => 'Devuelto'), array('style' => 'display:none'));
    
    

    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filtersVentas.js");
    
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
    'htmlOptions' => array('class' => 'form-stacked span12'),
    'id' => 'form_filtros'
    ));

		
?>
    
    <h4>Nuevo Filtro:</h4>
    
    <fieldset>
        <div id="filters-container" class="clearfix">
            <div id="filter">
                <div class="control-group">
                    <div class="controls" >
                        <div class="span3" >
                            <?php echo Chtml::dropDownList('dropdown_filter[]', '', array('estado' => 'Estado',
                            'fecha' => 'Fecha de Compra',
                            'looks' => 'Cantidad de Looks',
                            'prendas' => 'Cantidad de Prendas',
                            'total' => 'Monto',
                            'pago_id' => 'Método de Pago',
                            'user_id' => 'Usuaria',
                            'id' => 'ID de pedido',
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
    <div class="span3 pull-right">
        <a href="#" id="filter-save" class="btn" title="Buscar con el filtro actual y guardarlo">Buscar y Guardar Nuevo Filtro</a> 
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
        
        search('<?php echo CController::createUrl('orden/admin') ?>');
        
    });
    
    //Buscar y guardar nuevo
    $('#filter-save').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('orden/admin') ?>', true);
            
    });
    
    //Buscar y guardar filtro actual
    $('#filter-save2').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('orden/admin') ?>', false);
            
    });
    
    //Seleccionar un filtro preestablecido
    $("#all_filters").change(function(){
	
        getFilter('<?php echo CController::createUrl('orden/getFilter') ?>', $(this).val(), '<?php echo CController::createUrl('orden/admin') ?>');        	
	
    });
    
    $("#filter-remove").click(function(e){

             e.preventDefault();
             removeFilter('<?php echo CController::createUrl('orden/removeFilter') ?>',$("#all_filters").val());        	

    });    
    
    
/*]]>*/
</script>