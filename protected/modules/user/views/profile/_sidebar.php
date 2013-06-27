<?php $model = User::model()->findByPk(Yii::app()->user->id); ?> 
<?php $profile = $model->profile; ?> 

<div class="card">
      	        <?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); ?>
        <div class="card_content vcard">
          <h4 class="fn"><?php echo $profile->first_name." ".$profile->last_name; ?></h4>
          <p class="muted">Miembro desde: <?php echo Yii::app()->dateFormatter->format("d MMM y",strtotime($model->create_at)); ?></p>
        </div>
      </div>


<div class="navbar">
  <div class="navbar-inner margin_bottom">
    <ul class="nav ">
    
    <li >
						<?php echo CHtml::link('Datos Personales',array('profile/edit'));
						?>
					</li>
					<li>
						<?php echo CHtml::link('Avatar',array('profile/avatar'));
						?>
					</li>
					<li>
						<?php echo CHtml::link('Tu Tipo',array('profile/edittutipo'));
						?>
					</li>
<li><?php echo CHtml::link('Cambiar correo electronico',array('changeemail'),array("title"=>"Cambia tu correo electronico")); ?></li>
              <li><?php echo CHtml::link('Cambiar Contraseña',array('changepassword'),array("title"=>"Cambia tu contraseña")); ?></a></li>
              <li><?php echo CHtml::link('Gestionar correos',array('notificaciones'),array("title"=>"Gestionar correos de Personaling")); ?></li>
              
              <li><?php echo CHtml::link('Informacion publica',array('privacidad'),array("title"=>"Cambia tu Informacion publica")); ?></li>
              <li><?php echo CHtml::link('Eliminar Cuenta',array('delete'),array("title"=>"Eliminar Cuenta")); ?> </li>
                  </ul>
  </div>
</div>
