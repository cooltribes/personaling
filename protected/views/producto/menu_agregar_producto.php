	<!-- FLASH ON --> 
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
<!-- FLASH OFF -->

	<!-- SUBMENU ON -->
   <div class="navbar margin_top">
    <div class="navbar-inner">
      <ul class="nav">
        <li class="active"><?php echo CHtml::link('Información General',array('create',
                                     'id'=>$model->id,)); ?></li>
        <li><?php echo CHtml::link('Precios',array('precios',
                                     'id'=>$model->id,)); ?></li>
        <li><a href="#">SEO</a></li>
        <li><a href="#">Imágenes</a></li>
        <li><a href="#">Categorías</a></li>
        <li><a href="#">Inventario</a></li>
        <li><a href="#">Envíos y Transporte</a></li>
        <li><a href="#">Ventas Cruzadas</a></li>
      </ul>
    </div>
  </div>