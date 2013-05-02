<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend>Pedidos</legend>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered table-hover table-striped">
              <tbody>
                <tr>
                  <th scope="col">Fecha</th>
                  <th scope="col">Monto</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Método de pago</th>
                  <th scope="col">Acciones</th>
                </tr>
                <tr>
                  <td>21/12/2012 - 12:21 PM</td>
                  <td>8.890,00 Bs.</td>
                  <td>En espera de pago</td>
                  <td>Deposito / Transferencia</td>
                  <td><a title="Ver" href="admin_editar_pedidos.php"><i class="icon-eye-open"></i></a></td>
                </tr>
                <tr>
                  <td>21/12/2012 - 12:21 PM</td>
                  <td>8.890,00 Bs.</td>
                  <td>Recibido</td>
                  <td>TDC</td>
                  <td><a title="Ver" href="admin_editar_pedidos.php"><i class="icon-eye-open"></i></a></td>
                </tr>
                <tr>
                  <td>21/12/2012 - 12:21 PM</td>
                  <td>8.890,00 Bs.</td>
                  <td>En espera por confirmación</td>
                  <td>TDD</td>
                  <td><a title="Ver" href="admin_editar_pedidos.php"><i class="icon-eye-open"></i></a></td>
                </tr>
              </tbody>
            </table>
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
          <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
