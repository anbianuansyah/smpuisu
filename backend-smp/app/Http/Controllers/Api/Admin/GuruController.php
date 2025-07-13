<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\GuruResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class GuruController extends Controller implements HasMiddleware
{
    /**
     * middleware
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['permission:gurus.index'], only: ['index']),
            new Middleware(['permission:gurus.create'], only: ['store']),
            new Middleware(['permission:gurus.edit'], only: ['update']),
            new Middleware(['permission:gurus.delete'], only: ['destroy']),
        ];
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get gurus
        $gurus = Guru::when(request()->search, function ($gurus) {
            $gurus = $gurus->where('name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $gurus->appends(['search' => request()->search]);

        //return with Api Resource
        return new GuruResource(true, 'List Data Gurus', $gurus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'    => 'required|mimes:jpeg,jpg,png|max:2000',
            'name'     => 'required',
            'role'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('gurus', $image->hashName(), 'public');

        //create guru
        $guru = Guru::create([
            'image'     => $image->hashName(),
            'name'      => $request->name,
            'role'      => $request->role,
        ]);

        if ($guru) {
            //return success with Api Resource
            return new GuruResource(true, 'Data Guru Berhasil Disimpan!', $guru);
        }

        //return failed with Api Resource
        return new GuruResource(false, 'Data Guru Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = Guru::whereId($id)->first();

        if ($guru) {
            //return success with Api Resource
            return new GuruResource(true, 'Detail Data Guru!', $guru);
        }

        //return failed with Api Resource
        return new GuruResource(false, 'Detail Data Guru Tidak Ditemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guru $guru)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'role'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('public')->delete('gurus/' . basename($guru->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('gurus', $image->hashName(), 'public');

            //update guru with new image
            $guru->update([
                'image' => $image->hashName(),
                'name'  => $request->name,
                'role'  => $request->role,
            ]);
        }

        //update guru without image
        $guru->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        if ($guru) {
            //return success with Api Resource
            return new GuruResource(true, 'Data Guru Berhasil Diupdate!', $guru);
        }

        //return failed with Api Resource
        return new GuruResource(false, 'Data Guru Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guru $guru)
    {
        //remove image
        Storage::disk('public')->delete('gurus/' . basename($guru->image));

        if ($guru->delete()) {
            //return success with Api Resource
            return new GuruResource(true, 'Data Guru Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new GuruResource(false, 'Data Guru Gagal Dihapus!', null);
    }
}