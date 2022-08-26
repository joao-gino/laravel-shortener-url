<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenerUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'alias',
        'clicks',
    ];
}
