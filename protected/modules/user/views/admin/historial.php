<?php 


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->buscarPsShopper(),
	//'filter'=>$model,
	'columns'=>array(
		array(
		'name'=>'id_psShopper',
		'value'=>'$data->averiguarQuien()',
		),
		array(
		'name'=>'username',
		'value'=>'$data->averiguarNombre()',
		),
		array('name'=>'email','value'=>'$data->email',
                    'filter'=>CHtml::activeTextField($model, 'email',array("placeholder"=>"Filtre por email"))),
        array(
		'name'=>'admin_ps',
		'value'=>'$data->averiguarStatus()',
		),
		
	),
));