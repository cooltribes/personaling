<div class="container margin_top">
  <div class="page-header">
    <div class="row">
      <div class="span10">
        <h1>Panel de Control de Usuarios</h1>
      </div>
      <div class="span2">
        <div class="bg_color10 padding_small color1 text_align_center"><span class="T_large">1844</span><br/>
          usuarios registrados</div>
      </div>
    </div>
  </div>
  <!-- SUBMENU ON -->
  <?php include('menu_panel_usuarios.php'); ?>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span12">
      <div class="bg_color3 margin_bottom_small padding_small box_1">
        <ul class="nav nav-tabs">
          <li><a data-toggle="tab" href="#tab11">Registro de Usuarios</a></li>
          <li class="active"><a data-toggle="tab" href="#tab12">Ingreso de Usuarios</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab11"> <img src="images/stats_sample.png" alt="estadisticas"/> </div>
        </div>
      </div>
      <div class="row margin_top">
        <div class="span12">
          <h4 class="CAPS braker_bottom margin_bottom_small">REGISTROS</h4>
          <?php $us= new User;?>
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Tipos</th>
              <th scope="col">Registros</th>
              <th scope="col">% Registros</th>
            </tr>
            <tr>
              <td>Clientes</td>
              <td><?php echo $us->getTotalClients(); ?></td>
              <td><?php echo $us->getPercent('Client')." %"; ?></td>
            </tr>
            <tr>
              <td>Personal Shoppers</td>
              <td><?php echo $us->getTotalPS(); ?></td>
              <td><?php echo $us->getPercent('PS')." %"; ?></td>
            </tr>
            <tr>
              <td>Administradores</td>
              <td><?php echo $us->getTotalAdmin(); ?></td>
              <td><?php echo $us->getPercent('Admin')." %"; ?></td>
            </tr>
            <tr> 
              <td>Aplicantes</td>
              <td><?php echo $us->getAplicantes(); ?></td>
              <td><?php echo $us->getPercent('App')." %"; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <h2 class="braker_bottom margin_bottom_small margin_top">Últimos usuarios registrados</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Clientes</a></li>
        <li><a data-toggle="tab" href="#tab2">Personal Shoppers</a></li>
        <li><a data-toggle="tab" href="#tab3">Administradores</a></li>
        <li><a data-toggle="tab" href="#tab4">Aplicantes a PS</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab1">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Numero de Pedidos</th>
              <th scope="col">Promedio de Pedidos</th>
              <th scope="col">Total de Pedidos</th>
            </tr>
            <?php
            $last3=User::model()->getLast3("Client");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
            	$T=Orden::model()->countOrdersByUser($last); 
            	echo "<td>".$T." Bs.</td>";
				if($T>0)
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(round(Orden::model()->getPurchasedByUser($last)/Orden::model()->countOrdersByUser($last),2))." Bs</td>";
				else
					echo "<td>0</td>";
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(Orden::model()->getPurchasedByUser($last))." Bs.</td></tr>";
            	
            }
            ?>
            
          </table>
        </div>
        <div class="tab-pane" id="tab2">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre del PS</th>
              <th scope="col">Numero de Pedidos</th>
              <th scope="col">Promedio de Pedidos</th>
              <th scope="col">Total de Pedidos</th>
            </tr>
            <?php
            $last3=User::model()->getLast3("PS");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
            	$T=Orden::model()->countOrdersByUser($last); 
            	echo "<td>".$T." Bs.</td>";
				if($T>0)
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(round(Orden::model()->getPurchasedByUser($last)/Orden::model()->countOrdersByUser($last),2))." Bs</td>";
				else
					echo "<td>0</td>";
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(Orden::model()->getPurchasedByUser($last))." Bs.</td></tr>";
            	
            }
            ?>
          </table>
        </div>
        <div class="tab-pane" id="tab3">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Administrador</th>
              <th scope="col">Numero de Pedidos</th>
              <th scope="col">Promedio de Pedidos</th>
              <th scope="col">Total de Pedidos</th>
            </tr>
            <?php
            $last3=User::model()->getLast3("Admin");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
            	$T=Orden::model()->countOrdersByUser($last); 
            	echo "<td>".$T." Bs.</td>";
				if($T>0)
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(round(Orden::model()->getPurchasedByUser($last)/Orden::model()->countOrdersByUser($last),2))." Bs</td>";
				else
					echo "<td>0</td>";
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(Orden::model()->getPurchasedByUser($last))." Bs.</td></tr>";
            	
            }
            ?>
          </table>
        </div>
        <div class="tab-pane" id="tab4">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Aplicante</th>
              <th scope="col">Fecha de Registro</th>
              
            </tr>
            <?php
            $last3=User::model()->getLast3("App");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
				echo " <td>".User::model()->getCreate_at($last)."</td>";           	
            	
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->