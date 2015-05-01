<?php

/**
 * This is the model class for table "{{bugReporte}}".
 *
 * The followings are the available columns in table '{{bugReporte}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $bug_id
 * @property string $fecha
 * @property string $descripcion
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Bug $bug
 */
class BugReporte extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BugReporte the static model class
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
		return '{{bugReporte}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, bug_id, fecha, descripcion, estado', 'required','message'=>'{attribute} No puede ser vacio.'),
			array('user_id, bug_id, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, bug_id, fecha, descripcion, estado', 'safe', 'on'=>'search'),
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
			'bug' => array(self::BELONGS_TO, 'Bug', 'bug_id'),
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
			'bug_id' => 'Bug',
			'fecha' => 'Fecha',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('bug_id',$this->bug_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchEstados()
	{
		return $options = array ('0' => 'No Solucionado', '1' => 'Solucionado', '2' => 'En Analisis', '3' => 'No se Pudo Reproducir', '4' => 'Por Diseño');
	}
	
	public function getEstados($estado)
	{
		if($estado==0)
		{
			$estado='No Solucionado';
		}
		else 
		{
			if($estado==1)
			{
				$estado='Solucionado';
			}
			else 
			{
				if($estado==2)
				{
					$estado='En Analisis';
				}
				else 
				{
					if($estado==3)
					{
						$estado='No se Pudo Reproducir';
					}
					else 
					{
						$estado='Por Diseño';
					}
				}	
			}
		}	
		return $estado;
	}
	
}