<div class="row margin_top margin_bottom ">
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
        <div id="container-filter" class="clearfix">
            <div id="filter">
                <div class="control-group">
                    <div class="controls" >
                        <?php
                        echo Chtml::dropDownList('dropdown_filter', '', array('username' => 'Estado',
                            'lastname' => 'Fecha de Compra',
                            'firstname' => 'Cantidad de Looks',
                            'email' => 'Cantidad de Prendas',
                            'street' => 'Monto',
                            'city' => 'Método de Pago',
                            'cellphone' => 'Usuaria',
                            'birthdate' => 'N° de pedido',
                                ), array('empty' => '-- Seleccione --', 'class' => 'combo_filter span3'));

                        echo Chtml::dropDownList('dropdown_operator', '', array('>' => '>', '>=' => '>=', '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), array('empty' => 'Operador', 'class' => 'combo_operator span3'));

                        echo Chtml::textField('textfield_filter', '', array('class' => 'text_filter span3'));

                        echo Chtml::dropDownList('dropdown_relation', '', array('AND' => 'Y', 'OR' => 'O'), array('class' => 'combo_relation span3', 'style' => 'display:none'));
                        ?>
                        
                        <a href="#" class="btn span_add" style="float: right" title="Agregar nuevo campo"> + </a>
                        <a href="#" class="btn span_delete" style="display:none; float: right" title="Eliminar campo"> - </a>
                        
                        

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

</div>