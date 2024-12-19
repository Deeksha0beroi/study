<?php

namespace Tests\Feature\Repositories;

use App\Data\SubjectData;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\SubjectRepository;
use Tests\TestCase;

class SubjectRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $tenancy = true;

    private SubjectRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = app(SubjectRepository::class);
    }

    public function test_store_subject(): void
    {
        $subject = Subject::factory()->make([
            'name' => 'Math',
            'marks' => 90,
        ]);

        $subjectData = new SubjectData;
        $subjectData->name = $subject->name;
        $subjectData->marks = $subject->marks;

        $storedSubject = $this->subject->storeSubject($subjectData);

        $this->assertDatabaseHas((new Subject)->getTable(), [
            'name' => $storedSubject->name,
            'marks' => $storedSubject->marks,
        ]);
    }

    public function test_update_subject(): void
    {
        $subject = Subject::factory()->create([
            'name' => 'Math',
            'marks' => 90,
        ]);

        $subjectData = new SubjectData;
        $subjectData->name = 'Science';
        $subjectData->marks = 80;

        $updatedSubject = $this->subject->updateSubject($subjectData, $subject);

        $this->assertDatabaseHas((new Subject)->getTable(), [
            'name' => $updatedSubject->name,
            'marks' => $updatedSubject->marks,
        ]);
    }

    public function test_delete_subject(): void
    {
        $subject = Subject::factory()->create();

        $this->subject->deleteSubject($subject);

        $this->assertDatabaseMissing((new Subject)->getTable(), [
            'id' => $subject->id,
        ]);
    }

    public function test_attach_students(): void
    {
        $student = Student::factory()->create();
        $subjects = Subject::factory(3)->create();

        foreach ($subjects as $subject) {
            $this->subject->attachStudents($subject, [$student->id]);
        }

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
