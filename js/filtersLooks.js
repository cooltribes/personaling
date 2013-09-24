/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


//Guardar filto existente
//Guardar filtro Nuevo

//Eliminar filtro

//Boton crear nuevo

//Cargar Filtro existente

//Variables locales para el perfil actual


/*Guarda los campos actuales del modal en variables locales*/
function guardarLocal(){
    
}

function activarModalNuevo(nuevo){
  
    if(nuevo)
    {
        //ocultar el boton guardar y borrar
        $('#save').hide(); 
        $('#remove').hide(); 
        //limpiar campo para nombre de filtro
        $("#profile-name").val("");          
        //mostrar el campo de nombre y el boton guardar y buscar
        $('#campo-nombre').show();
        $('#save-search').show();
    }
    else
    {
        //ocultar el campo del nombre
        $('#campo-nombre').hide();
        $('#save-search').hide();
        
        //Mostrar el boton guardar y borrar dentro del modal
        $('#save').show();
        $('#remove').show();
    }
}

/*Resetear los dropdown, los tipos de cuerpo, el nombre del filtro*/
function clearFields(){
     
    //Resetear los dropdown y el tipo de cuerpo
     $("#modalFiltroPerfil #newFilter-form").find('input, select').val('');  
    
     //quitar active de los tipos de cuerpo
     $('#tipo_cuerpo li').removeClass('active');
     
}

/*Obtiene los campos pertenecientes a un filtro ID, los carga y luego realiza la búsqueda*/
function getFilter(){

    URL = 'getFilter';
    ID = $("#all_filters").val();    
    
      
    if(ID && ID.trim() !== ''){  
    
        $.ajax(
                URL,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: { 'id':ID },
                    success: function(data){
                        if(data.status === 'success'){                            
//                            var total = data.filter.length;
//                            for (var it = 1; it < total; it++) {
//                                addRow();
//                            };
//                            $.each(data.filter, function(i, item) {
//                                
//                                $('.dropdown_filter').eq(i).val(item.column);
//                                $('.dropdown_filter').eq(i).change();
//                                $('.dropdown_operator').eq(i).val(item.operator);
//                                $('.textfield_value').eq(i).val(item.value);
//                                $('.dropdown_relation').eq(i).val(item.relation); 
//                            });                              
//                            //Poner titulo
//                            $('#form_filtros h4').html("Filtro: <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
                            
                            
                            //Cargar los valores dentro del modal
                            
                            //guardarlos en variables locales
                            guardarLocal();
                            //activar para perfil cargado
                            activarModalNuevo(false);
                            //Mostrar el boton de editar
                            $('a.editar-filtro').parent('div').show(); 
                            
                            //Buscar
                            //refresh();           

                        }
                        
                         
                        
                        console.log(data.message);
                    },
                    error: function( jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                    }
                }
        );
    }else
    {  //Cuando el nombre es val = '' 
      
      //Ocultar el boton editar
       $('a.editar-filtro').parent('div').hide();
       
       clearFields();       
       
       activarModalNuevo(true);
       
       //Buscar para actualizar sin los filtros de perfiles
       refresh();
    }   
    
}

function saveFilter() {
    
    var nombre = $("#profile-name").val().trim();

    if (nombre !== '') {
        
        var perfil = $("#modalFiltroPerfil #newFilter-form").find('input, select').serialize();
        perfil += '&name=' + nombre;
        $.ajax(
                actionGuardarFiltro,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: perfil,
                    success: function(data) {

                        if (data.status === 'success') {
                            //Agregarlo a la lista de filtros
                            $('#all_filters').append($("<option />").val(data.idFilter).text(nombre));
                            $('#all_filters').val(data.idFilter);
                            //cerrar modal;
                            $("#modalFiltroPerfil").modal('hide');

                            //refresh();
                            //
                            //Guardar en local
                            guardarLocal();

                            activarModalNuevo(false);
                            
                            //Mostrar el boton de editar
                            $('a.editar-filtro').parent('div').show();
                        }
                        console.log(data.status);
                        console.log(data.message);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("error");
                        console.log(jqXHR);
                    }
                }
        );


    } else {
        console.log("error, campo nombre vacío.");
    }

}

$(function() {
    
    //$("#modalFiltroPerfil").modal('show');
    
    $('#tipo_cuerpo').on('click', 'li', function(e) {

        $(this).siblings().removeClass('active');
        $(this).addClass('active');


        $('#Profile_tipo_cuerpo').val($(this).attr('id').substring(5));

        e.preventDefault();

    });

    $('#save-search').click(function(e) {
        
        saveFilter();

    });
    
    $('#all_filters').change(function(e){
        
        //getfilter
        getFilter();
        
    });
    
    //para editar el filtro seleccionado
    $('.editar-filtro').click(function(e){
        $('#modalFiltroPerfil').modal('show');
    });
    
    $('.crear-filtro').click(function(e){
        clearFields();
    });

});

