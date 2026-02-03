@extends('Padre.layout')
@section('contenido')

<body id="page-top">
    <div class="modal fade" role="dialog" tabindex="-1" id="agregar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-blue);">
                    <h4 class="modal-title" style="color: rgb(0,0,0);">Agregar Hijo</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('agregarhijo') }}" method="POST">
               		   @csrf
                        <label class="form-label" style="color: rgb(0,0,0);">Nombre </label>
                        <input class="form-control form-control-sm" type="text" name="nombre_alumno">
                        <label class="form-label" style="color: rgb(0,0,0);">Apellidos </label>
                        <input class="form-control form-control-sm" type="text" name="apellido_alumno">
                        <label class="form-label" style="color: rgb(0,0,0);">DNI </label>
                        <input class="form-control form-control-sm" type="number" name="dni_alumno">
                        <label class="form-label" style="color: rgb(0,0,0);">Nivel</label>
                        <select class="form-select" name="nivel_alumno">
                            <option value="" selected="">Seleccione</option>
                            <option value="Inicial">Inicial</option>
                            <option value="Primaria">Primaria</option>
                            <option value="Secundaria">Secundaria</option>
                        </select>
                        <label class="form-label" style="color: rgb(0,0,0);">Grado</label>
                        <select class="form-select" name="grado_alumno">
                            <option value="" selected="">Seleccione</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select><label class="form-label" style="color: rgb(0,0,0);">Sección</label>
                        <select class="form-select" name="seccion_alumno">
                            <option value="" selected="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-primary" type="submit">Agregar</button></div>
            </div>
        </div></form>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="editar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-blue);">
                    <h4 class="modal-title" style="color: rgb(0,0,0);">Editar Hijo</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('editarhijop') }}" method="POST">
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
                    </select>  
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-primary" type="submit">Editar</button></div>
            </div></form>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="eliminar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-red);">
                    <h4 class="modal-title" style="color: rgb(0,0,0);">Eliminar Hijo</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('eliminarhijop') }}" method="POST">
                     @csrf
                        <input type="hidden" name="idalumno" id="idalumnoe">
                        <label class="form-label" style="color: rgb(0,0,0);">Nombre:</label>
                        <input class="form-control form-control-sm" type="text" id="nombre_alumnoe">
                </div>
                <div class="modal-footer"><button class="btn btn-success" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-danger" type="submit">Eliminar</button></div>
            </div>
        </div>
    </div>
   
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold"><i class="fa fa-list-alt"></i>&nbsp;Tabla de Hijos Registrados</p>
                        </div>
                        <div class="card-body">
                            @if (session('alert1'))
                            <div class="alert alert-success" role="alert">
                             <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
                            </div>
                            @endif
                            <div class="text-end" style="margin-top: 11px;margin-bottom: 10px;"><button class="btn btn-outline-primary btn-sm text-nowrap" type="button" data-bs-toggle="modal" data-bs-target="#agregar" style="margin-right: 6px;"><i class="fa fa-plus"></i>&nbsp;Agregar Hijo</button></div>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Estudiante</th>
                                            <th>Nivel&nbsp;</th>
                                            <th class="text-center">Grado</th>
                                            <th class="text-center">Sección</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hijos as $hijo)
                                        <tr>
                                            <td>{{$hijo->nombre_alumno}} {{$hijo->apellido_alumno}}</td>
                                            <td>{{$hijo->nivel_alumno}}</td>
                                            <td class="text-center">{{$hijo->grado_alumno}}</td>
                                            <td class="text-center">{{$hijo->seccion_alumno}}</td>
                                            <td class="text-center"><button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editar" onclick="editarhijo('{{$hijo->idalumno}}','{{$hijo->nombre_alumno}}','{{ $hijo->apellido_alumno }}','{{$hijo->dni_alumno}}','{{$hijo->nivel_alumno}}','{{$hijo->grado_alumno}}','{{$hijo->seccion_alumno}}' )"><i class="fa fa-edit"></i>&nbsp;Editar</button><button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#eliminar" style="margin-left: 10px;" onclick="eliminarhijo('{{$hijo->idalumno}}','{{$hijo->nombre_alumno}}')"><i class="fa fa-trash"></i>&nbsp;Eliminar</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
<script>
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
    
    
function eliminarhijo(idalumno,nombre_alumno) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idalumnoe').value = idalumno;
      document.getElementById('nombre_alumnoe').value = nombre_alumno;


      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }        
</script>
@endsection