<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Repositories\FeeRepository;
use Illuminate\Support\Facades\Redirect;

class FeeController extends Controller
{
    public function __construct(private FeeRepository $feesRepository) {}

    public function index()
    {
        return view('fees.index');
    }

    public function create()
    {
        return view('fees.create');
    }

    public function store(StoreFeeRequest $request)
    {
        $this->feesRepository->storeFee($request->validated());

        return Redirect::route('fees.index');
    }

    public function update(UpdateFeeRequest $request, int $id)
    {
        $this->feesRepository->updateFee($request->validated(), $this->feesRepository->getFeeById($id));

        return Redirect::route('fees.index');
    }
}
