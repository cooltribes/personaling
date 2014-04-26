<?php 
	foreach($direcciones as $cadauna){
	       			$ciudad = Ciudad::model()->findByPk($cadauna->ciudad_id);
					$provincia = Provincia::model()->findByPk($cadauna->provincia_id);
					if(isset($iddireccionNueva)){
						if( $iddireccionNueva == $cadauna->id)
							echo '<div id="scrollNueva" class="padding_top_xsmall padding_right_xsmall padding_left_xsmall alert-success transition_all_6s">';
						else
							echo '<div class="padding_top_xsmall padding_right_xsmall padding_left_xsmall ">';	
					}
					else
						echo '<div class="padding_top_xsmall padding_right_xsmall padding_left_xsmall ">';					
			       $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'direccionUsada',
						'action'=>'direcciones',
						'enableAjaxValidation'=>false,
						'enableClientValidation'=>true,
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
								
						),
						'htmlOptions'=>array('class'=>'form-horizontal  direccion'.$cadauna->id ),
					));
						
		            echo $form->hiddenField($cadauna, 'id', array('value'=>$cadauna->id,'type'=>'hidden'));	 	    
		            echo CHtml::hiddenField('tipo','direccionVieja');
					if(isset($_SESSION['idFacturacion']))
						{	echo CHtml::hiddenField('billAdd',Yii::app()->getSession()->get('idFacturacion'),array('class'=>'hidBill'));
							unset($_SESSION['idFacturacion']);
						}
					else
						echo CHtml::hiddenField('billAdd','0',array('class'=>'hidBill'));
		           
					 
		            echo "
		            <div class='row'>		            
		              <div class='span2'>
		                <p><strong>".$cadauna->nombre." ".$cadauna->apellido."</strong><br/>
		                  <span class='muted small'> ".Yii::t('contentForm','C.I')." ".$cadauna->cedula."</span></p>
		                <p> <strong>	".Yii::t('contentForm','Phone')."</strong>: ".$cadauna->telefono."</p>
		              </div>
		              <div class='span3'>
		                <p><strong>".Yii::t('contentForm','Address').":</strong> <br/>
		                  ".$cadauna->dirUno." </br>
		                  ".$cadauna->dirDos.". 
		                  ".$ciudad->nombre.", ".$provincia->nombre.". </br>
		                  ".$cadauna->pais." </p>
		                      
		              </div>
		              <div class='span2 margin_top_medium'>
		                <p>
					";
					$this->widget('bootstrap.widgets.TbButton', array(
			            'buttonType'=>'submit',
			            'type'=>'danger',
			            'size'=>'small',
			            'label'=>Yii::t('contentForm','Use this shipping address'),
			        )); 
					     	
					echo"
		                <br/>
		                  <a style='cursor: pointer;' onclick='editar(".$cadauna->id.")' title='editar'>".Yii::t('contentForm','Edit')."</a> <br/>
		                  <a style='cursor: pointer;' onclick='eliminar(".$cadauna->id.")' title='eliminar' data-loading-text='Eliminando...' id='eliminar".$cadauna->id."'>".Yii::t('contentForm','Delete')."</a></p>
		              </div>
		            </div>
		            <div class=''>		            	
						<label class='checkbox'>
						  <input  class='billingAddress' type='checkbox' value='".$cadauna->id."'>
						  ".Yii::t('contentForm','Use this as billing address')."
						</label>
		            </div>
			  		<div class='mensaje".$cadauna->id."' ></div>
		            ";
			  		echo '</div><hr/>';
			  		$this->endWidget();

			  	}
			  	?>
			  	