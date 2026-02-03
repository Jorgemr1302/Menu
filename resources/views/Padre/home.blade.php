@extends('Padre.layout')

@section('contenido')
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0"><i class="fa fa-dashboard"></i>&nbsp;Home</h3>
    </div>
    <div class="row">
        @if(Auth::user()->rol==='Padre')
        <!-- Hijos registrados -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-primary py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1">HIJOS REGISTRADOS</div>
                            <div class="text-dark fw-bold h5 mb-0">{{ $hijosRegistrados }}</div>
                        </div>
                        <div class="col-auto"><i class="fa fa-users" style="font-size: 33px; color: #000;"></i></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Total platos pedidos -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1">TOTAL DE PLATOS PEDIDOS</div>
                            <div class="text-dark fw-bold h5 mb-0">{{ $totalPlatosPedidos }} UND</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-utensils" style="font-size: 33px; color: #000;"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platos pedidos hoy -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-info py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-info fw-bold text-xs mb-1">PLATOS PEDIDOS HOY</div>
                            <div class="text-dark fw-bold h5 mb-0">{{ $platosHoy }} UND</div>
                        </div>
                        <div class="col-auto"><i class="far fa-calendar-check" style="font-size: 33px; color: #000;"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deuda total -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-danger py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-danger fw-bold text-xs mb-1">
                                <span>Deuda total</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0">
                                <span>S/ {{ number_format($deudaTotal, 2) }}</span>
                            </div>
                        </div>
        
                        {{-- Botón en reemplazo del ícono --}}
                        <div class="col-auto">
                            <button class="btn btn-sm btn-danger px-3" data-bs-toggle="modal" data-bs-target="#modalQr">
                                <i class="fa fa-money"></i> Pagar
                            </button>
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




@endsection
