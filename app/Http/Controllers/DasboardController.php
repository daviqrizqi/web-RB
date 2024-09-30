<?php

namespace App\Http\Controllers;

use App\Models\RencanaAksi;
use App\Models\Permasalahan;
use Illuminate\Http\Request;
use App\Models\TargetAnggaran;
use App\Models\RealisasiAnggaran;
use App\Models\TargetPenyelesaian;
use App\Models\RealisasiPenyelesaian;

class DasboardController extends Controller
{
    public function getCount(Request $request)
    {

        $countPermasalahan = $this->getCountPermasalahan($request);
        $countRenaksi = $this->getCountRenaksi($request);
        $countPenyelesaian = $this->getCountPenyelesaian($request);
        $countAnggaran = $this->getCountAnggaran($request);
        $data = [
            'permasalahan' => $countPermasalahan,
            'renaksi' => $countRenaksi,
            'penyelesaian' => $countPenyelesaian,
            'anggaran' => $countAnggaran
        ];

        return response()->json(['message' =>  'berhasil', 'data' => $data], 200);
    }
    protected function getCountPermasalahan($request)
    {
        $count  = Permasalahan::query();
        if ($request->years) {

            $count->whereYear('created_at', $request->years);
        }

        if ($request->dateAwal && $request->dateAkhir) {
            $count->where('created_at', '>=', $request->dateAwal)->where('created_at', '<=', $request->dateAkhir);
        }
        $data = $count->count();
        return $data;
    }

    protected function getCountRenaksi($request)
    {
        $count  = RencanaAksi::query();
        if ($request->years) {

            $count->whereYear('created_at', $request->years);
        }

        if ($request->dateAwal && $request->dateAkhir) {
            $count->where('created_at', '>=', $request->dateAwal)->where('created_at', '<=', $request->dateAkhir);
        }
        $data = $count->count();
        return $data;
    }
    protected function getCountPenyelesaian($request)
    {
        $count  = TargetPenyelesaian::query();
        if ($request->years) {

            $count->whereYear('created_at', $request->years);
        }

        if ($request->dateAwal && $request->dateAkhir) {
            $count->where('created_at', '>=', $request->dateAwal)->where('created_at', '<=', $request->dateAkhir);
        }
        $data = $count->count();
        return $data;
    }


    protected function getCountAnggaran($request)
    {
        $count  = TargetAnggaran::query();
        if ($request->years) {

            $count->whereYear('created_at', $request->years);
        }

        if ($request->dateAwal && $request->dateAkhir) {
            $count->where('created_at', '>=', $request->dateAwal)->where('created_at', '<=', $request->dateAkhir);
        }
        $data = $count->count();
        return $data;
    }

    public function getRataCapaianPermasalahan(Request $request)
    {
        $permasalahanQuery = Permasalahan::with(['renaksi.realisasiPenyelesaian'])->where('erb_type_id', $request->id);

        // Filter berdasarkan tahun
        if ($request->years) {
            $permasalahanQuery->whereYear('created_at', $request->years);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->dateAwal && $request->dateAkhir) {
            $permasalahanQuery->whereBetween('created_at', [$request->dateAwal, $request->dateAkhir]);
        }

        // Ambil semua permasalahan
        $permasalahanList = $permasalahanQuery->orderBy('created_at', 'asc')->get();

        // Inisialisasi array untuk menyimpan hasil
        $result = [];

        // Iterasi setiap permasalahan
        foreach ($permasalahanList as $permasalahan) {
            // Hitung rata-rata capaian dari realisasi penyelesaian terkait rencana aksi
            $rataRata = RealisasiPenyelesaian::whereHas('rencanaAksi', function ($query) use ($permasalahan) {
                $query->where('permasalahan_id', $permasalahan->id);
            })
                ->whereNotNull('presentase') // Abaikan data yang null
                ->avg('presentase');

            // Tambahkan permasalahan dan rata-rata capaian ke array hasil
            $result[] = [
                'permasalahan_id' => $permasalahan->id,
                'permasalahan' => $permasalahan->unique_namespace, // Sesuaikan dengan kolom yang Anda inginkan
                'rata_rata_capaian' => $rataRata,
            ];
        }

        // Return hasil dalam bentuk array JSON
        return response()->json([
            'message' => 'berhasil',
            'data' => $result,
        ]);
    }

    public function getRataCapaianAnggaran(Request $request)
    {
        $permasalahanQuery = Permasalahan::with(['renaksi.realisasiAnggaran'])->where('erb_type_id', $request->id);

        // Filter berdasarkan tahun
        if ($request->years) {
            $permasalahanQuery->whereYear('created_at', $request->years);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->dateAwal && $request->dateAkhir) {
            $permasalahanQuery->whereBetween('created_at', [$request->dateAwal, $request->dateAkhir]);
        }

        // Ambil semua permasalahan
        $permasalahanList = $permasalahanQuery->orderBy('created_at', 'asc')->get();

        // Inisialisasi array untuk menyimpan hasil
        $result = [];

        // Iterasi setiap permasalahan
        foreach ($permasalahanList as $permasalahan) {
            // Hitung rata-rata capaian dari realisasi penyelesaian terkait rencana aksi
            $rataRata = RealisasiAnggaran::whereHas('rencanaAksi', function ($query) use ($permasalahan) {
                $query->where('permasalahan_id', $permasalahan->id);
            })
                ->whereNotNull('presentase') // Abaikan data yang null
                ->avg('presentase');

            // Tambahkan permasalahan dan rata-rata capaian ke array hasil
            $result[] = [
                'permasalahan_id' => $permasalahan->id,
                'permasalahan' => $permasalahan->unique_namespace, // Sesuaikan dengan kolom yang Anda inginkan
                'rata_rata_capaian' => $rataRata,
            ];
        }

        // Return hasil dalam bentuk array JSON
        return response()->json([
            'message' => 'berhasil',
            'data' => $result,
        ]);
    }

    public function getRenaksiPenyelesaian(Request $request)
    {
        //mengambil capaian
        $rencanaAksiQuery = RencanaAksi::with(['realisasiPenyelesaian'])->where('permasalahan_id', $request->id);

        // Filter berdasarkan tahun
        if ($request->years) {
            $rencanaAksiQuery->whereYear('created_at', $request->years);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->dateAwal && $request->dateAkhir) {
            $rencanaAksiQuery->whereBetween('created_at', [$request->dateAwal, $request->dateAkhir]);
        }

        // Ambil semua permasalahan
        $rencanaAksiList = $rencanaAksiQuery->orderBy('created_at', 'asc')->get();
        $data = [];
        foreach ($rencanaAksiList as $item) {
            $data[] = [
                'renaksi' =>  $item->unique_namespace ?? null,
                'capaian' =>  $item->realisasiPenyelesaian->presentase ?? null,
            ];
        }
        // Return hasil dalam bentuk array JSON
        return response()->json([
            'message' => 'berhasil',
            'data' => $data,
        ]);
    }

    public function getRenaksiAnggaran(Request $request)
    {
        $rencanaAksiQuery = RencanaAksi::with(['realisasiAnggaran'])->where('permasalahan_id', $request->id);

        // Filter berdasarkan tahun
        if ($request->years) {
            $rencanaAksiQuery->whereYear('created_at', $request->years);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->dateAwal && $request->dateAkhir) {
            $rencanaAksiQuery->whereBetween('created_at', [$request->dateAwal, $request->dateAkhir]);
        }

        // Ambil semua permasalahan
        $rencanaAksiList = $rencanaAksiQuery->orderBy('created_at', 'asc')->get();

        $data = [];
        foreach ($rencanaAksiList as $item) {
            $data[] = [
                'renaksi' =>  $item->unique_namespace ?? null,
                'capaian' =>  $item->realisasiAnggaran->presentase ?? null,
            ];
        }
        // Return hasil dalam bentuk array JSON
        return response()->json([
            'message' => 'berhasil',
            'data' => $data,
        ]);
    }

    public function getTWpenyelesaian(Request $request)
    {
        $target = TargetPenyelesaian::where('rencana_aksi_id', $request->id)->first();
        $realisasi =  RealisasiPenyelesaian::where('rencana_aksi_id', $request->id)->first();
        $data = [
            [
                'triwulan' => 'TW1',
                'target' =>  $target->twI ?? null,
                'capaian' =>  $realisasi->twI ?? null
            ],
            [
                'triwulan' => 'TW2',
                'target' =>  $target->twII ?? null,
                'capaian' =>  $realisasi->twII ?? null
            ],
            [
                'triwulan' => 'TW3',
                'target' =>  $target->twIII ?? null,
                'capaian' =>  $realisasi->twIII ?? null
            ],
            [
                'triwulan' => 'TW4',
                'target' =>  $target->twIV ?? null,
                'capaian' =>  $realisasi->twIV ?? null
            ],
        ];

        return response()->json([
            'message' => 'berhasil',
            'data' => $data,
        ]);
    }
    public function getTWAnggaran(Request $request)
    {
        $target = TargetAnggaran::where('rencana_aksi_id', $request->id)->first();
        $realisasi =  RealisasiAnggaran::where('rencana_aksi_id', $request->id)->first();
        $data = [
            [
                'triwulan' => 'TW1',
                'target' =>  $target->tw1 ?? null,
                'capaian' =>  $realisasi->tw1 ?? null
            ],
            [
                'triwulan' => 'TW2',
                'target' =>  $target->tw2 ?? null,
                'capaian' =>  $realisasi->tw2 ?? null
            ],
            [
                'triwulan' => 'TW3',
                'target' =>  $target->tw3 ?? null,
                'capaian' =>  $realisasi->tw3 ?? null
            ],
            [
                'triwulan' => 'TW4',
                'target' =>  $target->tw4 ?? null,
                'capaian' =>  $realisasi->tw4 ?? null
            ],
        ];

        return response()->json([
            'message' => 'berhasil',
            'data' => $data,
        ]);
    }
}