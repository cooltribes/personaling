<tr>
      <td><input name="check" type="checkbox" value=""></td>
      <td><?php echo $data->id; ?></td>
      <td><h4><?php echo $data->nombre; ?></h4></td>
      <td>
      	<?php
      	switch ($data->estado) {
			  case '1':
				  echo 'Programada';
				  break;
			  case '2':
				  echo 'Recepción';
				  break;
			  case '3':
				  echo 'Revisión';
				  break;
			  case '4':
				  echo 'Ventas';
				  break;
			  case '5':
				  echo 'Finalizada';
				  break;
			  default:
				  echo 'Desconocido';
				  break;
		  } 
      	?>
      </td>
      <td colspan="2"><div class="margin_bottom_xsmall progress progress-danger">
      	<?php
        $time_inicio_publicacion = strtotime($data->ventas_inicio);
		$date_inicio_publicacion = date('M. d, Y', $time_inicio_publicacion);
		$time_fin_publicacion = strtotime($data->ventas_fin);
		$date_fin_publicacion = date('M. d, Y', $time_fin_publicacion);
		
		// Calcular porcentaje de tiempo transcurrido
		$porcentaje = 0;
		
		if(time() > $time_fin_publicacion){
			$porcentaje = 100;
		}else if(time() > $time_inicio_publicacion){
			$time_total_publicacion = $time_fin_publicacion - $time_inicio_publicacion;
			//echo 'Time: '.(time() - $time_inicio_publicacion).' - Total: '.$time_total_publicacion;
			$porcentaje = ((time() - $time_inicio_publicacion) * 100) / $time_total_publicacion;
		}
        ?>
        <div class="bar" style="width: <?php echo $porcentaje; ?>%;"></div>
        </div>
        <div class="clearfix">
          <div class="pull-left"> <small><?php echo $date_inicio_publicacion; ?></small></div>
          <div class="pull-right"> <small><?php echo $date_fin_publicacion; ?></small></div>
        </div></td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <?php
      $ps = CampanaHasPersonalShopper::model()->countByAttributes(array('campana_id'=>$data->id));
      ?>
      <td><a href="#myModal" role="button" data-toggle="modal"><?php echo $ps; ?></a></td>
      <td><a href="#myModal2" role="button" data-toggle="modal">0</a></td>
      <td>0,00</td>
      <td><div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_campanas_crear.php"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a title="ver" href="#"> <i class="icon-eye-open"> </i> Ver</a></li>
            <li><a title="Editar" href="admin_anadir_campana.php"> <i class="icon-edit"> </i> Editar</a></li>
            <li><a title="Pausar" href="admin_anadir_campana.php"> <i class="icon-pause"> </i> Pausar</a></li>
            <li><a title="Play" href="admin_anadir_campana.php"> <i class="icon-play"> </i> Reanudar</a></li>
            <li class="divider"></li>
            <li><a title="Eliminar" href="#"> <i class="icon-trash"> </i> Eliminar</a></li>
          </ul>
        </div></td>
    </tr>