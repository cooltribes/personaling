/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(e){
   var column = $(this);
   
   //si es fecha
   if(column.val() === 'created_on') //Fecha de carga
   {
       dateFilter(column);
    
   }else if(column.val() === 'status' || column.val() === 'user_id') 
   {       
       listFilter(column, column.val());

   }else if(column.val() === "campana") 
   {
       textFilter(column);       
        
   }else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}