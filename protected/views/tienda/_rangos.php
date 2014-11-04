<?php if ($tipo != "mobile"): ?>
                        <ul class="dropdown-menu" id="price-ranges" role="menu" aria-labelledby="dLabel">
                                    <?php foreach ($rangos as $key => $rango) { ?>
                                <li><a class="btn-link price-filter" id="<?php echo "{$rango['start']}-{$rango['end']}"; ?>">
                                        <?php
                                        if (!$key) {
                                            echo "Hasta ".Yii::app()->numberFormatter->format("#,##0.00",$rango['end'])." "
                                            .Yii::t('contentForm', 'currSym');
                                        } else {
                                            if ($key < 3) {
                                                echo "De ".Yii::app()->numberFormatter->format("#,##0.00",$rango['start'])." 
                                                    a ".Yii::app()->numberFormatter->format("#,##0.00",$rango['end'])." "
                                                        .Yii::t('contentForm', 'currSym');
                                            } else {
                                                echo "Más de ".Yii::app()->numberFormatter->format("#,##0.00",$rango['start']).
                                                        " ".Yii::t('contentForm', 'currSym');
                                            }
                                        }
                                        ?>
                                        <span class="color12">
                                <?php echo "({$rango['count']})" ?>
                                        </span>
                                    </a></li>
<?php } ?>
                        <?php if(!empty($rangos)){ ?>
                            <li><a class="btn-link price-filter" id="<?php echo "{$rangos[0]['start']}-{$rangos[3]['end']}" ?>">Todos <span class="color12"></span></a></li>
                        <?php } ?>  
                            
                        </ul>

<?php else: ?>

    <?php
    foreach ($rangos as $key => $rango) { ?>
        <a class="btn-link price-mobile" id="<?php echo "{$rango['start']}-{$rango['end']}"; ?>">
            <?php
            if (!$key) {
                echo "Hasta ".Yii::app()->numberFormatter->format("#,##0.00",$rango['end'])." "
                    .Yii::t('contentForm', 'currSym');
            } else {
                if ($key < 3) {
                    echo "De ".Yii::app()->numberFormatter->format("#,##0.00",$rango['start'])."
                                                    a ".Yii::app()->numberFormatter->format("#,##0.00",$rango['end'])." "
                        .Yii::t('contentForm', 'currSym');
                } else {
                    echo "Más de ".Yii::app()->numberFormatter->format("#,##0.00",$rango['start']).
                        " ".Yii::t('contentForm', 'currSym');
                }
            }
            ?>
            <span class="color12">
                                <?php echo "({$rango['count']})"; ?>
                                        </span>
        </a><br/>
    <?php } ?>
    <?php if(!empty($rangos)){ ?>
        <a class="btn-link price-filter" id="<?php echo "{$rangos[0]['start']}-{$rangos[3]['end']}" ?>">Todos <span class="color12"></span></a>
    <?php } ?>

<?php endif; ?>