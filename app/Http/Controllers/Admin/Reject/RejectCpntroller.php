<?php

namespace App\Http\Controllers\Admin\Reject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RejectCpntroller extends Controller
{
    public function setReject(Request $request)
    {
        
        try {
            $request->validate([
                'rencana_aksi_id' => 'required|string',
                'user_id' => 'required|string',
                'comment' => 'required|string',
                'status' => 'required|string'
            ]);

            $data = Reject::create([
                'rencana_aksi_id' => $request->rencana_aksi_id,
                'user_id' => $request->user_id,
                'comment' => $request->comment,
                'status' => $request->status
            ]);

            return back()->with('success', 'Data berhasil disimpan');
        } catch (ValidationException $e) {
            return back()->with('error', 'Inputan wajib diisi');
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'rencana_aksi_id' => 'required|string',
                'user_id' => 'required|string',
                'comment' => 'required|string',
                'status' => 'required|string'
            ]);

            $data = Reject::where('id', $request->id)->first();
            $data->update([
                'rencana_aksi_id' => $request->rencana_aksi_id,
                'user_id' => $request->user_id,
                'comment' => $request->comment,
                'status' => $request->status
            ]);

            return back()->with('success', 'Data berhasil disimpan');
        } catch (ValidationException $e) {
            return back()->with('error', 'Inputan wajib diisi');
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $data = Reject::all();
            return response()->json(['status' => 'success', 'message' => 'data berhasil', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByUserId(Request $request)
    {
        try {
            $data = Reject::where('user_id', $request->user_id)->get();

            return response()->json(['status' => 'success', 'message' => 'data berhasil', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = Reject::where('id', $request->id)->first();
            $data->delete();

            return response()->json(['status' => 'success', 'message' => 'data berhasil', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
