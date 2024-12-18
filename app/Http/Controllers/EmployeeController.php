<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeRepository $employeesRepository) {}

    public function index()
    {
        return view('employees.index');
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $this->employeesRepository->storeEmployee($request->validated());

        return Redirect::route('employees.index');
    }

    public function update(UpdateEmployeeRequest $request, int $id)
    {
        $this->employeesRepository->updateEmployee($request->validated(), $this->employeesRepository->getEmployeeById($id));

        return Redirect::route('employees.index');
    }
}
