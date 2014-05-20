<?php

/**
 * This is the model class for table "{{inbound}}".
 *
 * The followings are the available columns in table '{{inbound}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $fecha_carga
 * @property integer $total_productos
 * @property integer $total_cantidad
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Inbound extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Inbound the static model class
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
        return '{{inbound}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, fecha_carga, total_productos, total_cantidad', 'required'),
            array('user_id, total_productos, total_cantidad', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, fecha_carga, total_productos, total_cantidad', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
            'fecha_carga' => 'Fecha Carga',
            'total_productos' => 'Total Productos',
            'total_cantidad' => 'Total Cantidad',
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
        $criteria->compare('fecha_carga',$this->fecha_carga,true);
        $criteria->compare('total_productos',$this->total_productos);
        $criteria->compare('total_cantidad',$this->total_cantidad);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}