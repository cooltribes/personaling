<?php

/**
 * This is the model class for table "{{siteImage}}".
 *
 * The followings are the available columns in table '{{siteImage}}':
 * @property integer $id
 * @property string $name
 * @property integer $index
 * @property integer $group
 * @property string $title
 * @property integer $alt
 * @property string $copy
 * @property string $path
 * @property string $link
 * @property integer $type
 * @property integer $width
 * @property integer $height
 */
class SiteImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteImage the static model class
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
		return '{{siteImage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('path', 'required'),
			array('id, index, group, type, width, height', 'numerical', 'integerOnly'=>true),
			array('name, title, alt', 'length', 'max'=>50),
			array('copy, link', 'length', 'max'=>200),
			array('path', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, index, group, title, alt, copy, path, type, width, height, link', 'safe', 'on'=>'search'),
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
			'name' => 'Elemento',
			'index' => 'Posición',
			'group' => 'Grupo',
			'title' => 'Titulo',
			'alt' => 'Texto Alternativo',
			'copy' => 'Copy',
			'path' => 'Archivo',
			'link' => 'Enlace a',
			'type' => 'Tipo',
			'width' => 'Width',
			'height' => 'Height',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('index',$this->index);
		$criteria->compare('group',$this->group);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alt',$this->alt);
		$criteria->compare('copy',$this->copy,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getNames(){
        $array=array('banner','slider','article','magazine','organization');
        return $array;
    }
    public function getTypes(){
        $array=array(1=>'Desktop',2=>'Mobile',3=>'Ambas');
        return $array;
    }
    public function getImage($name,$index=1,$width='100%',$height=''){
            $img=$this->findByAttributes(array('name'=>$name,'index'=>$index));
            if($img){              
                
                return CHtml::image($img->path, $img->alt,array('title'=>$img->title,'width'=>$width,'height'=>$height));
            }
            else return "";    
        }
    
    public function getLinkedImage($name,$index=1,$width='100%',$height='',$class=''){
            $img=$this->findByAttributes(array('name'=>$name,'index'=>$index));
            if($img){              
                
                return "<a href='".$img->link."' title='".$img->title."' class='".$class."'>".CHtml::image($img->path, $img->alt,array('title'=>$img->title,'width'=>$width,'height'=>$height))."</a>";
            }
            else return "";    
        }
}