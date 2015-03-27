<?php

/**
 * This is the model class for table "{{recomendacion}}".
 * 
 * 
 * 
 * 	El campo "estado" hace referencia a
	0 vistos (Productos, Marcas o Categorias vistas)
	1 compras (Productos, Marcas o Categorias compradas)
 *
 * The followings are the available columns in table '{{recomendacion}}':
 * @property integer $id
 * @property integer $altura
 * @property integer $contextura
 * @property integer $ojos
 * @property integer $pelo
 * @property integer $tipo_cuerpo
 * @property integer $piel
 * @property integer $producto_id 
 * 
 * The followings are the available model relations:
 * @property Producto $producto
 */
class Recomendacion extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Recomendacion the static model class
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
        return '{{recomendacion}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('altura, contextura, ojos, pelo, tipo_cuerpo, piel, producto_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, altura, contextura, ojos, pelo, tipo_cuerpo, piel, producto_id', 'safe', 'on'=>'search'),
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
            'producto' => array(self::BELONGS_TO, 'Producto', 'producto_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'altura' => 'Altura',
            'contextura' => 'Contextura',
            'ojos' => 'Ojos',
            'pelo' => 'Pelo',
            'tipo_cuerpo' => 'Tipo Cuerpo',
            'piel' => 'Piel',
            'producto_id' => 'Producto',
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
        $criteria->compare('altura',$this->altura);
        $criteria->compare('contextura',$this->contextura);
        $criteria->compare('ojos',$this->ojos);
        $criteria->compare('pelo',$this->pelo);
        $criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);
        $criteria->compare('piel',$this->piel);
        $criteria->compare('producto_id',$this->producto_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	public function recomendar($user_id = NULL)
	{
		if(is_null($user_id))
		{
			$user = User::model()->findByPk(Yii::app()->user->id);
		}else
		{
			$user = User::model()->findByPk($user_id);
		}
		//$criteria=new CDbCriteria;
        //$criteria->compare('altura',$user->profile->altura);
        $recomendaciones = Recomendacion::model()->findAll();
		$productos = array();
		
		foreach ($recomendaciones as $recomendacion) 
		{
			$contador=0;
			if($recomendacion->altura == $user->profile->altura)
			{
				$contador++;
				
			}
			if($recomendacion->contextura == $user->profile->contextura)
			{
				$contador++;
				
			}
			if($recomendacion->pelo == $user->profile->pelo)
			{
				$contador++;
				
			}
			if($recomendacion->ojos == $user->profile->ojos)
			{
				$contador++;
				
			}
			if($recomendacion->piel == $user->profile->piel)
			{
				$contador++;
				
			}
			if($recomendacion->tipo_cuerpo == $user->profile->tipo_cuerpo)
			{
				$contador++;
				
			}
			
			$categoria = 1;
			
			
			$birthDate = explode("-", $user->profile->birthday);
				  //get age from date or birthdate
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[2]) - 1)
				: (date("Y") - $birthDate[2]));
			
			
			switch($age) 
			{
			   case in_array($age, range(21,30)): 
			      $categoria = 2;
			   break;
			   case in_array($age, range(31,35)): 
			      $categoria = 3;
			   break;
			    case in_array($age, range(36,40)): 
			      $categoria = 4;
			   break;
			    case in_array($age, range(41,45)): 
			      $categoria = 5;
			   break;
			    case in_array($age, range(46,50)): 
			      $categoria = 6;
			   break;
			    case in_array($age, range(51,55)): 
			      $categoria = 7;
			   break;
			    case in_array($age, range(56,60)): 
			      $categoria = 8;
			   break;
			    case in_array($age, range(61,80)): 
			      $categoria = 9;
			   break;
			}
			
			
			if($recomendacion->edad == $categoria)
			{
				$contador++;
				
			}
			 
			if($contador >= 2)
			{
				$criteria = new CDbCriteria();
				//$criteria->addCondition('id='.$recomendacion->producto_id);
				$criteria->addCondition('estado=0');
				$criteria->addCondition('status=1');
				
				if($recomendacion->producto_id)
				{
					#$producto = Producto::model()->findByAttributes(array('id'=>$recomendacion->producto_id,'estado'=>0,'status'=>1), array('distinct'=>true));	
					$producto = Producto::model()->findByPk($recomendacion->producto_id);
					if(!in_array($producto, $productos) && $producto->estado==0 && $producto->status==1)
					{
							
						$productos[]=$producto;	
							
					}
				
				}

			}	
			
		}
		
		if(sizeof($productos)>6)
		{
			$keys = array_rand ( $productos , 6);
			$productos_new = array();
			foreach ($keys as $key)
			{
				$productos_new[] = $productos[$key];
			}
			
			return $productos_new;
			
			
		}else{
			
			return $productos;

		}
		
	
	}

	public function recomendarMarca($user_id = NULL)
	{
		if(is_null($user_id))
		{
			$user = User::model()->findByPk(Yii::app()->user->id);
		}else
		{
			$user = User::model()->findByPk($user_id);
		}
		//$criteria=new CDbCriteria;
        //$criteria->compare('altura',$user->profile->altura);
        $recomendaciones = Recomendacion::model()->findAll();
		$productos = array();
		
		foreach ($recomendaciones as $recomendacion) 
		{
			$contador=0;
			if($recomendacion->altura == $user->profile->altura)
			{
				$contador++;
				
			}
			if($recomendacion->contextura == $user->profile->contextura)
			{
				$contador++;
				
			}
			if($recomendacion->pelo == $user->profile->pelo)
			{
				$contador++;
				
			}
			if($recomendacion->ojos == $user->profile->ojos)
			{
				$contador++;
				
			}
			if($recomendacion->piel == $user->profile->piel)
			{
				$contador++;
				
			}
			if($recomendacion->tipo_cuerpo == $user->profile->tipo_cuerpo)
			{
				$contador++;
				
			}
			
			$categoria = 1;
			
			
			$birthDate = explode("-", $user->profile->birthday);
				  //get age from date or birthdate
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[2]) - 1)
				: (date("Y") - $birthDate[2]));
			
			
			switch($age) 
			{
			   case in_array($age, range(21,30)): 
			      $categoria = 2;
			   break;
			   case in_array($age, range(31,35)): 
			      $categoria = 3;
			   break;
			    case in_array($age, range(36,40)): 
			      $categoria = 4;
			   break;
			    case in_array($age, range(41,45)): 
			      $categoria = 5;
			   break;
			    case in_array($age, range(46,50)): 
			      $categoria = 6;
			   break;
			    case in_array($age, range(51,55)): 
			      $categoria = 7;
			   break;
			    case in_array($age, range(56,60)): 
			      $categoria = 8;
			   break;
			    case in_array($age, range(61,80)): 
			      $categoria = 9;
			   break;
			}
			
			
			if($recomendacion->edad == $categoria)
			{
				$contador++;
				
			}
			 
			if($contador >= 2)
			{
				$criteria = new CDbCriteria();
				//$criteria->addCondition('id='.$recomendacion->producto_id);
				$criteria->addCondition('estado=0');
				$criteria->addCondition('status=1');
				if($recomendacion->marca_id)
				{
					$marca = Marca::model()->findByPk($recomendacion->marca_id);
					$producto_array = Producto::model()->findAllByAttributes(array('marca_id'=>$marca->id));
					foreach ($producto_array as $producto) {
						if(!in_array($producto, $productos) && $producto->estado==0 && $producto->status==1)
						{
							
							$productos[]=$producto;	
							
						}
					}
					
				
				}
				
				
				
			}	
			
		}
		
		if(sizeof($productos)>6)
		{
			$keys = array_rand ( $productos , 6);
			$productos_new = array();
			foreach ($keys as $key)
			{
				$productos_new[] = $productos[$key];
			}
			
			return $productos_new;
			
			
		}else{
			
			return $productos;

		}
		
	
	}
	
	public function recomendarCategoria($user_id = NULL)
	{
		if(is_null($user_id))
		{
			$user = User::model()->findByPk(Yii::app()->user->id);
		}else
		{
			$user = User::model()->findByPk($user_id);
		}
		//$criteria=new CDbCriteria;
        //$criteria->compare('altura',$user->profile->altura);
        $recomendaciones = Recomendacion::model()->findAll();
		$productos = array();
		
		foreach ($recomendaciones as $recomendacion) 
		{
			$contador=0;
			if($recomendacion->altura == $user->profile->altura)
			{
				$contador++;
				
			}
			if($recomendacion->contextura == $user->profile->contextura)
			{
				$contador++;
				
			}
			if($recomendacion->pelo == $user->profile->pelo)
			{
				$contador++;
				
			}
			if($recomendacion->ojos == $user->profile->ojos)
			{
				$contador++;
				
			}
			if($recomendacion->piel == $user->profile->piel)
			{
				$contador++;
				
			}
			if($recomendacion->tipo_cuerpo == $user->profile->tipo_cuerpo)
			{
				$contador++;
				
			}
			
			$categoria = 1;
			
			
			$birthDate = explode("-", $user->profile->birthday);
				  //get age from date or birthdate
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[2]) - 1)
				: (date("Y") - $birthDate[2]));
			
			
			switch($age) 
			{
			   case in_array($age, range(21,30)): 
			      $categoria = 2;
			   break;
			   case in_array($age, range(31,35)): 
			      $categoria = 3;
			   break;
			    case in_array($age, range(36,40)): 
			      $categoria = 4;
			   break;
			    case in_array($age, range(41,45)): 
			      $categoria = 5;
			   break;
			    case in_array($age, range(46,50)): 
			      $categoria = 6;
			   break;
			    case in_array($age, range(51,55)): 
			      $categoria = 7;
			   break;
			    case in_array($age, range(56,60)): 
			      $categoria = 8;
			   break;
			    case in_array($age, range(61,80)): 
			      $categoria = 9;
			   break;
			}
			
			
			if($recomendacion->edad == $categoria)
			{
				$contador++;
				
			}
			 
			if($contador >= 2)
			{
				$criteria = new CDbCriteria();
				//$criteria->addCondition('id='.$recomendacion->producto_id);
				$criteria->addCondition('estado=0');
				$criteria->addCondition('status=1');
				if($recomendacion->categoria_id)
				{
					
					$categoria = Categoria::model()->findByPk($recomendacion->categoria_id);					
					#$producto_array = Producto::model()->findAllByAttributes(array('marca_id'=>$marca->id));
					$productos_categoria = CategoriaHasProducto::model()->findAllByAttributes(array('tbl_categoria_id'=>$categoria->id));
					
					foreach($productos_categoria as $proCat)
					{
						
						$producto = Producto::model()->findByPk($proCat->tbl_producto_id);
						if(!in_array($producto, $productos) && $producto->estado==0 && $producto->status==1)
						{
							$productos[]=$producto;
							
						}	
					}
					
				
				}				
				
				
			}	
			
		}
		
		if(sizeof($productos)>6)
		{
			$keys = array_rand ( $productos , 6);
			$productos_new = array();
			foreach ($keys as $key)
			{
				$productos_new[] = $productos[$key];
			}
			
			return $productos_new;
			
			
		}else{
			
			return $productos;

		}
		
	
	}


}