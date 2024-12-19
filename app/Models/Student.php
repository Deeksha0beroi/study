<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relations
     |--------------------------------------------------------------------------
     */

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'students_subjects')
            ->withPivot('student_id', 'subject_id')
            ->withTimestamps();
    }

    /*
     |--------------------------------------------------------------------------
     | Factory
     |--------------------------------------------------------------------------
     */
    protected static function newFactory(): Factory
    {
        return StudentFactory::new();
    }
}
