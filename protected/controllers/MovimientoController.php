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
 
				'actions'=>array('productos','pormover','confirmar'),

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
                    
                    Yii::app()->session['ptcs']=$_POST['ptcs'];
                    Yii::app()->session['vals']=$_POST['vals'];                

                             

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
                                            
                    }
                }
			$productos="PRODS";
//                $this->redirect(array('admin/compradir'));
//                $this->redirect($this->createAbsoluteUrl('bolsa/index',array(),'https'));
               	$this->render('confirmar',array('ptcs'=>$productos));

              }
					
		
	}
	
}