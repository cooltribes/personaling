<?php 

class OrdenController extends Controller
{	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	 
        /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter. 
	 * @return array access control rules 
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('detallepedido','entregar','listado','modals','cancelar','recibo','imprimir', 'getFilter','removeFilter','historial',
				'mensajes','devolver','devoluciones'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions			
 
				'actions'=>array('index','cancel','admin','modalventas',
                                    'detalles','devoluciones','validar','enviar',
                                    'factura','calcularenvio','createexcel',
                                    'importarmasivo','reporte','reportecsv','admincsv',
                                    'adminXLS','generarExcelOut','devolver','adminDevoluciones',
                                    'detallesDevolucion', 'AceptarDevolucion','RechazarDevolucion',
                                    'AnularDevuelto','cantidadDevuelto','activarDevuelto',
                                    'resolverOutbound','descargarReturnXML', 'reporteDetallado','ResolverItemReturn','ordeneszoho'),

				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/*
	 * administrador de pedidos del usuario
	 * */
	public function actionListado()
	{
		$orden = new Orden;
		
		$orden->user_id = Yii::app()->user->id;
		$dataProvider = $orden->activas();
		
		$this->render('adminUsuario',
		array('orden'=>$orden,
		'dataProvider'=>$dataProvider,
		));

	}

public function actionReporte()
	{ 
   $orden = new Orden;
		
		if(!isset($_GET['data_page'])){
			
			if(isset(Yii::app()->session['idMarca']))
				unset(Yii::app()->session['idMarca']);
				
			if(isset(Yii::app()->session['desde']))
			{	unset(Yii::app()->session['desde']);

			}
			if(isset(Yii::app()->session['hasta']))
			{	unset(Yii::app()->session['hasta']);

			}
		}
		
		if(isset($_POST['marcas']))
			Yii::app()->session['idMarca']=$_POST['marcas'];
			
		if(isset($_POST['desde'])&&isset($_POST['hasta']))
			{	Yii::app()->session['desde']=date("Y-m-d", strtotime($_POST['desde']));
				Yii::app()->session['hasta']=date("Y-m-d", strtotime($_POST['hasta']));
				
			}
	
			
			$dataProvider = $orden->vendidas();
		
		
		//$orden->user_id = Yii::app()->user->id;
		
		$marcas=Marca::model()->getAll();
		$this->render('reporte',
		array(
		'dataProvider'=>$dataProvider,'marcas'=>$marcas
		));


	}


public function actionReportexls(){
	
	$title = array(
    'font' => array(
     
        'size' => 14,
        'bold' => true,
        'color' => array(
            'rgb' => '000000'
        ),
    ),
   /*'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => '6D2D56',
        ),
    ),*/
);

		Yii::import('ext.phpexcel.XPHPExcel');    
	
		$objPHPExcel = XPHPExcel::createPHPExcel();
	
		$objPHPExcel->getProperties()->setCreator("Personaling.com")
		                         ->setLastModifiedBy("Personaling.com")
		                         ->setTitle("Reporte-productos-vendidos")
		                         ->setSubject("Reporte de Producto Vendidos")
		                         ->setDescription("Reporte de Productos Vendidos con sus especificaciones individuales")
		                         ->setKeywords("personaling")
		                         ->setCategory("personaling");

			// creando el encabezado
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'SKU')
						->setCellValue('B1', 'Referencia')
						->setCellValue('C1', 'Marca')
						->setCellValue('D1', 'Nombre')
						
						->setCellValue('E1', 'Color')
						->setCellValue('F1', 'Talla')
						->setCellValue('G1', 'Cantidad')
						->setCellValue('H1', 'Costo ('.Yii::t('contentForm','currSym').')')
						->setCellValue('I1', 'Precio de Venta sin IVA ('.Yii::t('contentForm','currSym').')')
						->setCellValue('J1', 'Precio de Venta con IVA ('.Yii::t('contentForm','currSym').')')
						->setCellValue('K1', 'Orden N°')
						->setCellValue('L1', 'Vendido en');
			// encabezado end			
		 	
			foreach(range('A','I') as $columnID) {
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
		 	
		 	
		 	//Eliminar filtrado por marca antes de consultar
		 	/*$fake=false;
		 	if(isset(Yii::app()->session['idMarca'])){
		 		$marca=Yii::app()->session['idMarca'];
		 		$fake=true;
		 		unset(Yii::app()->session['idMarca']);
		 	}*/
			//fin			
		 	
		 	$orden=new Orden;
		 	$ordenes = $orden->vendidas(false); 
		 	$fila = 2;
		
			
			//Reestablecer filtrado por marca si existia
			/*if($fake)
				Yii::app()->session['idMarca']=$marca;*/
		 	//fin	 
		 
		 	foreach($ordenes->getData() as $data)
			{

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
				                //////echo $descuento_look.' - '.$porcentaje;

				                $precio -= $data['Precio'] * ($porcentaje / 100);
				                $precio_iva -= $data['pIVA'] * ($porcentaje / 100);
				            }
				        }
				    }
				}
					//Buscando los precios si los productos se vendieron en un look o dejando los de ordenhasptc
             
                    $I=number_format($precio,2,',','.'); 
                    $J=number_format($precio_iva,2,',','.');


					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila , $data['SKU']) 
							->setCellValue('B'.$fila , $data['Referencia']) 
							->setCellValue('C'.$fila , $data['Marca']) 
							->setCellValue('D'.$fila , $data['Nombre'])
							->setCellValue('E'.$fila , $data['Color'])
							->setCellValue('F'.$fila , $data['Talla']) 
							->setCellValue('G'.$fila , $data['Cantidad']) 
							->setCellValue('H'.$fila , number_format($data['Costo'],2,',','.')) 
							->setCellValue('I'.$fila , trim($I))							
							->setCellValue('J'.$fila , trim($J))
							->setCellValue('K'.$fila , $data['Orden'])
							->setCellValue('L'.$fila ,date("d/m/Y",strtotime($data['Fecha'])));
					$fila++;

			} // foreach
		 
			// Rename worksheet
	
			$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="ReporteVentas.xls"');
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
			Yii::app()->end();
				  
	}


	public function actionReporteCSV(){
		$orden=new Orden;
		$ordenes = $orden->vendidas(false); 
		header( "Content-Type: text/csv;charset=utf-8" );
		header('Content-Disposition: attachment; filename="Reporte de Ventas.csv"');
		$fp = fopen('php://output', 'w');
        // creando el encabezado
        fputcsv($fp,
          		array(	'SKU', 
          				'Referencia', 
          				'Marca',
          				'Nombre',
          				'Color',
          				'Talla',
          				'Cantidad',
          				'Costo ('.Yii::t('contentForm','currSym').')',
          				'Precio de Venta sin IVA ('.Yii::t('contentForm','currSym').')',
          				'Precio de Venta con IVA ('.Yii::t('contentForm','currSym').')',
          				'Orden N°',
          				'Vendido en'),";",'"');
		
		
		
		foreach($ordenes->getData() as $data)
			{

				$precio = $data['Precio'];
				$precio_iva = $data['pIVA'];
				if($data['look']!=0){
				    $look = Look::model()->findByPk($data['look']);
				    $orden = Orden::model()->findByPk($data['Orden']);
				    if(isset($look) && isset($orden)){
				        if(!is_null($look->tipoDescuento)){
				            if($orden->getLookProducts($look->id) == $look->countItems() && $look->valorDescuento > 0){
				                //echo 'Precio: '.$look->getPrecio(false).' - Precio desc: '.$look->getPrecioDescuento(false);
				                $descuento_look = $look->getPrecio(false) - $look->getPrecioDescuento(false);
				                $porcentaje = ($descuento_look * 100) / $look->getPrecio(false);
				                //////echo $descuento_look.' - '.$porcentaje;

				                $precio -= $data['Precio'] * ($porcentaje / 100);
				                $precio_iva -= $data['pIVA'] * ($porcentaje / 100);
				            }
				        }
				    }
				}
					//Buscando los precios si los productos se vendieron en un look o dejando los de ordenhasptc
             
                    $I=number_format($precio,2,',','.'); 
                    $J=number_format($precio_iva,2,',','.');


					 $vals=array( 	$data['SKU'],
					 				$data['Referencia'], 
					 				utf8_decode($data['Marca']), 
									utf8_decode($data['Nombre']), 
									utf8_decode($data['Color']), 
									$data['Talla'], 
									$data['Cantidad'], 
									number_format($data['Costo'],2,',','.'), 
									trim($I), 
									trim($J), 
									$data['Orden'],
									date("d/m/Y",strtotime($data['Fecha'])));
					fputcsv($fp,$vals,";",'"');
				}
			fclose($fp); 
			ini_set('memory_limit','128M'); 
			Yii::app()->end(); 
		
		
	}



	public function actionHistorial()
	{
		$orden = new Orden;
		
		$orden->user_id = Yii::app()->user->id;
		$dataProvider = $orden->historial();
		
		$this->render('adminUsuario',
		array('orden'=>$orden,
		'dataProvider'=>$dataProvider,
		));

	}
	
	/*
	 * action de detalle desde usuario 
	 * */
	public function actionDetallepedido()
	{
		
		$orden = Orden::model()->findByAttributes(array('id'=>$_GET['id'],'user_id'=>Yii::app()->user->id));
		
		if(isset($orden))
			$this->render('detalleUsuario', array('orden'=>$orden));
		
		else
			echo "error";
	}
	
		
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/*
	 * lo envia al admin de pedidos
	 * */
	public function actionAdmin()
	{
            
            $orden = new Orden;
            $dataProvider = $orden->search();               
            
            if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;
            
            
           if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['query'])){
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
                
                    $dataProvider = $orden->buscarPorFiltros($filters);                    
                     
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '1') //Filtros para ventas
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 1;
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

            if (isset($_POST['query'])){
                unset($_SESSION["todoPost"]);
                $dataProvider = $orden->filtrado($_POST['query']); 
                
            }
            
            //Ordenar por fecha descendiente
            $criteria = $dataProvider->getCriteria();
            $criteria->order = 't.fecha DESC';
            $dataProvider->setCriteria($criteria);       
			Yii::app()->session['ordenCriteria']=$dataProvider->getCriteria();
            $this->render('admin', array('orden' => $orden,
                'dataProvider' => $dataProvider,
            ));

	}
	
     public function actionAdminXLS()
	{  
		ini_set('memory_limit','256M'); 

		$criteria=Yii::app()->session['ordenCriteria'];
		$criteria->select = array('t.id');
		$dataProvider = new CActiveDataProvider('Orden', array(
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
		                         ->setTitle("Reporte-Ordenes")
		                         ->setSubject("Reporte de Ordenes")
		                         ->setDescription("Reporte de Ordenes")
		                         ->setKeywords("personaling")
		                         ->setCategory("personaling");
		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'ID')
						->setCellValue('B1', 'Usuaria')
						->setCellValue('C1', 'Fecha')
						->setCellValue('D1', 'Looks')
						->setCellValue('E1', 'Prendas Individuales')
						->setCellValue('F1', 'Total Prendas')
						->setCellValue('G1', 'Monto (Bs)')
						->setCellValue('H1', 'Método de Pago')
						->setCellValue('I1', 'Estado');
						
		foreach(range('A','I') as $columnID) {
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

		
		
		$fila=2;
		foreach($dataProvider->getData() as $data){
				
			$orden=Orden::model()->findByPk($data->id);
			$compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$data->id));
			$ohptc= new OrdenHasProductotallacolor;
			
		 
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila , $data->id) 
							->setCellValue('B'.$fila , $orden->user->username) 
							->setCellValue('C'.$fila , date("d-m-Y H:i:s",strtotime($orden->fecha)))
							->setCellValue('D'.$fila , $ohptc->countLooks($data->id))
							->setCellValue('E'.$fila , $ohptc->countIndividuales($data->id))
							->setCellValue('F'.$fila , $ohptc->countPrendasEnLooks($data->id)) 
							->setCellValue('G'.$fila , number_format($orden->total,2,',','.')) 
							->setCellValue('H'.$fila , $orden->getTiposPago('reporte')) 
							->setCellValue('I'.$fila , $orden->textestado);  
					$fila++;
	
		}
		$objPHPExcel->setActiveSheetIndex(0);
 
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="ReporteOrdenes.xls"');
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





	public function actionAdminCSV()
	{  
		ini_set('memory_limit','256M'); 

		$criteria=Yii::app()->session['ordenCriteria'];
		$criteria->select = array('t.id');
		$dataProvider = new CActiveDataProvider('Orden', array(
                    'criteria' => $criteria,

                ));
                
                
                $pages=new CPagination($dataProvider->totalItemCount);
		$pages->pageSize=$dataProvider->totalItemCount;
		$dataProvider->setPagination($pages);	
			
                $elementos = $dataProvider->getData();
		
		header( "Content-Type: text/csv;charset=utf-8" );
		header('Content-Disposition: attachment; filename="Ordenes.csv"');
		$fp = fopen('php://output', 'w');
		
		
		fputcsv($fp,array(' ID', 'Usuaria', 'Fecha', 'Looks',
                    'Prendas Individuales', 'Total Prendas',
                    utf8_decode('Monto ('.Yii::t('contentForm','currSym').')'),
                    utf8_decode('Método de Pago'), 'Estado', 
                    utf8_decode('Tarjeta de Crédito'),'Paypal','Balance',
                    utf8_decode('Cupón de Descuento')),";",'"');
                
                
		foreach($elementos as $data){
				
			$orden=Orden::model()->findByPk($data->id);
			$compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$data->id));
			$ohptc= new OrdenHasProductotallacolor;
			$vals=array($data->id, $orden->user->username,
                            date("d-m-Y H:i:s",strtotime($orden->fecha)) , $ohptc->countLooks($data->id)
			, $ohptc->countIndividuales($data->id), 
                            $ohptc->countPrendasEnLooks($data->id), number_format($orden->total,2,',','.')
    			, $orden->getTiposPago('reporte') ,
                            $orden->textestado,$orden->montoTipo(4),
                            $orden->montoTipo(5),$orden->montoTipo(3),
                            $orden->montoTipo(Detalle::CUPON_DESCUENTO));  
			fputcsv($fp,$vals,";",'"');		
		}
		fclose($fp); 
		ini_set('memory_limit','128M'); 
		Yii::app()->end(); 
	 }


	   
        /**          
         * Obtiene el filtro con id $id          
         */

        public function actionGetFilter() {
            
            $response = array();
            if(isset($_POST['id'])){
                $filter = Filter::model()->findByPk($_POST['id']);                
                
                if($filter){                
                   
                   $response['filter']  = $filter->filterDetails;
                   $response['status'] = 'success';
                    
                }else{
                  $response['status'] = 'error';
                  $response['message'] = 'Filtro no encontrado';
                }               
                
                
            }
            
            echo CJSON::encode($response);
            
        }
        
        
        /**
         * Elimina un filtro
         * */
        
        public function actionRemoveFilter() {
            
            $response = array();
            if(isset($_POST['id'])){
                $filter = Filter::model()->findByPk($_POST['id']);                
                
                if($filter){ 
                    
                   $filter->delete(); 
                   $response['status'] = 'success';
                   $response['message'] = 'Se ha eliminado el filtro <b>'.
                           $filter->name.'</b>';
                   
                    
                }else{
                  $response['status'] = 'error';
                  $response['message'] = 'Filtro no encontrado';
                }               
                
                
            }
            
            echo CJSON::encode($response);
            
        }
        
	public function actionModalventas($id){
		
		$id=$_POST['ord'];
	  	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;		
	
		$ordhasptc= OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$id));
		$productos=Array();
		$ptc=Array();
		foreach($ordhasptc as $ohptc){				
			
				$ptc= Preciotallacolor::model()->findByPk($ohptc->preciotallacolor_id);
				$pr=Producto::model()->findByPk($ptc->producto_id);
				$var[0]=$pr->id;
				$var[1]=$ptc->id;
				$var[2]=$ohptc->precio;
				$var[3]=$ohptc->cantidad;
				array_push($productos,$var);
					
		}
		
		
		
		$html='';
		// $html=$html.'<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
  		$html=$html.'<div class="modal-header">';
    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    	$html=$html.'<h3>Vista de prendas pedidas</h3>';
  		$html=$html.'</div>';
  		$html=$html.'<div class="modal-body">';
    	$html=$html.'';
		
		
		
		
    	// Tabla ON
    	//Header de la tabla ON
   		$html=$html.'<div class="well well-small margin_top well_personaling_small"><h3>Pedido #'.$id.'</h3>';
		
      	$html=$html.'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">';
        $html=$html.'<thead><tr>';
        $html=$html.'<th scope="col">Nombre de la prenda</th>';
        $html=$html.'<th scope="col">Cantidad</th>';
        $html=$html.'<th scope="col">Precio por unidad</th>';
        $html=$html.'<th scope="col">Precio total</th>';
        $html=$html.'</tr>';
        $html=$html.'</thead><tbody>';
        
		 foreach ($productos as $idp) {
			 $producto=Producto::model()->findByPk($idp[0]);
			 $marca=Marca::model()->findByPk($producto->marca_id);
			 $ptc=PrecioTallaColor::model()->findByPk($idp[1]);
			 $talla=Talla::model()->findByPk($ptc->talla_id);
			 $color=Color::model()->findByPk($ptc->color_id);
			 $precio=Precio::model()->getPrecioDescuento($idp[0]);
			 
			  $html=$html.'<tr>';
	        // Primera columna ON
	        $html=$html.'<td><strong>'.$producto->nombre.'</strong><br/> ';
	        $html=$html.'<small><strong>Marca:</strong>'.$marca->nombre.'</small> <br/>';
	        $html=$html.'<small><strong>Color:</strong>'.$color->valor.'</small> <br/>';
	        $html=$html.'<small><strong>Talla:</strong>'.$talla->valor.'</small> <br/>';
			$html=$html.'<small><strong>REF:</strong>'.$producto->codigo.'</small> ';
	        $html=$html.'</td>';
	        // Primera columna OFF
	        // Segunda columna ON
	        $html=$html.'<td>';
			$html=$html.$idp[3];
	        $html=$html.'</td>';
	        // Segunda columna OFF
	        // Tercera columna ON
	        $html=$html.'<td>';
			$html=$html.number_format($precio, 2, ',', '.')."  Bs.";
	        $html=$html.'</td>';
	        // Tercera columna OFF
	        // Cuarta columna ON
	        $html=$html.'<td>';
			$html=$html.number_format($precio*$idp[3], 2, ',', '.')." Bs.";
	        $html=$html.'</td>';
	        // Cuarta columna OFF        

        $html=$html.'<tr>';
			 
			 
			 
			 
			 
		 }
		
		
		
		
        //Header de la tabla OFF
        //Cuerpo de la tabla ON
        /*
        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td><strong>Vestido</strong><br/> ';
        $html=$html.'<small><strong>Marca:</strong> Nidea </small> <br/>';
        $html=$html.'<small><strong>Color:</strong> Gris Rata </small> <br/>';
        $html=$html.'<small><strong>Talla:</strong> M </small> ';
        $html=$html.'</td>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'5';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'52,00 Bs.';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'104,00 Bs.';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';
        
        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td><strong>Ruana</strong><br/> ';
        $html=$html.'<small><strong>Marca:</strong> Nidea </small> <br/>';
        $html=$html.'<small><strong>Color:</strong> Horrible </small> <br/>';
        $html=$html.'<small><strong>Talla:</strong> 3 </small> ';
        $html=$html.'</td>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'5';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'520,00 Bs.';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'1040,00 Bs.';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';

        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td><strong>Vestido</strong><br/> ';
        $html=$html.'<small><strong>Marca:</strong> Nidea </small> <br/>';
        $html=$html.'<small><strong>Color:</strong> Gris Rata </small> <br/>';
        $html=$html.'<small><strong>Talla:</strong> M </small> ';
        $html=$html.'</td>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'5';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'52,00 Bs.';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'104,00 Bs.';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';        
*/
        //Cuerpo de la tabla OFF
        $html=$html.'</tbody></table></div>';
        // Tabla OFF
  		$html=$html.'</div></div>';
		echo $html;
		
		
		
	


	}

	public function actionDetalles($id)
	{
		$orden = Orden::model()->findByPk($id);  
                
                
		/*$sql="select * from tbl_zoom where cod NOT IN (select cod_zoom from tbl_ciudad where cod_zoom IS NOT NULL)";
		$zooms=Yii::app()->db->createCommand($sql)->queryAll();
	
		
		foreach ($zooms as $zoom){
				
			
			
			echo ucwords(strtolower($zoom['ciudad']))." - ".$zoom['estado']." - ".intval($zoom['estado'])."<br/>";
			if(strpos($zoom['ciudad'],'(')>0)
				$zoom['ciudad']= substr($zoom['ciudad'], 0, strpos($zoom['ciudad'],'(')); 
			   
			 
			$city=new Ciudad;
			$city->nombre=ucwords(strtolower($zoom['ciudad']));
			$city->cod_zoom=$zoom['cod'];
			$city->ruta_id=4;
			$city->provincia_id=intval($zoom['estado']);
			if(!$city->save())
				print_r($city->getErrors());
		}*/
		/*
	 * $estados=Provincia::model()->findAll();
		$i=0;
		$zoom=Zoom::model()->findAll(array('order'=>'estado'));
		
		foreach ($zoom as $ciudad){
			foreach ($estados as $estado){
				if(strtoupper($estado->nombre) == strtoupper($ciudad->estado)){
					$ciudad->estado=$estado->id;
					$ciudad->save(); 
					break;
				}
			}
		}
			*/
		
		
	
		

		$this->render('detalle', array('orden'=>$orden,));
	}

		
	public function actionFactura($id)
	{
		$factura = Factura::model()->findByPk($id);
		
		$this->render('factura', array('factura'=>$factura));
	}
	
	public function actionRecibo($id)
	{
		$factura = Factura::model()->findByPk($id);
		
		if(!UserModule::isAdmin()){
			
			if($factura->orden->user_id!=Yii::app()->user->id||!isset($factura)){
				
				$this->redirect(Yii::app()->request->baseUrl.'/orden/listado');
			}
		}
		
		$this->render('recibo', array('factura'=>$factura));
	}
	
	public function actionImprimir($id, $documento) {

            if (isset($documento)) {
                $factura = Factura::model()->findByPk($id);
                $mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L', 0, '', 15, 15, 16, 16, 9, 9, 'L');

                if ($_GET['documento'] == "factura") {
                    $mPDF1->WriteHTML($this->renderPartial('factura', array('factura' => $factura), true));
                } else if ($documento == "recibo") {
                    $mPDF1->WriteHTML($this->renderPartial('recibo', array('factura' => $factura), true));
                }

                $mPDF1->Output();
            }
        //$this->render('recibo', array('factura'=>$factura));
	}
	
	                                                                    
                                             
public function actionValidar()
	{ 
		
		// Elementos para enviar el correo, depende del estado en que quede la orden
		$message            = new YiiMailMessage;
		$message->view = "mail_template";
		 
		$detalle = Detalle::model()->findByPk($_POST['id']);
		$orden = Orden::model()->findByAttributes(array('id'=>$detalle->orden_id));
		$acumulado=$detalle->getSumxOrden();
		
		$factura = Factura::model()->findByAttributes(array('orden_id'=>$orden->id));
		
		$user = User::model()->findByPk($orden->user_id);
		//$subject = 'Recupera tu contraseña de Personaling';
		//$body = '<h2>Has solicitado cambiar tu contraseña de Personaling.</h2> Para recibir una nueva contraseña haz clic en el seiguiente link:<br/><br/> '.$activation_url;
		$porpagar=$orden->getxPagar();
			
		if($_POST['accion']=="aceptar"){
			
			$detalle->estado = 1; // aceptado
			
			if($detalle->save()){
				/*
				 * Revisando si lo depositado es > o = al total de la orden. 
				 * */
				$diferencia_pago = round(($detalle->monto - $porpagar),3,PHP_ROUND_HALF_DOWN);
				if( $diferencia_pago >= 0){
					/*
					 * Hacer varias cosas, si es igual que haga el actual proceso, si es mayor ponerlo como positivo
					 * Si es menor aceptarlo pero ponerle saldo negativo y no cambiar el estado de la orden
					 * 
					 * */
					$orden->estado = 3;
					
					if($orden->save()){
						if($factura){
							$factura->estado = 2;
							$factura->save();
							$estado = new Estado;
													
							$estado->estado = 3; // pago recibido
							$estado->user_id = Yii::app()->user->id;
							$estado->fecha = date("Y-m-d");
							$estado->orden_id = $orden->id;
									
							if($estado->save())
							{
								echo "ok";
							} else {
								Yii::trace('user id:'.Yii::app()->user->id.' Validar error:'.print_r($estado->getErrors(),true), 'registro');
							}
						}
						// Subject y body para el correo
						$subject = 'Pago aceptado';
						$body = Yii::t('contentForm','<h2>Great! Your payment has been accepted.</h2> We are preparing your order for shipment, very soon you can enjoy your purchase. <br/><br/>');
						
						$usuario = Yii::app()->user->id;
						//$excede = ($detalle->monto-$porpagar);	
						if(($diferencia_pago) > 0.5)
						{
							
						
							$balance = new Balance;
							$balance->orden_id = $orden->id;
							$balance->user_id = $orden->user_id;
							$balance->total = $diferencia_pago;
							
							$balance->save();
							$body .=  Yii::t('contentForm','We have good news, you have a balance available for {balance}',array('{balance}' => Yii::app()->numberFormatter->formatCurrency($excede, '')))." ".Yii::t('contentForm','currSym');

						} // si es mayor hace el balance
						
						/*Pagar comision a las PS involucradas en la venta*/
                                                //Orden::model()->pagarComisiones($orden); 
                                                
							// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
					
					}//orden save
				}// si el pago realizado es mayor o igual
				else{
					
					$diferencia_pago = 0-$diferencia_pago;
					$saldo = Profile::model()->getSaldo($orden->user_id);
					if($saldo>0){

						$det_bal=new Detalle;
						//$pag_bal=new Pago;
						if($saldo>$diferencia_pago){
							
							$det_bal->monto=$diferencia_pago;
							$det_bal->fecha=date("Y-m-d H:m:s");
							$det_bal->comentario="Saldo para completar";
							$det_bal->estado=1;
							$det_bal->orden_id=$orden->id;
							$det_bal->tipo_pago = 3;
							if($det_bal->save()){
								//$pag_bal->tbl_detalle_id=$det_bal->id;
								//$pag_bal->tipo=3;
								$estado = new Estado;
													
								$estado->estado = 3; // pago recibido
								$estado->user_id = Yii::app()->user->id;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
										
								if($estado->save())
								{
									//$pag_det->save();
									echo "ok";	
								}	else {
								Yii::trace('user id:'.Yii::app()->user->id.' Validar error:'.print_r($estado->getErrors(),true), 'registro');
							}
							}
												
							
							$orden->estado = 3;
							if($orden->save()){
								
								$subject = 'Pago aceptado';
								$body = Yii::t('contentForm','<h2>Great! Your payment has been accepted.</h2> We are preparing your order for shipment, very soon you can enjoy your purchase. <br/><br/>');
								
								$usuario = Yii::app()->user->id;
								
								if($factura){
									$factura->estado = 2;
									$factura->save();
								}
								$balance = new Balance;
								$balance->orden_id = $orden->id;
								$balance->user_id = $orden->user_id;
								$balance->total = 0-$diferencia_pago;
								$balance->tipo=1;
								
								$balance->save();
                                                                
                                                                /*Pagar comision a las PS involucradas en la venta*/
                                                                //Orden::model()->pagarComisiones($orden); 
									
								
							}
								
						}else{//Saldo no cubre la deuda
								
							$orden->estado = 7;
							
							if($orden->save()){
								$balance = new Balance;
								$balance->orden_id = $orden->id;
								$balance->user_id = $orden->user_id;
								$balance->total = 0-$saldo;
								$balance->tipo=1;								
								if($balance->save()){
									$subject = 'Pago insuficiente';
									$body = Yii::t('contentForm','Receiving this email Because your payment for the purchase you made ​​in Personaling.com is Insufficient. You must pay to process your order {amount} {currSym}.', array('{amount}'=>Yii::app()->numberFormatter->formatCurrency($orden->getxPagar(), ''),'{currSym}' => Yii::t('contentForm','currSym')));
									$estado = new Estado;
																
									
									$det_bal->monto=$saldo;
									$det_bal->fecha=date("Y-m-d H:m:s");
									$det_bal->comentario="Uso Saldo Falta Pago ";
									$det_bal->estado=1;
									$det_bal->orden_id=$orden->id;
									if($det_bal->save()){
										$estado->estado = 7; // pago insuficiente
									$estado->user_id = Yii::app()->user->id;
									$estado->fecha = date("Y-m-d");
									$estado->orden_id = $orden->id;
									
									if($estado->save())
									{
										echo "ok";
									} else {
								Yii::trace('user id:'.Yii::app()->user->id.' Validar error:'.print_r($estado->getErrors(),true), 'registro');
							}
									}	
								}
								
							}
						}//Saldo no cubrio la deuda
						
						
					}//Saldo positivo
					else{
						
							$subject = 'Pago insuficiente';
							$body = Yii::t('contentForm','Receiving this email Because your payment for the purchase you made ​​in Personaling.com is Insufficient. You must pay to process your order {amount} {currSym}.', array('{amount}'=>Yii::app()->numberFormatter->formatCurrency($orden->getxPagar(), ''),'{currSym}' => Yii::t('contentForm','currSym')));							
							$estado = new Estado;
																	
							$estado->estado = 7; // pago insuficiente
							$estado->user_id = Yii::app()->user->id;
							$estado->fecha = date("Y-m-d");
							$estado->orden_id = $orden->id;
							if($estado->save())
									{
										echo "ok";	
									}else {
								Yii::trace('user id:'.Yii::app()->user->id.' Validar error:'.print_r($estado->getErrors(),true), 'registro');
							}
							//if($estado->save())
							//{
								//$pag_bal->tbl_detalle_id=$det_bal->id;
								//$pag_bal->tipo=3;
								//$pag_det->save();
							//}
						
					}	
				}	
							
			}// detalle
		}else if($_POST['accion']=="rechazar"){
			$detalle = Detalle::model()->findByPk($_POST['id']);
			$detalle->estado = 2; // rechazado
			
			$orden = Orden::model()->findByPk($detalle->orden_id);
			$orden->estado = 1; // regresa a "En espera de pago"
			
			if($detalle->save()){
				if($orden->save()){
					$subject = 'Pago rechazado';
					$body = 'El pago que realizaste fue rechazado. Por favor procesa el pago nuevamente a través del sistema.<br/><br/> ';
					
					$usuario = Yii::app()->user->id; 
						
						// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
						$estado = new Estado;
											
						$estado->estado = 6; // pago rechazado
						$estado->user_id = Yii::app()->user->id;
						$estado->fecha = date("Y-m-d");
						$estado->orden_id = $orden->id;
							
						if($estado->save())
						{
							echo "ok";	
						}
				}
			}
		}
		$params              = array('subject'=>$subject, 'body'=>$body);
		$message->subject    = $subject;
		$message->setBody($params, 'text/html');                
		$message->addTo($user->email);
		$message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
		Yii::app()->mail->send($message);



	}

	/*
	 * Modal del listado
	 * 
	 * */
	public function actionModals($id)
	{
		/*	
		$id = $_GET['id'];	
		
		$orden = Orden::model()->findByPk($id);
		
		//if($orden->estado == 7){
		//	$detPago = new Detalle;
		//}
		//else {
		//	$detPago = Detalle::model()->findByPk($orden->detalle_id);
		//}
		
		$detPago = new Detalle;
		//echo $orden->getxPagar();
		//$nf = new NumberFormatter("es_VE", NumberFormatter::CURRENCY);
		//echo $nf->formatCurrency($orden->getxPagar(),'Bs.');
		//echo Yii::app()->format->unformatNumber('123,55');
		//echo Yii::app()->numberFormatter->formatCurrency($orden->getxPagar(),'Bs.');
		
		$datos="";
  		$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
		$datos=$datos."<h4> Agregar Depósito o Transferencia bancaria ya realizada</h4>";
    	$datos=$datos."</div>";
  
  		$datos=$datos."<div class='modal-body'>";
  		$datos=$datos."<form class=''>";
		$datos=$datos."<input type='hidden'id='idOrden' value='".$orden->id."' />";
		
  		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Nombre del Depositante <span class='required'>*</span></label><![endif]-->";
    	$datos=$datos."<div class='controls'>";
      	$datos=$datos. CHtml::activeTextField($detPago,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre del Depositante')) ;
		$datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Número o Código del Depósito <span class='required'>*</span></label><![endif]-->";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'nTransferencia',array('id'=>'numeroTrans','class'=>'span5','placeholder'=>'Número o Código del Depósito')) ;
		$datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Banco<span class='required'>*</span></label><![endif]-->";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeDropDownList($detPago,'banco',array('Seleccione'=>'Seleccione','Banesco'=>'Banesco. Cuenta: 0134 0277 98 2771093092'),array('id'=>'banco','class'=>'span5')); 
		//$datos=$datos. CHtml::activeTextField($detPago,'banco',array('id'=>'banco','class'=>'span5','placeholder'=>'Banco donde se realizó el deposito'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Cedula<span class='required'>*</span></label><![endif]-->";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'cedula',array('id'=>'cedula','class'=>'span5','placeholder'=>'Cedula del Depositante'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Monto (separar decimales con coma ',')<span class='required'>*</span></label><![endif]-->";
		
		$datos=$datos."<div class='controls'>";
		//$porpagar=Yii::app()->numberFormatter->formatDecimal($data->total-Detalle::model()->getSumxOrden($data->id));	
		
		
		$datos=$datos. CHtml::activeTextField($detPago,'monto',array('id'=>'monto','class'=>'span5',
                    	'placeholder'=>'Monto. Separe los decimales con una coma (,)',
                    	'value'=>Yii::app()->numberFormatter->formatDecimal($orden->getxPagar())
						)
					); 
                
		$datos=$datos. "<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='controls controls-row'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Fecha del depósito DD/MM/YYYY <span class='required'>*</span></label><![endif]-->";
		$datos=$datos. CHtml::TextField('dia','',array('id'=>'dia','class'=>'span1','placeholder'=>'Día'));
		$datos=$datos. CHtml::TextField('mes','',array('id'=>'mes','class'=>'span1','placeholder'=>'Mes')); 
		$datos=$datos. CHtml::TextField('ano','',array('id'=>'ano','class'=>'span2','placeholder'=>'Año')); 
      	$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Comentario <span class='required'>*</span></label><![endif]-->";
		
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextArea($detPago,'comentario',array('id'=>'comentario','class'=>'span5','rows'=>'6','placeholder'=>'Comentarios (Opcional)')); 
        $datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='form-actions'><a onclick='enviar()' class='btn btn-danger'>Confirmar Deposito</a></div>";
      	$datos=$datos."<p class='text_align_center'><a title='Formas de Pago' href='".Yii::app()->baseUrl."/site/formas_de_pago'> Terminos y Condiciones de Recepcion de pagos por Deposito y/o Transferencia</a><br/></p>";
    	$datos=$datos."</form>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		
		//if($orden->estado == 7){
		//	$datos=$datos."<input type='hidden' id='idDetalle' value='0' />";
		//}
		//else {
		//	$datos=$datos."<input type='hidden' id='idDetalle' value='".$orden->detalle_id."' />";
		//}
		
		$datos=$datos."<input type='hidden' id='idDetalle' value='0' />";
		echo $datos;
		 * */
		echo $this->renderPartial('_modal_pago',array('orden_id'=>$id),true,false); 
		
	}

	public function actionCancelar($id)
	{   
            
            $orden = Orden::model()->findByPK($id);            
            $response = array();
            $esAdmin = isset($_POST['admin']) || isset($_GET['admin']);
            
            $pagoHecho = $orden->estado == Orden::ESTADO_CONFIRMADO
                         || $orden->estado == Orden::ESTADO_INSUFICIENTE;   
            

            /* 
             * Si la orden esta en espera de pago la puede cancelar el usuario y el admin
             * Si esta en 2, 3, 7 (con pagos hechos). La puede cancelar solamente el admin y se devuelve
             * el dinero al usuario
             */
            if($orden->estado == Orden::ESTADO_ESPERA || $orden->estado == Orden::ESTADO_RECHAZADO ||
               ($esAdmin && $pagoHecho))
            {
                $ban = false;
                $ohptcs = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
                foreach($ohptcs as $ohptc){
                    $ptc=Preciotallacolor::model()->findByPk($ohptc->preciotallacolor_id);
                    $ptc->cantidad=$ptc->cantidad+$ohptc->cantidad; //devolver inventario
                        if($ptc->save())
                            $ban = true;
                        else{
                            print_r($ptc->getErrors());
                            $ban = false;
                            break;
                        }
                }
                
                /*Si ha pagado, devolver dinero al saldo*/
                if($pagoHecho){
                                               
                    $balance = new Balance;                    
                    $totalDevuelto = $balance->total = $orden->totalpagado;
                    $balance->orden_id = $orden->id;
                    $balance->user_id = $orden->user_id;
                    $balance->tipo = 4;
                    $balance->save();  
                }

                $orden->estado = 5;	// se canceló la orden

                if($orden->save() && $ban)
                {
                    // agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado						
                    $estado = new Estado;												
                    $estado->estado = 5;
                    $estado->user_id = Yii::app()->user->id; // quien cancelo la orden
                    $estado->fecha = date("Y-m-d H:i:s");
                    $estado->orden_id = $orden->id;

                    //Si hay un motivo de cancelacion
                    if(isset($_GET['mensaje']) && $_GET['mensaje'] != ""){
                        $estado->observacion = $_GET['mensaje'];
                    }		
                    if($estado->save())
                    {
                            Yii::app()->user->setFlash('success', 'Pedido cancelado con éxito.');                                    
                            $response["status"] = "success";
                            $response["message"] = "Pedido cancelado con éxito. <br>
                                Se han agregado <b>".Yii::app()->numberFormatter->format('#,##0.00',$totalDevuelto)." Bs.</b> al saldo del usuario</b>";
                    }
                }	
            }
            else
            {
                Yii::app()->user->setFlash('error', "No se puede cancelar el pedido.");
                $response["status"] = "error";
                $response["message"] = "No se puede cancelar el pedido";
            }
            if($esAdmin){
                echo CJSON::encode($response);
                return 0;
            }else
                    $this->redirect(array('listado'));
	}

	
	/*
	 *  Action para añadir el tracking y cambiar el estado a enviado
	 * */

		public function actionEntregar()
	{
			
		
		$orden = Orden::model()->findByPK($_POST['id']);
		if(UserModule::isAdmin()||Yii::app()->user->id==$orden->user_id)
		{

			$orden->estado=8; // Entregado
			
			if($orden->save())
				{
					
					//agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
					$estado = new Estado;
											
					$estado->estado = 8;
					$estado->user_id = Yii::app()->user->id; // 
					$estado->fecha = date("Y-m-d");
					$estado->orden_id = $orden->id;
							
						if($estado->save())
					{
						Yii::app()->user->setFlash('success',"La entrega fue registrada");
						
						
							
						
						/*	$user = User::model()->findByPk($orden->user_id);		
							$message            = new YiiMailMessage;
							$message->view = "mail_template";
							$subject = 'Tu compra en Personaling #'.$orden->id.' ha sido enviada';
							$body = "Nos complace informar que tu pedido #".$orden->id." ha sido enviado <br/>
									<br/>
									Empresa: Zoom <br/>
									Número de seguimiento: ".$orden->tracking." <br/> 
									";
							$params              = array('subject'=>$subject, 'body'=>$body);
							$message->subject    = $subject;
							$message->setBody($params, 'text/html');                
							$message->addTo($user->email);
							$message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');
							Yii::app()->mail->send($message);
							
						/*
							// Enviar correo cuando se envia la compra
							$user = User::model()->findByPk($orden->user_id);
							$message             = new YiiMailMessage;
							//this points to the file test.php inside the view path
							$message->view = "mail_template";
							$subject = 'Tu compra en Pesonaling #'.$orden->id.' ha sido enviada';
							$body = "Nos complace informarte que tu pedido #".$orden->id." ha sido enviado </br>
									</br>
									Empresa: Zoom </br>
									Número de seguimiento: ".$orden->tracking." </br> 
									";
							$params              = array('body'=>$body);
							$message->subject    = $subject;
							$message->setBody($params, 'text/html');
							$message->addTo($user->email);
							$message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');
							
							Yii::app()->mail->send($message);					
						
						
						Yii::app()->user->setFlash('success', 'Se ha enviado la orden.');
						
						echo "ok";
					}*/
						
				
				}
			else{
				
				Yii::app()->user->setFlash('success',"No se pudo registrar la Entrega");
			}	
			}
		}else
			Yii::app()->user->setFlash('success',"No esta autorizado para registrar la entrega");
		
		echo "ok";	
	}
	

	public function actionEnviar()
	{
		$orden = Orden::model()->findByPK($_POST['id']);
		$response=array();
		$orden->tracking = $_POST['guia'];
		$orden->estado=4; // enviado
		
		if($orden->save())
                {
                    // agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
                    $estado = new Estado;

                    $estado->estado = 4;
                    $estado->user_id = Yii::app()->user->id; // quien cancelo la orden
                    $estado->fecha = date("Y-m-d H:i:s");
                    $estado->orden_id = $orden->id;

                    if($estado->save())
                    {
                        $user = User::model()->findByPk($orden->user_id);		
                        $message            = new YiiMailMessage;
                        //Opciones de Mandrill
                        $message->activarPlantillaMandrill();
                        $subject = 'Tu compra en Personaling #'.$orden->id.' ha sido enviada';
                        $body = "Nos complace informarte que tu pedido #".$orden->id.
                                " esta en camino y pronto podrás disfrutar de tu compra.
                                <br/>
                                <br/>
                                ".Yii::t('contentForm','You can track your order via the Zoom page: http://www.grupozoom.com with the following tracking number: {number}',array('{number}'=>$orden->tracking))." <br/> 
                                ";
                        $message->subject    = $subject;
                        $message->setBody($body, 'text/html');                
                        $message->addTo($user->email);
                        Yii::app()->mail->send($message);
                        
//                        $message->view = "mail_template";
//                        Yii::t('contentForm','',array('{number}'=>$orden->tracking));
//                        $params              = array('subject'=>$subject, 'body'=>$body);
//                        $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');

                        Yii::app()->user->setFlash('success', 'Se ha enviado la orden.');

                        $response['status']="ok";
                    }
		}else{
		    $response['status']="error";
		}
       echo json_encode($response);
		
	}

	public function actionMensajes()
	{
		if(isset($_POST['notificar']))
			$notificar = $_POST['notificar'];
		else 
			$notificar=0;
		if(isset($_POST['visible']))
			$visible = $_POST['visible'];
		else 
			$visible=1;
			
		$mensaje = new Mensaje;
		
		$mensaje->asunto = $_POST['asunto'];
		$mensaje->cuerpo = $_POST['cuerpo'];
		$mensaje->visible = $visible; // llega 0 o 1, 1 visible, 0 no
		$mensaje->user_id = $_POST['user_id'];
		$mensaje->orden_id = $_POST['orden_id']; 
		if(isset($_POST['admin'])){
			$mensaje->admin=1;
			
		}
		$mensaje->fecha =  date('Y-m-d H:i:s', strtotime('now'));
		$mensaje->estado = 0; // sin leer
		
		if($mensaje->save())
		{
			if($notificar == 1) // pidió notificar por email 	
			{
				$usuario = User::model()->findByPk($_POST['user_id']); 
				
				$message = new YiiMailMessage;
                #$message->view = "mail_template";
                $message->activarPlantillaMandrill();
                $subject = 'Tienes un mensaje nuevo en Personaling';
                $body = '<h2>Tienes un mensaje en Personaling.</h2>' . 
                        '<br/>' .
                        'El Administrador del sistema te ha enviado un mensaje referente a tu compra <br/>'. 
                        'Ingresa con tu usuario y revisa tus notificaciones.';
				//$params = array('subject' => $subject, 'body' => $body);
                $message->subject = $subject;
                $message->setBody($body, 'text/html');
                if(is_null($mensaje->admin))
                	$message->addTo($usuario->email);
                //$message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                Yii::app()->mail->send($message);
			}		
			
			Yii::app()->user->setFlash('success', 'Se ha enviado el mensaje correctamente.');
			echo "ok";	
		}	
		
	}

	
	
	public function actionGetprendas($ord){
		$ordhasptc= OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$ord));
		$productos=Array();
		foreach($ordhasptc as $ohptc){
			$ptc= PrecioTallaColor::model()->findByPk($ohptc->preciotallacolor_id);	
			$pr=Producto::model()->findByPk($ptc->producto_id);
			array_push($productos,$pr->id);			
		}
		print_r($productos);				
	}


    public function actionCalcularenvio(){
    	
		if(isset($_POST['orden']) && isset($_POST['check']))
		{
			$orden = Orden::model()->findByPk($_POST['orden']);
			$devolver=array();
			$nproductos=0;
			$peso=0;
			$costo=0;
			$cont=0;
			$checks = explode(',',$_POST['check']); // checks va a tener los id de preciotallacolor
			
//			echo count($checks);
//                        Yii::app()->end();
			$totalenvio = 0;
			
//                        foreach($checks as $uno)
//			{echo $uno."<br>";
//                            
//                       }
//                        Yii::app()->end();
			
			$orden = Orden::model()->findByPk($_POST['orden']);
			
			foreach($checks as $uno)
			{
				
				$ptcolor = Preciotallacolor::model()->findByAttributes(array('sku'=>$uno)); 
				
				
             if($ptcolor)
				if($_POST['motivos'][$cont] == "Devolución por prenda dañada" 
                                        || $_POST['motivos'][$cont] == "Devolución por pedido equivocado")
				{
							
					array_push($devolver,$ptcolor->id);	
							
					// calculo envio
					/*
					$producto = Producto::model()->findByPk($ptcolor->producto_id);
					$peso_total = $producto->peso; 
					
					if($peso_total <= 0.5){
						$envio = 80.08;
					}else if($peso_total < 5){
						$peso_adicional = ceil($peso_total-0.5);
						$direccion = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
						$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
						$envio = 80.08 + ($peso_adicional*$ciudad_destino->ruta->precio);
										
							if($envio > 163.52){
								$envio = 163.52;
							}
							
						$tipo_guia = 1;
					}else{
							$peso_adicional = ceil($peso_total-5);
							$direccion = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
							$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
							$envio = 163.52 + ($peso_adicional*$ciudad_destino->ruta->precio);
							
						if($envio > 327.04){
							$envio = 327.04;
						}
							
						$tipo_guia = 2;
					}*/
					
				} // if motivos

				
				
				$cont++;
			} // foreach
			
			
			$ohptcs=OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));	
		
			foreach($ohptcs as $ohptc){
				
				if(!in_array($ohptc->preciotallacolor_id,$devolver)){
					$nproductos=$nproductos+$ohptc->cantidad;
					$costo=$costo+$ohptc->precio;
					$peso+=$ohptc->cantidad*$ptcolor->producto->peso;	
				}
				
			}
			
			if($peso< 5){      
							
						
						$flete=Orden::model()->calcularTarifa($orden->direccionEnvio->myciudad->cod_zoom,$nproductos,$peso,$costo);
							
							if(!is_null($flete)){
								$envio=$flete->total - $orden->flete;
					
							}else{
								$envio =Tarifa::model()->calcularEnvio($peso,$orden->direccionEnvio->myciudad->ruta_id);
								$seguro=$envio*0.13;
							}
							
							
							$tipo_guia = 1;
							
			}else{
							$peso_adicional = ceil($peso-5);
							$envio = 163.52 + ($peso*$orden->direccionEnvio->myciudad->ruta->precio);
							if($envio > 327.04){
								$envio = 327.04;
							}
							$tipo_guia = 2;
							
			}
			
					
			
			
									
//		echo Yii::app()->numberFormatter->formatCurrency($totalenvio, '');

		}	
	echo ($orden->envio-$envio);

	}

	public function actionCreateExcel(){
		
		Yii::import('ext.phpexcel.XPHPExcel');    
	
		$objPHPExcel = XPHPExcel::createPHPExcel();
	
		$objPHPExcel->getProperties()->setCreator("Personaling.com")
		                         ->setLastModifiedBy("Personaling.com")
		                         ->setTitle("plantilla-masiva-prepagada")
		                         ->setSubject("Plantilla masiva prepagada")
		                         ->setDescription("Plantilla masiva prepagada creada a través de la aplicación.")
		                         ->setKeywords("personaling")
		                         ->setCategory("personaling");
/*
			// Add some data
			$objPHPExcel->setActiveSheetIndex(0)
			            ->setCellValue('A1', 'Hello')
			            ->setCellValue('B2', 'world!')
			            ->setCellValue('C1', 'Hello')
			            ->setCellValue('D2', 'world!');
*/
			// creando el encabezado
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'REMITENTE')
						->setCellValue('A2', 'Persona Contacto')
						->setCellValue('B2', 'Teléfono')
						->setCellValue('C2', 'Dirección')
						->setCellValue('D1', 'DESTINATARIO')
						->setCellValue('D2', 'Ciudad Destino')
						->setCellValue('E2', 'Destinatarios')
						->setCellValue('F2', 'Persona Contacto')
						->setCellValue('G2', 'R.I.F/C.I')
						->setCellValue('H2', 'Teléfono')
						->setCellValue('I2', 'Dirección')
						->setCellValue('J1', 'DATOS DEL ENVIO')
						->setCellValue('J2', 'Referencia')
						->setCellValue('K2', 'Pzas')
						->setCellValue('L2', 'Peso Ref (Kg) ')
						->setCellValue('M2', 'Tipo de Envio')
						->setCellValue('N2', 'Descripción de Contenido')
						->setCellValue('O2', 'Valor Declarado (Bs)')
						->setCellValue('Q1', 'Nota:')
						->setCellValue('Q2', 'En Tipo de Envio solo debe escribir D ó M')
						->setCellValue('S1', 'D = Documento')
						->setCellValue('S2', 'M = Mercancia');	
			// encabezado end			
		 
		 	$ordenes = Orden::model()->findAllByAttributes(array('estado'=>3)); // pago confirmado
		 	$fila = 3;
			
		 	// el remitente siempre será el mismo por tanto		 	
		 	foreach($ordenes as $orden)
			{
				if($orden->peso < 5){
					$dir = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
					$prov = Provincia::model()->findByPk($dir->provincia_id);
					$usuario = User::model()->findByPk($orden->user_id);
					/*
					$peso = 0;
					$orden_ptc = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
					
					foreach($orden_ptc as $uno)
					{
						if($uno->look_id != 0){ // eslook
									
						}
						else{
							$ptaco = Preciotallacolor::model()->findByPk($uno->preciotallacolor_id);
							$producto = Producto::model()->findByPk($ptaco->producto_id);
						
							$peso += $producto->peso;
						}
					}*/
				
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila , 'PERSONALING, C.A.') // Persona Contacto
							->setCellValue('B'.$fila , '04144239902') // Teléfono
							->setCellValue('C'.$fila , 'AV BOLIVAR C.C. CM, PISO 2 OFICINA 210. MUNICIPIO MARIÑO, PORLAMAR, NUEVA ESPARTA. 6301') // Direccion
							->setCellValue('D'.$fila , $prov->nombre) // ciudad destino
							->setCellValue('E'.$fila , $usuario->profile->first_name." ".$usuario->profile->first_name) // destinatario
							->setCellValue('F'.$fila , $usuario->profile->first_name." ".$usuario->profile->first_name) // persona contacto
							->setCellValue('G'.$fila , $usuario->profile->cedula) // cedula
							->setCellValue('H'.$fila , $usuario->profile->tlf_celular) // telefono
							->setCellValue('I'.$fila , $dir->dirUno.", ".$dir->dirDos) // Direccion
							->setCellValue('J'.$fila , $orden->id) // referencia
							->setCellValue('K'.$fila , '1') // Piezas
							->setCellValue('L'.$fila , $orden->peso) // Peso ref
							->setCellValue('M'.$fila , 'M') // tipo de envio
							->setCellValue('N'.$fila , 'Ropa') // Descripcion
							->setCellValue('O'.$fila , ($orden->total - $orden->envio)); // valor declarado
					$fila++;
						
				}// orden
			} // foreach
		 
			// Rename worksheet
		//	$objPHPExcel->getActiveSheet()->setTitle('plantillamasivaprepagada');
			 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="plantillamasivaprepagada.xls"');
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
			      Yii::app()->end();
				  
	}

	// importar desde excel
	public function actionImportarMasivo()
	{

		$tabla = "";		
		
		if( isset($_POST['valido']) ){ // enviaron un archivo
			
		$archivo = CUploadedFile::getInstancesByName('url');
			
			if(isset($archivo) && count($archivo) > 0){

				foreach ($archivo as $arc => $xls) {
					
	            	$nombre = Yii::getPathOfAlias('webroot').'/docs/xlsImported/'. date('d-m-Y-H:i:s', strtotime('now')) ;
	            	$extension = '.'.$xls->extensionName;
				//	$model->banner_url = '/images/banner/'. $id .'/'. $image .$extension;
				 
			//	 if (!$model->save())	
			//			Yii::trace('username:'.$model->username.' Crear Banner Error:'.print_r($model->getErrors(),true), 'registro');										
					
		            if($xls->saveAs($nombre . $extension)){
			                Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("El archivo ha sido cargado y procesado exitosamente."));			            										            	
	            	}
					else{
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('error',UserModule::t("Error al cargar el archivo."));	
					}	            	
				}

			}
			
			// ==============================================================================
			
			$sheet_array = Yii::app()->yexcel->readActiveSheet($nombre . $extension);
 /*
			$tabla = $tabla . "<table class='table table-bordered table-hover table-striped'>";
			 
			foreach( $sheet_array as $row ) {
			    $tabla = $tabla . "<tr>";
			    
			    foreach( $row as $column )
			        $tabla = $tabla . "<td>$column</td>"; 
				
			    $tabla = $tabla . "</tr>";
			} 
			 
			$tabla = $tabla . "</table>"; */
			$tabla = $tabla ."<br/>";
		 	
			
			foreach( $sheet_array as $row ) {
				
				if($row['A']=="VENTA DE ENVIOS DE TAQUILLA" || $row['A']=="Fecha" || $row['A']==""){
					// do nothing
				}else
				{/*
					$tabla = $tabla.'fecha: '.$row['A'].
									' servicio: '.$row['B'].
									' guia: '.$row['C'].
									' referencia: '.$row['D'].
									' remitente: '.$row['E'].
									' destinatario: '.$row['F'].
									' destino: '.$row['G'].
									' peso: '.$row['H'].
									' Estatus: '.$row['I'].
									' Flete origen: '.$row['J'].
									' flete destino: '.$row['K'].
									' proteccion mercancia: '.$row['L'].
									' iva: '.$row['M'].
									' frac: '.$row['N'].
									' valor mercancia: '.$row['O'].
									' total a pagar: '.$row['P'].
					 				' usuario: '.$row['Q'].
									'<br/>';*/
									
					$status = strtolower($row['I']);
					
					if($status == "guia recibida por zoom") // se debe cambiar el estado de la orden
					{
						$orden = Orden::model()->findByPk($row['D']);
						
						if($orden->estado == 3) // pago confirmado
						{
							$orden->estado = 4; // enviado
							$orden->tracking = $row['C']; // guia
							$orden->save();
						
							$tabla .= "La orden #".$row['D']." cambió a estado Enviado. Numero de Guia: ".$row['C']." </br>"; 
						}
						
					}				
					
				}		
					
			}

			
			
		}// isset 
		
		$this->render('importar_masivo',array(
			'tabla'=>$tabla,
		));
		
	} // action


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
	
	public function actionAdminDevoluciones(){
		
		$devolucion=new Devolucion;	
		$dataProvider=new CActiveDataProvider($devolucion,array('criteria'=>array('order'=>'id DESC'),'pagination'=>array('pageSize'=>20,),));
		
		$this->render('adminDevoluciones',array('dataProvider'=>$dataProvider));
		
	}
	
	public function actionDetallesDevolucion($id){
		
		$devolucion=Devolucion::model()->findByPk($id);	
		
		
		$this->render('detallesDevolucion',array('devolucion'=>$devolucion));
		
	}
        
    public function actionGenerarExcelOut($id) {
        
        $orden = Orden::model()->findByPk($id);
        $productos = $orden->ohptc;       
                
        $encabezado = array(
            "Albaran",
            "FechaAlbaran",
            "CodigoProveedor",
            "NombreProveedor",
            "DireccionProveedor",
            "CP",
            "Poblacion",
            "Pais",
            "EAN",
            "Cantidad",
        );
        $fecha = date("Y-m-d", strtotime($orden->fecha));
        $fechaNombre = date("YmdHi");
        
        header("Content-Disposition: attachment; filename=\"Outbound$fechaNombre.csv\"");
        header("Content-Type: application/vnd.ms-excel;");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = fopen("php://output", 'w');
        
        //Crear la primera fila con encabezado.
        fputcsv($out, $encabezado);
        
        foreach ($productos as $producto) {
            $row = array();
            
            //albaran y fecha            
            $row[] = $orden->id;
            $row[] = $fecha;

            //codigo y nombre de usuario        
            $usuario = $orden->user;
            $row[] = $usuario->id;
            $row[] = $usuario->profile->getNombre();

            //Direccion
            $direccionEnvio = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
            $ciudadEnvio = Ciudad::model()->findByPk($direccionEnvio->ciudad_id);
            $provinciaEnvio = Provincia::model()->findByPk($direccionEnvio->provincia_id);
            $codigoPostal = CodigoPostal::model()->findByPk($direccionEnvio->codigo_postal_id);
            
            $row[] = $direccionEnvio->dirUno.", ".$direccionEnvio->dirDos;

            //ZIP
            if($codigoPostal){
                $row[] = $codigoPostal->codigo;                
            }else{
                $row[] = "No existe";                
            }

            //Poblacion, pais
            $row[] = $ciudadEnvio->nombre;
            $row[] = $direccionEnvio->pais;

            //sku y cantidad
            $row[] = $producto->preciotallacolor->sku;
            $row[] = $producto->cantidad;
            
            //sustituir codificacion
            $row[3] = mb_convert_encoding($row[3], 'UTF-16LE', 'UTF-8');
            $row[4] = mb_convert_encoding($row[4], 'UTF-16LE', 'UTF-8');
            $row[6] = mb_convert_encoding($row[6], 'UTF-16LE', 'UTF-8');
            $row[7] = mb_convert_encoding($row[7], 'UTF-16LE', 'UTF-8');            
            
            //Escribir en el excel
            fputcsv($out, $row);
            
        }
        
        
        fclose($out);
    }
    
    public function actionResolverOutbound() {
        
        $response = array();
        $response["message"] = Yii::t('contentForm', 'No se puede resolver la discrepancia.');
        $response["status"] = "error";
        
        if(isset($_POST["idOutbound"])){
            
            $outbound = Outbound::model()->findByPk($_POST["idOutbound"]);
            
            if($outbound && $outbound->discrepancias == 1){
                $outbound->discrepancias = 0;
                
                //si escribieron algo en la observacion
                if(isset($_POST["observacion"]) && $_POST["observacion"] != ""){
                    
                    $outbound->observacion = $_POST["observacion"];
                    
                }
                
                //marcar los productos como corregidos
                foreach($outbound->orden->ohptc as $producto){
                    if($producto->estadoLF == 2) //si tenia discrepancias marcarlo corregido
                    {
                        $producto->estadoLF = 3;
                        $producto->save();
                    }                    
                }                
                
                $outbound->save();
                
                $response["message"] = Yii::t('contentForm', 'Se han resuelto las discrepancias con éxito');                
                $response["status"] = "success";
                
            }
        }
        
        echo CJSON::encode($response);
        
    }
    
	
	public function actionDescargarReturnXml()
	{
            //Revisar la extension
            $archivo = Yii::getPathOfAlias("webroot").Devolucion::RUTA_RETURN.
                    $_GET["id"].".xml";
            $existe = file_exists($archivo);
            
            //si no existe con extension xlsx, poner xls
            if(!$existe){
                throw new CHttpException(404,'The requested page does not exist.');
            }
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=Return_'.basename($archivo));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            ob_clean();
            flush();
            readfile($archivo);
            
	}
        
        public function actionReporteDetallado(){
            
            ini_set('memory_limit','256M'); 
            
            $arrayOrdenes = Orden::model()->findAll(array(
                "order" => "id desc",
                "condition" => "id > 53"
            ));
                      
            /*Formato del titulo*/
            $title = array(
                'font' => array(

                    'size' => 12,
                    'bold' => true,
                    'color' => array(
                        'rgb' => '000000'
                    ),
                ),
                'background' => array(                    
                    'color' => array(
                        'rgb' => '246598'
                    ),
                ),
            );

            Yii::import('ext.phpexcel.XPHPExcel');    
            $objPHPExcel = XPHPExcel::createPHPExcel();

            $objPHPExcel->getProperties()->setCreator("Personaling.com")
                                     ->setLastModifiedBy("Personaling.com")
                                     ->setTitle("Reporte de Órdenes");

            // creando el encabezado
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'ID')
                        ->setCellValue('B1', 'Subtotal sin IVA')
                        ->setCellValue('C1', 'Total de IVA')
                        ->setCellValue('D1', 'Total de Descuentos')
                        ->setCellValue('E1', 'Subtotal (+Iva-Descuento)')
                        ->setCellValue('F1', 'Envio')
                        ->setCellValue('G1', 'Total')
                        ->setCellValue('H1', 'Monto por Cupón €')
                    
                        ->setCellValue('I1', 'Tipos de Pago')
                        ->setCellValue('J1', 'Monto Sabadell')
                        ->setCellValue('K1', 'Monto Paypal')
                        ->setCellValue('L1', 'Monto Balance')
                    
                        ->setCellValue('M1', 'Fecha')
                        ->setCellValue('N1', 'Nombre y Apellido')
                        ->setCellValue('O1', 'Direccion Envio')
                        ->setCellValue('P1', 'Telefono')
                        ->setCellValue('Q1', 'Codigo Postal')
                        ->setCellValue('R1', 'Email')
                        ->setCellValue('S1', 'Fecha Creación')
                        ;

            $colI = 'A';
            $colF = 'S';

            //Poner autosize todas las columnas
            foreach(range($colI,$colF) as $columnID) {

                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);

//                if($columnID)//Poner color amarillo
                    
                $objPHPExcel->getActiveSheet()->getStyle($columnID.'1')->applyFromArray($title);

            }
            
            //Agregar los productos
            $i = 2;
            foreach ($arrayOrdenes as $orden) {
                
                //Revisar el cupon
                $cuponUsado = "";
                if($orden->cupon){
                    $cuponUsado = $orden->cupon->descuento;
                }
                $tiposPago = "";
                $montoS = "";
                $montoP = "";
                $montoB = "";
                
                foreach ($orden->detalles as $detalle) {
                    $tiposPago .= $detalle->getTipoPago();
                    
                    if($detalle->tipo_pago == Detalle::TDC_AZTIVE){
                        $montoS = $detalle->monto;
                    }else if($detalle->tipo_pago == Detalle::PAYPAL_AZTIVE){
                        $montoP = $detalle->monto;                        
                    }else if($detalle->tipo_pago == Detalle::USO_BALANCE){
                        $montoB = $detalle->monto;
                    }
                        
                }
                
                $user = $orden->user;
                
                //Agregar la fila al documento xls
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.($i), $orden->id) 
                        ->setCellValue('B'.($i), $orden->subtotal)
                        ->setCellValue('C'.($i), $orden->iva)                        
                        ->setCellValue('D'.($i), $orden->descuento)                        
                        ->setCellValue('E'.($i), Yii::app()->numberFormatter->format(
                                "#,##0.00",$orden->subtotal + $orden->iva - $orden->descuento) )  
                        ->setCellValue('F'.($i), $orden->envio)                        
                        ->setCellValue('G'.($i), $orden->total)
                        ->setCellValue('H'.($i), $cuponUsado)
                        
                        ->setCellValue('I'.($i), $tiposPago)
                        ->setCellValue('J'.($i), $montoS)
                        ->setCellValue('K'.($i), $montoP)
                        ->setCellValue('L'.($i), $montoB)
                        
                        ->setCellValue('M'.($i), date("d-m-Y h:i:s a", strtotime($orden->fecha)))
                        ->setCellValue('N'.($i), $user->profile->getNombre())
                        ->setCellValue('O'.($i), $orden->direccionEnvio->dirUno)
                        ->setCellValue('P'.($i), $orden->direccionEnvio->telefono)
                        ->setCellValue('Q'.($i), $orden->direccionEnvio->codigoPostal->codigo)
                        ->setCellValue('R'.($i), $user->email)
                        ->setCellValue('S'.($i), $user->create_at)
                        ;

                $i++;
            }

            $objPHPExcel->setActiveSheetIndex(0);          

            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Reporte de Órdenes.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            Yii::app()->end();
        }


//------------------------------------   DEVOLUCIONES --------------------------------------------------------------


/*
	 * Action para las devoluciones 
	 * 
	 */	  
    
    public function actionDevolver(){
    	 $orden=$_POST['orden'];
		 $monto=$_POST['monto'];
		 
    	 $productos = explode(',',$_POST['ptcs']);
         $cantidades = explode(',',$_POST['cantidades']);
		 $indices= explode(',',$_POST['indices']);
		 $montos = explode(',',$_POST['montos']);
		 $motivos = explode(',',$_POST['motivos']);
		 $ptcs = explode(',',$_POST['ptcs']);
		 $looks = explode(',',$_POST['looks']);
		 $dhptcs=array();
		 $response = array();
		 $response['productos'] = array();
		 $i=0;
		 $out="ok";
		 $proceder=false;
		 $devolucion=new Devolucion;
		 foreach($cantidades as $cantidad){
		 	if($cantidad!=0)
			{	$dhptc= new Devolucionhaspreciotallacolor;
				if($dhptc->isValid($ptcs[$i],$cantidades[$i],$orden)){
					$dhptc->preciotallacolor_id=$ptcs[$i];
					$dhptc->cantidad=$cantidades[$i];
					$dhptc->motivo=$devolucion->getReasons($motivos[$i]);
					$dhptc->motivoAdmin=$dhptc->motivo;
					$dhptc->monto=$montos[$i];
					$dhptc->look_id=$looks[$i];
					array_push($dhptcs,$dhptc);
					$proceder=true;
					Yii::app()->user->setFlash('success', 'Su Devolución fue registrada exitosamente.');

					// datos para procesar la solicitud en analytics
					$category_product = CategoriaHasProducto::model()->findByAttributes(array('tbl_producto_id'=>$dhptc->preciotallacolor->producto->id));
					$category = Categoria::model()->findByPk($category_product->tbl_categoria_id);
	                $precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$dhptc->preciotallacolor->producto_id));

	                $response['productos'][] = array(
	                	'id'=>$dhptc->preciotallacolor->sku,
	                	'name'=>$dhptc->preciotallacolor->producto->nombre,
	                	'category'=>$category->nombre,
	                	'brand'=>$dhptc->preciotallacolor->producto->mymarca->nombre,
	                	'variant'=>$dhptc->preciotallacolor->mycolor->valor. " ". $dhptc->preciotallacolor->mytalla->valor,
	                	'price'=>$precio->precioImpuesto,
	                	'quantity'=>$dhptc->cantidad
	                );
				}
			}
			
			$i++;
		 }

		 if(!$proceder)
		 	{	Yii::app()->user->setFlash('error', 'Su Devolución no procede.');
		 		echo "no";
			}
		 else{
		 	if(count($dhptcs))
		 	{
				$devolucion->user_id=Yii::app()->user->id;
				$devolucion->orden_id=$orden;
				$devolucion->fecha=date('Y-m-d h:i:s');
				$devolucion->estado=0;
				$devolucion->montodevuelto=$monto;
				$devolucion->montoenvio=0;
				if($devolucion->save()){
					 foreach($dhptcs as $dhptc){
					 	$dhptc->devolucion_id=$devolucion->id;
						if($dhptc->save()){
							$out="ok";
						}
				}
			 }
			if($out=="ok"){
				
                            $user = User::model()->findByPk($devolucion->orden->user_id);
                            $lf="";
                            
                            $comments="Disculpa las posibles molestias ocasionadas.<br/>
                                Te recomendamos consultar nuestras politicas de devolución haciendo click 
                                <a href='http://www.personaling.es/develop/site/politicas_de_devoluciones'>aquí.</a>";
                            
                            $message            = new YiiMailMessage;
                            //Opciones de Mandrill
                            $message->activarPlantillaMandrill();                            
                            
                            $subject = 'Hemos recibido tu solicitud de devolución.';
//                            $params              = array('subject'=>$subject, 'devolucion'=>$devolucion, 'comments'=>$comments);
                            $body = $this->renderPartial("//mail/_devolucion",
                                    array('devolucion' => $devolucion,
                                        'comments' => $comments)
                                    , true);
                            $message->subject    = $subject;
                            $message->setBody($body, 'text/html');
                            $message->addTo($user->email);
//                            $message->addTo("nramirez@upsidecorp.ch");

//                            $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');
//                            $message->view = "mail_devolucion";
                            //$message->from = 'Tu Personal Shopper Digital <operaciones@personaling.com>\r\n';   
                            Yii::app()->mail->send($message);
                            if($devolucion->sendXML() && UserModule::isAdmin())
                                $lf="<br/>Devolución notificada a Logisfashion.";

                            Yii::app()->user->setFlash('success', 'Devolucion Registrada exitosamente.'.$lf);
                            if(UserModule::isAdmin())
                                $out="okadmin";
                            else
                                $out="okuser";
			}
			else
				Yii::app()->user->setFlash('error', 'Su devolución no se pudo registrar.');
			}
			//echo $out;
			$response['status'] = $out;
			echo json_encode($response);
		 }
    }
   
    public function actionDevoluciones(){
    		
		if(isset($_GET['id']))
		{	
			$orden = Orden::model()->findByPk($_GET['id']);
			if(UserModule::isAdmin()||$orden->user_id==Yii::app()->user->id)
				$this->render('devoluciones',array('orden'=>$orden));
			else {
				$this->redirect(Yii::app()->request->baseUrl.'/orden/listado');
			}
		}
        
    }

	public function actionAceptarDevolucion(){
		$devolucion=Devolucion::model()->findByPk($_POST['id']);
		$orden=Orden::model()->findByPk($devolucion->orden_id);
		$devolucion->estado=5;
		foreach($devolucion->dptcs as $dhptc){
			if(!$dhptc->rechazado)	{	
				$ohptc=OrdenHasProductotallacolor::model()->findByAttributes(array('tbl_orden_id'=>$devolucion->orden_id,'preciotallacolor_id'=>$dhptc->preciotallacolor_id));
				$ptc=Preciotallacolor::model()->findByPk($dhptc->preciotallacolor_id);
				$ohptc->cantidadActualizada=$ohptc->cantidad-$dhptc->cantidad;
				if(array_search($dhptc->motivoAdmin,Devolucion::model()->reasons)==1){
					$def=new Defectuoso;
					$def->cantidad=$dhptc->cantidad;
					$def->fecha=date("Y-m-d");
					$def->user_id=Yii::app()->user->id;
					$def->preciotallacolor_id=$dhptc->preciotallacolor_id;
					$def->procedencia="Devolucion";
					$def->costo=$ptc->producto->getCosto(false);
					$def->save();
				}else{					
					$ptc->cantidad=$ptc->cantidad+$dhptc->cantidad;
					$ptc->save();			
				}
				$ohptc->save();
			}				
		}
		$orden->totalActualizado=$orden->totalActualizado-$devolucion->montodevuelto;
		$orden->estado=9;
		if($orden->save()){
                    $estado=new Estado;
                    $estado->estado=9;
                    $estado->user_id=Yii::app()->user->id;
                    $estado->fecha=date('Y-m-d');
                    $estado->orden_id=$orden->id;

                    if($devolucion->save()){
                        $balance=new Balance;
                        $balance->total=$devolucion->montodevuelto;
                        $balance->orden_id=$devolucion->orden_id;
                        $balance->user_id=$orden->user_id;
                        $balance->tipo=4;
                        if($balance->save()){	
                            $user = User::model()->findByPk($devolucion->orden->user_id);
                            $comments = "Tu solicitud de devolución cumple con 
                                las condiciones y políticas de Personaling.es y 
                                tenemos el gusto de informarte que el monto de 
                                la misma ha sido cargado a tu saldo en nuestro portal.";	

                            $message            = new YiiMailMessage;
                            //Opciones de Mandrill
                            $message->activarPlantillaMandrill();
                            $subject = 'Tu solicitud de devolución fué aprobada.';
                            $body = $this->renderPartial("//mail/_devolucion",
                                    array('devolucion' => $devolucion,
                                        'comments' => $comments)
                                    , true);

                            $message->subject    = $subject;
                            $message->setBody($body, 'text/html');
                            $message->addTo($user->email);
                                                        
//                            $message->view = "mail_devolucion";
//                            $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');
//                            $params = array('subject'=>$subject, 'devolucion'=>$devolucion, 'comments'=>$comments);
                            //$message->from = 'Tu Personal Shopper Digital <operaciones@personaling.com>\r\n';   
                            Yii::app()->mail->send($message);


                            Yii::app()->user->setFlash('success', 'Devolución Aceptada exitosamente.');
                            echo "ok";
                        }
                    }
		}else{
			Yii::app()->user->setFlash('error', 'La devolución no pudo aceptarse.');
		}
	}
	public function actionRechazarDevolucion(){
            $devolucion=Devolucion::model()->findByPk($_POST['id']);
            $devolucion->estado=4;
            if($devolucion->save()){
                $user = User::model()->findByPk($devolucion->orden->user_id);
                $comments="Lamentamos informarte que tu solicitud de devolución no cumple con las condiciones y políticas de devoluciones de Personaling.es, para mayor información puedes comunicarte vía
                e-mail a info@personaling.com o visitar nuestro apartado de politicas de devoluciones haciendo click <a href='http://www.personaling.es/develop/site/politicas_de_devoluciones'>aquí.</a>";	
                $message            = new YiiMailMessage;
                //Opciones de Mandrill
                $message->activarPlantillaMandrill();
                   
                $subject = 'Tenemos inconvenientes para procesar tu devolución';
                $message->subject    = $subject;
                $body = $this->renderPartial("//mail/_devolucion",
                                array('devolucion' => $devolucion,
                                    'comments' => $comments)
                                , true);
                
                $message->setBody($body, 'text/html');
                $message->addTo($user->email);
//                $message->addTo("nramirez@upsidecorp.ch");
//                $message->view = "mail_devolucion";
//                $params              = array('subject'=>$subject, 'devolucion'=>$devolucion, 'comments'=>$comments);
//                $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');
                //$message->from = 'Tu Personal Shopper Digital <operaciones@personaling.com>\r\n';   
                Yii::app()->mail->send($message);

                Yii::app()->user->setFlash('success', 'Devolución Rechazada correctamente');
                echo "ok";
            }

            else 
                    {	Yii::app()->user->setFlash('error', 'La devolución no pudo rechazarse.');
                            echo "no";	}
	}
	public function actionAnularDevuelto(){
		$devuelto=Devolucionhaspreciotallacolor::model()->findByPk($_POST['id']);
		$devuelto->rechazado=1;
		if($devuelto->save())
		{
			Yii::app()->user->setFlash('success', 'Producto Anulado correctamente.');	
			echo "ok";
		}	
		else
		{
			Yii::app()->user->setFlash('error', 'El producto no pudo anularse');	
			echo "no";
		}
			
	}
	public function actionCantidadDevuelto(){
	
		$devuelto=Devolucionhaspreciotallacolor::model()->findByPk($_POST['id']);
		$devuelto->cantidad=$_POST['cantidad'];
		$devuelto->motivoAdmin=Devolucion::model()->getReasons($_POST['motivo']);
		
		if($devuelto->save())
			{	Yii::app()->user->setFlash('success', 'Actualización realizada.');
				echo "ok";}
		else
			{	Yii::app()->user->setFlash('error', 'No pudo actualizarse información.');
				echo "no";}
	}
	public function actionActivarDevuelto(){
		$devuelto=Devolucionhaspreciotallacolor::model()->findByPk($_POST['id']);
		$devuelto->rechazado=0;
		if($devuelto->save())
			{	Yii::app()->user->setFlash('success', 'Producto activado correctamente');
				echo "ok";}
		else
			{	Yii::app()->user->setFlash('success', 'Producto no pudo ser activado');
				echo "no";}
	}
	public function actionResolverItemReturn(){
		$item=ItemReturn::model()->findByPk($_POST['id']);
		$item->resuelto=1;
		if($item->save())
			{	$item->myreturn->actualizarDiscrepancias();
				Yii::app()->user->setFlash('success', 'Discrepancia Resuelta');
				echo "ok";}
		else
			{	Yii::app()->user->setFlash('success', 'Discrepancia no resuelta');
				echo "no";}
	}
	
	
	public function actionOrdenesZoho(){
		/*
		$criteria = new CDbCriteria(array('order'=>'id'));
		$criteria->addBetweenCondition('id', 1, 10);  
			
		$todas = Orden::model()->findAll($criteria);
		
		foreach($todas as $orden){ // para cada orden nuevo invoice en zoho
			
			$user = User::model()->findByPk($orden->user->id);
			
			$zoho = new ZohoSales;
								
			if($user->tipo_zoho == 0){ 
				$conv = $zoho->convertirLead($user->zoho_id, $user->email);
				$datos = simplexml_load_string($conv);
				
				var_dump($datos);
									
				$id = $datos->Contact;
				$user->zoho_id = $id;
				$user->tipo_zoho = 1;
									
				$user->save(); 
			}
								
			if($user->tipo_zoho == 1) // es ahora un contact
			{
				$respuesta = $zoho->save_potential($orden);
									
				$datos = simplexml_load_string($respuesta);
				
				var_dump($datos);
									
				$id = $datos->result[0]->recorddetail->FL[0];
									
				$orden->zoho_id = $id;
				$orden->save();  
			}	
			
		}
		*/
		
		$sumatoria = 1;
		$cont = 1;
		$xml = "";
		$ids = array();
					
		$criteria = new CDbCriteria(array('order'=>'id'));
        //    $criteria->addBetweenCondition('id', 490, 650);  
		$todasOrdenes = Orden::model()->findAll($criteria);
		
		$ordenesTotal = sizeof($todasOrdenes);
		
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Invoices>';
		
		foreach($todasOrdenes as $orden){ // para cada orden nuevo invoice en zoho
			
			$user = User::model()->findByPk($orden->user->id);
			$zoho = new ZohoSales;
			
			if($cont >= 100){
				$xml .= '</Invoices>';
				
				//var_dump($xml);
				
				$url ="https://crm.zoho.com/crm/private/xml/Invoices/insertRecords";
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
									$order = Orden::model()->findByPk($data['orden']);

									if(isset($datos->result[0]->row[$posicion]->success->details->FL[0])){
										$order->zoho_id = $datos->result[0]->row[$posicion]->success->details->FL[0];
										$order->save();
											
										echo "El row #".$data['row']." corresponde a orden ".$order->id." con id de zoho: ".$datos->result[0]->row[$posicion]->success->details->FL[0].", ".$x."<br>";
									}else{
										echo "Error en posicion ".$posicion;
									}
								}	
							}//foreach ids
					}// isset  
				$posicion++; 

				}// ciclo
					
				echo "fin de ciclo"; 
				echo "<br><br>";
				
				//var_dump($response);
				//Yii::app()->end();
				
				/* reiniciando todos los valores */
				$xml = ""; 
				$cont = 1;	
				$posicion=0;
						
				unset($ids);
				$ids = array();
						
				$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
				$xml .= '<Invoices>';		
			} // mayor a 100						
			
			if($cont < 100)
			{				
				if($user->tipo_zoho == 0){
					echo $user->email." estaba en 0<br>";
					//var_dump($xml);
					//Yii::app()->end();	
						 
					$conv = $zoho->convertirLead($user->zoho_id, $user->email);
					$datos = simplexml_load_string($conv);
											
					$id = $datos->Contact;
					$user->zoho_id = $id;
					$user->tipo_zoho = 1;
											
					$user->save(); 					
				}	
				else{
					echo $user->email." ya estaba en 1 el tipo zoho<br>";
					//var_dump($xml);
					//Yii::app()->end();	
				}
				
				/*Datos para el arreglo a comparar */
				$add = array();
				$add = array("row" => $cont, "orden" => $orden->id);
				array_push($ids,$add);
				
				
				$xml .= '<row no="'.$cont.'">';
				$xml .= '<FL val="Subject">Orden '.$orden->id.'</FL>';
				
				$detalles = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
				$envio_pago = 0;
				$ajuste=0;
				$forma="";
				$cupon=0;
				
				foreach($detalles as $detalle){
					if($envio_pago == 0){		
						if($orden->envio > 0){
							$ajuste = $ajuste + $orden->envio;
							$envio_pago = 1;
						} 
					}
					
					if($detalle->tipo_pago == 3){ 
						$ajuste -= $detalle->monto; 
						$xml .= '<FL val="Balance">'.(double)$detalle->monto.'</FL>';
					}
					
					if($detalle->tipo_pago == 4 || $detalle->tipo_pago == 5){
						$xml .= '<FL val="Paypal_Sabadell">'.(double)$detalle->monto.'</FL>';
					}
					
					$forma .= $detalle->getTipoPago().", "; 
					
					if(isset($orden->cupon)){
						if($cupon == 0){
							$ajuste -= $orden->cupon->descuento;
							$xml .= '<FL val="Cupon">'.(double)$orden->cupon->descuento.'</FL>';
							$cupon++;
						}	
					} 
				} 
					
				if((double)$orden->descuento > 0) 
					$xml .= '<FL val="Discount">'.(double)$orden->descuento.'</FL>';
				
				
                 $status = $orden->getTextEstado();

                if($status == "Devuelta<br>Finalizada")
                    $status_final = str_replace("Devuelta<br>Finalizada",'Devuelta, Finalizada' ,$status);

                if($status == "Parcialmente devuelta<br>Finalizada")
                    $status_final = str_replace("Parcialmente devuelta<br>Finalizada",'Parcialmente devuelta, Finalizada' ,$status);
                
                
		        $xml .= '<FL val="Purchase Order">'.intval($orden->id).'</FL>';
		        if(isset($status_final))
                    $xml .= '<FL val="Status">'.$status_final.'</FL>';
                else
                    $xml .= '<FL val="Status">'.$status.'</FL>';
				$xml .= '<FL val="Status">'.$orden->getTextEstado().'</FL>'; 
				$xml .= '<FL val="Invoice Date">'.date("Y-m-d",strtotime($orden->fecha)).'</FL>';
				$xml .= '<FL val="Contact Id">'.$orden->user->zoho_id.'</FL>';
				$xml .= '<FL val="Contact Name">'.$orden->user->profile->first_name.' '.$orden->user->profile->last_name.'</FL>';
				$xml .= '<FL val="Email">'.$orden->user->email.'</FL>';
				$xml .= '<FL val="Peso">'.$orden->peso.'</FL>';
				$xml .= '<FL val="Envio">'.$orden->envio.'</FL>';
				$xml .= '<FL val="Billing Street">'.$orden->direccionFacturacion->dirUno.' '.$orden->direccionFacturacion->dirDos.'</FL>';
				$xml .= '<FL val="Billing State">'.$orden->direccionFacturacion->provincia->nombre.'</FL>';
				$xml .= '<FL val="Billing City">'.$orden->direccionFacturacion->ciudad->nombre.'</FL>';
				$xml .= '<FL val="Billing Country">'.$orden->direccionFacturacion->pais.'</FL>';
				$xml .= '<FL val="Telefono Facturacion">'.$orden->direccionFacturacion->telefono.'</FL>';
				$xml .= '<FL val="Shipping Street">'.$orden->direccionFacturacion->dirUno.' '.$orden->direccionFacturacion->dirDos.'</FL>';
				$xml .= '<FL val="Shipping State">'.$orden->direccionFacturacion->provincia->nombre.'</FL>';
				$xml .= '<FL val="Shipping City">'.$orden->direccionFacturacion->ciudad->nombre.'</FL>';
				$xml .= '<FL val="Shipping Country">'.$orden->direccionFacturacion->pais.'</FL>';
				$xml .= '<FL val="Telefono Envio">'.$orden->direccionFacturacion->telefono.'</FL>';
				$xml .= '<FL val="Sub Total">'.(double)$orden->subtotal.'</FL>';
				$xml .= '<FL val="Tax">'.(double)$orden->iva.'</FL>';
				$xml .= '<FL val="Adjustment">'.(double)$ajuste.'</FL>';	
				$xml .= '<FL val="Forma de Pago">'.$forma.'</FL>'; 
				
				// productos
				$xml .= $zoho->Products($orden->id); 
				echo "Un request al relacionar productos<br>";
				// actualizar cantidades de productos
				//$zoho->actualizarCantidades($orden->id);
				//echo "Otro para actualizar cantidades<br>"; 
				
				$xml .= '<FL val="Grand Total">'.(double)$orden->total.'</FL>'; 
				$xml .= '</row>';
					
				$cont++;
					
			}// if 
			
			if($ordenesTotal == $sumatoria)
				$this->actionEnviarZoho($xml, $ids);
			else
				$sumatoria++;
			
		}
	}


	public function actionEnviarZoho($xml,$ids){
				
			$xml .= '</Invoices>'; 
			
			var_dump($xml);
			
			$url ="https://crm.zoho.com/crm/private/xml/Invoices/insertRecords";
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
				
				var_dump($response);
				Yii::app()->end();
						
				$datos = simplexml_load_string($response);
				$posicion=0;
						
				$total = sizeof($ids);
						
				for($x=1; $x<=$total; $x++){ 
					if(isset($datos->result[0]->row[$posicion])){	
						$number = $datos->result[0]->row[$posicion]->attributes()->no[0]; 
							
							foreach($ids as $data){
								if($number == $data['row']){
									$order = Orden::model()->findByPk($data['orden']);

									if(isset($datos->result[0]->row[$posicion]->success->details->FL[0])){
										$order->zoho_id = $datos->result[0]->row[$posicion]->success->details->FL[0];
										$order->save();
											
										echo "El row #".$data['row']." corresponde a orden ".$order->id." con id de zoho: ".$datos->result[0]->row[$posicion]->success->details->FL[0].", ".$x."<br>";
									}else{
										echo "Error en posicion ".$posicion;
									}
								}	
							}//foreach ids
					}// isset  
				$posicion++; 

				}// ciclo
					
				echo "fin de ciclo final";		
			
		}

        
}
