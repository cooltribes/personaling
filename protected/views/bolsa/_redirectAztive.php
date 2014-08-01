<!--
<h1>
    Procesando el pago, espera un momento por favor.    
</h1>
<?php echo $url; ?>
<br>
<a href="<?php echo $url; ?>">Ir a la confirmación</a>-->

<script>
    window.top.location.href = '<?php echo $url; ?>';
//    var n = '<?php echo $url; ?>';
</script>