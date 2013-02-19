<?php

/**
 * This is the model class for table "{{seo}}".
 *
 * The followings are the available columns in table '{{seo}}':
 * @property integer $id
 * @property string $mTitulo
 * @property string $mDescripcion
 * @property string $pClave
 * @property string $urlAmigable
 * @property integer $tbl_producto_id
 */
class Seo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Seo the static model class
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
		return '{{seo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, tbl_producto_id', 'required'),
			array('id, tbl_producto_id', 'numerical', 'integerOnly'=>true),
			array('mTitulo', 'length', 'max'=>80),
			array('pClave', 'length', 'max'=>140),
			array('urlAmigable', 'length', 'max'=>180),
			array('mDescripcion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mTitulo, mDescripcion, pClave, urlAmigable, tbl_producto_id', 'safe', 'on'=>'search'),
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
			'mTitulo' => 'M Titulo',
			'mDescripcion' => 'M Descripcion',
			'pClave' => 'P Clave',
			'urlAmigable' => 'Url Amigable',
			'tbl_producto_id' => 'Tbl Producto',
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
		$criteria->compare('mTitulo',$this->mTitulo,true);
		$criteria->compare('mDescripcion',$this->mDescripcion,true);
		$criteria->compare('pClave',$this->pClave,true);
		$criteria->compare('urlAmigable',$this->urlAmigable,true);
		$criteria->compare('tbl_producto_id',$this->tbl_producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}