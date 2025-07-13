<?php

namespace App\Http\Controllers\Api\Public;

use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuruResource;

class GuruController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $gurus = Guru::oldest()->get();

        //return with Api Resource
        return new GuruResource(true, 'List Data Guru', $gurus);
    }
}