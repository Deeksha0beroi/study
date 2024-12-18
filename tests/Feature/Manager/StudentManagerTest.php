<?php

namespace Tests\Feature\Manager;

use App\Data\StudentData;
use App\Data\SubjectData;
use App\Manager\StudentManager;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Tests\TestCase;

class StudentManagerTest extends TestCase
{
    private StudentManager $studentManager;

    private StudentRepository $studentRepository;

    private SubjectRepository $subjectRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Instantiate real repositories
        $this->studentRepository = new StudentRepository;

        $this->subjectRepository = new SubjectRepository;

        $this->studentManager = new StudentManager(
            $this->studentRepository,

            $this->subjectRepository
        );
    }

    public function test_save_student_with_relations()
    {
        // Prepare test data
        $studentData = new StudentData;
        $studentData->name = 'John Doe';
        $studentData->email = 'john.doe@example.com';
        $studentData->subject_id = 1;

        $subjectData = new SubjectData;
        $subjectData->id = $studentData->subject_id;
        $subjectData->name = 'Mathematics';

        $this->subjectRepository->save($subjectData);

        $student = $this->studentManager->saveStudentWithRelations($studentData);

        $this->assertNotNull($student);
        $this->assertEquals('John Doe', $student->name);

        // Verify that the relationship has been stored in student
        $this->assertEquals(1, $student->subject->id);
    }
}
