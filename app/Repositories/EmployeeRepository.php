<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getEmployeeById(int $id, $relations = []): Employee
    {
        return Employee::with($relations)->findOrFail($id);
    }

    public function storeEmployee(EmployeeData $employeesData): Employee
    {
        $employee = new Employee;
        $employee->fill($employeesData);
        $employee->save();

        return $employee;
    }

    public function updateEmployee(EmployeeData $employeesData, Employee $employee)
    {
        $employee->fill($employeesData);
        $employee->update();

        return $employee;
    }

    public function deleteEmployee(Employee $employee): bool
    {
        return $employee->delete();
    }
}
