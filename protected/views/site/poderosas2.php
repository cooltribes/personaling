<div class="margin_top">
    <img width="100%" src="<?php echo Yii::app()->getBaseUrl();?>/images/concurso/concursoF2.jpg">
</div>
<style>
    
    
</style>
<p class="margin_top text_align_center" >
    Miles de mujeres en toda Venezuela compartieron con nosotros y con el mundo las razones que tienen para sentirse poderosas ¡Y ahora te toca a ti decidir quién es la ganadora de nuestro concurso #MeSientoPoderosa por un Día Personaling (Personaling Day) de la mano de nuestros fabulosos Personal Shoppers y Estilistas
    
</p>
<div class="row margin_top">
    <div class="span10 offset1 ">
        <section class="row-fluid">

                        <article class="span3 pShopper">
                        <a href="http://www.personaling.com.ve/HarryLevy" title="Harry Levy">                        
                            <div>
                                <img alt="Harry Levy" src="<?php echo Yii::app()->getBaseUrl();?>/images/concurso/hlevy.jpg" width="100%"/>                        
                            </div>
                         </a>   
                            <div class="bio">
                                  <a href="http://www.personaling.com.ve/HarryLevy">   
                                      <h4 class="text_center_align">
                                          Harry Levy
                                      </h4>
                                 </a>
                               <!--  <small> <?php //echo $ps1->profile->bio ?> </small>  -->                     
                            </div>
                        </article>
                        
                        <article class="span3 pShopper">
                        <a href="http://tubellezaparallevar.com/" title="Bárbara Rodríguez">                        
                            <div>
                                <img alt="Bárbara Rodríguez" src="<?php echo Yii::app()->getBaseUrl();?>/images/concurso/brodriguez.jpg" width="100%"/>                        
                            </div>
                         </a>   
                            <div class="bio">
                                  <a href="http://tubellezaparallevar.com/">   
                                      <h4 class="text_center_align">
                                          Bárbara Rodríguez
                                      </h4>
                                 </a>
                               <!--  <small> <?php //echo $ps1->profile->bio ?> </small>  -->                     
                            </div>
                        </article>
                        
                        <article class="span3 pShopper">
                        <a href="https://twitter.com/AgustinBozzo" title="Agustín Bozzo">                        
                            <div>
                                <img alt="Agustín Bozzo" src="<?php echo Yii::app()->getBaseUrl();?>/images/concurso/abozzo.jpg" width="100%"/>                        
                            </div>
                         </a>   
                            <div class="bio">
                                  <a href="https://twitter.com/AgustinBozzo">   
                                      <h4 class="text_center_align">
                                          Agustín Bozzo
                                      </h4>
                                 </a>
                               <!--  <small> <?php //echo $ps1->profile->bio ?> </small>  -->                     
                            </div>
                        </article>
                        
                        <article class="span3 pShopper">
                        <a href="https://twitter.com/HGKripsy" title="Kripsy Herrera">                        
                            <div>
                                <img alt="Kripsy Herrera" src="<?php echo Yii::app()->getBaseUrl();?>/images/concurso/kherrera.jpg" width="100%"/>                        
                            </div>
                         </a>   
                            <div class="bio">
                                  <a href="https://twitter.com/HGKripsy">   
                                      <h4 class="text_center_align">
                                          Kripsy Herrera
                                      </h4>
                                 </a>
                               <!--  <small> <?php //echo $ps1->profile->bio ?> </small>  -->                     
                            </div>
                        </article>
                        

           
        </section>
    </div>
</div>


<p class="margin_top text_align_center" >
    No fue nada fácil, lo reconocemos, pero después de leer con mucho cuidado cada uno de sus maravillosos tuits, <strong>seleccionamos los 10 mejores y creativos</strong>    
</p>

<h3 class="text_align_center  Bold">
    ¡Te invitamos a votar más abajo por el que más te guste! 
</h3>
<section class="row margin_top">
<?php

    foreach($tweets as $key=>$tweet):
?>
    <article class="contest-box span4 <?php echo $key==9?'offset2':'' ?> margin_bottom well_outer">
            <h4 class="text_align_right margin_right_small margin_bottom_small_minus">
                <small>votos: <b><?php echo UserPromocion::model()->countxValor($key); ?></b></small>
            </h4>
            <div class="tweet-frame">
               <?php echo $tweet['code']; ?>  
                  
              
            </div>
            <div class="button-vote">
                 <a id="t0" class="btn btn-large btn-danger width_complete no_padding_left no_padding_right pointer " onclick="votar(<?php echo $key; ?>)"> Vota por <?php echo $tweet['user'] ?></a>
            </div>
   
    </article>

<?php endforeach; ?>
</section>
<h3 class="text_align_center Bold">
    Anunciaremos a la ganadora final el 23 de marzo de 2015.
</h3>
<style>
    
</style>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<script>
    function votar(id){
    
        
      $.ajax({ 
                      url: "site/modalVoto",
                      type: "post",
                      datatype:'json',
                      data: {
                       id:id,                
                        
                        
                         },
                      success: function(data){
                         // console.log(data);
                          var obj=JSON.parse(data);
                         
                              $('#myModal').html(obj.form);    
                              $('#myModal').modal();                           
                          }
                                              
                      ,
                      error: function(){
                  
                      }
                });
}

    
</script>