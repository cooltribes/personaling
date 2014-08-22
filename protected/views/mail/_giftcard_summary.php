<multiline label="Description" width="580">
<?php echo $body; ?>
</multiline>
<p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>


<table border="0" cellspacing="3" cellpadding="5" class="table table-bordered table-hover table-striped" width="100%">
    <thead>
        <tr>
            <th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Via</th>
            <th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Destinatario</th>
            <th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Monto</th>            
        </tr>
    </thead>
    <tbody>
        <?php echo $resumen ?>
    </tbody>
</table>