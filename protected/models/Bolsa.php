<?php

/**
 * This is the model class for table "{{bolsa}}".
 *
 * The followings are the available columns in table '{{bolsa}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property LookHasTblBolsa[] $lookHasTblBolsas
 * @property LookHasTblBolsa[] $lookHasTblBolsas1
 * @property Orden[] $ordens
 * @property Orden[] $ordens1
 */
class Bolsa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bolsa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bolsa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('created_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, created_on', 'safe', 'on'=>'search'),
		);
	} 

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'lookHasTblBolsas' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_bolsa_id'),
			'lookHasTblBolsas1' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_bolsa_user_id'),
			'ordens' => array(self::HAS_MANY, 'Orden', 'tbl_bolsa_id'),
			'ordens1' => array(self::HAS_MANY, 'Orden', 'user_id'),
			'bolsahasproductos' => array(self::HAS_MANY,'BolsaHasProductotallacolor','bolsa_id'),
			'countproductos' => array(self::STAT, 'BolsaHasProductotallacolor', 'bolsa_id',
            		'select' => 'SUM(cantidad)'
        		),
		); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'created_on' => 'Created On',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function actualizar() //actualiza las cantidades a los productos
	{
		$bandera = false;	
		foreach($this->bolsahasproductos as $producto)
		{
				
			if ($producto->cantidad > $producto->preciotallacolor->cantidad)
			{
				$producto->cantidad = $producto->preciotallacolor->cantidad;
				$bandera = true;
				$producto->save();
			}
		}
		//if ($bandera)
		//	$this->save();
		return $bandera;
	}
	public function hasProductos(){
                
            return $this->bolsahasproductos;
                    
                
	}
	public function checkInventario(){                
                if(!$this->bolsahasproductos){
                    return false;
                }
            
                foreach($this->bolsahasproductos as $producto)
		{
				
			if ($producto->cantidad > $producto->preciotallacolor->cantidad)
			{
				return false;
			}
		}                
		return true;
	}
	public function looks()
	{
		
		$sql = "select look_id from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$this->id." group by look_id";
		return Yii::app()->db->createCommand($sql)->queryColumn();
		
	}
	public function getLooks()
	{
		
		$sql = "
                select count(distinct(look_id)) from tbl_bolsa_has_productotallacolor 
                where look_id != 0 and bolsa_id = ".$this->id;
                
		return Yii::app()->db->createCommand($sql)->queryScalar();
		
	}

	public function getLookProducts($look_id)
	{
		
		$sql = "
                select count(*) from tbl_bolsa_has_productotallacolor 
                where look_id = ".$look_id." and bolsa_id = ".$this->id;
                
		return Yii::app()->db->createCommand($sql)->queryScalar();
		
	}

	public function getProductos()
	{
		
		$sql = "
                select count(look_id) from tbl_bolsa_has_productotallacolor 
                where look_id = 0 and bolsa_id = ".$this->id;
		return Yii::app()->db->createCommand($sql)->queryScalar();
		
	}
	
	public function deleteInactivos(){
		$return=false;
		foreach($this->bolsahasproductos as $productobolsa){
			if($productobolsa->preciotallacolor->producto->status==0 ||
                           $productobolsa->preciotallacolor->producto->estado==1 ||
                           $productobolsa->cantidad == 0){
				if($productobolsa->delete())
					$return=true; 
			}
		}
		return $return;
	}

 /*
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('bolsahasproducto');
		$criteria->group='bolsahasproducto.look_id';
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
*/	
	public function addProducto($producto_id,$talla_id,$color_id,$look_id=0)
	{
		
		$carrito = $this;
		$ptcolor = Preciotallacolor::model()->findByAttributes(array('producto_id'=>$producto_id,'talla_id'=>$talla_id,'color_id'=>$color_id));
		
		//revisar si está o no en el carrito
		
		$nuevo = BolsaHasProductotallacolor::model()->findByPk(array('bolsa_id'=>$this->id,'preciotallacolor_id'=>$ptcolor->id,'look_id'=>$look_id));
		
		if(isset($nuevo)) // existe
		{
			$cantidadnueva = $nuevo->cantidad + 1;
			BolsaHasProductotallacolor::model()->updateByPk(array('bolsa_id'=>$this->id,'preciotallacolor_id'=>$nuevo->preciotallacolor_id,'look_id'=>$look_id), array('cantidad'=>$cantidadnueva));
			return "ok";
						 
		}
		else{ // si el producto es nuevo en la bolsa
		
			$pn = new BolsaHasProductotallacolor;
			$pn->bolsa_id = $carrito->id;
			$pn->preciotallacolor_id = $ptcolor->id;
			$pn->cantidad = 1;
			if ($look_id != 0)
				$pn->look_id = $look_id;	
			if($pn->save())
			{// en bolsa tengo id de usuario e id de bolsa				
				return "ok";
			}
				
		}  
		return "fail";	
	}
        
        
        /**
         * 
         * Agrega un producto a la bolsa del Guest
         */
	public static function addProductoGuest($producto_id,$talla_id,$color_id,$look_id=0)
	{   
            
            $carrito = Yii::app()->getSession()->get("Bolsa");			
			
            $ptcolor = Preciotallacolor::model()->findByAttributes(array(
                'producto_id'=>$producto_id,
                'talla_id'=>$talla_id,
                'color_id'=>$color_id
                ));

            //revisar si está o no en el carrito
            $esta = FALSE;
            foreach ($carrito as $producto){
                if($producto->preciotallacolor_id == $ptcolor->id 
                        && $producto->look_id == $look_id){

                    $producto->cantidad++;
                    $esta = TRUE;
                }
            }

            if(!$esta){

                $nuevoProducto = new BolsaHasProductotallacolor();

                $nuevoProducto->bolsa_id = 0;
                $nuevoProducto->preciotallacolor_id = $ptcolor->id;
                $nuevoProducto->cantidad = 1;
                $nuevoProducto->look_id = $look_id;	                    
                $nuevoProducto->added_on = date("Y-m-d H:i:s");	 

                $carrito[] = $nuevoProducto;
            }

            Yii::app()->getSession()->add("Bolsa", $carrito);

	}
        
        /**
         * 
         * @param type $cantProductosGuest cantidad de productos que hay
         * en la bolsa del usuario Guest
         * @return string el texto / contenido del popover que se muestra
         * para la bolsa
         */
        public static function textoBolsaGuest($cantProductosGuest){
            
            /*
             * Esto es texto para javaScript, debe llevar los \n\ para que no
             * tome los saltos como parte de la cadena
             */
            $botonComprar = '<div class="padding_right_xsmall padding_left_xsmall \n\
            padding_bottom_xsmall"><a href="'.Yii::app()->baseUrl.'/inicio-personaling" \n\
            class="btn btn-block btn-small btn-warning">Comprar</a></div>';
            
//            text_align_center link-vaciar"><a href="'.Yii::app()->baseUrl.'/bolsa/vaciarGuest" \n\
            //agregar link de vaciar
            $botonComprar .= '<div class="padding_right_xsmall padding_left_xsmall \n\
            text_align_center link-vaciar" id="link-vaciar"><a href="#" \n\
            >Vaciar bolsa</a></div>';            
            
            //si no hay productos
            if($cantProductosGuest == 0){      
       
                $textShoppingBag = '<p class="padding_small"><strong> \n\
                Tu carrito todavía está vacío</strong>, ¿Qué esperas? Looks y prendas \n\
                increíbles esperan por ti.</p>';

            //si hay productos, construir el contenido    
            }else{
                
                $carrito = Yii::app()->getSession()->get("Bolsa");                
                $textShoppingBag = '<ul class="unstyled clearfix" >';
                        
                //Extraer los id de looks existentes
                $looksIds = array();
                foreach($carrito as $producto){
                    if($producto->look_id != 0){
                        $looksIds[$producto->look_id] = 1;                        
                    }
                }                
                $hayLooks = count($looksIds);
                $textoLooks = '';
                
                //Extraer los productos individuales
                $prodsIndividuales = array();
                foreach($carrito as $producto){
                    if($producto->look_id == 0){
                        $prodsIndividuales[] = $producto;                        
                    }
                }                
                $hayProdsIndiv = count($prodsIndividuales);                
                $textoProds = '';
                
                $contadorItems = 0; //contar items dentro del popover
                
                //Si hay looks en la bolsa
                if($hayLooks){
                    //invertir el array de ids de looks para mostrar primero al que se 
                    //agrego de ultimo a la bolsa
                    $looksIds = array_reverse(array_keys($looksIds));

                    //Armar el listado de looks dentro de la bolsa
                    foreach ($looksIds as $look_id) {

                        //para la cantidad de filas a mostrar dentro del popover
                        if ($contadorItems > 5) {
                            break;
                        }

                        $look = Look::model()->findByPk($look_id);

                        if (isset($look)) {

                            $textoLooks .= '<li><a class="btn-link" href="' . 
                                    $look->getUrl() . '" >'. addslashes($look->title) . 
                                    '</a><div class="row-fluid">';                       
                            
                            foreach ($carrito as $elementoCarrito) {

                                // buscar solo los productos dentro del carrito
                                // que le pertenezcan a $look_id                            
                                if($elementoCarrito->look_id != $look_id){
                                    continue;
                                }
                                //buscar el producto
                                $productoTallaColor = Preciotallacolor::model()->findByPk(
                                       $elementoCarrito->preciotallacolor_id);

                                $producto = Producto::model()->findByPk($productoTallaColor->producto_id);
                                $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id' =>
                                    $producto->id, 'orden' => '1'));
                                if ($imagen) {
                                    $htmlimage = CHtml::image(Yii::app()->baseUrl .'/images/'.Yii::app()->language.'/producto/'. str_replace(".","_x30.",$imagen->url), "Imagen ", array("width" => "30", "height" => "30"));
                                    $textoLooks .= '<div class="span2">' . $htmlimage . '</div>';
                                }
                            }

                            $textoLooks .= "</div> </li>";

                            $contadorItems++;
                        }
                    }
                } 
                
                //Si hay productos individuales
                if($hayProdsIndiv){
                   $prodsIndividuales = array_reverse($prodsIndividuales);
                    foreach ($prodsIndividuales as $elementoCarrito){
                        
                        if($contadorItems >= 5){
                            break;
                        }
                        
                        $productoTallaColor = Preciotallacolor::model()->findByPk(
                                        $elementoCarrito->preciotallacolor_id);
                        $producto = Producto::model()->findByPk($productoTallaColor->producto_id);
                        
                        $imagen = Imagen::model()->findByAttributes(array(
                            'tbl_producto_id'=>$producto->id,'orden'=>'1'));
                        
                        $textoProds .= '<li><a class="btn-link" href="'.
                                $producto->getUrl().'" >'.addslashes($producto->nombre).
                                '</a><div class="row-fluid">';

                        if($imagen){
                            $htmlimage = CHtml::image(Yii::app()->baseUrl .'/images/'.Yii::app()->language.'/producto/'. str_replace(".","_x30.",$imagen->url), "Imagen ", array("width" => "30", "height" => "30"));
                            $textoProds .= '<div class="span2">'.$htmlimage.'</div>';
                        }  
                        
                        $textoProds .= '</div> </li>';  
                        
                        $contadorItems++;
                        
                    }
                                   
                }
                
                //Cerrar el listado de prods y agregar el boton
                $textShoppingBag .= $textoLooks . $textoProds . '</ul>' . $botonComprar;
            }

//            echo $textShoppingBag;
//            Yii::app()->end();
            
            return $textShoppingBag;
            
        }
        
        
        /* Para pasar los productos de la bolsa GUEST a la bolsa del usuario
         * que inicia sesion
         */
        
        public static function pasarBolsaGuest($bolsaGuest){
            
            $userId = Yii::app()->user->id;
            
            //bolsa del usuario que inica sesion o se acaba de registrar
            $bolsa = Bolsa::model()->findByAttributes(array(
	                    'user_id'=> $userId, 'admin' => 0));
			
            if(!isset($bolsa)) 
            {
                    $bolsa = new Bolsa;
                    $bolsa->user_id = $userId;
                    $bolsa->created_on = date("Y-m-d H:i:s");
                    $bolsa->save();
            }
            
            //agregar cada producto a la bolsa
            foreach($bolsaGuest as $itemBolsa){
                $producto = Preciotallacolor::model()->findByPk(
                                        $itemBolsa->preciotallacolor_id);
                
                //agregarlos en la misma cantidad que estaban
                for($i=0; $i<$itemBolsa->cantidad;$i++){
                    $bolsa->addProducto($producto->producto_id, $producto->talla_id,
                            $producto->color_id, $itemBolsa->look_id);                    
                }
                                                
            }           
            
            
        }
        
        public static function isEmpty(){
            
            if(Yii::app()->user->isGuest){
                return true;
            }
            $bolsa = Bolsa::model()->findByAttributes(array(
                "user_id" => Yii::app()->user->id));
            
            return !$bolsa->bolsahasproductos;
                    
        }
        
}