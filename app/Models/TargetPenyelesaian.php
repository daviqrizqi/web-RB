<?php

namespace App\Models;

use App\Models\RencanaAksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetPenyelesaian extends Model
{
    use HasFactory;

    protected $table = "target_penyelesaians";

    protected $primaryKey = 'id';

    // Pastikan UUID di-cast sebagai string
    protected $casts = [
        'id' => 'string',
    ];

    public $incrementing = false;

    // Set jenis key type
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
        "subjek",
        "type",

    ];

    public function rencanaAksi()
    {
        return $this->belongsTo(RencanaAksi::class);
    }
}