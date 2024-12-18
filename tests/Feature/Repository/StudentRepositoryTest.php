<?php

namespace Tests\Feature\Repositories;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Tests\TestCase;

class StudentRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $tenancy = true;

    private StudentRepository $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = app(StudentRepository::class);
    }

    public function test_get_Student_by_id(): void
    {
        $student = Student::factory()->create();

        $this->assertEquals(Student::class, get_class($this->student->getStudentById($student->id)));
    }

    public function test_store_Student(): void
    {
        $student = Student::factory()->make();

        $this->student->storeStudent($student->getData());

        $this->assertDatabaseHas((new Student)->getTable(), [
            'name' => $student->name,
            'email' => $student->email,
            'subject_id' => $student->subject_id,
        ]);
    }

    public function test_update_Student(): void
    {
        $student = Student::factory()->create();

        $student->subject_id = 2;

        $this->student->updateStudent($student->getData(), $student);

        $this->assertDatabaseHas((new Student)->getTable(), [
            'id' => $student->id,
            'subject_id' => 2,
        ]);
    }

    public function test_delete_Student(): void
    {
        $student = Student::factory()->create();

        $result = $this->student->deleteStudent($student);

        $this->assertTrue($result);
    }
}
