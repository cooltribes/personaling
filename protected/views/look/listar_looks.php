<?php 
$this->breadcrumbs = array(
    'Mis Looks',
);

Yii::app()->clientScript->registerScriptFile('http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js', CClientScript::POS_HEAD);  

?>

<div class="container" id="scroller-anchor">
	
	
    <div class="container" id="scroller">
        
    
  
    <div class="container">
        <div class="alert in" id="alert-msg" style="display: none">
            <button type="button" class="close" >&times;</button> 
            <!--data-dismiss="alert"-->
            <div class="msg"></div>
        </div>
    </div>
    <div>
    <?php
    $ps = User::model()->findByPk(Yii::app()->user->id);
    echo $ps->lookreferredviews;
    echo $ps->getLookReferredViewsByDate('2014-09-05','2014-09-17');
    $match = addcslashes('ps_id":"', '%_');
    echo ShoppingMetric::model()->count(
        'data LIKE :match',
        array(':match' => "%$match%")
    );

    ?>


</div>

<!-- SUBMENU OFF -->
<div class="container" id="tienda_looks">
    <?php if(empty($looks)){ ?>
    <p>
       No tienes looks disponibles. 
    </p>
        
    <?php } ?>
    <?php
    $this->renderPartial('_look', array(
        'looks' => $looks,
        'pages' => $pages,
    ));
    ?>
</div>

<?php 

 echo CHtml::hiddenField('toEnable','');
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'dialogLook')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h4><?php echo Yii::t('contentForm', 'Share Link'); ?></h4>
        </div>

        <div class="modal-body">
        	<span id="nombre">  		
        	</span>
        </div>
        <div class="modal-footer">

            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>Yii::t('contentForm', 'Close'),
                'url'=>'#',
                'htmlOptions'=>array('data-dismiss'=>'modal'),
            )); ?>
        </div>
        <?php $this->endWidget(); 
       
        ?>
        
