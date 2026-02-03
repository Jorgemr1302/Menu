<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - Brand</title>
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
</head>
<script>
    function validarContraseñas() {
        var password = document.getElementById('examplePasswordInput').value;
        var passwordRepeat = document.getElementById('exampleRepeatPasswordInput').value;

        if (password !== passwordRepeat) {
            alert('Las contraseñas no coinciden. Por favor, intente nuevamente.');
            return false; // Evita que el formulario se envíe
        }

        return true; // El formulario se enviará si las contraseñas coinciden
    }
</script>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background: url(&quot;assets/img/dogs/diferentes-platos-comida-mesa_1639-26531.avif&quot;) center no-repeat;"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Registrate para acceder al sistema!</h4>
                            </div><div class="alert alert-info" role="alert">
<i class="fa fa-warning" style="font-size: 16px;"></i><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"><strong>Aviso:</strong></span><span class="text-black margin-left" style="margin: 0px;margin-left: 10px;">Recuerde que el registro solo es para padres de </span>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
<span class="text-danger" > familia, apoderados o profesor</span>   
</div>

<form action="{{ route('registrarpadre') }}" method="POST" onsubmit="return validarContraseñas()">
                        @csrf
                        <!-- SELECT agregado -->
                        <div class="mb-3">
                            
                            <select class="form-select" name="tipo_usuario" required>
                                <option value="" selected disabled>Seleccione si es Padre o Profesor</option>
                                <option value="padre">Padre</option>
                                <option value="profesor">Profesor</option>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input class="form-control form-control-user" type="text" id="exampleFirstName" required="" placeholder="Nombre" name="nombre_padre">
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control form-control-user" type="text" required="" id="exampleFirstName" placeholder="Apellido" name="apellido_padre">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-user" type="text" id="" required="" aria-describedby="emailHelp" placeholder="Celular" name="celular_padre" inputmode="numeric">
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-user" type="text" id="" required="" aria-describedby="emailHelp" placeholder="DNI" name="dni_padre" inputmode="numeric">
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-user" type="email" required="" id="exampleInputEmail-1" aria-describedby="emailHelp" placeholder="Email" name="email_padre">
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input class="form-control form-control-user" required="" type="password" id="examplePasswordInput" placeholder="Contraseña" name="password">
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control form-control-user" type="password" required="" id="exampleRepeatPasswordInput" placeholder="Repita su Contraseña" name="password_repeat">
                            </div>
                        </div>
                        <button class="btn btn-primary d-block btn-user w-100" type="submit">Registrarse</button>
                        <hr>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/Table-With-Search.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>