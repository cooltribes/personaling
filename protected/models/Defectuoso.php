<?php

/**
 * This is the model class for table "{{defectuoso}}".
 *
 * The followings are the available columns in table '{{defectuoso}}':
 * @property integer $id
 * @property integer $cantidad
 * @property string $fecha
 * @property integer $user_id
 * @property integer $preciotallacolor_id
 * @property double $costo
 * @property string $procedencia
 */
class Defectuoso extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Defectuoso the static model class
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
		return '{{defectuoso}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad, user_id, preciotallacolor_id', 'numerical', 'integerOnly'=>true),
			array('costo', 'numerical'),
			array('procedencia', 'length', 'max'=>50),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cantidad, fecha, user_id, preciotallacolor_id, costo, procedencia', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cantidad' => 'Cantidad',
			'fecha' => 'Fecha',
			'user_id' => 'User',
			'preciotallacolor_id' => 'Preciotallacolor',
			'costo' => 'Costo',
			'procedencia' => 'Procedencia',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('preciotallacolor_id',$this->preciotallacolor_id);
		$criteria->compare('costo',$this->costo);
		$criteria->compare('procedencia',$this->procedencia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function all($pages = NULL)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 
	$sql="select d.fecha as 'Fecha', u.username as 'Usuario', d.costo as 'Costo', 
	d.procedencia as 'Procedencia', p.id,
		p.codigo as 'Referencia', 
		m.nombre as 'Marca', m.id, 
		p.nombre as 'Nombre', 
		ptc.sku as 'SKU', 
		c.valor as 'Color', 
		t.valor as 'Talla', 
		d.cantidad as 'Cantidad' from tbl_defectuoso d 
		JOIN tbl_precioTallaColor ptc ON d.preciotallacolor_id=ptc.id
		JOIN tbl_producto p ON p.id=ptc.producto_id 
		JOIN tbl_marca m ON p.marca_id = m.id 
		JOIN tbl_color c ON ptc.color_id = c.id 
		JOIN tbl_talla t ON ptc.talla_id=t.id
		JOIN tbl_users u ON d.user_id=u.id";
 	
 	 
		
		if(isset(Yii::app()->session['idMarca'])){
			if(Yii::app()->session['idMarca']!=0)
				$sql=$sql." WHERE m.id=".Yii::app()->session['idMarca'];

		}
		
		$sql=$sql." group by d.id";
		
	
		
		
		$rawData=Yii::app()->db->createCommand($sql)->queryAll();
		
		if(!is_null($pages)){
				
			if(!$pages){
				$sql="select count(id) from  tbl_defectuoso";
				$pages=Yii::app()->db->createCommand($sql)->queryScalar();
			}
			else
				$pages=30;
		}

				// or using: $rawData=User::model()->findAll(); <--this better represents your question
	
				return new CArrayDataProvider($rawData, array(
				    'id'=>'data',
				    'pagination'=>array(
				        'pageSize'=>$pages,
				    ),
					 
				    'sort'=>array(
				        'attributes'=>array(
				            'Marca', 'Nombre', 'Color', 'Talla',  'Costo','Cantidad','Usuario','Procedencia'
				        ),
	    ),
				));
		
		

	}
	
	
	
	
}