<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Precio</small></h1>
  </div>
  
<?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model)); ?>
  
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model); ?>
  
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
          	<legend >Precios: </legend>

          <div class="control-group">
             <?php echo $form->radioButtonListRow($precio, 'combinacion', array(0 => 'Aplicar datos a todas las combinaciones', 1 => 'Aplicar datos por separado a cada combinación',)); ?>
             <?php echo $form->error($precio,'combinacion'); ?>
          </div>
            <div class="control-group">
                    <?php echo $form->textFieldRow($precio, 'costo', array('class'=>'span5')); ?>
                <div class="controls">    
                <div class=" muted">Precio al que compró este producto como mayorista </div>
                </div>
            </div>
            <div class="control-group">
              		<?php echo $form->textFieldRow($precio, 'precioVenta', array('class'=>'span5')); ?>
                <div class="controls">
                <div class=" muted">Precio sin Iva de venta de este producto</div>
                </div>
             </div>
			<div class="control-group">
                 	<?php echo $form->dropDownListRow($precio, 'tipoDescuento', array(0 => 'Porcentaje %', 1 => 'Monto en Bs.',)); ?>
                    <?php echo $form->error($precio,'tipoDescuento'); ?>                    
            </div>
            <div class="control-group">
                 	<?php echo $form->textFieldRow($precio, 'valorTipo', array('class'=>'span5','id'=>'valordescuento')); ?>
                 <div class="controls">
                <div class=" muted">Si el producto no tendrá descuento ingrese 0</div>
                </div>
            </div>
            <div class="control-group">
                 	<?php echo $form->textFieldRow($precio, 'ahorro', array('class'=>'span5')); ?>
            </div>
            <div class="control-group">
                 	<?php echo $form->textFieldRow($precio, 'precioDescuento', array('class'=>'span5','disabled'=>true)); ?>
            </div>
            <div class="control-group">
				<?php echo $form->dropDownListRow($precio, 'impuesto', array(0 => 'Sin IVA (Zona Libre)', 1 => 'Con IVA 12% (Tierra Firme)',2 => 'Ambos')); ?>
                <?php echo $form->error($precio,'impuesto'); ?> 
            </div>
            <div class="control-group">
                 	<?php echo $form->textFieldRow($precio, 'precioImpuesto', array('class'=>'span5')); ?>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
           <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'label'=>'Guardar',
		)); ?>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
          <li><a href="#" title="Duplicar">Duplicar</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"> </i>Borrar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
<?php $this->endWidget(); ?>

<script type="text/javascript">

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
			tres = parseFloat(pre) + (parseFloat(pre) * 0.12);			
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
			tres = parseFloat(pre) + (parseFloat(pre) * 0.12);			
			$("#Precio_precioImpuesto").val(tres);
		}	
	}
    
});

$("#valordescuento").keyup(function(){

var uno;
var dos;	
var tres;
var valor;
	
	uno = document.getElementById("Precio_tipoDescuento").value;
	dos = document.getElementById("Precio_precioVenta").value;
	
	valor = document.getElementById("Precio_impuesto").value;
	
	
	if(uno==0)
	{
		$("#Precio_ahorro").val(dos * (this.value/100));		
		$("#Precio_precioDescuento").val(dos - (dos * (this.value/100)));
		
		if(valor==0)
			$("#Precio_precioImpuesto").val(dos - (dos * (this.value/100)));	
		else{
			tres = parseFloat(dos) + (parseFloat(dos) * 0.12);			
			$("#Precio_precioImpuesto").val(tres);
		}
	}
	else
	{
		$("#Precio_ahorro").val(this.value);
		$("#Precio_precioDescuento").val(dos - this.value);
		
		if(valor==0)
			$("#Precio_precioImpuesto").val(dos - this.value);	
		else{
			tres = parseFloat(dos) + (parseFloat(dos) * 0.12);			
			$("#Precio_precioImpuesto").val(tres);
		}				
	}
	
    
});


$("#Precio_impuesto").click(function(){
	
var uno;
var dos;
var tres;

uno= document.getElementById("Precio_impuesto").value;
dos= document.getElementById("Precio_precioDescuento").value;	
	
	if(uno==0)
		$("#Precio_precioImpuesto").val(dos);
	
	if(uno==1 || uno==2){
		tres = parseFloat(dos) * 0.12;
		
		dos = parseFloat(dos)+parseFloat(tres);
		
		$("#Precio_precioImpuesto").val(dos);
	}

	
});

$("#Precio_tipoDescuento").click(function(){
	
	$("#Precio_ahorro").val("AAAAAAAAA");
var uno;
var dos;
var tres;
var cuatro;
var cinco;

uno = document.getElementById("Precio_precioVenta").value;
dos = document.getElementById("valordescuento").value;	
tres = document.getElementById("Precio_ahorro").value;
cuatro = document.getElementById("Precio_precioDescuento").value;
cinco = $("#Precio_tipoDescuento").val();
console.log(cinco);
	if(cinco==0)
		$("#Precio_ahorro").val("AAAAAAAAA");
	if(cinco==1){
		$("#Precio_ahorro").val("OOOOOO");
	}

	
});


		$('#limpiar').on('click', function() {
           $("#producto-form input[type=text]").val('');
           $("#producto-form input[type=text]").value('');
           
           $("#producto-form textarea").val("");
           $("#producto-form textarea").value("");
            
           $("#producto-form select").val('-1');
           $("#producto-form select").value('-1');
           
           $("#producto-form input[type=radio]").val('');
           $("#producto-form input[type=radio]").value('');
           
           $("#producto-form input[type=checkbox]").val('');
           $("#producto-form input[type=checkbox]").value('');
           
           $("#producto-form")[0].reset();
           $("#producto-form")[3].reset();
       });
	
	
</script>