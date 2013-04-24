<?php

/**
 * This is the model class for table "{{categoria}}".
 *
 * The followings are the available columns in table '{{categoria}}':
 * @property integer $id
 * @property integer $padreId
 * @property string $nombre
 * @property string $urlImagen
 * @property string $mTitulo
 * @property string $mDescripcion
 * @property string $descripcion
 * @property string $pClaves
 * @property string $urlSugerida
 * @property string $estado
 */
class Categoria extends CActiveRecord
{
	
	public $items;
	public $imagen="";
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Categoria the static model class
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
		return '{{categoria}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('padreId', 'numerical', 'integerOnly'=>true),
			array('nombre, pClaves, urlSugerida', 'length', 'max'=>100),
			array('urlImagen', 'length', 'max'=>150),
			//array('imagen', 'file', 'types'=>'jpg, gif, png'),
			array('mTitulo', 'length', 'max'=>80),
			array('mDescripcion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, padreId, nombre, urlImagen, mTitulo, mDescripcion, estado, descripcion, urlSugerida, pClaves', 'safe', 'on'=>'search'),
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
		'productos' => array(self::MANY_MANY, 'Producto', 'tbl_categoria_has_tbl_producto(tbl_categoria_id, tbl_producto_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'padreId' => 'Categoría Padre',
			'nombre' => 'Nombre',
			'urlImagen' => 'Url Imagen',
			'mTitulo' => 'Meta Titulo',
			'mDescripcion' => 'Meta Descripcion',
			'Descripcion' => 'Descripción',
			'urlSugerida' => 'Url Sugerida',
			'pClaves' => 'Palabras Claves',
			'estado' => 'Estado',
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
		$criteria->compare('padreId',$this->padreId);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('urlImagen',$this->urlImagen,true);
		$criteria->compare('mTitulo',$this->mTitulo,true);
		$criteria->compare('mDescripcion',$this->mDescripcion,true);
		$criteria->compare('Descripcion',$this->descripcion,true);
		$criteria->compare('pClaves',$this->pClaves,true);
		$criteria->compare('urlSugerida',$this->urlSugerida,true);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function beforeSave()
	{

	$valor->attributes=$_POST['Categoria'];

		if($this->padreId=='')
		{
			$this->padreId = 0;
		}
		
		echo($this->padreId);
		

	return parent::beforeSave();	
	}
	
	public function hasChildren(){
		if (Categoria::model()->findByAttributes(array('padreId'=>$this->id))){
			return true; 
		}	else {
			return false;
		}
	}
	
	public function getChildren(){
		return Categoria::model()->findAllByAttributes(array('padreId'=>$this->id));
	}
	public function childrenButtons($categorias=NULL){
		$array = array();
		$i = 0;
		foreach (Categoria::model()->findAllByAttributes(array('padreId'=>$this->id)) as $hijo){
			$array[$i]['label']=$hijo->nombre;
			$array[$i]['url'] = '#'.$hijo->id;
			if ($categorias)
				if (in_array($hijo->id, $categorias)) 
					$array[$i]['active'] = true;
			
			$i++;
		}
		return $array;
	}

	
	
}