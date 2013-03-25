<?php

/**
 * This is the model class for table "{{look}}".
 *
 * The followings are the available columns in table '{{look}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $altura
 * @property integer $contextura
 * @property integer $pelo
 * @property integer $ojos
 * @property integer $tipo_cuerpo
 * @property integer $piel
 * @property string $created_on
 * @property integer $tipo
 *
 * The followings are the available model relations:
 * @property LookHasTblBolsa[] $lookHasTblBolsas
 * @property Producto[] $tblProductos
 */
class Look extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Look the static model class
	 */
	 private $_items;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{look}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array(' altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'numerical','min'=>1),
			array('title, altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'required'),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'numerical', 'integerOnly'=>true),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel', 'numerical','min'=>1,'tooSmall' => 'Debe seleccionar por lo menos un {attribute}','on'=>'update'),
			array('title', 'length', 'max'=>45),
			array('description, created_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, altura, contextura, pelo, ojos, tipo_cuerpo, piel, created_on, tipo', 'safe', 'on'=>'search'),
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
			'lookHasTblBolsas' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_look_id'),
			'tblProductos' => array(self::MANY_MANY, 'Producto', '{{look_has_producto}}(look_id, producto_id)'),
			'categoriahaslook' => array(self::HAS_MANY, 'CategoriaHasLook', 'look_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Titulo',
			'description' => 'Description',
			'altura' => 'Altura',
			'contextura' => 'Condición Física',
			'pelo' => 'Color de Cabello',
			'ojos' => 'Color de Ojos',
			'tipo_cuerpo' => 'Tipo Cuerpo',
			'piel' => 'Color de Piel',
			'created_on' => 'Created On',
			'tipo' => 'Tipo',
		);
	}

	public function match($user) 
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
/*
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('altura',$this->altura);
		$criteria->compare('contextura',$this->contextura);
		$criteria->compare('pelo',$this->pelo);
		$criteria->compare('ojos',$this->ojos);
		$criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);
		$criteria->compare('piel',$this->piel);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('tipo',$this->tipo);
*/
		/*
		$criteria->addCondition('altura & ' . $user->profile->altura . ' != 0');
		$criteria->addCondition('contextura & ' . $user->profile->contextura . ' != 0');
		$criteria->addCondition('pelo & ' . $user->profile->pelo . ' != 0');
		$criteria->addCondition('ojos & ' . $user->profile->ojos . ' != 0');
		$criteria->addCondition('tipo_cuerpo & ' . $user->profile->tipo_cuerpo . ' != 0');
		$criteria->addCondition('piel & ' . $user->profile->piel . ' != 0');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
		
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if('.$user->profile->pelo.' & pelo !=0,1,0)+if('.$user->profile->altura.' & altura !=0,1,0))>=2')->queryScalar();
		$sql='SELECT id FROM tbl_look WHERE (
			if('.$user->profile->altura.' & altura !=0,1,0)+
			if('.$user->profile->contextura.' & contextura !=0,1,0)+
			if('.$user->profile->pelo.' & pelo !=0,1,0)+
			if('.$user->profile->ojos.' & ojos !=0,1,0)+
			if('.$user->profile->piel.' & ojos !=0,1,0)+
			if('.$user->profile->tipo_cuerpo.' & altura !=0,1,0)
		) >= 2';
		//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if(pelo & 2 !=0,1,0)+if(altura & 2 !=0,1,0))>=2')->queryScalar();
		//$sql='SELECT id FROM tbl_look WHERE (if(pelo & 2 !=0,1,0)+if(altura & 2 !=0,1,0)) >= 2';
		//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if(tipo = coctel,1,0)+if(tipo = fiesta,1,0))>=2')->queryScalar();
		//$sql='SELECT id FROM tbl_look WHERE (if(pelo & 2 !=0,1,0)+if(altura & 2 !=0,1,0)) >= 2';
		
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		//'sort'=>array(
		//    'attributes'=>array(
		//         'id', 'username', 'email',
		//    ),
		//),
		//'pagination'=>array(
		//    'pageSize'=>10, 
		//    ),
		));
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('altura',$this->altura);
		$criteria->compare('contextura',$this->contextura);
		$criteria->compare('pelo',$this->pelo);
		$criteria->compare('ojos',$this->ojos);
		$criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);
		$criteria->compare('piel',$this->piel);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getCategorias()
	{
		$array = array();	
		foreach($this->categoriahaslook as $categoria)
			$array[] = $categoria->categoria_id;
		return $array;
			
	}
	public function countItems()
	{
		if (isset($this->_items)){
			return $_items;
		}else {
			$_items = count($this->tblProductos);
			return $_items;
		}
	}
}