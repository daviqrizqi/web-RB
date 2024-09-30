<?php

namespace App\Models;

use App\Models\RealisasiPenyelesaian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileAsset extends Model
{
    use HasFactory;

    protected $table ="file_assets";
    protected $casts = [
        'id' => 'string'
    ];
    protected $ketType = 'string';
    protected $fillable = [
        "id",
        "rencana_aksi_id",
        "file_name",
        "file_path"
    ];

    public function realisasiPenyelesaian () {
        return $this->BelongsTo(RealisasiPenyelesaian::class, 'rencana_aksi_id', 'rencana_aksi_id');
    }
}
