<div class="row margin_top margin_bottom ">
  <?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
//'action' => Yii::app()->createUrl($this->route),
'method' => 'post',
'htmlOptions' => array('class' => 'form-stacked'),
'id' => 'form_buscar'
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
  <h4>Neue Filter:</h4>
  <div class="clearfix">
    <label>Vordefinierte Filter </label>
    <div class="input">
      <?php
echo Chtml::dropDownList('combo_save','',array(),array('empty' => 'Filter auswÃ¤hlen','class'=>'combo_buscar'))
?>
    </div>
  </div>
  <div class="clearfix"> <?php echo $form->labelEx($users, 'usertype'); ?>
    <div class="input"> <?php echo $form->dropDownList($users, 'usertype', YumUser::itemAlias('UserType')); ?> <span class="help-block"> <?php echo $form->error($users, 'usertype'); ?></span> </div>
  </div>
  <div id="div_add_filter" style="display:none" class="modulo1">
    <h4>Benutzer-Profil</h4>
    <div id="container-filter" class="clearfix">
      <div id="filter">
        <?php
/*
echo $form->dropDownList( $users,'username', 
              array('sex' => 'Anrede','lastname' => 'lastname', 'firstname' => 'firstname', 'email' => 'email','date' => 'birn date'),
              array('empty' => 'Filter', 'class' => 'combo_buscar'));
*/
echo Chtml::dropDownList('dropdown_filter','', 
              array('username' => 'Benutzername',              
              'lastname' => 'Nachname',
'firstname' => 'Vorname', 
'email' => 'E-Mail',
'street' => 'Strasse',
'city' => 'Ort',
'cellphone' => 'Handy',
'birthdate' => 'Geburtsdatum',
'zipcode' => 'PLZ',
'profession' => 'Beruf',
'sex' => 'Anrede',
'phone' => 'Telefonnummer',
'contact_per' => 'Kontaktieren per'),
              array('empty' => 'Filter', 'class' => 'combo_filter span4'));			  
/*		  
echo $form->dropDownList( $users,'sex', 
              array('>' => '>', '>=' => '>=', '=' => '=', '<' => '<', '<=' => '<='),
              array('empty' => 'Operator', 'class' => 'combo_buscar'));	
	*/		  		  
echo Chtml::dropDownList('dropdown_operator','',
              array('>' => '>', '>=' => '>=', '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'),
              array('empty' => 'Operator', 'class' => 'combo_operator span3'));	
			  
//echo $form->textField($users,'sex');
echo Chtml::textField('textfield_filter','',array('class'=>'text_filter span4'));

/*
echo $form->dropDownList( $users,'sex', 
              array('AND' => 'AND', 'OR' => 'OR', 'NOT' => 'NOT'),
              array('class' => 'combo_buscar'));
*/			  
echo Chtml::dropDownList('dropdown_relation','',
              array('AND' => 'UND', 'OR' => 'ODER'),
              array('class' => 'combo_relation span3','style'=>'display:none'));
//echo Chtml::link('-','#',array('id'=>'link_delete','class'=>'btn_delete','style'=>'display:none'));			 
			  			  
?>
        <span  class="span_delete" style="display:none"> - </span> <span  class="span_add"> + </span> </div>
    </div>
    <?php
echo $form->hiddenField($users,'hidden_type','');
echo $form->hiddenField($users,'hidden_filter','');	
echo $form->hiddenField($users,'hidden_textfield','');
echo $form->hiddenField($users,'hidden_operator','');
echo $form->hiddenField($users,'hidden_relation','');	

//echo Chtml::htmlButton('Add',array('class'=>'btn small','id'=>'btn_add','name'=>'btn_add'));
?>
    <div class=" box_2 braker_top">
      <?php
echo $form->dropDownList($users,'dropdown_relation_big',
              array('AND' => 'UND', 'OR' => 'ODER'),
              array('class' => 'combo_relation_big span3'));
?>
    </div>
    <h4>Studien</h4>
    <div id="container-filter-survay" >
      <div id="filter-survay" class="clearfix">
        <?php

echo Chtml::dropDownList('dropdown_survey','',
	 CHtml::listData(Survey::model()->findAll(), 'id', 'title'),
	 array('prompt' => 'AuswÃ¤hlen...',
	'class' => 'span4',
	'ajax' => array(
		'type' => 'POST',
		//'data' => array('dropdown_survey' => 'js: $(this).val()'),
		'url' => CController::createUrl('//survey/preguntas'),
		'update' => '#dropdown_question'
	),
	
	
));			  
/*echo Chtml::dropDownList('dropdown_question','',
              CHtml::listData(Question::model()->findAll('question_type_id = 4'),'id','title'),
              array('class' => 'combo_question span4'));
*/
echo Chtml::dropDownList('dropdown_question','',array(),              
              array('class' => 'combo_question span4'));
echo Chtml::dropDownList('dropdown_operator_survey','',
               array('>' => '>', '>=' => '>=', '=' => '=', '<' => '<', '<=' => '<='),
              array('empty' => 'Operator', 'class' => 'combo_operator_survey span3'));		
			  			  			  		  
	
echo Chtml::textField('textfield_filter_survey','',array('class'=>'text_filter_survey span4'));			  	  


echo Chtml::dropDownList('dropdown_relation_survey','',
               array('AND' => 'UND', 'OR' => 'ODER'),
              array('class' => 'combo_relacion_survey span2','style'=>'display:none'));
//echo Chtml::link('-','#',array('id'=>'link_delete_survey','class'=>'btn_delete_survey','style'=>'display:none'));					  
			  	
?>
        <span  class="span_delete_survey" style="display:none"> - </span> <span  class="span_add_survey"> + </span> </div>
    </div>
    <?php
//echo CHtml::label('Add','label-add');
echo $form->hiddenField($users,'hidden_filter_survey','');	
echo $form->hiddenField($users,'hidden_textfield_survey','');
echo $form->hiddenField($users,'hidden_operator_survey','');
echo $form->hiddenField($users,'hidden_relation_survey','');


echo '<div class="clearfix">';

//echo Chtml::htmlButton('Add',array('class'=>'btn small','id'=>'btn_add_survay'));
echo '</div>';

echo '<div class="clearfix">';
echo '<h4>Filter speichern</h4>';

echo CHtml::textField('name_save','');	
echo '&nbsp;';
echo CHtml::submitButton('Filter speichern', array('id' => 'btn_save','class'=>'btn small'));
echo '&nbsp;';
echo '<span id="btn_delete" class=" btn small">Filter lÃ¶schen</span>';	
echo '</div>';
?>
  </div>
  <?php
echo '<div class="clearfix margin_top">';
echo $form->textField($users,'textfield_all',array('class'=>'span4'));	
echo '&nbsp;';
echo CHtml::submitButton('Suchen', array('id' => 'btn_buscar','class'=>'btn  primary'));
echo '&nbsp;';
echo '<span id="span_new_filter" class=" btn small">Neuer Filter</span>';
echo '</div>';
	
//echo $form->textField($users,'date_from',array('width' => 50));	

///////////***************** Hidden Field for Create PDF *************//////////////////////
echo $form->hiddenField($users,'hidden_title','');
echo $form->hiddenField($users,'hidden_description','');	  			  		 
$this->endWidget();	

?>
</div>
