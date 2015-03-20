<?php

/**
 * This is the model class for table "{{recomendacion}}".
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
			$user = Yii::app()->user;
			
		}else{
			$user = User::model()->findByPk($user_id);
		}
		
	
		
		
	
		return Producto::model()->destacados(6);
	
	}


}