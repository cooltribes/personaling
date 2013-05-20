	<!-- FLASH ON --> 
<?php 

 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'categoria-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-stacked form-horizontal','enctype' => 'multipart/form-data'),
));

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Categorias</small></h1>
  </div>
  <!-- SUBMENU ON -->
 <input id="producto" type="hidden" value="<?php echo $model->id ?>" />
<?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>5)); ?>
  <!-- SUBMENU OFF -->
  <?php 
  
$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); 

  ?>
  
  
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
          <?php $this->widget('bootstrap.widgets.TbButton', array(
	    'buttonType' => 'link',
	    'label'=>'Crear Nueva Categoría',
	    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'normal', // null, 'large', 'small' or 'mini'
	    'url' =>'../../categoria/create',
	    'htmlOptions' => array('class'=>'btn pull-right margin_bottom_small'),
		)); ?>
            <legend>Listado de Categorías</legend>
              <div class="span6">
                <?
                /*<ul class="no_bullets">
                  <li>
                    <label> <a href="#categoria" data-toggle="collapse" data-target="#demo"><i class="icon-chevron-right"></i> </a>
                      <input name="" type="checkbox" value="">
                      <strong>CATEGORIA 1</strong></label>
                    <ul id="demo" class="collapse in no_bullets">
                      <li>
                        <label> <a href="#categoria1" data-toggle="collapse" data-target="#demo1"><i class="icon-chevron-right"></i> </a>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                        <ul id="demo1" class="collapse in no_bullets">
                          <li>
                            <label>
                              <input name="" type="checkbox" value="">
                              Sub-Categoria  </label>
                          </li>
                          <li>
                            <label>
                              <input name="" type="checkbox" value="">
                              Sub-Categoria  </label>
                          </li>
                          <li>
                            <label>
                              <input name="" type="checkbox" value="">
                              Sub-Categoria </label>
                          </li>
                          <li>
                            <label>
                              <input name="" type="checkbox" value="">
                              Sub-Categoria </label>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <label> <a href="#categoria2" data-toggle="collapse" data-target="#demo2"><i class="icon-chevron-right"></i> </a>
                      <input name="" type="checkbox" value="">
                      <strong>CATEGORIA 2</strong></label>
                    <ul id="demo2" class="collapse in no_bullets">
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <label> <a href="#categoria3" data-toggle="collapse" data-target="#demo3"><i class="icon-chevron-right"></i> </a>
                      <input name="" type="checkbox" value="">
                      <strong>CATEGORIA 1</strong></label>
                    <ul id="demo3" class="collapse in no_bullets">
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                    </ul>
                  </li>
                  <li> 
                    <label><a href="#categoria4" data-toggle="collapse" data-target="#demo4"><i class="icon-chevron-right"></i> </a>
                      <input name="" type="checkbox" value="">
                      <strong>CATEGORIA 1</strong></label>
                    <ul id="demo4" class="collapse in no_bullets">
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria  </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                      <li>
                        <label>
                          <input name="" type="checkbox" value="">
                          Sub-Categoria </label>
                      </li>
                    </ul>
                  </li>
                </ul>*/

        $cat = Categoria::model()->findAllByAttributes(array('id'=>'1','padreId'=>'0'));


		if(count($categorias) > 0){
			foreach($categorias as $indiv)
			{
				if(isset($indiv->tbl_categoria_id))	
					echo("<input class='idsCategorias' type='hidden' value='".$indiv->tbl_categoria_id."' />");
			}		
		}

		nodos($cat);
		
			function nodos($items){
				echo "<ul class='no_bullets'>";
				foreach ($items as $item){
						echo "<li><label><input id='".$item->id."' type='checkbox' value='' /> ".$item->nombre."</label></li>";
						
						if ($item->hasChildren()){
							nodos($item->getChildren());
						}
					}
				echo "</ul>";
				return 1;
			}

     ?>
                
              </div>
             
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 
      	
      	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxButton',
			'type'=>'danger',
			'label'=>'Guardar',
			'url'=>array('producto/recatprod'), // ReCatProd Relacion Categorias a producto
			'htmlOptions'=>array('id'=>'guardar','class'=>'btn-large btn-block'),
			'ajaxOptions'=>array(
			'type' => 'POST',
			'beforeSend' => "function( request )
			{
				 var checkValues = $(':checkbox:checked').map(function() {
			        return this.id;
			    }).get().join();
				
				//alert(checkValues);
				var producto = $('#producto').attr('value');
			
			this.data += '&idProd='+producto+'&check='+checkValues;
			}",
			
			'data'=>array('a'=>'5'),
			'success'=>"function(data){
				
				if(data=='ok')
					window.location.reload();
				
			}",
			),
			)); ?>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Limpiar" id="limpiar">Limpiar</a></li>
          <li><a href="#" title="Duplicar">Duplicar</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"> </i>Borrar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
<?php $this->endWidget(); ?>

<script>
	$(document).ready(function(){
		
	jQuery.each($('.idsCategorias'), function() {
		
		var id = $(this).attr('value');
    	$('#'+id).attr('checked',true);
   	});		
		
	               
	});
	
</script>
