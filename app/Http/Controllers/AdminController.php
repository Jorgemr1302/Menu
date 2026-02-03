<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function crear()
    {
        //
        $contraseña = "admin@2024";
        $user = new User([
            "name" => "Carina Ocaña",
            "email" => "Carina@prandium.com",
            "password" => bcrypt($contraseña),
            "rol" => "Administrador",
            "estado" => "Activo",
               ]);
        $user->save();
        return "usuario creado.";
    }
    public function platos()
    {
        //
        $platos=DB::table('plato')
        ->where('estado_plato','=','Activo')
        ->where('tipo_plato','=','Individual')
        ->orderby('idplato','desc')
        ->get();

        return view('Admin.platos',compact('platos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function crearplato(Request $request)
    {
        //

        DB::table('plato')->insert([
            "nombre_plato" =>$request->input('nombre_plato'),
            "descripcion_plato" =>$request->input('descripcion_plato'),
            "precio_plato" =>$request->input('precio_plato'),
            "estado_plato"=>'Activo',
            "tipo_plato"=>'Individual',
    
        ]);

        return redirect()->route('platos')->with('alert1', 'Plato Agregado Satisfactoriamente!');


    }

    /**
     * Store a newly created resource in storage.
     */
    public function editarplato(Request $request)
    {
        //        return $request->all();
        $idplato=$request->input('idplato');
        DB::table('plato')
        ->where('idplato',$idplato)
        ->update([
            "nombre_plato" =>$request->input('nombre_plato'),
            "descripcion_plato" =>$request->input('descripcion_plato'),
            "precio_plato" =>$request->input('precio_plato'),
            
    
        ]);

        return redirect()->route('platos')->with('alert1', 'Plato Modificado Satisfactoriamente!');

    }

    /**
     * Display the specified resource.
     */
    public function eliminarplato(Request $request)
    {
        //
        //return $request->all();
        $idplato=$request->input('idplato');
        DB::table('plato')
        ->where('idplato',$idplato)
        ->update([
            "estado_plato" =>'Inactivo',
                 
    
        ]);

        return redirect()->route('platos')->with('alert1', 'Plato Eliminado Satisfactoriamente!');

    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function pedidos(Request $request)
    {   
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
            ->select(
                'padre.nombre_padre',
                'padre.apellido_padre',
                'alumno.*',
                'plato.nombre_plato',
                'plato.descripcion_plato',
                'plato.precio_plato',
                'pedido.idpedido',
                'pedido.estado_pago',
                'pedido.estado_pedido',
                'pedido.tipo_pago',
                'pedido.Recreo',
                'pedido.fecha_pedido',
            )
            ->where(function ($query) {
                $query->whereNull('padre.tipo_usuario')
                      ->orWhereRaw("LOWER(padre.tipo_usuario) != 'profesor'");
            })
            ->orderBy('pedido.fecha_pedido', 'desc')
            ->get();
    
        // Aquí calculamos el total por cada grupo de pedidos
        $grupos_pedidos = DB::table('pedido')
            ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
            ->join('padre', 'alumno.padre_idpadre', '=', 'padre.idpadre')
            ->select(
                'padre.nombre_padre',
                'padre.apellido_padre',
                'alumno.idalumno',
                'alumno.nombre_alumno',
                'alumno.apellido_alumno',
                'pedido.Recreo',
                'pedido.fecha_pedido',
                DB::raw('COUNT(pedido.idpedido) as cantidad_pedidos'),
                DB::raw('SUM(plato.precio_plato) as precio_total'),  // Aquí calculamos el precio total del grupo
                DB::raw('MIN(pedido.tipo_pago) as tipo_pago'),
                DB::raw('MIN(pedido.estado_pedido) as estado_pedido'),
                DB::raw('MIN(pedido.estado_pago) as estado_pago')
            )
            ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')  // Aseguramos de unir la tabla de menús para acceder a los precios
            ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')  // Aseguramos de unir la tabla de platos para acceder a los precios
            ->where(function ($query) {
                $query->whereNull('padre.tipo_usuario')
                    ->orWhereRaw("LOWER(padre.tipo_usuario) != 'profesor'");
            })
            ->groupBy(
                'pedido.fecha_pedido',
                'pedido.Recreo',
                'alumno.idalumno',
                'padre.nombre_padre',
                'padre.apellido_padre',
                'alumno.nombre_alumno',
                'alumno.apellido_alumno'
            )
            ->orderBy('pedido.fecha_pedido', 'desc')
            ->get();
    
        return view('Admin.pedidos', compact('pedidos', 'grupos_pedidos'));
    }


    public function pedidosprofesor(Request $request)
    {   
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
        ->select(
            'padre.nombre_padre',
            'padre.apellido_padre',
            'alumno.*',
            'plato.nombre_plato',
            'plato.descripcion_plato',
            'plato.precio_plato',
            'pedido.idpedido',
            'pedido.estado_pago',
            'pedido.estado_pedido',
            'pedido.tipo_pago',
            'pedido.Recreo',
            'pedido.fecha_pedido',
        )
        ->whereRaw("LOWER(padre.tipo_usuario) = 'profesor'")
        ->orderBy('pedido.fecha_pedido', 'desc')
        ->get();

    // Aquí calculamos el total por cada grupo de pedidos para los profesores
    $grupos_pedidos = DB::table('pedido')
        ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
        ->join('padre', 'alumno.padre_idpadre', '=', 'padre.idpadre')
        ->select(
            'padre.nombre_padre',
            'padre.apellido_padre',
            'alumno.idalumno',
            'alumno.nombre_alumno',
            'alumno.apellido_alumno',
            'pedido.Recreo',
            'pedido.fecha_pedido',
            DB::raw('COUNT(pedido.idpedido) as cantidad_pedidos'),
            DB::raw('SUM(plato.precio_plato) as precio_total'),  // Aquí calculamos el precio total del grupo
            DB::raw('MIN(pedido.tipo_pago) as tipo_pago'),
            DB::raw('MIN(pedido.estado_pedido) as estado_pedido'),
            DB::raw('MIN(pedido.estado_pago) as estado_pago')
        )
        ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')  // Aseguramos de unir la tabla de menús para acceder a los precios
        ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')  // Aseguramos de unir la tabla de platos para acceder a los precios
        ->whereRaw("LOWER(padre.tipo_usuario) = 'profesor'") // Filtro solo para profesores
        ->groupBy(
            'pedido.fecha_pedido',
            'pedido.Recreo',
            'alumno.idalumno',
            'padre.nombre_padre',
            'padre.apellido_padre',
            'alumno.nombre_alumno',
            'alumno.apellido_alumno'
        )
        ->orderBy('pedido.fecha_pedido', 'desc')
        ->get();

    return view('Admin.pedidosprofesor', compact('pedidos', 'grupos_pedidos'));
}


    /**
     * Update the specified resource in storage.
     */
    public function deudaspendientes(Request $request)
    {
        //
       
        $usuarios = DB::table('padre')
        ->leftJoin('alumno', 'padre.idpadre', '=', 'alumno.padre_idpadre')
        ->leftJoin('pedido', 'alumno.idalumno', '=', 'pedido.alumno_idalumno')
        ->leftJoin('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
        ->leftJoin('plato', 'menu.plato_idplato', '=', 'plato.idplato') // Join clave agregado
        ->select(
            'padre.idpadre',
            'padre.nombre_padre',
            'padre.apellido_padre',
            'padre.tipo_usuario',
            'padre.email_padre',
            DB::raw('SUM(CASE WHEN pedido.estado_pago = "Pendiente" THEN plato.precio_plato ELSE 0 END) as deuda_total')
        )
        ->groupBy(
            'padre.idpadre',
            'padre.nombre_padre',
            'padre.apellido_padre',
            'padre.tipo_usuario',
            'padre.email_padre'
        )
        ->orderBy('padre.nombre_padre', 'asc')
        ->get();


        


        return view('Admin.deudas_pendientes',compact('usuarios'));
    }
    public function pagarDeudaTotal(Request $request)
    {
        $idpadre = $request->input('idpadre');
        $tipo_pago = $request->input('tipo_pago');
       
        $alumnos = DB::table('alumno')
            ->where('padre_idpadre', $idpadre)
            ->pluck('idalumno');

        if ($alumnos->isEmpty()) {
            return response()->json(['success' => false, 'mensaje' => 'No se encontraron hijos.'], 404);
        }

        DB::table('pedido')
            ->whereIn('alumno_idalumno', $alumnos)
            ->where('estado_pago', 'Pendiente')
            ->update([
                'estado_pago' => 'Pagado',
                'tipo_pago' => $tipo_pago
            ]);

        return response()->json(['success' => true, 'mensaje' => 'Deuda pagada correctamente con ' . $tipo_pago]);
    }




    public function padre_hijo(Request $request)
    {
        //
       
        $hijos=DB::table('padre')
        ->join('alumno', 'padre.idpadre', '=', 'alumno.padre_idpadre')
        ->select('padre.*','alumno.*')
        ->orderBy('padre.nombre_padre')
        ->get();

        $padres=DB::table('padre')->get();


        return view('Admin.padre_hijo',compact('padres','hijos'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function editarpadre(Request $request)
    {
        //
        //return $request->all();
        $idpadre=$request->input('idpadre');
        DB::table('padre')
        ->where('idpadre',$idpadre)
        ->update([
            "nombre_padre" =>$request->input('nombre_padre'),
            "apellido_padre" =>$request->input('apellido_padre'),
            "celular_padre" =>$request->input('celular_padre'),
            "email_padre" =>$request->input('email_padre'),
            "estado_padre" =>$request->input('estado_padre'),
                 
    
        ]);
        
        DB::table('users')
        ->where('dni',$request->input('dni_padre'))
        ->update([
            "estado"=>$request->input('estado_padre'),
            
            ]);
        

        return redirect()->route('padre_hijo')->with('alert1', 'Padre Modificado Satisfactoriamente!');

    }
    public function editarhijo(Request $request)
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

        return redirect()->route('padre_hijo')->with('alert1', 'Alumno Modificado Satisfactoriamente!');
    }
    
    private function obtenerFechaBaseSemana()
{
    $hoy = new DateTime("now", new DateTimeZone("America/Lima"));
    $diaSemana = $hoy->format('N'); // 1 = lunes ... 7 = domingo

    if ($diaSemana >= 6) {
        // sábado (6) o domingo (7) → lunes de la próxima semana
        $hoy->modify("monday next week");
    } else {
        // lunes a viernes → lunes de esta semana
        $hoy->modify("monday this week");
    }

    return Carbon::instance($hoy); // devolverlo como Carbon
}
   public function menu(Request $request)
{
    $offset = (int) $request->get('week', 0); // semana actual por defecto
    $fechaBase = new DateTime("now", new DateTimeZone("America/Lima"));

    // ✅ CORRECCIÓN: sábado (6) y domingo (7) → usar lunes NEXT week
    $diaSemana = $fechaBase->format('N'); // 1 = Lunes ... 7 = Domingo

    if ($diaSemana >= 6) {
        $fechaBase->modify("monday next week");
    } else {
        $fechaBase->modify("monday this week");
    }

    // Navegación por semanas (FUNCIONA COMO SIEMPRE)
    if ($offset !== 0) {
        $fechaBase->modify(($offset > 0 ? '+' : '') . ($offset * 7) . ' days');
    }

    $diasSemana = [
        1 => 'lunes',
        2 => 'martes',
        3 => 'miércoles',
        4 => 'jueves',
        5 => 'viernes',
        6 => 'sábado',
        7 => 'domingo',
    ];

    $fechas = [];
    for ($i = 0; $i < 7; $i++) {
        $fecha = clone $fechaBase;
        $fecha->modify("+$i days");
        $numeroDia = $fecha->format('N');
        $fechas[$diasSemana[$numeroDia]] = [
            'texto' => ucfirst($diasSemana[$numeroDia]) . ' ' . $fecha->format('d M'),
            'fecha' => $fecha->format('Y-m-d')
        ];
    }

    // Consultas por día
    $menus = [];
    foreach (['lunes', 'martes', 'miércoles', 'jueves', 'viernes'] as $dia) {
        $menus[$dia] = DB::table('menu')
            ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
            ->where('fecha_menu', '=', $fechas[$dia]['fecha'])
            ->select('plato.*', 'menu.*')
            ->get();
    }

    $platos = DB::table('plato')
        ->where('estado_plato', '=', 'Activo')
        ->where('tipo_plato', '=', 'Individual')
        ->get();

    $estado = DB::table('mantenimiento')->value('estado_mantenimiento');

    return view('Admin.menu', [
        'fechas' => $fechas,
        'menus' => $menus,
        'platos' => $platos,
        'estado' => $estado,
        'offset' => $offset
    ]);
}


public function agregarmenu(Request $request)
{
    DB::table('menu')->insert([
        "plato_idplato" => $request->input('idplato'),
        "cantidad_plato" => $request->input('cantidad_plato'),
        "stock_plato" => $request->input('cantidad_plato'),
        "fecha_menu" => $request->input('fecha_menu'),
    ]);

    // Fecha agregada
    $fecha = Carbon::parse($request->input('fecha_menu'));
    $fechaFormateada = $fecha->format('d-m-Y');

    // 🔥 USAR EL MISMO LUNES BASE QUE EL MÉTODO menu()
    $fechaBase = $this->obtenerFechaBaseSemana();  

    // 🔥 Ahora el offset SIEMPRE cuadra con menu()
    $offset = intdiv(
        $fecha->startOfDay()->diffInDays($fechaBase->startOfDay(), false),
        7
    );

    return redirect("menu?week={$offset}")
        ->with('alert1', 'Menú Agregado Satisfactoriamente para la fecha '.$fechaFormateada)
        ->with('fecha_destacada', $request->input('fecha_menu'));
}



    public function perfil(Request $request)
    {

        return view('Admin.perfil');
    }
     public function editarperfil(Request $request)
    {   

        //return $request->all();

        $user=Auth::user()->id;
        DB::table('users')
        ->where('id','=',$user)
        ->update([

            'name'=>$request->input('name'),
            'email'=>$request->input('email'),

    ]);

        return redirect()->route('perfil')->with('alert1', 'Usuario Modificado Satisfactoriamente');
    }

public function pedidosupdate(Request $request)
{
    try {
        $campo = $request->input('campo_a_actualizar');
        $valor = $request->input('nuevo_valor');
        $id = $request->input('pedido_id');
        $esGrupo = $request->input('es_grupo');

        if (!$campo || !$valor || !$id) {
            return response()->json(['mensaje' => 'Faltan datos para actualizar'], 422);
        }

        if ($esGrupo) {
            // Separar el identificador compuesto
            [$idalumno, $fecha, $recreo] = explode('|', $id);

            $query = DB::table('pedido')
                ->where('alumno_idalumno', $idalumno)
                ->where('fecha_pedido', $fecha)
                ->where('Recreo', $recreo);

            if ($campo === 'tipo_pago') {
                $query->update([
                    'tipo_pago' => $valor,
                    'estado_pago' => 'Pagado',
                ]);
                return response()->json(['mensaje' => 'Tipo de Pago fue actualizado correctamente']);
            } else {
                $query->update([
                    'estado_pedido' => $valor,
                ]);
                return response()->json(['mensaje' => 'Estado del Pedido fue actualizado correctamente']);
            }

        } else {
            // Actualización individual
            if ($campo === 'tipo_pago') {
                DB::table('pedido')
                    ->where('idpedido', $id)
                    ->update([
                        'tipo_pago' => $valor,
                        'estado_pago' => 'Pagado',
                    ]);
                return response()->json(['mensaje' => 'Tipo de Pago actualizado correctamente']);
            } else {
                DB::table('pedido')
                    ->where('idpedido', $id)
                    ->update([
                        'estado_pedido' => $valor,
                    ]);
                return response()->json(['mensaje' => 'Estado del Pedido actualizado correctamente']);
            }
        }
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Error: ' . $e->getMessage()], 500);
    }
}


public function pdf(Request $request)
    {   

         $data = ['title' => 'Prueba de PDF', 'content' => 'Este es el contenido del PDF.'];

        // Cargar la vista que quieres convertir a PDF
        $pdf = PDF::loadView('Admin.pdf', $data);

        // Mostrar el PDF en el navegador
        return $pdf->stream('documento.pdf');

        // Generar el PDF y devolverlo al navegador
       // return $pdf->download('documento.pdf');
    }

    public function ticket(Request $request)
{
    
 //   return $request->all();
    $data = [
        'nombre_alumno' => $request->input('nombre_alumno'),
        'apellido_alumno' => $request->input('apellido_alumno'),
        'nivel_alumno' => $request->input('nivel_alumno'),
        'grado_alumno' => $request->input('grado_alumno'),
        'seccion_alumno' => $request->input('seccion_alumno'),
        'nombre_plato' => $request->input('nombre_plato'),
        'descripcion_plato' => $request->input('descripcion_plato'),
        'Recreo' => $request->input('Recreo'),
        'precio_plato' => $request->input('precio_plato'),
        'fecha_pedido' => $request->input('fecha_pedido')
    ];

    // Establecer las opciones de configuración para el tamaño del papel A7
    $pdf = PDF::loadView('Admin.ticket', $data);
    
    // Configurar el tamaño del papel A7 (74mm x 105mm)
    $pdf->setPaper([0, 0, 74, 105]);

    // Mostrar el PDF en el navegador
    return $pdf->stream('ticket.pdf');
}


    public function reportes(Request $request)
    {   

       
        return view('Admin.reporte');
     }

    public function recreo(Request $request)
    {   
        $idpedido=$request->input('idpedido');
        DB::table('pedido')
        ->where('idpedido','=',$idpedido)
        ->update([

            'Recreo'=>$request->input('Recreo'),
            

            ]);

        return redirect()->route('pedidos')->with('alert1', 'Recreo Modificado Satisfactoriamente');

    }

    public function generar(Request $request)
    {   
        $fecha_inicio=$request->input('fecha_inicio');
        $fecha_fin=$request->input('fecha_fin');

        $idpadre=$request->input('idpadre');

       $padres=DB::table('padre')->where('idpadre','=',$idpadre)->get(); 
    
   // return $request->all();    
        
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
    ->where('idpadre','=',$idpadre)
    ->where('pedido.estado_pedido','!=','Anulado')
    ->where('pedido.estado_pago','=','Pendiente')
    ->where('pedido.fecha_pedido','>=',$fecha_inicio)
    ->where('pedido.fecha_pedido','<=',$fecha_fin)
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
   // Ejecutar la consulta y obtener los resultados
    ->get();

    $deudas = DB::table('pedido')
    // Unir la tabla alumno
    ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
    // Unir la tabla padre
    ->join('padre', 'alumno.padre_idpadre', '=', 'padre.idpadre')
    // Unir la tabla menu
    ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
    // Unir la tabla plato
    ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
    // Seleccionar los datos requeridos
    ->where('idpadre','=',$idpadre)
    ->where('pedido.estado_pedido','!=','Anulado')
    ->where('pedido.estado_pago','=','Pendiente')
    ->where('pedido.fecha_pedido','>=',$fecha_inicio)
    ->where('pedido.fecha_pedido','<=',$fecha_fin)
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
   // Ejecutar la consulta y obtener los resultados
    ->sum('plato.precio_plato');

    $pdf = PDF::loadView('Admin.deudas', compact('pedidos','deudas','padres','fecha_inicio','fecha_fin'));

        // Mostrar el PDF en el navegador
        return $pdf->stream('deudas.pdf');
  

    }

    public function pedidosadmin(Request $request)
    {
        $offset = (int) $request->get('week', 0); // semana actual por defecto
    
        $fechaBase = new DateTime("now", new DateTimeZone("America/Lima"));
        $fechaBase->modify("monday this week"); // empezar desde el lunes actual
    
        if ($offset !== 0) {
            $fechaBase->modify(($offset > 0 ? '+' : '') . ($offset * 7) . ' days');
        }
    
        // Nombres de los días
        $diasSemana = [
            1 => 'lunes',
            2 => 'martes',
            3 => 'miércoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sábado',
            7 => 'domingo',
        ];
    
        // Generar las fechas de la semana (solo lunes a viernes)
        $fechas = [];
        setlocale(LC_TIME, 'es_ES.UTF-8');
        \Carbon\Carbon::setLocale('es');
    
        for ($i = 0; $i < 5; $i++) { // solo lunes a viernes
            $fecha = clone $fechaBase;
            $fecha->modify("+$i days");
            $numeroDia = $fecha->format('N');
    
            $fechas[$diasSemana[$numeroDia]] = [
                'texto' => ucfirst($diasSemana[$numeroDia]) . ' ' . $fecha->format('d') . ' de ' . strftime('%B', $fecha->getTimestamp()),
                'fecha' => $fecha->format('Y-m-d'),
            ];
        }
    
        // Obtener menús por día (para mostrar pedidos)
        $menus = [];
        foreach ($fechas as $dia => $info) {
            $menus[$dia] = DB::table('menu')
                ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
                ->where('fecha_menu', '=', $info['fecha'])
                ->select('plato.*', 'menu.*')
                ->get();
        }
    
        // Platos activos
        $platos = DB::table('plato')
            ->where('estado_plato', '=', 'Activo')
            ->get();
    
        // Padres y alumnos activos
        $padres = DB::table('padre')
            ->join('alumno', 'padre.idpadre', '=', 'alumno.padre_idpadre')
            ->where('alumno.estado_alumno', '=', 'Activo')
            ->select('padre.*', 'alumno.*')
            ->get();
    
        // Rango semanal (para mostrar arriba)
        $inicioSemana = reset($fechas);
        $finSemana = end($fechas);
        $rangoSemana = \Carbon\Carbon::parse($inicioSemana['fecha'])->translatedFormat('d \d\e F') .
            ' al ' .
            \Carbon\Carbon::parse($finSemana['fecha'])->translatedFormat('d \d\e F \d\e Y');
    
        return view('Admin.pedidosadmin', compact('fechas', 'menus', 'platos', 'padres', 'offset', 'rangoSemana'));
    }



    public function realizarpedido(Request $request)
    {
        //return $request->all();

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


        return redirect()->route('pedidos')->with('alert1', 'Pedido Agregado Satisfactoriamente');


    }
    public function editarstock(Request $request)
    {
        $idmenu=$request->input('idmenu');
        $stock_plato=$request->input('stock_plato');
    DB::table('menu')->where('idmenu','=',$idmenu)
    ->update([
        'stock_plato'=>$stock_plato,  
        
        ]);
        return redirect()->route('menu')->with('alert1', 'Stock Modificado Satisfactoriamente!');
    }
    
    public function recarga(Request $request)
    {
        $padres=DB::table('padre')->get();
        return view('Admin.recarga',compact('padres'));
    }
    
    public function recargar(Request $request)
    {
    //return $request->all();     
         
    $pedidos=DB::table('pedido')
    // Unir la tabla alumno
    ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
    // Unir la tabla padre
    ->join('padre', 'alumno.padre_idpadre', '=', 'padre.idpadre')
    // Unir la tabla menu
    ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
    // Unir la tabla plato
    ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
    // Seleccionar los datos requeridos
    ->where('pedido.estado_pago','=','Pendiente')
    ->where('padre.idpadre','=',$request->input('idpadre'))
    
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
    // Ejecutar la consulta y obtener los resultados
    ->sum('plato.precio_plato');
    //return $pedidos;
        
        DB::table('saldo')
        ->insert([
            'fecha_recarga'=>$request->input('fecha_recarga'),
            'saldo_recarga'=>$request->input('saldo_recarga'),
            'idpadre'=>$request->input('idpadre_hidden'),
            
            ]);
        
        $recargas=DB::table('saldo')
        ->where('idpadre','=',$request->input('idpadre_hidden'))
        ->sum('saldo_recarga');
        

    
    
    $saldonuevo=$recargas-$pedidos;
        
        DB::table('padre')
        ->where('idpadre','=',$request->input('idpadre_hidden'))
        ->update([
            'saldo_actual'=>$saldonuevo,
          
            ]);
        $dni=DB::table('padre')
       ->where('idpadre','=',$request->input('idpadre_hidden'))
       ->sum('dni_padre');
        
        DB::table('users')
        ->where('dni','=',$dni)
        ->update([
            'saldo_actual'=>$saldonuevo,
          
            ]);
            
        return redirect()->route('padre_hijo')->with('alert1', 'Recarga Realizada Satisfactoriamente');
    }
    
    public function agregarlonchera(Request $request)
{
    // Insertar el plato
    $id = DB::table('plato')->insertGetId([
        "nombre_plato"       => $request->input('nombre_plato'),
        "descripcion_plato"  => $request->input('descripcion_plato'),
        "precio_plato"       => $request->input('precio_plato'),
        "estado_plato"       => 'Activo',
        "tipo_plato"         => 'Lonchera',
    ]);

    // Insertar menú
    DB::table('menu')->insert([
        "plato_idplato"  => $id,
        "cantidad_plato" => $request->input('cantidad_plato'),
        "stock_plato"    => $request->input('cantidad_plato'),
        "fecha_menu"     => $request->input('fecha_menu'),
    ]);

    // Fecha a donde se agregó
    $fecha = Carbon::parse($request->input('fecha_menu'));
    $fechaFormateada = $fecha->format('d-m-Y');

    // 🚀 Calcular offset usando la misma base del método "menu()"
    $fechaBase = $this->obtenerFechaBaseSemana();
    $offset = intdiv(
        $fecha->startOfDay()->diffInDays($fechaBase->startOfDay(), false),
        7
    );

    return redirect("menu?week={$offset}")
        ->with('alert1', 'Lonchera Agregada Satisfactoriamente para la fecha ' . $fechaFormateada)
        ->with('fecha_destacada', $fecha->format('Y-m-d'));
}



public function agregarpra(Request $request)
{
    $entrada = $request->input('entrada_plato');
    $segundo = $request->input('segundo_plato');

    // Insertar plato Prandium
    $id = DB::table('plato')->insertGetId([
        "nombre_plato"      => 'Menu Prandium',
        "descripcion_plato" => '➼ Entradas: ' . $entrada . ' ➼ Segundo: ' . $segundo,
        "precio_plato"      => $request->input('precio_plato'),
        "estado_plato"      => 'Activo',
        "tipo_plato"        => 'Menu',
    ]);

    // Insertar menú
    DB::table('menu')->insert([
        "plato_idplato"  => $id,
        "cantidad_plato" => $request->input('cantidad_plato'),
        "stock_plato"    => $request->input('cantidad_plato'),
        "fecha_menu"     => $request->input('fecha_menu'),
    ]);

    // Fecha agregada
    $fecha = Carbon::parse($request->input('fecha_menu'));
    $fechaFormateada = $fecha->format('d-m-Y');

    // 🚀 Calcular offset igual al método "menu()"
    $fechaBase = $this->obtenerFechaBaseSemana();
    $offset = intdiv(
        $fecha->startOfDay()->diffInDays($fechaBase->startOfDay(), false),
        7
    );

    return redirect("menu?week={$offset}")
        ->with('alert1', 'Menú Prandium Agregado Satisfactoriamente para la fecha ' . $fechaFormateada)
        ->with('fecha_destacada', $fecha->format('Y-m-d'));
}




public function eliminarmenu(Request $request)
{
    $idmenu = $request->input('idmenu');

    // Obtener el menú antes de eliminar
    $menu = DB::table('menu')->where('idmenu', $idmenu)->first();

    if ($menu) {
        $fechaMenu = Carbon::parse($menu->fecha_menu);
        $fechaFormateada = $fechaMenu->format('d-m-Y');

        // 🚀 Usamos la MISMA fecha base que el método "menu()"
        $fechaBase = $this->obtenerFechaBaseSemana();

        // 🚀 Calcular offset EXACTO como agregarmenu()
        $offset = intdiv(
            $fechaMenu->startOfDay()->diffInDays($fechaBase->startOfDay(), false),
            7
        );

        // Ahora sí borrar
        DB::table('menu')->where('idmenu', $idmenu)->delete();

        // Redirigir a la semana correcta
        return redirect("menu?week={$offset}")
            ->with('alert1', "Menú eliminado satisfactoriamente para la fecha {$fechaFormateada}")
            ->with('fecha_destacada', $fechaMenu->format('Y-m-d'));
    }

    // Si no existe
    return redirect()->route('menu')->with('alert1', 'El menú ya no existe o fue eliminado anteriormente.');
}

    
     public function cambiarestado(Request $request)
    {
        //
        $estado=$request->input('estado');
        if($estado=='1')
        {
            DB::table('mantenimiento')->where('id_mantenimiento','1')
            ->update(
                [
                'estado_mantenimiento'=>'0'        
                    ]
                );
                $estado = DB::table('mantenimiento')->value('estado_mantenimiento');
            return redirect()->route('menu')->with('alert1', 'Mantenimieto Desactivado Satisfactoriamente!');
            
        }
        
        else{
        
        DB::table('mantenimiento')->where('id_mantenimiento','1')
            ->update(
                [
                'estado_mantenimiento'=>'1'        
                    ]
                );
                
        $estado = DB::table('mantenimiento')->value('estado_mantenimiento');
        
        return redirect()->route('menu')->with('alert1', 'Mantenimieto Activado Satisfactoriamente!');
        }
    
    }


    public function recuperar_clave(Request $request)
{
    $request->validate([
        'dni' => 'required',
        'email' => 'required|email'
    ]);

    $usuario = DB::table('users')
        ->where('dni', $request->dni)
        ->where('email', $request->email)
        ->first();

    if (!$usuario) {
        return redirect()->back()->with('error', 'No se encontró un usuario con esos datos. Comuniquese con el administrador');
    }

    $nueva_clave = 'Temporal2025'; // Puedes cambiarla por otra fija o incluso aleatoria

    DB::table('users')
        ->where('id', $usuario->id)
        ->update(['password' => bcrypt($nueva_clave)]);
    DB::table('padre')
    ->where('idpadre', $request->dni)
        ->update(['clave' => $nueva_clave]);
    return redirect()->back()->with('nueva_clave', $nueva_clave);
}




public function editarPrandium(Request $request)
{
    // Obtener ID del plato
    $idPlato = DB::table('menu')
        ->where('idmenu', $request->id_menu)
        ->value('plato_idplato');

    // Actualizar `plato`
    DB::table('plato')
        ->where('idplato', $idPlato)
        ->update([
            'descripcion_plato' => $request->descripcion_plato, // entrada + segundo ya está combinado
            'precio_plato' => $request->precio_plato,
        ]);

    // Actualizar `menu`
    DB::table('menu')
        ->where('idmenu', $request->id_menu)
        ->update([
            'fecha_menu' => $request->fecha_menu,
            'cantidad_plato' => $request->cantidad_plato,
            'stock_plato' => $request->cantidad_plato,
        ]);

    return back()->with('alert1', 'Menú prandium actualizado correctamente');
}



public function editarLonchera(Request $request)
{
    // Paso 1: Obtener el ID del plato relacionado al menú
    $idPlato = DB::table('menu')
        ->where('idmenu', $request->id_menu)
        ->value('plato_idplato');

    // Paso 2: Actualizar tabla `plato`
    DB::table('plato')
        ->where('idplato', $idPlato)
        ->update([
            'nombre_plato' => $request->nombre_plato,
            'descripcion_plato' => $request->descripcion_plato,
            'precio_plato' => $request->precio_plato,
        ]);

    // Paso 3: Actualizar tabla `menu`
    DB::table('menu')
        ->where('idmenu', $request->id_menu)
        ->update([
            'fecha_menu' => $request->fecha_menu,
            'cantidad_plato' => $request->cantidad_plato,
            'stock_plato' => $request->cantidad_plato,
        ]);

    return back()->with('alert1', 'Lonchera actualizada correctamente');
}

public function ticket_grupo(Request $request)
{
    $fecha = $request->fecha;
    $idAlumno = $request->alumno;
    $recreo = $request->recreo;
    $precio_total=$request->precio_total;

    // Obtener todos los pedidos agrupados
    $pedidos = DB::table('pedido')
        ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
        ->join('padre', 'alumno.padre_idpadre', '=', 'padre.idpadre')
        ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
        ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
        ->select(
            'padre.tipo_usuario',
            'padre.nombre_padre',
            'padre.apellido_padre',
            'alumno.nombre_alumno',
            'alumno.apellido_alumno',
            'alumno.nivel_alumno',
            'alumno.grado_alumno',
            'alumno.seccion_alumno',
            'plato.nombre_plato',
            'plato.descripcion_plato',
            'plato.precio_plato',
            'pedido.Recreo',
            'pedido.fecha_pedido'
        )
        ->where('pedido.fecha_pedido', $fecha)
        ->where('pedido.alumno_idalumno', $idAlumno)
        ->where('pedido.Recreo', $recreo)
        ->get();

    // Enviar todos los pedidos al PDF
    $data = [
        'pedidos' => $pedidos,
        'precio_total'=>$precio_total,
    ];

    // Cargar vista PDF
    $pdf = PDF::loadView('Admin.ticket', $data);
    $pdf->setPaper([0, 0, 74, 105]); // Tamaño A7

    return $pdf->stream('ticket.pdf');
}

public function buscar_cliente(Request $request)
{
    $term = $request->get('q');

    $clientes = DB::table('padre')
        ->where(function($query) use ($term) {
            $query->where('nombre_padre', 'like', '%' . $term . '%')
                  ->orWhere('apellido_padre', 'like', '%' . $term . '%');
        })
        ->limit(20)
        ->get();

    $formatted = $clientes->map(function ($cliente) {
        return [
            'id' => $cliente->idpadre,
            'text' => $cliente->nombre_padre . ' ' . $cliente->apellido_padre
        ];
    });

    return response()->json($formatted);
}




}
