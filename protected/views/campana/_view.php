 <tr>
      <td><input name="check" type="checkbox" value=""></td>
      <td><?php echo $data->id; $ID=$data->id;?></td>
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
      <?php
      $creados = Look::model()->countByAttributes(array('status'=>0, 'campana_id'=>$data->id));
	  $enviados = Look::model()->countByAttributes(array('status'=>1, 'campana_id'=>$data->id));
	  $aprobados = Look::model()->countByAttributes(array('status'=>2, 'campana_id'=>$data->id));
      ?>
      <td><?php echo $creados+$enviados; ?></td>
      <td><?php echo $aprobados; ?></td>
      <?php
      $ps = CampanaHasPersonalShopper::model()->countByAttributes(array('campana_id'=>$data->id));
      ?>
      <td>
      	<?php
      	if($ps > 0){
	      	?>
	      	<a style="cursor: pointer;" role="button" onclick="get_ps(<?php echo $data->id; ?>)"><?php echo $ps; ?></a>
	      	<?php
		}else{
			echo '0';
		}
      	?>
      </td>
      <td>     
      	
      	<?php
      	
			$sql = "select count(distinct(m.nombre)) from tbl_campana c, tbl_look l, tbl_look_has_producto lp, tbl_producto p, tbl_marca m where c.id=".$data->id." and c.id=l.campana_id and l.id=lp.look_id and lp.producto_id=p.id and p.marca_id=m.id";
			$num = Yii::app()->db->createCommand($sql)->queryScalar();
			
			
			      	
      	?>
      	<a role="button" data-toggle="modal" onclick="get_marca(<?php echo $data->id; ?>)" style="cursor: pointer"><?php echo $num?></a>
      	
      </td>
      	
      	
      <td>0,00</td>
      <td><div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_campanas_crear.php"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a title="ver" onclick="ver_campana(<?php echo $data->id; ?>)" style="cursor: pointer;"> <i class="icon-eye-open"> </i> Ver</a></li>
            <li><?php echo CHtml::link('<i class="icon-edit"> </i> Editar', $this->createUrl('edit', array('id'=>$data->id))); ?></li>
            <?php 
            if($data->activo=="1")
            { 
            ?>
           		<li><a title="Desactivar Campaña" onclick="callModal('<?php echo $data->id; ?>', 0);" style="cursor: pointer;"> <i class="icon-pencil"> </i> Desactivar Campaña</a></li>
           	<?php 
			}
			else 
			{
			?>
				<li><a title="Activar Campaña" onclick="callModal('<?php echo $data->id; ?>', 1);" style="cursor: pointer;"> <i class="icon-pencil"> </i> Activar Campaña</a></li>
			<?php
			}
           	?>
            <!-- <li><a title="Pausar" href="admin_anadir_campana.php"> <i class="icon-pause"> </i> Pausar</a></li> -->
            <!-- <li><a title="Play" href="admin_anadir_campana.php"> <i class="icon-play"> </i> Reanudar</a></li> -->
            <!-- <li class="divider"></li> -->
            <!-- <li><a title="Eliminar" href="#"> <i class="icon-trash"> </i> Eliminar</a></li> -->
          </ul>
        </div></td>
    </tr>
    
    <?php 

    ?>
     


<script>
	function get_ps(campana_id){ 
		$.ajax({
	        type: "post",
	        dataType: 'html',
	        url: "getPS", // action 
	        data: { 'campana_id':campana_id }, 
	        success: function (data) {
				$('#ps_modal_body').html(data);
				$('#ps_modal').modal();
	       	}//success
	       });
	}
	function get_marca(campana_id){
		
		$.ajax({
	        type: "post",
	        dataType: 'html',
	        url: "getMarca", // action 
	        data: { 'campana_id':campana_id }, 
	        success: function (data) {
				$('#marca_modal_body').html(data);
				$('#marca_modal').modal();
	       	}//success
	       });
	}
	
		
</script>
