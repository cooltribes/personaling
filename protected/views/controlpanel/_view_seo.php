<tr>
	<td><?php echo $data->name; ?></td>
	<td><?php echo $data->title; ?></td>
	<td><?php echo $data->description; ?></td>
	<td><?php echo $data->keywords; ?></td>
	<td><?php echo $data->url; ?></td>
	<td>
		<div class="dropdown"> <a class="dropdown-toggle btn btn-small" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_campanas_crear.php"> <i class="icon-cog"></i></a> 
          	<!-- Link or button to toggle dropdown -->
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><?php echo CHtml::link('<i class="icon-edit"> </i> Editar', $this->createUrl('createSeo', array('id'=>$data->id))); ?></li>
				<li><?php echo CHtml::link('<i class="icon-trash"> </i> Eliminar', $this->createUrl('deleteSeo', array('id'=>$data->id))); ?></li>
			</ul>
        </div>
	</td>
</tr>