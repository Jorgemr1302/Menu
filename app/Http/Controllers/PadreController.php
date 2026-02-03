<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;

use App\Models\User;

class PadreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function perfilpadre()
    {
        //
        $datos=DB::table('padre')
        ->where('dni_padre','=',Auth::user()->dni)
        ->get();
        return view('Padre.perfil',compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function editarperfilpadre(Request $request)
    {
        //
         //return $request->all();
        $contraseña=$request->input('password');
        $name=$request->input('nombre_padre')." ".$request->input('apellido_padre');
        $user=Auth::user()->dni;
        DB::table('users')
        ->where('dni','=',$user)
        ->update([

            'name'=>$name,
            'email'=>$request->input('email_padre'),
            'password'=> bcrypt($contraseña),

    ]);
        DB::table('padre')
        ->where('dni_padre','=',$user)
        ->update([

            'nombre_padre'=>$request->input('nombre_padre'),
            'apellido_padre'=>$request->input('apellido_padre'),
            'email_padre'=>$request->input('email_padre'),
            'clave'=>$contraseña,

    ]);

        return redirect()->route('perfilpadre')->with('alert1', 'Datos Modificados Satisfactoriamente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function pedidospadre(Request $request)
    {
        //

             //
    $pedidos = DB::table('pedido')
    // Unir la tabla alumno
    ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
    // Unir la tabla padre
    ->join('padre', 'alumno.padre_idpadre', '=', 'padre.idpadre')
    // Unir la tabla menu
    ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
    // Unir la tabla plato
    ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
    // Seleccionar los datos requeridos
    ->where('padre.dni_padre','=',Auth::user()->dni)
    ->select(
        'padre.nombre_padre',
        'padre.apellido_padre',
        'alumno.*',
        'plato.nombre_plato',
        'plato.precio_plato',
        'pedido.idpedido',
        'pedido.estado_pago',
        'pedido.estado_pedido',
        'pedido.tipo_pago',
        'pedido.Recreo',
        'pedido.fecha_pedido',
    )
    ->orderBy('pedido.fecha_pedido', 'desc')
    // Ejecutar la consulta y obtener los resultados
    ->get();
    $dni = auth()->user()->dni;
    $deudaTotal = DB::table('padre')
                ->join('alumno', 'padre.idpadre', '=', 'alumno.padre_idpadre')
                ->join('pedido', 'alumno.idalumno', '=', 'pedido.alumno_idalumno')
                ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
                ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
                ->where('padre.dni_padre', $dni)
                ->where('pedido.estado_pago', 'Pendiente')
                ->sum('plato.precio_plato');

        return view('Padre.pedidos',compact('pedidos','deudaTotal'));

    }

    /**
     * Display the specified resource.
     */
    public function menupadre(Request $request)
    {
        //
          // Obtener la fecha actual
$fechaActual = new DateTime("now", new DateTimeZone("America/Lima"));
//$fechaActual = new DateTime('2025-04-28', new DateTimeZone('America/Lima'));

// Nombres de los días en español
$diasSemana = [
    1 => 'lunes',
    2 => 'martes',
    3 => 'miércoles',
    4 => 'jueves',
    5 => 'viernes',
    6 => 'sábado',
    7 => 'domingo',
];

// Determinar el día actual
$numeroDiaActual = $fechaActual->format('N');

// Ajustar la fecha al lunes de la semana actual si es un día de semana
if ($numeroDiaActual >= 6) {
    $fechaActual->modify('next monday');
} else {
    $fechaActual->modify('monday this week');
}

// Inicializar variables para cada día de la semana
$lunes = '';
$martes = '';
$miercoles = '';
$jueves = '';
$viernes = '';
$sabado = '';
$domingo = '';

// Asignar fechas a variables individuales
for ($i = 0; $i < 7; $i++) {
    $fecha = clone $fechaActual; // Clonar la fecha actual
    $fecha->modify("+$i days");  // Sumar días
    $numeroDia = $fecha->format('N'); // Obtener el número del día
    
    // Asignar cada día a su variable correspondiente
    switch ($numeroDia) {
        case 1:
            $lunes = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            $fecha1= $fecha->format('Y-m-d');
            break;
        case 2:
            $martes = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            $fecha2= $fecha->format('Y-m-d');
            break;
        case 3:
            $miercoles = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            $fecha3= $fecha->format('Y-m-d');
            break;
        case 4:
            $jueves = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            $fecha4= $fecha->format('Y-m-d');
            break;
        case 5:
            $viernes = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            $fecha5= $fecha->format('Y-m-d');
            break;
        case 6:
            $sabado = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            break;
        case 7:
            $domingo = $diasSemana[$numeroDia] . ' ' . $fecha->format('d');
            break;
    }
                         }

    $lunesplatos=DB::table('menu')
    ->join('plato','menu.plato_idplato','=','plato.idplato')
    ->where('fecha_menu','=',$fecha1)
    ->select('plato.*','menu.*')
    ->get();

    $martesplatos=DB::table('menu')
    ->join('plato','menu.plato_idplato','=','plato.idplato')
    ->where('fecha_menu','=',$fecha2)
    ->select('plato.*','menu.*')
    ->get();

    $miercolesplatos=DB::table('menu')
    ->join('plato','menu.plato_idplato','=','plato.idplato')
    ->where('fecha_menu','=',$fecha3)
    ->select('plato.*','menu.*')
    ->get();
                          
    $juevesplatos=DB::table('menu')
    ->join('plato','menu.plato_idplato','=','plato.idplato')
    ->where('fecha_menu','=',$fecha4)
    ->select('plato.*','menu.*')
    ->get();

    $viernesplatos=DB::table('menu')
    ->join('plato','menu.plato_idplato','=','plato.idplato')
    ->where('fecha_menu','=',$fecha5)
    ->select('plato.*','menu.*')
    ->get();

    $platos=DB::table('plato')->where('estado_plato','=','Activo')->get();
    
    $padres=DB::table('padre')
    ->join('alumno','padre.idpadre','=','alumno.padre_idpadre')
    ->where('alumno.estado_alumno','=','Activo')
    ->select('padre.*','alumno.*')
    
    ->get();
    
     $estado = DB::table('mantenimiento')->value('estado_mantenimiento');
        return view('Padre.menu',compact('lunes','lunesplatos','fecha1','martes','martesplatos','fecha2','miercoles','miercolesplatos','fecha3','jueves','juevesplatos','fecha4','viernes','viernesplatos','fecha5','platos','padres','estado'));
   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function registrar()
    {
        //
        return view('Padre.registrar');
    }

    /**
     * Update the specified resource in storage.
     */
    public function registrarpadre(Request $request)
    {   
        $email = $request->input('email_padre');

        // Verificar si el email ya existe
        $existe = DB::table('padre')->where('email_padre', $email)->exists();

        if ($existe) {
            return redirect()->route('/')->with('alert1', 'Email ya registrado, vuelva a registrarse con otro email.');
        }

        // Obtener contraseña y tipo de usuario
        $contraseña = $request->input('password');
        $tipo_usuario = $request->input('tipo_usuario');
        $rol_usuario = ($tipo_usuario === 'profesor') ? 'Profesor' : 'Padre';

        // Registrar en tabla users
        $user = new User([
            "name" => $request->input('nombre_padre') . " " . $request->input('apellido_padre'),
            "email" => $email,
            "password" => bcrypt($contraseña),
            "rol" => $rol_usuario,
            "estado" => "Activo",
            "dni" => $request->input('dni_padre'),
        ]);
        $user->save();

        // Insertar en tabla padre
        DB::table('padre')->insert([
            'idpadre' => $request->input('dni_padre'),
            'nombre_padre' => $request->input('nombre_padre'),
            'apellido_padre' => $request->input('apellido_padre'),
            'dni_padre' => $request->input('dni_padre'),
            'celular_padre' => $request->input('celular_padre'),
            'estado_padre' => 'Activo',
            'email_padre' => $email,
            'clave' => $contraseña, // texto plano (puedes aplicar bcrypt si lo usas para login directo)
            'tipo_usuario' => $tipo_usuario,
        ]);

        // Si es profesor, crear alumno ficticio
        if ($tipo_usuario === 'profesor') {
            DB::table('alumno')->insert([
                'nombre_alumno' => $request->input('nombre_padre'),
                'apellido_alumno' => $request->input('apellido_padre'),
                'dni_alumno' => $request->input('dni_padre'),
                'nivel_alumno' => 'Profesor',
                'grado_alumno' => 'N/A',
                'seccion_alumno' => 'N/A',
                'estado_alumno' => 'Activo',
                'padre_idpadre' => $request->input('dni_padre'),
            ]);
        }

        return redirect()->route('/')->with('alert1', 'Usuario Registrado');
    }

    
    public function realizarpedidopadre(Request $request)
    {

        DB::table('pedido')
        ->insert([
            'fecha_pedido'=>$request->input('fecha_pedido'),
            'alumno_idalumno'=>$request->input('idalumno'),
            'Recreo'=>$request->input('Recreo'),
            'menu_idmenu'=>$request->input('idmenu'),
            'estado_pedido'=>'No entregado',
            'estado_pago'=>'Pendiente',
            'tipo_pago'=>'No definido',



        ]);

        $stock=DB::table('menu')
        ->where('idmenu','=',$request->input('idmenu'))
        ->sum('menu.stock_plato');

        $stock_actual=$stock-1;

        DB::table('menu')
        ->where('idmenu','=',$request->input('idmenu'))
        ->update([

            'stock_plato'=>$stock_actual,
        ]);


        return redirect()->route('pedidospadre')->with('alert1', 'Pedido Agregado Satisfactoriamente');


    }
    /**
     * Remove the specified resource from storage.
     */
    public function hijos()
    {
        //
        $hijos=DB::table('alumno')
        ->join('padre','alumno.padre_idpadre','=','padre.idpadre')
        ->where('padre.dni_padre','=',Auth::user()->dni)
        ->where('estado_alumno','=','Activo')
        ->get();
        return view('Padre.hijos',compact('hijos'));
        
    }
    
    public function agregarhijo(Request $request)
    {
        //
        $hijos=DB::table('alumno')
        ->insert([
            'nombre_alumno'=>$request->input('nombre_alumno'),
            'apellido_alumno'=>$request->input('apellido_alumno'),
            'dni_alumno'=>$request->input('dni_alumno'),
            'nivel_alumno'=>$request->input('nivel_alumno'),
            'grado_alumno'=>$request->input('grado_alumno'),
            'seccion_alumno'=>$request->input('seccion_alumno'),
            'estado_alumno'=>'Activo',
            'padre_idpadre'=>Auth::user()->dni,

            
            
            ]);
            return redirect()->route('hijos')->with('alert1', 'Hijo(a) Agregado(a) Satisfactoriamente');
    }
    
    public function editarhijop(Request $request)
    {
        //

        $idalumno=$request->input('idalumno');
        DB::table('alumno')
        ->where('idalumno',$idalumno)
        ->update([
            "nombre_alumno" =>$request->input('nombre_alumno'),
            "apellido_alumno" =>$request->input('apellido_alumno'),
            "dni_alumno" =>$request->input('dni_alumno'),
            "nivel_alumno" =>$request->input('nivel_alumno'),
            "grado_alumno" =>$request->input('grado_alumno'),
            "seccion_alumno" =>$request->input('seccion_alumno'),
            
                 
    
        ]);

        return redirect()->route('hijos')->with('alert1', 'Alumno Modificado Satisfactoriamente!');
    }
    
    public function eliminarhijop(Request $request)
    {
        //

        $idalumno=$request->input('idalumno');
        DB::table('alumno')
        ->where('idalumno',$idalumno)
        ->update([
            "estado_alumno" =>'Inactivo',
           
        ]);

        return redirect()->route('hijos')->with('alert1', 'Alumno Eliminado Satisfactoriamente!');
    }
    
    public function editarrecreop(Request $request)
    {
        //

        $idpedido=$request->input('idpedido');
        $recreo=$request->input('recreo');
        DB::table('pedido')
        ->where('idpedido',$idpedido)
        ->update([
            "Recreo" =>$recreo,
           
        ]);

        return redirect()->route('pedidospadre')->with('alert1', 'Recreo Modificado Satisfactoriamente!');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
