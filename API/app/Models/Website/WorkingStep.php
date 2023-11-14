<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];
}
