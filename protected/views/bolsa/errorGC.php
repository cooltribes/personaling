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
            <p><?php echo '<p>'.Yii::t('contentForm','Reason').':</p> '.$mensaje; ?></p>
    </div>

    <p> <?php echo Yii::t('contentForm','In <b id="segundos">10</b> seconds this page will be redirected to the Shopping Bag'); ?></p>
    
    <hr/>
    
    <a href="<?php echo Yii::app()->createUrl('bolsa/pagoGC'); ?>" class="btn btn-danger" title="Intentar nuevamente"><?php echo Yii::t('contentForm','Intentar nuevamente'); ?></a> </div>
	

<script type="text/javascript">
    
var secs = 10;

function timer()
{        
    setTimeout(function(){            

        secs--;            
        $("#segundos").text(secs);

        if(secs == 1){
            window.location = "<?php echo Yii::app()->createUrl('bolsa/pagoGC'); ?>";
        }else{
            timer();
        }    

    }, 1000); 
}


$(document).ready(function() {

    timer();

});
	
</script>