<?php 
$this->breadcrumbs = array(
    'Mis Looks',
);
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