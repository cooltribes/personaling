<?php
$this->breadcrumbs=array(
	'Looks'=>array('mislooks'),
	'Información General',
);
?>

<div class="container">
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
    <h1>Información General</h1>
    <h2><?php echo $look->title; ?></h2>
  </div>
    
  <?php echo $this->renderPartial('_topBar', array('look'=>$look)); ?>
  
  
  <div class="row margin_top">
    <div class="span7">
      <div class="text_align_center">
        <?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)),
                "Look", array("width" => "500", "height" => "500", 'class'=>'img-polaroid')); ?>
      </div>
    </div>
    <div class="span5">
    <!-- SIDEBAR OFF --> 
      <div class="box_1"> 
          <h4>Visitas Generadas</h4> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed">
                
            <tr>
                <th scope="row">Vistas Totales</th>
                <td><?php echo "-" ?></td>
            </tr>                
            <tr>
                <th scope="row">Vistas desde Personaling</th>
                <td><?php echo "-" ?></td>
            </tr>                
            <tr>
                <th scope="row">Vistas Referidas</th>
                <td><?php echo "-" ?></td>
            </tr>                
            
          </table>
          
          <h4><?php echo Yii::t('contentForm', 'Products'); ?></h4>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-condensed"> 
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                    </tr>
                    
                    <?php foreach($look->lookhasproducto as $lookhasproducto){ ?>     
                        <tr>
                            <td><?php echo $lookhasproducto->producto->nombre; ?></td>
                            <td><?php echo $lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id); ?> <?php echo Yii::t('contentForm','availables'); ?></td>
                            <td><?php echo $lookhasproducto->producto->getPrecioImpuesto().' '.Yii::t('contentForm', 'currSym'); ?> </td>

                        </tr>
                    <?php } ?>
              </table>
          
      </div>
    <!-- SIDEBAR OFF --> 
      
    </div>
  </div>
</div>
</div>
<!-- /container -->
