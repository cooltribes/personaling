<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{            
		if(isset($_POST['datos']))
		{   
			$usuario = User::model()->findByAttributes(array('email'=>$_POST['email']));
	
			if($usuario){
				//echo 'usuario existe';
				
				$this->_model = $usuario;
				$session = new CHttpSession;
				$session->open();
				$session['username'] = $this->_model->username;
				Yii::app()->user->setState('username', $this->_model->username);
				Yii::app()->user->setState('id', $this->_model->id);
				$identity = new UserIdentity($this->_model->username, '');
		
				Yii::app()->user->login($identity, 3600);
				
				
			}else{
				
			}
			
		}

		if (Yii::app()->user->isGuest) {
                    
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
                            
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				
				if($model->validate()) {
                    ShoppingMetric::registro(ShoppingMetric::USER_INICIO);                
					$this->lastViset();
					$user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
                                        
                                        $this->revisarBolsaGuest();
                                        
					if (UserModule::isAdmin()){
                                            if (Yii::app()->user->returnUrl=='/index.php'){
                                                $this->redirect(Yii::app()->controller->module->returnUrl);
                                            }else{                                                                                                
                                                $this->redirect(Yii::app()->user->returnUrl);
                                            }
					} else {
						if($user->profile->sex == 2) 
                                                    $this->redirect(array('/tienda/look'));
						else{
                                                    if ($user->status_register == User::STATUS_REGISTER_ESTILO || !Yii::app()->params['registro']) {
                                                        //Yii::trace('username:'.$model->username.' Error ESTILO: '.$user->status_register, 'registro');
                                                        $referrer = explode('/', Yii::app()->request->urlReferrer);
                                                        if ($referrer[count($referrer) - 1] == 'login') {
                                                            if ($user->personal_shopper != 1)
                                                                $this->redirect(array('/tienda/look'));
                                                            else
                                                                $this->redirect(array('/look/create'));
                                                        }
                                                        if (Yii::app()->user->returnUrl == '/index.php')
                                                            $this->redirect(Yii::app()->controller->module->returnUrl);
                                                        else
                                                            $this->redirect(Yii::app()->user->returnUrl);
                                                    } elseif ($user->status_register == User::STATUS_REGISTER_TIPO) {
                                                        $this->redirect(array("/user/profile/tuestilo"));
                                                    } elseif ($user->status_register == User::STATUS_REGISTER_NEW) {
                                                        //Yii::trace('username:'.$model->username.' Error NEW: '.$user->status_register, 'registro');
                                                        $this->redirect(array("/user/profile/tutipo"));
                                                    }
						}
					}
				}
				
				
			}
 			
 			$seo = SeoStatic::model()->findByAttributes(array('name'=>'Inicio de sesión'));
			// display the login form
			$this->render('/user/login',array('model'=>$model, 'seo'=>$seo));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->visit = $lastVisit->visit+1;
		$lastVisit->save();
		
	}
		
	public function actionLoginfb()
	{
	$usuario = User::model()->findByAttributes(array('email'=>$_POST['email']));
	
			if($usuario){
				$session = new CHttpSession;
				$session->open();
				$session['username'] = $usuario->username;
				
				
				if(strlen($usuario->profile->ciudad)<3){
					$profile=Profile::model()->findByPk($usuario->id);
					$profile->profile_type=1;
					$profile->ciudad=$_POST['ciudad'];
					if($profile->pais==0){
						if(Yii::app()->language=='es_es')
							$profile->pais=1;
						else
							$profile->pais=2;
					}
					$profile->save();
						
				}
				
				Yii::app()->user->setState('username', $usuario->username);
				Yii::app()->user->setState('id', $usuario->id);
				Yii::app()->user->allowAutoLogin = true;
				
				$identity = new UserIdentity($usuario->username, '');
				$identity->facebook();
				
				Yii::app()->user->login($identity, 3600);
				
				if(!Yii::app()->user->isGuest)
					//echo Yii::app()->user->id." ".Yii::app()->user->name;
					echo "existe";
				 
			}else{
				echo "no";
			}
	
		
	}//loginfb
    
        //Revisar si tenia algo en la bolsa
        private function revisarBolsaGuest() {
            
            if(!Yii::app()->getSession()->contains("Bolsa")){
                return;
            }
            
            $bolsaGuest = Yii::app()->getSession()->get("Bolsa");
            Yii::app()->getSession()->remove("Bolsa");  
            
            //si es admin eliminar la bolsa
            if(!UserModule::isAdmin()){
                //llena la bolsa del usuario que inicia sesion con los produtos
                //que habian en la bolsa de Guest y borra la variable de sesion
                Bolsa::pasarBolsaGuest($bolsaGuest);
                
                //redirigir a la bolsa para que compre de una vez
                $this->redirect(array("/bolsa/index"));
            }
        }
        

}