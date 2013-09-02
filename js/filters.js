/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function add_row(e){
    
    e.preventDefault();
    $('#container-filter').append( $('<div/>').html($('#filter').html()) );
    
	//alert($('#filter').html());
	//$('#container-filter').add( $('<div/>',{'class':'some','id':'filter2','html': $('#filter').html()} ) );
	

//	$('.span_delete').click(function(e){
//		$(this).parent('div').remove();
//		$('.combo_relation').last().hide();	
//		$('.span_add').last().show();
//	});
	$('.span_add').last().click(add_row);
	$('.span_add').hide().last().show();
//	$('.span_delete').last().show();
//	$('.combo_relation').show();
//	$('.combo_relation').last().hide();	

//console.log("agregada");
	
}

$(function() { 


$('.span_add').click(add_row);

});