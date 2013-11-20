<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */


$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Generar Masivo' =>array('createMasivo'),
        'Seleccionar Usuarios'
);
$this->pageTitle=Yii::app()->name . ' - Seleccionar Usuarios';
?>
<div class="container">
<h1>Seleccionar Usuarios</h1>
<div class="container margin_top">
    <div class="row-fluid margin_top margin_bottom ">
        <div class="span4">
            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                <?php 
                echo CHtml::textField('nombre', "", array('id' => 'textbox_buscar', 'class' => '', 'placeholder' => 'Buscar'));
                ?>
            </div>

        </div>
        <div class="span3">
            <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 3'), "id_filter", "name"), 
                    array('empty' => '-- Filtros Preestablecidos --', 'id' => 'all_filters'))
            ?>
        </div>
        <div class="span3">
            <a href="#" class="btn  crear-filtro">Crear nuevo filtro</a>
        </div>
        
    </div>
    
    
    <hr/>
        <?php  $this->renderPartial("_filters"); ?>
    <hr/>
    
    <?php
      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
          'id' => 'todosUsuarios',
          'htmlOptions' => array('enctype' => 'multipart/form-data'),
          //'type' => 'horizontal',
          // 'type'=>'inline',
          //'enableClientValidation' => true,
//          'enableAjaxValidation' => true,
//          'clientOptions' => array(
//              'validateOnSubmit' => true,
//          ),
      ));
      ?>
    
    <?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped table-condensed">
    <tr>
      <th rowspan="2" scope="col"><input name="Check" id="check-todos" type="checkbox" value="Check"></th>
      <th colspan="3" rowspan="2" scope="col">Usuario</th>
      <th colspan="2" scope="col">Pedidos</th>
      <th rowspan="2" scope="col">Saldo Disponible</th>
      <th colspan="2" scope="col">Ingresos al Portal</th>
      <th rowspan="2" scope="col">Fecha de Registro</th>      
    </tr>
        <tr>
      <th scope="col">Pedidos</th>
      <th scope="col">Direcciones</th>
      <th scope="col">#</th>
      <th scope="col">Ultima Fecha</th>
    </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_user',
	    'template'=>$template,                    
	    'beforeAjaxUpdate'=>" function(id, data) {
                
                    

             } ",
	    'afterAjaxUpdate'=>" function(id, data) {

                   Codigo();

                    } ",
            'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));    
	
	
	Yii::app()->clientScript->registerScript('search',
	    "var ajaxUpdateTimeout;
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
        <div class="span2 offset10">
            <?php echo CHtml::submitButton("Seleccionar Diseño", array('class' => 'btn btn-block btn-danger', 'name' => 'siguiente', 'id' => 'siguiente')); ?>
        </div>
    </div>
  
  <?php $this->endWidget();  ?>
  
</div>
<!-- /container -->    
</div>
<script type="text/javascript">
   var selected, noselected;
   var all = Array(); 
    
function Codigo(){
   $('#check-todos').click(function() { 
        inputs = $('table').find('input').filter('[type=checkbox]');
        if($(this).attr('checked')){
             inputs.attr('checked', true);
        }else {
             inputs.attr('checked', false);
        } 	
    });    
    
    
    $("input:checkbox").click(function(e){
        selected = $("input:checkbox:checked[name='seleccionados']");
        noselected = $("input:checkbox:not(:checked)[name='seleccionados']");
        
        $.each(selected, function(i, e){
           
           var id = $(e).attr("id");
           //console.log(i + " " + id); 
           if(all.indexOf(id) == -1){
              all.push(id);               
           }
           
        });
        
        $.each(noselected, function(i, e){
           
           var id = $(e).attr("id");
           //console.log(i + " " + id); 
           var index = all.indexOf(id);
           if(index != -1){
              all.splice(index, 1); 
           }
           
        });
    });    
    
    
}    
    
    Codigo();
    
    $("#siguiente").click(function(e){
        
        if(!all.length){
            bootbox.alert("Debes seleccionar al menos un (1) usuario para el envío de Gift Card");
            e.preventDefault();            
            return;
        }
        
        //Crear inputs para enviar al server
        var form = $("#todosUsuarios");
        $.each(all, function(i, e){
           
           console.log(all);
           form.append($("<input >").attr({
                type : "hidden",
                name : 'seleccionadosH[]',
           }).val(e));
           console.log("--");
           
           
        });
        
        

    });
    
    
</script>