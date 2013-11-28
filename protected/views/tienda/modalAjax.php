<div id="modalPerfilesOcultos" class="modal fade" aria-hidden="true" style="display: none;">        
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Todos tus perfiles</h3>
    </div>    
      
    <div class="modal-body ">
        <div class="dropdown open">
            <ul class="dropdown-menu">
                <li>
                  <a class="sub_perfil_item"  tabindex="-1" href="#">
                      <img width="30" height="30" class="img-circle avatar_menu" src="/develop/images/avatar_provisional_2_x30.jpg">
                      Nuevo Perfil de ...
                  </a>  
                </li>
            </ul>
        </div>
            
        <?php 
        
            $otrosPerfiles = Filter::model()->findAllByAttributes(array('type' => '0', 'user_id' => Yii::app()->user->id),array('order' => 'id_filter DESC'));
            echo "Pruesssa";
            foreach($otrosPerfiles as $perfil){
                

//                $itemsUser[] = array('label'=>'<img width="30" height="30" class="img-circle avatar_menu" src="/develop/images/avatar_provisional_2_x30.jpg">'.$perfil->name,
//                    'url'=>'#',
//                    'linkOptions' => array('class' => 'sub_perfil_item', 'id' => $perfil->id_filter),
//                    //'itemOptions' => array('id' => $perfil->id_filter),
//                    );
                
                echo "EEE<br>";

            }
        
        ?>
        
    </div>
    
    <div class="modal-footer margin_top_medium_minus">
        <div class="">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'label' => 'Administrar Perfiles',
                'type' => 'danger',
                'url' => '#'
                //'size' => 'large', // null, 'large', 'small' or 'mini'
                //'block' => 'true',
                //'htmlOptions' => array('id' => 'save-search','class'=>'controls'),//'onclick' => 'js:$("#newFilter-form").submit();')
            ));          
            ?>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>
    </div>                    

</div>