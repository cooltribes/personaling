<style>
    #modalPerfilesOcultos li {
        cursor: pointer;
            
    }
</style>
<div id="modalPerfilesOcultos" class="modal fade" aria-hidden="true" style="display: none;">        
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Todos tus perfiles</h3>
    </div>    
      
    <div class="modal-body ">
<!--        <p class="lead">Selecciona un perfil para alguien más</p> 
        <hr>-->
        <h4>Selecciona un perfil para alguien más:</h4>
        <div class="row-fluid margin_bottom_medium margin_top_medium">
            <div class="span6 offset3">                                     
                        
               <ul class="nav nav-tabs nav-stacked">
                <?php
                $otrosPerfiles = Filter::model()->findAllByAttributes(array('type' => '0', 'user_id' => Yii::app()->user->id),array('order' => 'id_filter DESC'));                            

                foreach($otrosPerfiles as $perfil){

                    echo '<li class="divider-vertical">
                        <a data-dismiss="modal" aria-hidden="true" id="'.$perfil->id_filter.
                            '" class="sub_perfil_item"><img width="30" height="30" class="img-circle avatar_menu" src="/develop/images/avatar_provisional_2_x30.jpg"> '.
                            $perfil->name.'</a></li>';                                    

                }
                ?>
               </ul>
            
            </div>
        </div>
        
    </div>
    
    <div class="modal-footer margin_top_medium_minus">
        <div class="">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'label' => 'Administrar Perfiles',
                'type' => 'danger',
                'url' => CController::createUrl('/user/profile/tusPerfiles'),
                //'size' => 'large', // null, 'large', 'small' or 'mini'
                //'block' => 'true',
                //'htmlOptions' => array('id' => 'save-search','class'=>'controls'),//'onclick' => 'js:$("#newFilter-form").submit();')
            ));          
            ?>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>
    </div>                    

</div>
<script type="text/javascript">

 //Click para seleccionar un peril de la lista que esta en el dropdown User
    $("#modalPerfilesOcultos li a").click(function(e){
        e.preventDefault();
        var urlActual = "<?php echo CController::createUrl(""); ?>";
        var tiendaLooks = "<?php echo CController::createUrl("/tienda/look"); ?>";        
        var redirect = "<?php echo CController::createUrl("/tienda/redirect"); ?>";        
        //si esta en tienda de looks
        if(urlActual === tiendaLooks){
            clickPerfil($(this).prop("id"));
        }else{
        
        //Llevar a tienda de looks
            var datos = $(this).prop("id");
            $.ajax({
                type: 'POST',
                url: redirect,
                dataType: 'JSON',
                data: {perfil : datos},
                success: function(data){

                    if(data.status == 'success'){

                      window.location = tiendaLooks;  

                    }else if(data.status == 'error'){
                        

                    }
                }
            });
        }
       
    });

</script>