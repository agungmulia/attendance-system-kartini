<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sesi;

class SesiController extends Controller
{
    public function index()
    {
        $Sesi = Sesi::all();

        if(count($Sesi)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Sesi
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
}