<?php

namespace App\Http\Controllers;

use App\DataTables\StafDataTable;
use App\Helpers\imageHelper;
use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StafController extends Controller
{
    public function index(StafDataTable $dataTable)
    {
        return $dataTable->render('dashboard.staf.index', [
            'title' => 'Staf Management',
        ]);
    }

    public function create()
    {
        return view('dashboard.staf.form-action', [
            'title' => 'Tambah Staf',
            'staf'  => new Staf,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'      => 'required',
            'jabatan'   => 'required',
            'kelamin'    => 'required',
            'telepon'   => 'required|unique:stafs,telepon',
            'foto'      => 'image|mimes:jpg,jpeg,png,bmp,webp|max:2048',
        ], [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'max'      => ':attribute maksimal :max karakter.',
            'date'     => ':attribute harus berupa tanggal yang valid.',
            'unique'   => ':attribute sudah digunakan.',
            'file'     => ':attribute harus berupa file.',
            'mimes'    => ':attribute harus berupa file dengan format: :values.',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 10 MB.',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = imageHelper::cropStafFoto($request->file('foto'), 'staf');
        }

        $staf = Staf::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Tambah Staf Berhasil.',
            'staf' => $staf,
        ]);
    }

    public function show(Staf $staf)
    {
        //
    }

    public function edit(Staf $staf)
    {
        return view('dashboard.staf.form-action', [
            'title' => 'Update Staf',
            'staf'  => $staf,
        ]);
    }

    public function update(Request $request, Staf $staf)
    {
        $rules = [
            'nama' => 'required',
            'jabatan'   => 'required',
            'kelamin'    => 'required',
            'foto'      => 'image|mimes:jpg,jpeg,png,bmp,webp|max:2048',
        ];

        if ($request->telepon !== $staf->telepon) {
            $rules['telepon'] = 'required|unique:stafs,telepon,' . $staf->id;
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto')) {
            if ($request->oldFoto) {
                Storage::delete($request->oldfoto);
            }
            $validatedData['foto'] = imageHelper::cropUserFoto($request->file('foto'), 'staf');
        }

        Staf::where('id', $staf->id)->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Update Data Staf ' . $staf->name . ' Successfully.',
        ]);
    }

    public function destroy(Staf $staf)
    {
        if ($staf->foto) {
            Storage::disk('public')->delete($staf->foto);
        }

        $staf->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Delete Staf Successfully.',
        ]);
    }
}
