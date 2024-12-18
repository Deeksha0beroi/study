<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'position',
    ];

    protected $cast = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'position' => 'string',
    ];
}
