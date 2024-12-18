<?php

namespace Tests\Feature\Manager;

use App\Data\StudentData;
use App\Data\SubjectData;
use App\Manager\StudentManager;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagerTest extends TestCase
{
    use RefreshDatabase;

    private StudentManager $studentManager;

    private StudentRepository $studentRepository;

    private SubjectRepository $subjectRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentRepository = new StudentRepository;

        $this->subjectRepository = new SubjectRepository;

        $this->studentManager = new StudentManager(
            $this->studentRepository,
            $this->subjectRepository
        );
    }

    public function test_save_student_with_relations()
    {
        $studentData = new StudentData;
        $studentData->name = 'John Doe';
        $studentData->email = 'johndoe@gmail.com';

        $subjectData = new SubjectData;
        $subjectData->name = 'Mathematics';
        $subject = $this->subjectRepository->storeSubject($subjectData);
        $studentData->subject_id = $subject->id;

        $student = $this->studentManager->saveStudentWithRelations($studentData);

        $this->assertEquals($studentData->name, $student->name);
        $this->assertEquals($studentData->email, $student->email);
        $this->assertEquals($studentData->subject_id, $student->subject_id);

        $this->assertDatabaseHas('students', [
            'name' => $studentData->name,
            'email' => $studentData->email,
            'subject_id' => $studentData->subject_id,
        ]);

        $this->assertDatabaseHas('subjects', [
            'id' => $studentData->subject_id,
        ]);

    }
}
