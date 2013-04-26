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
        <li><a href="admin_editar_estilos.php" title="Estilos">Estilos</a></li>
        <li><a href="admin_editar_avatar.php" title="Avatar">Avatar</a></li>
        <li><a href="admin_editar_direcciones.php" title="Direcciones">Direcciones</a></li>
        <li><a href="admin_editar_pedidos.php" title="Pedidos">Pedidos</a></li>
        <li><a href="admin_editar_carrito.php" title="Carrito">Carrito</a></li>
        <li><a href="admin_editar_favoritos.php" title="Favoritos">Favoritos</a></li>
      </ul>
    </div>
  </div>
  

