<?php

    echo"<tr>";
    echo "<td>" . $data->id . "</td>"; // id

    if ($data->fecha != "")
        echo "<td>" . date("d/m/Y h:i:s a", strtotime($data->fecha)) . "</td>";
    else
        echo "<td></td>";

    echo "<td>" . Yii::app()->numberFormatter->formatDecimal($data->total) . "</td>"; // precio
    //echo "<td>" . Yii::app()->numberFormatter->formatDecimal($data->getxPagar()) . "</td>"; // precio
    //----------------------Estado
    echo "<td>" . $data->textestado . "</td>";

    // agregar demas estados

    echo "<td>
                    <div class='dropdown'><a class='dropdown-toggle btn' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='/page.html'>
                    <i class='icon-cog'></i></a> 
                    <!-- Link or button to toggle dropdown -->
                    <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>";


    if ($data->estado == 1 || $data->estado == 6 || $data->estado == 7) {
        echo "<li>";

        echo CHtml::link("<i class='icon-edit'></i> ".Yii::t('backEnd', 'Register Payment')." ", $this->createUrl('orden/modals', array('id' => $data->id)), array(// for htmlOptions
            'onclick' => ' {' . CHtml::ajax(array(
                'url' => CController::createUrl('orden/modals', array('id' => $data->id)),
                'success' => "js:function(data){ $('#myModal').html(data);
                                                                            $('#myModal').modal(); }")) .
            'return false;}',
            // 'class'=>'delete-icon',
            'id' => 'link' . $data->id)
        );

        echo "</li>";
    }
    echo "<li><a tabindex='-1' href='detallepedido/" . $data->id . "'><i class='icon-eye-open'></i> ".Yii::t('backEnd', 'View Details')."</a></li>

                    ";

    if ($data->estado == 8 || $data->estado == 9) {
        echo "<li>" .
        CHtml::link("<i class='icon-arrow-left'></i> ".Yii::t('contentForm', 'Ask for Return')."", $this->createUrl('orden/devoluciones', array('id' => $data->id)), array(
            'id' => 'linkDevolver' . $data->id)
        )
        . "</li>";
    }
   
    if ($data->estado == 1 && Yii::app()->language=="es_es") {
        echo "<li class='divider'></li>
                        <li>" .
        CHtml::link("<i class='icon-ban-circle'></i> ".Yii::t('backEnd', 'Cancel Order')."", $this->createUrl('orden/cancelar', array('id' => $data->id)), array(
            'id' => 'linkCancelar' . $data->id)
        )
        . "</li>";
    }

    
    echo "</ul>
                    </div></td>	
                            ";

    echo("</tr>");
?>
