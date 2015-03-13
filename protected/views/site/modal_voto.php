<div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#voto').hide();">×</button>
     <h3 >Tu elección</h3> 
</div>
<div  id="body_voto">
     <div style="width:500px; margin: 0 auto;">
         <?php echo $tweet['code'];?>
     </div> 
    <div class="margin_top text_align_center">
        <p>
            Para votar ingresa tus credenciales personaling <br/>
            si no estas registrado, introduce un correo electrónico y contraseña<br/>
            para formar parte de personaling.
        </p>
        <form method="post" id="voting" class="row-fluid no_margin_bottom"> 
            <div class="span6" >
               <input type="text" placeholder="Nombre" required="required" name='first_name'/>
            </div>
            <div class="span6" >
               <input type="text" placeholder="Apellido" required="required"  name='last_name'/ >
            </div>
            <div class="span6 no_margin_left" >
               <input type="email" placeholder="Correo Electrónico" required="required" name='email'/>
            </div>
            <div class="span6" >
               <input type="password" placeholder="Contraseña" required="required"  name='password'/ >
            </div>
       
            <input type="submit" class="text_center_align btn btn-danger margin_bottom_small" value="Registrar Voto">
            
    
        </form>
    
    </div>
</div>
<script>
      $("#voting").submit(function(event){
  
       event.preventDefault();
       regVoto(); 
    
  });
  
   function regVoto(){
      email=$('#email').val();
      nombre=$('#email').val();
      apellido=$('#email').val();
      password=$('#email').val();
      id=1;  
      $.ajax({ 
                      url: "site/poderosas",
                      type: "post",
                      datatype:'json',
                      data: {
                       id:id,
                       email:email,
                       nombre:nombre,
                       apellido:apellido,
                       password:password,                
                        
                        
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
