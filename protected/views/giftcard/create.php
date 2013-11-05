<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Giftcard', 'url'=>array('index')),
	array('label'=>'Manage Giftcard', 'url'=>array('admin')),
);
?>

<h1>Create Giftcard</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>