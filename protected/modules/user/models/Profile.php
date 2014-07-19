<?php

class Profile extends UActiveRecord
{
	/**
	 * The followings are the available columns in table 'profiles':
	 * @var integer $user_id
	 * @var boolean $regMode
	 */
	public $regMode = false;
	public $profile_type = 0;
	
	private $_model;
	private $_modelReg;
	private $_rules = array();
	public $month;
	public $day;
	public $year;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableProfiles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		if (!$this->_rules) {
			$required = array();
			$numerical = array();
			$float = array();		
			$decimal = array();
			$rules = array();
			array_push($rules,array('facebook, twitter, url, bio', 'type','type'=>'string','allowEmpty'=>true,'on'=>'notPS' ));	
			
		
			$model=$this->getFields();
			
			foreach ($model as $field) {
				$field_rule = array();
				
				if ($field->required==ProfileField::REQUIRED_YES_NOT_SHOW_REG||
                                        $field->required==ProfileField::REQUIRED_YES_SHOW_REG||
                                        $field->required==ProfileField::REQUIRED_YES_ESTILO||
                                        $field->required==ProfileField::REQUIRED_YES_TIPO ||
                                        $field->required==ProfileField::REQUIRED_YES_PERSONAL_REG ||
                                        $field->id == 26 ||
                                        $field->id == 25)
					 {
                                       if ($field->varname=="first_name")
                                               array_push($rules,array($field->varname, 'required','message'=>' ¿Cómo te llamas? '));
									   else	if ($field->varname=="last_name")
                                               array_push($rules,array($field->varname, 'required','message'=>' ¿Cuál es tu apellido? '));
									   else if ($field->varname=="sex")
                                               array_push($rules,array($field->varname, 'required','message'=>' ¿Eres mujer/hombre? '));
                                               
                                                                           else if ($field->varname=="url" || $field->varname=="bio"
                                                                                   || $field->varname=="facebook" || $field->varname=="twitter")
                                               { array_push($rules,array($field->varname, 'required','message'=>" {$field->error_message} ",'on'=>'PS'));
											   	 
											   }
									   else									   
                                       		array_push($required,$field->varname);
                     }
				if ($field->field_type=='FLOAT') 
					array_push($float,$field->varname);
				if ($field->field_type=='DECIMAL')
					array_push($decimal,$field->varname);
				if ($field->field_type=='INTEGER')
					array_push($numerical,$field->varname);
				if ($field->field_type=='VARCHAR'||$field->field_type=='TEXT') {
					$field_rule = array($field->varname, 'length', 'max'=>$field->field_size, 'min' => $field->field_size_min);
					if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
					array_push($rules,$field_rule);
				}
				if ($field->other_validator) {
					if (strpos($field->other_validator,'{')===0) {
						$validator = (array)CJavaScript::jsonDecode($field->other_validator);
						foreach ($validator as $name=>$val) {
							$field_rule = array($field->varname, $name);
							$field_rule = array_merge($field_rule,(array)$validator[$name]);
							if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
							array_push($rules,$field_rule);
						}
					} else {
						$field_rule = array($field->varname, $field->other_validator);
						if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
						array_push($rules,$field_rule);
					}
				} elseif ($field->field_type=='DATE') {
					$field_rule = array($field->varname, 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd', 'allowEmpty'=>false);
					if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
					array_push($rules,$field_rule);
					if ($field->varname=='birthday'){
						$field_rule = array($field->varname, 'EAgeValidator',  'minAge'=>10,  'maxAge'=>120,  'allowEmpty'=>false, 'message'=>'Hola, edad validation');
						array_push($rules,$field_rule);
					}
					
				}
				if ($field->match) {
					$field_rule = array($field->varname, 'match', 'pattern' => $field->match);
					if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
					array_push($rules,$field_rule);
				}
				if ($field->range) {
					$field_rule = array($field->varname, 'in', 'range' => self::rangeRules($field->range));
					if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
					array_push($rules,$field_rule);
				}
			}
			
			array_push($rules,array('month,day,year', 'safe'));
			
			array_push($rules,array(implode(',',$required), 'required', 'message'=>'{attribute}'));
			array_push($rules,array(implode(',',$numerical), 'numerical', 'integerOnly'=>true));
			array_push($rules,array(implode(',',$float), 'type', 'type'=>'float'));
			array_push($rules,array(implode(',',$decimal), 'match', 'pattern' => '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'));
			
			$this->_rules = $rules;
		}
		
		return $this->_rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
		if (isset(Yii::app()->getModule('user')->profileRelations)) $relations = array_merge($relations,Yii::app()->getModule('user')->profileRelations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'user_id' => UserModule::t('User ID'),
		);
		$model=$this->getFields();
		
		foreach ($model as $field)
			$labels[$field->varname] = ((Yii::app()->getModule('user')->fieldsMessage)?UserModule::t($field->title,array(),Yii::app()->getModule('user')->fieldsMessage):UserModule::t($field->title));
		//print_r($labels);	
		return $labels;
	}
	
	private function rangeRules($str) {
		$rules = explode(';',$str);
		for ($i=0;$i<count($rules);$i++)
			$rules[$i] = current(explode("==",$rules[$i]));
		return $rules;
	}
	
	static public function range($str,$fieldValue=NULL) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])) $array[$item[0]] = ((isset($item[1]))?$item[1]:$item[0]);
		}
		if (isset($fieldValue)) 
			if (isset($array[$fieldValue])) return $array[$fieldValue]; else return '';
		else
			return $array;
	}
	static public function rangeButtons($str,$fieldValue=NULL,$disabled=false) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])){
				$array[$i]['label'] = ((isset($item[1]))?$item[1]:$item[0]);
				$array[$i]['url'] = '#'.$item[0];
				$array[$i]['htmlOptions'] = array('disabled'=>$disabled);
				if ((int)$item[0]&(int)$fieldValue){
					
					//echo 'item'.$item[0].'value'.$fieldValue;
					$array[$i]['active'] = true;
				}
			} 
		}
		return $array;

	}	
	public function widgetAttributes() {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widget;
		}
		return $data;
	}
	
	public function widgetParams($fieldName) {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widgetparams;
		}
		return $data[$fieldName];
	}
	
	public function getFields() {
		if ($this->regMode) {
			if (!$this->_modelReg){
                            $this->_modelReg=ProfileField::model()->forRegistration()->findAll();
                            
                            if($this->profile_type == 4){ //Personal Shopper
                                $this->_modelReg = array_merge($this->_modelReg, ProfileField::model()->forPersonalShopperReg()->forOwner()->findAll());
                            }
                        }
				
			return $this->_modelReg;
		} else {
			
			if (!$this->_model)
				switch ($this->profile_type){
					case 0:
						$this->_model=ProfileField::model()->findAll(); //
						break;						
					case 1:
						$this->_model=ProfileField::model()->forPersonal()->forOwner()->findAll(); //
						break;
					case 2:
						$this->_model=ProfileField::model()->forEstilo()->forOwner()->findAll(); //forPersonal()->
						break;
					case 3:
						$this->_model=ProfileField::model()->forTipo()->forOwner()->findAll(); //forPersonal()->
						break;
					case 4:
						$this->_model=ProfileField::model()->forPersonalShopper()->forOwner()->findAll(); //forPersonal()->
						break;
					case 5:
						$this->_model=ProfileField::model()->forPersonalShopperComi()->forOwner()->findAll(); //forPersonal()->
						break;
					default:
						$this->_model=ProfileField::model()->forOwner()->findAll(); //forPersonal()->	
				}
			return $this->_model;
		}
	}
	protected function beforeValidate()
	{
	   	
	   $this->birthday = $this->year .'-'. $this->month .'-'. $this->day;
	   //echo $this->birthday;
	   return parent::beforeValidate();
	}
	protected function afterFind(){
		
   $this->day = date('d', strtotime($this->birthday));
    $this->month = date('m', strtotime($this->birthday));
    $this->year = date('Y', strtotime($this->birthday));	

		return parent::afterFind();
	}
	
	public function getSaldo($id , $format=true){
			$sum = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".$id)->queryScalar();
			//$sum= Yii::app()->numberFormatter->formatCurrency($sum, '');
			return $sum;
	}
	/* Obtener el url del perfil publico del usuario */
	public function getUrl(){
		
		if ($this->url != '')	
			return Yii::app()->baseUrl.'/'.$this->url;
		return Yii::app()->createUrl('user/profile/perfil',array('id'=>$this->user_id));		
	}
	/* Obtener el nombre del ususario */
	public function getNombre($id = null){
		if(!is_null($id))
		{
			$null=$this->findByPk($id);	
			return $null->first_name.' '.$null->last_name; 		
		}
		return $this->first_name.' '.$this->last_name; 
	}
	  
	 public function countXestatura(){
	 		$estatura=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(altura) FROM tbl_profiles WHERE altura<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE altura =".$alt)->queryScalar();
				$estatura[$alt]=$sum;
			}
			$estatura[0]=100/array_sum($estatura);			
			return $estatura;
		
	 }
	 
	 public function countXcontextura(){
	 		$cont=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(contextura) FROM tbl_profiles WHERE contextura<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE contextura =".$alt)->queryScalar();
				$cont[$alt]=$sum;
			}
			$cont[0]=100/array_sum($cont);			
			return $cont;
		
	 }
	 
	 public function countXpelo(){
	 		$pelo=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(pelo) FROM tbl_profiles WHERE pelo<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE pelo =".$alt)->queryScalar();
				$pelo[$alt]=$sum;
			}
			$pelo[0]=100/array_sum($pelo);			
			return $pelo;
		
	 }
	 public function countXojos(){
	 		$ojos=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(ojos) FROM tbl_profiles WHERE ojos<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE ojos =".$alt)->queryScalar();
				$ojos[$alt]=$sum;
			}
			$ojos[0]=100/array_sum($ojos);		
			return $ojos;
		
	 }
	 public function countXcuerpo(){
	 		$cuerpo=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(tipo_cuerpo) FROM tbl_profiles WHERE tipo_cuerpo<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE tipo_cuerpo =".$alt)->queryScalar();
				$cuerpo[$alt]=$sum;
			}
			$cuerpo[0]=100/array_sum($cuerpo);			
			return $cuerpo;
		
	 }
	 public function countXpiel(){
	 		$piel=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(piel) FROM tbl_profiles WHERE piel<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE piel =".$alt)->queryScalar();
				$piel[$alt]=$sum;
			}
			$piel[0]=100/array_sum($piel);		
			return $piel;
		
	 }
	 
	  public function countXgenero(){
	 		$sex=array();
			$alts = Yii::app()->db->createCommand(" SELECT distinct(sex) FROM tbl_profiles WHERE sex<>0")->queryColumn();
			foreach($alts as $alt){
				$sum = Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE sex =".$alt)->queryScalar();
				$sex[$alt]=$sum;
			} 
			$sex[0]=100/array_sum($sex);		
			return $sex;
		
	 }
	 
	  public function countXedad(){
	 		$minmax=Yii::app()->db->createCommand(" select min(birthday) as oldest, max(birthday) as youngest from tbl_profiles where birthday>'0000-00-00' ")->queryRow();	
	 		$old= date('Y', strtotime($minmax['oldest']));
			$young=date('Y', strtotime($minmax['youngest']));
			$todos=0;
			$block=round(($young-$old)/5,0);
			for($i=1;$i<6;$i++){
				$ran[$i]['min']=$young-$block*$i;
				$ran[$i]['max']=$young-$block*($i-1);
				$ran[$i]['edad2']=date("Y")-$ran[$i]['min'];
				$ran[$i]['edad1']=date("Y")-$ran[$i]['max'];
				$ran[$i]['total']=Yii::app()->db->createCommand(" SELECT count(user_id) FROM tbl_profiles WHERE birthday BETWEEN '".$ran[$i]['min']."-01-01' AND '".$ran[$i]['max']."-12-31'")->queryScalar();
				$todos+=$ran[$i]['total'];
			}
			$ran[0]=$todos;
			return $ran;
	 	
	 				
	 }
	 
	 public function getStyleTest($id=null,$bool = true){
	 	if(!is_null($id))
			$user=Profile::model()->findByPk($id);
		else
			$user=$this;	
	 	$count=0;
		if($user->coctel >0)
			$count++;
		if($user->fiesta >0)
			$count++;
		if($user->playa >0)
			$count++;
		if($user->sport >0)
			$count++;
		if($user->trabajo >0)
			$count++;
		if($user->piel >0)
			$count++;
		
		if($count==6){
	 		if($bool)
	 			return true;
			else
				return "Completo";
		}
		else{
			if($bool)
	 			return false;
			else
				return "Incompleto";
		}
	 }	
	 
	 public function getCompletedProfile($id=null,$bool = true){
	 	if(!is_null($id))
			$user=Profile::model()->findByPk($id);
		else
			$user=$this;		
	 	$count=0;
		if($user->altura >0)
			$count++;
		if($user->contextura >0)
			$count++;
		if($user->pelo >0)
			$count++;
		if($user->ojos >0)
			$count++;
		if($user->tipo_cuerpo >0)
			$count++;
		if($count==5){
	 		if($bool)
	 			return true;
			else
				return "Completo";
		}
		else{
			if($bool)
	 			return false;
			else
				return "Incompleto";
		}
			
	 }
	 
}
