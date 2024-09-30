<?php

namespace App\Models;

use App\Models\RencanaAksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetAnggaran extends Model
{
    use HasFactory;

    protected $table = "target_anggarans";

    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',

    ];
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        "id",
        "rencana_aksi_id",
        "user_id",
        "twI",
        "twII",
        "twIII",
        "twIV",
        "jumlah",
        "koordinator",
        "pelaksana"
    ];

    public function rencanaAksi()
    {
        return $this->belongsTo(RencanaAksi::class);
    }
}