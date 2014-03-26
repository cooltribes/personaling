    
<?php if($data->status == 0){ ?>
    <tr class="warning">
<?php } else{ ?>
    <tr class=" <?php echo ($data->personal_shopper == 2)?'info':''; ?> ">
<?php } ?>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td>
      	<?php
      	 	// <img src="images/kitten.png" width="70" height="70" alt="avatar">
      	 		echo CHtml::image($data->getAvatar(),'Avatar',array("width"=>"70", "height"=>"70"));
      	 ?>
      	
      	
      </td>
      <td>
        <h5 class="no_margin_bottom"> <?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></h5>
        <small><strong>ID</strong>: <?php echo $data->id; ?><br/>
        <?php if($data->personal_shopper == 1){
                if($data->ps_destacado == 1){
                   ?>
                    <span class="label label-warning">Personal Shopper Destacado</span>
                    <?php
                }else{
                    echo 'Personal Shopper';
                }
            
            
              }else if($data->personal_shopper == 2){
                  echo '<span class="label label-info"> Aplicante Personal Shopper</span>';
              }else{
                  echo '';
              }
             ?> </small>
      </td>
      <td><small><?php echo $data->email; ?><br/>
        <strong>Telf.</strong>: <?php echo $data->profile->tlf_celular; ?> <br/>
        <strong>Ciudad</strong>: <?php echo $data->profile->ciudad; ?> <br/>
        <?php if($data->status == User::STATUS_NOACTIVE){ ?>
        <strong class="text-warning text-center">Cuenta no validada</strong>
        <?php }else if($data->status == User::STATUS_BANNED){ ?>          
        <strong class="text-error text-center">Cuenta bloqueada</strong>
        <?php } ?>   
     </small>
        

        </td>
      <td><?php echo $data->ordenCount; ?></td>
      <td><?php echo $data->direccionCount; ?></td>
      <td><?php $saldo=Profile::model()->getSaldo($data->id); echo Yii::app()->numberFormatter->formatDecimal($saldo)." Bs.";?></td>
      <td><?php echo $data->visit; ?></td>
      <td><?php if ($data->getLastvisit()) echo  date("d/m/Y",$data->getLastvisit()); else echo 'N/D'; ?></td>
      <td><?php if ($data->getCreatetime()) echo  date("d/m/Y",$data->getCreatetime()); else echo 'N/D'; ?></td>
      <td>
      <div class="dropdown"> <a class="dropdown-toggle btn btn-block" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php" title="acciones"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
            <li>
        <?php echo CHtml::link('<i class="icon-eye-open">  </i>  Ver',array("profile/perfil","id"=>$data->id)); ?>            
            </li>
      <li>
        
       <?php echo CHtml::link('<i class="icon-edit">  </i>  Editar',array("admin/update","id"=>$data->id)); ?>
      </li>
      <li><a title="Cambiar contraseña" href="#" onclick='modal( <?php echo $data->id; ?>)'>  <i class="icon-lock">  </i>  Cambiar contraseña</a></li>
      <?php if($data->status == 0){ ?>
      <li>
        <?php echo CHtml::link('<i class="icon-refresh">  </i>   Enviar Correo electrónico de Verificación ',array("admin/resendvalidationemail","id"=>$data->id)); ?>
      </li>
      <?php } ?>
      <!-- <li><a title="Reenviar invitacion" href="#">  <i class="icon-refresh">  </i>  Reenviar invitacion</a></li> -->
      <li><a title="Cargar Saldo" href="#" onclick='carga(<?php echo $data->id; ?>)'>  <i class="icon-gift">  </i>  Cargar Saldo</a>
       <li> <?php echo CHtml::link('<i class="icon-shopping-cart">  </i>  Registrar Orden',array("admin/compra","id"=>$data->id)); ?>
      
            <li class="divider"></li>
      <li><a title="Eliminar" href="#">  <i class="icon-trash">  </i>  Eliminar</a></li>
          </ul>
        </div>
      <?php if($data->status == 0){ ?>
      <?php } ?>
      </td>
    </tr>
    <div id='myModal' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        </div>
    <div id='saldoCarga' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        </div>
    
