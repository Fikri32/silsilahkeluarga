<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Keluarga;
use Datatables;
class KeluargaController extends Controller
{
    public function index()
    {
        $parent = Keluarga::all();
        return view('welcome',compact('parent'));
    }

    public function data()
    {
        $data = Keluarga::all();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('p_name', function ($data) {
                    if($data->parent != null)
                    {
                        return $data->parent->nama;
                    }

                    // dd($data->parent->nama);
                })
                ->addColumn('action',function($row){
                    $aksi = '
                        <a href="javascript:void(0)" data-id="'.$row->id.'" title="Edit" id="editdata" class="edit btn btn-primary btn-sm">Edit</a>
                        <a href="javascript:void(0)" data-id="'.$row->id.'"  title="Delete" class="hapus btn btn-danger btn-sm">Hapus</a>
                    ';

                    return $aksi;
                })

                ->rawColumns(['action'])
                ->make(true);
    }

    public function store(Request $request)
    {
        $input = Keluarga::create($request->all());
        return response()->json([
            'fail' => 'true',
        ],200);
    }

    public function edit($id)
    {
        $data = Keluarga::find($id);
        return $data;
    }

    public function update($id,Request $request)
    {
        $data = $request->except('_method','_token');
        $update = Keluarga::where('id',$id)->update($data);
        return response()->json([
            'fail'=>true,
        ],200);
    }

    public function delete($id)
    {
        $delete  = Keluarga::destroy($id);
        return $delete;

    }
}
