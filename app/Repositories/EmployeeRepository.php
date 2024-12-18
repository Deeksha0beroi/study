<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository
{
    public function getAllEmployees(array $relations = []): Collection
    {
        return Employee::with($relations)->get();
    }

    public function getEmployeeById(int $id, array $relations = []): Employee
    {
        return Employee::with($relations)->findOrFail($id);
    }

    public function storeEmployee(array $request)
    {
        $employee = new Employee;
        $employee->fill($request);
        $employee->save();

        return $employee;
    }

    public function updateEmployee(array $request, Employee $employee)
    {
        $employee->fill($request);
        $employee->update();

        return $employee;
    }

    public function deleteEmployee(Employee $employee): bool
    {
        return $employee->delete();
    }
}
