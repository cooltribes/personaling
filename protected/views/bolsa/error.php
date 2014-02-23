<?php

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
	
	
	<hr/>
	
	<div class='alert alert-error margin_top_medium margin_bottom'>
		<h1><?php echo Yii::t('contentForm','It was not possible to continue with the order.'); ?></h1>
	   	<br/>
	   	<p><?php echo Yii::t('contentForm','Reason').': '.$mensaje; ?></p>
	</div>
	
	<p> <?php echo Yii::t('contentForm','In 10 seconds this page will be redirected to the Shopping Bag.'); ?>/p>
	<hr/>
		<a href="<?php echo Yii::app()->createUrl('tienda/index'); ?>" class="btn btn-danger" title="seguir comprando">
			<?php echo Yii::t('contentForm','Keep buying'); ?></a>
		 </div>
<script>

	$(document).ready(function() {
		setTimeout(function(){
			window.location = "<?php echo Yii::app()->createUrl('bolsa/index'); ?>";
		}, 10000); /* 5 seconds */
	});
	
	
</script>