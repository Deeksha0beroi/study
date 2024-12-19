<?php

namespace Tests\Feature\Repository;

use App\Data\StudentData;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\StudentRepository;
use Tests\TestCase;

class StudentRepositoryTest extends TestCase
{
    protected $tenancy = true;

    private StudentRepository $students;

    protected function setUp(): void
    {
        parent::setUp();

        $this->students = app(StudentRepository::class);
    }

    public function test_store_student(): void
    {
        $student = Student::factory()->make([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $studentData = new StudentData([
            'name' => $student->name,
            'email' => $student->email,
        ]);

        $storedStudent = $this->students->storeStudent($studentData);

        $this->assertDatabaseHas((new Student)->getTable(), [
            'name' => $storedStudent->name,
            'email' => $storedStudent->email,
        ]);
    }

    public function test_update_student(): void
    {
        $student = Student::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $studentData = new StudentData([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        $updatedStudent = $this->students->updateStudent($studentData, $student);

        $this->assertDatabaseHas((new Student)->getTable(), [
            'name' => $updatedStudent->name,
            'email' => $updatedStudent->email,
        ]);

        $this->assertDatabaseMissing((new Student)->getTable(), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_delete_student(): void
    {
        $student = Student::factory()->create();

        $this->students->deleteStudent($student);

        $this->assertDatabaseMissing((new Student)->getTable(), [
            'id' => $student->id,
        ]);
    }

    public function test_attach_subjects(): void
    {
        $student = Student::factory()->create();
        $subjects = Subject::factory(3)->create();

        $this->students->attachSubjects($student, $subjects->pluck('id')->toArray());

        $this->assertDatabaseHas('students_subjects', [
            'student_id' => $student->id,
            'subject_id' => $subjects->first()->id,
        ]);

        $this->assertDatabaseHas('students_subjects', [
            'student_id' => $student->id,
            'subject_id' => $subjects->last()->id,
        ]);
    }
}
