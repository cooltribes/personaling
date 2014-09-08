<?php 
	
$this->breadcrumbs = array(
    'Usuarios' => array('admin'),
    'Historial',);
?>
<div class="container margin_top">
    <div class="page-header">
        <h1>Editar Usuario</small></h1>
    </div>
    <!-- SUBMENU ON -->
    <?php $this->renderPartial('_menu', array('model' => $model, 'activo' => 1)); ?>
    <!-- SUBMENU OFF -->
    <div class="row margin_top">
        <div class="span12">
            <div class="bg_color3   margin_bottom_small padding_small box_1">
                <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Historial de Personal Shopper</legend>
                        <div class=" margin_top">
                            <div class="">
                                <ul class="nav nav-tabs">
                                 
                                </ul>    
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">	            
                                        <table class="table table-bordered ta table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Quien lo realizo</th>
                                                    <th>A quien se Realizo</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $porciones = explode("-", $model->admin_ps);
												$porciones_fecha = explode("*", $model->fecha_ps);
											    $num=count($porciones_fecha)-1;
												$i=0;
												foreach(array_reverse($porciones) as $value)
												{
  													if($i!="0")
  													{
  														$ultima= explode("/", $value);	
  														 if($ultima[1]=="Q") 
														 {
														 	$col = "<tr style='color:#F00'>";
															echo $col . "<td >".$porciones_fecha[$num].  "</td>";
															echo "<td >".Profile::model()->findByPk($ultima[0])->first_name." ".Profile::model()->findByPk($ultima[0])->last_name.  "</td>";
															echo "<td >".Profile::model()->findByPk($model->id)->first_name." ".Profile::model()->findByPk($model->id)->last_name. "</td>";
															echo "<td>" . "Lo elimino como Personal Shopper" . "</td>";
														 }
														 else 
														 {
															 $col = "<tr>";
															echo $col . "<td >".$porciones_fecha[$num].  "</td>";
															echo "<td >".Profile::model()->findByPk($ultima[0])->first_name." ".Profile::model()->findByPk($ultima[0])->last_name.  "</td>";
															echo "<td >".Profile::model()->findByPk($model->id)->first_name." ".Profile::model()->findByPk($model->id)->last_name. "</td>";
															echo "<td>" . "Lo agrego como Personal Shopper" . "</td>";
														 } 
  													}
  													$i++;
													$num--;
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


