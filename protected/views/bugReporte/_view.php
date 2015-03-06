        <legend>Status de Falla Tecnica</legend>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped" align="center">
        	<thead>
        		<tr>
        			<th>Usuario</th>
        			<th>Descripcion</th>
        			<th>Estado</th>
        			<th>Fecha</th>     			
        		</tr>        		
        	</thead>
        	<tbody>
        		
        		<?php foreach ($model as $historico)
				 {
                         ?>			
        		<tr>
        			<td><?php $userObject = User::model()->findByPk($historico->user_id);  echo $userObject->profile->first_name." ".$userObject->profile->last_name; ?></td>
        			<td><?php echo $historico->descripcion; ?></td>
        			<td><?php echo $historico->getEstados($historico->estado); ?></td>
        			<td><?php echo $historico->fecha; ?></td>
        			
        		</tr>
        		<?php } ?>
        	</tbody>
        	
        </table>