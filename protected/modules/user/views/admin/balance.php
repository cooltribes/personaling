<?php
$this->breadcrumbs = array(
    'Usuarios' => array('admin'),
    'Editar',);
?>
<div class="container margin_top">
    <div class="page-header">
        <h1>Editar Usuario</small></h1>
    </div>
    <!-- SUBMENU ON -->
    <?php $this->renderPartial('_menu', array('model' => $model, 'activo' => 11)); ?>
    <!-- SUBMENU OFF -->
    <div class="row margin_top">
        <div class="span12">
            <div class="bg_color3   margin_bottom_small padding_small box_1">
                <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Resumen de Balance</legend>
                        <div class=" margin_top">
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab1">Operaciones</a></li>

                                </ul>    
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">	            
                                        <table class="table table-bordered ta table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>Monto</th>
                                                    <th>Origen</th>
                                                    <th>Administrador</th>
                                                    <th>Fecha de Transacción</th>
                                                    <th>Nro. Orden</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($balances as $balance) {
                                                    if ($balance->total < 0)
                                                        $col = "<tr style='color:#F00'>";
                                                    else
                                                        $col = "<tr>";

                                                    echo $col . "<td >" . abs($balance->total) . "</td>";
                                                    echo "<td>" . $balance->origen . "</td>";

                                                    if ($balance->admin_id)
                                                        echo "<td>[<strong>ID: " . $balance->admin_id
                                                            ."</strong>] ". $balance->admin->profile->getNombre()                                                      
                                                            ." - <small>". $balance->admin->email
                                                            . "</small></td>";
                                                    else
                                                        echo "<td> N/A </td>";
                                                    
                                                    if ($balance->fecha)
                                                        echo "<td >" . $balance->getFecha(). "</td>";
                                                    else
                                                        echo "<td> N/A </td>";
                                                    
                                                    
                                                    if ($balance->orden_id > 0)
                                                        echo "<td >" . $balance->orden_id . "</td>";
                                                    else
                                                        echo "<td> N/A </td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        UNO
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /container -->
