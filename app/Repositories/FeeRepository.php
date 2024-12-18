<?php

namespace App\Repositories;

use App\Data\FeeData;
use App\Models\Fee;

class FeeRepository
{
    public function getFeeById(int $id, $relations = []): Fee
    {
        return Fee::with($relations)->findOrFail($id);
    }

    public function storeFee(FeeData $feeData): Fee
    {
        $fees = new Fee;
        $fees->fill($feeData->toArray());
        $fees->save();

        return $fees;
    }

    public function updateFee(FeeData $feeData, Fee $fees)
    {
        $fees->fill($feeData->toArray());
        $fees->update();

        return $fees;
    }

    public function deleteFee(Fee $fees): bool
    {
        return $fees->delete();
    }
}
