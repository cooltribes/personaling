<?php header("Content-type: text/xml"); 
header('Content-Disposition: attachment; filename="text.xml"'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; $content="HOLA";?>

<Response>         
        <Tag><?php echo $content; ?></Tag>
</Response>