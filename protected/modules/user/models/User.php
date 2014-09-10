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
    
    //Tipo de Usuario
    const TYPE_PSAPPLY = 2;
    

    //Vector de estados para dropdown
    public static $statuses = array(self::STATUS_ACTIVE => 'Activo', 
        self::STATUS_NOACTIVE => 'Inactivo', self::STATUS_BANNED => 'Bloqueado',
        self::STATUS_DELETED => 'Eliminado');
	
	public $id_psShopper;
	
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
     * @var int $ps_destacado
	 * @var integer $interno
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
                    array('id, username, password, email, activkey, create_at, lastvisit_at,visit, superuser, status,status_register,privacy,personal_shopper, twitter_id, facebook_id, avatar_url, banner_url, ps_destacado, zoho_id, tipo_zoho, admin_ps, id_psShopper', 'safe', 'on' => 'search'),
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
        $relations['saldo'] = array(self::STAT, 'Balance', 'user_id',
            'select' => 'SUM(total)',
        );
        $relations['direccionCount'] = array(self::STAT, 'Direccion', 'user_id',
            'select' => 'COUNT(*)',
        );
        $relations['ordenCount'] = array(self::STAT, 'Orden', 'user_id',
            'select' => 'COUNT(*)',
        );
        
        $relations['ordenes'] = array(self::HAS_MANY, 'Orden', 'user_id',

//                        'select'=>false,
//                        'joinType'=>'INNER JOIN',
//                        'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',
            );
        $relations['looks'] = array(self::HAS_MANY, 'Look', 'user_id',

//                        'select'=>false,
//                        'joinType'=>'INNER JOIN',
                        'condition'=>'(looks.status = '.Look::STATUS_APROBADO.')',
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
            'status_register' => UserModule::t("Status Register"),
            'twitter_id' => UserModule::t("Twitter ID"),
            'facebook_id' => UserModule::t("Facebook ID"),
            'avatar_url' => UserModule::t("Avatar"),
            'banner_url' => "Banner",
            'ps_destacado' => "Destacado",
            'url' => "Alias",
            'zoho_id' => 'ID Zoho',
            'tipo_zoho' => 'Tipo Zoho',
            'interno' => "Interno",
             'admin_ps' => "Status de Personal Shopper",
            'id_psShopper' => "Usuario que hizo el Cambio",
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
                'select' => 'id, username, password, email, activkey, create_at, lastvisit_at,visit, superuser, status, status_register,privacy,personal_shopper,twitter_id, facebook_id,avatar_url, banner_url, ps_destacado, interno',
            ),
        );
    }

    public function defaultScope() {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope, array(
            'alias' => 'user',
            'select' => 'user.id, user.username, user.email, user.create_at,
                user.lastvisit_at, user.visit, user.superuser, user.status,
                user.status_register, user.privacy, user.personal_shopper,
                user.twitter_id, user.facebook_id, user.avatar_url, user.banner_url, 
                user.ps_destacado, user.zoho_id, user.tipo_zoho, user.interno, user.suscrito_nl, user.admin_ps, user.fecha_ps',

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
        $criteria->compare('ps_destacado', $this->ps_destacado);
		$criteria->compare('zoho_id', $this->zoho_id);		
		$criteria->compare('tipo_zoho', $this->tipo_zoho);	
		
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

        $criteria = new CDbCriteria;

        $criteria->with = array();
        $criteria->select = array();
         
        /*Ver si hay un filtro para PS*/
        $paraPS = false;
        foreach ($filters['fields'] as $key => $campo) {
            if(strpos($campo, "_2")){
                $paraPS = true;                          
                $filters['fields'][$key] = strtr($campo, array("_2"=>"")); 
            }
        }
        //buscar solo dentro de los PS
        if($paraPS) $criteria->compare("personal_shopper", 1);

        //recorrer los filtros para armar el criteria
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

            if ($column == 'zoho_id')
            {
                $criteria->addCondition('(zoho_id = "" OR zoho_id IS NULL'.')', $logicOp);

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

                    
                }else if($value === 'aplica')
                {
                    $criteria->compare("personal_shopper", $comparator.'2', false, $logicOp);

                    
                }else if($value === 'psDes')
                {
                    $criteria->compare("ps_destacado", $comparator.'1', false, $logicOp);

                    
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
            /*Saldo disponible*/
            if($column == 'balance')
            { 
                
                 $criteria->addCondition('(IFNULL(
                     (
                        SELECT SUM(total) as total FROM tbl_balance WHERE user_id = user.id 
                               
                      ), 0))  '
                                        . $comparator . ' ' . $value . '', $logicOp);
                        
                continue;
            }
            
            /*Invitaciones*/
            if($column == 'invitaciones')
            { 
                
                 $criteria->addCondition('(IFNULL(
                     (
                        (SELECT count(*) as total FROM tbl_email_invite WHERE user_id=user.id) 
                        + 
                        (SELECT count(*) as total FROM tbl_facebook_invite WHERE user_id=user.id)
                               
                      ), 0))  '
                     . $comparator . ' ' . $value . '', $logicOp);
                        
                continue;
            }

            if($column == 'looks')
            { 
                
                $criteria->with['ordenes'] = array(
                    'select'=> false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',                        

                );

                $criteria->with['ordenes.productos'] = array(
                'select' => false,
                'joinType' => 'INNER JOIN',
//                   'condition' => '(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',
                  'group' => 'user.id'  
                );                   

                $criteria->with['ordenes.productos']['group'] = 'user.id';
                                
                
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
                
                $criteria->with['ordenes'] = array(
                    'select'=> false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',                        

                );

                $criteria->with['ordenes.looks'] = array(
                    'select'=> false,
                    'joinType'=>'INNER JOIN',
                );
                 
                
                $criteria->addCondition('looks.user_id  '
                                        . $comparator . ' ' . $value . '', $logicOp);
               
                continue;
            }
              
            if($column == 'prods_marca')
            {    
                
                $criteria->with['ordenes'] = array(
                    'select'=> false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'(ordenes.estado = 3 OR ordenes.estado = 4 OR ordenes.estado = 8)',                        

                );

                $criteria->with['ordenes.productos'] = array(
                    'select'=> false,
                    'joinType'=>'INNER JOIN',
                );
                
                $criteria->with['ordenes.productos.producto'] = array(
                    'select'=> false,
                    'joinType'=>'INNER JOIN',
                );
                 
                
                $criteria->addCondition('producto.marca_id  '
                                        . $comparator . ' ' . $value . '', $logicOp);
               
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

            /*Looks vendidos por PS*/
            if($column == 'looks_vendidos')
            {
                
            }

            /*Saldo ganado por comisiones*/
            if($column == 'saldoComisiones')
            {                 
                 $criteria->addCondition('(IFNULL(
                     (
                        SELECT SUM(total) as total FROM tbl_balance WHERE user_id = user.id
                        AND tipo = 5

                      ), 0))  '
                    . $comparator . ' ' . $value . '', $logicOp);
                        
                continue;
            }
            
            if ($column == 'lastvisit_at' || $column == 'create_at' || $column == 'birthday')
            {
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);
            }
            
            /*Compras realizadas*/
            if($column == 'compras')
            { 
                
                 $criteria->addCondition('(IFNULL(
                     (
                        (SELECT count(*) as total FROM tbl_orden WHERE user_id=user.id)                         
                               
                      ), 0))  '
                     . $comparator . ' ' . $value . '', $logicOp);
                        
                continue;
            }
                    
            /*Prendas compradas*/
            if($column == 'prendas')
            { 
                
                 $criteria->addCondition('(IFNULL(
                     (
                        (SELECT SUM(oh.cantidadActualizada)
                         FROM tbl_orden_has_productotallacolor oh
                         JOIN tbl_orden o ON o.id = oh.tbl_orden_id
                         WHERE o.user_id=user.id)                         
                               
                      ), 0))  '
                     . $comparator . ' ' . $value . '', $logicOp);
                        
                continue;
            }
            
            
            //Comparar normal
            $criteria->compare($column, $comparator . " " . $value, false, $logicOp);
        }
        
        $criteria->together = true;        

//        echo "<br>Criteria:<br>";
//        echo "<pre>";
//        print_r($criteria->toArray());
//        echo "</pre>";
//        Yii::app()->end();   


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

   
    
		public function getTotalPS()
	{
		$sql = "select count(*) from tbl_users where personal_shopper = 1";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	} 
	
	public function getTotalAdmin()
	{
		$sql = "select count(*) from tbl_users where superuser = 1";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	} 
	public function getTotalClients()
	{
		$sql = "select count(*) from tbl_users where superuser = 0 AND personal_shopper = 0";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	} 
	
	public function getTotal()
	{
		$sql = "select count(*) from tbl_users where (superuser = 0 AND personal_shopper = 0) OR superuser = 1 OR personal_shopper = 1";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}
	
	public function getAplicantes()
	{
		$sql = "select count(*) from tbl_users where personal_shopper = 2";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	} 
	
	public function getPercent($rol){
		switch ($rol) {
		    case 'Admin':
		        $perc=round($this->getTotalAdmin()*100/$this->getTotal(),2);
		        break;
		    case 'PS':
		        $perc=round($this->getTotalPS()*100/$this->getTotal(),2);
		        break;
		    case 'Client':
		        $perc=round($this->getTotalClients()*100/$this->getTotal(),2);
		        break;
			case 'App':
		        $perc=round($this->getAplicantes()*100/$this->getTotal(),2);
		        break;
		    default:
		       $perc=0;
				break;
		}
		return $perc;
	}
	
	
	
	protected function beforeSave()
	{
	   	
	   if($this->personal_shopper>0)
	   		$this->banner_url='/images/banner/default.gif';
	   //echo $this->birthday;
	   return parent::beforeSave();
	}
	
	public function getLast3($rol){
		

		
		switch ($rol) {
		    case 'Admin':
		        $sql = "select id from tbl_users where superuser = 1 order by create_at desc limit 0,3";
				$total = Yii::app()->db->createCommand($sql)->queryColumn();
		        break;
		    case 'PS':
		        $sql = "select id from tbl_users where personal_shopper = 1 order by create_at desc limit 0,3";
				$total = Yii::app()->db->createCommand($sql)->queryColumn();
		        break;
		    case 'Client':
		        $sql = "select id from tbl_users where superuser = 0 AND personal_shopper = 0 order by create_at desc limit 0,3";
				$total = Yii::app()->db->createCommand($sql)->queryColumn();
		        break;
			case 'App':
		        $sql = "select id from tbl_users where personal_shopper = 2 order by create_at desc limit 0,3";
				$total = Yii::app()->db->createCommand($sql)->queryColumn();
		        break;
		    default:
		       $sql = "select id from tbl_users order by create_at desc limit 0,3";
				$total = Yii::app()->db->createCommand($sql)->queryColumn();
				break;
		}
	
		return $total;
		
		
	}
	
	public function getCreate_at($id = null){
		if(!is_null($id))
		{
			$null=$this->findByPk($id);	
			return $null->create_at; 		
		}
		return $this->create_at; 
	}
	
	public function getUsername($id = null){
		if(!is_null($id))
		{
			$null=$this->findByPk($id);	
			return $null?$null->username:"No Existe"; 		
		}
		return $this->username; 
	} 
        
        
	public function getEdad(){
            
            $hoy = new DateTime();
            $edad = $hoy->diff(DateTime::createFromFormat('Y-m-d', $this->profile->birthday));
            return $edad->y;
            
	} 
        
        /*Calcula el saldo que tiene una PS percibido por comisiones en ventas*/
        function getSaldoPorComisiones($format = true) {
            
            //Balance tipo 5 = por commisiones
            $saldo = Yii::app()->db->createCommand(
                    "SELECT SUM(total) as total FROM tbl_balance WHERE tipo IN
                     (5, 7, 8)
                     AND user_id = ".$this->id)
                    ->queryScalar();            

            return $format ? Yii::app()->numberFormatter->format("#,##0.00",$saldo) : $saldo;            

        }
        /*Calcula el saldo que está en solicitudes sin aprobar para PS*/
        function getSaldoEnEspera($format = true) {
                        
            $saldo = Yii::app()->db->createCommand(
                    "SELECT SUM(total) as total FROM tbl_balance WHERE tipo IN
                     (7, 8)
                     AND user_id = ".$this->id)
                    ->queryScalar();
            
//            return $format ? Yii::app()->numberFormatter->formatCurrency($saldo, "") : $saldo;            
            return $format ? Yii::app()->numberFormatter->format("#,##0.00",$saldo) : $saldo;            
//            return $saldo;            
        }
        
        /*Todos los productos vendidos como parte de looks de una PS*/
        function getProductosVendidos() {
            
            //Guardar los ids de los looks de esta PS
            $looksIds = array();
            foreach($this->looks as $look){
                $looksIds[] = $look->id;
            }
            
            //Si no tiene looks, los productos vendidos son 0
            if(empty($looksIds)){
                return 0;
            }
            
            //buscar ventas de esos looks.
            $total = Yii::app()->db->createCommand()->select("IFNULL(SUM(o.cantidad), 0)")
                    ->from("tbl_orden_has_productotallacolor as o")
                    //Incluir solamente los que han sido pagados                    
                    ->where("status_comision = :status", 
                            array(":status" => OrdenHasProductotallacolor::STATUS_PAGADA))
                    //incluir los pertenecientes al usuario
                    ->andWhere(array("in", "o.look_id", $looksIds))
                    ->queryScalar();
            
            
            return $total;
        }
	 
        /*Todos los productos vendidos como parte de looks de una PS*/
        function getLooksVendidos() {
            
           
            $total = 0;
            return $total;
        }
        
        /*Obtiene la comision del PS formateada de acuerdo al tipo (% o fijo)*/
        function getComision() {
           
            $comision = $this->profile->comision . " ";
            
            //Porcentaje
            if($this->profile->tipo_comision == 1){
                
                $comision .= "%";
                
            }else if($this->profile->tipo_comision == 2){
                
                $comision .= Yii::t('contentForm', 'currSym');
                
            }
            
            return $comision;
        }
        
        
        /*Obtiene el tiempo de validez de productos en la bolsa*/
        function getValidezBolsa() {
           
            $valores = array(15 => "15 Días",
                    30 => "1 Mes", 90 => "3 Meses", 180 => "6 Meses", 360 => "1 Año");
            
            return $valores[$this->profile->tiempo_validez];
            
        }
		
		function is_personalshopper($id){
			$user=User::model()->findByPk($id);
			return $user->personal_shopper;
		}
                
                
        /* 
         * Buscar la ultima orden del usuario y ver si fue hace menos de un minuto
         * Se usa para validar que no se hagan compras seguidas por error.
         */
        public static function hasRecentOrder(){            
            
            $orden = Orden::model()->findByAttributes(array("user_id" => Yii::app()->user->id),
                    array("order" => "fecha DESC")
                    );

            if(!$orden){
                return false;
            }
            
            $haceUnMinuto = time() - 60;
            $fechaOrden = strtotime($orden->fecha);            
                
//            echo "<br>";
//            echo "<br>unmi ". $haceUnMinuto;
//            echo "<br>orden ". $fechaOrden;
//            
//            Yii::app()->end();
            
            
            return  $fechaOrden >= $haceUnMinuto;            
            
        }
		
		
	
        

}
