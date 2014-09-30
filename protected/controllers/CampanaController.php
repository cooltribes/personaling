<?php

class CampanaController extends Controller
{
	 /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */ 
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index', 'create', 'delete', 'edit', 'invite', 'uninvite', 'view', 'getPS', 'inviteAll', 'uninviteAll','getMarca','changeCampaign'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionCreate()
	{
		$campana = new Campana;
		
		if(isset($_POST['Campana'])){
			$campana->attributes = $_POST['Campana'];
			$campana->fecha_creacion = date('Y-m-d H:i:s');
			if(strtotime($campana->recepcion_inicio) <= time()){
				$campana->estado = 2;
			}
			
			if($campana->save()){
				if($_POST['personal_shopper'] == 'todos'){
					$list_ps = User::model()->findAllByAttributes(array('personal_shopper'=>1));
					foreach ($list_ps as $ps) {
						$campana_ps = new CampanaHasPersonalShopper;
						$campana_ps->campana_id = $campana->id;
						$campana_ps->user_id = $ps->id;
						$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
						$campana_ps->save();
					}
					Yii::app()->user->setFlash('success','Campaña guardada con éxito'); 
					$this->redirect(array('index'));
				}else if($_POST['personal_shopper'] == 'seleccionar'){
					Yii::app()->session['campana_id'] = $campana->id;
					$dataProvider=new CActiveDataProvider('User', array(
					    'criteria'=>array(
					            'condition'=>'personal_shopper=1',
					    ),
					));
					$this->render('select_ps', array('campana'=>$campana, 'dataProvider'=>$dataProvider));
					Yii::app()->end();
				}
			}else{
				Yii::app()->user->setFlash('error','No se pudo guardar la campaña');
			}
		}else{
                    
                    if(isset($_POST['buscarNombre'])){
                        $criteria = new CDbCriteria();
                        $criteria->alias = 'User';
                        $criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' .
                                $_POST['buscarNombre'] . '%" OR p.last_name LIKE "%' . $_POST['buscarNombre'] .
                                '%" OR User.email LIKE "%' . $_POST['buscarNombre'] . '%" 
                                OR User.username LIKE "%' . $_POST['buscarNombre'] . '%")';
                        
                        $criteria->addCondition('personal_shopper=1');
                
                        $dataProvider=new CActiveDataProvider('User', array(
                            'criteria'=>$criteria,
                        ));
                        $this->render('select_ps', array('campana'=>$campana, 'dataProvider'=>$dataProvider));
                        Yii::app()->end();
                     
                     }
		
			if(isset($_POST['personal_shopper'])){
				if($_POST['personal_shopper'] == 'todos'){
						$list_ps = User::model()->findAllByAttributes(array('personal_shopper'=>1));
						foreach ($list_ps as $ps) {
							$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$ps->id));
							if(!$campana_ps){
								$campana_ps = new CampanaHasPersonalShopper;
								$campana_ps->campana_id = Yii::app()->session['campana_id'];
								$campana_ps->user_id = $ps->id;
								$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
								$campana_ps->save();
							}
						}
						Yii::app()->user->setFlash('success','Campaña guardada con éxito');
						$this->redirect(array('index'));
				}
			}
		}
		$this->render('create', array('campana'=>$campana));
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionEdit($id)
	{
		$campana = Campana::model()->findByPk($id);
		
		if(isset($_GET['User_page']) || isset($_GET['ajax'])) 
		{
			Yii::app()->session['campana_id'] = $campana->id;
				
			$dataProvider=new CActiveDataProvider('User', array(
				'criteria'=>array(
				'condition'=>'personal_shopper=1', 
			),
			));
					
			$this->render('select_ps', array('campana'=>$campana, 'dataProvider'=>$dataProvider));
			Yii::app()->end();
		}
		
		if(isset($_POST['Campana'])){

                    $campana->attributes = $_POST['Campana'];
			//$campana->fecha_creacion = date('Y-m-d H:i:s');
			
			if(date("Y-m-d H:i:s")<$campana->recepcion_inicio)
				$campana->estado=1;
			else{
				if(date("Y-m-d H:i:s")>$campana->recepcion_inicio&&date("Y-m-d H:i:s")<$campana->recepcion_fin)
					$campana->estado=2;
				else{
					if(date("Y-m-d H:i:s")>$campana->recepcion_fin&&date("Y-m-d H:i:s")<$campana->ventas_inicio)
						$campana->estado=3;
					else{
						if(date("Y-m-d H:i:s")<$campana->ventas_fin&&date("Y-m-d H:i:s")>$campana->ventas_inicio)
							$campana->estado=4;
						else{
							if(date("Y-m-d H:i:s")>$campana->ventas_fin)
								$campana->estado=5;
							}
					}
				}
			}
			
		if($campana->save()){
				if(isset($_POST['personal_shopper'])){
				if($_POST['personal_shopper'] == 'todos'){
					$list_ps = User::model()->findAllByAttributes(array('personal_shopper'=>1));
					foreach ($list_ps as $ps) {
						$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>$id, 'user_id'=>$ps->id));
						if(!$campana_ps){
						$campana_ps = new CampanaHasPersonalShopper;
						$campana_ps->campana_id = $campana->id;
						$campana_ps->user_id = $ps->id;
						$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
						$campana_ps->save();
						}
					}
					Yii::app()->user->setFlash('success','Campaña guardada con éxito');
					$this->redirect(array('index'));
				}else if($_POST['personal_shopper'] == 'seleccionar'){
					Yii::app()->session['campana_id'] = $campana->id;
					$dataProvider=new CActiveDataProvider('User', array(
					    'criteria'=>array(
					            'condition'=>'personal_shopper=1', 
					    ),
					));
					$this->render('select_ps', array('campana'=>$campana, 'dataProvider'=>$dataProvider));
					Yii::app()->end();
				}
				}else{
					Yii::app()->user->setFlash('success','Campaña guardada con éxito'); 
					$this->redirect(array('index'));
				}
			}else{
                          
                            
				Yii::app()->user->setFlash('error','No se pudo guardar la campaña');
			}
		}else{
                                   
                    if(isset($_POST['buscarNombre'])){
                        $criteria = new CDbCriteria();
                        $criteria->alias = 'User';
                        $criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' .
                                $_POST['buscarNombre'] . '%" OR p.last_name LIKE "%' . $_POST['buscarNombre'] .
                                '%" OR User.email LIKE "%' . $_POST['buscarNombre'] . '%" 
                                OR User.username LIKE "%' . $_POST['buscarNombre'] . '%")';
                        
                        $criteria->addCondition('personal_shopper=1');
                
                        $dataProvider=new CActiveDataProvider('User', array(
                            'criteria'=>$criteria,
                        ));
                        $this->render('select_ps', array('campana'=>$campana, 'dataProvider'=>$dataProvider));
                        Yii::app()->end();
                     
                     }
			if(isset($_POST['personal_shopper'])){
				if($_POST['personal_shopper'] == 'todos'){
						$list_ps = User::model()->findAllByAttributes(array('personal_shopper'=>1));
						foreach ($list_ps as $ps) {
							$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$ps->id));
							if(!$campana_ps){
								$campana_ps = new CampanaHasPersonalShopper;
								$campana_ps->campana_id = Yii::app()->session['campana_id'];
								$campana_ps->user_id = $ps->id;
								$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
								$campana_ps->save();
							}
						}
						Yii::app()->user->setFlash('success','Campaña guardada con éxito');
						$this->redirect(array('index'));
				}
			}
		}
		
		$this->render('edit', array('campana'=>$campana));
	}

	public function actionGetPS(){
		$campana = Campana::model()->findByPk($_POST['campana_id']);
		$personal_shoppers = CampanaHasPersonalShopper::model()->findAllByAttributes(array('campana_id'=>$_POST['campana_id']));
		$return = '<h4>Nombre de la campaña: '.$campana->nombre.'</h4>';
		$return .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
				      <tbody>
				        <tr>
				          <th colspan="1" scope="col">Avatar</th>
				          <th colspan="1" scope="col" width="80%">Nombre</th>
				        </tr>';
		//var_dump($personal_shoppers);
		foreach ($personal_shoppers as $ps) {
			$usuario = User::model()->findByPk($ps->user_id);
			$return .= '<tr>
				          <td><img src="'.$usuario->getAvatar().'" width="30" height="30"></td>
				          <td>'.$usuario->profile->first_name.' '.$usuario->profile->last_name.'</td>
				        </tr>';
		}
		
		$return .= '</tbody>
    			</table>';
				
		echo $return;
	}


	public function actionGetMarca(){
		$campana = Campana::model()->findByPk($_POST['campana_id']);
		

		$looks=Array();
		$marcas=Array();
		
		$looks= Look::model()->findAllByAttributes(array('campana_id'=>$campana->id));
	
		$lk;
		
		foreach ($looks as $look) {
				 
			$lk= LookHasProducto::model()->findAllByAttributes(array('look_id'=>$look->id));
			
			foreach ($lk as $lhp) {
				$producto= Producto::model()->findByPk($lhp->producto_id);
			
				$mr= Marca::model()->findByPk($producto->marca_id);	
					
				if(!in_array($mr->id, $marcas)){
					array_push($marcas,$mr->id);
				}
			}
		}
			
		$return= '<h4>Nombre de la campaña: '.$campana->nombre.'</h4>';
		$return .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
				      <tbody>
				        <tr>
				          <th colspan="1" scope="col">Avatar</th>
				          <th colspan="1" scope="col" width="80%">Nombre</th>
				        </tr>';
		
		
		if(!empty($marcas)){
	
		foreach ($marcas as $marcaid) {
			
		$marca= Marca::model()->findByPk($marcaid);	
		$return.= '<tr>
				          <td>'.CHtml::image(Yii::app()->baseUrl.'/images/marca/'.$marca->id.'_thumb.jpg', $marca->nombre).'</td>
				          <td>'.$marca->nombre.'</td>
				        </tr>';
			}
		}
		$return .= '</tbody>
    			</table>';
				
		echo $return;
	}
	


	public function actionIndex()
	{
		$campana = new Campana; 

		if (isset($_POST['nombre']))
		{
			$campana->nombre = $_POST['nombre'];
		}
                $dataProvider = $campana->search();
		
                
                /**********************   Para Filtros   *************************/
            if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;
            
            
           if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['nombre'])){
              $_POST = $_SESSION['todoPost'];
           }            
            
            if(isset($_POST['dropdown_filter'])){  
                                
                $_SESSION['todoPost'] = $_POST;          
                
                //Validar y tomar sólo los filtros válidos
                for($i=0; $i < count($_POST['dropdown_filter']); $i++){
                    if($_POST['dropdown_filter'][$i] && $_POST['dropdown_operator'][$i]
                            && trim($_POST['textfield_value'][$i]) != '' && $_POST['dropdown_relation'][$i]){

                        $filters['fields'][] = $_POST['dropdown_filter'][$i];
                        $filters['ops'][] = $_POST['dropdown_operator'][$i];
                        $filters['vals'][] = $_POST['textfield_value'][$i];
                        $filters['rels'][] = $_POST['dropdown_relation'][$i];                    

                    }
                }     
                //Respuesta ajax
                $response = array();
                
                if (isset($filters['fields'])) {                    
                
                    $dataProvider = $campana->buscarPorFiltros($filters);                    
                    //echo "Total: " . $dataProvider->getItemCount();
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '5') //Filtros para Campanas
                                    ); 
                            
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 5;
                                if ($filter->save()) {
                                    for ($i = 0; $i < count($filters['fields']); $i++) {

                                        $filterDetails[] = new FilterDetail();
                                        $filterDetails[$i]->id_filter = $filter->id_filter;
                                        $filterDetails[$i]->column = $filters['fields'][$i];
                                        $filterDetails[$i]->operator = $filters['ops'][$i];
                                        $filterDetails[$i]->value = $filters['vals'][$i];
                                        $filterDetails[$i]->relation = $filters['rels'][$i];
                                        $filterDetails[$i]->save();
                                    }
                                    
                                    $response['status'] = 'success';
                                    $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';
                                    $response['idFilter'] = $filter->id_filter;                                    
                                    
                                }
                                
                            //si ya existe
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'No se pudo guardar el filtro, el nombre <b>"'.
                                        $filter->name.'"</b> ya existe'; 
                            }

                          /* si esta guardadndo uno existente */
                         }else if(isset($_POST['id'])){
                            
                            $filter = Filter::model()->findByPk($_POST['id']); 

                            if ($filter) {
                                
                                //borrar los existentes
                                foreach ($filter->filterDetails as $detail){
                                    $detail->delete();
                                }
                                
                                //Crear los nuevos
                                for ($i = 0; $i < count($filters['fields']); $i++) {

                                    $filterDetails[] = new FilterDetail();
                                    $filterDetails[$i]->id_filter = $filter->id_filter;
                                    $filterDetails[$i]->column = $filters['fields'][$i];
                                    $filterDetails[$i]->operator = $filters['ops'][$i];
                                    $filterDetails[$i]->value = $filters['vals'][$i];
                                    $filterDetails[$i]->relation = $filters['rels'][$i];
                                    $filterDetails[$i]->save();
                                }

                                $response['status'] = 'success';
                                $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';                                
                            //si NO existe el ID
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'El filtro no existe'; 
                            }
                             
                         }
                        
                         echo CJSON::encode($response); 
                         Yii::app()->end();
                         
                     }//fin si esta guardando

                //si no hay filtros válidos    
                }else if (isset($_POST['save'])){
                    $response['status'] = 'error';
                    $response['message'] = 'No has seleccionado ningún criterio para filtrar'; 
                    echo CJSON::encode($response); 
                    Yii::app()->end();
                }
            }
                
                
                
                if (isset($_POST['nombre'])) {
                    unset($_SESSION["todoPost"]);
                    $campana->nombre = $_POST['nombre'];
                    $dataProvider = $campana->search();
                }
		
		$this->render('index',array(
			'model'=>$campana,
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionInvite(){
		if(isset($_POST['id'])){
			$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$_POST['id']));
			if(!$campana_ps){
				$campana_ps = new CampanaHasPersonalShopper;
				$campana_ps->campana_id = Yii::app()->session['campana_id'];
				$campana_ps->user_id = $_POST['id'];
				$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
				$campana_ps->save();
			}
		}
	}
	
	public function actionInviteAll(){
		//if(isset($_POST['id'])){
		$personal_shoppers = User::model()->findAllByAttributes(array('personal_shopper'=>1));
		foreach ($personal_shoppers as $ps) {
			$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$ps->id));
			if(!$campana_ps){
				$campana_ps = new CampanaHasPersonalShopper;
				$campana_ps->campana_id = Yii::app()->session['campana_id'];
				$campana_ps->user_id = $ps->id;
				$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
				if($campana_ps->save()){
					echo 'saved';
				}else{
					print_r($campana_ps->getErrors());
				}
			}
		}
		//echo 'Campaña: '.Yii::app()->session['campana_id'].' - PS: '.sizeof($personal_shoppers);
		//}
	}

	public function actionUninvite(){
		if(isset($_POST['id'])){
			$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$_POST['id']));
			if($campana_ps){
				$campana_ps->delete();
			}
		}
	}
	
	public function actionUninviteAll(){
		//if(isset($_POST['id'])){
			$campanas_ps = CampanaHasPersonalShopper::model()->findAllByAttributes(array('campana_id'=>Yii::app()->session['campana_id']));
			if(sizeof($campanas_ps) > 0){
				foreach ($campanas_ps as $campana) {
					$campana->delete();
				}
			}
		//}
	}
	
	public function actionView(){
		if(isset($_POST['id'])){
			$campana = Campana::model()->findByPk($_POST['id']);
			$time_recepcion_inicio = strtotime($campana->recepcion_inicio);
			$time_recepcion_fin = strtotime($campana->recepcion_fin);
			$time_ventas_inicio = strtotime($campana->ventas_inicio);
			$time_ventas_fin = strtotime($campana->ventas_fin);
			$campana_ps = CampanaHasPersonalShopper::model()->countByAttributes(array('campana_id'=>$campana->id));
			
			$return = '<div class="modal-header">';
			$return .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
			$return .= '<h3>'.$campana->nombre.'</h3>';
			$return .= '</div>';
			$return .= '<div class="modal-body">';
			$return .= '<p>Resumen de la campaña:</p>';
			$return .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
						  <tr>
						    <th scope="col">Descripción</th>
						    <th scope="col">Detalle</th>
						  </tr>
						  <tr>
						    <td>Recepción de los looks:</td>
						    <td>del ';
			$return .= date('d-m-Y', $time_recepcion_inicio);
			$return .= ' al ';
			$return .= date('d-m-Y', $time_recepcion_fin);
			$return .= '</td>
						  </tr>
						  <tr>
						    <td>Actividad de la campaña:</td>
						    <td>del ';
			$return .= date('d-m-Y', $time_ventas_inicio);
			$return .= ' al ';
			$return .= date('d-m-Y', $time_ventas_fin);
			$return .= '</td>
						  </tr>
						  <tr>
						    <td>Personal shopper invitados:</td>
						    <td>';
			$return .= $campana_ps;
			$return .= '</td>
							  </tr>
							</table>
						  </div>
						  <div class="modal-footer">';
			$return .= CHtml::link('<i class="icon-edit"></i> Editar', $this->createUrl('edit', array('id'=>$campana->id)), array('class'=>'btn'));
			$return .= CHtml::button('Salir al listado de campañas', array('title'=>'Salir', 'class'=>'btn', 'data-dismiss'=>'modal'));
			$return .= '</div></div>';
			echo $return;
		}
	}

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
    
    public function actionChangeCampaign() //accept
    {
        if (isset($_POST['respuesta']))
        {
              $respuesta=$_POST['respuesta'];
             $id=$_POST['id'];

             if($respuesta==1)
             {
                 Campana::model()->updateByPk($id, array('activo'=>'0'));
                Look::model()->updateAll(array('activo'=>0,'campana_id=:campana_id',array('campana_id'=>$id)));
                echo "ok";
             }
             if($respuesta==3)
             {
                 Campana::model()->updateByPk($id, array('activo'=>1));
                Look::model()->updateAll(array('activo'=>1,'campana_id=:campana_id',array('campana_id'=>$id)));
                echo "ok";
             }
            if($respuesta==2 || $respuesta==4)
            {
                echo "nada";
            }
        }
    }
    
    

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}