@extends('Padre.layout')

@section('contenido')
<div role="dialog" tabindex="-1" class="modal fade" id="recreo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(78, 115, 223);height: 59px;">
                <h4 class="modal-title" style="color: rgb(255,255,255);"><i class="far fa-bell"></i> Editar Recreo</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('editarrecreop') }}" method="POST">
               		 @csrf
               		<input type="hidden" name="idpedido" id="idpedido">
                	<label class="form-label">Seleccione el Nuevo Recreo:</label>
                	<select class="form-select form-select-sm" name="recreo" required>
                        <option value selected>Seleccione</option>
                        <option value="Primer Recreo">Primer Recreo</option>
                        <option value="Segundo Recreo">Segundo Recreo</option>
                        <option value="Hora de Salida">Hora de Salida</option>
                    </select>

            </div>
            <div class="modal-footer" style="height: 67px;"><button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-info btn-sm" type="submit">Guardar</button></div>
        </div>
    </div></form>
</div>

<div class="modal fade" id="pagar" tabindex="-1" role="dialog" aria-labelledby="pagarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Aquí va la imagen -->
        <img src="assets/img/Pagos.jpeg" class="img-fluid" alt="Imagen de pago">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="yape" tabindex="-1" role="dialog" aria-labelledby="pagarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Aquí va la imagen -->
        <img src="assets/img/yape.jpeg" class="img-fluid" alt="Imagen de pago">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="plin" tabindex="-1" role="dialog" aria-labelledby="pagarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Aquí va la imagen -->
        <img src="assets/img/plin.jpeg" class="img-fluid" alt="Imagen de pago">
      </div>
    </div>
  </div>
</div>


   <div class="container-fluid">
        @if($deudaTotal>0)
       <div class="alert alert-info d-flex justify-content-between align-items-center" role="alert">
        <div>
            <i class="fa fa-info-circle me-2"></i>
            Para realizar el <strong>pago total de su deuda de S/{{number_format($deudaTotal, 2)}}</strong>, por favor haga clic en el boton <strong>Pagar</strong>.
        </div>
        <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#modalQr">
                                <i class="fa fa-money"></i> Pagar
        </button>
        </div>
        @endif
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Registro de Pedidos</p>
                        </div>
                        <div class="card-body">
                            @if (session('alert1'))
                            <div class="alert alert-success" role="alert">
                             <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
                            </div>
                            @endif
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1" style="color: rgb(0,32,255);"><i class="far fa-list-alt"></i>&nbsp;General</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2" style="color: rgb(86,227,36);"><i class="far fa-check-circle"></i>&nbsp;Pagados</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3" style="color: rgb(254,17,88);"><i class="fa fa-window-close"></i>&nbsp;Sin Pagar</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id="tab-1">
                                        <div class="table-responsive text-nowrap">
                                             <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    @if(Auth::user()->rol === 'Padre')
                                                    <th>Apoderado</th>
                                                    <th>Estudiante</th>
                                                    @endif
                                                    <th>Plato</th>
                                                    <th>Precio</th>
                                                    <th class="text-center">Estado pago</th>
                                                    <th class="text-center">Recreo</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Estado Pedido</th>
                                                    <th class="text-center">Opciones</th>
                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pedidos as  $pedido)
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($pedido->fecha_pedido)) }}</td>
                                                        @if(Auth::user()->rol === 'Padre')
                                                        <td>{{$pedido->nombre_padre}} {{$pedido->apellido_padre}}</td>
                                                        <td>{{$pedido->nombre_alumno}} {{$pedido->apellido_alumno}}</td>
                                                        @endif
                                                        <td>{{$pedido->nombre_plato}}</td>
                                                        <td>S/ {{ number_format($pedido->precio_plato, 2) }}</td>
                                                        <td class="text-center">
                                                            @if($pedido->estado_pago=="Pendiente")
                                                            <span class="btn btn-warning btn-sm" style="font-size:13px;"><b>{{$pedido->estado_pago}}</b></span>
                                                            @else
                                                            <span class="btn btn-success btn-sm" style="font-size:13px;"><b>{{$pedido->estado_pago}}</b></span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($pedido->Recreo=="Primer Recreo")
                                                            <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#recreo" onclick="editarecreo('{{$pedido->idpedido}}')">{{$pedido->Recreo}}
                                                            </button>
                                                            @else
                                                            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#recreo" onclick="editarecreo('{{$pedido->idpedido}}')" >{{$pedido->Recreo}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                        
                                                         
                                                         <!-- Select de Tipo Pago -->
                                                            <td>
                                                              {{$pedido->tipo_pago}}
                                                            </td>

                                                            <!-- Select de Estado Pedido -->
                                                            <td style="color:black;">
                                                               <b>{{$pedido->estado_pedido}}</b>
                                                            </td>
                                                            @if($pedido->estado_pago=='Pendiente')
                                                            <td class="text-center"><button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#pagar" >Pagar
                                                            </button> <a class="btn btn-outline-warning btn-sm" type="button" target="_blank" href='https://api.whatsapp.com/send?phone=51958695315&text=Hola, soy {{$pedido->nombre_padre}} {{$pedido->apellido_padre}} y te envìo mi pago del pedido de {{$pedido->nombre_plato}} con el costo de S/{{ number_format($pedido->precio_plato, 2) }} del dia {{ date('d/m/Y', strtotime($pedido->fecha_pedido)) }}.'>Enviar Pago
                                                            </a>
                                                            <button class="btn btn-outline-dark btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#yape" >QR YAPE
                                                            </button>
                                                            <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#plin" >QR PLIN
                                                            </button>
                                                            </td>
                                                            @else
                                                            <td></td>
                                                            @endif
                                                            
                                                       
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="tab-2">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                    @if(Auth::user()->rol === 'Padre')    
                                                    <th>Apoderado</th>
                                                    <th>Estudiante</th>
                                                    @endif
                                                    <th>Plato</th>
                                                    <th>Precio</th>
                                                    <th class="text-center">Estado pago</th>
                                                    <th class="text-center">Recreo</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Estado Pedido</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     @foreach($pedidos as  $pedido)
                                                     @if($pedido->estado_pago=='Pagado')
                                                    <tr>
                                                        <td>{{$pedido->fecha_pedido}}</td>
                                                        @if(Auth::user()->rol === 'Padre')
                                                        <td>{{$pedido->nombre_padre}} {{$pedido->apellido_padre}}</td>
                                                        <td>{{$pedido->nombre_alumno}} {{$pedido->apellido_alumno}}</td>
                                                        @endif
                                                        <td>{{$pedido->nombre_plato}}</td>
                                                        <td>S/{{$pedido->precio_plato}}.00</td>
                                                        <td class="text-center">{{$pedido->estado_pago}}</td>
                                                        <td class="text-center">{{$pedido->Recreo}}</td>
                                                        
                                                         
                                                         <!-- Select de Tipo Pago -->
                                                            <td>
                                                              {{$pedido->tipo_pago}}
                                                            </td>

                                                            <!-- Select de Estado Pedido -->
                                                            <td style="color:black;">
                                                               <b>{{$pedido->estado_pedido}}</b>
                                                            </td>
                                                            

                                                       
                                                    </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="tab-3">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                            <th>Fecha</th>
                                                    @if(Auth::user()->rol === 'Padre')        
                                                    <th>Apoderado</th>
                                                    <th>Estudiante</th>
                                                    @endif
                                                    <th>Plato</th>
                                                    <th>Precio</th>
                                                    <th class="text-center">Estado pago</th>
                                                    <th class="text-center">Recreo</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Estado Pedido</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach($pedidos as  $pedido)
                                                     @if($pedido->estado_pago=='Pendiente')
                                                    <tr>
                                                        <td>{{$pedido->fecha_pedido}}</td>
                                                        @if(Auth::user()->rol === 'Padre')
                                                        <td>{{$pedido->nombre_padre}} {{$pedido->apellido_padre}}</td>
                                                        <td>{{$pedido->nombre_alumno}} {{$pedido->apellido_alumno}}</td>
                                                        @endif
                                                        <td>{{$pedido->nombre_plato}}</td>
                                                        <td>S/{{$pedido->precio_plato}}.00</td>
                                                        <td class="text-center">{{$pedido->estado_pago}}</td>
                                                        <td class="text-center">{{$pedido->Recreo}}</td>
                                                        
                                                         
                                                         <!-- Select de Tipo Pago -->
                                                            <td>
                                                              {{$pedido->tipo_pago}}
                                                            </td>

                                                            <!-- Select de Estado Pedido -->
                                                            <td style="color:black;">
                                                               <b>{{$pedido->estado_pedido}}</b>
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

<!-- Modal QR mejorado -->
<div class="modal fade" id="modalQr" tabindex="-1" aria-labelledby="modalQrLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-3">
        
        {{-- Imagen con tamaño máximo adaptable --}}
        <img src="assets/img/Pagos.jpeg" alt="Código QR" class="img-fluid mb-3 mx-auto d-block" style="max-width: 100%; height: auto; border-radius: 10px;">

        @php
            $nombre = Auth::user()->name;
            $monto = number_format($deudaTotal, 2);
            $mensaje = urlencode("¡Hola! Soy $nombre y vengo de App Prandium. Adjunto mi comprobante de pago por la deuda total de S/ $monto.");
        @endphp

        <div style="margin-top:-55px;">
            <a href="https://wa.me/51958695315?text={{ $mensaje }}"
               target="_blank"
               class="btn btn-success"
               style="max-width: 300px; width: 100%;">
               <i class="fab fa-whatsapp"></i> Enviar comprobante
            </a>
        </div>

        <button type="button" class="btn btn-secondary mt-2" data-bs-dismiss="modal" style="max-width: 300px; width: 100%;">
            Cerrar
        </button>
      </div>
    </div>
  </div>
</div>                
<script>
function editarecreo(idpedido) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idpedido').value = idpedido;


      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }    
    
     
</script>
           
@endsection