<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class SliderController extends Controller implements HasMiddleware
{
    /**
     * middleware
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['permission:sliders.index'], only: ['index']),
            new Middleware(['permission:sliders.create'], only: ['store']),
            new Middleware(['permission:sliders.delete'], only: ['destroy']),
        ];
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get data sliders
        $sliders = Slider::latest()->paginate(5);

        //return with Api Resource
        return new SliderResource(true, 'List Data Sliders', $sliders);
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('sliders', $image->hashName(), 'public');

        $slider = Slider::create([
            'image' => $image->hashName(),
        ]);

        if ($slider) {
            //return success with Api Resource
            return new SliderResource(true, 'Data Slider Berhasil Disimpan!', $slider);
        }

        //return failed with Api Resource
        return new SliderResource(false, 'Data Slider Gagal Disimpan!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //remove image
        Storage::disk('public')->delete('sliders/' . basename($slider->image));

        if ($slider->delete()) {
            //return success with Api Resource
            return new SliderResource(true, 'Data Slider Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new SliderResource(false, 'Data Slider Gagal Dihapus!', null);
    }
}