<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('padreId')); ?>:</b>
	<?php echo CHtml::encode($data->padreId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('urlImagen')); ?>:</b>
	<?php echo CHtml::encode($data->urlImagen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mTitulo')); ?>:</b>
	<?php echo CHtml::encode($data->mTitulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mDescripcion')); ?>:</b>
	<?php echo CHtml::encode($data->mDescripcion); ?>
	<br />


</div>