<?php if(!$voto): ?>

<div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#voto').hide();">×</button>
     <h3 >Tu elección</h3> 
</div>
<div  id="body_voto">
     <div style="width:500px; margin: 0 auto;">
         <?php echo $tweet['code'];?>
     </div> 
     
    <div class="margin_top text_align_center">
        <?php if(Yii::app()->user->isGuest): ?>
        <p>
            Para votar ingresa tus credenciales personaling <br/>
            si no estas registrado, introduce un correo electrónico y contraseña<br/>
            para formar parte de personaling.
        </p>
        <form method="post" id="voting" class="row-fluid no_margin_bottom"> 
            <div class="span6" >
               <input type="text" placeholder="Nombre" required="required" name='first_name' id='first_name'/>
            </div>
            <div class="span6" >
               <input type="text" placeholder="Apellido" required="required"  name='last_name'  id='last_name'/ >
            </div>
            <div class="span6 no_margin_left" >
               <input type="email" placeholder="Correo Electrónico" required="required" name='email' id='email' />
            </div>
            <div class="span6" >
               <input type="password" placeholder="Contraseña" required="required"  name='password' id='password'/ >
            </div>
       
            <input type="submit" class="text_center_align btn btn-danger margin_bottom" value="Registrar Voto">
            
    
        </form>
        
        
        
        
        <?php else: ?>
            
            <input onclick="votoLogueado()" class="text_center_align btn btn-large btn-danger margin_bottom" value="Registrar Voto">
            
            
        <?php endif; ?>
    </div>
</div>
<script>
      $("#voting").submit(function(event){
  
       event.preventDefault();
       regVoto();
  
    
  });
  
   function regVoto(){
  
      var email=$('#email').val();
      var first_name=$('#first_name').val();
      var last_name=$('#last_name').val();
      var password=$('#password').val();
      var id=<?php echo $id; ?>;  
      $.ajax({ 
                      url: "site/poderosas",
                      type: "post",
                      datatype:'json',
                      data: {
                       id:id,
                       email:email,
                       first_name:first_name,
                       last_name:last_name,
                       password:password,           
                        
                        
                         },
                      success: function(data){
                         // console.log(data);
                          var obj=JSON.parse(data);
                         
                              $('#myModal').html(obj.html);    
                              $('#myModal').modal();                           
                          }
                                              
                      ,
                      error: function(){
                  
                      }
                });
}

function votoLogueado(){
     var id=<?php echo $id; ?>;  
      $.ajax({ 
                      url: "site/poderosas",
                      type: "post",
                      datatype:'json',
                      data: {
                       id:id,

                         },
                      success: function(data){
                         // console.log(data);
                          var obj=JSON.parse(data);
                         
                              $('#myModal').html(obj.html);    
                              $('#myModal').modal();                           
                          }
                                              
                      ,
                      error: function(){
                  
                      }
                });
    
}
   
  
</script>
<?php else: 
        if(isset($new)):     
            if($new):     
?>
<div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#voto').hide();">×</button>
     <h3>Voto registrado</h3> 
</div>
<div  id="body_voto" class="text_align_center">
    <p class="margin_top margin_bottom">Gracias por participar en nuestro concurso</p> 
    <p class="margin_top margin_bottom">Te invitamos a completar tu perfil para que obtengas todas las recomendaciones que nuestros expertos han preparado para tí</p>
    <a class="text_center_align btn btn-large btn-danger margin_bottom" href="user/profile/tutipo">Completar mi perfil</a> 
    
</div>


    <?php else: ?>   
<div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#voto').hide();">×</button>
     <h3 >Felicidades</h3> 
</div>
<div  id="body_voto" class="text_align_center">
    <p class="margin_top margin_bottom">Gracias por participar en nuestro concurso</p> 
    <p class="margin_top margin_bottom">Te invitamos a ver los looks que nuestros expertos han preparado para tí</p>
    <a class="text_center_align btn btn-large btn-danger  margin_bottom" href="looks-personalizados">Ver looks</a> 
    
</div>        
        
    
<?php    endif;
    else:       
        if(isset($error)):?>
<div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#voto').hide();">×</button>
     <h3 >Los sentimos</h3> 
</div>
<div  id="body_voto" class="text_align_center">
    <p class="margin_top margin_bottom">Hemos tenido un problema registrando tu voto</p> 
    <p class="margin_top margin_bottom">Te invitamos a elegir de nuevo ese tweet que te identifica y registrar tu voto.</p>
    <a class="text_center_align btn btn-large btn-danger margin_bottom pointer" onclick="$('#voto').hide();" >Ver los tweets</a> 
    
</div> 
        
        
 <?php       
        endif;
        if(isset($repeated)):        
        ?> 
<div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#voto').hide();">×</button>
     <h3 >Uuupssss!</h3> 
</div>
<div  id="body_voto" class="text_align_center">
    <p class="margin_top margin_bottom">Al parecer ya votaste en nuestro concurso</p> 
    <p class="margin_top margin_bottom">Te invitamos a ver los looks que nuestros expertos han preparado para tí</p>
    <a class="text_center_align btn btn-large btn-danger margin_bottom" href="looks-personalizados">Ver looks</a> 
    
</div>
        
<?php   
        endif;     
    endif;
endif;?>