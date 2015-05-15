<?php /* @var $this Controller */ ?>
<?php 
$this->beginContent('//layouts/main_ve');
if (Yii::app()->language == "es_ve")
	$this->beginContent('//layouts/main_ve');
if (Yii::app()->language == "es_es") 
	$this->beginContent('//layouts/main_es');
 
?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>