<?php
$this->breadcrumbs=array(
	'Looks'=>array('mislooks'),
	'Descuento',
);
?>

<div class="container margin_top">
	<?php $this->widget('bootstrap.widgets.TbAlert', array(
	        'block'=>true, // display a larger alert block?
	        'fade'=>true, // use transitions?
	        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
	        'alerts'=>array( // configurations per alert type
	            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
	            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
	        ),
	    )
	); ?>
  <div class="page-header">
    <h1>Look - Aplicar descuento</small></h1>
    <h2 ><?php echo $model->title; ?></h2>
  </div>
  
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'descuento-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
)); ?>
  <?php echo $form->errorSummary($model); ?>
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
        	<fieldset>
	          	<legend>Productos: </legend>
				<div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed"> 
						<tr>
							<th>Nombre</th>
							<th>Disponibilidad</th>
							<th>Precio total</th>
							<th>Precio con descuento</th>
						</tr>
						<?php foreach($model->lookhasproducto as $lookhasproducto){ 
							?>
							<tr> <th scope="row"><?php echo $lookhasproducto->producto->nombre; ?></th>
								<td><?php echo $lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id); ?> <?php echo Yii::t('contentForm','availables'); ?></td>
								<td>           <?php   echo Yii::t('contentForm', 'currSym').' '.$lookhasproducto->producto->getPrecioImpuesto(); ?> </td>
								<td>           <?php   echo Yii::t('contentForm', 'currSym').' '.$lookhasproducto->producto->getPrecioDescuento(); ?> </td>
							</tr>
							<?php 
						} 
						?>
					</table>
					
				</div>
          	</fieldset>
        	<fieldset>
        		<legend>Precios del look: </legend>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed">
					<tr>
	                    <th scope="row">Precio total de productos con IVA</th>
	                    <td><?php echo Yii::t('contentForm', 'currSym').' '.$model->getPrecioProductosFull(); ?></td>
	                </tr>
	                <tr>
	                    <th scope="row">Precio total de productos con descuento (incluye IVA)</th>
	                    <td><?php echo Yii::t('contentForm', 'currSym').' '.$model->getPrecioProductosDescuento(); ?></td>
	                </tr>
				</table>
			</fieldset>
          	<fieldset>
            <legend >Descuento: </legend>
            <div class="control-group"> 
            	<?php echo $form->dropDownListRow($model, 'tipoDescuento', array(0 => 'Porcentaje %', 1 => 'Establecer total en '.Yii::t('contentForm','currSym'),)); ?> 
            	<?php echo $form->error($model,'tipoDescuento'); ?> 
            </div>
            <div class="control-group"> <?php echo $form->textFieldRow($model, 'valorDescuento', array('class'=>'span5','id'=>'valordescuento', 'placeholder'=>'0.00')); ?>
            	<?php echo $form->error($model,'valorDescuento'); ?>
				<div class="controls">
					<div class=" muted">Si el look no tendrá descuento ingrese 0</div>
				</div>
            </div>
            <div class="control-group"> 
            	<?php echo CHtml::label('Precio Total Definitivo', 'precio_total', array('class'=>'control-label')); ?>
            	<div class="controls">
            		<?php echo CHtml::textField('precio_total', Yii::t('contentForm','currSym').' '.$model->getPrecioDescuento(), array('class'=>'span5','id'=>'precio_total', 'disabled'=>'disabled')); ?>
            	</div>
            </div>
            <?php echo $form->hiddenField($model, 'id', array('id'=>'hidden_id')); ?>
          </fieldset>
			
          
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR OFF --> 
        
        <div id="scroller-anchor"></div>
        <div id="scroller">
          <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'htmlOptions' => array('id'=>'normal'),
			'label'=>'Guardar',
		)); ?>
        </div>
      </div>
      <!-- SIDEBAR OFF --> 
      
    </div>
  </div>
</div>
</div>
<!-- /container -->
<?php $this->endWidget(); ?>
<script type="text/javascript">
/*
$("#Precio_precioVenta").keyup(function(){

var uno;
var dos;
var valor;
var tres;
var pre;

	
	uno = document.getElementById("Precio_tipoDescuento").value;
	dos = document.getElementById("valordescuento").value;
	
	valor = document.getElementById("Precio_impuesto").value;
	
	if(uno==0)
	{
		$("#Precio_ahorro").val(this.value * (dos/100));		
		$("#Precio_precioDescuento").val(this.value - (this.value * (dos/100)));
		
		if(valor==0)
			$("#Precio_precioImpuesto").val(this.value - (this.value * (dos/100)));		
		else{
			pre = document.getElementById("Precio_precioDescuento").value;
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()));			
			$("#Precio_precioImpuesto").val(tres);
		}// else
	}
	else
	{
		$("#Precio_ahorro").val(dos);
		$("#Precio_precioDescuento").val(this.value - dos);
		
		if(valor==0)
			$("#Precio_precioImpuesto").val(this.value - dos);	
		else{
			pre = document.getElementById("Precio_precioDescuento").value;
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()));			
			$("#Precio_precioImpuesto").val(tres);
		}	
	}
    
});
*/
	$("#valordescuento").keyup(function(){
		if($('#Look_tipoDescuento').val() == '0'){
			calcular_precio_descuento();
		}else{
			$('#precio_total').val("<?php echo Yii::t('contentForm','currSym'); ?> "+$("#valordescuento").val());
		}
	});

	$("#Look_tipoDescuento").change(function(){
		if($('#Look_tipoDescuento').val() == '0'){
			calcular_precio_descuento();
		}else{
			$('#precio_total').val("<?php echo Yii::t('contentForm','currSym'); ?> "+$("#valordescuento").val());
		}
	});

	function calcular_precio_descuento(){
		$.ajax({
	        type: "post", 
	        url: "../calcularPrecioDescuento", // action 
	        data: { 'id': $('#hidden_id').val(), 'tipo_descuento': $('#Look_tipoDescuento').val(), 'valor_descuento': $("#valordescuento").val() }, 
	        success: function (data) {
				$('#precio_total').val(data);
	       	}//success
	    });
	}
/*

$("#Precio_impuesto").click(function(){
	
var uno;
var dos;
var tres;

uno= document.getElementById("Precio_impuesto").value;
dos= document.getElementById("Precio_precioDescuento").value;	
	
	if(uno==0)
		$("#Precio_precioImpuesto").val(dos);
	
	if(uno==1 || uno==2){
		tres = parseFloat(dos) * parseFloat($("#iva").val());
		
		dos = parseFloat(dos)+parseFloat(tres);
		
		$("#Precio_precioImpuesto").val(dos);
	}

	
});



$("#Precio_tipoDescuento").click(function(){

var uno;
var dos;
var tres;
var cuatro;
var cinco;
var pre;
var valor;

	valor = document.getElementById("Precio_impuesto").value;

uno = $("#Precio_precioVenta").val();
dos = $("#valordescuento").val();	
tres = $("#Precio_ahorro").val();
cuatro = $("#Precio_precioDescuento").val();
cinco = $("#Precio_tipoDescuento").val();

	if(cinco==0){
	
		$("#Precio_ahorro").val(uno * (dos/100));		
		$("#Precio_precioDescuento").val(uno - (uno * (dos/100)));
		
		if(valor==0)
			$("#Precio_precioImpuesto").val(uno - (uno * (dos/100)));	
		else{
			pre = $("#Precio_precioDescuento").val();
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()));			
			$("#Precio_precioImpuesto").val(tres);
		}
		
	}else 
	if(cinco==1){
	
		$("#Precio_ahorro").val(dos);		
		$("#Precio_precioDescuento").val(uno - dos);
		
		if(valor==0)
			$("#Precio_precioImpuesto").val(uno - dos);	
		else{
			pre = $("#Precio_precioDescuento").val();
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()));			
			$("#Precio_precioImpuesto").val(tres);
		}
		
	}

	
});

});
	*/
</script>