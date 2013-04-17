<?php
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Detalle',
);

$usuario = User::model()->findByPk($orden->user_id); 

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>PEDIDO #<?php echo $orden->id; ?></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="4"> PEDIDO #<?php echo $orden->id; ?> - <span class="color1"><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></span> </th>
      <th scope="col" colspan="2"><div class="text_align_right">23/03/2013 - 05:30 p.m.</div></th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall color1">Recibido </p>
        Estado actual</td>
      <td><p class="T_xlarge margin_top_xsmall"> 4 </p>
        Documentos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 4</p>
        Mensajes<br/></td>
      <td><p class="T_xlarge margin_top_xsmall">150</p>
        Prendas</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        Bolivares (Bs.)</td>
      <td><a href="#" class="btn margin_top pull-right"><i class="icon-print"></i> Imprimir pedido</a></td>
    </tr>
  </table>
  <hr/>
  <div class="row">
    <div class="span7">
      <h3 class="braker_bottom margin_top"> Información del cliente</h3>
      <div class="row">
        <div class="span1"><img src="http://placehold.it/90" title="Nombre del usuario"></div>
        <div class="span6">
          <h2>John Doe<small> C.I. 14.941.873</small></h2>
          <div class="row">
            <div class="span3">
              <ul class="no_bullets no_margin_left">
                <li><strong>eMail</strong>: johannmg@gmail.com </li>
                <li><strong>Telefono</strong>: 0414-724.80.43 </li>
                <li><strong>Ciudad</strong>: San Cristobal </li>
              </ul>
            </div>
            <div class="span3">
              <ul class="no_bullets no_margin_left">
                <li><strong>Cuenta registrada</strong>: 21/12/2012 - 12:21 pm</li>
                <li><strong>Pedidos validos realizados</strong>: 0</li>
                <li><strong>Total comprado desde su registro</strong>: 0,00 Bs. </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="well well-small margin_top well_personaling_small">
        <h3 class="braker_bottom "> Método de Pago</h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Método de pago</th>
            <th scope="col">ID de Transaccion</th>
            <th scope="col">Monto</th>
            <th scope="col"></th>
          </tr>
          <tr>
            <td>21/12/2012 - 12:21 PM</td>
            <td>Deposito o Transferencia</td>
            <td>12345678910</td>
            <td>8.890,00 Bs.</td>
            <td><a href="#" title="Ver"><i class="icon-eye-open"></i></a></td>
          </tr>
        </table>
      </div>
      <div class="well well-small margin_top well_personaling_small">
        <h3 class="braker_bottom "> Transporte </h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Tipo</th>
            <th scope="col">Transportista</th>
            <th scope="col">Peso</th>
            <th scope="col">Costo de envio</th>
            <th scope="col">Numero de seguimiento</th>
            <th scope="col"></th>
          </tr>
          <tr>
            <td>21/12/2012 - 12:21 PM</td>
            <td>Delivery</td>
            <td>DHL</td>
            <td>0,00 Kg.</td>
            <td>180,00 Bs.</td>
            <td>1234567891012345</td>
            <td><a href="#" title="Editar"><i class="icon-edit"></i></a></td>
          </tr>
        </table>
      </div>
      <div class="row-fluid">
        <div class="span6">
          <h3 class="braker_bottom margin_top">Dirección de envío</h3>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
          </div>
          <a href="#" class="btn"><i class="icon-edit"></i></a> </div>
        <div class="span6">
          <h3 class="braker_bottom margin_top">Dirección de Facturación</h3>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
            <a href="#" class="btn"><i class="icon-edit"></i></a> </div>
        </div>
      </div>
    </div>
    <div class="span5">
      <div class="well well_personaling_big">
        <h3 class="braker_bottom"><strong>Acciones pendientes</strong></h3>
        <div class="alert alert-block ">
          <h4 class="alert-heading ">Confirmar Pago:</h4>
          <ul class="padding_bottom_small padding_top_small">
            <li>Banco: Mercantil</li>
            <li>Monto: XXXX</li>
            <li>Fecha</li>
          </ul>
          <p> <a href="#" class="btn" title="Aceptar pago"><i class="icon-check"></i> Aceptar</a> <a href="#" class="btn" title="Rechazar pago">Rechazar</a> </p>
        </div>
        <div class="alert alert-block form-inline ">
          <h4 class="alert-heading "> Enviar pedido:</h4>
          <p>
            <input name="" type="text" placeholder="Numero de Tracking">
            <a href="#" class="btn" title="Rechazar pago">Enviar</a> </p>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Estado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Fecha</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <td>Pendiente por confirmar</td>
            <td>Sophia Marquez</td>
            <td>21/12/2012 </td>
            <td><a tabindex="-1" href="#"><i class="icon-edit"></i></a></td>
          </tr>
          <tr>
            <td>Pendiente de Pago</td>
            <td>Sophia Marquez</td>
            <td>21/12/2012 </td>
            <td><a tabindex="-1" href="#"><i class="icon-edit"></i></a></td>
          </tr>
          <tr>
            <td>Nuevo Pedido</td>
            <td>Sophia Marquez</td>
            <td>21/12/2012 </td>
            <td><a tabindex="-1" href="#"><i class="icon-edit"></i></a></td>
          </tr>
        </table>
      </div>
  <div class="well well-small margin_top well_personaling_small">  <h3 class="braker_bottom margin_top"> Documentos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Documento</th>
          <th scope="col">Número</th>
        </tr>
        <tr>
          <td>21/12/2012 </td>
          <td>Factura</td>
          <td>12345</td>
        </tr>
        <tr>
          <td>21/12/2012 </td>
          <td>Recibo de Pago</td>
          <td>23123</td>
        </tr>
        <tr>
          <td>21/12/2012 </td>
          <td>Etiqueta de direccion</td>
          <td>1231234</td>
        </tr>
        <tr>
          <td>21/12/2012 </td>
          <td>Orden de devolucion</td>
          <td>45648</td>
        </tr>
        <tr>
          <td>21/12/2012 </td>
          <td>Tarjeta de regalo</td>
          <td>123546</td>
        </tr>
      </table></div>
    </div>
  </div>
  <hr/>
  <!-- INFORMACION DEL PEDIDO ON -->
  <div class="row">
    <div class="span7">
   <div class="well well-small margin_top well_personaling_small">   <h3 class="braker_bottom margin_top">Productos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col">Nombre de la prenda</th>
          <th scope="col">Cant. en Existencia</th>
          <th scope="col">Cant. en Pedido</th>
          <th scope="col">Precio Unitario</th>
          <th scope="col">Subtotal</th>
          <th scope="col">Descuento</th>
          <th scope="col">Impuesto</th>
          <th scope="col">Accion</th>
        </tr>
        <tr>
          <td>Vestido</td>
          <td>10</td>
          <td>4</td>
          <td>12.000,00</td>
          <td>48.000,00</td>
          <td>8.000,00</td>
          <td>12.000,00</td>
          <td><div class="dropdown"> <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html"> <i class="icon-cog"></i></a> 
              <!-- Link or button to toggle dropdown -->
              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                <li><a tabindex="-1" href="#"><i class="icon-edit"></i> Editar</a></li>
                <li class="divider"></li>
                <li><a tabindex="-1" href="#"><i class="icon-trash"></i> Eliminar</a></li>
              </ul>
            </div></td>
        </tr>
        <tr>
          <td>Vestido</td>
          <td>10</td>
          <td>4</td>
          <td>12.000,00</td>
          <td>48.000,00</td>
          <td>8.000,00</td>
          <td>12.000,00</td>
          <td><div class="dropdown"> <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html"> <i class="icon-cog"></i></a> 
              <!-- Link or button to toggle dropdown -->
              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                <li><a tabindex="-1" href="#"><i class="icon-edit"></i> Editar</a></li>
                <li class="divider"></li>
                <li><a tabindex="-1" href="#"><i class="icon-trash"></i> Eliminar</a></li>
              </ul>
            </div></td>
        </tr>
        <tr>
          <td>Vestido</td>
          <td>10</td>
          <td>4</td>
          <td>12.000,00</td>
          <td>48.000,00</td>
          <td>8.000,00</td>
          <td>12.000,00</td>
          <td><div class="dropdown"> <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html"> <i class="icon-cog"></i></a> 
              <!-- Link or button to toggle dropdown -->
              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                <li><a tabindex="-1" href="#"><i class="icon-edit"></i> Editar</a></li>
                <li class="divider"></li>
                <li><a tabindex="-1" href="#"><i class="icon-trash"></i> Eliminar</a></li>
              </ul>
            </div></td>
        </tr>
        <tr>
          <td>Vestido</td>
          <td>10</td>
          <td>4</td>
          <td>12.000,00</td>
          <td>48.000,00</td>
          <td>8.000,00</td>
          <td>12.000,00</td>
          <td><div class="dropdown"> <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html"> <i class="icon-cog"></i></a> 
              <!-- Link or button to toggle dropdown -->
              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                <li><a tabindex="-1" href="#"><i class="icon-edit"></i> Editar</a></li>
                <li class="divider"></li>
                <li><a tabindex="-1" href="#"><i class="icon-trash"></i> Eliminar</a></li>
              </ul>
            </div></td>
        </tr>
      </table>
      <a href="#" title="Añadir productos" class="btn btn-info"><i class="icon-plus icon-white"></i> Añadir productos</a></div> </div>
    <div class="span5">
   <div class="well well-small margin_top well_personaling_small"> <h3 class="braker_bottom margin_top"> Resumen del Pedido</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col">No de Looks</th>
          <th scope="col">1</th>
        </tr>
        <tr>
          <td>No de Prendas</td>
          <td>4</td>
        </tr>
        <tr>
          <td>SubTotal</td>
          <td>2.400,00</td>
        </tr>
        <tr>
          <td>Descuento</td>
          <td>0,00</td>
        </tr>
        <tr>
          <td>Envio y Transporte</td>
          <td> 180,00</td>
        </tr>
        <tr>
          <td>Impuesto</td>
          <td> 307,20</td>
        </tr>
        <tr>
          <td>Total</td>
          <td>2.887,20</td>
        </tr>
      </table></div>
    </div>
  </div>
  <!-- INFORMACION DEL PEDIDO OFF -->
  <hr/>
  
  <!-- MENSAJES ON -->
  
  <div class="row">
    <div class="span7">
      <h3 class="braker_bottom margin_top">MENSAJES</h3>
      <form>
        <div class="control-group">
          <select>
            <option>Elija un mensaje estandar</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>
        <div class="control-group">
          <textarea name="Mensaje" cols="" class="span7" rows="4"></textarea>
        </div>
        <div class="control-group">
          <label class="checkbox">
            <input type="checkbox" value="">
            Notificar al Cliente por eMail </label>
          <label class="checkbox">
            <input type="checkbox" value="">
            Hacer visible en el Frontend</label>
        </div>
        <div class="form-actions"><a href="#" title="Enviar" class="btn btn-inverse">Enviar comentario</a> </div>
      </form>
    </div>
    <div class="span5">
      <h3 class="braker_bottom margin_top">Historial de Mensajes</h3>
      <ul class="media-list">
        <li class="media braker_bottom">
          <div class="media-body">
            <h4 class="color4"><i class=" icon-comment"></i> Asunto: XXX YYY ZZZ</h4>
            <p class="muted"> <strong>23/03/2013</strong> 12:35 PM <strong>| Recibido | Cliente: <strong>Notificado</strong> </strong></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
            <!-- Nested media object --> 
            
          </div>
        </li>
        <li class="media braker_bottom">
          <div class="media-body">
            <h4 class="color4"><i class=" icon-comment"></i> Asunto: XXX YYY ZZZ</h4>
            <p class="muted"> <strong>23/03/2013</strong> 12:35 PM <strong>| Recibido | Cliente: <strong>Notificado</strong> </strong></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
            <!-- Nested media object --> 
            
          </div>
        </li>
        <li class="media braker_bottom">
          <div class="media-body">
            <h4 class="color4"><i class=" icon-comment"></i> Asunto: XXX YYY ZZZ</h4>
            <p class="muted"> <strong>23/03/2013</strong> 12:35 PM <strong>| Recibido | Cliente: <strong>Notificado</strong> </strong></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
            <!-- Nested media object --> 
            
          </div>
        </li>
      </ul>
    </div>
    
    <!-- MENSAJES OFF --> 
    
  </div>
</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Desea aceptar este pago?</h3>
  </div>
  <div class="modal-body">
    <p><strong>Detalles</strong></p>
    <ul>
      <li><strong>Usuaria</strong>: Maria Perez</li>
      <li><strong>Fecha de compra</strong>: 18/10/1985</li>
      <li><strong>Monto</strong>: Bs. 6.500</li>
    </ul>
  </div>
  <div class="modal-footer"><a href="" title="ver" class="btn-link" target="_blank">Cancelar </a> <a href="#" title="Confirmar" class="btn btn-success">Aceptar el pago</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->
