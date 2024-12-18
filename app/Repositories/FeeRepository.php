<?php

namespace App\Repositories;

use App\Models\Fee;

class FeeRepository
{
    public function getFeeById(int $id, $relations = []): Fee
    {
        return Fee::with($relations)->findOrFail($id);
    }

    public function storeFee(array $request)
    {
        $fees = new Fee;
        $fees->fill($request);
        $fees->save();

        return $fees;
    }

    public function updateFee(array $request, Fee $fees)
    {
        $fees->fill($request);
        $fees->update();

        return $fees;
    }

    public function deleteFee(Fee $fees): bool
    {
        return $fees->delete();
    }
}
