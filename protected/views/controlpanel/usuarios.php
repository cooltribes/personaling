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
          </table>
        </div>
      </div>
      <h2 class="braker_bottom margin_bottom_small margin_top">Últimos usuarios registrados</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Clientes</a></li>
        <li><a data-toggle="tab" href="#tab2">Personal Shoppers</a></li>
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
            <tr>
              <td><a href="#" title="Ver perfil">John Doe</a></td>
              <td>1</td>
              <td>6</td>
              <td>184,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver perfil">John Doe</a></td>
              <td>1</td>
              <td>6</td>
              <td>184,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver perfil">John Doe</a></td>
              <td>1</td>
              <td>6</td>
              <td>184,00</td>
            </tr>
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
            <tr>
              <td><a href="#" title="Ver perfil">John Doe</a></td>
              <td>1</td>
              <td>6</td>
              <td>184,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver perfil">John Doe</a></td>
              <td>1</td>
              <td>6</td>
              <td>184,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver perfil">John Doe</a></td>
              <td>1</td>
              <td>6</td>
              <td>184,00</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->