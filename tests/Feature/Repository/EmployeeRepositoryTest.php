<?php

namespace Tests\Feature\Repositories;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $tenancy = true;

    private EmployeeRepository $employee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employee = app(EmployeeRepository::class);
    }

    public function test_get_employee_by_id(): void
    {
        $employee = Employee::factory()->create();

        $this->assertEquals(Employee::class, get_class($this->employee->getEmployeeById($employee->id)));
    }

    public function test_store_employee(): void
    {
        $employee = Employee::factory()->make();

        $this->employee->storeEmployee($employee->getData());

        $this->assertDatabaseHas((new Employee)->getTable(), [
            'name' => $employee->name,
            'email' => $employee->email,
            'position' => $employee->position,
        ]);
    }

    public function test_update_employee(): void
    {
        $employee = Employee::factory()->create();

        $employee->position = 'developer';

        $this->employee->updateEmployee($employee->getData(), $employee);

        $this->assertDatabaseHas((new Employee)->getTable(), [
            'id' => $employee->id,
            'position' => 'developer',
        ]);
    }

    public function test_delete_employee(): void
    {
        $employee = Employee::factory()->create();

        $result = $this->employee->deleteEmployee($employee);

        $this->assertTrue($result);
    }
}
