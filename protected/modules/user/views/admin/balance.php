<?php
$this->breadcrumbs = array(
    'Usuarios' => array('admin'),
    'Editar',);
?>

<?php /*
$models=User::model()->findAllBySql("select * from tbl_users where create_at>= '2014-07-01' and create_at<= '2014-07-24'");
				foreach($models as $modelado)
				{
					$saldo=Profile::model()->getSaldo($modelado->id);
					
					if($saldo>0 && $saldo <=5)
					{
						//echo $modelado->id."----";
						$balance=new Balance;
						$balance->total=$saldo*(-1); // coloco el usuario que se le quiere hacer el cambio
						$balance->orden_id=0;
						$balance->admin_id = 228; //guardar cual admin fue
						$balance->user_id=$modelado->id; // el usuario que se quiera hacer el cambio
						$balance->tipo=12;
						$balance->fecha = date("Y-m-d H:m:i");
						$balance->save();
					}
				}
*/
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
                                	<div id="saldoAct" align="right">
                                	<a title="Cargar Saldo" href="#" onclick='carga(<?php echo $model->id; ?>)'>  <i class="icon-gift">  </i>  Cargar Saldo</a> 
                                	</div>                                  
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

<div id='saldoCarga' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
       </div>

<script>

function carga(id){

	$.ajax({
		type: "post",
		'url' :'<?php echo  CController::createUrl('admin/saldo');?>',
		data: { 'id':id}, 
		'success': function(data){
			$('#saldoCarga').html(data);
			$('#saldoCarga').modal(); 
		},
		'cache' :false});

}
function saldo(id){	
		
		var cant=$("#cant").val();
       	var desc=0;
        if(cant.length>1){
	        if(cant.indexOf(',')==(cant.length-2))
	        	cant+='0';
			if(cant.indexOf(',')==-1)
				cant+=',00';
				}
        var pattern = /^\d+(?:\,\d{0,2})$/ ;
       
       if($('#discount').attr('checked')=='checked')
       	desc=1;
       
        
        if (pattern.test(cant)||cant.length<2) { 
          	cant=cant.replace(',','.');
           
           $.ajax({
			type: "post",
			'url' :'<?php echo  CController::createUrl('admin/saldo');?>',
			data: { 'cant':cant,
			'id':id,'desc':desc}, 
			'success': function(data){
				window.location.reload();	                                    
			},
			'cache' :false});
        }else{
        	alert("Formato de cantidad no válido");
         }     
}





</script>
