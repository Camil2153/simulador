<?php

namespace App\Http\Controllers;

use App\Models\Conductore;
use Illuminate\Http\Request;

class ConductoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conductores = Conductore::paginate();

        return view('conductore.index', compact('conductores'))
            ->with('i', (request()->input('page', 1) - 1) * $conductores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conductore = new Conductore();
        return view('conductore.create', compact('conductore'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Conductore::$rules);

        $conductore = Conductore::create($request->all());

        return redirect()->route('conductores.index')
            ->with('success', 'Conductore created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $ced_con
     * @return \Illuminate\Http\Response
     */
    public function show($ced_con)
    {
        $conductore = Conductore::where('ced_con', $ced_con)->first();

        if ($conductore) {
            return view('conductore.show', compact('conductore'));
        }

        return redirect()->route('conductores.index')
            ->with('error', 'No se encontró el conductor');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $ced_con
     * @return \Illuminate\Http\Response
     */
    public function edit($ced_con)
    {
        $conductore = Conductore::where('ced_con', $ced_con)->first();

        if ($conductore) {
            return view('conductore.edit', compact('conductore'));
        }

        return redirect()->route('conductores.index')
            ->with('error', 'No se encontró el conductor');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $ced_con
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ced_con)
    {
        request()->validate(Conductore::$rules);

        $conductore = Conductore::where('ced_con', $ced_con)->first();

        if ($conductore) {
            $conductore->update($request->all());
            return redirect()->route('conductores.index')
                ->with('success', 'Conductor actualizado exitosamente');
        }

        return redirect()->route('conductores.index')
            ->with('error', 'No se encontró el conductor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $ced_con
     * @return \Illuminate\Http\Response
     */
    public function destroy($ced_con)
    {
        $conductore = Conductore::where('ced_con', $ced_con)->first();

        if ($conductore) {
            $conductore->delete();
            return redirect()->route('conductores.index')
                ->with('success', 'Conductor eliminado exitosamente');
        }

        return redirect()->route('conductores.index')
            ->with('error', 'No se encontró el conductor');
    }
}