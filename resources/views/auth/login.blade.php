<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Prandium </title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
    <link rel="stylesheet" href="assets/css/info-box.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search-1.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    
    <!-- Agregar un bloque de estilos para la imagen -->
    <style>
        #login-block img {
            width: 100%;   /* Hace que la imagen ocupe todo el ancho del contenedor */
            height: auto;  /* Mantiene la relación de aspecto */
        }
        
        /* Estilo para el fondo con logotipo en forma de mosaico */
        #bg-block {
            background: url('assets/img/loguito.jpg') repeat; /* Aplica la imagen de fondo en mosaico */
            background-size: 250px 150px; /* Redefine el tamaño de la imagen en cada repetición */
            background-color: white; /* Color de fondo blanco por si la imagen es pequeña */
        }
    </style>
</head>

<body>
    
<!-- Modal para recuperación mejorado -->
<div class="modal fade" id="modalRecuperarClave" tabindex="-1" aria-labelledby="modalRecuperarClaveLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('recuperar.clave') }}" class="modal-content shadow-lg border-0 rounded-4">
        @csrf
        <div class="modal-header bg-primary text-white rounded-top-4">
            <h5 class="modal-title fw-bold" id="modalRecuperarClaveLabel">
                <i class="fas fa-key me-2"></i> Recuperar Contraseña
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body bg-light">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" class="form-control rounded-pill shadow-sm" name="dni" placeholder="Ingrese su DNI" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control rounded-pill shadow-sm" name="email" placeholder="ejemplo@correo.com" required>
            </div>
        </div>
        <div class="modal-footer bg-white">
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                <i class="fas fa-sync-alt me-1"></i> Generar nueva clave
            </button>
        </div>
    </form>
  </div>
</div>


    <div class="container-fluid">
        <div class="row mh-100vh">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block">
                <div class="m-auto w-lg-75 w-xl-50">
                <div style="margin-top:50px;"><h2 class="text-info fw-light mb-5" ><i class="fa fa-user"></i>&nbsp;Sistema V2.0</h2></div>
                    @if(session('nueva_clave'))
                        <div class="alert alert-success">
                            <strong>¡Nueva clave generada!</strong><br>
                            Tu nueva clave es: <b>{{ session('nueva_clave') }}</b><br>
                            Te recomendamos cambiarla después de iniciar sesión.
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-triangle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>Usuario o Contraseña Incorrecto!</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
                        </div>
                    @endforeach<br>
                    @if (session('alert1'))
                    <div class="alert alert-success" role="alert">
                     <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" style="margin-top:-30px;">
                        @csrf
                        <div class="form-group mb-3"><label class="form-label text-secondary">Email</label><input class="form-control" type="text" required=""  inputmode="email" name="email"></div>
                        <div class="form-group mb-3"><label class="form-label text-secondary">Password</label><input class="form-control" type="password" required="" name="password"></div><button class="btn btn-info mt-2" type="submit" role="button" style="width: 100%;">Ingresar</button>
                    </form>
                  
                  <div class="text-center mt-4">
                    <a href="{{route('registrar')}}">Registrarse</a> <a href="#" data-bs-toggle="modal" data-bs-target="#modalRecuperarClave">¿Olvidaste tu contraseña?</a>
                </div>  
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block">
                <p class="ms-auto small text-dark mb-2"><em>&nbsp;</em><a class="text-dark" href="https://unsplash.com/photos/v0zVmWULYTg?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText" target="_blank"><em></em></a><br></p>
            </div>
        </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/Table-With-Search.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
