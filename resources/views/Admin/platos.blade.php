@extends('Admin.layout')

@section('contenido')

<div class="modal fade" role="dialog" tabindex="-1" id="agregarplato">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: var(--bs-blue);">
                    <h4 class="modal-title"><i class="fa fa-cutlery"></i>&nbsp;Agregar Plato y/o Snack</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crearplato') }}" method="POST">
               		   @csrf
                    	<label class="form-label" style="color: var(--bs-gray-900);">Nombre del Plato:</label><input class="form-control form-control-sm" type="text" name="nombre_plato"><label class="form-label" style="color: var(--bs-gray-900);">Descripción:</label><textarea class="form-control form-control-sm" name="descripcion_plato"></textarea><label class="form-label" style="color: var(--bs-gray-900);">Precio:</label><input class="form-control form-control-sm" type="text" required inputmode="numeric" name="precio_plato">

                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-primary" type="submit">Agregar</button></div>
            </div>
        </div> </form>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="editarplato">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: var(--bs-blue);">
                    <h4 class="modal-title"><i class="fa fa-cutlery"></i>&nbsp;Editar Plato</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('editarplato') }}" method="POST">
               		   @csrf
               		   <input type="hidden" name="idplato" id="idplato">
                    	<label class="form-label" style="color: var(--bs-gray-900);">Nombre del Plato:</label><input class="form-control form-control-sm" type="text" name="nombre_plato" id="nombre_plato"><label class="form-label" style="color: var(--bs-gray-900);">Descripción:</label><textarea class="form-control form-control-sm" name="descripcion_plato" id="descripcion_plato"></textarea><label class="form-label" style="color: var(--bs-gray-900);">Precio:</label><input class="form-control form-control-sm" type="text" required inputmode="numeric" name="precio_plato" id="precio_plato">
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-primary" type="submit">Editar</button></div>
            </div>
        </div></form>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="eliminarplato">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: var(--bs-red);">
                    <h4 class="modal-title"><i class="fa fa-cutlery"></i>&nbsp;Eliminar Plato</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1 style="font-size: 16px;text-align: center;color: rgb(0,0,0);">¿Desea eliminar este plato?</h1>
                    
                    <form action="{{ route('eliminarplato') }}" method="POST">
               		   @csrf
               		   <input type="hidden" name="idplato" id="idplato1">
                    	<label class="form-label" style="color: var(--bs-gray-900);">Nombre del Plato:</label><input class="form-control form-control-sm" type="text" readonly="" id="nombre_plato1" name="nombre_plato"><label class="form-label" style="color: var(--bs-gray-900);">Descripción:</label><textarea class="form-control form-control-sm" readonly="" id="descripcion_plato1"></textarea><label class="form-label" style="color: var(--bs-gray-900);">Precio:</label><input class="form-control form-control-sm" type="text" readonly="" id="precio_plato1">                </div>
                <div class="modal-footer"><button class="btn btn-success" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-danger" type="submit">Eliminar</button></div>
            </div>
        </div></form>

    </div>

<div class="container-fluid">
@if (session('alert1'))
<div class="alert alert-success" role="alert">
 <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
</div>
@endif
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold"><i class="fa fa-cutlery"></i>&nbsp;Tabla de Platos</p>
                        </div>
                        <div class="card-body">
                            <div class="text-nowrap text-center" style="margin-bottom: 19px;"><button class="btn btn-primary btn-sm text-nowrap" type="button" data-bs-toggle="modal" data-bs-target="#agregarplato"><i class="fas fa-plus-circle"></i>&nbsp;Crear Plato y/o Snack</button></div>
                            <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"></div>
                          <br>
                            <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por cualquier dato..." onkeyup="filterTable()" style="width: 100%; padding: 10px;">
                            </div>
                            <div class="table-responsive text-nowrap table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info" style="max-height: 520px; overflow-y: auto;">
                                <table class="table my-0" id="pedidosTable">
                                    <thead>
                                        <tr>
                                            <th>Nombre del plato</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@foreach($platos as $plato)
                                        <tr>
                                            <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/images.png">{{$plato->nombre_plato}}</td>
                                            <td>{{$plato->descripcion_plato}}</td>
                                            <td>S/ {{number_format($plato->precio_plato, 2, '.', '')}}</td>
                                            <td class="text-center"><button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editarplato" onclick="editar('{{$plato->idplato}}','{{$plato->nombre_plato}}','{{$plato->descripcion_plato}}','{{$plato->precio_plato}}')"><i class="fa fa-edit"></i>&nbsp;Editar</button><button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#eliminarplato" style="margin-left: 10px;" onclick="eliminar('{{$plato->idplato}}','{{$plato->nombre_plato}}','{{$plato->descripcion_plato}}','{{$plato->precio_plato}}')"><i class="fa fa-trash"></i>&nbsp;Eliminar</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
</div>



<script>
    // Función para abrir el modal y mostrar los datos
    function editar(idplato,nombre_plato,descripcion_plato,precio_plato) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idplato').value = idplato;
      document.getElementById('nombre_plato').value = nombre_plato;
      document.getElementById('descripcion_plato').value = descripcion_plato;
      document.getElementById('precio_plato').value = precio_plato;
      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }

    function eliminar(idplato,nombre_plato,descripcion_plato,precio_plato) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idplato1').value = idplato;
      document.getElementById('nombre_plato1').value = nombre_plato;
      document.getElementById('descripcion_plato1').value = descripcion_plato;
      document.getElementById('precio_plato1').value = precio_plato;

      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }
    
    function filterTable() {
        // Obtener el valor del campo de búsqueda
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("pedidosTable");
        tr = table.getElementsByTagName("tr");

        // Recorremos todas las filas de la tabla
        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none"; // Ocultamos la fila inicialmente
            td = tr[i].getElementsByTagName("td");

            // Recorremos todas las celdas de la fila
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""; // Mostramos la fila si hay coincidencia
                        break; // Salimos del bucle para no seguir verificando otras celdas
                    }
                }
            }
        }
    }    
  </script>
@endsection