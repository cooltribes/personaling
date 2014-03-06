<?php 
	foreach($direcciones as $cadauna){
	       			$ciudad = Ciudad::model()->findByPk($cadauna->ciudad_id);
					$provincia = Provincia::model()->findByPk($cadauna->provincia_id);

			       $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'direccionUsada',
						'enableAjaxValidation'=>false,
						'enableClientValidation'=>true,
						'clientOptions'=>array(
							'validateOnSubmit'=>true, 
						),
						'htmlOptions'=>array('class'=>'form-horizontal  direccion'.$cadauna->id ),
					));
						
		            echo $form->hiddenField($cadauna, 'id', array('value'=>$cadauna->id,'type'=>'hidden'));	 	    
		            echo CHtml::hiddenField('tipo','direccionVieja');
		            
					
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
			            'size'=>'normal',
			            'label'=>Yii::t('contentForm','Use this address'),
			        )); 
					     	
					echo"
		                <br/>
		                  <a style='cursor: pointer;' onclick='editar(".$cadauna->id.")' title='editar'>".Yii::t('contentForm','Edit')."</a> <br/>
		                  <a style='cursor: pointer;' onclick='eliminar(".$cadauna->id.")' title='eliminar' data-loading-text='Eliminando...' id='eliminar".$cadauna->id."'>".Yii::t('contentForm','Delete')."</a></p>
		              </div>
		            </div>
		            <div class='border_1'>		            	
						<label class='checkbox'>
						  <input class='billingAddress' type='checkbox' value=''>
						  Utilizar como direccion de facturación.
						</label>
		            </div>
			  		<div class='mensaje".$cadauna->id."' ></div>
		            <hr/>";
			  		
			  		$this->endWidget();

			  	}
			  	?>