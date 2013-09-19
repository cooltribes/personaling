<?php

class User extends CActiveRecord {

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    const STATUS_DELETED = 2;

    //TODO: Delete for next version (backward compatibility)
    //const STATUS_BANED=-1;
    const STATUS_REGISTER_NEW = 0;
    const STATUS_REGISTER_TIPO = 1;
    const STATUS_REGISTER_ESTILO = 2;
    const STATUS_REGISTER_DONE = 3;

    // PRIVACIDAD
    const PRIVACIDAD_DATOS_BASICOS = 1;
    const PRIVACIDAD_AVATAR = 2;
    const PRIVACIDAD_LOOKS = 4;
    const PRIVACIDAD_SHOPPERS = 8;

    //Vector de estados para dropdown
    public static $statuses = array(self::STATUS_ACTIVE => 'Activo', self::STATUS_NOACTIVE => 'Inactivo', 
        self::STATUS_BANNED => 'Bloqueado', self::STATUS_DELETED => 'Eliminado');

    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var string $activkey
     * @var integer $createtime
     * @var integer $lastvisit
     * @var integer $superuser
     * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
     * @var timestamp $avatar_url
     * @var timestamp $banner_url
     * */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return Yii::app()->getModule('user')->tableUsers;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.CConsoleApplication
        return ((get_class(Yii::app()) == 'CConsoleApplication' || (get_class(Yii::app()) != 'CConsoleApplication' && Yii::app()->getModule('user')->isAdmin())) ? array(
                    array('username', 'length', 'max' => 128, 'min' => 8, 'message' => UserModule::t("Incorrect username (length between 8 and 128 characters).")),
                    //array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
                    array('password', 'length', 'max' => 128, 'min' => 4, 'tooShort' => 'La contraseña debe tener mínimo 4 caracteres.'),
                    array('email', 'email'),
                    array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
                    array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
                    //array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
                    array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANNED)),
                    array('superuser', 'in', 'range' => array(0, 1)),
                    array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
                    array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
                    array('username, email, superuser, status', 'required'),
                    array('superuser, status,status_register,privacy, twitter_id, facebook_id', 'numerical', 'integerOnly' => true),
                    array('id, username, password, email, activkey, create_at, lastvisit_at,visit, superuser, status,status_register,privacy,personal_shopper, twitter_id, facebook_id, avatar_url, banner_url', 'safe', 'on' => 'search'),
                        ) : ((Yii::app()->user->id == $this->id) ? array(
                            array('username, email', 'required'),
                            array('password', 'length', 'max' => 128, 'min' => 4, 'tooShort' => 'La contraseña debe tener mínimo 4 caracteres.'),
                            array('privacy', 'numerical', 'integerOnly' => true),
                            array('username', 'length', 'max' => 128, 'min' => 8, 'message' => UserModule::t("Incorrect username (length between 8 and 128 characters).")),
                            array('email', 'email'),
                            array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
                            //array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
                            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
                                ) : array()));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        $relations['direccion'] = array(self::HAS_MANY, 'Direccion', 'user_id');

        $relations['direccionCount'] = array(self::STAT, 'Direccion', 'user_id',
            'select' => 'COUNT(*)',
        );
        $relations['ordenCount'] = array(self::STAT, 'Orden', 'user_id',
            'select' => 'COUNT(*)',
        );
        
        $relations['ordenes'] = array(self::HAS_MANY, 'Orden', 'user_id',
//            // we don't want to select posts
//                        'select'=>false,
//                        // but want to get only users with published posts
//                        'joinType'=>'INNER JOIN',
//                        'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',
            );
        
        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => UserModule::t("Id"),
            'username' => UserModule::t("username"),
            'password' => UserModule::t("password"),
            'verifyPassword' => UserModule::t("Retype Password"),
            'email' => UserModule::t("E-mail"),
            'verifyCode' => UserModule::t("Verification Code"),
            'activkey' => UserModule::t("activation key"),
            'createtime' => UserModule::t("Registration date"),
            'create_at' => UserModule::t("Registration date"),
            'personal_shopper' => UserModule::t("Personal Shopper"),
            'lastvisit_at' => UserModule::t("Last visit"),
            'superuser' => UserModule::t("Administrador"),
            'status' => UserModule::t("Status"),
            'twitter_id' => UserModule::t("Twitter ID"),
            'facebook_id' => UserModule::t("Facebook ID"),
            'avatar_url' => UserModule::t("Avatar"),
            'banner_url' => "Banner",
        );
    }

    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'status=' . self::STATUS_ACTIVE,
            ),
            'notactive' => array(
                'condition' => 'status=' . self::STATUS_NOACTIVE,
            ),
            'banned' => array(
                'condition' => 'status=' . self::STATUS_BANNED,
            ),
            'superuser' => array(
                'condition' => 'superuser=1',
            ),
            'notsafe' => array(
                'select' => 'id, username, password, email, activkey, create_at, lastvisit_at,visit, superuser, status, status_register,privacy,personal_shopper,twitter_id, facebook_id,avatar_url, banner_url',
            ),
        );
    }

    public function defaultScope() {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope, array(
                    'alias' => 'user',
                    'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.visit, user.superuser, user.status, user.privacy, user.personal_shopper, user.twitter_id, user.facebook_id, user.avatar_url, user.banner_url',
        ));
    }

    public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => UserModule::t('Not active'),
                self::STATUS_ACTIVE => UserModule::t('Active'),
                self::STATUS_BANNED => UserModule::t('Banned'),
            ),
            'AdminStatus' => array(
                '0' => UserModule::t('No'),
                '1' => UserModule::t('Yes'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('activkey', $this->activkey);
        $criteria->compare('create_at', $this->create_at);
        $criteria->compare('lastvisit_at', $this->lastvisit_at);
        $criteria->compare('superuser', $this->superuser);
        $criteria->compare('status', $this->status);
        $criteria->compare('twitter_id', $this->twitter_id);
        $criteria->compare('facebook_id', $this->facebook_id);
        $criteria->compare('avatar_url', $this->avatar_url);
        $criteria->compare('banner_url', $this->banner_url);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->getModule('user')->user_page_size,
            ),
        ));
    }

    public function getAvatar() {
        if ($this->avatar_url != '')
            return Yii::app()->baseUrl . $this->avatar_url;
        if ($this->personal_shopper)
            return Yii::app()->baseUrl . '/images/avatar_provisional_3.jpg';
        return Yii::app()->baseUrl . '/images/avatar_provisional_2.jpg';
    }

    public function getBanner() {
        if ($this->banner_url != '')
            return Yii::app()->baseUrl . $this->banner_url;

        return 'http://placehold.it/87	0x90';
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at = date('Y-m-d H:i:s', $value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at = date('Y-m-d H:i:s', $value);
    }

    protected function beforeValidate() {

        if (!(isset($this->username)) || $this->username == '')
            $this->username = $this->email;
        //$this->birthday = $this->birthday['year'] .'-'. $this->birthday['month'] .'-'. $this->birthday['day'];
        //echo $this->birthday;
        return parent::beforeValidate();
    }

    public static function getStatus($key = null) {

        if ($key !== null)
            return self::$statuses[$key];


        return self::$statuses;
    }

    public static function getMonthsArray() {

        $months['01'] = "Enero";
        $months['02'] = "Febrero";
        $months['03'] = "Marzo";
        $months['04'] = "Abril";
        $months['05'] = "Mayo";
        $months['06'] = "Junio";
        $months['07'] = "Julio";
        $months['08'] = "Agosto";
        $months['09'] = "Septiembre";
        $months['10'] = "Octubre";
        $months['11'] = "Noviembre";
        $months['12'] = "Diciembre";


        return array(0 => 'Mes:') + $months;
    }

    public static function getDaysArray() {
        $days['01'] = '01';
        $days['02'] = '02';
        $days['03'] = '03';
        $days['04'] = '04';
        $days['05'] = '05';
        $days['06'] = '06';
        $days['07'] = '07';
        $days['08'] = '08';
        $days['09'] = '09';
        for ($dayNum = 10; $dayNum <= 31; $dayNum++) {
            $days[$dayNum] = $dayNum;
        }

        return array(0 => 'Dia:') + $days;
    }

    public static function getYearsArray() {
        $thisYear = date('Y', time());

        for ($yearNum = $thisYear; $yearNum >= 1920; $yearNum--) {
            $years[$yearNum] = $yearNum;
        }

        return array(0 => 'Año:') + $years;
    }

    /**
     * Buscar por todos los filtros dados en el array $filters
     */
    public function buscarPorFiltros($filters) {
//        echo "<pre>";
//        print_r($filters);
//        echo "</pre>";
//            Yii::app()->end();

        $criteria = new CDbCriteria;

        $criteria->with = array();
        $criteria->select = array();
        //$criteria->select[] = "t.*";

        for ($i = 0; $i < count($filters['fields']); $i++) {

            $column = $filters['fields'][$i];
            $value = $filters['vals'][$i];
            $comparator = $filters['ops'][$i];

            if ($i == 0) 
            {
                $logicOp = 'AND';
            } 
            else
            {
                $logicOp = $filters['rels'][$i - 1];
            }

            /* Usuarios */
            if ($column == 'first_name' || $column == 'last_name'
                    || $column == 'email' || $column == 'ciudad')
            {
                
                $value = ($comparator == '=') ? "=" . $value . "" : $value;

                $criteria->compare($column, $value, true, $logicOp);

                continue;
            }
            
            if ($column == 'telefono')
            {                
                
                $value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";

                $criteria->addCondition('(tlf_casa '.$value.' OR tlf_celular '.$value.')', $logicOp);

                continue;
            }
            
            if($column === 'tipoUsuario')
            {
                if($value === 'admin')
                {
                    $criteria->compare("superuser", $comparator.'1', false, $logicOp);

                }else if($value === 'ps')
                {
                    $criteria->compare("personal_shopper", $comparator.'1', false, $logicOp);

                }else if($value === 'user')
                {              
                    $comparator = ($comparator == '=') ? '' : 'NOT ';
                    $criteria->addCondition($comparator.'(superuser =  0 AND personal_shopper = 0)', $logicOp);
                    
                }
                
                continue;
                
            }
            
            if($column === 'fuenteR')
            {                                
                
                if($value === 'face')
                {
                   $comparator = $comparator === '=' ? 'NOT ' : '';                   

                }else if($value === 'user')
                {
                    $comparator = $comparator === '=' ? '' : 'NOT ';

                }
                
                $criteria->addCondition('facebook_id IS '.$comparator.'NULL', $logicOp);
                
                continue;
                
            }

            if($column == 'monto')
            { 

                 $criteria->addCondition('(IFNULL((select SUM(orden.total) 
		from tbl_orden orden 
		where orden.user_id = user.id 
			AND 
		(orden.estado = 3 OR orden.estado = 4 OR orden.estado = 8)), 0))  '
                                        . $comparator . ' ' . $value . '', $logicOp);
                        
                continue;
            }

            if($column == 'looks')
            { 

               if (!in_array('ordenes', $criteria->with)) {
                    $criteria->with['ordenes'] = array(
                        'select'=> false,
                        'joinType'=>'INNER JOIN',
                        'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',                        
                        
                    );
                }                
                
                if (!in_array('ordenes.productos', $criteria->with)) {
                     
                    $criteria->with['ordenes.productos'] = array(
                    'select' => false,
                    'joinType' => 'INNER JOIN',
//                   'condition' => '(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',
                      'group' => 'user.id'  
                    );                   
                     
                 }else{                     
                    if (!in_array('group', $criteria->with['ordenes.productos'])) {
                     $criteria->with['ordenes.productos']['group'] = 'user.id';
                    }                    
                 }                 
                
                if(!strpos($criteria->condition, 'productos_productos.look_id > 0')){
                   $criteria->addCondition('productos_productos.look_id > 0'); 
                }
                
                if(!strlen($criteria->having)){
                    $logicOp = '';
                }
                $criteria->having .= $logicOp.' SUM(productos_productos.cantidad) '. $comparator . ' ' . $value.' ';
                        
                continue;
            }
            
            if($column == 'looks_ps')
            { 

               if (!in_array('ordenes', $criteria->with)) {
                    $criteria->with['ordenes'] = array(
                        'select'=> false,
                        'joinType'=>'INNER JOIN',
                        'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',                        
                        
                    );
                }                
                /*
                if (!in_array('ordenes.productos', $criteria->with)) {
                     
                    $criteria->with['ordenes.productos'] = array(
                    'select' => false,
                    'joinType' => 'INNER JOIN',
//                   'condition' => '(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',
                      'group' => 'users.id'  
                    );                   
                     
                 }else{                     
                    if (!in_array('group', $criteria->with['ordenes.productos'])) {
                     $criteria->with['ordenes.productos']['group'] = 'user.id';
                    }                    
                 }                 
                */
                
                 if (!strpos($criteria->join, 'tbl_look')) {
                     
                   
				   
				    // $criteria->join .= ' left outer JOIN tbl_look looks ON (looks.id = look_id) '; 
                      $criteria->with['ordenes.looks'] = array();
                      /*
                      $criteria->mergeWith(array(
                          'join' => 'left outer JOIN tbl_look looks ON (looks.id = productos_productos.look_id)',
                      ));
					   * 
					   */
                 }
                                
               /*  
                if(!strpos($criteria->condition, 'productos_productos.look_id > 0')){
                   $criteria->addCondition('productos_productos.look_id > 0'); 
                }*/
                    
//                $criteria->compare('looks.user_id', $comparator . " " . $value, false, $logicOp);
               
                continue;
            }
            
            
            
            if ($column == 'lastorder_at')
            {
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);                
                
                //$criteria->compare('ordenes.' . $column, $comparator . " " . $value, false, $logicOp);

                if (!in_array('ordenes', $criteria->with)) {
                    $criteria->with['ordenes'] = array(
                        'select'=> false,
                        'joinType'=>'INNER JOIN',
                        'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',                        
                    );
                }
                               
                 $criteria->addCondition('(SELECT IFNULL(max(ordenes.fecha), 0) from tbl_orden ordenes
                                        WHERE ((ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8) AND (ordenes.user_id=user.id))) '
                                        .$comparator.' \''.$value.'\'');                 
                
                continue;
            }                       

            if ($column == 'lastvisit_at') {
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);
            }
            
            $criteria->compare($column, $comparator . " " . $value, false, $logicOp);
        }


        //$criteria->with = array('categorias', 'preciotallacolor', 'precios');
        $criteria->together = true;
        //$criteria->compare('t.status', '1'); //siempre los no eliminados

//        echo "Criteria:";
//
//        echo "<pre>";
//        print_r($criteria->toArray());
//        echo "</pre>";
//            exit();


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
