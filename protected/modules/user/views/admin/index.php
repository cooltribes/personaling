<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar usuarios</h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">120 </p>
        Usuarios Totales</td>
      <td><p class="T_xlarge margin_top_xsmall"> 144 </p>
        Usuarios Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 156</p>
        Usuarios Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall">150</p>
        Personal Shoppers</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        Usuarios de Facebook </td>
      <td><p class="T_xlarge margin_top_xsmall"> 182 </p>
        Usuarios de Twitter</td>
    </tr>
  </table>
  <hr/>
  <div class="row margin_top margin_bottom ">
    <div class="span4">
      <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
        <input class="span3" id="prependedInput" type="text" placeholder="Buscar">
      </div>
    </div>
    <div class="span3">
      <select class="span3">
        <option>Filtros prestablecidos</option>
        <option>Filtro 1</option>
        <option>Filtro 2</option>
        <option>Filtro 3</option>
      </select>
    </div>
    <div class="span3"><a href="#" class="btn">Crear nuevo filtro</a></div>
    <div class="span2"><a href="#" class="btn btn-success">Crear usuario</a></div>
  </div>
    <hr/>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th rowspan="2" scope="col"><input name="Check" type="checkbox" value="Check"></th>
      <th colspan="3" rowspan="2" scope="col">Usuario</th>
      <th colspan="2" scope="col">Pedidos</th>
      <th rowspan="2" scope="col">Saldo Disponible</th>
      <th colspan="2" scope="col">Ingresos al Portal</th>
      <th rowspan="2" scope="col">Fecha de Registro</th>
      <th rowspan="2" scope="col"></th>
    </tr>
    <tr>
      <th scope="col">Pedidos</th>
      <th scope="col">Direcciones</th>
      <th scope="col">#</th>
      <th scope="col">Ultima Fecha</th>
    </tr>
    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="images/kitten.png" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS">Scott Pilgrim</span></strong><br/>
        <strong>ID</strong>: 0001<br/>
        Personal Shopper </td>
      <td><small><strong>eMail</strong>: keniadubay@gmail.com<br/>
        <strong>Telefono</strong>: 0424-709.85.06 <br/>
        <strong>Ciudad</strong>: San Cristobal 
        
     </small>
        
        </td>
      <td>0</td>
      <td>1</td>
      <td>300.00 Bs.</td>
      <td>25</td>
      <td>Ene. 11, 2013</td>
      <td>Dic 01, 2012</td>
      <td>
      <div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a title="ver" href="#">  <i class="icon-eye-open">  </i>  Ver</a></li>
      <li><a title="Editar" href="admin_editar_usuario.php">  <i class="icon-edit">  </i>  Editar</a></li>
      <li><a title="Cambiar contraseña" href="#">  <i class="icon-lock">  </i>  Cambiar contraseña</a></li>
      <li><a title="Reenviar invitacion" href="#">  <i class="icon-refresh">  </i>  Reenviar invitacion</a></li>
      <li><a title="Cargar Saldo" href="#">  <i class="icon-gift">  </i>  Cargar Saldo</a>
            <li class="divider"></li>
      <li><a title="Eliminar" href="#">  <i class="icon-trash">  </i>  Eliminar</a></li>
          </ul>
        </div>
          
      </td>
    </tr>
    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="images/hipster_girl.jpg" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS">John Snow</span></strong><br/>
        <strong>ID</strong>: 0001<br/>
        Personal Shopper </td>
      <td><small><strong>eMail</strong>: keniadubay@gmail.com<br/>
        <strong>Telefono</strong>: 0424-709.85.06 <br/>
        <strong>Ciudad</strong>: San Cristobal </small></td>
      <td>0</td>
      <td>1</td>
      <td>300.00 Bs.</td>
      <td>25</td>
      <td>Ene. 11, 2013</td>
      <td>Dic 01, 2012</td>
      <td> <div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a title="ver" href="#">  <i class="icon-eye-open">  </i>  Ver</a></li>
      <li><a title="Editar" href="admin_editar_usuario.php">  <i class="icon-edit">  </i>  Editar</a></li>
      <li><a title="Cambiar contraseña" href="#">  <i class="icon-lock">  </i>  Cambiar contraseña</a></li>
      <li><a title="Reenviar invitacion" href="#">  <i class="icon-refresh">  </i>  Reenviar invitacion</a></li>
      <li><a title="Cargar Saldo" href="#">  <i class="icon-gift">  </i>  Cargar Saldo</a>
            <li class="divider"></li>
      <li><a title="Eliminar" href="#">  <i class="icon-trash">  </i>  Eliminar</a></li>
          </ul>
        </div></td>
    </tr>
    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="images/kitten.png" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS">Lorem Ipsum</span></strong><br/>
        <strong>ID</strong>: 0001<br/>
        Personal Shopper </td>
      <td><small><strong>eMail</strong>: keniadubay@gmail.com<br/>
        <strong>Telefono</strong>: 0424-709.85.06 <br/>
        <strong>Ciudad</strong>: San Cristobal </small></td>
      <td>0</td>
      <td>1</td>
      <td>300.00 Bs.</td>
      <td>25</td>
      <td>Ene. 11, 2013</td>
      <td>Dic 01, 2012</td>
      <td> <div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a title="ver" href="#">  <i class="icon-eye-open">  </i>  Ver</a></li>
      <li><a title="Editar" href="admin_editar_usuario.php">  <i class="icon-edit">  </i>  Editar</a></li>
      <li><a title="Cambiar contraseña" href="#">  <i class="icon-lock">  </i>  Cambiar contraseña</a></li>
      <li><a title="Reenviar invitacion" href="#">  <i class="icon-refresh">  </i>  Reenviar invitacion</a></li>
      <li><a title="Cargar Saldo" href="#">  <i class="icon-gift">  </i>  Cargar Saldo</a>
            <li class="divider"></li>
      <li><a title="Eliminar" href="#">  <i class="icon-trash">  </i>  Eliminar</a></li>
          </ul>
        </div></td>
    </tr>
  </table>
  <div class="pagination pagination-right">
    <ul>
      <li class="disabled"><a href="#">&laquo;</a></li>
      <li class="active"><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">Next</a></li>
    </ul>
  </div>
  <hr/>
   <div class="row">
   <div class="span3"><select class="span3">
        <option>Seleccionar usuarios</option>
        <option>Lorem</option>
        <option>Ipsum 2</option>
        <option>Lorem</option>
      </select></div>
      <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
      </div>
</div>
<!-- /container -->

