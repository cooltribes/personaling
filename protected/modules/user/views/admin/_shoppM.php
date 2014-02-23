<tr>	
    <td><?php 
    
        echo "<b>".$data->step.".-</b> ";
        switch ($data->step){
            case 0:
                echo "Viendo el carrito"; 
                break;
            case 1:
                echo "Autenticación"; 
                break;
            case 2:
                echo "Escogiendo dirección"; 
                break;
            case 3:
                echo "Escogiendo método de pago"; 
                break;
            case 4:
                echo "Confirmando la compra"; 
                break;
            default: //5
                echo "Viendo resumen del pedido"; 
        }
    
    
    ?></td>
    <td><?php echo "<strong>".date("d/m/Y",strtotime($data->created_on)).
            "    </strong> - ".date("H:i:s",strtotime($data->created_on))?></td>
</tr>