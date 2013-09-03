/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function add_row(e){
    
    e.preventDefault();
    $('#filters-container').append( $('<div/>').html($('#filter').html()) );
    
	//alert($('#filter').html());
	//$('#container-filter').add( $('<div/>',{'class':'some','id':'filter2','html': $('#filter').html()} ) );
	

    $('.span_delete').click(function(e) {
        $(this).parent().parent().parent('div').remove();
//       if($(this).parent('div'))
        $('.dropdown_relation').last().hide();
        $('.span_add').last().show();


        return false;
    });
        
    $('.span_add').last().click(add_row);
    $('.span_add').hide().last().show();
    $('.span_delete').last().show();
    $('.dropdown_relation').show();
    $('.dropdown_relation').last().hide();

//console.log("agregada");
	
}

function getFilter(url, id){
    
}

$(function() { 
    
    //Agregar fila al filtro
    $('.span_add').click(add_row);

    //Mostrar los campos
    $('.crear-filtro').click(function(e){
        e.preventDefault();
        $('#filters-view').slideDown();
    });

    //Seleccionar un filtro preestablecido
    $("#all_filters").change(function(){
//	if ($('#span_new_filter').html() != 'Filter verbergen'){
//		$('#div_add_filter').show();
//		$('#YumUser_textfield_all').hide().val('');
//		//$(this).hide();
//		$('#span_new_filter').html('Filter verbergen');
//	}	
	$('#filters-container').children('div').each(function(i){
		if (i >0){
                    $(this).remove();
		}
                
		$('.dropdown_relation').last().hide();	
		$('.span_add').last().show();		
	});
        
        $.ajax(
                '',
                {
                    
                }
                
            
            );
        
//	var tsTimeStamp= new Date().getTime();
//	var myJson = "{dummy:"+tsTimeStamp+",combo_save:'"+$(this).val()+"'}";
//	$.getJSON("http://kundenrat.gmaare.migros.ch/migros/filter/filter.php",eval('('+myJson+')'), function(result){
//		for (i=1;i<result.data.length;i++){
//			add_fila('');
//		};
//		var total = result.data.length;
//		$.each(result.data, function(i,item) {
//			//alert(data.data);
//			//alert(item.tx_detail);
//        	//options.append($("<option />").val(item[0]).text(item[1]));
//			$('.combo_filter').eq(i-1).val(item.tx_detail);
//			$('.combo_operator').eq(i-1).val(item.tx_operator);
//			$('.text_filter').eq(i-1).val(item.tx_value);
//			if (total > i)
//				$('.combo_relation').eq(i-1).val(item.tx_relation);
//    	});			
//
//
//
//		
//	});	
	
    });
    


});