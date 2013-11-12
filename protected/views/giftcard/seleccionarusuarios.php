<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */


$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Generar Masivo',
    'Seleccionar Usuarios'
);

?>
<div class="container">
<h1>Seleccionar Usuarias</h1>
<div class="container margin_top">
  <div class="row margin_top margin_bottom ">
    <div class="span4">
      <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
        <input class="span3" id="prependedInput" type="text" placeholder="Buscar">
      </div>
    </div>
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
    </tr>
    <tr>
      <th scope="col">Pedidos</th>
      <th scope="col">Direcciones</th>
      <th scope="col">#</th>
      <th scope="col">Ultima Fecha</th>
    </tr>
    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="http://placehold.it/70x70" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS">Scott Pilgrim</span></strong><br/>
        <strong>ID</strong>: 0001<br/>
        Personal Shopper </td>
      <td><small><strong>Email</strong>: keniadubay@gmail.com<br/>
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
    </tr>
    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="http://placehold.it/70x70" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS">John Snow</span></strong><br/>
        <strong>ID</strong>: 0001<br/>
        Personal Shopper </td>
      <td><small><strong>Email</strong>: keniadubay@gmail.com<br/>
        <strong>Telefono</strong>: 0424-709.85.06 <br/>
        <strong>Ciudad</strong>: San Cristobal </small></td>
      <td>0</td>
      <td>1</td>
      <td>300.00 Bs.</td>
      <td>25</td>
      <td>Ene. 11, 2013</td>
      <td>Dic 01, 2012</td>
    </tr>
    <tr>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td><img src="http://placehold.it/70x70" width="70" height="70" alt="avatar"></td>
      <td><strong> <span class="CAPS">Lorem Ipsum</span></strong><br/>
        <strong>ID</strong>: 0001<br/>
        Personal Shopper </td>
      <td><small><strong>Email</strong>: keniadubay@gmail.com<br/>
        <strong>Telefono</strong>: 0424-709.85.06 <br/>
        <strong>Ciudad</strong>: San Cristobal </small></td>
      <td>0</td>
      <td>1</td>
      <td>300.00 Bs.</td>
      <td>25</td>
      <td>Ene. 11, 2013</td>
      <td>Dic 01, 2012</td>
    </tr>
  </table>

  <hr/>
   <div class="row">
        <div class="span2 offset10">
            <a href="#" title="Seleccionar Diseño" class="btn btn-block btn-danger">Seleccionar Diseño</a>
        </div>
    </div>
</div>
<!-- /container -->    
</div>
