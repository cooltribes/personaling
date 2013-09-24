<?php

/**
 * This is the model class for table "{{filter_profile}}".
 *
 * The followings are the available columns in table '{{filter_profile}}':
 * @property integer $id_filter_profile
 * @property integer $id_filter
 * @property integer $altura
 * @property integer $contextura
 * @property integer $pelo
 * @property integer $ojos
 * @property integer $piel
 * @property integer $tipo_cuerpo
 *
 * The followings are the available model relations:
 * @property Filter $idFilter
 */
class FilterProfile extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FilterProfile the static model class
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
        return '{{filter_profile}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_filter', 'required'),
            array('id_filter, altura, contextura, pelo, ojos, piel, tipo_cuerpo', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_filter_profile, id_filter, altura, contextura, pelo, ojos, piel, tipo_cuerpo', 'safe', 'on'=>'search'),
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
            'idFilter' => array(self::BELONGS_TO, 'Filter', 'id_filter'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id_filter_profile' => 'Id Filter Profile',
            'id_filter' => 'Id Filter',
            'altura' => 'Altura',
            'contextura' => 'Contextura',
            'pelo' => 'Pelo',
            'ojos' => 'Ojos',
            'piel' => 'Piel',
            'tipo_cuerpo' => 'Tipo Cuerpo',
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

        $criteria->compare('id_filter_profile',$this->id_filter_profile);
        $criteria->compare('id_filter',$this->id_filter);
        $criteria->compare('altura',$this->altura);
        $criteria->compare('contextura',$this->contextura);
        $criteria->compare('pelo',$this->pelo);
        $criteria->compare('ojos',$this->ojos);
        $criteria->compare('piel',$this->piel);
        $criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}