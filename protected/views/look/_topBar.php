<?php $id = $look->id; ?>

<!-- SUBMENU ON -->
<div class="navbar margin_top">
<div class="navbar-inner">
    <ul class="nav">
    <li <?php echo $this->getAction()->getId() == "informacion"?'class="active"':''; ?>>
    
        <?php echo CHtml::link('Información General',array('informacion','id'=>$id,)); ?>
        
    </li>
    <?php
    //Solo mostrar el link a descuentos si el look no tiene productos externos
    if(!$look->hasProductosExternos()){ ?>
    
        <li <?php echo $this->getAction()->getId() == "descuento"?'class="active"':''; ?> >

            <?php echo CHtml::link('Descuentos',array('descuento','id'=>$id,)); ?>

        </li>
    
    <?php } ?>
    
  </ul>
</div>
</div>