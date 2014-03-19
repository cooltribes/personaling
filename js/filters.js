/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * 
 * Falta:
 * confirmar borrar filtro. ?
 * Paginacion
 * filtrar por precio de venta o precio de descuento
 * 
 */

/* Variables */

var ajaxUpdateTimeout;
var ajaxRequest;
var idDateField = 0;

/* Funciones */

/*Agrega una fila para el filtro*/
function addRow(){
    
    
    $('#filters-container').append( $('<div/>').html($('#filter').html()) );
    
    $('.span_delete').click(function(e) {
        $(this).parent().parent().parent('div').remove();

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
    $(".dropdown_filter").last().change(changeFilter);
    $(".dropdown_filter").last().change();

	
}

//Borrar todos los campos
function clearFilters() {

    $('#filters-container').children('div').each(function(i) {
        if (i > 0) {
            $(this).remove();
        }
        
    });
    
    $('.dropdown_filter, .dropdown_operator, .textfield_value, .dropdown_relation').val('');
    $('.dropdown_filter').change();
    $('.dropdown_relation').last().hide();
    $('.span_add').last().show();      
    
    //Titulo
    $('#form_filtros h4').html("Nueva búsqueda avanzada:");
                            
    //Ocultar el botón guardar
    $('#filter-save2').parent('div').hide();
    
    //ocultar alert si está
    $(".alert").fadeOut('slow');
        
}

//Mostrar alert
function showAlert(type, message){
   $('#alert-msg').removeClass('alert-success alert-error') ;
   $('#alert-msg').addClass("alert-"+type);
   $('#alert-msg').children(".msg").html(message);
   $('#alert-msg').show();
   //$("html, body").animate({ scrollTop: 0 }, "slow");
}

/*Obtiene los campos pertenecientes a un filtro ID, los carga y luego realiza la búsqueda*/
function getFilter(URL, ID, URL2){

    clearFilters();
    
    if(ID && ID.trim() !== ''){  
    
        $.ajax(
                URL,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: { 'id':ID },
                    success: function(data){
                        if(data.status == 'success'){
                            
                            var total = data.filter.length;
                            for (var it = 1; it < total; it++) {
                                addRow();
                            };

                            $.each(data.filter, function(i, item) {
                                
                                $('.dropdown_filter').eq(i).val(item.column);
                                $('.dropdown_filter').eq(i).change();
                                $('.dropdown_operator').eq(i).val(item.operator);
                                $('.textfield_value').eq(i).val(item.value);

                                $('.dropdown_relation').eq(i).val(item.relation); 

                            });  
                            
                            //Poner titulo
                            $('#form_filtros h4').html("Filtro: <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
                            
                            //Mostrar el botón guardar
                            $('#filter-save2').parent('div').show();
                            
                            $('#filters-view').slideDown();
                            
                            search(URL2);                            

                        }else if(data.status == 'error'){
                           console.log(data.error); 
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                    }
                }
        );
    }   
    
}

/*Eliminia un filtro dado por ID*/
function removeFilter(URL, ID){     
    
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
                    
                    if(data.status == 'success'){                       
                        
                        $('#all_filters').find("[value='"+ID+"']").remove();
                        clearFilters();        
                        
                    }
                    
                    showAlert(data.status, data.message);                    
                    
                },
                error: function( jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                }
            }
        );
        
    
}

//Buscar por filtros
function search(URL){
    
    ajaxRequest = $('#form_filtros').serialize();
    clearTimeout(ajaxUpdateTimeout);
    //  $('#form_filtros').submit();
    
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
            }, 300);    
}

//Buscar por filtros y guardar el filtro
function searchAndSave(URL, newFilter) {    
    
    //search(URL);
    ajaxRequest = $('#form_filtros').serialize();
    //Si esta guardando un nuevo filtro                        
    if (newFilter) {
        bootbox.prompt("Indica un nombre para el filtro:", function(result) {            
            if (result === null) {
                
            } else {
                result = result.trim();
                if (result !== "") {
                    //guardar el filtro
                    ajaxRequest += "&save=true&name=" + result;                    
                    // $('#form_filtros').submit();
                    $.ajax(
                        URL,
                        {
                            type: 'POST',
                            dataType: 'json',
                            data: ajaxRequest,
                            success: function(data){
                                
                                if(data.status == 'success'){                                   
                                    //$('#alert-msg')
                                    $('#all_filters').append($("<option />").val(data.idFilter).text(result));
                                    $('#all_filters').val(data.idFilter);
                                    //$('#all_filters').change();
                                    //Poner titulo
                                     $('#form_filtros h4').html("Filtro: <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
                            
                                    //Mostrar el botón guardar
                                    $('#filter-save2').parent('div').show();
                                    search(URL);
                                    
                                }
                                
                                showAlert(data.status, data.message);
                                
                            },
                            error: function( jqXHR, textStatus, errorThrown){
                                console.log(jqXHR);
                            }
                        }
                    );
                    
                    
                }else{
                    showAlert('error', 'Debes indicar un nombre para el filtro');
                }

            }
        });
        
    //si esta guardando el filtro acutal    
    }else{       
       var ID = $('#all_filters').val();
       
       ajaxRequest += "&save=true&id=" + ID; 
       $.ajax(
            URL,
            {
                type: 'POST',
                dataType: 'json',
                data: ajaxRequest,
                beforeSend: function(){
                    if(ID === null || ID.trim() === ''){
                        return false;
                    }
                },
                success: function(data){
                    
                    if(data.status == 'success'){                                   
                        //$('#alert-msg')
//                        $('#all_filters').append($("<option />").val(data.idFilter).text(result));
//                        $('#all_filters').val(data.idFilter);
//                        $('#all_filters').change();
                        search(URL);
                    }

                    showAlert(data.status, data.message);

                },
                error: function( jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                }
            }
      ); 
        
    }


}

//Para buscar por listado
function listFilter(column, selectId){   
    
    var operator = column.parent('div').next();
    var value = operator.next();

    value.empty().append( 
           $('<select />').html($("#"+selectId).html()).addClass('textfield_value span2')   
           .attr('name','textfield_value[]')
           .attr('id', 'textfield_value')
        );
       //agregar = y diferente     
    operator.children().children().each(function(i, elem){
       if($(elem).val() !== '')
           $(elem).remove();
    });
    operator.children().append(
       $("<option />").val('=').text('=')
    ).append(
       $("<option />").val('<>').text('<>')        
    ); 
    
}
//Para buscar texto
function textFilter(column){
    
    var operator = column.parent('div').next();
    var value = operator.next();
    
    value.empty().append($('<input />').attr('type', 'text').addClass('textfield_value span2')   
        .attr('name','textfield_value[]')
        .attr('id', 'textfield_value')        
       );
           
       //agregar = y LIKE    
   operator.children().children().each(function(i, elem){
       if($(elem).val() !== '')
           $(elem).remove();
   });
   operator.children().append(
       $("<option />").val('=').text('=')
   ).append(
       $("<option />").val('LIKE').text('Contenga')        
   );
    
}
//Para buscar por numeros
function valueFilter(column){
    var operator = column.parent('div').next();
    var value = operator.next();
    
    value.empty().append($('<input />').attr('type', 'text').addClass('textfield_value span2')   
        .attr('name','textfield_value[]')
        .attr('id', 'textfield_value')        
       );
              
   operator.children().empty().html($("#Operadores").html());
}
//Para buscar por fechas
function dateFilter(column){
    var operator = column.parent('div').next();
    var value = operator.next();
    
    value.empty().append($('<input />').attr('type', 'text').addClass('textfield_value span2')   
        .attr('name','textfield_value[]')
        .attr('id', 'textfield_value'+(idDateField++))
        .datepicker({
            dateFormat: "dd-mm-yy"
        })
       ); 
              
   operator.children().empty().html($("#Operadores").html());
}

function init(){
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

    $(".alert").alert();
    $(".alert .close").click(function(){
        $(".alert").fadeOut('slow');
    });
    
    /*Adaptar operador y valor dependiendo de la columna*/
    $(".dropdown_filter").change(changeFilter);
    
}

$(function() { 
    
    init();
    

});