@extends('Admin.layout')

@section('contenido')

                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Dashboard</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>PADRES REGISTRADOS<br></span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>{{$padres}}</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fa fa-user" style="font-size: 33px;color: rgb(0,0,0);"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>ALUMNOS REGISTRADOS</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>{{$alumnos}}</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-graduate" style="font-size: 33px;color: rgb(0,0,0);"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Platos vendidos</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span>{{$pedidos}} UND</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-graduate" style="font-size: 33px;color: rgb(0,0,0);"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>platos pagados</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>{{$pagados}} UND</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-comment-dollar" style="font-size: 33px;color: rgb(0,0,0);"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
                </div>
            </footer>
        </div>



@endsection