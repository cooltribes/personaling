<?php

/*
 * Estado = 0 activo / 1 Inactivo
 * status = 0 eliminado / 1 no eliminado
 */ 

/**
 * This is the model class for table "{{producto}}".
 *
 * The followings are the available columns in table '{{producto}}':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property integer $estado
 * @property string $descripcion
 * @property string $fInicio
 * @property string $fFin
 * @property string $fecha
 * @property integer $status
 * @property integer $destacado
 * @property integer $marca_id
 * @property integer $view_counter 
 * @property string $almacen
 * @property string $temporada
 *
 */
class Producto extends CActiveRecord
{
	const aldo='Aldo';
	const desigual='Desigual';
	const mango='Mango';
	const accessorize='Accessorize';
	const suite='SuiteBlanco';
	const helly='Helly Hansel';
	const secret='Woman Secret';
	const bimba='Bimba & Lola';
	
	
	public $horaInicio="";
	public $horaFin="";
	public $minInicio="";
	public $minFin="";
	public $uno="";
	public $dos="";
	public $categoria_id="";
	public $_precio = null;
    private $_totalVentas = null;
	public $precioNf;
    
    public function scopes()
    {
        return array(
            'noeliminados'=>array(
                'condition'=>'status=1',
            ),
            'activos'=>array(
                'condition'=>'t.estado=0',
            ),
        );
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Producto the static model class
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
		return '{{producto}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado, marca_id, view_counter, outlet', 'numerical', 'integerOnly'=>true),
			array('peso', 'numerical', 'min'=>0.1, 'tooSmall'=>'El peso debe ser mayor a 0'),
			array('codigo', 'length', 'max'=>25),
			array('nombre', 'length', 'max'=>70),
			array('nombre, codigo, marca_id, descripcion, peso', 'required','message'=>'{attribute} '.Yii::t('contentForm','cannot be blank')),
			//array('proveedor', 'length', 'max'=>45), 
			array('imagenes', 'required', 'on'=>'multi'),
			array('codigo', 'unique', 'message'=>'Código de producto ya registrado.'),
			array('descripcion, fInicio, fFin,horaInicio, horaFin, minInicio, minFin, fecha, status, peso, outlet', 'safe'),
			//array('fInicio','compare','compareValue'=>date("Y-m-d"),'operator'=>'=>'),
			array('fInicio','compare','compareValue'=>date("m/d/Y"),'operator'=>'>=','allowEmpty'=>true, 'message'=>'La fecha de inicio debe ser mayor al dia de hoy.'),
			array('fFin','compare','compareAttribute'=>'fInicio','operator'=>'>', 'allowEmpty'=>true , 'message'=>'La fecha de fin debe ser mayor a la fecha de inicio.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, nombre, estado, descripcion, marca_id, destacado, fInicio, fFin,horaInicio,horaFin,minInicio,minFin,fecha, status, peso, almacen, outlet', 'safe', 'on'=>'search'),
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
			'categorias' => array(self::MANY_MANY, 'Categoria', 'tbl_categoria_has_tbl_producto(tbl_categoria_id, tbl_producto_id)'),
			'encantan' => array(self::MANY_MANY, 'UserEncantan', 'tbl_userEncantan(producto_id, user_id)'),
			'imagenes' => array(self::HAS_MANY, 'Imagen', 'tbl_producto_id','order' => 'k.orden ASC', 'alias' => 'k'),
			'mainimage' => array(self::HAS_ONE, 'Imagen', 'tbl_producto_id','on' => 'orden=1'),
			'colorimage' => array(self::HAS_ONE, 'Imagen', 'tbl_producto_id','order'=>'k.orden ASC', 'alias' => 'k'),
			'precios' => array(self::HAS_MANY, 'Precio', 'tbl_producto_id'),
			'inventario' => array(self::HAS_ONE, 'Inventario', 'tbl_producto_id'),
			'preciotallacolor' => array(self::HAS_MANY,'Preciotallacolor','producto_id'),
			'preciotallacolorSum' => array(self::STAT, 'Preciotallacolor', 'producto_id',
                'select'=> 'SUM(cantidad)',
                ),
            'lookhasproducto' => array(self::BELONGS_TO, 'LookHasProducto','id'),
             'mymarca' => array(self::BELONGS_TO, 'Marca','marca_id'),  
             'myclasificaciones' => array(self::HAS_MANY,'ClasificacionMarca','marca_id'),  
             'mycolor' => array(self::MANY_MANY, 'Color', 'tbl_precioTallaColor(color_id, producto_id)'),                  
            'seo' => array(self::HAS_ONE, 'Seo', 'tbl_producto_id'),
		);
	}
 
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Referencia',
			'nombre' => 'Nombre / Titulo',
			'estado' => 'Estado',
			'descripcion' => 'Descripción',
			'fInicio' => 'Inicio',
			'fFin' => 'Fin',
			'fecha' => 'Fecha',
			'status' => 'Status',
			'destacado' => '¿Destacar?',
			'marca_id' => 'Marca',
			'view_counter' => 'Contador',
			'peso' => 'Peso',
			'almacen' => 'Almacen',
			'temporada' => 'Temporada',
			'outlet' => '¿Enviar al Outlet?',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('peso',$this->peso,true);
		$criteria->compare('almacen',$this->almacen,true);
		$criteria->compare('outlet',$this->outlet,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 

	public function busquedaNombreReferencia($keyword)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codigo',$keyword,true,'OR');
		$criteria->compare('nombre',$keyword,true,'OR');
		//$criteria->addSearchCondition('codigo', $query);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 

	public function busqueda($todos)
	{

		$criteria=new CDbCriteria;
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('categorias.nombre',$this->nombre,true,'OR');
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('status',$this->status,true);
		/*
		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('peso',$this->peso,true);
		*/
		
		//$criteria->with = array('categorias');
		//$criteria->with = array('precios');
		$criteria->with = array('precios','categorias');
		
		$criteria->join ='JOIN tbl_imagen ON tbl_imagen.tbl_producto_id = t.id';
		
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
		}

		$criteria->addCondition('precioDescuento != ""');
		$criteria->addCondition('orden = 1');
		
		$criteria->order = "t.id ASC";
		$criteria->group="t.id";
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	public function busquedaOLD($todos)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		//$criteria->compare('codigo',$this->codigo,true);
		//$criteria->compare('nombre',$this->nombre,true,'OR',true);
		
		$criteria->compare('t.nombre',$this->nombre,true,'OR');
		//$criteria->compare('t.descripcion',$this->nombre,true);
		$criteria->compare('categorias.nombre',$this->nombre,true,'OR');
		//$criteria->compare('preciotallacolor.color_id',4,false,'OR');
		
		//$criteria->compare('t.estado',$this->estado,true);
		//$criteria->compare('marca_id',$this->marca_id,true);
		//$criteria->compare('fInicio',$this->fInicio,true);
		//$criteria->compare('fFin',$this->fFin,true);
		//$criteria->compare('fecha',$this->fecha,true);
		//$criteria->compare('status',$this->status,true);
		//$criteria->compare('destacado',$this->destacado,true);
		//$criteria->compare('peso',$this->peso,true);
		$criteria->with = array('categorias','preciotallacolor');
		//$criteria->with = array('preciotallacolor');
		
		
		
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
					
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
		}
			
		
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>24),
       'criteria'=>$criteria,
	));
		
	}

	public function hijos($items,$op){
		
		$ids = array();
		foreach ($items as $item) {				
			if($item->hasChildren()){
				$categ = Categoria::model()->findAllByAttributes(array('padreId'=>$item->id,));
				foreach ($categ as $ca){
					array_push($ids, $ca->id);
					$op++;
				}
			}	
		}
		return $ids;
	}
	public function getPrecio($format=true)
	{
            if (is_null($this->_precio)) {
                $c = new CDbCriteria();
                $c->order = '`id` desc';
                $c->compare('tbl_producto_id', $this->id);
                $this->_precio = Precio::model()->find($c);
            }
            if (isset($this->_precio->precioDescuento))
                if ($format) {
                    return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio->precioDescuento);
                } else {
                    return $this->_precio->precioDescuento;
                }
            else
                return 0;
    } 
	
	public function getCosto($format=true)
	{
            if (is_null($this->_precio)) {
                $c = new CDbCriteria();
                $c->order = '`id` desc';
                $c->compare('tbl_producto_id', $this->id);
                $this->_precio = Precio::model()->find($c);
            }
            if (isset($this->_precio->costo))
                if ($format) {
                    return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio->costo);
                } else {
                    return $this->_precio->costo;
                }
            else
                return 0;
    }

    public function getPrecioDescuento($format=true)
	{
            if (is_null($this->_precio)) {
                $c = new CDbCriteria();
                $c->order = '`id` desc';
                $c->compare('tbl_producto_id', $this->id);
                $this->_precio = Precio::model()->find($c);
            }
            if (isset($this->_precio->precioDescuento))
                if ($format) {
                    return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio->precioDescuento);
                } else {
                    return $this->_precio->precioDescuento;
                }
            else
                return 0;
    }

    public function getPrecioImpuesto($format=true)
	{
            if (is_null($this->_precio)) {
                $c = new CDbCriteria();
                $c->order = '`id` desc';
                $c->compare('tbl_producto_id', $this->id);
                $this->_precio = Precio::model()->find($c);
            }
            if (isset($this->_precio->precioImpuesto))
                if ($format) {
                    return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio->precioImpuesto);
                } else {
                    return $this->_precio->precioImpuesto;
                }
            else
                return 0;
    }

    public function getPrecioVenta2($format=true)
	{
            if (is_null($this->_precio)) {
                $c = new CDbCriteria();
                $c->order = '`id` desc';
                $c->compare('tbl_producto_id', $this->id);
                $this->_precio = Precio::model()->find($c);
            }
            if (isset($this->_precio->precioVenta))
                if ($format) {
                    return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio->precioVenta);
                } else {
                    return $this->_precio->precioVenta;
                }
            else
                return 0;
    }

    public function getAhorro($format=true)
	{
            if (is_null($this->_precio)) {
                $c = new CDbCriteria();
                $c->order = '`id` desc';
                $c->compare('tbl_producto_id', $this->id);
                $this->_precio = Precio::model()->find($c);
            }
            if (isset($this->_precio->ahorro))
                if ($format) {
                    return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio->ahorro);
                } else {
                    return $this->_precio->ahorro;
                }
            else
                return 0;
    }
	/*
	public function getPrecioNf()
	{
	    $c = new CDbCriteria();
	    $c->order = '`id` desc';
	    $c->compare('tbl_producto_id', $this->id);
	    $temp_precio = Precio::model()->find($c);
        if (isset($temp_precio->precioImpuesto))
            return $temp_precio->precioImpuesto;
       return 0;
    }	*/
	public function getCantidad($talla=null,$color=null)
	{
	if (is_null($talla) and is_null($color))
		return $this->preciotallacolorSum;
	if (is_null($talla))
 		return $this->preciotallacolorSum(array('condition'=>'color_id=:color_id',
                      'params' => array(':color_id'=>$color)
				));	
	if (is_null($color))
 		return $this->preciotallacolorSum(array('condition'=>'talla_id = :talla_id',
                  'params' => array(':talla_id' => $talla)
			));
			 
	return $this->preciotallacolorSum(array('condition'=>'talla_id = :talla_id AND color_id=:color_id',
                  'params' => array(':talla_id' => $talla,':color_id'=>$color)
			));
	}
	public function getImageUrl($color=null,$opciones=array())
	{
		//$opciones['ext'] = isset($opciones['ext'])?$opciones['ext']:'jpg'; // valor por defecto
	 	//$opciones['type'] = isset($opciones['type'])?'_'.$opciones['type'].'.':'.'; // valor por defecto
			if (is_null($color)){
				if ($this->mainimage) return $this->mainimage->getUrl($opciones);
			}else{
				$imagecolor = $this->colorimage( array('condition'=>'color_id=:color_id','params' => array(':color_id'=>$color) ) ); 
				if ( isset( $imagecolor) ) return  $imagecolor->getUrl($opciones);
				elseif ($this->mainimage) return $this->mainimage->getUrl($opciones);
			}
			return "http://placehold.it/180";
			 
	}
	public function getColores($talla=null)
	{
		//$kwdata = Producto::model()->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color)))->findByPk($this->id);
		//foreach ($this->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color))) as $producto){
		//	$co = Color::model()->findByPk($p->color_id);
		//}
		if ($talla == null)
			$ptc = Preciotallacolor::model()->findAllByAttributes(array('producto_id'=>$this->id));
		else
			$ptc = Preciotallacolor::model()->findAllByAttributes(array('talla_id'=>$talla,'producto_id'=>$this->id));
		$datos = array();
		foreach($ptc as $p)
		{
			
			
			$ta = Color::model()->findByPk($p->color_id);
			$datos[$ta->id]=$ta->valor;
			//array_push($datos,$ta->id);
			//array_push($datos,$ta->valor); // para cada talla guardo su id y su valor
			
			
		}		
		return $datos;
	}
	public function getTallas($color)
	{
		//$kwdata = Producto::model()->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color)))->findByPk($this->id);
		//foreach ($this->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color))) as $producto){
		//	$co = Color::model()->findByPk($p->color_id);
		//}
$ptc = Preciotallacolor::model()->findAllByAttributes(array('color_id'=>$color,'producto_id'=>$this->id),'cantidad > 0');
		$datos = array();
		foreach($ptc as $p)
		{
			
			
			$ta = Talla::model()->findByPk($p->talla_id);
			$datos[$ta->id]=$ta->valor;
			//array_push($datos,$ta->id);
			//array_push($datos,$ta->valor); // para cada talla guardo su id y su valor
			
			
		}		
		return $datos;
	}
	public function beforeSave()
	{
		

		if(!$this->fInicio && !$this->fFin)
		{
			$this->fInicio = "";
			$this->fFin = "";
			
			$this->fecha = date("Y-m-d");
			
			if($this->estado=="")
				$this->estado = 1;
			
			return parent::beforeSave();
		}
		else if(($this->fInicio=="" && $this->fFin=="") || ($this->fInicio=="0000-00-00 00:00:00" && $this->fFin=="0000-00-00 00:00:00"))
		{ 
		
			$this->fInicio = "";
			$this->fFin = "";
			
			$this->fecha = date("Y-m-d");
			
			if($this->estado=="")
				$this->estado = 1;
			
			return parent::beforeSave();	
		
		}else{

			if($this->estado=="")
				$this->estado = 1;
			
		$this->fInicio=Yii::app()->dateformatter->format("yyyy-MM-dd",$this->fInicio);	
		$this->fFin=Yii::app()->dateformatter->format("yyyy-MM-dd",$this->fFin);
		
		//$this->horaInicio = $producto->horaInicio."".$producto->minInicio;
		
		$this->fecha = date("Y-m-d");
		
		$this->uno = $this->horaInicio;
		$this->dos = $this->horaFin;
		
		$this->horaInicio = substr($this->horaInicio, 0, 2); 
		$this->horaFin = substr($this->horaFin, 0, 2);
		
		$this->minInicio = substr($this->uno, 3, 2);
		$this->minFin = substr($this->dos, 3, 2);
		
		$horarioInicio = substr($this->uno, 6, 2);
		$horarioFin = substr($this->dos, 6, 2);
		
		if($horarioInicio=='AM')
			$this->fInicio= $this->fInicio.' '.$this->horaInicio.':'.$this->minInicio.':00';
		else
			{
				$this->horaInicio=$this->horaInicio+12;
				$this->fInicio= $this->fInicio.' '.$this->horaInicio.':'.$this->minInicio.':00';
			}
			
		if($horarioFin=='AM')
			$this->fFin = $this->fFin.' '.$this->horaFin.':'.$this->minFin.':00';
		else
			{
				$this->horaFin=$this->horaFin+12;
				$this->fFin = $this->fFin.' '.$this->horaFin.':'.$this->minFin.':00';
			}
				
		return parent::beforeSave();
	}
	
}


	public function busColor($idColor)
	{
		// llega un ID de color

		$criteria=new CDbCriteria;

        $criteria->select = 't.*';
        $criteria->join ='JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id';
        $criteria->addCondition('t.estado = 0');
		$criteria->addCondition('t.status = 1');
     //   $criteria->condition = 't.estado = :uno';
	//	$criteria->condition = 't.status = :dos';
		$criteria->addCondition('tbl_precioTallaColor.color_id = :tres');
	//	$criteria->condition = 'tbl_precioTallaColor.color_id = :tres';
		$criteria->addCondition('tbl_precioTallaColor.cantidad > 0'); // que haya algo en inventario		
    //    $criteria->params = array(":uno" => "2"); // estado
	//	$criteria->params = array(":dos" => "1"); // status
		$criteria->params = array(":tres" => $idColor); // color que llega
		$criteria->group = 't.id';

		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	
			
	
	
	
		
	public function ProductosLook($personal)
	{
		$sql = "SELECT c.* FROM tbl_look a, tbl_look_has_producto b, tbl_producto c where a.user_id =".$personal." and c.id = b.producto_id and a.id = b.look_id group by b.producto_id order by a.created_on DESC";
		
		$sql2 = "SELECT count( distinct b.producto_id ) as total FROM tbl_look a, tbl_look_has_producto b, tbl_producto c where a.user_id =".$personal." and c.id = b.producto_id and a.id = b.look_id order by a.created_on DESC";
		$num = Yii::app()->db->createCommand($sql2)->queryScalar();
		$count = $num;	
		
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
			 'pagination'=>array(
				'pageSize'=>9,
			),		    

		));  
	
	}
	

	public function nueva($todos)
	{

		$criteria=new CDbCriteria;
		unset(Yii::app()->session['color']);
		$criteria->compare('id',$this->id);
		
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		
		
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		
		$criteria->compare('fecha',$this->fecha,true);
		
		$criteria->compare('status',$this->status,true);
		//$criteria->compare('status',0,true);
		$criteria->compare('destacado',$this->destacado,true);

		$criteria->compare('peso',$this->peso,true);
		
		$criteria->with = array('categorias');
		$criteria->with = array('precios');
		$criteria->join ='JOIN tbl_imagen ON tbl_imagen.tbl_producto_id = t.id JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id';
		
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
				
		}
		
		$criteria->addCondition('precioDescuento != ""');
		$criteria->addCondition('orden = 1');
		
		$criteria->addCondition('cantidad > 0');
		
		// $criteria->order = "t.id ASC";
		$criteria->order = "fecha DESC";
		$criteria->group = "t.id";
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	
	
	public function multipleColor($idColor, $idact)
	{
		// llega un array de ID de color
		 
		$colores="";
		$i=0;
		$criteria=new CDbCriteria;

        $criteria->select = 't.*';
		$criteria->with = array('precios','preciotallacolor','categorias','clasificaciones');
        //$criteria->join ='JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id JOIN tbl_categoria_has_tbl_producto on tbl_categoria_has_tbl_producto.tbl_producto_id  = t.id';
        $criteria->addCondition('t.estado = 0');
		$criteria->addCondition('t.status = 1');
     //   $criteria->condition = 't.estado = :uno';
	//	$criteria->condition = 't.status = :dos';
	
	$criteria->together = true;
	
	if(is_array($idColor)){
		if(count($idColor)>0){	
			
			foreach($idColor as $col){
				if(count($idColor)==1){
					$colores='color_id = '.$col;	
					break;			
				}	
				
				if($i==0)
					$colores.='(color_id = '.$col.' ';
				
				if($i>0 && $i<count($idColor)-1)
					$colores.='OR color_id = '.$col.' ';
				
				if($i==count($idColor)-1)
					$colores.='OR color_id = '.$col.' )';
				
				$i++;
				
				Yii::app()->session['color']=1;
						
			}
			$criteria->addCondition($colores);
			
		}
	}
	
	if(isset(Yii::app()->session['idact'])){
		
		$categoria= 'tbl_categoria_id ='.$idact;
		$criteria->addCondition($categoria);
		
		
	}
	
		
	
	if(isset(Yii::app()->session['minpr'])&&isset(Yii::app()->session['maxpr'])){
		$rangopr= 'precioDescuento BETWEEN '.Yii::app()->session['minpr'].' AND '.Yii::app()->session['maxpr'];
		$criteria->addCondition($rangopr);
	}
	
	
			
	//	$criteria->condition = 'tbl_precioTallaColor.color_id = :tres';
		$criteria->addCondition('cantidad > 0'); // que haya algo en inventario		
    //    $criteria->params = array(":uno" => "2"); // estado
	//	$criteria->params = array(":dos" => "1"); // status
		$criteria->order = "fecha DESC";
		$criteria->group = 't.id';

		
		return new CActiveDataProvider($this, array(
       'criteria'=>$criteria,
       'pagination'=>array('pageSize'=>12,)
	));
		
	}
	

	public function nueva2($todos)
	{

		$criteria=new CDbCriteria;
		unset(Yii::app()->session['color']);
		$criteria->compare('id',$this->id);
		
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		
		
		$criteria->compare('marca_id',$this->marca_id,true);

		//$criteria->compare('outlet',$this->outlet,true);
		if(isset(Yii::app()->session['outlet'])){
			if(Yii::app()->session['outlet'] == 'true'){
				$criteria->compare('outlet',1,true);
			}else{
				$criteria->compare('outlet',0,true);
			}
		}else{
			//$criteria->compare('outlet',0,true);
		}
		//$criteria->compare('outlet',1,true);
		//$criteria->compare('t.estado',0,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		
		$criteria->compare('fecha',$this->fecha,true);
		
		$criteria->compare('status',$this->status,true);
		$criteria->compare('destacado',$this->destacado,true);

		$criteria->compare('peso',$this->peso,true);
		$imgsql = "SELECT tbl_producto_id FROM tbl_imagen";
       	$enImagen= Yii::app()->db->createCommand($imgsql)->queryColumn();
		$criteria->addInCondition('t.id',$enImagen);
		
		$criteria->with = array('preciotallacolor','precios','categorias', 'mymarca','mycolor');
		if(isset(Yii::app()->session['chic'])){
			$criteria->join ='JOIN tbl_clasificacion_marca ON tbl_clasificacion_marca.marca_id = t.marca_id';
			$criteria->addCondition(' tbl_clasificacion_marca.clasificacion = 1 ');
			
		}
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
				
		}
		
		
		//Filtro por color
		if(isset(Yii::app()->session['f_color'])){
			$condition = 'preciotallacolor.color_id = '.Yii::app()->session['f_color'];

			// busco si tiene colores hijos para incluirlos en la búsqueda
			$colores_hijos = Color::model()->findAllByAttributes(array('padreID'=>Yii::app()->session['f_color']));
			if(sizeof($colores_hijos) > 0){
				foreach ($colores_hijos as $hijo) {
					//echo $producto->id.' - '.$hijo->id.'<br/>';
					$condition .= ' OR preciotallacolor.color_id='.$hijo->id;
				}
			}
			$criteria->addCondition($condition);
		}
	
		//Filtro por outlet
		/*if(isset(Yii::app()->session['outlet'])){
			if(Yii::app()->session['outlet'] == 'true'){
				$criteria->addCondition('outlet = 1');
			}
		}*/
			
		//Filtro por marca
		if(isset(Yii::app()->session['f_marca'])){
			$criteria->addCondition('t.marca_id = '.Yii::app()->session['f_marca']);
		}
		
		//Filtro por categoria
		if(isset(Yii::app()->session['f_cat'])){
			$criteria->addCondition('tbl_categoria_id  = '.Yii::app()->session['f_cat']);
		}else{
			if(isset(Yii::app()->session['f_padre'])){
				$criteria->addCondition('categorias.padreId = '.Yii::app()->session['f_padre']);
			}
		}
		
		
		//------------------ BUSQUEDA POR TEXTO (marca, categoria, color, nombre de la prenda) ----------------
		$text="";
		if(isset(Yii::app()->session['f_text'])){
			if(strlen(Yii::app()->session['f_text'])>0)	{
				$words=array();
				$palabras=explode( ' ', Yii::app()->session['f_text']);
				foreach ($palabras as $palabra){
					if(substr($palabra, (strlen($palabra)-1), 1)=='s'||substr($palabra, (strlen($palabra)-1), 1)=='S')
						$palabra=substr($palabra, 0, -2);
					else
						$palabra=substr($palabra, 0, -1);
					if(strlen($palabra)>2){
						array_push($words,$palabra);
						
					}
						
				}
				foreach ($words as $key=>$word){
					if($key>0)
						$text=$text." OR ";
					$text=" categorias.nombre LIKE '%".$word."%' ";
					$text=$text."OR  mymarca.nombre LIKE '%".$word."%' ";
					$text=$text."OR  mycolor.valor LIKE '%".$word."%' ";
					$text=$text."OR  t.nombre LIKE '%".$word."%' ";
				}
			}

			//verificar outlet

			/*if(isset(Yii::app()->session['outlet'])){
					if(Yii::app()->session['outlet'] == 'true'){
						$text=$text."AND t.outlet = 1 ";
					}else{
						$text=$text."AND (t.outlet = 0 OR t.outlet = 1) ";
					}
				}else{
					$text=$text."AND (t.outlet = 0 OR t.outlet = 1) ";
				}*/

			if(strlen($text)>3)
				$criteria->addCondition($text);
		}
		//---------------------- FIN BUSQUEDA TEXTO -----------------------------------------------------------------
		 

		
		
		$criteria->addCondition('preciotallacolor.cantidad > 0');
			
		// $criteria->order = "t.id ASC";
		//------------------------- ALEATORIZAR LA VISTA PRINCIPAL -------------------------
		/*if(!isset(Yii::app()->session['f_color'])&&!isset(Yii::app()->session['f_text'])){
			$ran=rand(0,8);
			switch($ran) {
			    case 0:
			        $criteria->order = "t.fecha DESC";
			        break;
			    case 1:
			        $criteria->order = "t.fecha ASC";
			        break;
			    case 2:
			        $criteria->order = "t.descripcion DESC";
			        break;
				case 3:
			        $criteria->order = "t.descripcion ASC";
			        break;
				case 4:
			        $criteria->order = "t.view_counter DESC";
			        break;
			    case 5:
			       $criteria->order = "t.peso ASC";
			        break;
				case 6:
			        $criteria->order = "t.peso DESC";
			        break;
				case 7:
			        $criteria->order = "t.id DESC";
			        break;
				case 8:
			        $criteria->order = "t.id ASC";
			        break;
				
			}
		}*///----------------------- FIN DE ALEATORIZACION ------------------------------------------------
		//else{
			//Filtro por precio
			if(isset(Yii::app()->session['p_index'])){
				$criteria->addCondition('precioVenta > '.Yii::app()->session['min']);
				$criteria->addCondition('precioVenta < '.Yii::app()->session['max']);
				$criteria->order = "precioVenta ASC";
			}
			else
				$criteria->order = "fecha DESC";
		//     }
		$criteria->group = "t.id";
		$criteria->together = true;
		
		return $criteria;
		
	}

public function multipleColor2($idColor, $idact)
	{
		// llega un array de ID de color
		 
		$colores="";
		$i=0;
		$criteria=new CDbCriteria;

        $criteria->select = 't.*';
		$criteria->with = array('precios','preciotallacolor','categorias');
        //$criteria->join ='JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id JOIN tbl_categoria_has_tbl_producto on tbl_categoria_has_tbl_producto.tbl_producto_id  = t.id';
        $criteria->addCondition('t.estado = 0');
		$criteria->addCondition('t.status = 1');
     //   $criteria->condition = 't.estado = :uno';
	//	$criteria->condition = 't.status = :dos';
	
	$criteria->together = true;
	
	if(is_array($idColor)){
		if(count($idColor)>0){	
			
			foreach($idColor as $col){
				if(count($idColor)==1){
					$colores='color_id = '.$col;	
					break;			
				}	
				
				if($i==0)
					$colores.='(color_id = '.$col.' ';
				
				if($i>0 && $i<count($idColor)-1)
					$colores.='OR color_id = '.$col.' ';
				
				if($i==count($idColor)-1)
					$colores.='OR color_id = '.$col.' )';
				
				$i++;
				
				Yii::app()->session['color']=1;
						
			}
			$criteria->addCondition($colores);
			
		}
	}
	
	if(isset(Yii::app()->session['idact'])){
		
		$categoria= 'tbl_categoria_id ='.$idact;
		$criteria->addCondition($categoria);
		
		
	}
	if(isset(Yii::app()->session['minpr'])&&isset(Yii::app()->session['maxpr'])){
		$rangopr= 'precioDescuento BETWEEN '.Yii::app()->session['minpr'].' AND '.Yii::app()->session['maxpr'];
		$criteria->addCondition($rangopr);
	}
	
	 
			
	//	$criteria->condition = 'tbl_precioTallaColor.color_id = :tres';
		$criteria->addCondition('cantidad > 0'); // que haya algo en inventario		
    //    $criteria->params = array(":uno" => "2"); // estado
	//	$criteria->params = array(":dos" => "1"); // status
		
		$criteria->group = 't.id';

		
		return $criteria;
		
	}






	/**
	 * Mas vendidos
	 */
	 public function masvendidos($limit=10)
	 {
			
		//$sql ="SELECT SUM(tbl_orden_has_productotallacolor.cantidad) as productos,producto_id FROM db_personaling.tbl_orden_has_productotallacolor left join tbl_precioTallaColor on tbl_orden_has_productotallacolor.preciotallacolor_id = tbl_precioTallaColor.id GROUP BY producto_id ORDER by productos DESC";
		$sql = "SELECT SUM(tbl_orden_has_productotallacolor.cantidad) as productos,producto_id FROM tbl_orden_has_productotallacolor left join tbl_precioTallaColor on tbl_orden_has_productotallacolor.preciotallacolor_id = tbl_precioTallaColor.id left join tbl_imagen on tbl_precioTallaColor.producto_id = tbl_imagen.tbl_producto_id left join tbl_producto on tbl_producto.id = tbl_precioTallaColor.producto_id where tbl_imagen.orden = 1 and tbl_producto.status = 1 and tbl_producto.estado = 0 GROUP BY producto_id ORDER by productos DESC";
                 $count = count(Yii::app()->db->createCommand($sql)->query());
                
                $limit = $count && $count > $limit?$limit:$count;  
                        
                //$count = 0;		
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
			 'pagination'=>array(
				'pageSize'=>$limit,
			),		    

		));  
	 }

         /**
	 * Productos que encantan a un usuario $userId
	 */
	 public function produtosEncantan($userId)
	 {
		$criteria=new CDbCriteria;  

		$criteria->join = "JOIN tbl_userEncantan pe on pe.user_id = :userID and pe.producto_id = id";
                $criteria->params = array(":userID" => $userId);		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
				'pageSize'=>9,
			),
		));             
             
		
	 }
	 public function getPrecioVenta(){
	 	$sql="select precioVenta from tbl_precio where tbl_producto_id =".$this->id." order by id desc limit 1";
		return Yii::app()->db->createCommand($sql)->queryScalar();
	 }
         
         /**
         * Buscar por todos los filtros dados en el array $filters
         */
        public function buscarPorFiltros($filters) {
//            echo "<pre>";
//            print_r($filters);
//            echo "</pre>";
//            Yii::app()->end();

            $criteria = new CDbCriteria;
            
            $criteria->with = array();
//            $criteria->select = array();
//            $criteria->select[] = "t.*";
            
            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }                  
                
                /*Productos*/
                if($column == 'codigo')
                {
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare($column, $value,
                        true, $logicOp);
                    
                    continue;
                }
                
                if($column == 'categoria')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare('categorias.nombre', $value,
                        true, $logicOp);
                    
                    if(!in_array('categorias', $criteria->with))
                    {
                        $criteria->with[] = 'categorias';
                    }
                    
                    continue;
                }
                
                if($column == 'sku')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare('preciotallacolor.sku', $value,
                        true, $logicOp);
                    
                    if(!in_array('preciotallacolor', $criteria->with))
                    {
                        $criteria->with[] = 'preciotallacolor';
                    }
                   
                    
                    continue;
                }
                
                if($column == 'precioVenta' || $column == 'precioDescuento')
                {
                    
                    $criteria->compare('precios.'.$column, $comparator." ".$value,
                        false, $logicOp);
                    
                    if(!in_array('precios', $criteria->with))
                    {
                        $criteria->with[] = 'precios';
                    }
                    
                    continue;
                }
                
                
                if($column == 'total')
                {
                                       
                    $criteria->addCondition('(IFNULL((select SUM(ptc.cantidad) from tbl_precioTallaColor ptc where ptc.producto_id = t.id), 0)) '
                            .$comparator.' '.$value.'');
                    
                    
                    continue;
                }
                
                if($column == 'disponible')
                {
                    
                    $criteria->addCondition('
                        IFNULL((select SUM(ptc.cantidad) from tbl_precioTallaColor ptc where ptc.producto_id = t.id), 0)
                          - 
                          IFNULL(
                         (select sum(o_ptc.cantidad) from tbl_precioTallaColor ptc, tbl_orden_has_productotallacolor o_ptc, tbl_orden orden 
                          where ptc.id = o_ptc.preciotallacolor_id and orden.id = o_ptc.tbl_orden_id and 
                          orden.estado IN (3, 4, 8) and t.id = ptc.producto_id), 
                         0) '
                            .$comparator.' '.$value.'', $logicOp);
                    
                    
                    continue;
                }
                
                if($column == 'vendida')
                {
                   
                    $criteria->addCondition('(IFNULL(
                        (select sum(o_ptc.cantidad) from tbl_precioTallaColor ptc, tbl_orden_has_productotallacolor o_ptc, tbl_orden orden 
                        where ptc.id = o_ptc.preciotallacolor_id and orden.id = o_ptc.tbl_orden_id and 
                        orden.estado IN (3, 4, 8) and t.id = ptc.producto_id), 
                        0)) '
                    .$comparator.' '.$value.'', $logicOp);
                    
                    
                    continue;
                    
                }                
                
                if($column == 'ventas')
                {
                    $criteria->addCondition('IFNULL(
                        (select sum(o_ptc.precio * o_ptc.cantidad) from tbl_precioTallaColor ptc, tbl_orden_has_productotallacolor o_ptc, tbl_orden orden 
                        where ptc.id = o_ptc.preciotallacolor_id and orden.id = o_ptc.tbl_orden_id and 
                        orden.estado IN (3, 4, 8) and t.id = ptc.producto_id), 
                        0)'
                    .$comparator.' '.$value.'', $logicOp);                   
                    
                    
                    continue;
                }
                
                if($column == 'fecha')
                {
                    $value = strtotime($value);
                    $value = date('Y-m-d H:i:s', $value);
                }
                
                $criteria->compare("t.".$column, $comparator." ".$value,
                        false, $logicOp);
                
            }
                                   
             
            //$criteria->with = array('categorias', 'preciotallacolor', 'precios');
            $criteria->together = true;
            $criteria->compare('t.status', '1'); //siempre los no eliminados
            
//            echo "Criteria:";
//            
//            echo "<pre>";
//            print_r($criteria->toArray());
//            echo "</pre>"; 
//            exit();


            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }

       public function getDevueltos()
	{
		$sql = "select count(*) from tbl_orden_has_productotallacolor where devolucion_id <> 0";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}  
	
	public function getEnviados()
	{
		$sql = "select count(*) from tbl_precioTallaColor where id IN(select preciotallacolor_id from tbl_orden_has_productotallacolor WHERE tbl_orden_id IN(select id from tbl_orden where estado= 4))";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}  
	
	public function getUrl() 
	{
		//	if(isset($this->url_amigable) && $this->url_amigable != "")	
		
		if(isset($this->seo->urlAmigable) && $this->seo->urlAmigable != ""){
			return Yii::app()->baseUrl."/productos/".$this->seo->urlAmigable;
		}
		else{
			return Yii::app()->baseUrl."/producto/detalle/".$this->id;
		}	
		
	}
	public function getImgColor($id){
		$img=0;	
		if(isset(Yii::app()->session['idColor'])) // llega como parametro el id del color presionado
		{
			$colores = explode('#',Yii::app()->session['idColor']);
			
			unset($colores[0]);	
		
			
			foreach($colores as $color){
				$sql = "select id from tbl_imagen where tbl_producto_id =".$id." AND color_id = ".$color;
				$img = Yii::app()->db->createCommand($sql)->queryScalar();
				if(!is_null($img))
					break;
			}
		}
		return $img;
	}
	
	public function Next($id_actual)
	{
	    $records=NULL;
	    
	    $order="id ASC";
	
	    $records = Producto::model()->findAllByAttributes(array('status'=>1),
	    	array('select'=>'id', 'order'=>$order)
	    );
	
	    foreach($records as $i=>$r)
	       if($r->id == $id_actual)
	          if(isset($records[$i+1]->id))
			  	return $records[$i+1]->id;
			  else
			  	return NULL;
	
	    return NULL;
	}
        
        public static function masVistos($limit = 20){
            $criteria=new CDbCriteria;  		
		
            //$criteria-> compare('destacado',1);
            //$criteria->addInCondition('status', array(2, 1));
            $criteria->order = "view_counter DESC";
            return new CActiveDataProvider(__CLASS__, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                            'pageSize'=>$limit,
                    ),	
            ));
            
            
        }
        
        public function getCantVendidos()
	{
	
            return Yii::app()->getDb()->createCommand("select IFNULL(sum(o_ptc.cantidad), 0) from tbl_precioTallaColor ptc, tbl_orden_has_productotallacolor o_ptc, tbl_orden orden 
                        where ptc.id = o_ptc.preciotallacolor_id and orden.id = o_ptc.tbl_orden_id and 
                        orden.estado IN (3, 4, 8) and ".$this->id." = ptc.producto_id")->queryScalar();
		
	}
        
        public function getTotalVentas($format = true){
            /*El precio en la tabla tbl_orden_has_productotallacolor esta con IVA ? */
            
            if (is_null($this->_totalVentas)){
                $sql ="SELECT SUM(op.precio * op.cantidad) FROM tbl_orden_has_productotallacolor op, tbl_orden o, tbl_precioTallaColor pt
                    where o.estado IN (3, 4, 8)
                    AND
                    o.id = op.tbl_orden_id
                    AND
                    op.preciotallacolor_id = pt.id
                    AND
                    pt.producto_id = :id";
                $this->_totalVentas = Yii::app()->db->createCommand($sql)->queryScalar(array("id" => $this->id));
            }
            
		
            
            if ($format)
			return Yii::app()->numberFormatter->formatDecimal($this->_totalVentas);
		else
			return $this->_totalVentas;
            
             
        }
        
        public function getTallasDisponibles($id = null){
        	if(is_null($id))
				$id=$this->id;
        	$sql ="select * from tbl_talla where id in (select distinct t.talla_id from tbl_precioTallaColor t where t.producto_id = ".$id." and cantidad >0) order by orden asc";
        	return Yii::app()->db->createCommand($sql)->queryAll();
		}
        
         
		 
}
