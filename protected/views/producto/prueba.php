<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
)); ?>

<?php

foreach($categorias as $una)
{
	$cat = Categoria::model()->findByPk($una->tbl_categoria_id);
	echo $cat->nombre." </br>";
}


nodos($categorias);
		
			function nodos($items){
				echo "<ul class='no_bullets'>";
				foreach ($items as $item){
						echo "<li><label><input id='".$item->tbl_categoria_id."' type='checkbox' value='' /> </label></li>";
						
						if ($item->hasChildren()){
							nodos($item->getChildren());
						}
					}
				echo "</ul>";
				return 1;
			}

?>

<?php $this->endWidget(); ?>