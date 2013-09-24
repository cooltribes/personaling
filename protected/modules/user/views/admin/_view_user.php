    
<?php if($data->status == 0){ ?>
    <tr class="warning">
<?php } else{ ?>
    <tr>
<?php } ?>
      <td><input name="Check" type="checkbox" value="Check"></td>
      <td>
      	<?php
      	 	// <img src="images/kitten.png" width="70" height="70" alt="avatar">
      	 		echo CHtml::image($data->getAvatar(),'Avatar',array("width"=>"70", "height"=>"70"));
      	 ?>
      	
      	
      </td>
      <td><h5 class="no_margin_bottom"> <?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></h5>
        <small><strong>ID</strong>: <?php echo $data->id; ?><br/>
        <?php echo $data->personal_shopper?'Personal Shopper':''; ?> </small></td>
      <td><small><?php echo $data->email; ?><br/>
        <strong>Telf.</strong>: <?php echo $data->profile->tlf_celular; ?> <br/>
        <strong>Ciudad</strong>: <?php echo $data->profile->ciudad; ?> <br/>
        <?php if($data->status == User::STATUS_NOACTIVE){ ?>
        <strong class="text-warning text-center">Cuenta no validada</strong>
        <?php }else if($data->status == User::STATUS_BANNED){ ?>          
        <strong class="text-error text-center">Cuenta bloqueada</strong>
        <?php } ?>   
     </small>
        

        </td>
      <td><?php echo $data->ordenCount; ?></td>
      <td><?php echo $data->direccionCount; ?></td>
      <td><?php $saldo=Profile::model()->getSaldo($data->id); echo $saldo." Bs.";?></td>
      <td><?php echo $data->visit; ?></td>
      <td><?php if ($data->getLastvisit()) echo  date("d/m/Y",$data->getLastvisit()); else echo 'N/D'; ?></td>
      <td><?php if ($data->getCreatetime()) echo  date("d/m/Y",$data->getCreatetime()); else echo 'N/D'; ?></td>
      <td>
      <div class="dropdown"> <a class="dropdown-toggle btn btn-block" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php" title="acciones"> <i class="icon-cog"></i></a> 
          <!-- Link or button to toggle dropdown -->
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
            <li>
        <?php echo CHtml::link('<i class="icon-eye-open">  </i>  Ver',array("profile/perfil","id"=>$data->id)); ?>            
            </li>
      <li>
        
       <?php echo CHtml::link('<i class="icon-edit">  </i>  Editar',array("admin/update","id"=>$data->id)); ?>
      </li>
      <li><a title="Cambiar contraseña" href="#" onclick='modal( <?php echo $data->id; ?>)'>  <i class="icon-lock">  </i>  Cambiar contraseña</a></li>
      <?php if($data->status == 0){ ?>
      <li>
        <?php echo CHtml::link('<i class="icon-refresh">  </i>  Reenviar Email de Verificación',array("admin/resendvalidationemail","id"=>$data->id)); ?>
      </li>
      <?php } ?>
      <li><a title="Reenviar invitacion" href="#">  <i class="icon-refresh">  </i>  Reenviar invitacion</a></li>
      <li><a title="Cargar Saldo" href="#" onclick='carga(<?php echo $data->id; ?>)'>  <i class="icon-gift">  </i>  Cargar Saldo</a>
       <li> <?php echo CHtml::link('<i class="icon-shopping-cart">  </i>  Registrar Orden',array("admin/compra","id"=>$data->id)); ?>
      
            <li class="divider"></li>
      <li><a title="Eliminar" href="#">  <i class="icon-trash">  </i>  Eliminar</a></li>
          </ul>
        </div>
      <?php if($data->status == 0){ ?>
      <?php } ?>
      </td>
    </tr>
    <div id='myModal' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        </div>
    <div id='saldoCarga' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        </div>
    
<script >
function modal(id){

	$.ajax({
		type: "post",
		'url' :'<?php echo  CController::createUrl('admin/contrasena');?>',
		data: { 'id':id}, 
		'success': function(data){
			$('#myModal').html(data);
			$('#myModal').modal(); 
		},
		'cache' :false});

}
function cambio(id){
	
	if($("#psw1").val()==$("#psw2").val())
	{	
		var psw=$("#psw2").val();
		$.ajax({
			type: "post",
			'url' :'<?php echo  CController::createUrl('admin/contrasena');?>',
			data: { 'psw':psw,
			'id':id}, 
			'success': function(data){
				
			window.location.reload();
			},
			'cache' :false});
	}
	else{
		alert("Ambos campos deben coincidir");		
	}

}
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
        if(cant.indexOf(',')==(cant.length-2))
        	cant+='0';
		if(cant.indexOf(',')==-1)
			cant+=',00';
        var pattern = /^\d+(?:\,\d{0,2})$/ ;
        if (pattern.test(cant)) { 
          cant=cant.replace(',','.');
           
           $.ajax({
			type: "post",
			'url' :'<?php echo  CController::createUrl('admin/saldo');?>',
			data: { 'cant':cant,
			'id':id}, 
			'success': function(data){
				window.location.reload();			
			},
			'cache' :false});
        }else{
        	alert("Formato de cantidad no válido");
         }
            
          


		
		
		
		
		
}





</script>