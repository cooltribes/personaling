/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function changeFilter(e){
   var column = $(this);
   
   if(column.val() === 'fecha'){ //si es fecha

        dateFilter(column);
   
   }else if(column.val() === 'pago_id'){  //metodo de pago
       
        listFilter(column, 'metodosPago');
    
   }else if(column.val() === 'estado'){ //Estado de la Orden
       
       listFilter(column, 'estadosOrden');
    
   }else if(column.val() === 'user_id'){ //campo nombre usuario
       
        textFilter(column);
    
   }else{      //campo normal (valores numericos)
        valueFilter(column);       
   }
    
}