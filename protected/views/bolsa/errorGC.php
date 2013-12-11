<?php

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
	
    <hr/>

    <div class='alert alert-error margin_top_medium margin_bottom'>
            <h1>No ha sido posible continuar con la compra.</h1>
            <br/>
            <p><b>Motivo:</b> <?php echo $mensaje; ?></p>
    </div>

    <p> En <b id="segundos">10</b> segundos serás redirigid@ al proceso de compra nuevamente</p>
    
    <hr/>
    
    <a href="<?php echo Yii::app()->createUrl('bolsa/pagoGC'); ?>" class="btn btn-danger" title="Intentar nuevamente">Intentar nuevamente</a> </div>
	

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