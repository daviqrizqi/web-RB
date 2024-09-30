<?php

namespace App\Http\Controllers;

use App\Models\ERBType;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    public function getType(Request $request)
    {
        $startTime = microtime(true);
        $data = ERBType::query();
        if ($request && $request->id) {
            $data = $data->where('cluster_id', $request->id)->get();
        }
        $data = $data->all();



        $status = 'berhasil';
        $message = 'data berhasil didapat';

        $endtime = microtime(true);
        $time_access =  $endtime -  $startTime;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'time_access' => $time_access
        ], 200);
    }
    public function getId(Request $request)
    {

        $startTime = microtime(true);
        $data = ERBType::where('cluster_id', $request->id)->orWhere('id', $request->id)->get();




        $status = 'berhasil';
        $message = 'data berhasil didapat';

        $endtime = microtime(true);
        $time_access =  $endtime -  $startTime;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'time_access' => $time_access
        ], 200);
    }

    public function create(Request $request) {}

    public function update(Request $request) {}

    public function delete(Request $request) {}
}