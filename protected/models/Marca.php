<?php

/**
 * This is the model class for table "{{marca}}".
 *
 * The followings are the available columns in table '{{marca}}':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $urlImagen
 * @property string $contacto
 *  @property string $cif
 *  @property string $dirUno
 *  @property string $dirDos
 *  @property string $telefono
 *  @property string $pais
 *  @property integer $provincia_id
 *  @property integer $ciudad_id
 * @property integer $codigo_postal_id
 *  @property integer $pais
 *  *  @property integer $padreId
 *
 */
class Marca extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Marca the static model class
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
		return '{{marca}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'length', 'max'=>55),
			array('descripcion', 'length', 'max'=>250),
			array('urlImagen', 'length', 'max'=>150),
			array('urlImagen', 'required'),
			#array('nombre, descripcion, urlImagen, contacto, cif, dirUno, telefono, ciudad_id, provincia_id, pais ', 'required', 'on'=>'adicional'), //se pidio cambiar
			array('nombre, descripcion, urlImagen, contacto', 'required', 'on'=>'adicional'),
			array('descripcion', 'required', 'message'=>'No puede registrar una marca sin descripción.'),
			array('nombre', 'required', 'message'=>'No puede registrar una marca sin nombre.'),
			array('nombre', 'unique', 'message'=>'Nombre ya ha sido tomado.'),
			#array('nombre','unique','attributeName'=>'nombre','className'=>'Marca','allowEmpty'=>false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, urlImagen', 'safe', 'on'=>'search'),
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
		'productos' => array(self::HAS_MANY, 'Producto', 'marca_id'),
		'hijos' => array(self::HAS_MANY, 'Marca', 'padreId'),

		//'clasificaciones' => array(self::HAS_MANY, 'ClasificacionMarca', 'marca_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción',
			'urlImagen' => 'Url Imagen',
			'contacto'=>'Persona de Contacto',
			'cif'=>'Identificación Fiscal',
			'dirUno'=>'Dirección',
			'$dirDos'=>'Información Adicional (Dirección)',
			'telefono'=>'Teléfono',
			'pais'=>'País',
			'provincia_id'=>'Provincia',
			'ciudad_id'=>'Población',
			'codigo_postal_id'=>'Postal',
			'padreId'=>'Marca padre'

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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('urlImagen',$this->urlImagen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
		/**
	 * Mas vendidos
	 */
	 public function masvendidos($limit=10)
	 {
		
		$sql = "select sum(a.cantidad) as uno , b.id as marca from tbl_orden_has_productotallacolor a, tbl_marca b, tbl_producto c, tbl_precioTallaColor d where a.preciotallacolor_id = d.id and c.id = d.producto_id and c.marca_id = b.id group by marca_id order by uno DESC";
				
		$count = 10; 	
		
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
			 'pagination'=>array(
				'pageSize'=>$limit,
			),		    

		));  
	 }
	  
	 public function getImageUrl($thumb=false){
	 	if ($thumb){
	 		if ($this->urlImagen!='')	
	 			//$url = Yii::app()->baseUrl .'/images/marca/' . str_replace('.','_thumb.',$this->urlImagen);
	 			$url = Yii::app()->baseUrl .'/images/'.Yii::app()->language.'/marca/' . $this->id . '_thumb.jpg';
			else
			 	$url = "http://placehold.it/50";
		} else {
			if ($this->urlImagen!='')	
				$url = Yii::app()->baseUrl . '/images/'.Yii::app()->language.'/marca/' . $this->urlImagen; 
			else
				$$url = "http://placehold.it/100"; 
		}
		return $url;
	 }
	 
	 public function getMarca($id)
	 {
		$marca=Marca::model()->findByPk($id);
		return $marca->nombre;
		
	}
	 
	public function getAll(){
		$todas=Marca::model()->findAll();
		return $todas;
		
	}
	public function getMyclasificaciones(){
		$class=ClasificacionMarca::model()->findAllByAttributes(array('marca_id'=>$this->id));
		$return=array();
		if(count($class)==0)
			return null;
		else {
			foreach($class as $clas){
				array_push($return,$clas->clasificacion);
			}
			return $return;
		}
		
	}
	
	
	public function getIs_100chic($id = null){
		if(is_null($id)){
			$marca=$this;
		} 
		else{
			$marca=$this->findByPk($id);
		}
		if(!is_null($marca->myclasificaciones)){
			if(in_array(1,$this->myclasificaciones)){
					return true;						
			}
		}
		
			return false;
		
	}
	 
	 
	
	
}