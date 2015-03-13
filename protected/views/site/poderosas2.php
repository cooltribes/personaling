<div class="margin_top" style="height:280px; background-color:#BBB">
    
</div>

<p class="margin_top text_align_center" >
    Miles de mujeres en toda Venezuela compartieron con nosotros y con el mundo las razones que tienen para sentirse poderosas ¡Y ahora te toca a ti decidir quién es la ganadora de nuestro concurso #MeSientoPoderosa por un Día Personaling (Personaling Day) de la mano de nuestros fabulosos Personal Shoppers y Estilistas
    
</p>
<div class="row margin_top">
    <div class="span10 offset1">
        <section class="row-fluid">
           <?php foreach (User::model()->psDestacados(4) as $ps1): ?>
                        <article class="span3 pShopper">
                        <a href="<?php echo $ps1->profile->getUrl(); ?>">                        
                            <div>
                                <img alt="<?php echo $ps1->profile->first_name . " " . $ps1->profile->last_name; ?>" src="<?php echo $ps1->getAvatar(); ?>" width="100%"/>                        
                            </div>
                         </a>   
                            <div class="bio">
                                  <a href="<?php echo $ps1->profile->getUrl(); ?>">   
                                      <h4 class="text_center_align">
                                          <?php echo $ps1->profile->getNombre(); ?>
                                      </h4>
                                 </a>
                               <!--  <small> <?php //echo $ps1->profile->bio ?> </small>  -->                     
                            </div>
                        </article>
                        
                    <?php endforeach; ?>
           
        </section>
    </div>
</div>


<p class="margin_top text_align_center" >
    No fue nada fácil, lo reconocemos, pero después de leer con mucho cuidado cada uno de sus maravillosos tuits, <strong>seleccionamos los 10 mejores y creativos</strong>    
</p>

<p class="text_align_center">
    ¡Te invitamos a votar más abajo por el que más te guste! 
</p>
<section class="row margin_top">
<?php

    foreach($tweets as $key=>$tweet):
?>
    <article class="span4 <?php echo $key==9?'offset4':'' ?> margin_bottom">
        
            <div>
               <?php echo $tweet['code']; ?>  
                  
              
            </div>
            <div>
                 <a id="t0" class="btn btn-danger width_complete no_padding_left no_padding_right pointer " onclick="votar(1)"> Vota por <?php echo $tweet['user'] ?></a>
            </div>
   
    </article>

<?php endforeach; ?>
</section>
<p class="text_align_center">
    Anunciaremos a la ganadora final el 23 de marzo de 2015.
</p>
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