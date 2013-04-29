    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="images/kitten.png" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS"><?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></span></strong><br/>
        <strong>ID</strong>: <?php echo $data->id; ?><br/>
        <?php echo $data->personal_shopper?'Personal Shopper':''; ?> </td>
      <td><small><strong>eMail</strong>: <?php echo $data->email; ?><br/>
        <strong>Telefono</strong>: <?php echo $data->profile->tlf_celular; ?> <br/>
        <strong>Ciudad</strong>: <?php echo $data->profile->ciudad; ?>
        
     </small>
        
        </td>
      <td>0</td>
      <td><?php echo $data->direccionCount; ?></td>
      <td>0 Bs.</td>
      <td><?php echo $data->visit; ?></td>
      <td><?php if ($data->getLastvisit()) echo  date("d/m/Y",$data->getLastvisit()); else echo 'N/D'; ?></td>
      <td><?php if ($data->getCreatetime()) echo  date("d/m/Y",$data->getCreatetime()); else echo 'N/D'; ?></td>
      <td>
      <div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li>
				<?php echo CHtml::link('<i class="icon-eye-open">  </i>  Ver',array("admin/view","id"=>$data->id));	?>          	
            </li>
      <li>
      	
       <?php echo CHtml::link('<i class="icon-edit">  </i>  Editar',array("admin/update","id"=>$data->id));	?>
      </li>
      <li><a title="Cambiar contraseña" href="#">  <i class="icon-lock">  </i>  Cambiar contraseña</a></li>
      <li><a title="Reenviar invitacion" href="#">  <i class="icon-refresh">  </i>  Reenviar invitacion</a></li>
      <li><a title="Cargar Saldo" href="#">  <i class="icon-gift">  </i>  Cargar Saldo</a>
            <li class="divider"></li>
      <li><a title="Eliminar" href="#">  <i class="icon-trash">  </i>  Eliminar</a></li>
          </ul>
        </div>
          
      </td>
    </tr>