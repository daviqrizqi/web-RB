<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function get()
    {

        $cluster = Cluster::all();

        return response()->json(['data' => $cluster]);
    }
    public function getById(Request $request)
    {
        $cluster = Cluster::where('id', $request->id);

        return response()->json(['data' => $cluster]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'cluster' => 'string|required'
        ]);

        $cluster = Cluster::create([
            'id' => Str::uuid(),
            'cluster' =>  $request->cluster
        ]);

        return response()->json(['message' => 'berhasil disimpan', 'data' =>  $cluster]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'cluster' => 'string|required'
        ]);

        $cluster = Cluster::where('id', $request->id)->update([
            'id' => Str::uuid(),
            'cluster' =>  $request->cluster
        ]);

        return response()->json(['message' => 'berhasil disimpan', 'data' =>  $cluster]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'cluster' => 'string|required'
        ]);

        $cluster = Cluster::where('id', $request->id)->delete();
        return response()->json(['message' => 'berhasil terhapus']);
    }
}