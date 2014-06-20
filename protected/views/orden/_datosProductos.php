<?php 

// calculo de precio de venta de producto si pertenece a un look con descuento
$precio = $data['Precio'];
$precio_iva = $data['pIVA'];
if($data['look']!=0){
    $look = Look::model()->findByPk($data['look']);
    $orden = Orden::model()->findByPk($data['Orden']);
    if($look && $orden){
        if(!is_null($look->tipoDescuento) && $look->valorDescuento > 0){
            if($orden->getLookProducts($look->id) == $look->countItems()){
                //echo 'Precio: '.$look->getPrecio(false).' - Precio desc: '.$look->getPrecioDescuento(false);
                $descuento_look = $look->getPrecio(false) - $look->getPrecioDescuento(false);
                $porcentaje = ($descuento_look * 100) / $look->getPrecio(false);
                //echo $descuento_look.' - '.$porcentaje;

                $precio -= $data['Precio'] * ($porcentaje / 100);
                $precio_iva -= $data['pIVA'] * ($porcentaje / 100);
            }
        }
    }
}

    echo"<tr> 
    <td>".$data['SKU']."</td>
    <td>".$data['Referencia']."</td>
    <td>".$data['Marca']."</td>
    <td>".$data['Nombre']."</td>
   
    <td>".$data['Color']."</td>
    <td>".$data['Talla']."</td>
    <td>".$data['Cantidad']."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['Costo'], '')."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($precio, '')."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($precio_iva, '')."</td>
    <td>".$data['Orden']."</td>
    <td>".date("d/m/Y",strtotime($data['Fecha']))."</td></tr>";

?>