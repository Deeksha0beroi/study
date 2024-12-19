<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class FeeData extends Data
{
    public int $id;

    public string $amount;

    public string $due_date;
}
