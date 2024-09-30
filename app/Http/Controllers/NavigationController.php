<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function LoginView(Request $request){
        return view('login');
    }
    public function dashboardView(Request $request){
        return view('page.dasboard');
    }

    public function e_rbSutingView (Request $request){
        return view('page.E_RB.temtatik.sunting.e_rb');
    }

    public function RencanaAksiSutingView (Request $request){
        return view('page.E_RB.temtatik.sunting.rencana-aksi');
    }

    public function TargetPenyelesaianSutingView (Request $request){
        return view('page.E_RB.temtatik.sunting.target_penyelesaian');
    }

    public function TargetAnggaranSutingView (Request $request){
        return view('page.E_RB.temtatik.sunting.target_anggaran');
    }

    public function RealisasiPenyelesaianSuntingView (Request $request){
        return view('page.E_RB.temtatik.sunting.realisasi.realisasi_penyelesaian');
    }
    public function RelisasiAnggaranSuntingView (Request $request){
        return view('page.E_RB.temtatik.sunting.realisasi.realisasi_anggaran');
    }

    

    // Admin Navigation

    public function DasboardAdminView(Request $request){
        return view('admin.dasboard-admin');
    }
    
    public function TemaAdminView(Request $request){
        return view('admin.tema-admin');
    }
    
    public function ClusterAdminView(Request $request){
        return view('admin.cluster-admin');
    }

    public function EvaluatedAdminView(Request $request){
        return view('admin.evaluasi-admin');
    }

    
    public function UserdAdminView(Request $request){
        return view('admin.user-admin');
    }


 

}
