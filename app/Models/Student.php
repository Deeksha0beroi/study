<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
        'subject_id',
        'fee_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'subject_id' => 'integer',
        'fee_id' => 'integer',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relations
     |--------------------------------------------------------------------------
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function fees(): HasOne
    {
        return $this->hasOne(Fee::class);
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
