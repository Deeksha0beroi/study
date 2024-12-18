<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getEmployeeById(int $id, $relations = []): Employee
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
