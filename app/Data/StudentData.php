<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class StudentData extends Data
{
    public string $name;

    public string $email;

    public string $subject_id;

    public string $fee_id;
}
