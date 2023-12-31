<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use App\Models\Sistema;
use Illuminate\Http\Request;

/**
 * Class SistemaController
 * @package App\Http\Controllers
 */
class SistemaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sistemas.index')->only('index');
        $this->middleware('can:sistemas.create')->only('create', 'store');
        $this->middleware('can:sistemas.show')->only('show');
        $this->middleware('can:sistemas.edit')->only('edit', 'update');
        $this->middleware('can:sistemas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sistemas = Sistema::paginate(1000);

        return view('sistema.index', compact('sistemas'))
            ->with('i', (request()->input('page', 1) - 1) * $sistemas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sistema = new Sistema();
        return view('sistema.create', compact('sistema'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Sistema::$rules);

        $sistema = Sistema::create($request->all());

        return redirect()->route('sistemas.index')
            ->with('success', '<div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                    Sistema creado exitosamente.
                                </div>');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $cod_sis
     * @return \Illuminate\Http\Response
     */
    public function show($cod_sis)
    {
        $sistema = Sistema::find($cod_sis);

        return view('sistema.show', compact('sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $cod_sis
     * @return \Illuminate\Http\Response
     */
    public function edit($cod_sis)
    {
        $sistema = Sistema::find($cod_sis);

        return view('sistema.edit', compact('sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Sistema $sistema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sistema $sistema)
    {
        // Validar los campos del formulario, excepto 'cod_sis'
        $request->validate(Arr::except(sistema::$rules, 'cod_sis'));
    
        // Verificar si el valor de 'cod_sis' ha cambiado
        if ($request->input('cod_sis') !== $sistema->cod_sis) {
            // Validar 'cod_sis' como único en la tabla 'sistemas'
            $request->validate([
                'cod_sis' => 'required|unique:sistemas,cod_sis',
            ]);
        }
    
        // Actualizar los atributos del modelo sistema
        $sistema->update($request->all());
    
        return redirect()->route('sistemas.index')
            ->with('success', '<div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                    Sistema actualizado exitosamente.
                                </div>');
    }

    /**
     * @param string $cod_sis
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($cod_sis)
    {
        try {
            // Intenta eliminar el registro del camión
            $sistema = Sistema::find($cod_sis);
            if (!$sistema) {
                return redirect()->route('sistemas.index')
                    ->with('error', '<div class="alert alert-danger alert-dismissible">
                                      <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
                                      El sistema no existe.
                                    </div>');
            }
    
            $sistema->delete();
    
            return redirect()->route('sistemas.index')
                ->with('success', '<div class="alert alert-success alert-dismissible">
                                      <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                      Sistema eliminado exitosamente.
                                    </div>');
        } catch (\PDOException $e) {
            $errorMessage = '';
            if ($e->getCode() == "23000" && strpos($e->getMessage(), "Cannot delete or update a parent row") !== false) {
                $errorMessage = 'Estás tratando de realizar una acción que viola las restricciones de integridad referencial.';
            } else {
                $errorMessage = 'Ha ocurrido un error al intentar eliminar el sistema: ' . $e->getMessage();
            }
    
            return redirect()->route('sistemas.index')
                ->with('error', '<div class="alert alert-danger alert-dismissible">
                                  <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
                                  ' . $errorMessage . '
                                </div>');
        }
    }
}
