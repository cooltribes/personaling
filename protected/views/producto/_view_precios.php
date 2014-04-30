<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Precios',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Precio</small></h1>
    <h2 ><?php echo $model->nombre."  [<small class='t_small'>Ref: ".$model->codigo."</small>]"; ?></h2>
  </div>
  <?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>2)); ?>
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
  <?php echo $form->errorSummary($model); ?>
  
  
<?php
	echo CHtml::hiddenField('accion','def', array('id' => 'accion'));
	echo CHtml::hiddenField('iva',Yii::app()->params['IVA']);
	//<input id="accion" type="hidden" value="" />	
?>

  
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend >Precios: </legend>
            <!--
            <div class="control-group"> <?php echo $form->radioButtonListRow($precio, 'combinacion', array(0 => 'Aplicar datos a todas las combinaciones', 1 => 'Aplicar datos por separado a cada combinación',)); ?> <?php echo $form->error($precio,'combinacion'); ?> </div>
            -->
            <div class="control-group">
              <?php  echo $form->textFieldRow($precio, 'costo', array('class'=>'span5')); ?>
              <div class="controls">
                <div class=" muted">Precio al que compró este producto como mayorista </div>
              </div>
            </div>
            <div class="control-group"> <?php echo $form->textFieldRow($precio, 'precioVenta', array('class'=>'span5')); ?>
              <div class="controls">
                <div class=" muted">Precio sin Iva de venta de este producto</div>
              </div>
            </div>
            <div class="control-group"> <?php echo $form->dropDownListRow($precio, 'tipoDescuento', array(0 => 'Porcentaje %', 1 => 'Monto en Bs.',)); ?> <?php echo $form->error($precio,'tipoDescuento'); ?> </div>
            <div class="control-group"> <?php echo $form->textFieldRow($precio, 'valorTipo', array('class'=>'span5','id'=>'valordescuento')); ?>
              <div class="controls">
                <div class=" muted">Si el producto no tendrá descuento ingrese 0</div>
              </div>
            </div>
            <div class="control-group"> <?php echo $form->textFieldRow($precio, 'ahorro', array('class'=>'span5','readonly'=>true)); ?> </div>
            <div class="control-group"> <?php echo $form->labelEx($precio,'precioDescuento', array('class' => 'control-label required')); ?>
              <div class="controls"> <?php echo $form->textField($precio, 'precioDescuento', array('class'=>'span5','readonly'=>true)); ?> <?php echo $form->error($precio,'precioDescuento'); ?> </div>
            </div>
            <div class="control-group"> <?php echo $form->dropDownListRow($precio, 'impuesto', array(0 => 'Sin IVA (Zona Libre)', 1 => 'Con IVA 12% (Tierra Firme)',2 => 'Ambos')); ?> <?php echo $form->error($precio,'impuesto'); ?> </div>
            <div class="control-group"> <?php echo $form->textFieldRow($precio, 'precioImpuesto', array('class'=>'span5')); ?> </div>
          </fieldset>
        </form>
        <?php if(count($precio->anteriores)){ ?>
        <legend>Histórico de Precios</legend>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped" align="center">
        	<thead>
        		<tr>
        			<th>Usuario</th>
        			<th>Costo</th>
        			<th>Precio Venta</th>
        			<th>Precio con Descuento</th>
        			<th>Precio con Impuesto</th>
        			
        			<th>Guardado en</th>
        		</tr>        		
        	</thead>
        	<tbody>
        		<?php foreach ($precio->anteriores as $historico) {
					
				?>
        		<tr>
        			<td><?php echo User::model()->getUsername($historico->user_id); ?></td>
        			<td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$historico->costo); ?></td>
        			<td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$historico->precioVenta); ?></td>
        			<td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$historico->precioDescuento); ?></td>
        			<td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$historico->precioImpuesto); ?></td>
        			
        			<td width="23%"><?php echo date("d/m/Y h:i:s a",strtotime($historico->fecha)); ?></td>
        		</tr>
        		<?php } ?>
        	</tbody>
        	
        </table>
        	<?php } ?>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR OFF --> 
        <script > 
			// Script para dejar el sidebar fijo Parte 1
			function moveScroller() {
				var move = function() {
					var st = $(window).scrollTop();
					var ot = $("#scroller-anchor").offset().top;
					var s = $("#scroller");
					if(st > ot) {
						s.css({
							position: "fixed",
							top: "70px"
						});
					} else {
						if(st <= ot) {
							s.css({
								position: "relative",
								top: "0"
							});
						}
					}
				};
				$(window).scroll(move);
				move();
			}
		</script>
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
          <ul class="nav nav-stacked nav-tabs margin_top">
            <li><a id="avanzar" style="cursor: pointer" title="Guardar y Siguiente" id="limpiar">Guardar y avanzar</a></li>
            <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar Formulario</a></li>
          </ul>
        </div>
      </div>
      <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });
		</script> 
      <!-- SIDEBAR OFF --> 
      
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
			pre = document.getElementById("Precio_precioDescuento").value;
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()));			
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
			pre = document.getElementById("Precio_precioDescuento").value;
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()));			
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
			tres = parseFloat(pre) + (parseFloat(pre) * parseFloat($("#iva").val()););			
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


		$('a#limpiar').on('click', function() {
			
			$('#producto-form').each (function(){
			  this.reset();
			});
			
			 $('#producto-form').find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });

       });
	
	
		$('#normal').on('click', function(event) {
		event.preventDefault();
		
		// cambio el valor
		$("#accion").attr("value", "normal");
		//alert( $("#accion").attr("value") );
		
		// submit del form
		$('#producto-form').submit();
		
		}
	);
	
	
	$('a#avanzar').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "avanzar");
		//alert( $("#accion").attr("value") );
		
		// submit del form
		$('#producto-form').submit();
		
		}
	);
	
	
</script>