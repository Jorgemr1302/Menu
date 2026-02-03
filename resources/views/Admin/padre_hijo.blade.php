@extends('Admin.layout')

@section('contenido')
<div role="dialog" tabindex="-1" class="modal fade" id="editarpadre">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(78, 115, 223);height: 59px;">
                <h4 class="modal-title" style="color: rgb(255,255,255);"><i class="fas fa-user-tie"></i> Editar Padre</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('editarpadre') }}" method="POST">
                  @csrf
                	<input type="hidden" name="idpadre" id="idpadre">
                	<label class="form-label">Nombre :</label>
                	<input type="text" class="form-control form-control-sm" name="nombre_padre" id="nombre_padre" />
                	<label class="form-label">Apellido:</label>
                	<input type="text" class="form-control form-control-sm" name="apellido_padre" id="apellido_padre" />
                	<label class="form-label">DNI:</label>
                	<input type="text" class="form-control form-control-sm" readonly="" name="dni_padre" id="dni_padre" />
                	<label class="form-label">Celular:</label>
                	<input type="text" class="form-control form-control-sm" inputmode="numeric" name="celular_padre" id="celular_padre" />
                	<label class="form-label">Email:</label>
                	<input type="text" class="form-control form-control-sm" inputmode="email" name="email_padre" id="email_padre" />
                	<label class="form-label">Estado:</label>
                	<select class="form-select form-select-sm" name="estado_padre" id="estado_padre">
                        <option value selected>Seleccione</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                      
                    </select>
                

            </div>
            <div class="modal-footer" style="height: 67px;"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-info" type="submit">Editar</button></div>
        </div>
    </div> </form>
</div>


<div role="dialog" tabindex="-1" class="modal fade" id="editarhijo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(78, 115, 223);height: 59px;">
                <h4 class="modal-title" style="color: rgb(255,255,255);"><i class="fas fa-user"></i> Editar Hijo</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form action="{{ route('editarhijo') }}" method="POST">
                  @csrf
                	<input type="hidden" name="idalumno" id="idalumno">
                	<label class="form-label">Nombre :</label>
                	<input type="text" class="form-control form-control-sm" name="nombre_alumno" id="nombre_alumno" />
                	<label class="form-label">Apellido:</label>
                	<input type="text" class="form-control form-control-sm" name="apellido_alumno" id="apellido_alumno" />
                	<label class="form-label">DNI:</label>
                	<input type="text" class="form-control form-control-sm" name="dni_alumno" id="dni_alumno" />
                	<label class="form-label">Nivel:</label>
                	<select class="form-select form-select-sm" name="nivel_alumno" id="nivel_alumno">
                        <option value selected>Seleccione</option>
                        <option value="Inicial">Inicial</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                    </select>
                    <label class="form-label">Grado:</label>
                    <select class="form-select form-select-sm" name="grado_alumno" id="grado_alumno">
                        <option value selected>Seleccione</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                    <label class="form-label">Sección:</label>
                    <select class="form-select form-select-sm" name="seccion_alumno" id="seccion_alumno">
                        <option value selected>Seleccione</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>            </div>
            <div class="modal-footer" style="height: 67px;"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-info" type="submit">Editar</button></div>
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
                            <p class="text-primary m-0 fw-bold">Tabla de Usuarios</p>
                        </div>
                        <div class="card-body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1"><i class="fas fa-user-tie"></i>&nbsp;Padres/Hijos</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id="tab-1">
                                        <br>
                                        <div class="mb-3">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por cualquier dato..." onkeyup="filterTable()" style="width: 100%; padding: 10px;">
                                        </div>
                                        <div class="table-responsive text-nowrap" style="max-height: 520px; overflow-y: auto;">
                                            <table class="table" border="1" id="pedidosTable">
                                                <thead>
                                                    <tr>
                                                        <th>Apoderado</th>
                                                        <th>Estudiante</th>
                                                        <th>Nivel</th>
                                                        <th>Grado</th>
                                                        <th>Sección</th>
                                                        <th class="text-center">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @foreach ($hijos as $index => $registro)
												    <!-- Si el padre cambia o es el primer registro, mostramos su nombre -->
												    @if ($index == 0 || $hijos[$index-1]->nombre_padre != $registro->nombre_padre || $hijos[$index-1]->apellido_padre != $registro->apellido_padre)
												        <tr>
												            <!-- Mostrar el nombre del padre solo en el primer hijo -->
												            <td rowspan="{{ $hijos->where('nombre_padre', $registro->nombre_padre)->where('apellido_padre', $registro->apellido_padre)->count() }}">
												                {{$registro->nombre_padre}} {{$registro->apellido_padre}} <span class="badge bg-danger badge-counter"></span>
												            </td>
												            <td>{{ $registro->nombre_alumno }} {{$registro->apellido_alumno}}</td>
												            <td>{{$registro->nivel_alumno}}</td>
												            <td>{{$registro->grado_alumno}}</td>
												            <td>{{$registro->seccion_alumno}}</td>
												            <td class="text-center">
												                <button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editarpadre"  onclick="editarpadre('{{$registro->idpadre}}','{{$registro->nombre_padre}}','{{ $registro->apellido_padre }}','{{$registro->dni_padre}}','{{$registro->celular_padre}}','{{$registro->email_padre}}','{{$registro->estado_padre}}'  )">
												                    <i class="fas fa-user-tie"></i>&nbsp;Editar Padre
												                </button>
												                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editarhijo" style="margin-left: 10px;" onclick="editarhijo('{{$registro->idalumno}}','{{$registro->nombre_alumno}}','{{ $registro->apellido_alumno }}','{{$registro->dni_alumno}}','{{$registro->nivel_alumno}}','{{$registro->grado_alumno}}','{{$registro->seccion_alumno}}' )">
												                    <i class="fa fa-user"></i>&nbsp;Editar Hijo
												                </button>
												            </td>
												        </tr>
												    @else
												        <!-- Si el padre es el mismo, no mostramos el nombre del padre, solo los alumnos -->
												        <tr>
												            <td>{{ $registro->nombre_alumno }} {{$registro->apellido_alumno}}</td>
												            <td>{{$registro->nivel_alumno}}</td>
												            <td>{{$registro->grado_alumno}}</td>
												            <td>{{$registro->seccion_alumno}}</td>
												            <td class="text-center">
												                <button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editarpadre" onclick="editarpadre('{{$registro->idpadre}}','{{$registro->nombre_padre}}','{{ $registro->apellido_padre }}','{{$registro->dni_padre}}','{{$registro->celular_padre}}','{{$registro->email_padre}}','{{$registro->estado_padre}}' )">
												                    <i class="fas fa-user-tie"></i>&nbsp;Editar Padre
												                </button>
												                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editarhijo" style="margin-left: 10px;" onclick="editarhijo('{{$registro->idalumno}}','{{$registro->nombre_alumno}}','{{ $registro->apellido_alumno }}','{{$registro->dni_alumno}}','{{$registro->nivel_alumno}}','{{$registro->grado_alumno}}','{{$registro->seccion_alumno}}' )">
												                    <i class="fa fa-user"></i>&nbsp;Editar Hijo
												                </button>
												            </td>
												        </tr>
												    @endif
												@endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                              
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



<script>
    // Función para abrir el modal y mostrar los datos
    function editarpadre(idpadre,nombre_padre,apellido_padre,dni_padre,celular_padre,email_padre,estado_padre) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idpadre').value = idpadre;
      document.getElementById('nombre_padre').value = nombre_padre;
      document.getElementById('apellido_padre').value = apellido_padre;
      document.getElementById('dni_padre').value = dni_padre;
      document.getElementById('celular_padre').value = celular_padre;
      document.getElementById('email_padre').value = email_padre;
      document.getElementById('estado_padre').value = estado_padre;

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }

    function editarhijo(idalumno,nombre_alumno,apellido_alumno,dni_alumno,nivel_alumno,grado_alumno,seccion_alumno) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idalumno').value = idalumno;
      document.getElementById('nombre_alumno').value = nombre_alumno;
      document.getElementById('apellido_alumno').value = apellido_alumno;
      document.getElementById('dni_alumno').value = dni_alumno;
      document.getElementById('nivel_alumno').value = nivel_alumno;
      document.getElementById('grado_alumno').value = grado_alumno;
      document.getElementById('seccion_alumno').value = seccion_alumno;

      

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