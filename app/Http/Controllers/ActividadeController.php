<?php

namespace App\Http\Controllers;

use App\Models\Actividade;
use Illuminate\Http\Request;
use App\Models\Sistema;


/**
 * Class ActividadeController
 * @package App\Http\Controllers
 */
class ActividadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades = Actividade::paginate();

        return view('actividade.index', compact('actividades'))
            ->with('i', (request()->input('page', 1) - 1) * $actividades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actividade = new Actividade();
        $sistemas = Sistema::pluck('nom_sis', 'cod_sis');
        return view('actividade.create', compact('actividade', 'sistemas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Actividade::$rules);

        $actividade = Actividade::create($request->all());

        return redirect()->route('actividades.index')
            ->with('success', 'Actividade created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $cod_act
     * @return \Illuminate\Http\Response
     */
    public function show($cod_act)
    {
        $actividade = Actividade::find($cod_act);

        return view('actividade.show', compact('actividade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $cod_act
     * @return \Illuminate\Http\Response
     */
    public function edit($cod_act)
    {
        $actividade = Actividade::find($cod_act);
        $sistemas = Sistema::pluck('nom_sis', 'cod_sis');
        return view('actividade.edit', compact('actividade', 'sistemas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Actividade $actividade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actividade $actividade)
    {
        request()->validate(Actividade::$rules);

        $actividade->update($request->all());

        return redirect()->route('actividades.index')
            ->with('success', 'Actividade updated successfully');
    }

    /**
     * @param int $cod_act
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($cod_act)
    {
        $actividade = Actividade::find($cod_act)->delete();

        return redirect()->route('actividades.index')
            ->with('success', 'Actividade deleted successfully');
    }
}