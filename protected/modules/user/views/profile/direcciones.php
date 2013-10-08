<?php
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta") => array('micuenta'),
	UserModule::t("Tus direcciones"),
);
$look = new Look;
$looks_encantan = LookEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$productos_encantan = UserEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$looks_recomendados = $look->match($model);
?>

<div class="container margin_top tu_perfil">
   

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
           <!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 

        
        <!-- aquí empieza lo de las direcciones -->
        
        <div class="span9 ">
        <h1>Tus direcciones</h1>
        

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
					$ciudad = Ciudad::model()->findByPk($dir->ciudad_id);
					echo '
                        <div class="well">
                            <p> <strong>'.$dir->nombre.' '.$dir->apellido.'</strong> <br/>
                                <span class="muted small"> C.I. '.$dir->cedula.'</span></p>
                            <p> <strong>Telefono</strong>: '.$dir->telefono.' </p>
                            <p><strong>Dirección:</strong> <br/>
                                '.$dir->dirUno.'. '.$dir->dirDos.'. '.$ciudad->nombre.', '.$ciudad->provincia->nombre.'. '.$dir->pais.'.
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