<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa');
    }

    public function getData()
    {
        return response()->json(Mahasiswa::all());
    }

    public function store(Request $request)
    {
        Mahasiswa::create($request->all());
        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        return response()->json(Mahasiswa::find($id));
    }

    public function update(Request $request, $id)
    {
        Mahasiswa::find($id)->update($request->all());
        return response()->json(['status' => 'updated']);
    }

    public function destroy($id)
    {
        Mahasiswa::destroy($id);
        return response()->json(['status' => 'deleted']);
    }
}
