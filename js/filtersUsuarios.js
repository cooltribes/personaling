/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(e){
   var column = $(this);
   
   var fecha = ['lastvisit_at', 'lastorder_at', 'create_at', 'create_at_2'];
   var opciones = ['status', 'tipoUsuario', 'fuenteR' , 'looks_marca',
                   'looks_ps'  , 'prods_marca', 'tipo_comision_2'];
   var texto = ['first_name'  , 'last_name', 'email'  , 'telefono', 'ciudad'];
               
   //si es fecha
   if(fecha.indexOf(column.val()) != -1) //Fechas
   {
       dateFilter(column);
    
   }else if(opciones.indexOf(column.val()) != -1) //Estado del usuario, tipo usuario, fuenteRegistro
   {       
       
       listFilter(column, column.val());
        

   }else if(texto.indexOf(column.val()) != -1) 
   {
       textFilter(column);       
        
   }else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}