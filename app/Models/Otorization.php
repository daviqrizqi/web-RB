<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otorization extends Model
{
    use HasFactory;

    protected $table = 'otorizations';

    protected $casts = [
        'id' => 'string'
    ];

public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'tema_id',
        'tema',
        'status',
    ];
}
