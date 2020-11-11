<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditoriaRequest;
use App\Models\Auditoria;
use DataTables;
use Illuminate\Http\Request;
use Response;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Auditoria::all();

        return Datatables::of($data)

                ->addColumn('fecha', function($row){

                    return strtoupper(date('d/m/Y', strtotime($row->fecha)));
                })

                ->rawColumns(['fecha'])

                ->addColumn('local', function($row){

                    return $row->sede->nombre;
                })

                ->rawColumns(['local'])

                ->addColumn('turno', function($row){

                    return $row->turno == 1 ? 'Mañana' : 'Tarde';
                })

                ->rawColumns(['turno'])

                ->addColumn('sector', function($row){

                    return $row->sector->nombre;
                })

                ->rawColumns(['sector'])

                ->addColumn('responsable', function($row){

                    return $row->responsable->name;
                })

                ->rawColumns(['responsable'])

                ->addColumn('comentario', function($row){

                    return $row->comentario;
                })

                ->rawColumns(['comentario'])

                ->make(true);
    }

    public function store(AuditoriaRequest $request)
    {
        $auditoria = new Auditoria;
        $auditoria->sede_id = $request->sede;
        $auditoria->fecha = $request->fecha;
        $auditoria->turno = $request->turno;
        $auditoria->sector_id = $request->sector;
        $auditoria->responsable_id = auth()->id();
        $auditoria->comentario= $request->comentario;
        $auditoria->save();

        return Response::json(null, 201);
    }
}
