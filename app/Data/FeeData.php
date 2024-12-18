<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class FeeData extends Data
{
    public string $amount;

    public string $due_date;
}
