<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Historial',
);

?>

<div class="container margin_top">
    
    <div class="page-header">
        <h1>Producto - Historial de cambios</small></h1>
        <h2 ><?php echo $model->nombre . "  [<small class='t_small'>Ref: " . $model->codigo . "</small>]"; ?></h2>
    </div>
  
    

      <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'producto-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
    )); ?>

	<?php echo $form->errorSummary($model); ?>
<?php
	
	
	//  <input id="id_sig" type="hidden" value="<?php echo $model->next($model->id);" />	
	
?>
 
  <div class="row margin_top">
    <div class="span12">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        
          <fieldset>
          	<legend >Historial de cambios: </legend>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Cambios hechos</a></li>                       
                </ul>    
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">	            

                        <?php
                        $template = '{summary}
                          <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
                          <tbody>
                            <tr>

                            <th scope="col">Campo</th>
                            <th scope="col">Valor Anterior</th>
                            <th scope="col">Valor Nuevo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Usuario</th>

                            </tr>
                            {items}
                                </tbody>
                            </table>
                            {pager}
                                ';                        

                        $this->widget('zii.widgets.CListView', array(
                            'id' => 'email',
                            'dataProvider' => $dataProvider,
                            'itemView' => '_cambio',
                            'template' => $template,
                            'enableSorting' => 'true',
                            'afterAjaxUpdate' => " function(id, data) {
                                                                } ",
                            'pager' => array(
                                'header' => '',
                                'htmlOptions' => array(
                                    'class' => 'pagination pagination-right',
                                )
                            ),
                        ));
                        ?>
                    </div>
                    
                </div>
          
          </fieldset>
        
      </div>
    </div>
    
  
    
    
    </div>
  </div>
</div>
<!-- /container -->
<?php $this->endWidget(); ?>

