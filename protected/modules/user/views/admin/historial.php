<?php 


$this->widget('zii.widgets.CListView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->buscarPsShopper(),

));