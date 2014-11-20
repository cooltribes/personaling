<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	// public $layout='//layouts/column2';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array( 
                    array('allow', // allow admin user to perform 'admin' and 'delete' actions
                        'actions'=>array('admin','delete','create','update',
                            'view','corporal','estilos','pedidos','carrito',
                            'direcciones','avatar', 'productos', 'looks','toggle_ps',
                            'toggleDestacado', 'toggle_admin','resendvalidationemail',
                            'toggle_banned','contrasena','saldo',
                            'compra','compradir','comprapago','compraconfirm','modal',
                            'credito','editardireccion',
                            'eliminardireccion','comprafin','mensajes','displaymsj',
                            'invitaciones','porcomprar','seguimiento','balance',
                            'reporteCSV','usuariosZoho', 'suscritosNl', 'historial','enviarzoho','saveUrl','editAddress'),                                         
                         
                        'expression' => 'UserModule::isAdmin()',

                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
          
		  	
		    $model = new User('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['User']))
                $model->attributes = $_GET['User'];

            $criteria = new CDbCriteria;
			if(isset($_GET['User_page']))
			{
				Yii::app()->session['sumolo']=$_GET['User_page'];
			}
			else {
				if(isset($_GET['ajax']))
					unset(Yii::app()->session['sumolo']);
			}
				
			if(Yii::app()->session['sumolo']=="")
			{
				$dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->getModule('user')->user_page_size,
                    ),
                ));
			}
			else
			{
				if(Yii::app()->session['sumolo']>=2)
				{
					$dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->getModule('user')->user_page_size,
                       'currentPage'=>Yii::app()->session['sumolo']-1,
                    	),
               		 ));
				}
				
			}
            

            //Modelos para el formulario de crear Usuario
            $modelUser = new User;
            $profile = new Profile;
            $profile->regMode = true;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'newUser-form') {
                echo UActiveForm::validate(array($modelUser, $profile));
                Yii::app()->end();
            }

            if (isset($_POST['User']) && isset($_POST['Profile']) && isset($_POST['tipoUsuario']) && isset($_POST['genero'])) {

                $modelUser->attributes = $_POST['User'];
                $modelUser->username = $modelUser->email;
                $modelUser->password = $this->passGenerator();
                $modelUser->activkey = Yii::app()->controller->module->encrypting(microtime() . $modelUser->password);

                if ($_POST['tipoUsuario'] == 1) { //personalShopper
                    $modelUser->personal_shopper = 1;
                } else if ($_POST['tipoUsuario'] == 2) { //Admin
                    $modelUser->superuser = 1;
                }

                $profile->attributes = $_POST['Profile'];
                $profile->user_id = 0;                
    //            
                $profile->sex = $_POST['genero'];



                if ($modelUser->validate() && $profile->validate()) {
                    
                    $originalPass = $modelUser->password;
                    $modelUser->password = Yii::app()->controller->module->encrypting($modelUser->password);

                    if ($modelUser->save()) {
                        $profile->user_id = $modelUser->id;
                        $profile->save();

                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash('success', UserModule::t("El usuario ha sido creado."));

                        if(Yii::app()->params['zohoActive'] == TRUE){ // Zoho Activo        
                            // save user to zoho
                            $zoho = new Zoho();
                            $zoho->email = $modelUser->email;
                            $zoho->first_name = $profile->first_name;
                            $zoho->last_name = $profile->last_name;
                            $zoho->birthday = $profile->birthday;
                            if($profile->sex == 1)
                                $zoho->sex = 'Mujer';
                            else if($profile->sex == 2)
                                $zoho->sex = 'Hombre';

                            $zoho->admin = 'No';
                            $zoho->ps = 'No';

                            if($modelUser->superuser == 1){
                                $zoho->admin = 'Si';
                            }
                            if($modelUser->personal_shopper == 1){
                                $zoho->ps = 'Si';
                            }
                            $zoho->save_potential();
                        }

                        //Enviar Correo
                        
                        $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $modelUser->activkey, "email" => $modelUser->email));

                        $message = new YiiMailMessage;
                        //Opciones de Mandrill
                        $message->activarPlantillaMandrill();
                        $subject = 'Registro Personaling';
                        $body = Yii::t('contentForm','Copy de crear usuario desde admin',array(
                            '{code}'=>$originalPass,
                            '{activation_url}'=>$activation_url));
                        $message->subject = $subject;
                        $message->setBody($body, 'text/html');
                        $message->addTo($modelUser->email);
                        Yii::app()->mail->send($message);
                        
//                        $message->view = "mail_template";
//                        $params = array('subject' => $subject, 'body' => $body);
//                        $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');

                        $modelUser->unsetAttributes();
                        $profile->unsetAttributes();
                        $profile->day = $profile->month = $profile->month = '';
                    }
                    //$this->redirect(array('view','id'=>$model->id));
                } else {
                    $profile->validate();
                    $profile->birthday = '';
                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('error', UserModule::t("Ha habido un error creando el usuario."));

    //             echo "<pre>";
    //            print_r($modelUser->getErrors());
    //            echo "</pre><br>";
    //            echo "<pre>";
    //            print_r($profile->getErrors());
    //            echo "</pre><br>";
    //            exit();
                }
            }
            
            
            
             /*********************** Para los filtros *********************/
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
                    
                    $dataProvider = $model->buscarPorFiltros($filters);                    
                    
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '3') 
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 3;
                                
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
            
            if (isset($_GET['nombre'])) {
               # echo $_GET['nombre'];
				#break;
				$palabras=explode( ' ',$_GET['nombre']);
                unset($_SESSION["todoPost"]);
                $criteria->alias = 'User';
				if (!isset($palabras[1]))
				{
					$criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' . $_GET['nombre'] . '%" OR p.last_name LIKE "%' . $_GET['nombre'] . '%" OR User.email LIKE "%' . $_GET['nombre'] . '%")';
				}
				else {																					  
					$criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND ((p.first_name LIKE "%' . $palabras[0] . '%" AND p.last_name LIKE "%' . $palabras[1] . '%" ) OR
																 					   (p.first_name LIKE "%' . $palabras[1] . '%" AND p.last_name LIKE "%' . $palabras[0] . '%" ))';
					}
                
                
                $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->getModule('user')->user_page_size,
                    ),
                ));
            }

            	Yii::app()->session['userCriteria']=$dataProvider->criteria;
            
            
            $this->render('index', array(
                'model' => $model,
                'modelUser' => $modelUser,
                'profile' => $profile,
                'dataProvider' => $dataProvider,
       
            ));
        
	}
	
	 public function actionReporteCSV(){
		ini_set('memory_limit','1024M');
		$criteria=Yii::app()->session['userCriteria'];
		$criteria->select = array('t.id');
		$dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria, ));
                
		$pages=new CPagination($dataProvider->totalItemCount);
		$pages->pageSize=$dataProvider->totalItemCount;
		$dataProvider->setPagination($pages);
		
		header( "Content-Type: text/csv;charset=utf-8" );
		header('Content-Disposition: attachment; filename="Usuarios.csv"');
		$fp = fopen('php://output', 'w');
		
		fputcsv($fp,array(' ID','Nombre', 'Apellido', 'Email', 'Ciudad', 'Ordenes Registradas',
		 				'Direcciones Registradas', 'Saldo Disponible', 'Ingresos al portal', 
		 				'Ultimo Ingreso', 'Fecha de Registro', 'Fecha de Nacimiento', 
		 				'Altura', 'Contextura', 'Color de cabello', 
						'Color de ojos','Color de piel','Forma de cuerpo', 'Estilo Diario',
						'Estilo Fiesta', 'Estilo Vacaciones', 'Estilo Deporte', 'Estilo Oficina'
						, 'Género', 'Status', 'Perfil Corporal', 'Test Estilos'),";",'"');
                        
		foreach($dataProvider->getData() as $user){
			$saldo=Yii::app()->numberFormatter->formatDecimal(Profile::model()->getSaldo($user->id));
		 	if ($user->getLastvisit()) 
		 		$lastVisit=date("d/m/Y",$user->getLastvisit()); 
		 	else 
		 		$lastVisit= 'N/D'; 
    		if ($user->getCreatetime())
    			$createdAt=date("d/m/Y",$user->getCreatetime()); 
    		else 
    			$createdAt='N/D'; 	
				
			//El utf8_decode sirve para imprimir correctamente los caracteres especiales com la Ñ y las tildes
		        	
			$vals=array($user->id,utf8_decode($user->profile->first_name), utf8_decode($user->profile->last_name), 
						$user->email, utf8_decode($user->profile->ciudad), $user->ordenCount, $user->direccionCount, 
						$saldo, $user->visit, $lastVisit, $createdAt,date("d/m/Y",strtotime($user->profile->birthday)));
                   
                        $rangos = array(); 
                        
                        $profileFields=$user->profile->getFields();
                        if ($profileFields) {
                            foreach($profileFields as $field) {
                                if($field->id > 4 && $field->id < 16){
                                    $rangos[] =  $field->range.";0==Ninguno";
                                }
                                if($field->id == 4){
                                    $rangosSex = $field->range;
                                }
                                
                            }
                        }
		        	array_push($vals,utf8_decode(Profile::range($rangos[0],$user->profile->altura)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[1],$user->profile->contextura)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[2],$user->profile->pelo)));
                 	array_push($vals,utf8_decode(Profile::range($rangos[3],$user->profile->ojos)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[10],$user->profile->piel)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[4],$user->profile->tipo_cuerpo)));
                 	array_push($vals,utf8_decode(Profile::range($rangos[5],$user->profile->coctel)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[6],$user->profile->fiesta)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[7],$user->profile->playa)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[8],$user->profile->sport)));
                   	array_push($vals,utf8_decode(Profile::range($rangos[9],$user->profile->trabajo)));
                   	array_push($vals,utf8_decode(Profile::range($rangosSex,$user->profile->sex)));
					array_push($vals,utf8_decode($user->getStatus($user->status)));
					array_push($vals,utf8_decode($user->profile->getCompletedProfile($user->id,false)));
                   	array_push($vals,utf8_decode($user->profile->getStyleTest($user->id,false)));                    
		    	 	fputcsv($fp,$vals,";",'"');
		} 
		
		fclose($fp); 
		ini_set('memory_limit','128M'); 
		Yii::app()->end(); 
	 }
	
	public function actionReporteXLS(){
		ini_set('memory_limit','256M'); 

		$criteria=Yii::app()->session['userCriteria'];
		$criteria->select = array('t.id');
		$dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    
                ));
                
		$pages=new CPagination($dataProvider->totalItemCount);
		$pages->pageSize=$dataProvider->totalItemCount;
		$dataProvider->setPagination($pages);
		
		//print_r($pages);
		
		$title = array(
		    'font' => array(
		     
		        'size' => 14,
		        'bold' => true,
		        'color' => array(
		            'rgb' => '000000'
		        ),
	    ));
		Yii::import('ext.phpexcel.XPHPExcel');    
	
		$objPHPExcel = XPHPExcel::createPHPExcel();
	
		$objPHPExcel->getProperties()->setCreator("Personaling.com")
		                         ->setLastModifiedBy("Personaling.com")
		                         ->setTitle("Reporte-Usuarios")
		                         ->setSubject("Reporte de Usuarios")
		                         ->setDescription("Reporte de Usuarios")
		                         ->setKeywords("personaling")
		                         ->setCategory("personaling");
		$objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue('A1', 'ID')
                                        ->setCellValue('B1', 'Nombre')
                                        ->setCellValue('C1', 'Apellido')
                                        ->setCellValue('D1', 'Email')
                                        ->setCellValue('E1', 'Ciudad')
                                        ->setCellValue('F1', 'Ordenes Registradas')
                                        ->setCellValue('G1', 'Direcciones Registradas')
                                        ->setCellValue('H1', 'Saldo Disponible')
                                        ->setCellValue('I1', 'Ingresos al portal')
                                        ->setCellValue('J1', 'Ultimo Ingreso')
                                        ->setCellValue('K1', 'Fecha de Registro');
                
                $objeto = $objPHPExcel->setActiveSheetIndex(0);
                $objeto->setCellValue('L1', 'Altura')
                        ->setCellValue('M1', 'Contextura')
                        ->setCellValue('N1', 'Color de cabello')
                        ->setCellValue('O1', 'Color de ojos')
                        ->setCellValue('P1', 'Color de piel')
                        ->setCellValue('Q1', 'Forma de cuerpo')
                        ->setCellValue('R1', 'Estilo Diario')
                        ->setCellValue('S1', 'Estilo Fiesta')
                        ->setCellValue('T1', 'Estilo Vacaciones')
                        ->setCellValue('U1', 'Estilo Deporte')
                        ->setCellValue('V1', 'Estilo Oficina')
                        ->setCellValue('W1', 'Género')
						->setCellValue('X1', 'Status')
						->setCellValue('Y1', 'Perfil Corporal')
                        ->setCellValue('Z1', 'Test Estilos')
                        ;
                
                
                
		foreach(range('A','Z') as $columnID) {
    		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        	->setAutoSize(true);
		}  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($title);
                        
			$objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('Q1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('S1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('T1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('U1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('V1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('W1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('X1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('Y1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('Z1')->applyFromArray($title);
                        
		
		$fila=2;
		foreach($dataProvider->getData() as $data){
			$user=User::model()->findByPk($data->id);
			$saldo=Yii::app()->numberFormatter->formatDecimal(Profile::model()->getSaldo($data->id));
		 	if ($user->getLastvisit()) 
		 		$lastVisit=date("d/m/Y",$user->getLastvisit()); 
		 	else 
		 		$lastVisit= 'N/D'; 
    		if ($user->getCreatetime())
    			$createdAt=date("d/m/Y",$user->getCreatetime()); 
    		else 
    			$createdAt='N/D'; 
			
		
			
			$objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue('A'.$fila , $data->id) 
                                        ->setCellValue('B'.$fila , $user->profile->first_name) 
                                        ->setCellValue('C'.$fila , $user->profile->last_name) 
                                        ->setCellValue('D'.$fila , $user->email)
                                        ->setCellValue('E'.$fila , $user->profile->ciudad)
                                        ->setCellValue('F'.$fila , $user->ordenCount) 
                                        ->setCellValue('G'.$fila , $user->direccionCount) 
                                        ->setCellValue('H'.$fila , $saldo) 
                                        ->setCellValue('I'.$fila , $user->visit)							
                                        ->setCellValue('J'.$fila , $lastVisit)
                                        ->setCellValue('K'.$fila , $createdAt);
                        
                        $objeto = $objPHPExcel->setActiveSheetIndex(0);
//                        $columnID = "L";
                        $rangos = array();
                        
                        $profileFields=$user->profile->getFields();
                        if ($profileFields) {
                            foreach($profileFields as $field) {
                                if($field->id > 4 && $field->id < 16){
                                    $rangos[] =  $field->range.";0==Ninguno";
                                }
                                if($field->id == 4){
                                    $rangosSex = $field->range;
                                }
                                
                            }
                        }
//                        
//                        
//                        $idProfile = 5;
//                        foreach(range('L','U') as $columnID) {
//                            $field = ProfileField::model()->findByPk($idProfile);                            
//                        }
		
                       $objeto     
                    ->setCellValue('L'.$fila , Profile::range($rangos[0],$user->profile->altura))
                    ->setCellValue('M'.$fila , Profile::range($rangos[1],$user->profile->contextura))
                    ->setCellValue('N'.$fila , Profile::range($rangos[2],$user->profile->pelo))
                    ->setCellValue('O'.$fila , Profile::range($rangos[3],$user->profile->ojos))
                    ->setCellValue('P'.$fila , Profile::range($rangos[10],$user->profile->piel))
                    ->setCellValue('Q'.$fila , Profile::range($rangos[4],$user->profile->tipo_cuerpo))
                    ->setCellValue('R'.$fila , Profile::range($rangos[5],$user->profile->coctel))
                    ->setCellValue('S'.$fila , Profile::range($rangos[6],$user->profile->fiesta))
                    ->setCellValue('T'.$fila , Profile::range($rangos[7],$user->profile->playa))
                    ->setCellValue('U'.$fila , Profile::range($rangos[8],$user->profile->sport))
                    ->setCellValue('V'.$fila , Profile::range($rangos[9],$user->profile->trabajo))
                    ->setCellValue('W'.$fila , Profile::range($rangosSex,$user->profile->sex))
					->setCellValue('X'.$fila , $user->getStatus($user->status))
					->setCellValue('Y'.$fila , $user->profile->getCompletedProfile($user->id,false))
                    ->setCellValue('Z'.$fila , $user->profile->getStyleTest($user->id,false))
                    ;
                    $fila++;
	
		}
		$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="ReporteUsuarios.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
		 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
		 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			ini_set('memory_limit','128M'); 
			Yii::app()->end();
	}
	
	/*public function actionUsuariosZoho(){
        ini_set('memory_limit','2048M'); 

        $criteria=Yii::app()->session['userCriteria'];
        $criteria->select = array('t.id');
        //$criteria->limit = '10';
        $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    
                ));
                
        $pages=new CPagination($dataProvider->totalItemCount);
        $pages->pageSize=$dataProvider->totalItemCount;
        $dataProvider->setPagination($pages);
        
        //print_r($pages);
        
        $title = array(
            'font' => array(
             
                'size' => 14,
                'bold' => true,
                'color' => array(
                    'rgb' => '000000'
                ),
        ));
        Yii::import('ext.phpexcel.XPHPExcel');    
    
        $objPHPExcel = XPHPExcel::createPHPExcel();
    
        $objPHPExcel->getProperties()->setCreator("Personaling.com")
                                 ->setLastModifiedBy("Personaling.com")
                                 ->setTitle("Reporte-Usuarios")
                                 ->setSubject("Reporte de Usuarios")
                                 ->setDescription("Reporte de Usuarios")
                                 ->setKeywords("personaling")
                                 ->setCategory("personaling");
        $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue('A1', 'Email')
                                        ->setCellValue('B1', 'Nombre')
                                        ->setCellValue('C1', 'Apellido')
                                        ->setCellValue('D1', 'Fecha de nacimiento')
                                        ->setCellValue('E1', 'Descripción')
                                        ->setCellValue('F1', 'Sitio web')
                                        ->setCellValue('G1', 'Móvil')
                                        ->setCellValue('H1', 'Teléfono')
                                        ->setCellValue('I1', 'Facebook')
                                        ->setCellValue('J1', 'Twitter')
                                        ->setCellValue('K1', 'Pinterest');
                
                $objeto = $objPHPExcel->setActiveSheetIndex(0);
                $objeto->setCellValue('L1', 'Altura')
                        ->setCellValue('M1', 'Contextura')
                        ->setCellValue('N1', 'Color de cabello')
                        ->setCellValue('O1', 'Color de ojos')
                        ->setCellValue('P1', 'Color de piel')
                        ->setCellValue('Q1', 'Forma de cuerpo')
                        ->setCellValue('R1', 'Estilo Diario')
                        ->setCellValue('S1', 'Estilo Fiesta')
                        ->setCellValue('T1', 'Estilo Vacaciones')
                        ->setCellValue('U1', 'Estilo Deporte')
                        ->setCellValue('V1', 'Estilo Oficina')
                        ->setCellValue('W1', 'Género')
                        ->setCellValue('X1', 'Status')
                        ->setCellValue('Y1', 'Administrador')
                        ->setCellValue('Z1', 'Personal Shopper')
                        ->setCellValue('AA1', 'Calle')
                        ->setCellValue('AB1', 'Ciudad')
                        ->setCellValue('AC1', 'Estado')
                        ->setCellValue('AD1', 'Código Postal')
                        ->setCellValue('AE1', 'País')
                        ;
                
                
                
        foreach(range('A','Z') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
        }  
            /*$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($title);
                        
            $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('Q1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('S1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('T1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('U1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('V1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('W1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('X1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('Y1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('Z1')->applyFromArray($title);*/
                        
        
        /*$fila=2;
        foreach($dataProvider->getData() as $data){
            $user=User::model()->findByPk($data->id);
            $saldo=Yii::app()->numberFormatter->formatDecimal(Profile::model()->getSaldo($data->id));
            if ($user->getLastvisit()) 
                $lastVisit=date("d/m/Y",$user->getLastvisit()); 
            else 
                $lastVisit= 'N/D'; 
            if ($user->getCreatetime())
                $createdAt=date("d/m/Y",$user->getCreatetime()); 
            else 
                $createdAt='N/D'; 

            $time = strtotime($user->profile->birthday);

            $admin = 'No';
            $ps = 'No';

            if($user->superuser == 1){
                $admin = 'Si';
            }
            if($user->personal_shopper == 1){
                $ps = 'Si';
            }

            $direccion = Direccion::model()->findByAttributes(array('user_id'=>$user->id));
        
            
            $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue('A'.$fila , $user->email) 
                                        ->setCellValue('B'.$fila , $user->profile->first_name) 
                                        ->setCellValue('C'.$fila , $user->profile->last_name) 
                                        ->setCellValue('D'.$fila , date('d/m/Y', $time))
                                        ->setCellValue('E'.$fila , $user->profile->bio)
                                        ->setCellValue('F'.$fila , $user->profile->url) 
                                        ->setCellValue('G'.$fila , $user->profile->tlf_celular) 
                                        ->setCellValue('H'.$fila , $user->profile->tlf_casa) 
                                        ->setCellValue('I'.$fila , $user->profile->facebook)                            
                                        ->setCellValue('J'.$fila , $user->profile->twitter)
                                        ->setCellValue('K'.$fila , $user->profile->pinterest);
                        
                        $objeto = $objPHPExcel->setActiveSheetIndex(0);
//                        $columnID = "L";
                        $rangos = array();
                        
                        $profileFields=$user->profile->getFields();
                        if ($profileFields) {
                            foreach($profileFields as $field) {
                                if($field->id > 4 && $field->id < 16){
                                    $rangos[] =  $field->range.";0==Ninguno";
                                }
                                if($field->id == 4){
                                    $rangosSex = $field->range;
                                }
                                
                            }
                        }
//                        
//                        
//                        $idProfile = 5;
//                        foreach(range('L','U') as $columnID) {
//                            $field = ProfileField::model()->findByPk($idProfile);                            
//                        }
        
                       $objeto     
                    ->setCellValue('L'.$fila , Profile::range($rangos[0],$user->profile->altura))
                    ->setCellValue('M'.$fila , Profile::range($rangos[1],$user->profile->contextura))
                    ->setCellValue('N'.$fila , Profile::range($rangos[2],$user->profile->pelo))
                    ->setCellValue('O'.$fila , Profile::range($rangos[3],$user->profile->ojos))
                    ->setCellValue('P'.$fila , Profile::range($rangos[10],$user->profile->piel))
                    ->setCellValue('Q'.$fila , Profile::range($rangos[4],$user->profile->tipo_cuerpo))
                    ->setCellValue('R'.$fila , Profile::range($rangos[5],$user->profile->coctel))
                    ->setCellValue('S'.$fila , Profile::range($rangos[6],$user->profile->fiesta))
                    ->setCellValue('T'.$fila , Profile::range($rangos[7],$user->profile->playa))
                    ->setCellValue('U'.$fila , Profile::range($rangos[8],$user->profile->sport))
                    ->setCellValue('V'.$fila , Profile::range($rangos[9],$user->profile->trabajo))
                    ->setCellValue('W'.$fila , Profile::range($rangosSex,$user->profile->sex))
                    ->setCellValue('X'.$fila , $user->getStatus($user->status))
                    ->setCellValue('Y'.$fila , $admin)
                    ->setCellValue('Z'.$fila , $ps)
                    ;

                    if($direccion){
                        $objeto     
                        ->setCellValue('AA'.$fila, $direccion->dirUno)
                        ->setCellValue('AB'.$fila, $direccion->ciudad->nombre)
                        ->setCellValue('AC'.$fila, $direccion->provincia->nombre)
                        ->setCellValue('AD'.$fila, $direccion->codigopostal->codigo)
                        ->setCellValue('AE'.$fila, $direccion->pais)
                        ;
                    }

                    $fila++;
    
        }
        $objPHPExcel->setActiveSheetIndex(0);

            // Redirect output to a clientâ€™s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="ReporteUsuarios.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
         
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
         
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            ini_set('memory_limit','128M'); 
            Yii::app()->end();
        
    }*/

    public function actionUsuariosZoho(){

        $criteria=Yii::app()->session['userCriteria'];
        $criteria->select = array('t.id');
        //$criteria->limit = '10';
        $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
                
        $success = 0;
        $error = 0;
        $message = '';
		//echo "entro";
       // var_dump($dataProvider->getData());
        //Yii::app()->end();

		$acumulador = 1;
		$sumatoria = 1; // Usuarios hasta el momento
		$cont = 1; // Contador para el ciclo
		$xml = ""; // variable en string del xml
		$ids = array(); // arreglo para comparar
					
		$usuariosTotal = sizeof($dataProvider->getData());

		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Leads>';
		
        foreach($dataProvider->getData() as $data){
			if($cont >= 100) { 
				$xml .= '</Leads>';
					
				$url ="https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
				$query="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&newFormat=1&duplicateCheck=2&version=4&xmlData=".$xml;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.
						
				//Execute cUrl session
				$response = curl_exec($ch); 
				curl_close($ch);
						
				$datos = simplexml_load_string($response);
				$posicion=0;
						
				$total = sizeof($ids);
				
				for($x=1; $x<=$total; $x++){ 
					if(isset($datos->result[0]->row[$posicion])){	
						$number = $datos->result[0]->row[$posicion]->attributes()->no[0]; 
						
							foreach($ids as $data){
								if($number == $data['row']){
									$pos = (int)$data['row'];
									$user=User::model()->findByPk($data["user"]);
																			
									if(isset($datos->result[0]->row[$posicion]->success->details->FL[0])){
										$user->zoho_id = $datos->result[0]->row[$posicion]->success->details->FL[0];
										$user->tipo_zoho = 0;
 										//$user->save();
										
										if($user->save())
	                						$success++;
											
									//	echo "El row #".$data['row']." de ptc ".$precioTalla->id." corresponde al id de zoho: ".$datos->result[0]->row[$posicion]->success->details->FL[0].", ".$x."<br>";
									}
										
								} 
									
							}
					}  
						
					$posicion++;
				}// for
					
				//echo "fin de ciclo"; 
				$acumulador += $success;
						
				/* reiniciando todos los valores */
				$xml = ""; 
				$cont = 1;	
				$posicion=0;
						
				unset($ids);
						
				$ids = array();
						
				$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
				$xml .= '<Leads>';			 
			} // mayor que 100
			
			if($cont < 100)
			{
				//var_dump($data['id']); 
				//Yii::app()->end();
				if(isset($data['id']))
					$user=User::model()->findByPk($data['id']);
				else if(isset($data->id))
					$user=User::model()->findByPk($data->id);
				
				/*Datos para el arreglo a comparar */
					
				$add = array();
				$add = array("row" => $cont, "user" => $user->id);
				array_push($ids,$add);
						
				$time = strtotime($user->profile->birthday);
	
	            $admin = 'No';
	            $ps = 'No';
	            $no_suscrito = "";
	            $interno = 'Externo';
	
	            if($user->superuser == 1){
	                $admin = 'Si';
	            }
	            if($user->personal_shopper == 1){
	                $ps = 'Si';
	            }
	            if($user->suscrito_nl == 1){
	                $no_suscrito = "TRUE";
	            }
	            if($user->interno == 1){
	                $interno = 'Interno';
	            }
	
	            $direccion = Direccion::model()->findByAttributes(array('user_id'=>$user->id));
	
	            $rangos = array();
	            
	            $profileFields=$user->profile->getFields();
	            if ($profileFields) {
	                foreach($profileFields as $field) {
	                    if($field->id > 4 && $field->id < 16){
	                        $rangos[] =  $field->range.";0==Ninguno";
	                    }
	                    if($field->id == 4){
	                        $rangosSex = $field->range;
	                    }
	                    
	                }
	            }
				
				$xml .= '<row no="'.$cont.'">';
				$xml .= '<FL val="First Name">'.$user->profile->first_name.'</FL>';
				$xml .= '<FL val="Last Name">'.$user->profile->last_name.'</FL>';
				$xml .= '<FL val="Email">'.$user->email.'</FL>';
				$xml .= '<FL val="Lead Source">Tienda Personaling</FL>';
				$xml .= '<FL val="Fecha de Nacimiento">'.date('d/m/Y', $time).'</FL>';
				$xml .= '<FL val="Sexo">'.Profile::range($rangosSex,$user->profile->sex).'</FL>';
				$xml .= '<FL val="Description">'.$user->profile->bio.'</FL>';
				$xml .= '<FL val="Documento de Identidad">'.$user->profile->cedula.'</FL>';
				$xml .= '<FL val="Phone">'.$user->profile->tlf_casa.'</FL>';
				$xml .= '<FL val="Mobile">'.$user->profile->tlf_celular.'</FL>';
				$xml .= '<FL val="Pinterest">'.$user->profile->pinterest.'</FL>';
				$xml .= '<FL val="Twitter">'.$user->profile->twitter.'</FL>';
				$xml .= '<FL val="Facebook">'.$user->profile->facebook.'</FL>';
				if(isset($user->profile->url)) $xml .= '<FL val="Alias para el Url">'.$user->profile->url.'</FL>';
				if(isset($user->profile->url)) $xml .= '<FL val="Website">'.$user->profile->url.'</FL>';
				$xml .= '<FL val="Perfil de Administrador">'.$admin.'</FL>';
				$xml .= '<FL val="Perfil de Personal Shopper">'.$ps.'</FL>';
				$xml .= '<FL val="Altura">'.Profile::range($rangos[0],$user->profile->altura).'</FL>';
				$xml .= '<FL val="Condición Física">'.Profile::range($rangos[1],$user->profile->contextura).'</FL>';
				$xml .= '<FL val="Color de piel">'.Profile::range($rangos[10],$user->profile->piel).'</FL>';
				$xml .= '<FL val="Color de cabello">'.Profile::range($rangos[2],$user->profile->pelo).'</FL>';
				$xml .= '<FL val="Color de ojos">'.Profile::range($rangos[3],$user->profile->ojos).'</FL>';
				$xml .= '<FL val="Tipo de Cuerpo">'.Profile::range($rangos[4],$user->profile->tipo_cuerpo).'</FL>';
				$xml .= '<FL val="Diario">'.Profile::range($rangos[5],$user->profile->coctel).'</FL>';
				$xml .= '<FL val="Fiesta">'.Profile::range($rangos[6],$user->profile->fiesta).'</FL>';
				$xml .= '<FL val="Vacaciones">'.Profile::range($rangos[7],$user->profile->playa).'</FL>';
				$xml .= '<FL val="Haciendo Deporte">'.Profile::range($rangos[8],$user->profile->sport).'</FL>';
				$xml .= '<FL val="Oficina">'.Profile::range($rangos[9],$user->profile->trabajo).'</FL>';
				if($direccion){
					$xml .= '<FL val="Street">'.$direccion->dirUno.'</FL>';
					$xml .= '<FL val="City">'.$direccion->ciudad->nombre.'</FL>';
					$xml .= '<FL val="State">'.$direccion->provincia->nombre.'</FL>';
					//$xml .= '<FL val="Zip Code">'.$direccion->codigopostal->codigo.'</FL>';
					$xml .= '<FL val="Country">'.$direccion->pais.'</FL>';
					$xml .= '<FL val="Lead Status">'.$user->getStatus($user->status).'</FL>';
				}
				$xml .= '<FL val="Email Opt-out">'.$no_suscrito.'</FL>';
				$xml .= '<FL val="Tipo">'.$interno.'</FL>';
				$xml .= '</row>';
						
				$cont++;
				/*
	            $zoho = new Zoho();
	            $zoho->email = $user->email;
	            $zoho->first_name = $user->profile->first_name;
	            $zoho->last_name = $user->profile->last_name;
	            $zoho->birthday = date('d/m/Y', $time);
	            $zoho->sex = Profile::range($rangosSex,$user->profile->sex);
	            $zoho->bio = $user->profile->bio;
	            $zoho->dni = $user->profile->cedula;
	            $zoho->tlf_casa = $user->profile->tlf_casa;
	            $zoho->tlf_celular = $user->profile->tlf_celular;
	            $zoho->pinterest = $user->profile->pinterest;
	            $zoho->twitter = $user->profile->twitter;
	            $zoho->facebook = $user->profile->facebook;
	            $zoho->url = $user->profile->url;
	            $zoho->admin = $admin;
	            $zoho->ps = $ps;
	            $zoho->no_suscrito = $no_suscrito;
	            $zoho->tipo = $interno;
	            $zoho->altura = Profile::range($rangos[0],$user->profile->altura);
	            $zoho->condicion_fisica = Profile::range($rangos[1],$user->profile->contextura);
	            $zoho->color_piel = Profile::range($rangos[10],$user->profile->piel);
	            $zoho->color_cabello = Profile::range($rangos[2],$user->profile->pelo);
	            $zoho->color_ojos = Profile::range($rangos[3],$user->profile->ojos);
	            $zoho->tipo_cuerpo = Profile::range($rangos[4],$user->profile->tipo_cuerpo);
	            $zoho->diario = Profile::range($rangos[5],$user->profile->coctel);
	            $zoho->fiesta = Profile::range($rangos[6],$user->profile->fiesta);
	            $zoho->vacaciones = Profile::range($rangos[7],$user->profile->playa);
	            $zoho->deporte = Profile::range($rangos[8],$user->profile->sport);
	            $zoho->oficina = Profile::range($rangos[9],$user->profile->trabajo);
	            $zoho->status = $user->getStatus($user->status);
	            if($direccion){
	                $zoho->calle = $direccion->dirUno;
	                $zoho->ciudad = $direccion->ciudad->nombre;
	                $zoho->estado = $direccion->provincia->nombre;
	                $zoho->codigo_postal = $direccion->codigopostal->codigo;
	                $zoho->pais = $direccion->pais;
	            }
	
	            $result = $zoho->save_potential();
	
	            $xml = simplexml_load_string($result);
	            //var_dump($xml);
	            $id = (int)$xml->result[0]->recorddetail->FL[0];
	
	            $user->zoho_id = $id;
	            if($user->save()){
	                $success++;
	            }else{
	                $error++;
	                /*foreach ($user->getErrors() as $key => $value) {
	                    foreach ($value as $k => $v) {
	                        $message .= 'Error: '.$v.'</br>';
	                    }
	                }*/
			} // cont 100
    	
    		if($usuariosTotal == $sumatoria){
				$success = $this->actionEnviarZoho($xml, $ids);
				$acumulador += $success;
			}
			else
				$sumatoria++;
    	
    	
        } // foreach 

        $message .= $acumulador.' usuarios exportados';
        if($error > 0){
            $message .= '</br>'.$error.' usuarios NO exportados';
        }

        Yii::app()->user->updateSession();
        Yii::app()->user->setFlash('success',$message);
        $this->redirect(array('/user/admin'));
        
    }

	public function actionEnviarZoho($xml,$ids){
			$success=0;
			$xml .= '</Leads>';
					
				$url ="https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
				$query="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&newFormat=1&duplicateCheck=2&version=4&xmlData=".$xml; 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.
						
				//Execute cUrl session
				$response = curl_exec($ch); 
				curl_close($ch);
				
			//	var_dump($response);
			//	Yii::app()->end(); 
				
				$datos = simplexml_load_string($response);
				$posicion=0;
						
				$total = sizeof($ids);
				
				for($x=1; $x<=$total; $x++){ 
					if(isset($datos->result[0]->row[$posicion])){	
						$number = $datos->result[0]->row[$posicion]->attributes()->no[0]; 
						
							foreach($ids as $data){
								if($number == $data['row']){
									$pos = (int)$data['row'];
									$user=User::model()->findByPk($data["user"]);
																			
									if(isset($datos->result[0]->row[$posicion]->success->details->FL[0])){
										$user->zoho_id = $datos->result[0]->row[$posicion]->success->details->FL[0];
										$user->tipo_zoho = 0;
 										
 										if($user->save())
											$success++;
											
									//	echo "El row #".$data['row']." de ptc ".$precioTalla->id." corresponde al id de zoho: ".$datos->result[0]->row[$posicion]->success->details->FL[0].", ".$x."<br>";
									}
										
								}
									
							}
					}  
						
					$posicion++;
				}// for
					
				/* reiniciando todos los valores */
				$xml = ""; 	
			return $success;	 
		}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionToggle_admin($id){
		$model = User::model()->findByPk($id);
		$model->superuser = 1-$model->superuser; // hacer el toggle
		if ($model->save()){
		echo CJSON::encode(array(
	            'status'=>'success',
	            'admin'=>$model->superuser,
	     ));	
	     }else{
	     	Yii::trace('AdminController:100 Error toggle:'.print_r($model->getErrors(),true), 'registro');
			echo CJSON::encode(array(
	            'status'=>'error',
	            'admin'=>$model->superuser,
	     ));
	     }
	}
	
        /**
         * Poner o quitar a un PS en destacado (campo "ps_destacado")
         * @param type $id id del usuario que es PS
         */
	public function actionToggleDestacado($id){
            $model = User::model()->findByPk($id);
                                
            if($model->personal_shopper == 1){ //si es PS                

               $model->ps_destacado = 1 - $model->ps_destacado; // hacer el toggle               
               $model->fecha_destacado = date("Y-m-d H:i:s");
               
                if ($model->save()){
                    echo CJSON::encode(array(
                        'status'=>'success',
                        'personal_shopper'=>$model->ps_destacado,
                    ));	
                }else{
                   Yii::trace('AdminController:117 Error toggleDestacado:'.print_r($model->getErrors(),true), 'registro');
                           echo CJSON::encode(array(
                       'status'=>'error',
                       'personal_shopper'=>$model->ps_destacado,
                    ));
                }
            
            }
	}
        
        
        public function actionToggle_ps($id){
		$model = User::model()->findByPk($id);
                $apply = true;
                
                if($model->personal_shopper == 2){ //si es aplicante
                    $apply = true;
                    
                    $model->personal_shopper = 1;
                    
                    //Enviar mail
                    $model->activkey = UserModule::encrypting(microtime() . $model->password);
                    $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                    
                    $message = new YiiMailMessage;
                    //Opciones de Mandrill
                    $message->activarPlantillaMandrill();
                    $subject = 'Registro Personaling';
                    $body = '<h2>¡Felicitaciones! Tu aplicación ha sido aceptada.</h2><br/><br/>
                        Nuestro equipo piensa que tienes potencial como Personal Shopper de Personaling.es
                        <br/><br/>
                        ¿Nervios? No por favor, sabemos que tienes madera para esto.<br/>
                        Gracias por querer ser parte de nuestro equipo.<br/><br>
                        Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/><br/>
                        <a href="' . $activation_url.'"> Haz click aquí </a>';
                    $message->subject = $subject;
//                    $message->view = "mail_template";
//                    $params = array('subject' => $subject, 'body' => $body);
//                    $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                    $message->setBody($body, 'text/html');
                    $message->addTo($model->email);
                    Yii::app()->mail->send($message);  
                    $alert="¡Se ha aprobado la solicitud para Personal Shopper!";                  
                    
                }else{
                    
                   $model->personal_shopper = 1-$model->personal_shopper; // hacer el toggle 
                   $alert="El usuario ya no es Personal Shopper";  
                }
		
		
		$time=date("d-m-Y H:i:s");

		if($model->admin_ps=="")
		{
			$model->admin_ps=Yii::app()->user->id."/A-";
			$model->fecha_ps=$time."*";
		}
		else
		{
			$porciones = explode("-", $model->admin_ps);
			$num=count($porciones)-2;
			$value=$porciones[$num];
			$letter="";
			$ultima= explode("/", $value);		
			if($ultima[1]=="A")
			{
				$letter="Q";	
			}
			else 
			{
				$letter="A";	
			}
			$model->fecha_ps=$model->fecha_ps."".$time."*";
			$model->admin_ps=$model->admin_ps."".Yii::app()->user->id."/".$letter."-";
		}
		
		if ($model->save()){
			
            if(Yii::app()->params['zohoActive'] == TRUE){ // Si Zoho Activo
			/* Creando el caso */
				$ps = 'Si';
				
				$zoho = new Zoho();
				$zoho->email = $model->email;
				$zoho->ps = $ps;
				
				$result = $zoho->save_potential();
									
				$zohoCase = new ZohoCases;
				$zohoCase->Subject = "Aplicación PS - ".$model->email;
				$zohoCase->internal = "Aprobado";
				$zohoCase->Comment = "Aprobado por administrador";
				$zohoCase->Solution = "Aprobado por administrador";
				$zohoCase->Status = "Closed"; 
									
				$respuesta = $zohoCase->save_potential(); 
			} 

		echo CJSON::encode(array(
	            'status'=>'success',
	            'personal_shopper'=>$model->personal_shopper,
	            'alert'=>$alert,
                    'apply' => $apply,
	     ));	
	     }else{
	     	Yii::trace('AdminController:117 Error toggle:'.print_r($model->getErrors(),true), 'registro');
			echo CJSON::encode(array(
	            'status'=>'error',
	            'personal_shopper'=>$model->personal_shopper,
	     ));
	     }
	}
        
       /**
        * Bloquear al usuario, queda en estado STATUS_BANNED
        * @param int $id id del usuario
        * 
        */ 
       public function actionToggle_banned($id) {
            $model = User::model()->findByPk($id);
            $model->status = -($model->status);

            if ($model->save()) {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'user_status' => User::getStatus($model->status),
                ));
            } else {
                Yii::trace('AdminController:118 Error Toggle_banned:' . print_r($model->getErrors(), true), 'registro');
                echo CJSON::encode(array(
                    'status' => 'error',
                    'error' => $model->getErrors(),
                ));
            }
           
        }
        
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	public function actionEstilos()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$profile->profile_type = 2;
        if(isset($_POST['Profile']))
		{
			//$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($profile->validate()) {
				
				
				$profile->save();

                // update potential at zoho
                $zoho = new Zoho();
                $zoho->email = $model->email;

                $rangos = array();
                
                $profileFields=$profile->getFields();
                if ($profileFields) {
                    foreach($profileFields as $field) {
                        if($field->id > 4 && $field->id < 16){
                            $rangos[] =  $field->range.";0==Ninguno";
                        }
                        if($field->id == 4){
                            $rangosSex = $field->range;
                        }
                        
                    }
                }
                //var_dump($rangos);
                if(Yii::app()->params['zohoActive'] == TRUE){ // Zoho Activo    
                    $zoho->diario = Profile::range($rangos[0],$profile->coctel);
                    $zoho->fiesta = Profile::range($rangos[1],$profile->fiesta);
                    $zoho->vacaciones = Profile::range($rangos[2],$profile->playa);
                    $zoho->deporte = Profile::range($rangos[3],$profile->sport);
                    $zoho->oficina = Profile::range($rangos[4],$profile->trabajo);
                        
                    $result = $zoho->save_potential();
                }

				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			} else $profile->validate();
		}		
		$this->render('estilos',array(
			'model'=>$model,
			'profile'=>$profile,
		));		
	}
	
	public function actionLooks($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $dataProvider = new CActiveDataProvider('LookEncantan', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
		
		$this->render('looks',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPedidos($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $dataProvider = new CActiveDataProvider('Orden', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
		
		$this->render('pedidos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionProductos($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $dataProvider = new CActiveDataProvider('UserEncantan', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
		
		$this->render('productos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionInvitaciones($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $xEmail= new CActiveDataProvider('EmailInvite', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>50,
			),
        ));
		
		$xFB= new CActiveDataProvider('FacebookInvite', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>50,
			),
        ));
		
		$this->render('invitaciones',array(
			'model'=>$model,
			'xEmail'=>$xEmail,
			'xFB'=>$xFB
		));
	}
		
	public function actionDirecciones()
	{
		$model=$this->loadModel();
		$this->render('direcciones',array(
			'model'=>$model,
			
		));
	}
	public function actionAvatar()
	{
		$model=$this->loadModel();
		
		
		if (isset($_POST['valido'])&&isset($_POST['user'])){
				$id = $_POST['user'];
			// make the directory to store the pic:
				if(!is_dir(Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id,0777,true);
	 			}	 
				$images = CUploadedFile::getInstancesByName('filesToUpload');
				 if (isset($images) && count($images) > 0) {
		            foreach ($images as $image => $pic) {
		            	$nombre = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id .'/'. $image;
						$extension = '.'.$pic->extensionName;
		            	$model->avatar_url = $id .'/'. $image .$extension;
		            	if (!$model->save())	
							Yii::trace('username:'.$model->username.' Crear Avatar Error:'.print_r($model->getErrors(),true), 'registro');
						if ($pic->saveAs($nombre ."_orig". $extension)) {
		                	//echo $nombre;
		                	$image = Yii::app()->image->load($nombre ."_orig". $extension);
							$avatar_x = isset($_POST['avatar_x'])?$_POST['avatar_x']:0;
							$avatar_x = $avatar_x*(-1);
							$avatar_y = isset($_POST['avatar_y'])?$_POST['avatar_y']:0;
							$avatar_y = $avatar_y*(-1);
							
							$proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
							$image->resize(270,270,$proporcion)->crop(270, 270,$avatar_y,$avatar_x);
							$image->save($nombre . $extension);
							
							$proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
							$image->resize(30,30,$proporcion)->crop(30, 30,$avatar_y,$avatar_x);
							$image->save($nombre . "_x30". $extension);
							
							$proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
							$image->resize(60,60,$proporcion)->crop(60, 60,$avatar_y,$avatar_x);
							$image->save($nombre . "_x60". $extension);
							
		                	Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));	
							
						}
					}
				 }  	
		} 

		 $this->render('avatar',array(
	    	'model'=>$model,
			//'profile'=>$model->profile,
	    ));
		
		
		
		
		
	}
			
	public function actionCarrito($id)
	{
		$model = $this->loadModel();
		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$model->id));
		if(isset($bolsa))
		{
			$this->render('carrito',array(
				'model'=>$model,
				'bolsa'=>$bolsa,
				'usuario'=>$id,
			));
		}
		else{
			Yii::app()->user->setFlash('error',UserModule::t("Usuario no ha inicializado su carrito"));
		}
	
	}
	
	public function actionCorporal()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$profile->profile_type = 3;
		$this->performAjaxValidation(array($profile));
        
		if(isset($_POST['Profile']))
		{
			//$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($profile->validate()) {
				
				
				if ($profile->save()){
                    // update potential at zoho
                    $zoho = new Zoho();
                    $zoho->email = $model->email;

                    $rangos = array();
                    
                    $profileFields=$profile->getFields();
                    if ($profileFields) {
                        foreach($profileFields as $field) {
                            if($field->id > 4 && $field->id < 16){
                                $rangos[] =  $field->range.";0==Ninguno";
                            }
                            if($field->id == 4){
                                $rangosSex = $field->range;
                            }
                            
                        }
                    }
                    if(Yii::app()->params['zohoActive'] == TRUE){ // Zoho Activo    

                        $zoho->altura = Profile::range($rangos[1],$profile->altura);
                        $zoho->condicion_fisica = Profile::range($rangos[2],$profile->contextura);
                        $zoho->color_piel = Profile::range($rangos[0],$profile->piel);
                        $zoho->color_cabello = Profile::range($rangos[3],$profile->pelo);
                        $zoho->color_ojos = Profile::range($rangos[4],$profile->ojos);
                        $zoho->tipo_cuerpo = Profile::range($rangos[5],$profile->tipo_cuerpo);
                        
                        $result = $zoho->save_potential();
    				}

                    //$this->redirect(array('view','id'=>$model->id));
    				Yii::app()->user->updateSession();
    				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
				} else {
					Yii::trace('username:'.$model->username.' Error:'.print_r($profile->getErrors(),true), 'registro');
				}
				
			} else{
				//echo CActiveForm::validate($profile);
				 $profile->validate();
				// echo 'RAFA';
				//Yii::app()->end(); 
			}
		}		
		$this->render('corporal',array(
			'model'=>$model,
			'profile'=>$profile,
		));		
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id)
	{
		$model=User::model()->findByPk($id);
		
	
			$profile=$model->profile;

		$profile->profile_type = 1;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
	
			$model->attributes=$_POST['User'];
			
			$profile->attributes=$_POST['Profile'];
			$profile->ciudad=$_POST['Profile']['ciudad'];
		
		
			if($model->validate()&&$profile->validate()) {
				/*$old_password = User::model()->notsafe()->findByPk($model->id);
				 if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}*/ 
				$model->save();
				$model->interno=$_POST['User']['interno'];
	
				$model->save();
				
					
				$profile->save(); 
                if(Yii::app()->params['zohoActive'] == TRUE){ // Zoho Activo    
                    // update potential at zoho
                    $zoho = new Zoho();
                    $zoho->email = $model->email;
                    $zoho->first_name = $profile->first_name;
                    $zoho->last_name = $profile->last_name;
                    $zoho->birthday = $profile->birthday;
                    if($profile->sex == 1)
                        $zoho->sex = 'Mujer';
                    else if($profile->sex == 2)
                        $zoho->sex = 'Hombre';
                    $zoho->bio = $profile->bio;
                    $zoho->dni = $profile->cedula;
                    $zoho->tlf_casa = $profile->tlf_casa;
                    $zoho->tlf_celular = $profile->tlf_celular;
                    $zoho->pinterest = $profile->pinterest;
                    $zoho->twitter = $profile->twitter;
                    $zoho->facebook = $profile->facebook;
                    $zoho->url = $profile->url;
    				
    				if($_POST['User']['interno'] == 1)
    					$zoho->tipo = "Interno";
    				else if($_POST['User']['interno'] == 0)
    					$zoho->tipo = "Externo";
    						
                    $result = $zoho->save_potential();
                }
				
				//$this->redirect(array('view','id'=>$model->id));
				
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			} else $profile->save();
		}
                
                
		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	public function actionReSendValidationEmail($id)
	{
		

			$model = User::model()->notsafe()->findByPk( $id );
			$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
			
			$message            = new YiiMailMessage;
			$message->view = "mail_template";
			$subject = 'Activa tu cuenta en Personaling';
			$body = '<h2>Te damos la bienvenida a Personaling.</h2><br/><br/>Recibes este correo porque se ha registrado tu dirección en Personaling. Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/> <br/>  <a href="'.$activation_url.'">Haz click aquí</a>';			
			$params              = array('subject'=>$subject, 'body'=>$body);
			$message->subject    = $subject;
			$message->setBody($params, 'text/html');                
			$message->addTo($model->email);
			$message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
			Yii::app()->mail->send($message);
			Yii::app()->user->setFlash('success',"El correo electrónico de verificacion ha sido reenviado a <strong>".$model->email."</strong>");
			$this->redirect(array('/user/admin'));
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}                
                
		return $this->_model;
	}
        
   	protected function passGenerator($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $n = strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $n - 1);
            $result .= substr($chars, $index, 1);
        }

        return $result;
    }
	
	public function actionContrasena(){
		$html="";	
		if(isset($_POST['id'])&&!isset($_POST['psw']))
			{	$id=$_POST['id'];
				
				$html='<div class="modal-header">';
		    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		    	$html=$html.'<h3>Cambiar Contraseña</h3>';
		  		$html=$html.'</div>';
		  		$html=$html.'<div class="modal-body">';
				$html=$html. CHtml::PasswordField('psw1','',array('id'=>'psw1','class'=>'span5','placeholder'=>'Escribe la nueva contraseña')).
				CHtml::PasswordField('psw2','',array('id'=>'psw2','class'=>'span5','placeholder'=>'Escribe la nueva contraseña')).
				"<div><a onclick='cambio(".$_POST['id'].")' class='btn btn-danger margin_bottom_medium pull-left'>Guardar Cambio</a></div></div>";
				echo $html;
			}
		if(isset($_POST['psw'])&&isset($_POST['id']))	{
				$user=User::model()->findByPk($_POST['id']);
				$user->password=Yii::app()->controller->module->encrypting($_POST['psw']);
				if($user->save()){
					Yii::app()->user->setFlash('success', UserModule::t("Cambio realizado exitosamente"));				
				}					
				
			
		}
	}

	public function actionSaldo(){
		$html="";	
		if(isset($_POST['id'])&&!isset($_POST['cant']))
			{	$id=$_POST['id'];
				
				$saldo=Profile::model()->getSaldo($id);				
				$html='<div class="modal-header">';
		    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		    	$html=$html.'<h3>Cargar Saldo</h3>';
		  		$html=$html.'</div>';
		  		$html=$html.'<div class="modal-body">';
				$html=$html."<div class='pull-right'><h4>Saldo Actual: ".Yii::app()->numberFormatter->formatDecimal($saldo)."</h4></div>";				
				$html=$html. CHtml::TextField('cant','',array('id'=>'cant','class'=>'span5','placeholder'=>'Escribe la cantidad separando los decimales con coma (,)')).
				"<div class='margin_bottom'><input type='checkbox' id='discount' style='margin:0 0 0 0'> Descontar</div><div><a onclick='saldo(".$_POST['id'].")' class='btn btn-danger margin_bottom_medium pull-left'>Cargar Cantidad</a></div></div>";
	 
				echo $html;
			}
		if(isset($_POST['cant'])&&isset($_POST['id'])&&isset($_POST['desc']))	{
                                
				$balance=new Balance;
				$balance->total=$_POST['cant'];
				if($_POST['desc']){
					$balance->total=$balance->total*(-1);
				}
				$balance->orden_id=0;
				$balance->admin_id = Yii::app()->user->id; //guardar cual admin fue
				$balance->user_id=$_POST['id'];
				$balance->tipo=3;
				$balance->fecha = date("Y-m-d H:m:i");
                                
				if($balance->save()){
					
					Yii::app()->user->setFlash('success', UserModule::t("Carga realizada exitosamente"));				
				}
				else{
					
					Yii::app()->user->setFlash('error', UserModule::t("No se pudo realizar carga"));
				}                               
                                
							
		}

	}
	
	public function actionCompra($id)
	{
            if(isset($_POST['ptcs']))
            {
                if($_POST['ptcs']!='nothing'){ //Selecciono productos
                    
                    Yii::app()->session['ptcs']=$_POST['ptcs'];
                    Yii::app()->session['vals']=$_POST['vals'];                

                    $bolsa = Bolsa::model()->findByAttributes(array(
                        'user_id'=>$id,
                        'admin'=> 1,
                            ));

                    if(!isset($bolsa)) // si no tiene aun un carrito asociado 
                    {
                        $bolsa = new Bolsa;
                        $bolsa->user_id = $id;
                        $bolsa->admin = 1;
                        $bolsa->created_on = date("Y-m-d H:i:s");
                        $bolsa->save();
                    }                

                    /*id de preciotallacolor y su respectiva cantidad*/
                    $productos = explode(',',$_POST['ptcs']);
                    $cantidades = explode(',',$_POST['vals']);

                    for($i=0; $i < count($productos); $i++){

                        $idPrecioTallaColor = $productos[$i];
                        $cantidad = $cantidades[$i];

                        $precioTallaColor = Preciotallacolor::model()->findByPk($idPrecioTallaColor);

                        $idProducto = $precioTallaColor->producto_id;
                        $idTalla = $precioTallaColor->talla_id;
                        $idColor = $precioTallaColor->color_id;

                        //Agregarlo a la bolsa tantas veces como indique la cantidad
                        for($j=0; $j < $cantidad; $j++){

                            $bolsa->addProducto($idProducto, $idTalla, $idColor);	

                        }                    
                    }
                }
//                $this->redirect(array('admin/compradir'));
//                $this->redirect($this->createAbsoluteUrl('bolsa/index',array(),'https'));
                $this->redirect($this->createAbsoluteUrl('/bolsa/index',array(
                    "user" => $id,
                    )));

              }

			
			if(isset(Yii::app()->session['ptcs'])){
				
				unset(Yii::app()->session['ptcs']);
			}
			if(isset(Yii::app()->session['vals'])){
				
				unset(Yii::app()->session['vals']);
			}
			if(isset(Yii::app()->session['usercompra'])){
				
				unset(Yii::app()->session['usercompra']);
			}
							
			  	$q=" order by p.nombre";
			  	
	            if (isset($_POST['query']))
	            {
	                $q=" AND (p.nombre LIKE '%".trim($_POST['query'])."%' OR ptc.sku LIKE '%".trim($_POST['query'])."%'
	                 OR m.nombre LIKE '%".trim($_POST['query'])."%' OR p.codigo LIKE '%".trim($_POST['query'])."%' )".$q;		
				      	
	            }
				
				Yii::app()->session['usercompra']=$id;
	 
	          	$sql='select m.nombre as Marca, ptc.talla_id as Talla, ptc.color_id as Color, ptc.id as ptcid, p.id, p.nombre as Nombre, ptc.cantidad, p.codigo, ptc.sku as SKU 
					from tbl_precioTallaColor ptc, tbl_producto p JOIN tbl_marca m ON m.id=p.marca_id
					where ptc.cantidad >0 and p.estado=0 and p.`status`=1 and ptc.producto_id = p.id '.$q;
			
				$rawData=Yii::app()->db->createCommand($sql)->queryAll();
				
				$data=array();
				foreach($rawData as $row){
					//$row['Marca']=Marca::model()->getMarca($row['Marca']);
					$row['Talla']=Talla::model()->getTalla($row['Talla']);
					$row['url']=Imagen::model()->getImagen($row['id'],$row['Color']);
					$row['color_id']=$row['Color'];
					$row['Color']=Color::model()->getColor($row['Color']);
					$row['precioDescuento']=Precio::model()->getPrecioDescuento($row['id']);	
					array_push($data,$row);
								 				
				}
				
				// or using: $rawData=User::model()->findAll(); <--this better represents your question
	
				$dataProvider=new CArrayDataProvider($data, array(
				    'id'=>'data',
				    'pagination'=>array(
				        'pageSize'=>12,
				    ),
					 
				    'sort'=>array(
				        'attributes'=>array(
				             'Nombre', 'Marca', 'Talla', 'Color'
				        ),
	    ),
				));
				
				
				
				 
				
	            $this->render('compra', array(   'dataProvider'=>$dataProvider,
	            ));	
	   
		
	}
	
	public function actionPorComprar(){
			
		$html="";
		$html=$html."<table class='table table-striped'><thead><tr><th>PRODUCTO</th>
		<th>DATOS</th><th>CANTIDAD</th></tr></thead><tbody>";	
		$ptcs = explode(',',$_POST['ids']);
		$vals = explode(',',$_POST['cants']);
		$i=0;		
		foreach($ptcs as $ptc)
		{
				
			$obj=Preciotallacolor::model()->findByPk($ptc);	
			$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$obj->producto_id,'color_id'=>$obj->color_id ),array('order'=>'orden ASC'));
			if(sizeof($ima)==0)
				$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$obj->producto_id),array('order'=>'orden ASC'));
			if(sizeof($ima)==0)	
				$im="<td align='center'>".CHtml::image('http://placehold.it/50x50', "producto", array('id'=>'principal','rel'=>'image_src','width'=>'50px'))."</td>";
			else
				$im= "<td align='center'>".CHtml::image($ima[0]->getUrl(array('ext'=>'png')), "producto", array('id'=>'principal','rel'=>'image_src','width'=>'50px'))."</td>";
						 	
			$html=$html."<tr>".
			$im."<td>".
			"Color: ".$obj->mycolor->valor."<br/>".
			"Marca: ".$obj->producto->mymarca->nombre."<br/>".
			"Talla: ".$obj->mytalla->valor."   </td><td align='center'>".
			$vals[$i]."</td></tr>";
			$i++;
		}
		$html=$html."</tbody></table>";	
		echo $html;
		
	}
	
	
	
	
	public function actionCompradir()
		{
			$dir = new Direccion;
			
			
			if(isset($_POST['tipo']) && $_POST['tipo']=='direccionVieja')
			{
				//echo "Id:".$_POST['Direccion']['id'];
				
				Yii::app()->session['idDireccion']=$_POST['Direccion']['id'];
				
				$this->redirect(array('admin/comprapago'));
//				$this->redirect(array('bolsa/pagosAdmin'));
			}
			else
			if(isset($_POST['Direccion'])) // nuevo registro
			{
				//if($_POST['Direccion']['nombre']!="")
			//	{
				
				// guardar en el modelo direccion
				$dir->attributes=$_POST['Direccion'];
				
				if($dir->pais=="1")
					$dir->pais = "Venezuela";
				
				if($dir->pais=="2")
					$dir->pais = "Colombia";
				
				if($dir->pais=="3")
					$dir->pais = "Estados Unidos"; 
				
				$dir->user_id = Yii::app()->session['usercompra'];
				
					if($dir->save())
					{
						Yii::app()->session['idDireccion']=$dir->id;
						$this->render('comprapago',array('idDireccion'=>$dir->id));
						//$this->redirect(array('bolsa/pagos','id'=>$dir->id)); // redir to action Pagos
					}
					
				//} // nombre
			//	else {
					//$this->render('direcciones',array('dir'=>$dir)); // regresa
				//}
				
			}else // si está viniendo de la pagina anterior que muestre todo 
			{
				$this->render('compradir',array('dir'=>$dir));
			}
			

		}

	public function actionComprapago()
		{
			
			if(isset($_POST['idDireccion'])) // escogiendo cual es la preferencia de pago
			{ 
				$idDireccion = $_POST['idDireccion'];
				$tipoPago = $_POST['tipoPago'];
				echo "if";
				
				$this->render('compraconfirm',array('idDireccion'=>$idDireccion,'tipoPago'=>$tipoPago));
				//$this->redirect(array('bolsa/confirmar','idDireccion'=>$idDireccion, 'tipoPago'=>$tipoPago)); 
				// se le pasan los datos al action confirmar	
			}  // de direcciones
				$vals = explode(',',Yii::app()->session['vals']);
				$ptcs=explode(',',Yii::app()->session['ptcs']);
				$peso=0; $i=0;
				foreach ($ptcs as $ptc){
					$obj=Preciotallacolor::model()->findByPk($ptc);
					$peso+=$obj->producto->peso*$vals[$i];
				}
				$this->render('comprapago',array('cantidad'=>array_sum($vals),'peso_total'=>$peso));
			
			
		
		}  
	public function actionCompraconfirm()
		{
			
			// viene de pagos
			//var_dump($_POST);
			if(isset($_POST['tipo_pago'])){
				Yii::app()->getSession()->add('tipoPago',$_POST['tipo_pago']);
				if(isset($_POST['usar_balance']) && $_POST['usar_balance'] == '1'){
					Yii::app()->getSession()->add('usarBalance',$_POST['usar_balance']);
				}else{
					Yii::app()->getSession()->add('usarBalance','0');
				}
				//echo '<br/>'.$_POST['tipo_pago'];
				
			}
			
			$this->render('compraconfirm');
		}
	public function actionModal()
	{
		$tarjeta = new TarjetaCredito;
		
		$datos="";
		
		$datos=$datos."<div class='modal-header'>";
		$datos=$datos."Agregar datos de tarjeta de crédito";
    	$datos=$datos."</div>";
		
		$datos=$datos."<div class='modal-body'>";
		
		$datos=$datos.'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">';
  		$datos=$datos.'<tr>';			
		$datos=$datos.'<th scope="col" colspan="3">&nbsp;</th>';
		$datos=$datos.'<th scope="col">Número</th>';		
		$datos=$datos.'<th scope="col">Nombre en la Tarjeta</th>';
		$datos=$datos.'<th scope="col">Fecha de Vencimiento</th>';
		$datos=$datos.'</tr>';	
		
		$tarjetas = TarjetaCredito::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
		
		if(isset($tarjetas))
		{
			foreach($tarjetas as $cada){
				
				$datos=$datos.'<tr>';
				$datos=$datos.'<td><input class="radioss" type="radio" name="optionsRadios" id="tarjeta" value="'.$cada->id.'" ></td>';
				$datos=$datos.'<td><i class="icon-picture"></i></td>';
				$datos=$datos.'<td>Mastercard</td>';
				
				$rest = substr($cada->numero, -4);
				
				$datos=$datos.'<td>XXXX XXXX XXXX '.$rest.'</td>';
				$datos=$datos.'<td>'.$cada->nombre.'</td>';
				$datos=$datos.'<td>'.$cada->vencimiento.'</td>';
				$datos=$datos.'</tr>';
			}	
			$datos=$datos.'</table>';
		}
		else
			{
				$datos=$datos.'<tr>';
				$datos=$datos.'<td>No tienes tarjetas de credito asociadas.</td>';
				$datos=$datos.'</tr>';
				$datos=$datos.'</table>';
			}	
			
		
		$datos=$datos.'<button type="button" id="nueva" class="btn btn-info btn-small" data-toggle="collapse" data-target="#collapseOne"> Agregar una nueva tarjeta </button>';
    	
		$datos=$datos.'<div class="collapse" id="collapseOne">';
		$datos=$datos.'<form class="">';
        $datos=$datos.'<h5 class="braker_bottom">Nueva tarjeta de crédito</h5>';
		
		$datos=$datos.'<div class="control-group">';
        $datos=$datos.'<div class="controls">';     
		$datos=$datos. CHtml::activeTextField($tarjeta,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre impreso en la tarjeta'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
    	
  		$datos=$datos.'<div class="control-group">';
        $datos=$datos.'<div class="controls">';     
		$datos=$datos. CHtml::activeTextField($tarjeta,'numero',array('id'=>'numero','class'=>'span5','placeholder'=>'Número de la tarjeta'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
  
  		$datos=$datos.'<div class="control-group">';
        $datos=$datos.'<div class="controls">';     
		$datos=$datos. CHtml::activeTextField($tarjeta,'codigo',array('id'=>'codigo','class'=>'span2','placeholder'=>'Código de seguridad'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
  
  		$datos=$datos.'<div class="control-group">';
		$datos=$datos.'<label class="control-label required">Fecha de Vencimiento</label>';
        $datos=$datos.'<div class="controls">';     
	  	$datos=$datos. CHtml::dropDownList('mes','',array('Mes'=>'Mes','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'),array('id'=>'mes','class'=>'span1','placeholder'=>'Mes'));
        $datos=$datos. CHtml::dropDownList('ano','',array('Ano'=>'Año','2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019'),array('id'=>'ano','class'=>'span1','placeholder'=>'Año'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'direccion',array('id'=>'direccion','class'=>'span5','placeholder'=>'Dirección')) ;
		$datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'ciudad',array('id'=>'ciudad','class'=>'span5','placeholder'=>'Ciudad'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'estado',array('id'=>'estado','class'=>'span5','placeholder'=>'Estado'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'zip',array('id'=>'zip','class'=>'span2','placeholder'=>'Código Postal'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."</div>"; // modal body
		
		$datos=$datos."<div class='modal-footer'>";
		
		$datos=$datos."<div class=''><a id='boton_pago_tarjeta' onclick='enviarTarjeta()' class='pull-left btn-large btn btn-danger'> Pagar </a></div>";
    	$datos=$datos."</form>";
		$datos=$datos."</div>";
		
		$datos=$datos."<input type='hidden' id='idTarjeta' value='0' />"; // despues aqui se mandaria el id si la persona escoge una tarjeta que ya utilizó
		
		$datos=$datos."</div>"; // footer
		
		$datos=$datos."<script>";
		$datos=$datos."$(document).ready(function() {";
		
			$datos=$datos.'$("#nueva").click(function() { ';
				$datos=$datos."$('.table').find('input:radio:checked').prop('checked',false);";
				$datos=$datos.'$("#tarjeta").prop("checked", false);';
				$datos=$datos.'$("#idTarjeta").val(0);'; // lo regreso a 0 para que sea tarjeta nueva
			$datos=$datos.'});';
		
			$datos=$datos.'$(".radioss").click(function() { ';
				$datos=$datos."var numero = $(this).attr('value');";
				//$datos=$datos." alert(numero); ";
        		$datos=$datos.'$("#idTarjeta").val(numero);';
        	$datos=$datos."});";
		
		$datos=$datos."});"; 
		$datos=$datos."</script>"; 
		
		
		echo $datos;
		
		
	}

	
	
	public function actionCredito(){
		
			if(isset($_POST['tipoPago']) && $_POST['tipoPago'] == 2){ // Pago con TDC
						
					if($_POST['idCard'] == 0) // creo una tarjeta nueva
					{
						$usuario = Yii::app()->user->id; 
							
						$exp = $_POST['mes']."/".$_POST['ano'];
							
							$data_array = array(
								"Amount"=>$_POST['total'], // MONTO DE LA COMPRA
								"Description"=>"Tarjeta de Credito", // DESCRIPCION 
								"CardHolder"=>$_POST['nom'], // NOMBRE EN TARJETA
								"CardNumber"=>$_POST['num'], // NUMERO DE TARJETA
								"CVC"=>$_POST['cod'], //CODIGO DE SEGURIDAD
								"ExpirationDate"=>$exp, // FECHA DE VENCIMIENTO
								"StatusId"=>"2", // 1 = RETENER 2 = COMPRAR
								"Address"=>$_POST['dir'], // DIRECCION
								"City"=>$_POST['ciud'], // CIUDAD
								"ZipCode"=>$_POST['zip'], // CODIGO POSTAL
								"State"=>$_POST['est'], //ESTADO
							);
							
						$output = Yii::app()->curl->putPago($data_array); // se ejecuto
							
							if($output->code == 201){ // PAGO AUTORIZADO
							
								$detalle = new Detalle;
							
								$detalle->nTarjeta = $_POST['num'];
								$detalle->nTransferencia = $output->id;
								$detalle->nombre = $_POST['nom'];
								$detalle->codigo = $_POST['cod'];
								$detalle->vencimiento = $exp;
								$detalle->monto = $_POST['total'];
								$detalle->fecha = date("Y-m-d H:i:s");
								$detalle->banco = 'TDC';
								$detalle->estado = 1; // aceptado
								
								if($detalle->save()){
												
									$tarjeta = new TarjetaCredito;
								
									$tarjeta->nombre = $_POST['nom'];
									$tarjeta->numero = $detalle->nTarjeta;
									$tarjeta->codigo = $detalle->codigo;
									$tarjeta->vencimiento = $exp;
									$tarjeta->direccion = $_POST['dir'];
									$tarjeta->ciudad = $_POST['ciud'];
									$tarjeta->zip = $_POST['zip'];
									$tarjeta->estado = $_POST['est'];
									$tarjeta->user_id = $usuario;		
										
									$tarjeta->save();
									
									
									// cuando finalice entonces envia id de la orden para redireccionar
									echo CJSON::encode(array(
										'status'=> $output->code, // paso o no
										'mensaje' => $output->message,
										'idDetalle' => $detalle->id
										
									));
									
								}//detalle
								
							}// 201
							else
							{	
								// cuando finalice entonces envia id de la orden para redireccionar
								echo CJSON::encode(array(
									'status'=> $output->code, // paso o no
									'mensaje' => $output->message									
								));
									
							}
							
							//$respCard = $respCard."Success: ".$output->success."<br>"; // 0 = FALLO 1 = EXITO
						//	$respCard = $respCard."Message:".$output->success."<br>"; // MENSAJE EN EL CASO DE FALLO
						//	$respCard = $respCard."Id: ".$output->id."<br>"; // EL ID DE LA TRANSACCION
						//	$respCard = $respCard."Code: ".$output->code."<br>"; // 201 = AUTORIZADO 400 = ERROR DATOS 401 = ERROR AUTENTIFICACION 403 = RECHAZADO 503 = ERROR INTERNO

						}
						else // escogio una tarjeta
						{
							
							$card = TarjetaCredito::model()->findByPk($_POST['idCard']);
							$usuario = Yii::app()->user->id; 
							
							$data_array = array(
								"Amount"=>$_POST['total'], // MONTO DE LA COMPRA
								"Description"=>"Tarjeta de Credito", // DESCRIPCION 
								"CardHolder"=>$card->nombre, // NOMBRE EN TARJETA
								"CardNumber"=>$card->numero, // NUMERO DE TARJETA
								"CVC"=>$card->codigo, //CODIGO DE SEGURIDAD
								"ExpirationDate"=>$card->vencimiento, // FECHA DE VENCIMIENTO
								"StatusId"=>"2", // 1 = RETENER 2 = COMPRAR
								"Address"=>$card->direccion, // DIRECCION
								"City"=>$card->ciudad, // CIUDAD
								"ZipCode"=>$card->zip, // CODIGO POSTAL
								"State"=>$card->estado, //ESTADO
							);
							
						$output = Yii::app()->curl->putPago($data_array); // se ejecuto
						echo"<div style='width 500px; height:500px; font-size:25px' >";print_r($output);echo "</div>";
						
					/*	if($output->code == 201){ // PAGO AUTORIZADO
							
								$detalle = new Detalle;
							
								$detalle->nTarjeta = $card->numero;
								$detalle->nTransferencia = $output->id;
								$detalle->nombre = $card->nombre;
								$detalle->codigo = $card->codigo;
								$detalle->vencimiento = $card->vencimiento;
								$detalle->monto = $_POST['total'];
								$detalle->fecha = date("Y-m-d H:i:s");
								$detalle->banco = 'TDC';
								$detalle->estado = 1; // aceptado
								
								if($detalle->save()){
									// cuando finalice entonces envia id de la orden para redireccionar
									echo CJSON::encode(array(
										'status'=> $output->code, // paso o no
										'mensaje' => $output->message,
										'idDetalle' => $detalle->id										
									));
								}
					
							}*/
						}


					}


	

	
	}
	
		public function actionEliminardireccion()
		{
			// if(isset($_POST['idDir']))
			// {
			// 	$direccion = Direccion::model()->findByPk($_POST['idDir']);
			// 	$direccion->delete();
				
			// 	echo "ok";
			// }
			$id = $_POST['idDir'];
			$direccion = Direccion::model()->findByPk( $id  );
			$user = User::model()->findByPk( Yii::app()->user->id );
			if($user){
				$facturas1 = Factura::model()->countByAttributes(array('direccion_fiscal_id'=>$id));
				$facturas2 = Factura::model()->countByAttributes(array('direccion_envio_id'=>$id));
				
				if($facturas1 == 0 && $facturas2 == 0){
					if($direccion->delete()){
						echo "ok";
					}else{
						echo "wrong";
					}
				}else{
					echo "bad";
				}
			}
		}
		
			/**
		 * editar una direccion.
		 */
		public function actionEditardireccion()
		{
			if(isset($_POST['idDireccion'])){
				$dirEdit = Direccion::model()->findByPk($_POST['idDireccion']);
				
				$dirEdit->nombre = $_POST['Direccion']['nombre'];
				$dirEdit->apellido = $_POST['Direccion']['apellido'];
				$dirEdit->cedula = $_POST['Direccion']['cedula'];
				$dirEdit->dirUno = $_POST['Direccion']['dirUno'];
				$dirEdit->dirDos = $_POST['Direccion']['dirDos'];
				$dirEdit->telefono = $_POST['Direccion']['telefono'];
				$dirEdit->ciudad_id = $_POST['Direccion']['ciudad_id'];
				$dirEdit->provincia_id = $_POST['Direccion']['provincia_id'];
				
				if($_POST['Direccion']['pais']==1)
					$dirEdit->pais = "Venezuela";
				
				if($_POST['Direccion']['pais']==2)
					$dirEdit->pais = "Colombia";
				
				if($_POST['Direccion']['pais']==3)
					$dirEdit->pais = "Estados Unidos";
				
				if($dirEdit->save()){
					$dir = new Direccion;
					$this->redirect(array('admin/compradir')); // redir to action
					//$this->render('direcciones',array('dir'=>$dir));
					}
				
			}
			else if($_GET['id']){ // piden editarlo
				$direccion = Direccion::model()->findByAttributes(array('id'=>$_GET['id'],'user_id'=>Yii::app()->user->id));
				$this->render('editarDir',array('dir'=>$direccion));
			}
			
			
		}
	
	public function actionComprafin()
	{
				if (Yii::app()->request->isPostRequest){ // asegurar que viene en post
		 	$respCard = "";
		 	$usuario = Yii::app()->session['usercompra']; 
			$user = User::model()->findByPk($usuario);
			
			switch ($_POST['tipoPago']) {
			    case 1: // TRANSFERENCIA
			       	$dirEnvio = $this->clonarDireccion(Direccion::model()->findByAttributes(array('id'=>$_POST['idDireccion'],'user_id'=>$usuario)));
					$orden = new Orden;
					$orden->subtotal = $_POST['subtotal'];
					$orden->descuento = 0;
					$orden->envio = $_POST['envio'];
					$orden->iva = $_POST['iva'];
					
					$orden->descuentoRegalo = 0;
					$orden->total = $_POST['total'];
					$orden->seguro = $_POST['seguro'];
					$orden->fecha = date("Y-m-d H:i:s"); // Datetime exacto del momento de la compra 
					$orden->estado = Orden::ESTADO_ESPERA; // en espera de pago
					$orden->bolsa_id = 0;
					$orden->user_id = $usuario;
					$orden->direccionEnvio_id = $dirEnvio->id;
					$orden->tipo_guia = $_POST['tipo_guia'];
					
					$okk = round($_POST['total'], 2);
					$orden->total = $okk;
					$orden->admin_id=Yii::app()->user->id;
					
					$acpeso=0;
					$ptcs = explode(',',Yii::app()->session['ptcs']);
					$vals = explode(',',Yii::app()->session['vals']);		
					foreach($ptcs as $ptc)
								{	$inst=Preciotallacolor::model()->findByPk($ptc);
									$prinst=Producto::model()->findByPk($inst->producto_id);
									$acpeso+=$prinst->peso;
								}
							$orden->peso=$acpeso;
					
					
					
					if (!($orden->save())){
						echo CJSON::encode(array(
								'status'=> 'error',
								'error'=> $orden->getErrors(),
							));
						Yii::trace('UserID:'.$usuario.' Error al guardar la orden:'.print_r($orden->getErrors(),true), 'registro');	
						Yii::app()->end();
						
					}	
									
					if(isset($_POST['usar_balance']) && $_POST['usar_balance'] == '1'){
						//$balance_usuario=$balance_usuario=str_replace(',','.',Profile::model()->getSaldo(Yii::app()->user->id));	
						$balance_usuario = $user->saldo;
						if($balance_usuario > 0){
							$balance = new Balance;
							$detalle_balance = new Detalle;
							if($balance_usuario >= $_POST['total']){
								$orden->cambiarEstado(Orden::ESTADO_CONFIRMADO);
								
								$balance->total = $_POST['total']*(-1);
								$detalle_balance->monto=$_POST['total'];
							}else{
								 
								$orden->cambiarEstado(Orden::ESTADO_INSUFICIENTE);
								$balance->total = $balance_usuario*(-1);
								$detalle_balance->monto=$balance_usuario;
							}

							$detalle_balance->comentario="Uso de Saldo";
							$detalle_balance->estado=1;
							$detalle_balance->orden_id=$orden->id;
							$detalle_balance->tipo_pago = 3;
							if($detalle_balance->save()){
								$balance->orden_id = $orden->id;
								$balance->user_id = $usuario;
								$balance->tipo = 1;
								//$balance->total=round($balance->total,2);
								$balance->save();
							}
						}
					}
					
					$i=0;
							
								// añadiendo a orden producto
								foreach($ptcs as $ptc)
								{
									$prorden = new OrdenHasProductotallacolor;
									$prorden->tbl_orden_id = $orden->id;
									$prorden->preciotallacolor_id = $ptc;
									$prorden->cantidad = $vals[$i];
									$prorden->look_id = 0;
									
									$prtc = Preciotallacolor::model()->findByPk($ptc); // tengo preciotallacolor
									$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$prtc->producto_id));
									
										$prorden->precio = $precio->precioDescuento;
									
								
									
									if($prorden->save()){
										//listo y que repita el proceso
									}
									$i++;
								}
								$i=0;
								//descontando del inventario
								foreach($ptcs as $ptc)
								{
									$uno = Preciotallacolor::model()->findByPk($ptc);
									$cantidadNueva = $uno->cantidad - $vals[$i]; // lo que hay menos lo que se compró
									
									Preciotallacolor::model()->updateByPk($ptc, array('cantidad'=>$cantidadNueva));
									// descuenta y se repite									
								}
					
					
					
					
					// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
					// se agrega este estado en el caso de que no se haya pagado por TDC
					
					$estado = new Estado;
					$estado->estado = 1;
					$estado->user_id = $usuario;
					$estado->fecha = date("Y-m-d");
					$estado->orden_id = $orden->id;
					$estado->save();


					 	// cuando finalice entonces envia id de la orden para redireccionar
					 echo CJSON::encode(array(
						'status'=> 'ok',
						'orden'=> $orden->id,
						'total'=> $orden->total,
						'respCard' => $respCard,
						'descuento'=>$orden->descuento,
						'url'=> $this->createAbsoluteUrl('bolsa/pedido',array('id'=>$orden->id),'http'),
					));
			        break;
			    case 2: // TARJETA DE CREDITO
			        echo "i equals 1";
			        break;
			    case 3:
			        echo "i equals 2";
			        break;
			}
				// Generar factura
			$factura = new Factura;
			$factura->fecha = date('Y-m-d');
			$factura->direccion_fiscal_id = $_POST['idDireccion'];  // esta direccion hay que cambiarla después, el usuario debe seleccionar esta dirección durante el proceso de compra
			$factura->direccion_envio_id = $_POST['idDireccion'];
			$factura->orden_id = $orden->id;
			$factura->save();
			// Enviar correo con resumen de la compra
			$user = User::model()->findByPk($usuario);
			$message            = new YiiMailMessage;
	        //this points to the file test.php inside the view path
	        $message->view = "mail_compra";
			$subject = 'Tu compra en Personaling';
	        $params              = array('subject'=>$subject, 'orden'=>$orden);
	        $message->subject    = $subject;
	        $message->setBody($params, 'text/html');
	        $message->addTo($user->email);
			$message->from = array('ventas@personaling.com' => 'Tu Personal Shopper Digital');
	        //$message->from = 'Tu Personal Shopper Digital <ventas@personaling.com>\r\n';   
	        Yii::app()->mail->send($message);			
		}
		
		
		
	}

    public function actionMensajes(){
        
		$this->render('mensajes');
		
		
    }
    public function actionBalance($id){

			
            $model=$this->loadModel();
            $balances=Balance::model()->findAllByAttributes(array('user_id'=>$id),
                        array("order" => "fecha DESC"));   
            

            $this->render('balance',array(
                    'model'=>$model,
                    'balances'=>$balances

            ));		
		
    }
	
	public function actionDisplaymsj(){
		if(isset($_POST['msj_id'])){
			$mensaje = Mensaje::model()->findByPk($_POST['msj_id']);
			
			if($mensaje->estado == 0) // no se ha leido
			{
				$mensaje->estado = 1;
				$mensaje->save(); 
			}
			
			$div = "";
			
			$div = $div.'<div class="padding_medium bg_color3 ">';
			$div = $div."<p><strong>De:</strong> Admin <span class='pull-right'><strong> ".date('d/m/Y', strtotime($mensaje->fecha))."</strong> ".date('h:i A', strtotime($mensaje->fecha))."</span></p>";
			$div = $div."<p> <strong>Asunto:</strong> ".$mensaje->asunto."</p>";
			$div = $div."<p> ".$mensaje->cuerpo." </p>";
		/*	$div = $div.'<form class=" margin_top_medium ">
					  		<textarea class="span12 nmargin_top_medium" rows="3" placeholder="Escribe tu mensaje..."	></textarea>
					  		<button class="btn btn-danger"> <span class="entypo color3 icon_personaling_medium" >&#10150;</span> Enviar </button>
				  		</form>'; */
			$div = $div.'<p><a class="btn btn-danger pull-right" href="'.Yii::app()->getBaseUrl().'/orden/detalles/'.$mensaje->orden_id.'#mensajes" target="_blank"> Responder </a></p>
				  		';	  		
			
			$div = $div."<br/></div>";
			
			echo $div;
		

		
		}
		
		
		
	}

    public function actionEditAddress($id){
        $model=Direccion::model()->findByPk($id);
         if(isset($_POST['idDireccion'])){
                $dirEdit = $model;
                
                $dirEdit->nombre = $_POST['Direccion']['nombre'];
                $dirEdit->apellido = $_POST['Direccion']['apellido'];
                $dirEdit->cedula = $_POST['Direccion']['cedula'];
                $dirEdit->dirUno = $_POST['Direccion']['dirUno'];
                $dirEdit->dirDos = $_POST['Direccion']['dirDos'];
                $dirEdit->telefono = $_POST['Direccion']['telefono'];
                $dirEdit->ciudad_id = $_POST['Direccion']['ciudad_id'];
                $dirEdit->provincia_id = $_POST['Direccion']['provincia_id'];
                
                $dirEdit->pais=Pais::model()->getOficial($_POST['Direccion']['pais']);
                
                if($dirEdit->save())
                      Yii::app()->user->setFlash('success', UserModule::t("Direccion Actualizada"));
                else {
                      Yii::app()->user->setFlash('error', UserModule::t("Error al actualizar direccion"));
                }
                    $this->redirect(array('admin/direcciones/id/'.$dirEdit->user_id));           
                
            }
         
         
         $this->renderPartial('direccionesForm',array(
            'dir'=>$model,                
        ));
    }

	public function clonarDireccion($direccion){
		$dirEnvio = new DireccionEnvio;
					
		$dirEnvio->nombre = $direccion->nombre;
		$dirEnvio->apellido = $direccion->apellido;
		$dirEnvio->cedula = $direccion->cedula;
		$dirEnvio->dirUno = $direccion->dirUno;
		$dirEnvio->dirDos = $direccion->dirDos;
		$dirEnvio->telefono = $direccion->telefono;
		$dirEnvio->ciudad_id = $direccion->ciudad_id;
		$dirEnvio->provincia_id = $direccion->provincia_id;
		$dirEnvio->pais = $direccion->pais;	
		$dirEnvio->save();
		return $dirEnvio;
	}
        
        public function actionSeguimiento($id)
	{
		$model=$this->loadModel();
                
                /*Para compras en tienda*/
		$criteria=new CDbCriteria;
		$criteria->compare("user_id", $id);
                $criteria->compare("tipo_compra", ShoppingMetric::TIPO_TIENDA);
		$criteria->order = 'created_on DESC';       
		
		$movimientos = new CActiveDataProvider('ShoppingMetric', array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                                    'pageSize'=>20,
                            ),
                    
                        
                ));
                
                /*Para compra de giftcards*/
		$criteriaGC=new CDbCriteria;		
		$criteriaGC->compare("user_id", $id);
		$criteriaGC->compare("tipo_compra", ShoppingMetric::TIPO_GIFTCARD);		
		$criteriaGC->order = 'created_on DESC';
       
		
		$movimientosGC = new CActiveDataProvider('ShoppingMetric', array(
                    'criteria'=>$criteriaGC,
                    'pagination'=>array(
                                    'pageSize'=>20,
                            ),
                    
                        
                ));


                $this->render('seguimiento',array(
			'model'=>$model,
			'movimientos'=>$movimientos,
			'movimientosGC'=>$movimientosGC,
			
		));
	}
        
        public function actionSuscritosNl() {
            
            //Productos en el archivo
            $total = 0;
            //Productos modificados en precio
            $modificados = 0;
            
            //si esta validando el archivo
            if(isset($_POST["validar"]))
            {   
                
            //si esta cargandolo ya
            }
            else if(isset($_POST["cargar"])){
                
                $archivo = CUploadedFile::getInstancesByName('carga');                    
                $error = false;    
                //Guardarlo en el servidor para luego abrirlo y revisar
                if (isset($archivo) && count($archivo) > 0) {
                    foreach ($archivo as $arc => $xls) {
                        $nombre = Yii::getPathOfAlias('webroot') . '/docs/xlsPreciosProductos/' . "Archivo";
                        $extension = '.' . $xls->extensionName;                     

                        if (!$xls->saveAs($nombre . $extension)) {
                         
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo. Intente de nuevo."));                            
                            $error = true;
                        }
                    }
                //si no subio nada    
                }else{
                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('error', UserModule::t("Debe seleccionar un archivo."));                            
                    $error = true;
                }
                
                //si se pudo subir el archivo
                if(!$error){
                    
                    $sheetArray = Yii::app()->yexcel->readActiveSheet($nombre.$extension); 
                    $inParams = array();
                    foreach ($sheetArray as $row) {                        
                        
                        $inParams[] = $row["A"];  
                        $total++;
                    }

                    $criteria = new CDbCriteria();
                    $criteria->addInCondition("email", $inParams);
                    
//                    echo "<pre>";
//                    print_r($criteria);
//                    echo "</pre><br>";
//                                        
                    //actualizar la bd
                    $modificados = User::model()->updateAll(array(
                        "suscrito_nl" => 1,
                    ),$criteria);

                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('success', 
                    UserModule::t("Se ha cargado el archivo con éxito. Vea los detalles a continuación:"));                   
                        
                    echo "Totales: ".$total. "<br>";
                    echo "Modificados: ".$modificados. "<br>";
                    Yii::app()->end(); 
                }
            }
            
            
            $this->render('suscritosNl', array(               
                'total' => $total,
                'modificados' => $modificados,                                
            ));
            
        }

		public function actionHistorial($id)
		{
				             
         	$model=User::model()->findByPk($id);
			$this->render('historial',array(
				'model'=>$model,
			));     
			
		}
        
        public function actionSaveUrl(){
            if (Yii::app()->request->isPostRequest) {
                    
                $profile=Profile::model()->findByPk($_POST['id']);
                $profile->url=$_POST['url'];
                if($profile->save()){
                     Yii::app()->user->setFlash('success',"El alias de Url de ".$profile->first_name." ".$profile->last_name." se ha modificado a ".$profile->url);
                     echo json_encode(array(
                        'status' => 'ok',                                              
                     ));
                }else{
                    Yii::app()->user->setFlash('error', "El alias de Url de ".$profile->first_name." no pudo modificarse");
                     echo json_encode($profile->errors);
                }
                    
                    
               
            }
             else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }



}
