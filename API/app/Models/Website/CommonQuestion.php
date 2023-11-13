<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'answer'
    ];
}
