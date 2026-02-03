@extends('Padre.layout')

@section('contenido')

<div class="container-fluid">
                    <h3 class="text-dark mb-4" style="font-size: 19px;"><i class="fa fa-user"></i>&nbsp;Perfil</h3>
                    @if (session('alert1'))
					<div class="alert alert-success" role="alert">
					 <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
					</div>
					@endif
                    <div class="row mb-3">

                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="assets/img/padre.jpg" width="160" height="160">
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Change Photo</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row mb-3 d-none">
                                <div class="col">
                                    <div class="card textwhite bg-primary text-white shadow">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <p class="m-0">Peformance</p>
                                                    <p class="m-0"><strong>65.2%</strong></p>
                                                </div>
                                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                            </div>
                                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card textwhite bg-success text-white shadow">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <p class="m-0">Peformance</p>
                                                    <p class="m-0"><strong>65.2%</strong></p>
                                                </div>
                                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                            </div>
                                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Datos del Usuario</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('editarperfilpadre') }}" method="POST">
                     							@csrf
                                                <div class="row">
                                                    @foreach($datos as $dato)
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Nombre</strong></label><input class="form-control" type="text" value="{{$dato->nombre_padre}}" placeholder="user.name" name="nombre_padre"></div>
                                                    </div>
                                                    <div class="col">
                                                        
                                                        <div class="mb-3"><label class="form-label" for="email"><strong>Apellido</strong></label><input class="form-control" type="text"  value="{{$dato->apellido_padre}}" name="apellido_padre"></div>
                                                       
                                                    </div>
                                                     @endforeach
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>Email</strong><br></label><input class="form-control" value="{{Auth::user()->email}}" type="email" id="" placeholder="Clave" name="email_padre"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="last_name"><strong>Nueva Clave</strong></label><input class="form-control" type="password" name="password" value="password"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Guardar Cambios</button></div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Datos Adicionales</p>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                            	@foreach($datos as  $dato)
                                                <div class="mb-3"><label class="form-label" for="address"><strong>Celular</strong></label><input class="form-control" type="text" value="{{$dato->celular_padre}}" placeholder="" name="celular_padre"></div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="city"><strong>DNI</strong></label><input class="form-control" type="text" id="city" readonly value="{{$dato->dni_padre}}" placeholder="Pucallpa" name="city"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="country"><strong>Estado</strong></label><input class="form-control" type="text" id="country" value="Activo" readonly placeholder="Activo" name="country"></div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Guardar Cambios</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@endsection