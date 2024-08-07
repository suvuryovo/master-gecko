<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraitsModel extends Model
{
    use HasFactory;
    protected $table = 'traits';
    protected $fillable = [
        'traits',
        'notes',
    ];
}
