<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use App\Models\Almacene;
use Illuminate\Http\Request;
use App\Models\Componente;

/**
 * Class AlmaceneController
 * @package App\Http\Controllers
 */
class AlmaceneController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:almacenes.index')->only('index');
        $this->middleware('can:almacenes.create')->only('create', 'store');
        $this->middleware('can:almacenes.show')->only('show');
        $this->middleware('can:almacenes.edit')->only('edit', 'update');
        $this->middleware('can:almacenes.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Almacene::paginate(1000);

        return view('almacene.index', compact('almacenes'))
            ->with('i', (request()->input('page', 1) - 1) * $almacenes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacene = new Almacene();
        $componentesDisponibles = Componente::pluck('nom_com', 'num_ser_com');
        // Obtener los componentes ya registrados en el almacén
        $componentesRegistrados = $almacene->pluck('com_alm');
    
        // Combinar los componentes disponibles con los registrados para asegurarse de mostrar el componente actualmente seleccionado (si está registrado)
        $componentesFiltrados = $componentesDisponibles->except($componentesRegistrados);
    
        return view('almacene.create', compact('almacene', 'componentesFiltrados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Almacene::$rules);

        $almacene = Almacene::create($request->all());

        return redirect()->route('almacenes.index')
            ->with('success', '<div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                    Almacen creado exitosamente.
                                </div>');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $cod_alm
     * @return \Illuminate\Http\Response
     */
    public function show($cod_alm)
    {
        $almacene = Almacene::find($cod_alm);

        return view('almacene.show', compact('almacene'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $cod_alm
     * @return \Illuminate\Http\Response
     */
    public function edit($cod_alm)
    {
        $almacene = Almacene::find($cod_alm);
        $componentesFiltrados = Componente::where('num_ser_com', $almacene->com_alm)->first(); // Obtén el componente asociado
        
        return view('almacene.edit', compact('almacene', 'componentesFiltrados'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Almacene $almacene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacene $almacene)
    {
               // Validar los campos del formulario, excepto 'cod_alm'
               $request->validate(Arr::except(Almacene::$rules, 'cod_alm'));
    
               // Verificar si el valor de 'cod_alm' ha cambiado
               if ($request->input('cod_alm') !== $almacene->cod_alm) {
                   // Validar 'cod_alm' como único en la tabla 'camiones'
                   $request->validate([
                       'cod_alm' => 'required|unique:camiones,cod_alm',
                   ]);
               }

        $almacene->update($request->all());

        return redirect()->route('almacenes.index')
            ->with('success', '<div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                    Almacen actualizado exitosamente.
                                </div>');
    }

    /**
     * @param string $cod_alm
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
    */
    public function destroy($cod_alm)
    {
        try {
            // Intenta eliminar el registro del camión
            $almacene = Almacene::find($cod_alm);
            if (!$almacene) {
                return redirect()->route('almacenes.index')
                    ->with('error', '<div class="alert alert-danger alert-dismissible">
                                      <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
                                      El almacén no existe.
                                    </div>');
            }
    
            $almacene->delete();
    
            return redirect()->route('almacenes.index')
                ->with('success', '<div class="alert alert-success alert-dismissible">
                                      <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                      Almacén eliminado exitosamente.
                                    </div>');
        } catch (\PDOException $e) {
            $errorMessage = '';
            if ($e->getCode() == "23000" && strpos($e->getMessage(), "Cannot delete or update a parent row") !== false) {
                $errorMessage = 'Estás tratando de realizar una acción que viola las restricciones de integridad referencial.';
            } else {
                $errorMessage = 'Ha ocurrido un error al intentar eliminar el almacén: ' . $e->getMessage();
            }
    
            return redirect()->route('almacenes.index')
                ->with('error', '<div class="alert alert-danger alert-dismissible">
                                  <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
                                  ' . $errorMessage . '
                                </div>');
        }
    }
}