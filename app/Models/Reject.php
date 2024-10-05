<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    use HasFactory;
    protected $table = 'rejects';
    protected $casts = [
        'id' => 'string'
     ];
  
     public $incrementing = false;
  
     protected $keyTipe = 'string';

   

    protected $fillable = [
        'rencana_aksi_id',
        'user_id',
        'comment',
        'status',
    ];

     public function rencanaAksi()
    {
        return $this->belongsTo(RencanaAksi::class);
    }

}
