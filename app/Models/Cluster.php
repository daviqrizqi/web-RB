<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $table = "clusters";
    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;

    protected $keyTipe = 'string';
    protected $fillable = [
        'id',
        'cluster',
    ];
}