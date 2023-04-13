$(document).ready( function () {

    $.fn.datepicker.defaults.format = 'dd-mm-yyyy';

    var datatableUF = $('#historico_uf').DataTable({
            ajax: {
                url: "http://localhost:8000/obtenerDataIndicadores",
                type: 'GET',
                dataSrc: "",
                dataType: "json",
            },
            columns: [
                { data: "id" },
                { data: "codigoIndicador" },
                { data: "unidadMedidaIndicador" },
                { data: "valorIndicador" },
                { data: "fechaIndicador" },
                {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>Editar</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>Borrar</i></button></div></div>"},
                
            ],
            dom: 'Bfrtip',
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "order": [[ 0, "desc" ]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
    });

        $(document).on("click", ".btnEditar", function(){		        
            fila = $(this).closest("tr");	        
            $("#valorIndicador").val(fila.find('td:eq(3)').text());
            $('#fechaIndicador').datepicker('setDate', fila.find('td:eq(3)').text());
            $('#idUF').val( fila.find('td:eq(0)').text() );

            $("#tituloUf").text("Editar UF");		
            $('#modalUF').modal('show');		   
        });

        $('#formUF').submit(function(e){                         
             e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
             let id = $('#idUF').val();
             let urlRoutes;

             if ( id != '' ){
                 urlRoutes = 'http://localhost:8000/actualizarIndicador/'+id;
                 tipoEnvio = "PUT";
                }else{
                urlRoutes = 'http://localhost:8000/grabarIndicador';
                tipoEnvio = "POST";
             }

             let fecha = $('#fechaIndicador').datepicker('getDate');
             var fechaFormateada = fecha.toLocaleDateString('es-CL');
             $.fn.datepicker.defaults.format = 'dd-mm-yyyy';


            $.ajax({
                url: urlRoutes,
                type: tipoEnvio,
                datatype:"json",    
                data:  {    
                        valorIndicador:$('#valorIndicador').val(), 
                        fechaIndicador: fechaFormateada
                },    
                success: function(data) {
                    $("#valorIndicador").val("");
                    $("#fechaIndicador").val("");
                    datatableUF.ajax.reload(null, false);
                }
            });

            $('#modalUF').modal('hide');											     			
        });

        $(document).on('click', '.btnBorrar', function(e) {
            
            let id = $(this).closest("tr").find('td:eq(0)').text();
            urlEliminar = 'http://localhost:8000/eliminarIndicador/'+id

            Swal.fire({
                title: '¿Desea eliminar el valor de la UF?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: urlEliminar,
                        type: "delete",
                        datatype:"json",        
                        success: function(data) {
                            datatableUF.ajax.reload(null, false);
                        }
                    });
                }
            })
        });

    });