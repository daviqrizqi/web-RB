<?php

namespace App\Models;

use App\Models\RencanaAksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RealisasiAnggaran extends Model
{
    use HasFactory;

    protected $casts =[
        'id' =>  'string'
    ];

    public $incrementing = false;

    protected $keyTipe ='string';

    protected $fillable = [
        'id',
        'rencana_aksi_id',
        'user_id',
        'twI',
        'twII',
        'twIII',
        'twIV',
        'jumlah',
        'capaian',
        'presentase'
    ];

    public function rencanaAksi()
    {
        return $this->belongsTo(RencanaAksi::class);
    }

  

}
