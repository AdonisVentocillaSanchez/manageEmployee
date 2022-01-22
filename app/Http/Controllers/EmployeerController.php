<?php

namespace App\Http\Controllers;

use App\Employeer;
use Illuminate\Http\Request;
use DataTables;

class EmployeerController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Employeer::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->estado == "1") {

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" >Editar</a><br>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Borrar</a><br>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Update" class="btn btn-secondary btn-sm inactiveProduct">Desactivar</a>';

                        return $btn;
                    } else {
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Update" class="btn btn-success btn-sm inactiveProduct">Activar</a>';

                        return $btn;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('employeers');
    }


    public function store(Request $request)
    {
        $request->validate([
            'profile_photo_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->file('profile_photo_path')) {
            $imagePath = $request->file('profile_photo_path');
            $imageName = $imagePath->getClientOriginalName();

            $path = $request->file('profile_photo_path')->storeAs('uploads', $imageName, 'public');
        }
        Employeer::updateOrCreate(
            ['id' => $request->product_id],
            ['nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'email' => $request->email,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'cargo' => $request->cargo,
            'area' => $request->area,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tipo_contacto' => $request->tipo_contacto,
            'estado' => '1',
            'profile_photo_path' => '/storage/'.$path,
            ]
        );

        return response()->json(['success' => 'Empleado guardado exitosamente.']);
    }

    public function edit($id)
    {
        $employeer = Employeer::find($id);
        return response()->json($employeer);
    }

    public function update($id)
    {
        //$employeer = Employeer::find($id);
        //dd($employeer);
        //$employeer = Employeer::find($id)->value('estado');
        $employeer = Employeer::where('id', $id)->value('estado');
        //dd($employeer);
        if ($employeer == "1") {
            Employeer::where('id', $id)->update(array('estado' => '0'));

            return response()->json(['success' => 'Este empleado acaba de ser desactivado']);
        } else {
            Employeer::where('id', $id)->update(array('estado' => '1'));

            return response()->json(['success' => 'Este empleado acaba de ser activado']);
        }
    }


    public function destroy($id)
    {
        Employeer::find($id)->delete();

        return response()->json(['success' => 'Empleado eliminado satisfactoriamente.']);
    }
}
