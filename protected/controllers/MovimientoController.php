<?php

class MovimientoController extends Controller
{
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
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions			
 
				'actions'=>array('productos','pormover','confirmar','registraregreso','adminEgresos','defectuosos','defectuososxls'),

				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	public function actionProductos()
	{
            

			
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
				
				
				
				 
				
	            $this->render('productos', array(   'dataProvider'=>$dataProvider,
	            ));	
	   
	   }

	public function actionPorMover(){
			
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


	public function actionConfirmar(){
		if(isset($_POST['ptcs']))
            {
                 if($_POST['ptcs']!='nothing'){ //Selecciono productos
         

                             

                    /*id de preciotallacolor y su respectiva cantidad*/
                    $productos = explode(',',$_POST['ptcs']);
                    $cantidades = explode(',',$_POST['vals']);
					$ptcs=array();
                    for($i=0; $i < count($productos); $i++){

                        $idPrecioTallaColor = $productos[$i];
                        $cantidad = $cantidades[$i];

                       	array_push($ptcs,Preciotallacolor::model()->findByPk($idPrecioTallaColor));

                        

                        //Agregarlo a la bolsa tantas veces como indique la cantidad
                                            
                    }
                	$this->render('confirmar',array('ptcs'=>$ptcs,'cantidades'=>$cantidades,'ids'=>$productos));
					Yii::app()->end();
                }

//                $this->redirect(array('admin/compradir'));
//                $this->redirect($this->createAbsoluteUrl('bolsa/index',array(),'https'));
               	

              }
			 $this->redirect(array('productos'));
					
		
	}
	public function actionRegistrarEgreso(){
		$ids=explode(',',$_POST['ids']);
		$cantidades=explode(',',$_POST['cantidades']);
		$movimiento=new Movimiento;
		$movimiento->total=$_POST['total'];
		$movimiento->fecha=date('Y-m-d');
		$movimiento->user_id=Yii::app()->user->id;
		$movimiento->comentario=$_POST['comentario'];
		if($movimiento->save()){
			foreach($ids as $key=>$id){
				$mhptc=new Movimientohaspreciotallacolor;
				$ptc=Preciotallacolor::model()->findByPk($id);
				$mhptc->preciotallacolor_id=$ptc->id;
				$mhptc->cantidad=$cantidades[$key];
				$mhptc->movimiento_id=$movimiento->id;
				$mhptc->costo=$ptc->producto->getCosto(false);
				$mhptc->motivo=$movimiento->getTypes($_POST['tipo']);
				if($mhptc->save()){
					$ptc->cantidad=$ptc->cantidad-$mhptc->cantidad;
					$ptc->save();
				}
				if($_POST['tipo']){
					$defectuoso = new Defectuoso;
					$defectuoso->cantidad = $mhptc->cantidad;
					$defectuoso->fecha = date('Y-m-d');
					$defectuoso->user_id = Yii::app()->user->id;
					$defectuoso->preciotallacolor_id = $ptc->id;
					$defectuoso->preciotallacolor_id = $ptc->id;
					$defectuoso->procedencia = "Egreso desde Admin";
					$defectuoso->save();
					
				}
				
			 	
			}
			Yii::app()->user->setFlash('success', 'Egreso Registrado exitosamente.');
			echo "ok";
		}
		else {
			print_r($movimiento->errors);
			Yii::app()->user->setFlash('error', 'No se pudo registrar el egreso de mercancía.');
			echo "error";
		}
	}
	
	public function actionAdminEgresos(){
		
		$movimiento=new Movimiento;	
		$dataProvider=new CActiveDataProvider($movimiento,array('criteria'=>array('condition'=>'egreso=1','order'=>'fecha'), 'pagination'=>array('pageSize'=>20,),));
		
		$this->render('adminEgresos',array('dataProvider'=>$dataProvider));
		
	}
	public function actionDetallesEgreso($id){
		
		$movimiento=Movimiento::model()->findByPk($id);	
		
		
		$this->render('detallesEgreso',array('movimiento'=>$movimiento));
		
	}
	
	public function actionDefectuosos()
	{ 
   
		if(!isset($_GET['data_page'])){
			
			if(isset(Yii::app()->session['idMarca']))
				unset(Yii::app()->session['idMarca']);
		}		
		if(isset($_POST['marcaId'])){
			Yii::app()->session['idMarca']=$_POST['marcaId'];
		}	
			$dataProvider = Defectuoso::model()->all();
		
		
		//$orden->user_id = Yii::app()->user->id;
		
		$marcas=Marca::model()->getAll();
		$this->render('defectuosos',
		array(
		'dataProvider'=>$dataProvider,'marcas'=>$marcas
		));


	}
	
	public function actionDefectuososxls(){
	
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
		                         ->setTitle("Reporte-defectuosos")
		                         ->setSubject("Reporte de Defectuosos")
		                         ->setDescription("Reporte de Productos en existencia")
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
						->setCellValue('G1', 'Costo ('.Yii::t('contentForm','currSym').')')
						->setCellValue('H1', 'Cantidad')
						->setCellValue('I1', 'Registrado Por')
						->setCellValue('J1', 'Fecha')
						->setCellValue('K1', 'Procedencia');
			// encabezado end			
		 	
			foreach(range('A','K') as $columnID) {
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

		 	
		 	
		 	//Eliminar filtrado por marca antes de consultar
		 	/*$fake=false;
		 	if(isset(Yii::app()->session['idMarca'])){
		 		$marca=Yii::app()->session['idMarca'];
		 		$fake=true;
		 		unset(Yii::app()->session['idMarca']);
		 	}*/
			//fin			
		 	
		 	
		 	$def= Defectuoso::model()->all(false); 
		 	$fila = 2;
		
			
			//Reestablecer filtrado por marca si existia
			/*if($fake)
				Yii::app()->session['idMarca']=$marca;*/
		 	//fin	 
		 
		 	foreach($def->getData() as $data)
			{




					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila , $data['SKU']) 
							->setCellValue('B'.$fila , $data['Referencia']) 							
							->setCellValue('C'.$fila , $data['Marca']) 
							->setCellValue('D'.$fila , $data['Nombre'])
							
							->setCellValue('E'.$fila , $data['Color'])
							->setCellValue('F'.$fila , $data['Talla']) 
							->setCellValue('G'.$fila , number_format($data['Costo'],2,',','.')) 
							->setCellValue('H'.$fila , $data['Cantidad']) 
							->setCellValue('I'.$fila , $data['Usuario'])							
							->setCellValue('J'.$fila , $data['Fecha'])
							->setCellValue('K'.$fila , $data['Procedencia']);
					$fila++;

			} // foreach
		 
			// Rename worksheet
	
			$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="ReporteDefectuosos.xls"');
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
	
	
}