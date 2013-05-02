 <div class="navbar margin_top">
    <div class="navbar-inner">
      <ul class="nav">
        <li class="active">
        	
        	<?php echo CHtml::link('Datos Básicos',array('update',
                                     'id'=>$model->id,)); ?>
        </li>
		<li>
			
		<?php echo CHtml::link('Perfil Corporal',array('corporal',
                                     'id'=>$model->id,)); ?>
		</li>
        <li>
        	
        		<?php echo CHtml::link('Estilos',array('estilos',
                                     'id'=>$model->id,)); ?>	
        </li>
        <li>
    		<?php echo CHtml::link('Avatar',array('avatar',
                     'id'=>$model->id,)); ?>
        </li>
        <li>
    		<?php echo CHtml::link('Direcciones',array('direcciones',
                     'id'=>$model->id,)); ?>
        </li> 
        <li>
    		<?php echo CHtml::link('Pedidos',array('pedidos',
                     'id'=>$model->id,)); ?>
        </li>
        <li>
    		<?php echo CHtml::link('Carrito',array('carrito',
                     'id'=>$model->id,)); ?>
        </li>
        <li>
    		<?php echo CHtml::link('Favoritos',array('favoritos',
                     'id'=>$model->id,)); ?>
        </li>                        
   
      </ul>
    </div>
  </div>
  

