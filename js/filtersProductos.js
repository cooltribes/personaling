/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(e){
   var column = $(this);
   
   //si es fecha
   if(column.val() === 'fecha') //Fecha de carga
   {
       dateFilter(column);
    
   }else if(column.val() === 'estado') //Estado del producto
   {       
       listFilter(column, 'estados');

   }else if(column.val() === 'marca_id') //Marca del producto
   {       
       listFilter(column, 'marcas');

   }else if(column.val() === 'tienda_id') //Tienda del producto
   {       
       listFilter(column, 'tiendas');

   }else if(column.val() === 'codigo' || column.val() === 'categoria'
                || column.val() === 'sku') 
   {
       textFilter(column);       
        
   }else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}