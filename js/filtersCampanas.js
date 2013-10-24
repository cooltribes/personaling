/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(e){
   var column = $(this);
   
   
   if(column.val() === 'recepcion_inicio' || column.val() === 'recepcion_fin'
   || column.val() === 'ventas_inicio' || column.val() === 'ventas_fin') //si es fecha
   {
       
        dateFilter(column);
    
    
   }else if(column.val() === 'estado' || column.val() === 'personalS') //si es listado - dropdown
   {       
       
       listFilter(column, column.val());
        
        
   }else if(column.val() === 'first_name')  //si es campo de texto
   {
       textFilter(column);       
        
   }else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}