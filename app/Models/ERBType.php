<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ERBType extends Model
{
    use HasFactory;
    protected $table = "erb_types";
    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;

    protected $keyTipe = 'string';
    protected $fillable = [
        'id',
        'nama',
        'type',
        'cluster_id'
    ];
}