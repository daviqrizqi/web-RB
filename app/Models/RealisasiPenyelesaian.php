<?php

namespace App\Models;

use App\Models\RencanaAksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RealisasiPenyelesaian extends Model
{
   use HasFactory;

   protected $casts = [
      'id' => 'string'
   ];

   public $incrementing = false;

   protected $keyTipe = 'string';
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
      'presentase',
      'type'
   ];

   public function FileAsset()
   {
      return $this->hasOne(FileAsset::class, 'rencana_aksi_id', 'rencana_aksi_id');
   }

   public function RencanaAksi()
   {
      return $this->belongsTo(RencanaAksi::class, 'rencana_aksi_id', 'id');
   }
}
