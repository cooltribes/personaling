<div class="row margin_top margin_bottom" id="filters-view" style="display: block">
<?php

    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filters.js");
    
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
    'htmlOptions' => array('class' => 'form-stacked span12'),
    'id' => 'form_filtros'
    ));

		/*
		 echo CHtml::label('Anrede','sex');
		 // echo CHtml::dropDownList($users,'sex', 
		 echo $form->dropDownList( $users,'sex', 
              array('Herr' => 'Herr', 'Frau' => 'Frau'),
              array('empty' => '(Select a gender)', 'class' => 'combo_buscar'));
			 echo CHtml::label('Geburtsdatum zwischen:','date_form');
// echo CHtml::dropDownList($users,'username', 
 
//echo $form->dropDownList( $users,'username', 
//              array('jpernia' => 'jpernia', 'chantal' => 'chantal'),
//              array('empty' => '(Select a gender)', 'class' => 'combo_buscar'));	
			  
			echo $form->textField($users,'date_from');
			echo $form->textField($users,'date_to');
			echo CHtml::submitButton('Buscar', array('id' => 'btn_buscar'));
			*/
////////***************** NEW ******************///////////////
?>
    <?php //echo $form->errorSummary(array($modelUser,$profile)); ?>
    <h4>Nuevo filtro:</h4>
    
    <fieldset>
        <div id="filters-container" class="clearfix">
            <div id="filter">
                <div class="control-group">
                    <div class="controls" >
                        <div class="span3" >
                            <?php echo Chtml::dropDownList('dropdown_filter[]', '', array('estado' => 'Estado',
                            'fecha' => 'Fecha de Compra',
                            'detalle_id' => 'Cantidad de Looks',
                            'email' => 'Cantidad de Prendas',
                            'total' => 'Monto',
                            'pago_id' => 'Método de Pago',
                            'user_id' => 'Usuaria',
                            'id' => 'N° de pedido',
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
    
                <?php
//echo CHtml::label('Add','label-add');
                /*
                echo $form->hiddenField($users, 'hidden_filter_survey', '');
                echo $form->hiddenField($users, 'hidden_textfield_survey', '');
                echo $form->hiddenField($users, 'hidden_operator_survey', '');
                echo $form->hiddenField($users, 'hidden_relation_survey', '');


                echo '<div class="clearfix">';

//echo Chtml::htmlButton('Add',array('class'=>'btn small','id'=>'btn_add_survay'));
                echo '</div>';

                 */
        $this->endWidget();
        ?>

    <div class="span2 pull-right">
        <a href="#" class="btn crear-filtro" title="Borrar Filtro">Borrar Filtro</a>
    </div>
    <div class="span3 pull-right">
        <a href="#" id="filter-save" class="btn crear-filtro span2" title="Buscar con el filtro actual y guardarlo">Buscar y Guardar Filtro</a> 
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
    
    //Buscar y guardar
    $('#filter-save').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('orden/admin') ?>');
            
    });
    
    //Seleccionar un filtro preestablecido
    $("#all_filters").change(function(){
	
        getFilter('<?php echo CController::createUrl('orden/getFilter') ?>', $(this).val());        	
	
    });
    
    
/*]]>*/
</script>