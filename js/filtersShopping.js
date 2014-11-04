/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(e){
   var column = $(this);
   
   //si es fecha
   if(column.val() === 'fecha') //Fecha 
   {
       dateFilter(column);
    
   }else if(column.val() === 'navegador') 
   {       
       listFilter(column, 'navegador');

   }else if(column.val() === 'id' || column.val() === 'nombre_look'
                || column.val() === 'ps_id' || column.val() === 'ps_nombre'|| column.val() === 'fuente'
                || column.val() === 'ip'|| column.val() === 'vis_nombre' || column.val() === 'vis_id') 
   {
       textFilter(column);       
        
   }
	else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}