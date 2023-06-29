<?php

namespace App\Http\Controllers;

use App\Models\DocumentosCamione;
use Illuminate\Http\Request;
use App\Models\Camione;

/**
 * Class DocumentosCamioneController
 * @package App\Http\Controllers
 */
class DocumentosCamioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentosCamiones = DocumentosCamione::paginate();

        return view('documentos-camione.index', compact('documentosCamiones'))
            ->with('i', (request()->input('page', 1) - 1) * $documentosCamiones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documentosCamione = new DocumentosCamione();
        $camiones = Camione::pluck('pla_cam');
        return view('documentos-camione.create', compact('documentosCamione', 'camiones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(DocumentosCamione::$rules);

        $documentosCamione = DocumentosCamione::create($request->all());

        return redirect()->route('documentos-camiones.index')
            ->with('success', 'DocumentosCamione created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $cod_doc
     * @return \Illuminate\Http\Response
     */
    public function show($cod_doc)
    {
        $documentosCamione = DocumentosCamione::find($cod_doc);

        return view('documentos-camione.show', compact('documentosCamione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $cod_doc
     * @return \Illuminate\Http\Response
     */
    public function edit($cod_doc)
    {
        $documentosCamione = DocumentosCamione::find($cod_doc);
        $camiones = Camione::pluck('pla_cam');
        return view('documentos-camione.edit', compact('documentosCamione','camiones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  DocumentosCamione $documentosCamione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentosCamione $documentosCamione)
    {
        request()->validate(DocumentosCamione::$rules);

        $documentosCamione->update($request->all());

        return redirect()->route('documentos-camiones.index')
            ->with('success', 'DocumentosCamione updated successfully');
    }

    /**
     * @param string $cod_doc
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($cod_doc)
    {
        $documentosCamione = DocumentosCamione::find($cod_doc)->delete();

        return redirect()->route('documentos-camiones.index')
            ->with('success', 'DocumentosCamione deleted successfully');
    }
}
