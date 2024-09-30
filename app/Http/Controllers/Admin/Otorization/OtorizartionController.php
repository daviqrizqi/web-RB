<?php

namespace App\Http\Controllers\Admin\Otorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtorizartionController extends Controller
{
    public function setOtorization (Request $request){
        try {
            
            $request->validate([
                'user_id' => 'required|string',
                'tema_id' =>  'required|string',
                'tema' =>  'required|string',
                'status' => 'required|boolean'
            ]);

            $data = Otorization::create([
                'user_id' => $request->user_id,
                'tema_id' =>  $request->tema_id,
                'tema' =>  $request->tema,
                'status' => $request->status
            ]);

            return back()->with('success', 'Data berhasil disimpan');
        } catch (ValidationException $e) {
            return back()->with('error', 'Inputan username dan password wajib diisi');
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function update (Request $request){
        try{

            $request->validate([
                'tema_id' =>  'required|string',
                'tema' =>  'required|string',
                'status' => 'required|boolean'
            ]);

            $data =  Otorization::where('id',$request->id)->first();
            $data->update([
                'tema_id' =>  $request->tema_id,
                'tema' =>  $request->tema,
                'status' => $request->status
            ]);

            return back()->with('success', 'Data berhasil disimpan');

        }catch (ValidationException $e) {
            return back()->with('error', 'Inputan username dan password wajib diisi');
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function getAll (Request $request){
        try{
            $data = Otorization::all();
            return response()->json(['status' => 'success', 'message' => 'data berhasil', 'data' => $data], 200);
        }catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function getbyUserId (Request $request){
        try{
            $data = Otorization::where('user_id', $request->user_id)->get();

            return response()->json(['status' => 'success', 'message' => 'data berhasil', 'data' => $data], 200);
        }catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete (Request $request){
        try{
            $data = Otorization::where('id', $request->id)->first();
            $data->delete();
            
            return response()->json(['status' => 'success', 'message' => 'data berhasil', 'data' => $data], 200);
        }catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
