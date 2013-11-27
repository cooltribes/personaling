/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * FALTA
 * poner icono de loading 
 * Poner titulo en modal
 * campos en class error cuando intente guardar con campos en blanco.
 * 
 */



//Guardar filto existente
//Guardar filtro Nuevo

//Eliminar filtro

//Boton crear nuevo

//Cargar Filtro existente

//Variables locales para el perfil actual
 var valores = Array();

/*Poner en cero los valores*/
function limpiarLocal(){
    console.log("Limpiando");   
    
    $.each(valores, function(i, elem){
        //console.log("Primero" + elem);
        valores[i] = 0;
        //console.log("Despues" + elem);
    });
    
}
/*Guarda los campos actuales del modal en variables locales*/
function guardarLocal(){
    console.log("Guardando");
    $("#modalFiltroPerfil #newFilter-form").find('input, select').each(function(i, elem){
      valores[i] = $(elem).val();
    });
    
    //console.log(valores);
}

function cargarLocal(){
    console.log("Cargando");
    
    $("#modalFiltroPerfil #newFilter-form").find('input, select').each(function(i, elem){
        $(elem).val(valores[i]);
        //console.log($(elem));
    });
    
    //class activo al tipo de cuerpo    
    var activo = $('#tipo_cuerpo').find('li#tipo_'+valores[5]);
    activo.siblings().removeClass('active');
    activo.addClass("active");
    
    
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
        
        //Poner titulo al modal
        $('#modalFiltroPerfil .modal-header h3').html("Crea un perfil para alguien más (Una amiga, tu mamá, etc.)");
    }
    else
    {
        //ocultar el campo del nombre
        $('#campo-nombre').hide();
        $('#save-search').hide();
        
        //Mostrar el boton guardar y borrar dentro del modal
        $('#save').show();
        $('#remove').show();
        
        //Poner titulo al modal
        $('#modalFiltroPerfil .modal-header h3').html("Perfil Corporal - <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
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
    $("body").addClass("aplicacion-cargando");  
    if(ID && ID.trim() !== ''){  
    
        $.ajax(
                URL,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: { 'id':ID },
                    beforeSend: function(){
                        $("body").addClass("aplicacion-cargando");                       
                        
                    },
                    complete: function(){
                        //$("body").removeClass("aplicacion-cargando");
                    },
                    success: function(data){
                        if(data.status === 'success'){                           
//                            //Poner titulo
//                            $('#form_filtros h4').html("Filtro: <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
                                                       
                            //Cargar los valores en las variables locales
                            //console.log(data.filter);                            
                            valores[0] = data.filter.altura;
                            valores[1] = data.filter.contextura;
                            valores[2] = data.filter.pelo;
                            valores[3] = data.filter.ojos;
                            valores[4] = data.filter.piel;
                            valores[5] = data.filter.tipo_cuerpo;                                                    
                            
                            //mostrarlos en los campos del modal
                            //cargarLocal();
                            //activar para perfil cargado
                            activarModalNuevo(false);
                            //Mostrar el boton de editar
                            $('a.editar-filtro').parent('div').show(); 
                            
                            //Buscar
                            refresh();           
                        }
                        //console.log(data.message);
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
       
       limpiarLocal();       
       //Buscar para actualizar sin los filtros de perfiles
       refresh(true);
    }   
    
}


/*Obtiene los campos pertenecientes a un filtro ID, los carga y luego realiza la búsqueda*/
function getFilterByClick(idPerfil){

    URL = 'getFilter';
    ID = idPerfil;
    $("body").addClass("aplicacion-cargando");  
    if(ID && ID.trim() !== ''){  
    
        $.ajax(
                URL,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: { 'id':ID },
                    beforeSend: function(){
                        
                        $("body").addClass("aplicacion-cargando");
                        
                    },
                    complete: function(){
                        //$("body").removeClass("aplicacion-cargando");
                    },
                    success: function(data){
                        if(data.status === 'success'){                           
//                            //Poner titulo
//                            $('#form_filtros h4').html("Filtro: <strong>"+$('#all_filters').find(":selected").text()+"</strong>");
                                                       
                            //Cargar los valores en las variables locales
                            //console.log(data.filter);                            
                            valores[0] = data.filter.altura;
                            valores[1] = data.filter.contextura;
                            valores[2] = data.filter.pelo;
                            valores[3] = data.filter.ojos;
                            valores[4] = data.filter.piel;
                            valores[5] = data.filter.tipo_cuerpo;                                                    
                            
                            //mostrarlos en los campos del modal
                            //cargarLocal();
                            //activar para perfil cargado
                            activarModalNuevo(false);
                            //Mostrar el boton de editar
                            $('a.editar-filtro').parent('div').show(); 
                            
                            //Cambiar label del boton looks para mi
                            $("#btnMatch").html("Looks para <b>" + data.name + "</b>");
                            $("#btnMatch").addClass("btn-danger");
                            $("#btnTodos").removeClass("btn-danger");
                            //Buscar
                            refresh();           
                        }
                        //console.log(data.message);
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
       
       limpiarLocal();       
       //Buscar para actualizar sin los filtros de perfiles
       refresh(true);
    }   
    
}

function saveFilter(nuevo) {
    
    var action, nombre, boton;
    
    if(nuevo)
    {
        action = '&name=';
        nombre = $("#profile-name").val().trim(); 
        boton = $('#save-search');
    }
    else
    {
        action = '&id=';
        nombre = $('#all_filters').val();
        boton = $('#save');
    }   
    
    if (nombre !== '') {
        $("#profile-name").parent().parent().removeClass("error");
        
        var perfil = $("#modalFiltroPerfil #newFilter-form").find('input, select').serialize();
        
        perfil += action + nombre;
        
        $.ajax(
                actionGuardarFiltro,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: perfil,
                    beforeSend: function(){
                        boton.prop('disabled', true);
                        $("#profile-name").prop('disabled', true);
                        $("body").addClass("aplicacion-cargando");
                    },
                    complete: function(){
                        boton.prop('disabled', false);
                        $("#profile-name").prop('disabled', false);
                        $("body").removeClass("aplicacion-cargando");
                    },
                    success: function(data) {
                                                
                        if (data.status === 'success') {
                            
                            //si es nuevo
                            if(data.idFilter){
                                //Agregarlo a la lista de filtros
                                $('#all_filters').append($("<option />").val(data.idFilter).text(nombre));
                                $('#all_filters').val(data.idFilter); 
                                
                                activarModalNuevo(false);
                                
                                 //Mostrar el boton de editar
                                $('a.editar-filtro').parent('div').show();
                            }
                            //Guardar en local
                            guardarLocal();                            
                            refresh();                          
                           
                        }
                         
                            $("#modalFiltroPerfil").modal('hide');
                            showAlert(data.status, data.message);                    


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("error");
                        console.log(jqXHR);
                    }
                }
        );

    } else {
        //console.log("error, campo nombre vacío.");
        $("#profile-name").parent().parent().addClass("error");
        $("#profile-name").focus();
    }

}

/*Eliminia un filtro dado por ID*/
function removeFilter(URL){     
    
    
    ID = $("#all_filters").val();    
    var boton = $("#remove");
    $.ajax(
            URL,
            {
                type: 'POST',
                dataType: 'json',
                data: { 'id':ID },
                beforeSend: function(){
                    if(ID === null || ID.trim() === ''){
                        return false;
                    }
                    boton.prop('disabled', true);
                },
                complete: function(){
                    boton.prop('disabled', false);
                },
                success: function(data){
                    
                    if(data.status === 'success'){                       
                        
                        $('#all_filters').find("[value='"+ID+"']").remove();  
                        clearFields();
                        limpiarLocal();
                        activarModalNuevo(true); 
                        //Ocultar el boton editar
                        $('a.editar-filtro').parent('div').hide();
                        
                        $("#modalFiltroPerfil").modal('hide');
                        
                        refresh();
                        
                    }
                    showAlert(data.status, data.message);                    
                    
                },
                error: function( jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                }
            }
        );
        
    
}
//Mostrar alert
function showAlert(type, message){
   $('#alert-msg').removeClass('alert-success alert-error') ;
   $('#alert-msg').addClass("alert-"+type);
   $('#alert-msg').children(".msg").html(message);
   $('#alert-msg').show();
   $("html, body").animate({ scrollTop: 0 }, "slow");
}

//al hacer click en "agregar perfil + "
function clickAgregar(){
    clearFields();
    activarModalNuevo(true);
    $(".alert").fadeOut('slow');
}

//Al hacer click en un perfil creado
function clickPerfil(idPerfil){
    
    //e.preventDefault();
    //getFilterByClick($(this).prop("id"));  
    getFilterByClick(idPerfil);  
    $(".alert").fadeOut('slow');
    
}

//Al hacer click en el boton Looks para *
function clickPersonal(){
    
    console.log("Personal");
    $("#btnMatch").addClass("btn-danger");
    $("#btnTodos").removeClass("btn-danger");
    
}
//Al hacer click en el boton Todos los Looks
function clickTodos(){
    
    console.log("Todos");
    $("#btnTodos").addClass("btn-danger");
    $("#btnMatch").removeClass("btn-danger");
    
}


$(function() {
    
    //$("#modalFiltroPerfil").modal('show');
    
    $('#tipo_cuerpo').on('click', 'li', function(e) {

        $(this).siblings().removeClass('active');
        $(this).addClass('active');


        $('#Profile_tipo_cuerpo').val($(this).attr('id').substring(5));

        e.preventDefault();

    });

    //Boton guardar y buscar - FIltro nuevo
    $('#save-search').click(function(e) { 
        
        saveFilter(true);
        
    });
    
    $('#save').click(function(e) {        
        saveFilter(false);
    }); 
    
    
    
    $('#all_filters').change(function(e){
        getFilter();  
        $(".alert").fadeOut('slow');
    });
    
    //para editar el filtro seleccionado
    $('.editar-filtro').click(function(e){
        e.preventDefault();
        //si esta en blanco, cargar las locales y cambiar a fitro existente
        cargarLocal();
        activarModalNuevo(false);
        
        $('#modalFiltroPerfil').modal('show');
        
        $(".alert").fadeOut('slow');
    });
    
    /*Boton de crear nuevo filtro*/
    $('.crear-filtro').click(function(e){
        clearFields();
        activarModalNuevo(true);
        
        $(".alert").fadeOut('slow');
        
    });
    
    
    $(".alert").alert();
    $(".alert .close").click(function(){
        $(".alert").fadeOut('slow');
    });
    
    
    //FIltrar por precios
    
    $("#price-ranges a.price-filter").click(function(e){
        
        var id = $(this).attr("id");

        if($("#rango_actual").val() !== id){
            
            $(this).parent().siblings().removeClass("active-range");
            $(this).parent().addClass("active-range");
            $("#rango_actual").val(id); 
            
            refresh();
        }
        
    });
    
    
    
    //Click Boton todos los looks
//    $('.crear-filtro').click(function(e){
//        clearFields();
//        activarModalNuevo(true);        
//        $(".alert").fadeOut('slow');
//    });
    
    
});