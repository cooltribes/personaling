/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*Resetear los dropdown, los tipos de cuerpo, el nombre del filtro*/
function clearFields(){
     $("#profile-name").val("");
}

$(function() {
    
    $("#modalFiltroPerfil").modal('show');
    
    $('#tipo_cuerpo').on('click', 'li', function(e) {

        $(this).siblings().removeClass('active');
        $(this).addClass('active');


        $('#Profile_tipo_cuerpo').val($(this).attr('id').substring(5));

        e.preventDefault();

    });

    $('#save-search').click(function(e) {
        var nombre = $("#profile-name").val().trim();

        if (nombre !== '') {
            console.log(actionGuardarFiltro);
            
            $.ajax(
                actionGuardarFiltro,
                {
                    type: 'POST',
                    dataType: 'json',
                    data: {name : nombre},
                    success: function(data) {

                        if (data.status === 'success') {
                            
                            $('#all_filters').append($("<option />").val(data.idFilter).text(nombre));
                            $('#all_filters').val(data.idFilter);
                            
                            $("#modalFiltroPerfil").modal('hide');
                            clearFields();
                            
                            //$('#all_filters').change();
                            //Poner titulo
                            //$('#form_filtros h4').html("Filtro: <strong>" + $('#all_filters').find(":selected").text() + "</strong>");

                            //Mostrar el botón guardar
                            //$('#filter-save2').parent('div').show();
                            //search(URL);
                            
                            //refresh
                            

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

        }

    });

});

