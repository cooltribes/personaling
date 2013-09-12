<?php

/**
 * This is the model class for table "{{filter}}".
 *
 * The followings are the available columns in table '{{filter}}':
 * @property integer $id_filter
 * @property string $name
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property FilterDetail[] $filterDetails
 */

/*
 * Valores para el campo type:
 * 1 - Filtros para Ventas
 * 2 - Filtros para Productos
 * 
 */

class Filter extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Filter the static model class
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
        return '{{filter}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type', 'required'),
            array('type', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>64),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_filter, name, type', 'safe', 'on'=>'search'),
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
            'filterDetails' => array(self::HAS_MANY, 'FilterDetail', 'id_filter'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id_filter' => 'Id Filter',
            'name' => 'Name',
            'type' => 'Type',
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

        $criteria->compare('id_filter',$this->id_filter);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('type',$this->type);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}