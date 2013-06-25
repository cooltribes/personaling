<?php

$look = new Look;
$looks_encantan = LookEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$productos_encantan = UserEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$looks_recomendados = $look->match($model);
?>

<div class="container margin_top tu_perfil">
    <div class="page-header">
        <h1>Tu perfil de usuario</h1>
        
    </div>


	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>



    <div class="row">
        <aside class="span3">
            <div>
                <div class="card">
                	<?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); ?>
                	
                    <div class="card_content vcard">
                        <h4 class="fn"><?php echo $profile->first_name." ".$profile->last_name; ?></h4>
                        <p class="muted">Miembro desde: <?php echo Yii::app()->dateFormatter->format("d MMM y",strtotime($model->create_at)); ?></p>
                    </div>
                </div>
                <hr/>
                <h5>Tu actividad</h5>
                <aside class="card">
                    <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looks_encantan; ?></span>
                        <p>Looks que te Encantan</p>
                    </div>
                    <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $productos_encantan; ?></span>
                        <p>Productos que te Encantan</p>
                    </div>
                    <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looks_recomendados->totalItemCount; ?></span>
                        <p>Looks recomendados para ti</p>
                    </div>
                </aside>
                <hr/>
                <h5>Tus Compras</h5>
                <ul class="nav nav-stacked text_align_center" >
                	<?php
      	
			      	$sum = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".Yii::app()->user->id." GROUP BY user_id ")->queryScalar();
			      
			      	if($sum >= 0){
			      	?>
			      		<li><?php echo Yii::app()->numberFormatter->formatDecimal($sum); ?> Bs. de Balance en tu Cuenta</li>
			      	<?php
			      	}
			      	else
			      	{
			      	?>
			      		<li><?php echo Yii::app()->numberFormatter->formatDecimal($sum); ?> Bs. que adeudas.</li>
			      	<?php
			      	}
			      	?>
			        <li>XX Puntos Ganados</li>
			        
			        <?php
			        $total;
				
					$sql = "select count( * ) as total from tbl_orden where user_id=".Yii::app()->user->id." and estado < 5";
					$total = Yii::app()->db->createCommand($sql)->queryScalar();
			      	?>
			      	<li><?php echo $total; ?> Pedidos Activos</li>
			        <li>XX Devoluciones Pendientes</li>
                </ul>
            </div>
        </aside>
        
        <!-- aquí empieza lo de las direcciones -->
        
        <div class="span9 ">

            <section class="bg_color3 margin_bottom_small padding_small box_1">
            <?php	
            
            echo CHtml::link("<i class='icon-plus'></i> Agregar una nueva dirección",
				$this->createUrl('crearDireccion'),
					array(// for htmlOptions
						// 'class'=>'delete-icon',
						'id'=>'agregar',
						'role'=>'button',
						'class'=>'btn pull-right margin_top_xsmall')
				);	
				// <a href="tu_cuenta_usuario_nueva_direccion.php" class="btn pull-right margin_top_xsmall" title="Agregar Dirección">
				// <i class="icon-plus"></i> Guardar una nueva dirección</a>
            ?>	
                  
					<h3 >Direcciones utilizadas anteriormente: </h3>
			<?php
				
				$dirs = Direccion::model()->findAllByAttributes(array('user_id'=>$model->id));
				
				foreach ($dirs as $dir ) {
					
					echo '
                        <div class="well">
                            <p> <strong>'.$dir->nombre.' '.$dir->apellido.'</strong> <br/>
                                <span class="muted small"> C.I. '.$dir->cedula.'</span></p>
                            <p> <strong>Telefono</strong>: '.$dir->telefono.' </p>
                            <p><strong>Dirección:</strong> <br/>
                                '.$dir->dirUno.'. '.$dir->dirDos.'. '.$dir->ciudad.', '.$dir->estado.'. '.$dir->pais.'.
                          	</p>
                            <p>
                            ';
							
							echo CHtml::link("<i class='icon-edit'></i> Editar",
								$this->createUrl('crearDireccion',array('id'=>$dir->id)),
							    array(// for htmlOptions
							     // 'class'=>'delete-icon',
							    'id'=>'link'.$dir->id,
								'role'=>'button',
								'class'=>'btn')
							);	
							
							echo CHtml::link("<i class='icon-trash'></i> Eliminar",
								$this->createUrl('BorrarDireccion',array('id'=>$dir->id)),
							    array(// for htmlOptions
							     // 'class'=>'delete-icon',
							    'id'=>'link'.$dir->id,
								'role'=>'button',
								'class'=>'btn')
							);	
							
							echo '
                            </p>
                        </div> ';
				}
				
			?>

            </section>
        </div>
    </div>
</div>
<!-- /container -->