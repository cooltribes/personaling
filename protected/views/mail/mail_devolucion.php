<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--[if gte mso 9]>
<style _tmplitem="499" >
.article-content ol, .article-content ul {
   margin: 0 0 0 24px;
   padding: 0;
   list-style-position: inside;
}
</style>
<![endif]-->
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
    <tbody>
        <tr>
            <td align="center" bgcolor="#ececec"><table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td class="w640" width="640" height="20"></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#231f20">
                                    <tbody>
                                        <tr>
                                            <td class="w15" width="15"></td>
                                            <td class="w325" width="350" valign="middle" align="left"><table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w325" width="350" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="header-content"><span class="hide" style="color:#FFFFFF; padding-left:5px">
                                                    <preferences lang="es-ES" ><?php echo $subject; ?></preferences>
                                                    </span></div>
                                                <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w325" width="350" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table></td>
                                            <td class="w30" width="30"></td>
                                            <td class="w255" width="255" valign="middle" align="right"><table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w255" width="255" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="middle"><a title="Personaling en facebook" href="https://www.facebook.com/Personaling"><img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_facebook_v2.png"></a></td>
                                                            <td width="3"><a title="Personaling en Pinterest" href="https://twitter.com/personaling"> <img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_twitter_v2.png"></a></td>
                                                            <td valign="middle"><a title="pinterest" href="https://pinterest.com/personaling/"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_pinterest_v2.png"></a></td>
                                                            <td class="w10" width="10"><a title="Personaling en Instagram" href="http://instagram.com/personaling"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_instagram_v2.png"></a></td>
                                                            <td class="w10" width="10"><a title="Personaling en Youtube" href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ"><img width="30" height="30" title="Personaling en youtube" src="http://personaling.com/contenido_estatico/icon_personaling_youtube_v2.png"></a></td>                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w255" width="255" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table></td>
                                            <td class="w15" width="15"></td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td id="header" class="w640" width="640" align="center" bgcolor="#FFFFFF"><div align="center" style="text-align: center"> <a href="http://personaling.com/"> <img id="customHeaderImage" label="Header Image" editable="true" width="600" src="http://personaling.com/contenido_estatico/header_personaling_email_v2.png" class="w640" border="0" align="top" style="display: inline"> </a> </div></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640" height="30" bgcolor="#ffffff"></td>
                        </tr>
                        <tr id="simple-content-row">
                            <td class="w640" width="640" bgcolor="#ffffff"><table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="w30" width="30" style="width:30px"></td>
                                            <td class="w580" width="580"><table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w580" width="580"><!-- CONTENIDO ON -->
                                                                
                                                                <?php
                                                                    $user = User::model()->findByPk($devolucion->orden->user_id);
																	
                                                                   // $pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
                                                                    //echo $orden->pago_id;
                                                                ?>
    
                                                                
                                                                <h3 style="color:#999999;">RESUMEN DE TU SOLICITUD</h3>
                                                                <table width="100%" border="0" cellspacing="3" style="margin-bottom:10px;" cellpadding="5">
    <tr>
        <td style=" background-color:#dff0d8; padding:6px;  color:#468847; margin-bottom:5px"><p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $devolucion->id; ?></p></td>
        
        <td style=" background-color:#dff0d8; color:#468847;"><p> <strong>Orden #</strong>: <?php echo  $devolucion->orden_id; ?></p></td>
    </tr>
    <tr>
    	<td style=" background-color:#dff0d8; color:#468847;"><strong>Monto a devolver</strong>: <?php echo number_format($devolucion->montodevuelto, 2, ',', '.'); ?></td>
    	<td style=" background-color:#dff0d8; color:#468847;"><p> <strong>Fecha de solicitud</strong>: <?php echo  date('d/m/Y', strtotime($devolucion->fecha)); ?></p></td>
    </tr>
</table>
                                                                                                                    
                                                                <hr/>
                                                               <br/>
                                                             <h3 style="color:#999999;">DETALLES DE LA SOLICITUD</h3>
                                                                
                                                                <!-- Look ON -->
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
        	<th style=" background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col"></th>
       
			<th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Marca</th>
			<th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Nombre</th>
			<th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Color</th>
			<th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Talla</th>
			<th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Cant</th>
			<th width="180" style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Motivo</th>


		        
        </tr>
		
		<?php
		

			
			

			$separados=Devolucionhaspreciotallacolor::model()->getxDevolucion($devolucion->id);			
			foreach($separados as $prod){
				$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod['preciotallacolor_id'])); // consigo existencia actual
				$indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
				$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
				$marca=Marca::model()->findByPk($indiv->marca_id);
				$talla=Talla::model()->findByPk($ptc->talla_id);
				$color=Color::model()->findByPk($ptc->color_id);
				
                                $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id,'color_id'=>$color->id),array('order'=>'orden'));
                                $contador=0;
                                $foto = "";
                                $label = $color->valor;
                                //$label = "No hay foto</br>para el color</br> ".$color->valor;
                                 if(!is_null($ptc->imagen))
                                  {
                                     $foto = CHtml::image("http://www.personaling.es".Yii::app()->baseUrl.str_replace(".","_thumb.",$ptc->imagen['url']), "Imagen ", array("width" => "40", "height" => "40"));

                                  }
                                    else {
                                        $foto="No hay foto</br>para el color";
                                    } 
                            
                                
				echo("<tr>");

				echo("<td style='vertical-align: middle; text-align: center'><div>".$foto."<br/>".$label."</div></td>");

               echo("<td style='vertical-align: middle; text-align: center'>".$marca->nombre."</td>");
               echo(   "<td style='vertical-align: middle; text-align: center'>".$indiv->nombre."</td>");
                echo("<td style='vertical-align: middle; text-align: center'>".$color->valor."</td>");                         
               
              
               echo("<td style='vertical-align: middle; text-align: center'>".$talla->valor."</td>");

			   		echo "<td style='vertical-align: middle; text-align: center'>".$prod['cantidad']."</td>"; 
			   
			   echo("<td style='vertical-align: middle; text-align: center'>".$prod['motivo']."</td>");
			  
           
			}
			
	   
      ?>
	    

    	</table>
    	 <hr/><br/><br/>
    	<h3 style="font-weight: normal; text-align: justify; ">
    		<?php echo $comments; ?>
    		
    	</h3>
                                                                
                                                                <!-- CONTENIDO OFF --></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w580" width="580" height="10"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </layout></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640" height="15" bgcolor="#ffffff"></td>
                        </tr>
                        <tr >
                            <td class="w640" width="640"><table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#231f20">
                                    <tbody >
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580 h0" width="360" height="30"></td>
                                            <td class="w0" width="60"></td>
                                            <td class="w0" width="160"></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580" width="360" valign="top">
                                            <span class="hide">
                                                <p id="permission-reminder" align="left" class="footer-content-left" style="color:#FFFFFF"><span>Recibes este correo como respuesta a tu solicitud en Personaling.com </span></p>
                                                </span>
                                                </td>
                                            <td class="hide w0" width="60"></td>
                                            <td class="hide w0" width="160" valign="top"><p id="street-address" align="right" class="footer-content-right" style="color:#FFFFFF"><span><a href="http://personaling.com/" title="personaling" style="color:#FFFFFF">Personaling.com</a></span></p></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580" width="360" valign="top">
                                            <span class="hide">
                                                <p id="permission-reminder" align="left" class="footer-content-left" style="color:#FFFFFF"><span>
                                                	<?php echo Yii::app()->params['clientName']." - ".Yii::app()->params['clientIdentification']; ?></span></p>
                                                </span>
                                                </td>
                                            <td class="hide w0" width="60"></td>
                                        </tr>                                        
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580 h0" width="360" height="15"></td>
                                            <td class="w0" width="60"></td>
                                            <td class="w0" width="160"></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640" height="60"></td>
                        </tr>
                    </tbody>
                </table></td>
        </tr>
    </tbody>
</table>
</body>
</html>
