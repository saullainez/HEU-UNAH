<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\DB;
use View;

use App\Paciente;
use App\Persona;

class Paciente2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->input('NombrePaciente') != null)
        {

            $Pacientes = Paciente::nombre(request()->input('NombrePaciente'))->paginate(15);
            return view('pacientes.home')->with('Pacientes', $Pacientes);
        }
        else
        {


            //Hace el Join de la tabla Pacientes con la tabla Personas
            $Pacientes = Paciente::Join('personas', 'pacientes.idPersona', '=', 'personas.idPersona')
                ->select(['pacientes.idPersona', 'pacientes.idPaciente', 'personas.Persona_Nombre', 'personas.Persona_Apellido', 
                          'pacientes.condicion_llegada', 'pacientes.ubicacion'])->paginate(15);
            
            //Devuelve y renderiza la vista, con el resultado delJoin
            return view('pacientes.home')->with('Pacientes', $Pacientes);
        }
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $personas = DB::table('personas')->get();

        return view('pacientes.formulario',['personas'=>$personas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         //Se instancia el nuevo paciente, según el modelo
        $Paciente = new Paciente;
        //Campos que obtenemos del formulario
        $Paciente->condicion_llegada = request()->input('Condicion_Llegada');
        $Paciente->ubicacion = request()->input('ubicacion');
		
        //Obtenemos el Id que el usuario ingresa(será nuestro Id para buscar a la persona)
        $idPersona = request()->input('idPersona');
		//dd($idPersona);
        //Se instancia la nueva persona, según el resultado obtenido con el idPersona
        $Persona = Persona::find($idPersona);
		//dd($Persona);
		
        //Se crea el paciente
        if ($Persona != null){
			$Persona->paciente()->save($Paciente);
             
             return Redirect::to('/pacientes');
        }
        else{
            return redirect()->route('pacientes.create')->with(['message'=> '¡ID de persona no existe!']);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try{

            $paciente = Paciente::FindOrFail($id);
            if ($paciente){
              $datosPaciente = DB::table('pacientes as pa')
                  ->select('pa.idPaciente', 'pa.idPersona','pa.Condicion_Llegada','pa.ubicacion','pe.Persona_Nombre','pe.Persona_Apellido')
                  ->join('personas as pe', 'pa.idPersona', '=', 'pe.idPersona')
                  ->where('pa.idPaciente', $id)
                  ->get();
               // dd($datosPaciente);
                //return View::make('pacientes.editar')->with('paciente',$paciente);
               // $info = json_decode($datosPaciente);
               //dd($paciente);
               return view('pacientes.editar',['datosPaciente'=>$datosPaciente, 'paciente' => $paciente]);
            }
           
           // dd($paciente);
        }
        catch(exception $ex)
        {
            return 'error';    
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $paciente = Paciente::findOrFail($id);
        $paciente->fill(request()->all());
        //$paciente->condicion_llegada = request()->input('Condicion_Llegada');
        $paciente->ubicacion = request()->input('ubicacion');
        //dd($paciente);
        $paciente->save();
        return Redirect::to('/pacientes');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $paciente = Paciente::findOrFail($id);
        if ($paciente != null){
            $paciente->delete();
            return redirect()->route('pacientes.index');
        }
        else{
            return redirect()->route('personas.index')->with(['message'=> 'Wrong ID!!']);
        }
    }
    
    
    public function home(Request $request)
    {
        /*dd(request()->input('NombrePaciente'));

        if(request()->input('NombrePaciente') != null)
        {


            $Pacientes = Paciente::nombre(request()->input('NombrePaciente'))->paginate(15);
            return view('pacientes.home')->with('Pacientes', $Pacientes);
        }
        else
        {


            //Hace el Join de la tabla Pacientes con la tabla Personas
            $Pacientes = Paciente::Join('personas', 'pacientes.idPersona', '=', 'personas.idPersona')->select(['pacientes.idPersona', 'personas.Persona_Nombre', 'personas.Persona_Apellido', 'pacientes.condicion_llegada', 'pacientes.ubicacion'])->paginate(15);
            //Devuelve y renderiza la vista, con el resultado delJoin
            return view('pacientes.home')->with('Pacientes', $Pacientes);
        }*/
    }

    public function buscar(Request $request) 
    {
        if(request()->input('NombrePaciente') != null)
        {

            $Pacientes = Paciente::nombre(request()->input('NombrePaciente'))->paginate(15);
            return view('pacientes.buscar')->with('Pacientes', $Pacientes);
        }
        else
        {


            //Hace el Join de la tabla Pacientes con la tabla Personas
            $Pacientes = Paciente::Join('personas', 'pacientes.idPersona', '=', 'personas.idPersona')->select(['pacientes.idPersona', 'personas.Persona_Nombre', 'personas.Persona_Apellido', 'pacientes.condicion_llegada', 'pacientes.ubicacion'])->paginate(15);
            //Devuelve y renderiza la vista, con el resultado delJoin
            return view('pacientes.buscar')->with('Pacientes', $Pacientes);
        }
    }
}
