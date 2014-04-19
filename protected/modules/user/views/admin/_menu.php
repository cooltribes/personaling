
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
 <div class="navbar margin_top">
    <div class="navbar-inner">
      <ul class="nav">
        <li class="<?php if($activo == 1) echo 'active'; ?>">
        	
        	<?php echo CHtml::link('Datos',array('update',
                                     'id'=>$model->id,)); ?>
        </li>
		<li class="<?php if($activo == 2) echo 'active'; ?>">
			
		<?php echo CHtml::link('Perfil Corporal',array('corporal',
                                     'id'=>$model->id,)); ?>
		</li>
        <li class="<?php if($activo == 3) echo 'active'; ?>">
        	
        		<?php echo CHtml::link('Estilos',array('estilos',
                                     'id'=>$model->id,)); ?>	
        </li>

        <li class="<?php if($activo == 4) echo 'active'; ?>">
    		<?php echo CHtml::link('Avatar',array('avatar',
                     'id'=>$model->id,)); ?>
        </li>
        <li class="<?php if($activo == 5) echo 'active'; ?>">
    		<?php echo CHtml::link('Direcciones',array('direcciones',
                     'id'=>$model->id,)); ?>
        </li> 
        <li class="<?php if($activo == 6) echo 'active'; ?>">
    		<?php echo CHtml::link('Pedidos',array('pedidos',
                     'id'=>$model->id,)); ?>
        </li>
        <li class="<?php if($activo == 7) echo 'active'; ?>">
    		<?php echo CHtml::link('Carrito',array('carrito',
                     'id'=>$model->id,)); ?>
        </li>
        <li class="<?php if($activo == 8) echo 'active'; ?>">
    		<?php echo CHtml::link('Looks Favoritos',array('looks',
                     'id'=>$model->id,)); ?>
        </li>
        <li class="<?php if($activo == 9) echo 'active'; ?>">
    		<?php echo CHtml::link('Productos Favoritos',array('productos',
                     'id'=>$model->id,)); ?>
        </li>
        <li class="<?php if($activo == 10) echo 'active'; ?>">
    		<?php echo CHtml::link('Invitaciones',array('invitaciones',
                     'id'=>$model->id,)); ?>
        </li>
   
        <li class="<?php if($activo == 11) echo 'active'; ?>">
    		<?php echo CHtml::link('Saldo',array('balance',
                     'id'=>$model->id,)); ?>
        </li>
        <li class="<?php if($activo == 12) echo 'active'; ?>">
    		<?php echo CHtml::link('Seguimiento',array('seguimiento',
                     'id'=>$model->id,)); ?>
        </li>
      </ul>
    </div>
  </div>
  

