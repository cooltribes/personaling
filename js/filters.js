/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * 
 * Falta:
 * al guardar nuevo, agregarlo al dropdown.
 * mostrar alert al borrar un filtro. 
 * 
 * 
 */

/*Agrega una fila para el filtro*/
function addRow(){
    
    
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
        
    $('.span_add').last().click(function(e){
        e.preventDefault();
        addRow();
    });
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
    
    if(ID && ID.trim() !== ''){  
    
        $.ajax(
                URL,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: { 'id':ID },
                    success: function(data){
                        //console.log(data);
                        if(data.status == 'success'){
                           // console.log(data.filter);                                            
                            
                            var total = data.filter.length;
                            for (var it = 1; it < total; it++) {
                                addRow();
                            };

                            $.each(data.filter, function(i, item) {

                                $('.dropdown_filter').eq(i).val(item.column);
                                $('.dropdown_operator').eq(i).val(item.operator);
                                $('.textfield_value').eq(i).val(item.value);

                                $('.dropdown_relation').eq(i).val(item.relation); 

                            });  
                            //console.log($('#all-filters').val());
                            //Poner titulo
                            $('#form_filtros h4').html("Filtro: <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
                            
                            //Mostrar el botón guardar
                            $('#filter-save2').parent('div').show();

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
    }else{
        
    }   
    
}

/*Eliminia un filtro dado por ID*/
function removeFilter(URL, ID){
   
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
                    //console.log(data);
                    if(data.status == 'success'){
                        
                        console.log("Filtro eliminado"); 
                        //$('#alert-msg')
                        $('#all_filters').find("[value='"+ID+"']").remove();
                                
                        
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
        
    
}

var ajaxUpdateTimeout;
var ajaxRequest;

//Buscar por filtros
function search(URL){
    
    ajaxRequest = $('#form_filtros').serialize();

    //console.log(ajaxRequest);


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
function searchAndSave(URL, newFilter) {

    ajaxRequest = $('#form_filtros').serialize();

    if (newFilter) {
        bootbox.prompt("Indica un nombre para el filtro:", function(result) {
            
            if (result === null) {
                showAlert('warning', 'Debes indicar un nombre para el filtro');
                
            } else {
                result = result.trim();
                if (result !== "") {
                    //guardar el filtro
                    ajaxRequest += "&save=true&name=" + result;
                    //console.log(ajaxRequest);
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
                }else{
                    showAlert('warning', 'Debes indicar un nombre para el filtro');
                }

            }
        });
    }


}

//Borrar todos los campos
function clearFilters() {

    $('#filters-container').children('div').each(function(i) {
        if (i > 0) {
            $(this).remove();
        }
        
    });
    
    $('.dropdown_filter, .dropdown_operator, .textfield_value, .dropdown_relatio').val('');
    $('.dropdown_relation').last().hide();
    $('.span_add').last().show();   
    
    
    //Titulo
    $('#form_filtros h4').html("Nuevo Filtro:");
                            
    //Ocultar el botón guardar
    $('#filter-save2').parent('div').hide();
        
}

//Mostrar alert
function showAlert(type, message){
   $('#alert-msg').addClass(type);
   $('#alert-msg').children(".msg").text(message);
   $('#alert-msg').show();
   //$("html, body").animate({ scrollTop: 0 }, "slow");
}


$(function() { 
    
    //Agregar fila al filtro
    $('.span_add').click(function(e){
        e.preventDefault();
        addRow();
    });

    //Mostrar los campos - Crear nuevo filtro
    $('.crear-filtro').click(function(e){
        e.preventDefault();
        clearFilters();
        //Resetear el dropdown de filtros
        $("#all_filters").val('');
        
        $('#filters-view').slideDown();
    });


});