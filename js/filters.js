/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function add_row(e){
    
    e.preventDefault();
    $('#filters-container').append( $('<div/>').html($('#filter').html()) );
    
	//alert($('#filter').html());
	//$('#container-filter').add( $('<div/>',{'class':'some','id':'filter2','html': $('#filter').html()} ) );
	

//	$('.span_delete').click(function(e){
//		$(this).parent('div').remove();
//		$('.combo_relation').last().hide();	
//		$('.span_add').last().show();
//	});
	$('.span_add').last().click(add_row);
	$('.span_add').hide().last().show();
	$('.span_delete').last().show();
	$('.dropdown_relation').show();
	$('.dropdown_relation').last().hide();	

//console.log("agregada");
	
}

$(function() { 

//Agregar fila al filtro
$('.span_add').click(add_row);

//Mostrar los campos
$('.crear-filtro').click(function(e){
    e.preventDefault();
    $('#filters-view').slideDown();
});

//Buscar
    $('#btn_search_event').click(function() {
        ajaxRequest = $('#query').serialize();
        clearTimeout(ajaxUpdateTimeout);

        ajaxUpdateTimeout = setTimeout(function() {
            $.fn.yiiListView.update(
                    'list-auth-items',
                    {
                        type: 'POST',
                        //url: '" . CController::createUrl('orden / admin') . "',
                                data: ajaxRequest}

            )
        },
                300);
        return false;
    });

});