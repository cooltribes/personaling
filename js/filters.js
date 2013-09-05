/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*Agrega una fila para el filtro*/
function addRow(e){
    
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
        
    $('.span_add').last().click(addRow);
    $('.span_add').hide().last().show();
    $('.span_delete').last().show();
    $('.dropdown_relation').show();
    $('.dropdown_relation').last().hide();

//console.log("agregada");
	
}


/*Obtiene los campos pertenecientes a un filtro ID*/
function getFilter(URL, ID){
    //	if ($('#span_new_filter').html() != 'Filter verbergen'){
//		$('#div_add_filter').show();
//		$('#YumUser_textfield_all').hide().val('');
//		//$(this).hide();
//		$('#span_new_filter').html('Filter verbergen');
//	}

    clearFilters();
    
    $.ajax(
            URL,
            {
                type: 'POST',
                dataType: 'json',
                data: { 'id':ID },
                beforeSend: function(){
                    if(ID == null || ID.trim() === ''){
                        return false;
                    }
                },
                success: function(data){
                    console.log(data);
                    if(data.status == 'success'){
                        console.log(data.filter);                                            
                        var total = data.filter.length;
                        for (var it = 1; it < total; it++) {
                            addRow('');
                        };
                        
//                        
//                        $.each(result.data, function(i, item) {
//                            //alert(data.data);
//                            //alert(item.tx_detail);
//                            //options.append($("<option />").val(item[0]).text(item[1]));
//                            $('.combo_filter').eq(i - 1).val(item.tx_detail);
//                            $('.combo_operator').eq(i - 1).val(item.tx_operator);
//                            $('.text_filter').eq(i - 1).val(item.tx_value);
//                            if (total > i)
//                                $('.combo_relation').eq(i - 1).val(item.tx_relation);
//                        });
                        
                        
                        
                        
                        
                    }else if(data.status == 'error'){
                       console.log(data.error); 
                       bootbox.alert(data.error);
                    }
                },
                error: function( jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                }
            }
        );
        
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
    
    
}

var ajaxUpdateTimeout;
var ajaxRequest;

//Buscar por filtros
function search(URL){
    
    console.log("hello");
    ajaxRequest = $('#form_filtros').serialize();

    console.log(ajaxRequest);


    clearTimeout(ajaxUpdateTimeout);

    //$('#form_filtros').submit();

    ajaxUpdateTimeout = setTimeout(
            function() {
                $.fn.yiiListView.update(
                        'list-auth-items',
                        {
                            type: 'POST',
                            url: URL,
                                    data: ajaxRequest

                        }

                )
            },
            300);
    
}

//Buscar por filtros y guardar el filtro
function searchAndSave(URL) {

    ajaxRequest = $('#form_filtros').serialize();


    bootbox.prompt("Indica un nombre para el filtro:", function(result) {
        if (result === null) {

        } else {
            result = result.trim();
            if (result !== "") {
                //guardar el filtro
                ajaxRequest += "&save=true&name=" + result;

                console.log(ajaxRequest);


                clearTimeout(ajaxUpdateTimeout);

                // $('#form_filtros').submit();

                ajaxUpdateTimeout = setTimeout(
                        function() {
                            $.fn.yiiListView.update(
                                    'list-auth-items',
                                    {
                                        type: 'POST',
                                        url: URL,
                                                data: ajaxRequest

                                    }

                            )
                        },
                        300);



            }

        }
    });

}

//Borrar todos los campos
function clearFilters() {

    $('#filters-container').children('div').each(function(i) {
        if (i > 0) {
            $(this).remove();
        }

        $('.dropdown_relation').last().hide();
        $('.span_add').last().show();
    });

}

$(function() { 
    
    //Agregar fila al filtro
    $('.span_add').click(addRow);

    //Mostrar los campos - Crear nuevo filtro
    $('.crear-filtro').click(function(e){
        e.preventDefault();
        clearFilters();
        $('#filters-view').slideDown();
    });

    
    


});